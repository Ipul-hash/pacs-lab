@extends('layouts.app')

@section('title', 'Worklist')
@section('page-title', 'Worklist')

@section('breadcrumb')
<li class="breadcrumb-item"><span class="bullet bg-gray-500 w-5px h-2px"></span></li>
<li class="breadcrumb-item text-muted">Operational Study Queue</li>
@endsection

@section('toolbar-actions')
    {{-- Auto refresh countdown --}}
    <div class="d-none d-md-flex align-items-center me-3">
        <span class="text-muted fs-8 me-2">Auto-refresh:</span>
        <span class="badge badge-light-primary fw-bold fs-8" id="refresh_countdown">60s</span>
    </div>
    {{-- Refresh button --}}
    <button class="btn btn-sm btn-icon btn-light btn-active-light-primary me-2" id="btn_manual_refresh" data-bs-toggle="tooltip" title="Refresh Worklist">
        <i class="ki-outline ki-arrows-circle fs-4"></i>
    </button>
    {{-- Date range --}}
    <div class="me-2">
        <input class="form-control form-control-sm form-control-solid w-190px"
            placeholder="Pilih tanggal..."
            id="kt_worklist_daterange" />
    </div>
    {{-- Export --}}
    <button class="btn btn-sm btn-light btn-active-light-primary fw-bold me-2"
        data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
        <i class="ki-outline ki-exit-up fs-5 me-1"></i>Export
    </button>
    <div class="menu menu-sub menu-sub-dropdown w-200px" data-kt-menu="true">
        <div class="menu-item px-3 py-2">
            <div class="menu-content text-muted pb-2 px-3 fs-7 text-uppercase fw-bold">Export Format</div>
        </div>
        <div class="separator mb-3 opacity-75"></div>
        <div class="menu-item px-3">
            <a href="#" class="menu-link px-3 py-2"><i class="ki-outline ki-file-sheet fs-5 me-3 text-success"></i>Excel (.xlsx)</a>
        </div>
        <div class="menu-item px-3">
            <a href="#" class="menu-link px-3 py-2"><i class="ki-outline ki-file fs-5 me-3 text-danger"></i>PDF Report</a>
        </div>
        <div class="menu-item px-3">
            <a href="#" class="menu-link px-3 py-2"><i class="ki-outline ki-abstract-26 fs-5 me-3 text-primary"></i>CSV</a>
        </div>
    </div>
    {{-- Add Study --}}
    <a href="#" class="btn btn-sm btn-primary fw-bold">
        <i class="ki-outline ki-plus fs-4 me-1"></i>Tambah Studi
    </a>
@endsection

@section('content')

{{-- ================================================================
     DUMMY DATA
     ================================================================ --}}
@php
$loggedInRadiolog = 'Dr. Hendra Kusuma'; // Simulasi user login

