<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\WorklistService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WorklistController extends Controller
{
    protected WorklistService $service;

    public function __construct(WorklistService $service)
    {
        $this->service = $service;
    }

    /**
     * GET /api/order/health
     * Health check middleware & koneksi ke Orthanc
     */
    public function health(): JsonResponse
    {
        $info = $this->service->health();

        return response()->json([
            'status' => 'ok',
            'info'   => $info,
        ]);
    }

    /**
     * GET /api/order
     * List semua worklist order
     */
    public function index(): JsonResponse
    {
        $orders = $this->service->listOrders();

        return response()->json([
            'status' => 'success',
            'total'  => count($orders),
            'orders' => $orders,
        ]);
    }

    /**
     * POST /api/order
     * Buat worklist order baru
     *
     * Body JSON:
     * {
     *   "PatientName"                  : "Budi Santoso",
     *   "PatientID"                    : "PAT-001",
     *   "PatientBirthDate"             : "19900101",
     *   "PatientSex"                   : "M",
     *   "AccessionNumber"              : "ACC-001",
     *   "Modality"                     : "CT",
     *   "ScheduledDate"                : "20240221",
     *   "ScheduledTime"                : "090000",
     *   "ScheduledAET"                 : "CT_SCANNER",
     *   "ScheduledPhysician"           : "Dr^Radiolog",
     *   "RequestedProcedureDescription": "CT Scan Thorax"
     * }
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'PatientName'                   => 'required|string',
            'PatientID'                     => 'required|string',
            'PatientBirthDate'              => 'required|string',
            'PatientSex'                    => 'required|in:M,F',
            'AccessionNumber'               => 'required|string',
            'Modality'                      => 'required|string',
            'ScheduledDate'                 => 'required|string',
            'ScheduledTime'                 => 'nullable|string',
            'ScheduledAET'                  => 'nullable|string',
            'ScheduledPhysician'            => 'nullable|string',
            'RequestedProcedureDescription' => 'required|string',
        ]);

        // Set default value kalau kosong
        $validated['ScheduledTime']      = $validated['ScheduledTime']      ?? '000000';
        $validated['ScheduledAET']       = $validated['ScheduledAET']       ?? 'ANY';
        $validated['ScheduledPhysician'] = $validated['ScheduledPhysician'] ?? '';

        try {
            $filePath = $this->service->createOrder($validated);
        } catch (\Exception $e) {
            $statusCode = str_contains($e->getMessage(), 'sudah ada') ? 409 : 500;
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage(),
            ], $statusCode);
        }

        return response()->json([
            'status'          => 'success',
            'message'         => 'Order worklist berhasil dibuat',
            'AccessionNumber' => $validated['AccessionNumber'],
            'file'            => $filePath,
        ], 201);
    }

    /**
     * DELETE /api/order/{accessionNumber}
     * Hapus worklist order
     */
    public function destroy(string $accessionNumber): JsonResponse
    {
        try {
            $this->service->deleteOrder($accessionNumber);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage(),
            ], 404);
        }

        return response()->json([
            'status'  => 'success',
            'message' => "Order '{$accessionNumber}' berhasil dihapus",
        ]);
    }
}