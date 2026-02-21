@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <span class="bullet bg-gray-500 w-5px h-2px"></span>
    </li>
    <li class="breadcrumb-item text-muted">Worklist</li>
@endsection

@section('toolbar-actions')
    <!--begin::Date range-->
    <div class="me-2">
        <input class="form-control form-control-sm form-control-solid w-170px" placeholder="Pilih tanggal..." id="kt_daterangepicker_1" />
    </div>
    <!--end::Date range-->

    <!--begin::Refresh-->
    <button class="btn btn-sm btn-icon btn-light btn-active-light-primary me-2" id="btn_refresh" data-bs-toggle="tooltip" title="Refresh Worklist">
        <i class="ki-outline ki-arrows-circle fs-4"></i>
    </button>
    <!--end::Refresh-->

    <!--begin::New study-->
    <a href="#" class="btn btn-sm fw-bold btn-primary">
        <i class="ki-outline ki-plus fs-4 me-1"></i> Tambah Studi
    </a>
    <!--end::New study-->
@endsection

@section('content')


<div class="row g-5 g-xl-8 mb-5">
    <!--begin::Card Pending-->
    <div class="col-sm-6 col-xl-3">
        <div class="card card-flush h-xl-100">
            <div class="card-header pt-5">
                <div class="card-title d-flex flex-column">
                    <span class="fs-2hx fw-bold text-gray-900 me-2 lh-1 ls-n2">47</span>
                    <span class="text-gray-500 pt-1 fw-semibold fs-6">Studi Pending</span>
                </div>
            </div>
            <div class="card-body d-flex align-items-end pt-0">
                <div class="d-flex align-items-center flex-column mt-3 w-100">
                    <div class="d-flex justify-content-between fw-bold fs-6 text-gray-500 w-100 mt-auto mb-2">
                        <span>Hari ini</span>
                        <span class="text-warning">68%</span>
                    </div>
                    <div class="h-8px w-100 bg-light-warning rounded">
                        <div class="bg-warning rounded h-8px" style="width: 68%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end::Card Pending-->

    <!--begin::Card Urgent-->
    <div class="col-sm-6 col-xl-3">
        <div class="card card-flush h-xl-100 border border-danger border-dashed">
            <div class="card-header pt-5">
                <div class="card-title d-flex flex-column">
                    <span class="fs-2hx fw-bold text-danger me-2 lh-1 ls-n2">12</span>
                    <span class="text-gray-500 pt-1 fw-semibold fs-6">
                        <i class="ki-outline ki-warning-2 fs-7 text-danger me-1"></i>Studi Urgent
                    </span>
                </div>
            </div>
            <div class="card-body d-flex align-items-end pt-0">
                <div class="d-flex align-items-center flex-column mt-3 w-100">
                    <div class="d-flex justify-content-between fw-bold fs-6 text-gray-500 w-100 mt-auto mb-2">
                        <span>Prioritas tinggi</span>
                        <span class="text-danger">100%</span>
                    </div>
                    <div class="h-8px w-100 bg-light-danger rounded">
                        <div class="bg-danger rounded h-8px" style="width: 100%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end::Card Urgent-->

    <!--begin::Card Today-->
    <div class="col-sm-6 col-xl-3">
        <div class="card card-flush h-xl-100">
            <div class="card-header pt-5">
                <div class="card-title d-flex flex-column">
                    <span class="fs-2hx fw-bold text-gray-900 me-2 lh-1 ls-n2">89</span>
                    <span class="text-gray-500 pt-1 fw-semibold fs-6">Studi Hari Ini</span>
                </div>
            </div>
            <div class="card-body d-flex align-items-end pt-0">
                <div class="d-flex align-items-center flex-column mt-3 w-100">
                    <div class="d-flex justify-content-between fw-bold fs-6 text-gray-500 w-100 mt-auto mb-2">
                        <span>Selesai dibaca</span>
                        <span class="text-success">74%</span>
                    </div>
                    <div class="h-8px w-100 bg-light-success rounded">
                        <div class="bg-success rounded h-8px" style="width: 74%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end::Card Today-->

    <!--begin::Card Active-->
    <div class="col-sm-6 col-xl-3">
        <div class="card card-flush h-xl-100">
            <div class="card-header pt-5">
                <div class="card-title d-flex flex-column">
                    <span class="fs-2hx fw-bold text-primary me-2 lh-1 ls-n2">5</span>
                    <span class="text-gray-500 pt-1 fw-semibold fs-6">Sedang Aktif</span>
                </div>
            </div>
            <div class="card-body d-flex align-items-end pt-0">
                <div class="d-flex align-items-center flex-column mt-3 w-100">
                    <div class="d-flex justify-content-between fw-bold fs-6 text-gray-500 w-100 mt-auto mb-2">
                        <span>Sedang dibaca</span>
                        <span class="text-primary">Active</span>
                    </div>
                    <div class="h-8px w-100 bg-light-primary rounded">
                        <div class="bg-primary rounded h-8px" style="width: 45%; animation: pulse 1.5s infinite alternate;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end::Card Active-->