$studies = [
    // URGENT dulu, urut TAT desc
    ['id'=>1,'study_date'=>'2024-11-19','study_time'=>'06:30','patient_name'=>'Agus Setiawan','mrn'=>'MRN-2024-010','accession'=>'ACC-20241119-010','modality'=>'CT','description'=>'CT Scan Kepala Tanpa Kontras','priority'=>'urgent','status'=>'pending','assigned_to'=>null,'tat_remaining'=>'00:28','notes'=>'STAT - Suspek ICH'],
    ['id'=>2,'study_date'=>'2024-11-19','study_time'=>'07:15','patient_name'=>'Dewi Rahayu','mrn'=>'MRN-2024-011','accession'=>'ACC-20241119-011','modality'=>'CT','description'=>'CT Angiografi Paru','priority'=>'urgent','status'=>'assigned','assigned_to'=>'Dr. Hendra Kusuma','tat_remaining'=>'01:12','notes'=>'STAT - Suspek PE'],
    ['id'=>3,'study_date'=>'2024-11-19','study_time'=>'07:45','patient_name'=>'Bambang Purnomo','mrn'=>'MRN-2024-012','accession'=>'ACC-20241119-012','modality'=>'MR','description'=>'MRI Spine Cervical','priority'=>'urgent','status'=>'reporting','assigned_to'=>'Dr. Bowo Santoso','tat_remaining'=>'01:45','notes'=>'STAT - Post Trauma'],
    ['id'=>4,'study_date'=>'2024-11-19','study_time'=>'08:00','patient_name'=>'Wati Susanti','mrn'=>'MRN-2024-013','accession'=>'ACC-20241119-013','modality'=>'XR','description'=>'Foto Thorax PA','priority'=>'urgent','status'=>'pending','assigned_to'=>null,'tat_remaining'=>'02:15','notes'=>'STAT - Post Op'],
    // NORMAL - pending
    ['id'=>5,'study_date'=>'2024-11-19','study_time'=>'08:15','patient_name'=>'Budi Santoso','mrn'=>'MRN-2024-001','accession'=>'ACC-20241119-001','modality'=>'CT','description'=>'CT Scan Kepala Tanpa Kontras','priority'=>'normal','status'=>'pending','assigned_to'=>null,'tat_remaining'=>null,'notes'=>null],
    ['id'=>6,'study_date'=>'2024-11-19','study_time'=>'08:42','patient_name'=>'Sari Dewi','mrn'=>'MRN-2024-002','accession'=>'ACC-20241119-002','modality'=>'MR','description'=>'MRI Brain + Spine Cervical','priority'=>'normal','status'=>'pending','assigned_to'=>null,'tat_remaining'=>null,'notes'=>null],
    ['id'=>7,'study_date'=>'2024-11-19','study_time'=>'09:00','patient_name'=>'Ahmad Fauzi','mrn'=>'MRN-2024-003','accession'=>'ACC-20241119-003','modality'=>'XR','description'=>'Foto Thorax PA','priority'=>'normal','status'=>'assigned','assigned_to'=>'Dr. Hendra Kusuma','tat_remaining'=>null,'notes'=>null],
    ['id'=>8,'study_date'=>'2024-11-19','study_time'=>'09:15','patient_name'=>'Rina Marlina','mrn'=>'MRN-2024-004','accession'=>'ACC-20241119-004','modality'=>'US','description'=>'USG Abdomen Atas','priority'=>'normal','status'=>'assigned','assigned_to'=>'Dr. Sinta Permata','tat_remaining'=>null,'notes'=>null],
    ['id'=>9,'study_date'=>'2024-11-19','study_time'=>'09:30','patient_name'=>'Hendra Gunawan','mrn'=>'MRN-2024-005','accession'=>'ACC-20241119-005','modality'=>'CT','description'=>'CT Thorax HRCT','priority'=>'normal','status'=>'reporting','assigned_to'=>'Dr. Hendra Kusuma','tat_remaining'=>null,'notes'=>null],
    ['id'=>10,'study_date'=>'2024-11-19','study_time'=>'09:45','patient_name'=>'Fitri Handayani','mrn'=>'MRN-2024-006','accession'=>'ACC-20241119-006','modality'=>'MG','description'=>'Mammografi Bilateral','priority'=>'normal','status'=>'pending','assigned_to'=>null,'tat_remaining'=>null,'notes'=>null],
    ['id'=>11,'study_date'=>'2024-11-19','study_time'=>'10:00','patient_name'=>'Dedi Kurniawan','mrn'=>'MRN-2024-007','accession'=>'ACC-20241119-007','modality'=>'MR','description'=>'MRI Knee Joint Kanan','priority'=>'normal','status'=>'reporting','assigned_to'=>'Dr. Bowo Santoso','tat_remaining'=>null,'notes'=>null],
    ['id'=>12,'study_date'=>'2024-11-19','study_time'=>'10:15','patient_name'=>'Lisa Permata','mrn'=>'MRN-2024-020','accession'=>'ACC-20241119-020','modality'=>'CT','description'=>'CT Thorax + Abdomen','priority'=>'normal','status'=>'finalized','assigned_to'=>'Dr. Hendra Kusuma','tat_remaining'=>null,'notes'=>null],
    ['id'=>13,'study_date'=>'2024-11-19','study_time'=>'10:30','patient_name'=>'Joko Widodo','mrn'=>'MRN-2024-021','accession'=>'ACC-20241119-021','modality'=>'MR','description'=>'MRI Shoulder Kanan','priority'=>'normal','status'=>'finalized','assigned_to'=>'Dr. Sinta Permata','tat_remaining'=>null,'notes'=>null],
    ['id'=>14,'study_date'=>'2024-11-19','study_time'=>'10:45','patient_name'=>'Nani Sumarni','mrn'=>'MRN-2024-022','accession'=>'ACC-20241119-022','modality'=>'XR','description'=>'Foto Genu AP/Lateral','priority'=>'normal','status'=>'finalized','assigned_to'=>'Dr. Bowo Santoso','tat_remaining'=>null,'notes'=>null],
    ['id'=>15,'study_date'=>'2024-11-19','study_time'=>'11:00','patient_name'=>'Rudi Hermawan','mrn'=>'MRN-2024-023','accession'=>'ACC-20241119-023','modality'=>'US','description'=>'USG Renal Bilateral','priority'=>'normal','status'=>'pending','assigned_to'=>null,'tat_remaining'=>null,'notes'=>null],
];

$modality_colors = ['CT'=>'info','MR'=>'primary','XR'=>'success','US'=>'warning','MG'=>'pink','NM'=>'danger','FL'=>'dark'];
$status_cfg = [
    'pending'   => ['label'=>'Pending',   'color'=>'warning', 'icon'=>'ki-time'],
    'assigned'  => ['label'=>'Assigned',  'color'=>'info',    'icon'=>'ki-user-tick'],
    'reporting' => ['label'=>'Reporting', 'color'=>'primary', 'icon'=>'ki-document'],
    'finalized' => ['label'=>'Finalized', 'color'=>'success', 'icon'=>'ki-check-circle'],
    'archived'  => ['label'=>'Archived',  'color'=>'dark',    'icon'=>'ki-archive'],
];

// Summary counts
$total     = count($studies);
$pending   = count(array_filter($studies, fn($s) => $s['status'] === 'pending'));
$urgent    = count(array_filter($studies, fn($s) => $s['priority'] === 'urgent'));
$assigned  = count(array_filter($studies, fn($s) => $s['assigned_to'] === $loggedInRadiolog));
$reporting = count(array_filter($studies, fn($s) => $s['status'] === 'reporting'));
@endphp

{{-- ================================================================
     KPI STRIP
     ================================================================ --}}
