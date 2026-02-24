<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class WorklistService
{
    protected string $worklistDir;
    protected string $tmpDir;
    protected string $orthancHost;
    protected int    $orthancPort;
    protected string $orthancUrl;

    public function __construct()
    {
        $this->tmpDir = storage_path('app/tmp');
        if (!is_dir($this->tmpDir)) {
            @mkdir($this->tmpDir, 0755, true);
        }

        $this->worklistDir = env('WORKLIST_DIR', storage_path('app/worklists'));
        if (!is_dir($this->worklistDir) && !is_writable(dirname($this->worklistDir))) {
            $this->worklistDir = storage_path('app/worklists');
            @mkdir($this->worklistDir, 0755, true);
        }

        $this->orthancHost = env('ORTHANC_HOST', '10.164.96.189');
        $this->orthancPort = env('ORTHANC_PORT', 3001);
        $this->orthancUrl  = env('ORTHANC_URL', "http://{$this->orthancHost}:{$this->orthancPort}");
    }

    /**
     * Create order & generate .wl file
     */
    public function createOrder(array $data): string
    {
        $acc      = $data['AccessionNumber'];
        $dumpPath = $this->tmpDir . "/{$acc}.dump";
        $wlPath   = "{$this->worklistDir}/{$acc}.wl";

        // Validasi
        if (!is_writable($this->tmpDir)) {
            throw new Exception("Temp directory tidak writable: {$this->tmpDir}");
        }

        if (!is_dir($this->worklistDir)) {
            @mkdir($this->worklistDir, 0755, true);
        }

        if (!is_writable($this->worklistDir)) {
            throw new Exception("Worklist directory tidak writable: {$this->worklistDir}");
        }

        if (file_exists($wlPath)) {
            throw new Exception("AccessionNumber '{$acc}' sudah ada.");
        }

        try {
            $dump = $this->buildDump($data);
            
            $bytesWritten = @file_put_contents($dumpPath, $dump, LOCK_EX);
            if ($bytesWritten === false) {
                throw new Exception("Gagal menulis dump file");
            }

            // Convert dump → .wl (jika dcmtk available)
            if ($this->hasDcmtk()) {
                $output = [];
                $returnCode = 0;
                $cmd = "dump2dcm {$dumpPath} {$wlPath} 2>&1";
                exec($cmd, $output, $returnCode);

                if ($returnCode !== 0) {
                    Log::error('dump2dcm failed', ['output' => $output]);
                    throw new Exception("dump2dcm error (code {$returnCode})");
                }
            } else {
                // Fallback: simpan dump sebagai .wl (text format)
                if (!@copy($dumpPath, $wlPath)) {
                    throw new Exception("Gagal copy dump ke .wl");
                }
            }

            @unlink($dumpPath);

            Log::info('Order created', [
                'accession' => $acc,
                'wl_path' => $wlPath,
                'size' => filesize($wlPath),
            ]);

            return $wlPath;

        } catch (Exception $e) {
            @unlink($dumpPath);
            throw $e;
        }
    }

    /**
     * List orders
     */
    public function listOrders(): array
    {
        if (!is_dir($this->worklistDir)) {
            return [];
        }

        $files = glob("{$this->worklistDir}/*.wl") ?: [];
        $orders = [];

        foreach ($files as $file) {
            $acc = pathinfo($file, PATHINFO_FILENAME);
            $orders[] = [
                'AccessionNumber' => $acc,
                'file'            => $file,
                'size_bytes'      => filesize($file),
                'created_at'      => date('Y-m-d H:i:s', filectime($file)),
            ];
        }

        return $orders;
    }

    /**
     * Delete order
     */
    public function deleteOrder(string $acc): void
    {
        $wlPath = "{$this->worklistDir}/{$acc}.wl";

        if (!file_exists($wlPath)) {
            throw new Exception("Order '{$acc}' tidak ditemukan.");
        }

        if (!@unlink($wlPath)) {
            throw new Exception("Gagal menghapus order");
        }

        Log::info('Order deleted', ['accession' => $acc]);
    }

    /**
     * Health check - comprehensive
     */
    public function health(): array
    {
        $health = [
            'status' => 'ok',
            'timestamp' => now()->toIso8601String(),
            'storage' => $this->checkStorage(),
            'dcmtk' => $this->checkDcmtk(),
            'orthanc' => $this->checkOrthanc(),
            'total_orders' => count($this->listOrders()),
        ];

        return $health;
    }

    /**
     * Check storage permissions & directories
     */
    protected function checkStorage(): array
    {
        return [
            'temp_dir' => [
                'path' => $this->tmpDir,
                'exists' => is_dir($this->tmpDir),
                'writable' => is_writable($this->tmpDir),
            ],
            'worklist_dir' => [
                'path' => $this->worklistDir,
                'exists' => is_dir($this->worklistDir),
                'writable' => is_writable($this->worklistDir),
            ],
        ];
    }

    /**
     * Check dcmtk availability
     */
    protected function checkDcmtk(): array
    {
        $available = $this->hasDcmtk();
        
        if ($available) {
            $output = [];
            exec("dump2dcm --version 2>&1", $output);
            $version = implode(' ', $output);
        } else {
            $version = 'Not installed';
        }

        return [
            'available' => $available,
            'command' => 'dump2dcm',
            'version' => $version,
            'status' => $available ? '✓ Ready (binary format)' : 'Fallback to text format',
        ];
    }

    /**
     * Check Orthanc connectivity
     */
    protected function checkOrthanc(): array
    {
        $reachable = false;
        $version = null;
        $error = null;

        try {
            // Test basic connectivity
            $response = Http::timeout(5)->get("{$this->orthancUrl}/api/system");
            
            if ($response->successful()) {
                $data = $response->json();
                $reachable = true;
                $version = $data['DicomServerName'] ?? 'Unknown';
            } else {
                $error = "HTTP {$response->status()}";
            }
        } catch (\Exception $e) {
            $error = $e->getMessage();
        }

        return [
            'host' => $this->orthancHost,
            'port' => $this->orthancPort,
            'url' => $this->orthancUrl,
            'reachable' => $reachable,
            'version' => $version,
            'error' => $error,
            'status' => $reachable ? '✓ Connected' : "✗ {$error}",
        ];
    }

    /**
     * Test Orthanc MWL capability
     */
    public function testOrthancMWL(): array
    {
        try {
            $response = Http::timeout(5)->get("{$this->orthancUrl}/api/plugins");
            
            if ($response->successful()) {
                $plugins = $response->json() ?? [];
                $hasMwl = in_array('dicom-web', $plugins) || in_array('mwl', $plugins);
                
                return [
                    'mwl_capable' => $hasMwl,
                    'plugins' => $plugins,
                    'status' => $hasMwl ? '✓ MWL capable' : '⚠️ MWL plugin not found',
                ];
            }
        } catch (\Exception $e) {
            return [
                'mwl_capable' => false,
                'error' => $e->getMessage(),
                'status' => '✗ Cannot verify',
            ];
        }

        return [
            'mwl_capable' => false,
            'status' => '✗ Cannot reach Orthanc',
        ];
    }

    /**
     * Check dcmtk
     */
    protected function hasDcmtk(): bool
    {
        $output = [];
        $code = 0;
        exec("which dump2dcm 2>&1", $output, $code);
        return $code === 0;
    }

    /**
     * Build DICOM dump content
     */
    private function buildDump(array $data): string
    {
        $acc = $data['AccessionNumber'];

        return <<<DUMP
# DICOM Worklist - Generated by Laravel
(0008,0005) CS [ISO_IR 6]
(0008,0050) SH [{$acc}]
(0010,0010) PN [{$data['PatientName']}]
(0010,0020) LO [{$data['PatientID']}]
(0010,0030) DA [{$data['PatientBirthDate']}]
(0010,0040) CS [{$data['PatientSex']}]
(0020,000d) UI [1.2.840.10008.5.1.4.1.2.1.{$acc}]
(0032,1060) LO [{$data['RequestedProcedureDescription']}]
(0040,1001) SH [RP-{$acc}]
(0040,0100) SQ
(fffe,e000) na
(0008,0060) CS [{$data['Modality']}]
(0040,0001) AE [{$data['ScheduledAET']}]
(0040,0002) DA [{$data['ScheduledDate']}]
(0040,0003) TM [{$data['ScheduledTime']}]
(0040,0006) PN [{$data['ScheduledPhysician']}]
(0040,0007) LO [{$data['RequestedProcedureDescription']}]
(0040,0009) SH [SPS-{$acc}]
(fffe,e00d)
(fffe,e0dd)
DUMP;
    }
}