</div>

<div class="row g-5 g-xl-8">

    <div class="col-xl-8">
        <div class="card card-flush h-xl-100">

            <!--begin::Card header-->
            <div class="card-header border-0 pt-6">
                <div class="card-title">
                    <h3 class="fw-bold fs-4 text-gray-900 mb-0">Main Worklist</h3>
                </div>
                <!--begin::Card toolbar-->
                <div class="card-toolbar gap-2">
                    <!--begin::Filter tabs-->
                    <ul class="nav nav-pills nav-pills-custom" id="worklist_tabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link btn btn-outline btn-flex btn-color-muted btn-active-color-primary fw-bold px-4 py-2 active"
                                data-bs-toggle="tab" href="#tab_pending" id="tab_pending_btn">
                                <span class="fs-7">Pending</span>
                                <span class="badge badge-light-warning ms-1 fs-8">47</span>
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link btn btn-outline btn-flex btn-color-muted btn-active-color-danger fw-bold px-4 py-2"
                                data-bs-toggle="tab" href="#tab_urgent" id="tab_urgent_btn">
                                <span class="fs-7">Urgent</span>
                                <span class="badge badge-light-danger ms-1 fs-8">12</span>
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link btn btn-outline btn-flex btn-color-muted btn-active-color-info fw-bold px-4 py-2"
                                data-bs-toggle="tab" href="#tab_today" id="tab_today_btn">
                                <span class="fs-7">Today</span>
                                <span class="badge badge-light-info ms-1 fs-8">89</span>
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link btn btn-outline btn-flex btn-color-muted btn-active-color-primary fw-bold px-4 py-2"
                                data-bs-toggle="tab" href="#tab_active" id="tab_active_btn">
                                <span class="fs-7">Active</span>
                                <span class="badge badge-primary ms-1 fs-8">5</span>
                            </a>
                        </li>
                    </ul>
                    <!--end::Filter tabs-->

                    <!--begin::Filter button-->
                    <button class="btn btn-sm btn-flex btn-light btn-active-light-primary fw-bold"
                        data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                        <i class="ki-duotone ki-filter fs-6 text-muted me-1">
                            <span class="path1"></span><span class="path2"></span>
                        </i>Filter
                    </button>
                    <!--begin::Filter dropdown-->
                    <div class="menu menu-sub menu-sub-dropdown w-300px" data-kt-menu="true">
                        <div class="px-7 py-5">
                            <div class="fs-5 text-gray-900 fw-bold">Filter Worklist</div>
                        </div>
                        <div class="separator border-gray-200"></div>
                        <div class="px-7 py-5">
                            <div class="mb-5">
                                <label class="form-label fw-semibold">Modalitas:</label>
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach(['CT', 'MRI', 'X-Ray', 'USG', 'Mammo'] as $mod)
                                    <label class="form-check form-check-sm form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" value="{{ $mod }}" checked />
                                        <span class="form-check-label">{{ $mod }}</span>
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                            <div class="mb-5">
                                <label class="form-label fw-semibold">Status:</label>
                                <select class="form-select form-select-solid form-select-sm" multiple data-kt-select2="true" data-placeholder="Semua status">
                                    <option value="pending">Pending</option>
                                    <option value="in_progress">In Progress</option>
                                    <option value="completed">Completed</option>
                                    <option value="urgent">Urgent</option>
                                </select>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button class="btn btn-sm btn-light me-2" data-kt-menu-dismiss="true">Reset</button>
                                <button class="btn btn-sm btn-primary" data-kt-menu-dismiss="true">Terapkan</button>
                            </div>
                        </div>
                    </div>
                    <!--end::Filter dropdown-->
                    <!--end::Filter button-->

                </div>
                <!--end::Card toolbar-->
            </div>
            <!--end::Card header-->

            <!--begin::Card body-->
            <div class="card-body pt-4">
                <div class="tab-content">

                    <div class="tab-pane fade show active" id="tab_pending" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table table-row-bordered table-row-gray-100 align-middle gs-0 gy-3 fs-7" id="table_pending">
                                <thead>
                                    <tr class="fw-bold text-muted bg-light">
                                        <th class="ps-4 min-w-30px rounded-start">
                                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                                <input class="form-check-input" type="checkbox" id="check_all_pending" />
                                            </div>
                                        </th>
                                        <th class="min-w-100px">Pasien</th>
                                        <th class="min-w-100px">Accession No.</th>
                                        <th class="min-w-80px">Modalitas</th>
                                        <th class="min-w-120px">Deskripsi Studi</th>
                                        <th class="min-w-80px">Waktu Masuk</th>
                                        <th class="min-w-80px">Status</th>
                                        <th class="min-w-80px text-end pe-4 rounded-end">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $pendingStudies = [
                                        ['id' => 1, 'patient' => 'Budi Santoso', 'mrn' => 'MRN-2024-001', 'accession' => 'ACC-20241119-001', 'modality' => 'CT', 'modality_color' => 'info', 'description' => 'CT Scan Kepala Tanpa Kontras', 'arrived' => '08:15', 'priority' => 'routine'],
                                        ['id' => 2, 'patient' => 'Sari Dewi', 'mrn' => 'MRN-2024-002', 'accession' => 'ACC-20241119-002', 'modality' => 'MRI', 'modality_color' => 'primary', 'description' => 'MRI Brain + Spine Cervical', 'arrived' => '08:42', 'priority' => 'routine'],
                                        ['id' => 3, 'patient' => 'Ahmad Fauzi', 'mrn' => 'MRN-2024-003', 'accession' => 'ACC-20241119-003', 'modality' => 'X-Ray', 'modality_color' => 'success', 'description' => 'Foto Thorax PA', 'arrived' => '09:00', 'priority' => 'routine'],
                                        ['id' => 4, 'patient' => 'Rina Marlina', 'mrn' => 'MRN-2024-004', 'accession' => 'ACC-20241119-004', 'modality' => 'USG', 'modality_color' => 'warning', 'description' => 'USG Abdomen Atas', 'arrived' => '09:15', 'priority' => 'routine'],
                                        ['id' => 5, 'patient' => 'Hendra Gunawan', 'mrn' => 'MRN-2024-005', 'accession' => 'ACC-20241119-005', 'modality' => 'CT', 'modality_color' => 'info', 'description' => 'CT Thorax HRCT', 'arrived' => '09:30', 'priority' => 'routine'],
                                        ['id' => 6, 'patient' => 'Fitri Handayani', 'mrn' => 'MRN-2024-006', 'accession' => 'ACC-20241119-006', 'modality' => 'Mammo', 'modality_color' => 'pink', 'description' => 'Mammografi Bilateral', 'arrived' => '09:45', 'priority' => 'routine'],
                                        ['id' => 7, 'patient' => 'Dedi Kurniawan', 'mrn' => 'MRN-2024-007', 'accession' => 'ACC-20241119-007', 'modality' => 'MRI', 'modality_color' => 'primary', 'description' => 'MRI Knee Joint Kanan', 'arrived' => '10:00', 'priority' => 'routine'],
                                    ];
                                    @endphp

                                    @foreach($pendingStudies as $study)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                                <input class="form-check-input" type="checkbox" value="{{ $study['id'] }}" />
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <a href="#" class="text-gray-800 text-hover-primary fw-bold fs-7">
                                                    {{ $study['patient'] }}
                                                </a>
                                                <span class="text-muted fs-8">{{ $study['mrn'] }}</span>
                                            </div>
                                        </td>
                                        <td class="text-muted fw-semibold fs-8">{{ $study['accession'] }}</td>
                                        <td>
                                            <span class="badge badge-light-{{ $study['modality_color'] }} fw-bold fs-8 px-3">
                                                {{ $study['modality'] }}
                                            </span>
                                        </td>
                                        <td class="text-gray-700 fw-semibold fs-7">{{ $study['description'] }}</td>
                                        <td class="text-muted fs-8">{{ $study['arrived'] }}</td>
                                        <td>
                                            <span class="badge badge-light-warning fw-bold fs-8">Pending</span>
                                        </td>
                                        <td class="text-end pe-4">
                                            <a href="#"
                                                class="btn btn-icon btn-sm btn-light btn-active-light-primary me-1"
                                                data-bs-toggle="tooltip" title="Buka Viewer">
                                                <i class="ki-outline ki-eye fs-5"></i>
                                            </a>
                                            <a href="#" class="btn btn-icon btn-sm btn-light btn-active-light-success me-1"
                                                data-bs-toggle="tooltip" title="Buat Laporan">
                                                <i class="ki-outline ki-document fs-5"></i>
                                            </a>
                                            <button class="btn btn-icon btn-sm btn-light btn-active-light-danger"
                                                data-bs-toggle="tooltip" title="Tandai Urgent"
                                                onclick="markUrgent({{ $study['id'] }})">
                                                <i class="ki-outline ki-warning-2 fs-5"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                  
                    <div class="tab-pane fade" id="tab_urgent" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table table-row-bordered table-row-gray-100 align-middle gs-0 gy-3 fs-7" id="table_urgent">
                                <thead>
                                    <tr class="fw-bold text-muted bg-light-danger">
                                        <th class="ps-4 min-w-30px rounded-start">
                                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                                <input class="form-check-input" type="checkbox" />
                                            </div>
                                        </th>
                                        <th class="min-w-100px">Pasien</th>
                                        <th class="min-w-100px">Accession No.</th>
                                        <th class="min-w-80px">Modalitas</th>
                                        <th class="min-w-120px">Deskripsi Studi</th>
                                        <th class="min-w-80px">Waktu Masuk</th>
                                        <th class="min-w-80px">Sisa TAT</th>
                                        <th class="min-w-80px text-end pe-4 rounded-end">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $urgentStudies = [
                                        ['id' => 10, 'patient' => 'Agus Setiawan', 'mrn' => 'MRN-2024-010', 'accession' => 'ACC-20241119-010', 'modality' => 'CT', 'modality_color' => 'info', 'description' => 'CT Scan Kepala STAT - Suspek ICH', 'arrived' => '06:30', 'tat' => '00:28', 'tat_color' => 'danger'],
                                        ['id' => 11, 'patient' => 'Dewi Rahayu', 'mrn' => 'MRN-2024-011', 'accession' => 'ACC-20241119-011', 'modality' => 'CT', 'modality_color' => 'info', 'description' => 'CT Angiografi Paru - Suspek PE', 'arrived' => '07:15', 'tat' => '01:12', 'tat_color' => 'warning'],
                                        ['id' => 12, 'patient' => 'Bambang Purnomo', 'mrn' => 'MRN-2024-012', 'accession' => 'ACC-20241119-012', 'modality' => 'MRI', 'modality_color' => 'primary', 'description' => 'MRI Spine Cervical STAT - Trauma', 'arrived' => '07:45', 'tat' => '01:45', 'tat_color' => 'warning'],
                                        ['id' => 13, 'patient' => 'Wati Susanti', 'mrn' => 'MRN-2024-013', 'accession' => 'ACC-20241119-013', 'modality' => 'X-Ray', 'modality_color' => 'success', 'description' => 'X-Ray Thorax STAT - Post Op', 'arrived' => '08:00', 'tat' => '02:15', 'tat_color' => 'success'],
                                    ];
                                    @endphp

                                    @foreach($urgentStudies as $study)
                                    <tr class="border-start border-danger border-2">
                                        <td class="ps-4">
                                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                                <input class="form-check-input" type="checkbox" value="{{ $study['id'] }}" />
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <a href="#" class="text-gray-800 text-hover-primary fw-bold fs-7">
                                                    {{ $study['patient'] }}
                                                </a>
                                                <span class="text-muted fs-8">{{ $study['mrn'] }}</span>
                                            </div>
                                        </td>
                                        <td class="text-muted fw-semibold fs-8">{{ $study['accession'] }}</td>
                                        <td>
                                            <span class="badge badge-light-{{ $study['modality_color'] }} fw-bold fs-8 px-3">
                                                {{ $study['modality'] }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <span class="text-gray-700 fw-bold fs-7">{{ $study['description'] }}</span>
                                                <span class="badge badge-danger fs-9 w-fit-content mt-1">STAT</span>
                                            </div>
                                        </td>
                                        <td class="text-muted fs-8">{{ $study['arrived'] }}</td>
                                        <td>
                                            <span class="badge badge-light-{{ $study['tat_color'] }} fw-bold fs-8">
                                                <i class="ki-outline ki-time fs-8 me-1"></i>{{ $study['tat'] }}
                                            </span>
                                        </td>
                                        <td class="text-end pe-4">
                                            <a href="#"
                                                class="btn btn-sm btn-danger btn-active-danger">
                                                <i class="ki-outline ki-eye fs-6 me-1"></i>Buka
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                  
                    <div class="tab-pane fade" id="tab_today" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table table-row-bordered table-row-gray-100 align-middle gs-0 gy-3 fs-7" id="table_today">
                                <thead>
                                    <tr class="fw-bold text-muted bg-light">
                                        <th class="ps-4 min-w-30px rounded-start">
                                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                                <input class="form-check-input" type="checkbox" />
                                            </div>
                                        </th>
                                        <th class="min-w-100px">Pasien</th>
                                        <th class="min-w-80px">Modalitas</th>
                                        <th class="min-w-120px">Deskripsi Studi</th>
                                        <th class="min-w-80px">Waktu</th>
                                        <th class="min-w-100px">Radiolog</th>
                                        <th class="min-w-80px">Status</th>
                                        <th class="min-w-80px text-end pe-4 rounded-end">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $todayStudies = [
                                        ['id' => 20, 'patient' => 'Lisa Permata', 'modality' => 'CT', 'modality_color' => 'info', 'description' => 'CT Thorax + Abdomen', 'time' => '07:00', 'radiolog' => 'Dr. Hendra', 'status' => 'completed', 'status_color' => 'success'],
                                        ['id' => 21, 'patient' => 'Joko Widodo', 'modality' => 'MRI', 'modality_color' => 'primary', 'description' => 'MRI Shoulder Kanan', 'time' => '07:30', 'radiolog' => 'Dr. Sinta', 'status' => 'completed', 'status_color' => 'success'],
                                        ['id' => 22, 'patient' => 'Nani Sumarni', 'modality' => 'X-Ray', 'modality_color' => 'success', 'description' => 'Foto Genu AP/Lat', 'time' => '08:00', 'radiolog' => 'Dr. Hendra', 'status' => 'in_progress', 'status_color' => 'info'],
                                        ['id' => 23, 'patient' => 'Rudi Hermawan', 'modality' => 'USG', 'modality_color' => 'warning', 'description' => 'USG Renal Bilateral', 'time' => '08:30', 'radiolog' => '-', 'status' => 'pending', 'status_color' => 'warning'],
                                        ['id' => 24, 'patient' => 'Ani Kristiani', 'modality' => 'CT', 'modality_color' => 'info', 'description' => 'CT Kepala + Kontras', 'time' => '09:00', 'radiolog' => 'Dr. Bowo', 'status' => 'in_progress', 'status_color' => 'info'],
                                    ];
                                    $statusLabels = ['completed' => 'Selesai', 'in_progress' => 'Dibaca', 'pending' => 'Pending'];
                                    @endphp

                                    @foreach($todayStudies as $study)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                                <input class="form-check-input" type="checkbox" value="{{ $study['id'] }}" />
                                            </div>
                                        </td>
                                        <td>
                                            <a href="#" class="text-gray-800 text-hover-primary fw-bold fs-7">
                                                {{ $study['patient'] }}
                                            </a>
                                        </td>
                                        <td>
                                            <span class="badge badge-light-{{ $study['modality_color'] }} fw-bold fs-8 px-3">
                                                {{ $study['modality'] }}
                                            </span>
                                        </td>
                                        <td class="text-gray-700 fw-semibold fs-7">{{ $study['description'] }}</td>
                                        <td class="text-muted fs-8">{{ $study['time'] }}</td>
                                        <td class="text-gray-700 fw-semibold fs-7">{{ $study['radiolog'] }}</td>
                                        <td>
                                            <span class="badge badge-light-{{ $study['status_color'] }} fw-bold fs-8">
                                                {{ $statusLabels[$study['status']] }}
                                            </span>
                                        </td>
                                        <td class="text-end pe-4">
                                            <a href="#"
                                                class="btn btn-icon btn-sm btn-light btn-active-light-primary me-1"
                                                data-bs-toggle="tooltip" title="Detail">
                                                <i class="ki-outline ki-eye fs-5"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <div class="tab-pane fade" id="tab_active" role="tabpanel">
                        <div class="d-flex flex-column gap-4 py-2">
                            @php
                            $activeStudies = [
                                ['id' => 30, 'patient' => 'Siti Halimah', 'modality' => 'CT', 'modality_color' => 'info', 'description' => 'CT Kepala Polos', 'radiolog' => 'Dr. Hendra', 'started' => '09:45', 'duration' => '12 mnt'],
                                ['id' => 31, 'patient' => 'Eko Prasetyo', 'modality' => 'MRI', 'modality_color' => 'primary', 'description' => 'MRI Lumbar Spine', 'radiolog' => 'Dr. Sinta', 'started' => '09:52', 'duration' => '5 mnt'],
                                ['id' => 32, 'patient' => 'Tini Suhartini', 'modality' => 'X-Ray', 'modality_color' => 'success', 'description' => 'Foto Thorax', 'radiolog' => 'Dr. Bowo', 'started' => '09:58', 'duration' => '2 mnt'],
                                ['id' => 33, 'patient' => 'Herman Sopandi', 'modality' => 'USG', 'modality_color' => 'warning', 'description' => 'USG Tiroid', 'radiolog' => 'Dr. Hendra', 'started' => '10:00', 'duration' => '< 1 mnt'],
                                ['id' => 34, 'patient' => 'Ayu Lestari', 'modality' => 'CT', 'modality_color' => 'info', 'description' => 'CT Abdomen + Kontras', 'radiolog' => 'Dr. Sinta', 'started' => '10:01', 'duration' => '< 1 mnt'],
                            ];
                            @endphp

                            @foreach($activeStudies as $study)
                            <div class="d-flex align-items-center border border-dashed border-primary rounded p-4 bg-light-primary">
                                <!--begin::Indicator-->
                                <div class="me-4 position-relative">
                                    <div class="symbol symbol-45px">
                                        <div class="symbol-label fw-bold bg-{{ $study['modality_color'] }} text-white fs-6">
                                            {{ substr($study['modality'], 0, 2) }}
                                        </div>
                                    </div>
                                    <div class="position-absolute bottom-0 end-0 w-12px h-12px bg-success rounded-circle border border-2 border-white"
                                        style="animation: pulse 1.5s infinite;"></div>
                                </div>
                                <!--end::Indicator-->

                                <!--begin::Info-->
                                <div class="flex-grow-1 me-4">
                                    <a href="#"
                                        class="text-gray-900 text-hover-primary fw-bold fs-6">
                                        {{ $study['patient'] }}
                                    </a>
                                    <div class="text-muted fw-semibold fs-7">{{ $study['description'] }}</div>
                                </div>
                                <!--end::Info-->

                                <!--begin::Meta-->
                                <div class="d-flex flex-column align-items-end gap-1">
                                    <span class="badge badge-light-primary fw-bold fs-8">
                                        <i class="ki-outline ki-profile-circle fs-8 me-1"></i>{{ $study['radiolog'] }}
                                    </span>
                                    <span class="text-muted fs-8">
                                        <i class="ki-outline ki-time fs-9 me-1"></i>Mulai: {{ $study['started'] }} ({{ $study['duration'] }})
                                    </span>
                                </div>
                                <!--end::Meta-->
                            </div>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
    
    <div class="col-xl-4">
        <div class="d-flex flex-column gap-5">

           
            <div class="card card-flush">
                <!--begin::Header-->
                <div class="card-header border-0 pt-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold text-gray-900">
                            <i class="ki-outline ki-warning-2 text-danger me-2 fs-4"></i>Urgent Studies
                        </span>
                        <span class="text-muted mt-1 fw-semibold fs-7">12 studi memerlukan tindakan segera</span>
                    </h3>
                    <div class="card-toolbar">
                        <a href="#" class="btn btn-sm btn-light btn-active-light-danger fs-8">
                            Lihat Semua <i class="ki-outline ki-arrow-right fs-8"></i>
                        </a>
                    </div>
                </div>
                <!--end::Header-->

                <!--begin::Body-->
                <div class="card-body py-0">
                    @php
                    $urgentList = [
                        ['patient' => 'Agus Setiawan', 'modality' => 'CT', 'desc' => 'Kepala STAT', 'tat' => '28 mnt', 'tat_level' => 'danger'],
                        ['patient' => 'Dewi Rahayu', 'modality' => 'CT', 'desc' => 'CT Angio Paru', 'tat' => '1 j 12 mnt', 'tat_level' => 'warning'],
                        ['patient' => 'Bambang Purnomo', 'modality' => 'MRI', 'desc' => 'Spine Cervical', 'tat' => '1 j 45 mnt', 'tat_level' => 'warning'],
                        ['patient' => 'Wati Susanti', 'modality' => 'X-Ray', 'desc' => 'Thorax Post Op', 'tat' => '2 j 15 mnt', 'tat_level' => 'success'],
                    ];
                    @endphp

                    @foreach($urgentList as $i => $item)
                    <div class="d-flex align-items-center {{ $i < count($urgentList) - 1 ? 'mb-5' : 'mb-3' }}">
                        <div class="symbol symbol-40px me-4 flex-shrink-0">
                            <span class="symbol-label bg-light-danger">
                                <i class="ki-outline ki-pulse text-danger fs-5"></i>
                            </span>
                        </div>
                        <div class="flex-grow-1 me-3">
                            <a href="#" class="text-gray-800 text-hover-primary fw-bold fs-7">{{ $item['patient'] }}</a>
                            <div class="text-muted fs-8">{{ $item['modality'] }} &mdash; {{ $item['desc'] }}</div>
                        </div>
                        <div class="d-flex flex-column align-items-end">
                            <span class="badge badge-light-{{ $item['tat_level'] }} fw-semibold fs-8 mb-1">
                                <i class="ki-outline ki-time fs-9 me-1"></i>{{ $item['tat'] }}
                            </span>
                            <a href="#" class="btn btn-xs btn-danger py-1 px-2 fs-9">Buka</a>
                        </div>
                    </div>
                    @endforeach
                </div>
                <!--end::Body-->
            </div>
            
            <div class="card card-flush">
                <!--begin::Header-->
                <div class="card-header border-0 pt-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold text-gray-900">
                            <i class="ki-outline ki-profile-circle text-primary me-2 fs-4"></i>My Assignments
                        </span>
                        <span class="text-muted mt-1 fw-semibold fs-7">Studi yang ditugaskan ke saya</span>
                    </h3>
                    <div class="card-toolbar">
                        <span class="badge badge-light-primary fw-bold fs-8">8 studi</span>
                    </div>
                </div>
                <!--end::Header-->

                <!--begin::Body-->
                <div class="card-body py-0">
                    @php
                    $myAssignments = [
                        ['patient' => 'Lisa Permata', 'modality' => 'CT', 'desc' => 'CT Thorax + Abdomen', 'status' => 'in_progress', 'priority' => 'high'],
                        ['patient' => 'Rudi Hermawan', 'modality' => 'USG', 'desc' => 'USG Renal Bilateral', 'status' => 'pending', 'priority' => 'normal'],
                        ['patient' => 'Siti Halimah', 'modality' => 'CT', 'desc' => 'CT Kepala Polos', 'status' => 'pending', 'priority' => 'normal'],
                        ['patient' => 'Herman Sopandi', 'modality' => 'USG', 'desc' => 'USG Tiroid', 'status' => 'active', 'priority' => 'normal'],
                        ['patient' => 'Ayu Lestari', 'modality' => 'CT', 'desc' => 'CT Abdomen+Kontras', 'status' => 'active', 'priority' => 'high'],
                    ];
                    $statusMap = ['in_progress' => ['label' => 'Dibaca', 'color' => 'info'], 'pending' => ['label' => 'Pending', 'color' => 'warning'], 'active' => ['label' => 'Aktif', 'color' => 'success']];
                    @endphp

                    @foreach($myAssignments as $i => $assign)
                    <div class="d-flex align-items-center {{ $i < count($myAssignments) - 1 ? 'mb-5' : 'mb-3' }}">
                        <!--begin::Bullet-->
                        <div class="w-4px h-40px me-4 rounded {{ $assign['priority'] === 'high' ? 'bg-danger' : 'bg-primary' }} flex-shrink-0"></div>
                        <!--end::Bullet-->

                        <div class="flex-grow-1 me-3">
                            <a href="#" class="text-gray-800 text-hover-primary fw-bold fs-7">{{ $assign['patient'] }}</a>
                            <div class="text-muted fs-8">{{ $assign['modality'] }} &mdash; {{ $assign['desc'] }}</div>
                        </div>

                        <div class="d-flex flex-column align-items-end gap-1">
                            <span class="badge badge-light-{{ $statusMap[$assign['status']]['color'] }} fw-semibold fs-8">
                                {{ $statusMap[$assign['status']]['label'] }}
                            </span>
                            @if($assign['priority'] === 'high')
                                <span class="badge badge-light-danger fw-semibold fs-9">Prioritas</span>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
                <!--end::Body-->

                <!--begin::Footer-->
                <div class="card-footer py-3 text-center border-top">
                    <a href="#" class="btn btn-sm btn-color-gray-600 btn-active-color-primary fs-7">
                        Lihat Semua Assignment <i class="ki-outline ki-arrow-right fs-7"></i>
                    </a>
                </div>
                <!--end::Footer-->
            </div>
          
            <div class="card card-flush">
                <!--begin::Header-->
                <div class="card-header border-0 pt-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold text-gray-900">
                            <i class="ki-outline ki-timer text-success me-2 fs-4"></i>Aktivitas Terbaru
                        </span>
                        <span class="text-muted mt-1 fw-semibold fs-7">Log aktivitas sistem hari ini</span>
                    </h3>
                </div>
                <!--end::Header-->

                <!--begin::Body-->
                <div class="card-body py-0">
                    <div class="timeline timeline-3">
                        @php
                        $activities = [
                            ['time' => '10:01', 'color' => 'success', 'icon' => 'ki-check-circle', 'text' => 'Laporan selesai dikirim', 'detail' => 'CT Kepala - Agus Santoso', 'user' => 'Dr. Hendra'],
                            ['time' => '09:58', 'color' => 'primary', 'icon' => 'ki-eye', 'text' => 'Studi dibuka di viewer', 'detail' => 'MRI Lumbar - Eko Prasetyo', 'user' => 'Dr. Sinta'],
                            ['time' => '09:45', 'color' => 'danger', 'icon' => 'ki-warning-2', 'text' => 'Studi ditandai URGENT', 'detail' => 'CT Angio - Dewi Rahayu', 'user' => 'Dr. Bowo'],
                            ['time' => '09:30', 'color' => 'info', 'icon' => 'ki-abstract-26', 'text' => 'Studi baru masuk worklist', 'detail' => 'X-Ray Thorax - Fitri Handayani', 'user' => 'Sistem'],
                            ['time' => '09:15', 'color' => 'warning', 'icon' => 'ki-user-tick', 'text' => 'Assignment diubah', 'detail' => 'USG Abdomen - Rina Marlina', 'user' => 'Admin'],
                            ['time' => '08:45', 'color' => 'success', 'icon' => 'ki-check-circle', 'text' => 'Laporan diverifikasi', 'detail' => 'MRI Brain - Sari Dewi', 'user' => 'Dr. Hendra'],
                        ];
                        @endphp

                        @foreach($activities as $i => $act)
                        <div class="timeline-item align-items-start {{ $i < count($activities) - 1 ? 'mb-4' : 'mb-3' }}">
                            <!--begin::Label-->
                            <div class="timeline-label fw-bold text-gray-800 fs-8 w-40px text-nowrap flex-shrink-0">{{ $act['time'] }}</div>
                            <!--end::Label-->

                            <!--begin::Badge-->
                            <div class="timeline-badge flex-shrink-0">
                                <i class="ki-outline {{ $act['icon'] }} text-{{ $act['color'] }} fs-6"></i>
                            </div>
                            <!--end::Badge-->

                            <!--begin::Content-->
                            <div class="fw-semibold text-gray-700 ps-3">
                                <div class="fs-7">{{ $act['text'] }}</div>
                                <div class="text-muted fs-8">{{ $act['detail'] }}</div>
                                <div class="text-muted fs-9">oleh {{ $act['user'] }}</div>
                            </div>
                            <!--end::Content-->
                        </div>
                        @endforeach
                    </div>
                </div>
                <!--end::Body-->

                <!--begin::Footer-->
                <div class="card-footer py-3 text-center border-top">
                    <a href="#" class="btn btn-sm btn-color-gray-600 btn-active-color-primary fs-7">
                        Lihat Semua Aktivitas <i class="ki-outline ki-arrow-right fs-7"></i>
                    </a>
                </div>
                <!--end::Footer-->
            </div>
           

        </div>
    </div>


</div>

@endsection

@push('styles')
<style>
    @keyframes pulse {
        0% { opacity: 1; }
        100% { opacity: 0.4; }
    }

    .timeline.timeline-3 {
        display: flex;
        flex-direction: column;
    }
    .timeline-item {
        display: flex;
        align-items: flex-start;
        position: relative;
        padding-left: 0;
    }
    .timeline-label {
        text-align: right;
        padding-right: 10px;
        min-width: 40px;
        color: #a1a5b7;
        font-size: 0.75rem;
        padding-top: 2px;
    }
    .timeline-badge {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 20px;
        flex-shrink: 0;
    }

    #worklist_tabs .nav-link {
        border-radius: 6px;
        font-size: 0.8rem;
        transition: all 0.2s ease;
    }
    #worklist_tabs .nav-link.active {
        background-color: var(--bs-primary-light);
    }
    #worklist_tabs .nav-link[href="#tab_urgent"].active {
        background-color: var(--bs-danger-light);
    }

    #table_urgent tbody tr {
        background-color: rgba(var(--bs-danger-rgb), 0.02);
    }
    #table_urgent tbody tr:hover {
        background-color: rgba(var(--bs-danger-rgb), 0.05);
    }