<div class="d-flex align-items-center gap-3 mb-5 flex-wrap">
    <div class="d-flex align-items-center bg-body rounded border px-4 py-3 gap-3 min-w-100px">
        <div class="d-flex align-items-center justify-content-center w-40px h-40px rounded bg-light-primary flex-shrink-0">
            <i class="ki-outline ki-abstract-26 fs-3 text-primary"></i>
        </div>
        <div>
            <div class="fs-2 fw-bold text-gray-900 lh-1">{{ $total }}</div>
            <div class="fs-8 text-muted fw-semibold">Total Hari Ini</div>
        </div>
    </div>
    <div class="d-flex align-items-center bg-body rounded border px-4 py-3 gap-3 min-w-100px">
        <div class="d-flex align-items-center justify-content-center w-40px h-40px rounded bg-light-warning flex-shrink-0">
            <i class="ki-outline ki-time fs-3 text-warning"></i>
        </div>
        <div>
            <div class="fs-2 fw-bold text-warning lh-1">{{ $pending }}</div>
            <div class="fs-8 text-muted fw-semibold">Pending</div>
        </div>
    </div>
    <div class="d-flex align-items-center bg-body rounded border border-danger px-4 py-3 gap-3 min-w-100px">
        <div class="d-flex align-items-center justify-content-center w-40px h-40px rounded bg-light-danger flex-shrink-0">
            <i class="ki-outline ki-warning-2 fs-3 text-danger"></i>
        </div>
        <div>
            <div class="fs-2 fw-bold text-danger lh-1">{{ $urgent }}</div>
            <div class="fs-8 text-muted fw-semibold">Urgent</div>
        </div>
    </div>
    <div class="d-flex align-items-center bg-body rounded border border-dashed border-primary px-4 py-3 gap-3 min-w-100px">
        <div class="d-flex align-items-center justify-content-center w-40px h-40px rounded bg-light-primary flex-shrink-0">
            <i class="ki-outline ki-profile-circle fs-3 text-primary"></i>
        </div>
        <div>
            <div class="fs-2 fw-bold text-primary lh-1">{{ $assigned }}</div>
            <div class="fs-8 text-muted fw-semibold">My Assignments</div>
        </div>
    </div>
    <div class="d-flex align-items-center bg-body rounded border px-4 py-3 gap-3 min-w-100px">
        <div class="d-flex align-items-center justify-content-center w-40px h-40px rounded bg-light-info flex-shrink-0">
            <i class="ki-outline ki-document fs-3 text-info"></i>
        </div>
        <div>
            <div class="fs-2 fw-bold text-gray-900 lh-1">{{ $reporting }}</div>
            <div class="fs-8 text-muted fw-semibold">Sedang Dibaca</div>
        </div>
    </div>

    {{-- Last updated info --}}
    <div class="ms-auto d-flex align-items-center gap-2">
        <span class="text-muted fs-8">Terakhir diperbarui:</span>
        <span class="text-gray-700 fw-semibold fs-8" id="last_updated">{{ now()->format('H:i:s') }}</span>
        <span class="badge badge-light-success fw-bold fs-9 d-flex align-items-center gap-1">
            <span class="w-6px h-6px rounded-circle bg-success d-inline-block" style="animation: pulse-dot 1.5s infinite;"></span>
            Live
        </span>
    </div>
</div>

{{-- ================================================================
     FILTER BAR
     ================================================================ --}}
<div class="card mb-5">
    <div class="card-body py-4">
        <form id="filter_form" method="GET" action="#">
            <div class="row g-3 align-items-end">
                {{-- Date Range --}}
                <div class="col-12 col-md-6 col-xl-2">
                    <label class="form-label fw-semibold fs-7 text-gray-600 mb-1">Tanggal</label>
                    <input class="form-control form-control-sm form-control-solid"
                        placeholder="Rentang tanggal..."
                        id="filter_daterange"
                        name="date_range"
                        value="{{ request('date_range', now()->format('d/m/Y').' - '.now()->format('d/m/Y')) }}" />
                </div>
                {{-- Modality --}}
                <div class="col-6 col-md-4 col-xl-2">
                    <label class="form-label fw-semibold fs-7 text-gray-600 mb-1">Modalitas</label>
                    <select class="form-select form-select-sm form-select-solid" name="modality" id="filter_modality">
                        <option value="">Semua</option>
                        @foreach(['CT','MR','XR','US','MG','NM','FL'] as $mod)
                            <option value="{{ $mod }}" {{ request('modality') === $mod ? 'selected' : '' }}>{{ $mod }}</option>
                        @endforeach
                    </select>
                </div>
                {{-- Status --}}
                <div class="col-6 col-md-4 col-xl-2">
                    <label class="form-label fw-semibold fs-7 text-gray-600 mb-1">Status</label>
                    <select class="form-select form-select-sm form-select-solid" name="status" id="filter_status">
                        <option value="">Semua Status</option>
                        <option value="pending"   {{ request('status')==='pending'  ?'selected':'' }}>Pending</option>
                        <option value="assigned"  {{ request('status')==='assigned' ?'selected':'' }}>Assigned</option>
                        <option value="reporting" {{ request('status')==='reporting'?'selected':'' }}>Reporting</option>
                        <option value="finalized" {{ request('status')==='finalized'?'selected':'' }}>Finalized</option>
                        <option value="archived"  {{ request('status')==='archived' ?'selected':'' }}>Archived</option>
                    </select>
                </div>
                {{-- Priority --}}
                <div class="col-6 col-md-4 col-xl-1">
                    <label class="form-label fw-semibold fs-7 text-gray-600 mb-1">Prioritas</label>
                    <select class="form-select form-select-sm form-select-solid" name="priority" id="filter_priority">
                        <option value="">Semua</option>
                        <option value="urgent" {{ request('priority')==='urgent'?'selected':'' }}>🔴 Urgent</option>
                        <option value="normal" {{ request('priority')==='normal'?'selected':'' }}>Normal</option>
                    </select>
                </div>
                {{-- Assigned To --}}
                <div class="col-6 col-md-4 col-xl-2">
                    <label class="form-label fw-semibold fs-7 text-gray-600 mb-1">Radiolog</label>
                    <select class="form-select form-select-sm form-select-solid" name="assigned_to" id="filter_radiolog">
                        <option value="">Semua Radiolog</option>
                        <option value="me" {{ request('assigned_to')==='me'?'selected':'' }}>⭐ Saya</option>
                        @foreach(['Dr. Hendra Kusuma','Dr. Sinta Permata','Dr. Bowo Santoso','Dr. Ayu Lestari'] as $dr)
                            <option value="{{ $dr }}" {{ request('assigned_to')===$dr?'selected':'' }}>{{ $dr }}</option>
                        @endforeach
                    </select>
                </div>
                {{-- Search --}}
                <div class="col-12 col-md-6 col-xl-2">
                    <label class="form-label fw-semibold fs-7 text-gray-600 mb-1">Cari</label>
                    <div class="position-relative">
                        <i class="ki-outline ki-magnifier fs-5 text-gray-500 position-absolute top-50 translate-middle-y ms-3"></i>
                        <input type="text"
                            class="form-control form-control-sm form-control-solid ps-10"
                            name="search"
                            placeholder="Nama, MRN, Accession..."
                            value="{{ request('search') }}"
                            id="filter_search" />
                    </div>
                </div>
                {{-- Action buttons --}}
                <div class="col-12 col-xl-1 d-flex gap-2">
                    <button type="submit" class="btn btn-sm btn-primary w-100">
                        <i class="ki-outline ki-magnifier fs-6"></i>
                    </button>
                    <a href="#" class="btn btn-sm btn-light btn-active-light-danger w-100" data-bs-toggle="tooltip" title="Reset Filter">
                        <i class="ki-outline ki-arrows-circle fs-6"></i>
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- ================================================================
     MAIN TABLE CARD
     ================================================================ --}}
<div class="card" id="kt_worklist_card">

    {{-- ============================================================
         CARD HEADER
         ============================================================ --}}
    <div class="card-header border-0 pt-6">
        {{-- Normal toolbar --}}
        <div class="card-title" id="toolbar_base">
            <div class="d-flex align-items-center position-relative me-4">
                <i class="ki-outline ki-magnifier fs-3 position-absolute ms-3"></i>
                <input type="text"
                    id="kt_worklist_search"
                    class="form-control form-control-solid w-250px ps-10 fs-7"
                    placeholder="Cari di tabel..." />
            </div>
        </div>

        {{-- Bulk action toolbar (hidden by default) --}}
        <div class="d-flex align-items-center d-none" id="toolbar_selected">
            <div class="fw-bold me-5">
                <span class="me-2" id="selected_count">0</span>studi dipilih
            </div>
            <button class="btn btn-sm btn-light-primary fw-bold me-2" id="btn_bulk_assign">
                <i class="ki-outline ki-user-tick fs-5 me-1"></i>Assign
            </button>
            <button class="btn btn-sm btn-light-danger fw-bold me-2" id="btn_bulk_urgent">
                <i class="ki-outline ki-warning-2 fs-5 me-1"></i>Tandai Urgent
            </button>
            <button class="btn btn-sm btn-light-dark fw-bold" id="btn_bulk_archive">
                <i class="ki-outline ki-archive fs-5 me-1"></i>Arsipkan
            </button>
        </div>

        <div class="card-toolbar gap-2">
            {{-- Column visibility --}}
            <button class="btn btn-sm btn-icon btn-light btn-active-light-primary"
                data-bs-toggle="tooltip" title="Kolom">
                <i class="ki-outline ki-setting-3 fs-5"></i>
            </button>
            {{-- Density toggle --}}
            <div class="btn-group btn-group-sm">
                <button class="btn btn-light btn-active-light-primary fw-bold active fs-8" id="btn_density_comfortable">
                    <i class="ki-outline ki-row-horizontal fs-6 me-1"></i>Normal
                </button>
                <button class="btn btn-light btn-active-light-primary fw-bold fs-8" id="btn_density_compact">
                    <i class="ki-outline ki-menu fs-6 me-1"></i>Compact
                </button>
            </div>
        </div>
    </div>
    {{-- end card header --}}

    {{-- ============================================================
         CARD BODY - TABLE
         ============================================================ --}}
    <div class="card-body pt-0">
        <div class="table-responsive">
            <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4 fs-7"
                id="kt_worklist_table">
                {{-- ---- THEAD ---- --}}
                <thead>
                    <tr class="fw-bold text-muted">
                        <th class="w-30px ps-3">
                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" id="check_all" />
                            </div>
                        </th>
                        <th class="min-w-110px">Tgl / Waktu</th>
                        <th class="min-w-140px">Pasien</th>
                        <th class="min-w-120px">Accession</th>
                        <th class="w-50px text-center">Mod.</th>
                        <th class="min-w-180px">Deskripsi Studi</th>
                        <th class="w-80px text-center">Prioritas</th>
                        <th class="w-90px text-center">Status</th>
                        <th class="min-w-140px">Radiolog</th>
                        <th class="min-w-120px text-end pe-3">Aksi</th>
                    </tr>
                </thead>
                {{-- ---- TBODY ---- --}}
                <tbody>
                @foreach($studies as $study)
                @php
                    $isMyStudy     = $study['assigned_to'] === $loggedInRadiolog;
                    $isUrgent      = $study['priority']    === 'urgent';
                    $isFinalized   = $study['status']      === 'finalized';
                    $modColor      = $modality_colors[$study['modality']] ?? 'secondary';
                    $statusCfg     = $status_cfg[$study['status']];

                    // Row class
                    $rowClass = '';
                    if ($isUrgent && !$isFinalized)   $rowClass = 'table-row-urgent';
                    elseif ($isMyStudy)                $rowClass = 'table-row-mine';
                    elseif ($isFinalized)              $rowClass = 'table-row-finalized';
                @endphp
                <tr class="cursor-pointer worklist-row {{ $rowClass }}"
                    data-id="{{ $study['id'] }}"
                    data-priority="{{ $study['priority'] }}"
                    data-status="{{ $study['status'] }}"
                    data-href="#">

                    {{-- Checkbox --}}
                    <td class="ps-3" onclick="event.stopPropagation()">
                        <div class="form-check form-check-sm form-check-custom form-check-solid">
                            <input class="form-check-input row-checkbox" type="checkbox" value="{{ $study['id'] }}" />
                        </div>
                    </td>

                    {{-- Date/Time --}}
                    <td>
                        <div class="d-flex flex-column">
                            <span class="fw-bold text-gray-700">{{ \Carbon\Carbon::parse($study['study_date'])->format('d M Y') }}</span>
                            <span class="text-muted">{{ $study['study_time'] }}</span>
                        </div>
                    </td>

                    {{-- Patient --}}
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            {{-- Avatar circle --}}
                            <div class="symbol symbol-35px flex-shrink-0">
                                <div class="symbol-label fw-bold fs-8
                                    {{ $isUrgent ? 'bg-light-danger text-danger' : 'bg-light-primary text-primary' }}">
                                    {{ strtoupper(substr($study['patient_name'], 0, 2)) }}
                                </div>
                            </div>
                            <div class="d-flex flex-column">
                                <a href="#"
                                    class="text-gray-800 text-hover-primary fw-bold"
                                    onclick="event.stopPropagation()">
                                    {{ $study['patient_name'] }}
                                </a>
                                <span class="text-muted fs-8">{{ $study['mrn'] }}</span>
                            </div>
                        </div>
                    </td>

                    {{-- Accession --}}
                    <td>
                        <span class="text-gray-600 fw-semibold font-monospace fs-8">{{ $study['accession'] }}</span>
                    </td>

                    {{-- Modality --}}
                    <td class="text-center">
                        <span class="badge badge-light-{{ $modColor }} fw-bold px-3 py-2">{{ $study['modality'] }}</span>
                    </td>

                    {{-- Description --}}
                    <td>
                        <div class="d-flex flex-column">
                            <span class="text-gray-700 fw-semibold">{{ $study['description'] }}</span>
                            @if($study['notes'])
                                <span class="text-danger fs-8 fw-semibold">
                                    <i class="ki-outline ki-warning-2 fs-9 me-1"></i>{{ $study['notes'] }}
                                </span>
                            @endif
                        </div>
                    </td>

                    {{-- Priority --}}
                    <td class="text-center">
                        @if($isUrgent)
                            <span class="badge badge-danger fw-bold px-3 py-2">
                                <i class="ki-outline ki-warning-2 fs-8 me-1 text-white"></i>URGENT
                            </span>
                            @if($study['tat_remaining'])
                                <div class="text-danger fw-bold fs-9 mt-1">
                                    <i class="ki-outline ki-time fs-9"></i> {{ $study['tat_remaining'] }}
                                </div>
                            @endif
                        @else
                            <span class="badge badge-light-secondary fw-bold px-3">Normal</span>
                        @endif
                    </td>

                    {{-- Status --}}
                    <td class="text-center">
                        <span class="badge badge-light-{{ $statusCfg['color'] }} fw-bold px-3 py-2">
                            <i class="ki-outline {{ $statusCfg['icon'] }} fs-8 me-1"></i>
                            {{ $statusCfg['label'] }}
                        </span>
                    </td>

                    {{-- Assigned Radiolog --}}
                    <td>
                        @if($study['assigned_to'])
                            <div class="d-flex align-items-center gap-2">
                                <div class="symbol symbol-30px">
                                    <div class="symbol-label fs-8 fw-bold {{ $isMyStudy ? 'bg-primary text-white' : 'bg-light-secondary text-gray-600' }}">
                                        {{ strtoupper(substr(explode(' ', $study['assigned_to'])[1] ?? 'X', 0, 2)) }}
                                    </div>
                                </div>
                                <div class="d-flex flex-column">
                                    <span class="fw-semibold text-gray-700 fs-8
                                        {{ $isMyStudy ? 'text-primary' : '' }}">
                                        {{ $study['assigned_to'] }}
                                    </span>
                                    @if($isMyStudy)
                                        <span class="text-primary fs-9 fw-bold">⭐ Anda</span>
                                    @endif
                                </div>
                            </div>
                        @else
                            <span class="text-muted fs-8">— Belum di-assign</span>
                        @endif
                    </td>

                    {{-- Context-aware Action Buttons --}}
                    <td class="text-end pe-3" onclick="event.stopPropagation()">
                        @if($study['status'] === 'pending')
                            <button class="btn btn-sm btn-light-primary fw-bold me-1"
                                onclick="openAssignModal({{ $study['id'] }}, '{{ $study['patient_name'] }}')"
                                data-bs-toggle="tooltip" title="Assign ke Radiolog">
                                <i class="ki-outline ki-user-tick fs-6"></i> Assign
                            </button>
                            <a href="#"
                                class="btn btn-sm btn-icon btn-light btn-active-light-primary"
                                data-bs-toggle="tooltip" title="Buka Viewer">
                                <i class="ki-outline ki-eye fs-5"></i>
                            </a>

                        @elseif($study['status'] === 'assigned' && $isMyStudy)
                            <a href="#"
                                class="btn btn-sm btn-primary fw-bold me-1">
                                <i class="ki-outline ki-document fs-6 me-1"></i>Start Report
                            </a>
                            <a href="#"
                                class="btn btn-sm btn-icon btn-light btn-active-light-primary"
                                data-bs-toggle="tooltip" title="Buka Viewer">
                                <i class="ki-outline ki-eye fs-5"></i>
                            </a>

                        @elseif($study['status'] === 'assigned' && !$isMyStudy)
                            <a href="#"
                                class="btn btn-sm btn-icon btn-light btn-active-light-primary"
                                data-bs-toggle="tooltip" title="Buka Viewer">
                                <i class="ki-outline ki-eye fs-5"></i>
                            </a>

                        @elseif($study['status'] === 'reporting' && $isMyStudy)
                            <a href="#"
                                class="btn btn-sm btn-info fw-bold me-1">
                                <i class="ki-outline ki-notepad-edit fs-6 me-1"></i>Lanjut
                            </a>

                        @elseif($study['status'] === 'reporting' && !$isMyStudy)
                            <a href="#"
                                class="btn btn-sm btn-icon btn-light btn-active-light-primary"
                                data-bs-toggle="tooltip" title="Lihat">
                                <i class="ki-outline ki-eye fs-5"></i>
                            </a>

                        @elseif($study['status'] === 'finalized')
                            <a href="#"
                                class="btn btn-sm btn-light-success fw-bold me-1"
                                data-bs-toggle="tooltip" title="Lihat Laporan">
                                <i class="ki-outline ki-file-sheet fs-6 me-1"></i>View
                            </a>
                        @endif

                        {{-- 3-dot menu --}}
                        <button class="btn btn-sm btn-icon btn-light btn-active-light-primary"
                            data-kt-menu-trigger="click"
                            data-kt-menu-placement="bottom-end">
                            <i class="ki-outline ki-dots-vertical fs-5"></i>
                        </button>
                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-175px py-4" data-kt-menu="true">
                            <div class="menu-item px-3">
                                <a href="#" class="menu-link px-3">
                                    <i class="ki-outline ki-eye fs-5 me-3 text-primary"></i>Buka Viewer
                                </a>
                            </div>
                            @if($study['status'] !== 'finalized')
                            <div class="menu-item px-3">
                                <a href="#" class="menu-link px-3"
                                    onclick="openAssignModal({{ $study['id'] }}, '{{ $study['patient_name'] }}'); return false;">
                                    <i class="ki-outline ki-user-tick fs-5 me-3 text-info"></i>Assign
                                </a>
                            </div>
                            @if($study['priority'] === 'normal')
                            <div class="menu-item px-3">
                                <a href="#" class="menu-link px-3" onclick="markUrgent({{ $study['id'] }}); return false;">
                                    <i class="ki-outline ki-warning-2 fs-5 me-3 text-danger"></i>Tandai Urgent
                                </a>
                            </div>
                            @endif
                            @endif
                            <div class="separator my-2"></div>
                            <div class="menu-item px-3">
                                <a href="#" class="menu-link px-3 text-danger" onclick="archiveStudy({{ $study['id'] }}); return false;">
                                    <i class="ki-outline ki-archive fs-5 me-3 text-danger"></i>Arsipkan
                                </a>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 pt-4 border-top">
            <div class="fs-8 text-muted fw-semibold">
                Menampilkan 1 - {{ count($studies) }} dari {{ count($studies) }} studi
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-sm btn-icon btn-light btn-active-light-primary" disabled>
                    <i class="ki-outline ki-double-left fs-5"></i>
                </button>
                <button class="btn btn-sm btn-light-primary fw-bold px-4">1</button>
                <button class="btn btn-sm btn-icon btn-light btn-active-light-primary" disabled>
                    <i class="ki-outline ki-double-right fs-5"></i>
                </button>
            </div>
            <div class="d-flex align-items-center gap-2 fs-8 text-muted">
                Baris per halaman:
                <select class="form-select form-select-sm form-select-solid w-70px">
                    <option>15</option>
                    <option>25</option>
                    <option>50</option>
                    <option>100</option>
                </select>
            </div>
        </div>

    </div>