</style>
@endpush

@push('scripts')
<script>
    
    var KTDashboardWorklist = function () {
        var initPendingTable = function () {
            if (!$.fn.DataTable.isDataTable('#table_pending')) {
                $('#table_pending').DataTable({
                    pageLength: 10,
                    order: [[5, 'asc']],
                    dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                         "<'row'<'col-sm-12'tr>>" +
                         "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                    language: {
                        search: "",
                        searchPlaceholder: "Cari studi...",
                        lengthMenu: "Tampilkan _MENU_",
                        info: "Menampilkan _START_ - _END_ dari _TOTAL_ studi",
                        paginate: {
                            next: '<i class="ki-outline ki-arrow-right fs-7"></i>',
                            previous: '<i class="ki-outline ki-arrow-left fs-7"></i>'
                        },
                    },
                    columnDefs: [
                        { orderable: false, targets: [0, 7] },
                    ],
                });
            }
        };

        var initUrgentTable = function () {
            if (!$.fn.DataTable.isDataTable('#table_urgent')) {
                $('#table_urgent').DataTable({
                    pageLength: 10,
                    order: [[6, 'asc']],
                    dom: "t<'row mt-3'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                    columnDefs: [
                        { orderable: false, targets: [0, 7] },
                    ],
                });
            }
        };

        var initTodayTable = function () {
            if (!$.fn.DataTable.isDataTable('#table_today')) {
                $('#table_today').DataTable({
                    pageLength: 10,
                    order: [[4, 'asc']],
                    dom: "t<'row mt-3'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                    columnDefs: [
                        { orderable: false, targets: [0, 7] },
                    ],
                });
            }
        };

        return {
            init: function () {
                initPendingTable();

                $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
                    var target = $(e.target).attr("href");
                    if (target === '#tab_urgent') initUrgentTable();
                    if (target === '#tab_today') initTodayTable();
                });
            }
        };
    }();

    
    document.addEventListener('DOMContentLoaded', function () {
        const checkAllPending = document.getElementById('check_all_pending');
        if (checkAllPending) {
            checkAllPending.addEventListener('change', function () {
                document.querySelectorAll('#tab_pending .form-check-input:not(#check_all_pending)')
                    .forEach(cb => cb.checked = this.checked);
            });
        }

        KTDashboardWorklist.init();

        var tooltipEls = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipEls.forEach(function (el) {
            new bootstrap.Tooltip(el);
        });

        document.getElementById('btn_refresh')?.addEventListener('click', function () {
            var icon = this.querySelector('i');
            icon.classList.add('ki-spin');
            setTimeout(() => { icon.classList.remove('ki-spin'); }, 1500);
        });
    });

   
    function markUrgent(studyId) {
        if (confirm('Tandai studi ini sebagai URGENT?')) {
            fetch(`/studies/${studyId}/mark-urgent`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                },
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    toastr.success('Studi berhasil ditandai sebagai URGENT');
                }
            })
            .catch(() => {
                toastr.error('Gagal menandai studi sebagai urgent');
            });
        }
    }
</script>
@endpush