</div>
{{-- end main card --}}

{{-- ================================================================
     ASSIGN MODAL
     ================================================================ --}}
<div class="modal fade" id="modal_assign" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-500px">
        <div class="modal-content">
            <div class="modal-header pb-0 border-0">
                <h3 class="fw-bold fs-4">Assign Radiolog</h3>
                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <i class="ki-outline ki-cross fs-1"></i>
                </div>
            </div>
            <div class="modal-body py-5 px-7">
                <div class="notice d-flex bg-light-warning rounded border-warning border border-dashed mb-6 p-4">
                    <i class="ki-outline ki-information fs-2tx text-warning me-4"></i>
                    <div>
                        <h5 class="mb-1 fw-semibold">Studi yang dipilih:</h5>
                        <p class="mb-0 fs-7 text-muted" id="modal_patient_name">—</p>
                    </div>
                </div>
                <div class="mb-5">
                    <label class="form-label fw-semibold required">Pilih Radiolog</label>
                    <select class="form-select form-select-solid" id="modal_radiolog_select">
                        <option value="">— Pilih radiolog —</option>
                        <option value="Dr. Hendra Kusuma">Dr. Hendra Kusuma (Tersedia)</option>
                        <option value="Dr. Sinta Permata">Dr. Sinta Permata (Tersedia)</option>
                        <option value="Dr. Bowo Santoso">Dr. Bowo Santoso (2 studi aktif)</option>
                        <option value="Dr. Ayu Lestari">Dr. Ayu Lestari (Tersedia)</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Catatan (opsional)</label>
                    <textarea class="form-control form-control-solid" rows="2" placeholder="Tambahkan catatan untuk radiolog..."></textarea>
                </div>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <button class="btn btn-primary" id="btn_confirm_assign">
                    <i class="ki-outline ki-user-tick fs-5 me-2"></i>Assign Sekarang
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

{{-- ================================================================
     STYLES
     ================================================================ --}}
@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<style>
/* ── Row variants ───────────────────────────────────────────── */
.table-row-urgent td { background-color: rgba(var(--bs-danger-rgb), 0.04) !important; }
.table-row-urgent:hover td { background-color: rgba(var(--bs-danger-rgb), 0.09) !important; }
.table-row-urgent td:first-child { border-left: 3px solid var(--bs-danger) !important; }

.table-row-mine td { background-color: rgba(var(--bs-primary-rgb), 0.03) !important; }
.table-row-mine:hover td { background-color: rgba(var(--bs-primary-rgb), 0.07) !important; }
.table-row-mine td:first-child { border-left: 3px solid var(--bs-primary) !important; }

.table-row-finalized td { opacity: 0.65; }
.table-row-finalized:hover td { opacity: 0.85 !important; }

.worklist-row:hover td { cursor: pointer; }

/* ── Compact density ────────────────────────────────────────── */
.density-compact .table.gy-4 > :not(caption) > * > * { padding-top: 6px !important; padding-bottom: 6px !important; }
.density-compact .symbol-35px { width: 28px !important; height: 28px !important; }
.density-compact .symbol-35px .symbol-label { width: 28px !important; height: 28px !important; font-size: 0.7rem !important; }

/* ── Live pulse dot ─────────────────────────────────────────── */
@keyframes pulse-dot {
    0%, 100% { opacity: 1; transform: scale(1); }
    50%       { opacity: 0.4; transform: scale(0.8); }
}

/* ── KPI strip ──────────────────────────────────────────────── */
.min-w-100px { min-width: 100px; }

/* ── Monospace accession ────────────────────────────────────── */
.font-monospace { font-family: 'SFMono-Regular', Menlo, Monaco, Consolas, monospace; }
</style>
@endpush

{{-- ================================================================
     SCRIPTS
     ================================================================ --}}
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/moment/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script>
"use strict";

// ────────────────────────────────────────────────────────────────
// DATE RANGE PICKERS
// ────────────────────────────────────────────────────────────────
var drpOptions = {
    locale: {
        format: 'DD/MM/YYYY',
        applyLabel: 'Terapkan',
        cancelLabel: 'Batal',
        fromLabel: 'Dari',
        toLabel: 'Sampai',
        customRangeLabel: 'Kustom',
        daysOfWeek: ['Min','Sen','Sel','Rab','Kam','Jum','Sab'],
        monthNames: ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'],
    },
    ranges: {
        'Hari Ini'   : [moment(), moment()],
        '7 Hari'     : [moment().subtract(6, 'days'), moment()],
        '30 Hari'    : [moment().subtract(29, 'days'), moment()],
        'Bulan Ini'  : [moment().startOf('month'), moment().endOf('month')],
        'Bulan Lalu' : [moment().subtract(1,'month').startOf('month'), moment().subtract(1,'month').endOf('month')],
    },
    startDate: moment(),
    endDate:   moment(),
};

$('#filter_daterange, #kt_worklist_daterange').daterangepicker(drpOptions);

// ────────────────────────────────────────────────────────────────
// DATATABLE
// ────────────────────────────────────────────────────────────────
var dt;
$(document).ready(function() {
    dt = $('#kt_worklist_table').DataTable({
        pageLength: 15,
        order: [[6, 'desc'], [1, 'asc']], // priority desc, date asc
        dom: 't<"row mt-3 d-none"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
        columnDefs: [
            { orderable: false, targets: [0, 9] },
            { searchable: false, targets: [0, 4, 6, 7, 9] },
        ],
        language: {
            emptyTable: '<div class="text-center py-10"><i class="ki-outline ki-search-list fs-2x text-gray-400 mb-3 d-block"></i><span class="text-muted fw-semibold">Tidak ada studi yang ditemukan</span></div>',
        },
        drawCallback: function() {
            // Re-init tooltips after redraw
            initTooltips();
            KTMenu.createInstances();
        }
    });

    // Inline search (tabel lokal)
    $('#kt_worklist_search').on('keyup', function() {
        dt.search(this.value).draw();
    });

    // Filter form realtime changes
    ['#filter_modality','#filter_status','#filter_priority','#filter_radiolog'].forEach(function(sel) {
        $(sel).on('change', function() { autoSubmitFilter(); });
    });

    let searchTimer;
    $('#filter_search').on('keyup', function() {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(autoSubmitFilter, 500);
    });
});

function autoSubmitFilter() {
    // In production: AJAX. For now: form submit
    document.getElementById('filter_form').submit();
}

// ────────────────────────────────────────────────────────────────
// ROW CLICK → NAVIGATE
// ────────────────────────────────────────────────────────────────
$(document).on('click', '.worklist-row', function(e) {
    if ($(e.target).is('input, button, a, select') || $(e.target).closest('button, a, .menu').length) return;
    var href = $(this).data('href');
    if (href) window.location.href = href;
});

// ────────────────────────────────────────────────────────────────
// CHECKBOX & BULK ACTION
// ────────────────────────────────────────────────────────────────
var selectedIds = new Set();

$('#check_all').on('change', function() {
    var checked = this.checked;
    $('.row-checkbox').prop('checked', checked);
    if (checked) {
        $('.row-checkbox').each(function() { selectedIds.add(this.value); });
    } else {
        selectedIds.clear();
    }
    updateBulkToolbar();
});

$(document).on('change', '.row-checkbox', function() {
    if (this.checked) selectedIds.add(this.value);
    else              selectedIds.delete(this.value);
    updateBulkToolbar();
    // Update check_all state
    var total = $('.row-checkbox').length;
    var checked = $('.row-checkbox:checked').length;
    $('#check_all').prop('indeterminate', checked > 0 && checked < total);
    $('#check_all').prop('checked', checked === total);
});

function updateBulkToolbar() {
    var count = selectedIds.size;
    if (count > 0) {
        $('#toolbar_base').addClass('d-none');
        $('#toolbar_selected').removeClass('d-none');
        $('#selected_count').text(count);
    } else {
        $('#toolbar_base').removeClass('d-none');
        $('#toolbar_selected').addClass('d-none');
    }
}

$('#btn_bulk_assign').on('click', function() {
    openAssignModal([...selectedIds].join(','), selectedIds.size + ' studi terpilih');
});

$('#btn_bulk_urgent').on('click', function() {
    if (!confirm('Tandai ' + selectedIds.size + ' studi sebagai URGENT?')) return;
    showToast('warning', selectedIds.size + ' studi ditandai sebagai URGENT.');
    selectedIds.clear();
    updateBulkToolbar();
});

$('#btn_bulk_archive').on('click', function() {
    if (!confirm('Arsipkan ' + selectedIds.size + ' studi yang dipilih?')) return;
    showToast('dark', selectedIds.size + ' studi berhasil diarsipkan.');
    selectedIds.clear();
    updateBulkToolbar();
});

// ────────────────────────────────────────────────────────────────
// DENSITY TOGGLE
// ────────────────────────────────────────────────────────────────
$('#btn_density_compact').on('click', function() {
    $('#kt_worklist_card .card-body').addClass('density-compact');
    $(this).addClass('active').siblings().removeClass('active');
});
$('#btn_density_comfortable').on('click', function() {
    $('#kt_worklist_card .card-body').removeClass('density-compact');
    $(this).addClass('active').siblings().removeClass('active');
});

// ────────────────────────────────────────────────────────────────
// ASSIGN MODAL
// ────────────────────────────────────────────────────────────────
var currentStudyId = null;

function openAssignModal(studyId, patientName) {
    currentStudyId = studyId;
    $('#modal_patient_name').text(patientName);
    $('#modal_radiolog_select').val('');
    var modal = new bootstrap.Modal(document.getElementById('modal_assign'));
    modal.show();
}

$('#btn_confirm_assign').on('click', function() {
    var radiolog = $('#modal_radiolog_select').val();
    if (!radiolog) {
        $('#modal_radiolog_select').addClass('is-invalid');
        return;
    }
    $('#modal_radiolog_select').removeClass('is-invalid');
    // Production: POST /studies/{id}/assign
    bootstrap.Modal.getInstance(document.getElementById('modal_assign')).hide();
    showToast('primary', 'Studi berhasil di-assign ke ' + radiolog);
});

// ────────────────────────────────────────────────────────────────
// MARK URGENT
// ────────────────────────────────────────────────────────────────
function markUrgent(studyId) {
    if (!confirm('Tandai studi ini sebagai URGENT?')) return;
    // Production: POST /studies/{id}/mark-urgent
    showToast('danger', 'Studi berhasil ditandai sebagai URGENT.');
}

// ────────────────────────────────────────────────────────────────
// ARCHIVE
// ────────────────────────────────────────────────────────────────
function archiveStudy(studyId) {
    if (!confirm('Arsipkan studi ini? Studi yang diarsipkan tidak akan muncul di worklist aktif.')) return;
    showToast('dark', 'Studi berhasil diarsipkan.');
}

// ────────────────────────────────────────────────────────────────
// AUTO REFRESH (60 detik)
// ────────────────────────────────────────────────────────────────
var countdownVal = 60;
var countdownTimer = setInterval(function() {
    countdownVal--;
    $('#refresh_countdown').text(countdownVal + 's');
    if (countdownVal <= 10) {
        $('#refresh_countdown').removeClass('badge-light-primary').addClass('badge-light-danger');
    }
    if (countdownVal <= 0) {
        doRefresh();
    }
}, 1000);

function doRefresh() {
    countdownVal = 60;
    $('#refresh_countdown').removeClass('badge-light-danger').addClass('badge-light-primary').text('60s');
    $('#last_updated').text(new Date().toLocaleTimeString('id-ID'));
    // Production: AJAX reload table data
    var icon = document.querySelector('#btn_manual_refresh i');
    icon.style.animation = 'spin 1s linear';
    setTimeout(() => { icon.style.animation = ''; }, 1000);
}

$('#btn_manual_refresh').on('click', function() {
    countdownVal = 61;
    doRefresh();
});

// ────────────────────────────────────────────────────────────────
// TOAST HELPER
// ────────────────────────────────────────────────────────────────
function showToast(type, message) {
    var colorMap = {
        'primary': '#1B84FF', 'danger': '#F8285A', 'warning': '#F6C000',
        'success': '#17C653', 'dark': '#1C2434', 'info': '#7239EA'
    };
    var toast = document.createElement('div');
    toast.style.cssText = [
        'position:fixed','bottom:24px','right:24px','z-index:9999',
        'background:'+(colorMap[type]||'#333'),'color:#fff',
        'padding:14px 20px','border-radius:8px','font-size:14px',
        'font-weight:600','box-shadow:0 4px 24px rgba(0,0,0,.18)',
        'display:flex','align-items:center','gap:10px',
        'max-width:360px','animation:slideUp .3s ease'
    ].join(';');
    toast.innerHTML = '<i class="ki-outline ki-check-circle" style="font-size:18px"></i>' + message;
    var style = document.createElement('style');
    style.textContent = '@keyframes slideUp{from{transform:translateY(20px);opacity:0}to{transform:translateY(0);opacity:1}}';
    document.head.appendChild(style);
    document.body.appendChild(toast);
    setTimeout(() => { toast.style.opacity = '0'; toast.style.transition = 'opacity .3s'; setTimeout(() => toast.remove(), 300); }, 3000);
}

// ────────────────────────────────────────────────────────────────
// TOOLTIPS
// ────────────────────────────────────────────────────────────────
function initTooltips() {
    [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]')).forEach(function(el) {
        new bootstrap.Tooltip(el, { trigger: 'hover' });
    });
}

$(document).ready(function() { initTooltips(); });
</script>
@endpush