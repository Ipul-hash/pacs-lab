@extends('layouts.app')

@section('title', 'Modality Worklist')
@section('page-title', 'Modality Worklist')

@section('breadcrumb')
<li class="breadcrumb-item"><span class="bullet bg-gray-500 w-5px h-2px"></span></li>
<li class="breadcrumb-item text-muted">Modality Worklist</li>
@endsection



@php
$today = now()->format('Y-m-d');
@endphp

@section('content')

<div id="refresh_progress_bar"
     style="position:fixed;top:0;left:0;height:2px;width:0%;
            background:linear-gradient(90deg,#1B84FF,#7239EA);
            z-index:9999;transition:width 1s linear;pointer-events:none"></div>

<div class="d-flex flex-column flex-column-fluid">
<div class="app-content flex-column-fluid">
<div class="app-container container-fluid">


<div class="d-flex align-items-center justify-content-between mb-5 flex-wrap gap-3">
    <div>
        <h2 class="fw-bold text-gray-900 fs-3 mb-1">Modality Worklist</h2>
        <p class="text-muted fs-7 mb-0">Daftar pemeriksaan terjadwal untuk modalitas</p>
    </div>
    <div class="d-flex align-items-center gap-3">
        <span class="badge badge-light-primary fs-7 fw-bold px-3 py-2">
            <i class="ki-outline ki-calendar fs-7 me-1"></i>
            <span id="today_count">0</span> order hari ini
        </span>
        <span class="d-none d-md-flex align-items-center gap-2 text-muted fs-8">
            <span class="bullet bullet-dot bg-success h-7px w-7px"
                  style="animation:pulse-dot 1.5s infinite"></span>
            Refresh <b class="text-gray-700 ms-1" id="refresh_countdown2">30s</b>
        </span>
        <button class="btn btn-sm btn-icon btn-light btn-active-light-primary"
                id="btn_refresh2" title="Refresh">
            <i class="ki-outline ki-arrows-circle fs-4"></i>
        </button>
        <button class="btn btn-primary btn-sm fw-bold" id="btn_add_order">
            <i class="ki-outline ki-plus-square fs-4 me-1"></i>Tambah Order
        </button>
    </div>
</div>
<div class="d-flex align-items-stretch gap-3 mb-5 flex-wrap" id="kpi-container">
</div>


<div class="card card-flush mb-5">
    <div class="card-body py-4">
        <div class="row g-3 align-items-end">

            <div class="col-12 col-md-6 col-xl-2">
                <label class="form-label fw-semibold fs-7 text-gray-600 mb-1">
                    <i class="ki-outline ki-calendar fs-7 me-1"></i>Tanggal
                </label>
                <input type="date" id="filter_date"
                       class="form-control form-control-sm form-control-solid"
                       value="{{ $today }}">
            </div>

            <div class="col-6 col-md-3 col-xl-2">
                <label class="form-label fw-semibold fs-7 text-gray-600 mb-1">Modality</label>
                <select id="filter_modality" class="form-select form-select-sm form-select-solid">
                    <option value="">Semua</option>
                    @foreach(['CT','MRI','CR','US','DX','MG','NM','PT','RF'] as $m)
                        <option value="{{ $m }}">{{ $m }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-6 col-md-3 col-xl-2">
                <label class="form-label fw-semibold fs-7 text-gray-600 mb-1">Status</label>
                <select id="filter_status" class="form-select form-select-sm form-select-solid">
                    <option value="">Semua Status</option>
                    <option value="scheduled">Scheduled</option>
                    <option value="inprogress">In Progress</option>
                    <option value="completed">Completed</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </div>

            <div class="col-6 col-md-3 col-xl-2">
                <label class="form-label fw-semibold fs-7 text-gray-600 mb-1">Priority</label>
                <select id="filter_priority" class="form-select form-select-sm form-select-solid">
                    <option value="">Semua</option>
                    <option value="routine">Routine</option>
                    <option value="urgent">Urgent</option>
                    <option value="stat">STAT</option>
                </select>
            </div>

            <div class="col-12 col-md-6 col-xl-3">
                <label class="form-label fw-semibold fs-7 text-gray-600 mb-1">Cari Pasien / Accession</label>
                <div class="position-relative">
                    <i class="ki-outline ki-magnifier fs-5 text-gray-400
                               position-absolute top-50 translate-middle-y ms-3"></i>
                    <input type="text" id="filter_search"
                           class="form-control form-control-sm form-control-solid ps-10"
                           placeholder="Nama pasien, accession no...">
                </div>
            </div>

            <div class="col-6 col-md-3 col-xl-1">
                <button type="button" id="btn_reset_filter"
                        class="btn btn-sm btn-light btn-active-light-danger w-100"
                        title="Reset filter">
                    <i class="ki-outline ki-cross-circle fs-5"></i>
                </button>
            </div>

        </div>
    </div>
</div>

<div class="card card-flush">
    <div class="card-header pt-5 border-bottom-0">
        <div class="card-title">
            <h3 class="fw-bold fs-5 text-gray-800 mb-0">
                Daftar Order
                <span class="badge badge-light-primary ms-2 fs-8" id="row_count_badge">
                    0 item
                </span>
            </h3>
        </div>
        <div class="card-toolbar gap-2">
            <button class="btn btn-sm btn-light btn-active-light-primary fs-8 fw-bold"
                    id="btn_sort_toggle" title="Urutkan berdasarkan waktu">
                <i class="ki-outline ki-arrow-up fs-7 me-1" id="sort_icon"></i>
                Waktu Terjadwal
            </button>
        </div>
    </div>

    <div class="card-body py-3 px-0">
        <div class="table-responsive">
            <table class="table table-row-dashed table-row-gray-300 align-middle gs-4 gy-3 fs-7 mb-0"
                   id="worklist_table">
                <thead>
                    <tr class="fw-bold text-uppercase text-muted fs-8">
                        <th class="ps-5" style="min-width:130px">Accession No.</th>
                        <th style="min-width:185px">Patient Name</th>
                        <th style="min-width:110px">Patient ID</th>
                        <th style="min-width:70px;text-align:center">Mod.</th>
                        <th style="min-width:145px">Scheduled Time</th>
                        <th style="min-width:160px">Referring Physician</th>
                        <th style="min-width:88px;text-align:center">Priority</th>
                        <th style="min-width:110px;text-align:center">Status</th>
                        <th style="min-width:115px;text-align:center" class="pe-5">Action</th>
                    </tr>
                </thead>
                <tbody id="worklist_tbody">
                </tbody>
            </table>
        </div>

        <div id="empty_state" class="text-center py-16" style="display:none">
            <i class="ki-outline ki-search-list fs-3x text-gray-300 mb-4 d-block"></i>
            <p class="text-muted fw-semibold fs-6 mb-1">Tidak ada data worklist</p>
            <p class="text-muted fs-7">Coba ubah filter atau tambah order baru</p>
        </div>
    </div>
</div>

</div>
</div>
</div>

<div class="modal fade" id="modal_detail" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0" style="border-radius:12px;overflow:hidden">

            <div class="modal-header px-6 py-4" style="background:#f8f9fc;border-bottom:1px solid #e9ecef">
                <div class="d-flex flex-column">
                    <h5 class="modal-title fw-bold text-gray-900 mb-1" id="det_patient_name_title">—</h5>
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge fw-bold fs-8 wl-badge-modality" id="det_modality_hdr">—</span>
                        <span class="fw-bold fs-8 font-monospace text-primary" id="det_accession_hdr">—</span>
                        <span id="det_status_hdr"></span>
                        <span id="det_priority_hdr"></span>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="px-6 pt-3" id="det_mwl_wrapper"></div>

            <div class="modal-body px-6 py-5" style="max-height:calc(100vh - 230px);overflow-y:auto">
                <div class="row g-6">

                    <div class="col-md-6">

                        <div class="mb-6">
                            <div class="wl-section-title">
                                <i class="ki-outline ki-user-square fs-7 me-1"></i>Patient Information
                            </div>
                            <div class="wl-field">
                                <div class="wl-label">Nama Pasien</div>
                                <div class="wl-value fw-bold" id="det_patient_name">—</div>
                            </div>
                            <div class="row g-3">
                                <div class="col-6 wl-field">
                                    <div class="wl-label">Patient ID</div>
                                    <div class="wl-value font-monospace fs-8" id="det_patient_id">—</div>
                                </div>
                                <div class="col-6 wl-field">
                                    <div class="wl-label">Jenis Kelamin</div>
                                    <div class="wl-value" id="det_sex">—</div>
                                </div>
                            </div>
                            <div class="wl-field">
                                <div class="wl-label">Tanggal Lahir</div>
                                <div class="wl-value" id="det_dob">—</div>
                            </div>
                        </div>

                        <div>
                            <div class="wl-section-title">
                                <i class="ki-outline ki-abstract-26 fs-7 me-1"></i>Order Information
                            </div>
                            <div class="wl-field">
                                <div class="wl-label">Accession Number</div>
                                <div class="wl-value font-monospace text-primary fw-bold" id="det_accession">—</div>
                            </div>
                            <div class="wl-field">
                                <div class="wl-label">Requested Procedure</div>
                                <div class="wl-value fw-semibold" id="det_procedure">—</div>
                            </div>
                            <div class="wl-field">
                                <div class="wl-label">Clinical Information</div>
                                <div class="wl-value text-gray-600 fs-7 lh-base" id="det_clinical_info">—</div>
                            </div>
                            <div class="row g-3">
                                <div class="col-6 wl-field">
                                    <div class="wl-label">Modality</div>
                                    <div class="wl-value" id="det_modality_body">—</div>
                                </div>
                                <div class="col-6 wl-field">
                                    <div class="wl-label">Priority</div>
                                    <div id="det_priority_body">—</div>
                                </div>
                            </div>
                            <div class="wl-field">
                                <div class="wl-label">Scheduled Date & Time</div>
                                <div class="wl-value fw-semibold" id="det_scheduled_dt">—</div>
                            </div>
                            <div class="wl-field">
                                <div class="wl-label">Referring Physician</div>
                                <div class="wl-value" id="det_physician">—</div>
                            </div>
                        </div>

                    </div>

                    <div class="col-md-6">

                        <div class="mb-5">
                            <div class="wl-section-title">
                                <i class="ki-outline ki-technology-4 fs-7 me-1"></i>DICOM Technical Info
                                <span class="badge badge-light-info ms-1" style="font-size:9px">read-only</span>
                            </div>
                            <div class="wl-dicom-box">
                                <div class="wl-dicom-row">
                                    <span class="wl-dicom-label">Scheduled Station AE Title</span>
                                    <span class="wl-dicom-val" id="det_ae_title">—</span>
                                </div>
                                <div class="wl-dicom-row">
                                    <span class="wl-dicom-label">Scheduled Procedure Step ID</span>
                                    <span class="wl-dicom-val" id="det_step_id">—</span>
                                </div>
                                <div class="wl-dicom-row" style="margin-bottom:0">
                                    <span class="wl-dicom-label">Study Instance UID</span>
                                    <span class="wl-dicom-val" id="det_study_uid"
                                          style="font-size:11px;word-break:break-all">—</span>
                                </div>
                            </div>
                        </div>

                        <div>
                            <div class="wl-section-title">Catatan Tambahan</div>
                            <div class="text-muted fs-7" id="det_notes">—</div>
                        </div>

                    </div>

                </div>
            </div>

            <div class="modal-footer px-6 py-4 border-top gap-2">
                <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-sm btn-light-warning fw-bold" id="det_btn_edit" style="display:none">
                    <i class="ki-outline ki-pencil fs-5 me-1"></i>Edit Order
                </button>
                <button type="button" class="btn btn-sm btn-light-danger fw-bold" id="det_btn_delete">
                    <i class="ki-outline ki-trash fs-5 me-1"></i>Delete Order
                </button>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="modal_form_order" tabindex="-1" aria-hidden="true"
     data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0" style="border-radius:12px;overflow:hidden">

            <div class="modal-header px-6 py-4" style="background:#f8f9fc;border-bottom:1px solid #e9ecef">
                <h5 class="modal-title fw-bold" id="form_modal_title">Tambah Order Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body px-7 py-6" style="max-height:calc(100vh - 200px);overflow-y:auto">
                <form id="form_order" novalidate autocomplete="off">
                    @csrf
                    <input type="hidden" id="form_order_id" name="id">

                    <div class="wl-section-title mb-5">
                        <i class="ki-outline ki-user-square fs-7 me-1"></i>Informasi Pasien
                    </div>
                    <div class="row g-4 mb-4">
                        <div class="col-md-3">
                            <label class="required form-label fs-7 fw-semibold">No. RM / Patient ID</label>
                            <input type="text" name="patient_id" id="inp_patient_id"
                                   class="form-control form-control-sm form-control-solid"
                                   placeholder="Masukkan No. RM" required>
                        </div>
                        <div class="col-md-4">
                            <label class="required form-label fs-7 fw-semibold">Nama Pasien</label>
                            <input type="text" name="patient_name" id="inp_patient_name"
                                   class="form-control form-control-sm form-control-solid"
                                   placeholder="Nama lengkap" style="text-transform:uppercase" required>
                        </div>
                        <div class="col-md-3">
                            <label class="required form-label fs-7 fw-semibold">Tanggal Lahir</label>
                            <input type="date" name="dob" id="inp_dob"
                                   class="form-control form-control-sm form-control-solid" required>
                        </div>
                        <div class="col-md-2">
                            <label class="required form-label fs-7 fw-semibold">Jenis Kelamin</label>
                            <select name="sex" id="inp_sex" class="form-select form-select-sm form-select-solid" required>
                                <option value="">Pilih</option>
                                <option value="M">Laki-laki</option>
                                <option value="F">Perempuan</option>
                            </select>
                        </div>
                    </div>

                    <div class="wl-section-title mb-5">
                        <i class="ki-outline ki-abstract-26 fs-7 me-1"></i>Informasi Order
                    </div>
                    <div class="row g-4 mb-4">
                        <div class="col-md-3">
                            <label class="required form-label fs-7 fw-semibold">Modality</label>
                            <select name="modality" id="inp_modality" class="form-select form-select-sm form-select-solid" required>
                                <option value="">Pilih Modality</option>
                                @foreach([
                                    'CT'  => 'CT – Computed Tomography',
                                    'MRI' => 'MRI – Magnetic Resonance',
                                    'CR'  => 'CR – Computed Radiography',
                                    'US'  => 'US – Ultrasound',
                                    'DX'  => 'DX – Digital Radiography',
                                    'MG'  => 'MG – Mammography',
                                    'NM'  => 'NM – Nuclear Medicine',
                                    'PT'  => 'PT – PET Scan',
                                    'RF'  => 'RF – Fluoroscopy',
                                ] as $val => $lbl)
                                    <option value="{{ $val }}">{{ $lbl }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="required form-label fs-7 fw-semibold">Tanggal Jadwal</label>
                            <input type="date" name="scheduled_date" id="inp_scheduled_date"
                                   class="form-control form-control-sm form-control-solid"
                                   value="{{ $today }}" required>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fs-7 fw-semibold">Jam Jadwal</label>
                            <input type="time" name="scheduled_time" id="inp_scheduled_time"
                                   class="form-control form-control-sm form-control-solid">
                        </div>
                        <div class="col-md-3">
                            <label class="required form-label fs-7 fw-semibold">Requested Procedure</label>
                            <input type="text" name="procedure" id="inp_procedure"
                                   class="form-control form-control-sm form-control-solid"
                                   placeholder="Nama prosedur / pemeriksaan" required>
                        </div>
                        <div class="col-md-5">
                            <label class="form-label fs-7 fw-semibold">Referring Physician</label>
                            <input type="text" name="physician" id="inp_physician"
                                   class="form-control form-control-sm form-control-solid"
                                   placeholder="dr. Nama Dokter, Sp.XXX">
                        </div>
                        <div class="col-12">
                            <label class="form-label fs-7 fw-semibold">Clinical Information / Indikasi</label>
                            <textarea name="clinical_info" id="inp_clinical_info"
                                      class="form-control form-control-sm form-control-solid" rows="2"
                                      placeholder="Indikasi klinis, keluhan utama, riwayat penyakit..."></textarea>
                        </div>
                    </div>

                    <div class="wl-section-title mb-5">
                        <i class="ki-outline ki-technology-4 fs-7 me-1"></i>DICOM / MWL Configuration
                    </div>
                    <div class="row g-4">
                        <div class="col-md-4">
                            <label class="form-label fs-7 fw-semibold">Station AE Title</label>
                            <input type="text" name="ae_title" id="inp_ae_title"
                                   class="form-control form-control-sm form-control-solid font-monospace"
                                   placeholder="cth: CT_STATION_01"
                                   style="text-transform:uppercase">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fs-7 fw-semibold">Catatan Tambahan</label>
                            <textarea name="notes" id="inp_notes"
                                      class="form-control form-control-sm form-control-solid" rows="2"
                                      placeholder="Catatan khusus untuk operator / radiolog..."></textarea>
                        </div>
                    </div>

                </form>
            </div>

            <div class="modal-footer px-7 py-4 border-top gap-2">
                <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-sm btn-primary fw-bold" id="btn_save_order">
                    <i class="ki-outline ki-check fs-5 me-1"></i>
                    <span id="btn_save_label">Simpan Order</span>
                </button>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="modal_delete_confirm" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content border-0" style="border-radius:12px">
            <div class="modal-body px-7 py-7 text-center">
                <div class="mb-4">
                    <i class="ki-outline ki-trash-square text-danger" style="font-size:54px"></i>
                </div>
                <h5 class="fw-bold mb-2">Hapus Order?</h5>
                <p class="text-muted fs-7 mb-5">
                    Order <strong class="text-gray-800" id="delete_acc_text">—</strong>
                    akan dihapus. Tindakan ini tidak dapat diurungkan.
                </p>
                <input type="hidden" id="delete_accession">
                <div class="d-flex justify-content-center gap-3">
                    <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Tidak</button>
                    <button type="button" class="btn btn-sm btn-danger fw-bold" id="btn_confirm_delete">
                        <i class="ki-outline ki-cross fs-5 me-1"></i>Ya, Hapus
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
@keyframes pulse-dot {
    0%,100% { opacity:1; transform:scale(1); }
    50%      { opacity:.3; transform:scale(.75); }
}

#worklist_table tbody tr { cursor:pointer; transition:background .12s; }
#worklist_table tbody tr:hover td { background-color:#f8f9fc; }

.row-today td { background-color:rgba(27,132,255,.04) !important; }
.row-today:hover td { background-color:rgba(27,132,255,.09) !important; }
.row-today td:first-child { border-left:3px solid #1B84FF; }

.row-stat td { background-color:rgba(248,40,90,.04) !important; }
.row-stat:hover td { background-color:rgba(248,40,90,.08) !important; }
.row-stat td:first-child { border-left:3px solid #F8285A; }

.row-urgent td { background-color:rgba(246,192,0,.03) !important; }
.row-urgent td:first-child { border-left:3px solid #F6C000; }

.row-completed td { opacity:.6; }
.row-completed:hover td { opacity:.85; }
.row-cancelled td { opacity:.45; }

.wl-badge-modality {
    background:#eef2ff; color:#3b5bdb;
    font-family:'SFMono-Regular',Consolas,monospace;
    font-size:11px; font-weight:700; letter-spacing:.04em;
    padding:3px 9px; border-radius:5px;
}

.wl-badge-routine  { background:#f1f5f9; color:#64748b; }
.wl-badge-urgent   { background:#fff3eb; color:#c05621; }
.wl-badge-stat     { background:#ffe3e3; color:#c92a2a; }

.wl-badge-scheduled  { background:#e8f4fd; color:#1c7ed6; }
.wl-badge-inprogress { background:#fff4de; color:#e67700; }
.wl-badge-completed  { background:#e6f7eb; color:#2f9e44; }
.wl-badge-cancelled  { background:#ffeaea; color:#e03131; }

.wl-action-btn {
    width:30px; height:30px; display:inline-flex;
    align-items:center; justify-content:center;
    border-radius:6px; border:1px solid #e4e6ef;
    background:transparent; color:#7e8299;
    cursor:pointer; transition:all .15s; font-size:12px;
}
.wl-action-btn:hover { background:#f4f6fa; color:#1B84FF; border-color:#c5cbe3; }
.wl-action-btn.danger:hover { background:#fff0f3; color:#F8285A; border-color:#f5b8b8; }

.wl-section-title {
    font-size:10.5px; font-weight:700; text-transform:uppercase;
    letter-spacing:.08em; color:#a1a5b7;
    padding-bottom:8px; border-bottom:1px solid #e9ecef;
    margin-bottom:14px;
}
.wl-field { margin-bottom:14px; }
.wl-field:last-child { margin-bottom:0; }
.wl-label { font-size:11px; font-weight:600; color:#a1a5b7; margin-bottom:3px; }
.wl-value { font-size:13.5px; color:#181c32; font-weight:500; }

.wl-dicom-box {
    background:#f8f9fc; border:1px solid #e9ecef;
    border-radius:8px; padding:14px 16px;
}
.wl-dicom-row { display:flex; flex-direction:column; margin-bottom:12px; }
.wl-dicom-label {
    font-size:10px; font-weight:700; text-transform:uppercase;
    letter-spacing:.07em; color:#a1a5b7; margin-bottom:3px;
}
.wl-dicom-val {
    font-family:'SFMono-Regular',Consolas,monospace;
    font-size:12.5px; color:#3a3f55; font-weight:500;
}

.wl-mwl-ok {
    display:inline-flex; align-items:center; gap:7px;
    background:#e6f7eb; border:1px solid #b2dfbe; color:#2f9e44;
    font-size:12px; font-weight:600; border-radius:6px; padding:6px 14px;
}
.wl-mwl-pending {
    display:inline-flex; align-items:center; gap:7px;
    background:#f8f9fc; border:1px dashed #c9d0e3; color:#a1a5b7;
    font-size:12px; font-weight:600; border-radius:6px; padding:6px 14px;
}

@keyframes wlSlideUp {
    from { transform:translateY(16px); opacity:0; }
    to   { transform:translateY(0); opacity:1; }
}
.wl-toast {
    position:fixed; bottom:24px; right:24px; z-index:9999;
    display:flex; align-items:center; gap:10px;
    padding:13px 18px; border-radius:9px;
    font-size:13.5px; font-weight:600; color:#fff;
    box-shadow:0 6px 28px rgba(0,0,0,.16);
    animation:wlSlideUp .25s ease;
    max-width:340px;
}

.font-monospace { font-family:'SFMono-Regular',Consolas,monospace; }
</style>
@endpush

@push('scripts')
<script>
"use strict";

const WL = (function () {
    const API_BASE = '/api/order';
    let DATA = [];
    const TODAY = new Date().toISOString().split('T')[0];

    let sortAsc = true;
    let refreshSec = 30;
    let countdown = refreshSec;
    let timer = null;
    let activeEditAccession = null;


    function priorityBadge(p) {
        const map = {
            routine: ['wl-badge-routine','Routine'],
            urgent:  ['wl-badge-urgent', 'Urgent'],
            stat:    ['wl-badge-stat',   'STAT'],
        };
        const [cls, lbl] = map[p] || ['wl-badge-routine', p];
        return `<span class="badge ${cls} fw-bold" style="font-size:11px;padding:4px 9px">${lbl}</span>`;
    }

    function statusBadge(s) {
        const map = {
            scheduled:  ['wl-badge-scheduled',  'Scheduled'],
            inprogress: ['wl-badge-inprogress',  'In Progress'],
            completed:  ['wl-badge-completed',   'Completed'],
            cancelled:  ['wl-badge-cancelled',   'Cancelled'],
        };
        const [cls, lbl] = map[s] || ['wl-badge-scheduled', s];
        return `<span class="badge ${cls} fw-bold" style="font-size:11px;padding:4px 9px">${lbl}</span>`;
    }

    function modalityBadge(m) {
        return `<span class="wl-badge-modality">${m || '—'}</span>`;
    }

    function formatDT(dt) {
        if (!dt) return '—';
        const [date, time] = dt.split(' ');
        const d = new Date(date);
        const dateStr = d.toLocaleDateString('id-ID', {day:'2-digit', month:'short', year:'numeric'});
        return `<span class="fw-semibold text-gray-800">${dateStr}</span>
                <span class="text-muted ms-1">${time || ''}</span>`;
    }

    function formatDateFull(d) {
        if (!d) return '—';
        return new Date(d).toLocaleDateString('id-ID', {day:'2-digit',month:'long',year:'numeric'});
    }

    function formatDTText(dt) {
        if (!dt) return '—';
        const [date, time] = dt.split(' ');
        const d = new Date(date);
        return d.toLocaleDateString('id-ID', {day:'2-digit',month:'long',year:'numeric'}) + ' — ' + (time||'');
    }


    async function loadOrdersFromAPI() {
        try {
            const res = await fetch(`${API_BASE}/`);
            const data = await res.json();

            if (!res.ok) {
                toast('danger', `Error: ${data.message}`);
                return;
            }

            DATA = (data.orders || []).map((order, idx) => ({
                id: idx + 1,
                accession: order.AccessionNumber,
                file: order.file,
                size_bytes: order.size_bytes,
                created_at: order.created_at,
                patient_name: 'N/A',
                patient_id: 'N/A',
                dob: '—',
                sex: 'M',
                modality: 'CT',
                scheduled_dt: order.created_at ? order.created_at.split(' ')[0] : new Date().toISOString().split('T')[0],
                physician: '—',
                priority: 'routine',
                status: 'scheduled',
                procedure: 'Unknown',
                clinical_info: '—',
                ae_title: '—',
                step_id: '—',
                study_uid: null,
                mwl_generated: true,
                notes: '—',
            }));

            updateKPIs();   
            render(DATA);   

        } catch (err) {
            console.error('Load error:', err);
            toast('danger', `Error loading orders: ${err.message}`);
        }
    }

    async function createOrderViaAPI() {
        const payload = {
            PatientName: document.getElementById('inp_patient_name').value.trim().toUpperCase(),
            PatientID: document.getElementById('inp_patient_id').value.trim(),
            PatientBirthDate: document.getElementById('inp_dob').value.replace(/-/g, ''),
            PatientSex: document.getElementById('inp_sex').value,
            AccessionNumber: 'ACC-' + Date.now().toString().slice(-8),
            Modality: document.getElementById('inp_modality').value,
            ScheduledDate: document.getElementById('inp_scheduled_date').value.replace(/-/g, ''),
            ScheduledTime: (document.getElementById('inp_scheduled_time').value || '').replace(':', ''),
            ScheduledAET: document.getElementById('inp_ae_title').value.toUpperCase() || 'ANY',
            ScheduledPhysician: document.getElementById('inp_physician').value || '',
            RequestedProcedureDescription: document.getElementById('inp_procedure').value.trim(),
        };

        if (!payload.PatientName || !payload.Modality || !payload.ScheduledDate) {
            toast('danger', 'Please fill all required fields');
            return;
        }

        const btn = document.getElementById('btn_save_order');
        const originalHTML = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = `<span class="spinner-border spinner-border-sm me-2"></span>Saving...`;

        try {
            const res = await fetch(`${API_BASE}/`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]')?.content || '',
                },
                body: JSON.stringify(payload),
            });

            const result = await res.json();

            if (res.ok) {
                toast('success', `Order created: ${result.AccessionNumber}`);
                document.getElementById('form_order').reset();
                document.getElementById('inp_scheduled_date').value = TODAY;
                hideModal('modal_form_order');
                setTimeout(() => loadOrdersFromAPI(), 500);
            } else {
                toast('danger', result.message || 'Failed to create order');
            }

        } catch (err) {
            console.error('Create error:', err);
            toast('danger', `Error: ${err.message}`);
        } finally {
            btn.disabled = false;
            btn.innerHTML = originalHTML;
        }
    }

    async function deleteOrderViaAPI(accessionNumber) {
        const btn = document.getElementById('btn_confirm_delete');
        const originalHTML = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = `<span class="spinner-border spinner-border-sm me-2"></span>Deleting...`;

        try {
            const res = await fetch(`${API_BASE}/${accessionNumber}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]')?.content || '',
                },
            });

            const result = await res.json();

            if (res.ok) {
                toast('success', result.message || 'Order deleted');
                hideModal('modal_delete_confirm');
                hideModal('modal_detail');
                setTimeout(() => loadOrdersFromAPI(), 500);
            } else {
                toast('danger', result.message || 'Failed to delete order');
            }

        } catch (err) {
            console.error('Delete error:', err);
            toast('danger', `Error: ${err.message}`);
        } finally {
            btn.disabled = false;
            btn.innerHTML = originalHTML;
        }
    }


    function buildRow(item) {
        const isToday = item.scheduled_dt && item.scheduled_dt.startsWith(TODAY);
        let rowCls = isToday ? 'row-today' : '';
        if (item.priority === 'stat')   rowCls += ' row-stat';
        else if (item.priority === 'urgent') rowCls += ' row-urgent';
        if (item.status === 'completed') rowCls += ' row-completed';
        if (item.status === 'cancelled') rowCls += ' row-cancelled';

        const locked = item.status === 'completed' || item.status === 'cancelled';
        const actionBtns = `
            <button class="wl-action-btn" title="Lihat Detail"
                    onclick="WL.openDetail('${item.accession}');event.stopPropagation()">
                <i class="ki-outline ki-eye fs-7"></i>
            </button>
            ${!locked ? `
            <button class="wl-action-btn danger" title="Hapus Order"
                    onclick="WL.confirmDelete('${item.accession}');event.stopPropagation()">
                <i class="ki-outline ki-trash fs-7"></i>
            </button>` : ''}
        `;

        return `
        <tr class="${rowCls.trim()}" data-accession="${item.accession}">
            <td class="ps-5">
                <span class="font-monospace fw-bold text-primary fs-8">${item.accession}</span>
            </td>
            <td>
                <div class="d-flex align-items-center gap-3">
                    <div class="symbol symbol-30px flex-shrink-0">
                        <div class="symbol-label fw-bold fs-9 bg-light-primary text-primary">
                            ${item.patient_name.substring(0,2).toUpperCase()}
                        </div>
                    </div>
                    <div>
                        <div class="fw-semibold text-gray-800 lh-1">${item.patient_name}</div>
                        <div class="text-muted fs-8 mt-1">${item.sex === 'M' ? 'L' : 'P'} · ${item.dob}</div>
                    </div>
                </div>
            </td>
            <td><span class="text-muted fs-8 font-monospace">${item.patient_id}</span></td>
            <td class="text-center">${modalityBadge(item.modality)}</td>
            <td>${formatDT(item.scheduled_dt)}</td>
            <td><span class="text-gray-700 fs-7">${item.physician}</span></td>
            <td class="text-center">${priorityBadge(item.priority)}</td>
            <td class="text-center">${statusBadge(item.status)}</td>
            <td class="text-center pe-5" onclick="event.stopPropagation()">
                <div class="d-flex justify-content-center gap-1">${actionBtns}</div>
            </td>
        </tr>`;
    }

    function render(data) {
        const tbody = document.getElementById('worklist_tbody');
        const empty = document.getElementById('empty_state');

        if (!data || data.length === 0) {
            tbody.innerHTML = '';
            empty.style.display = '';
        } else {
            empty.style.display = 'none';
            tbody.innerHTML = data.map(buildRow).join('');
            tbody.querySelectorAll('tr[data-accession]').forEach(tr => {
                tr.addEventListener('click', () => WL.openDetail(tr.dataset.accession));
            });
        }
        document.getElementById('row_count_badge').textContent = (data?.length ?? 0) + ' item';
        const lastUpdatedEl = document.getElementById('last_updated_time');
            if (lastUpdatedEl) lastUpdatedEl.textContent = new Date().toLocaleTimeString('id-ID');
    }

    function updateKPIs() {
        const total = DATA.length;
        const scheduled = DATA.filter(d => d.status === 'scheduled').length;
        const inprogress = DATA.filter(d => d.status === 'inprogress').length;
        const completed = DATA.filter(d => d.status === 'completed').length;
        const urgent = DATA.filter(d => ['urgent', 'stat'].includes(d.priority)).length;

        document.getElementById('today_count').textContent = total;

        const kpiHTML = `
            <div class="d-flex align-items-center bg-body rounded border px-4 py-3 gap-3 flex-fill" style="min-width:130px">
                <div class="d-flex align-items-center justify-content-center w-40px h-40px rounded bg-light-primary flex-shrink-0">
                    <i class="ki-outline ki-abstract-26 fs-3 text-primary"></i>
                </div>
                <div><div class="fs-2 fw-bold text-gray-900 lh-1">${total}</div><div class="fs-8 text-muted fw-semibold mt-1">Total Hari Ini</div></div>
            </div>
            <div class="d-flex align-items-center bg-body rounded border px-4 py-3 gap-3 flex-fill" style="min-width:130px">
                <div class="d-flex align-items-center justify-content-center w-40px h-40px rounded bg-light-info flex-shrink-0">
                    <i class="ki-outline ki-time fs-3 text-info"></i>
                </div>
                <div><div class="fs-2 fw-bold text-gray-900 lh-1">${scheduled}</div><div class="fs-8 text-muted fw-semibold mt-1">Scheduled</div></div>
            </div>
            <div class="d-flex align-items-center bg-body rounded border px-4 py-3 gap-3 flex-fill" style="min-width:130px">
                <div class="d-flex align-items-center justify-content-center w-40px h-40px rounded bg-light-warning flex-shrink-0">
                    <i class="ki-outline ki-arrows-circle fs-3 text-warning"></i>
                </div>
                <div><div class="fs-2 fw-bold text-gray-900 lh-1">${inprogress}</div><div class="fs-8 text-muted fw-semibold mt-1">In Progress</div></div>
            </div>
            <div class="d-flex align-items-center bg-body rounded border px-4 py-3 gap-3 flex-fill" style="min-width:130px">
                <div class="d-flex align-items-center justify-content-center w-40px h-40px rounded bg-light-success flex-shrink-0">
                    <i class="ki-outline ki-check-circle fs-3 text-success"></i>
                </div>
                <div><div class="fs-2 fw-bold text-gray-900 lh-1">${completed}</div><div class="fs-8 text-muted fw-semibold mt-1">Completed</div></div>
            </div>
            <div class="d-flex align-items-center bg-body rounded border px-4 py-3 gap-3 flex-fill" style="min-width:130px">
                <div class="d-flex align-items-center justify-content-center w-40px h-40px rounded bg-light-danger flex-shrink-0">
                    <i class="ki-outline ki-warning-2 fs-3 text-danger"></i>
                </div>
                <div><div class="fs-2 fw-bold text-gray-900 lh-1">${urgent}</div><div class="fs-8 text-muted fw-semibold mt-1">Urgent / STAT</div></div>
            </div>
            <div class="ms-auto d-none d-xl-flex align-items-center gap-2 align-self-center">
                <span class="text-muted fs-8">Update terakhir:</span>
                <span class="fw-bold fs-8 text-gray-700" id="last_updated_time">${new Date().toLocaleTimeString('id-ID')}</span>
            </div>
        `;

        document.getElementById('kpi-container').innerHTML = kpiHTML;
    }


    function getFiltered() {
        const date = document.getElementById('filter_date').value;
        const modality = document.getElementById('filter_modality').value;
        const status = document.getElementById('filter_status').value;
        const priority = document.getElementById('filter_priority').value;
        const q = document.getElementById('filter_search').value.toLowerCase().trim();

        let d = [...DATA];
        if (date) d = d.filter(x => x.scheduled_dt && x.scheduled_dt.startsWith(date));
        if (modality) d = d.filter(x => x.modality === modality);
        if (status) d = d.filter(x => x.status === status);
        if (priority) d = d.filter(x => x.priority === priority);
        if (q) d = d.filter(x =>
            x.patient_name.toLowerCase().includes(q) ||
            x.accession.toLowerCase().includes(q) ||
            x.patient_id.toLowerCase().includes(q)
        );

        d.sort((a, b) => {
            const da = new Date(a.scheduled_dt), db = new Date(b.scheduled_dt);
            return sortAsc ? da - db : db - da;
        });

        return d;
    }

    function applyFilter() {
        render(getFiltered());
    }


    function openDetail(accession) {
        const item = DATA.find(d => d.accession === accession);
        if (!item) return;

        document.getElementById('det_patient_name_title').textContent = item.patient_name;
        document.getElementById('det_accession_hdr').textContent = item.accession;
        document.getElementById('det_modality_hdr').textContent = item.modality;
        document.getElementById('det_status_hdr').innerHTML = statusBadge(item.status);
        document.getElementById('det_priority_hdr').innerHTML = priorityBadge(item.priority);

        document.getElementById('det_mwl_wrapper').innerHTML = item.mwl_generated
            ? `<div class="wl-mwl-ok mb-3"><i class="ki-outline ki-verify fs-6"></i>MWL File Generated (.wl)</div>`
            : `<div class="wl-mwl-pending mb-3"><i class="ki-outline ki-time fs-6"></i>MWL File Pending</div>`;

        document.getElementById('det_patient_name').textContent = item.patient_name;
        document.getElementById('det_patient_id').textContent = item.patient_id;
        document.getElementById('det_sex').textContent = item.sex === 'M' ? 'Laki-laki' : 'Perempuan';
        document.getElementById('det_dob').textContent = formatDateFull(item.dob);
        document.getElementById('det_accession').textContent = item.accession;
        document.getElementById('det_procedure').textContent = item.procedure;
        document.getElementById('det_clinical_info').textContent = item.clinical_info || '—';
        document.getElementById('det_modality_body').innerHTML = modalityBadge(item.modality);
        document.getElementById('det_priority_body').innerHTML = priorityBadge(item.priority);
        document.getElementById('det_scheduled_dt').textContent = formatDTText(item.scheduled_dt);
        document.getElementById('det_physician').textContent = item.physician;
        document.getElementById('det_ae_title').textContent = item.ae_title || '—';
        document.getElementById('det_step_id').textContent = item.step_id || '—';
        document.getElementById('det_study_uid').textContent = item.study_uid || 'Not Generated';
        document.getElementById('det_notes').innerHTML = item.notes && item.notes !== '—'
            ? `<span class="text-gray-700">${item.notes}</span>`
            : `<span class="text-muted fst-italic">No notes</span>`;

        document.getElementById('det_btn_delete').onclick = () => {
            document.getElementById('delete_accession').value = item.accession;
            document.getElementById('delete_acc_text').textContent = item.accession;
            hideModal('modal_detail');
            setTimeout(() => showModal('modal_delete_confirm'), 300);
        };

        showModal('modal_detail');
    }

    function openAdd() {
        document.getElementById('form_modal_title').textContent = 'Tambah Order Baru';
        document.getElementById('btn_save_label').textContent = 'Simpan Order';
        document.getElementById('form_order').reset();
        document.getElementById('inp_scheduled_date').value = TODAY;
        activeEditAccession = null;
        showModal('modal_form_order');
    }

    function confirmDelete(accession) {
        document.getElementById('delete_accession').value = accession;
        document.getElementById('delete_acc_text').textContent = accession;
        showModal('modal_delete_confirm');
    }

    function showModal(id) {
        const el = document.getElementById(id);
        if (!el) return;
        let m = bootstrap.Modal.getInstance(el);
        if (!m) m = new bootstrap.Modal(el);
        m.show();
    }

    function hideModal(id) {
        const el = document.getElementById(id);
        if (!el) return;
        const m = bootstrap.Modal.getInstance(el);
        if (m) m.hide();
    }


    function startTimer() {
        clearInterval(timer);
        countdown = refreshSec;
        const bar = document.getElementById('refresh_progress_bar');

        timer = setInterval(() => {
            countdown--;
            const pct = ((refreshSec - countdown) / refreshSec) * 100;
            bar.style.width = pct + '%';

            ['refresh_countdown','refresh_countdown2'].forEach(id => {
                const el = document.getElementById(id);
                if (el) el.textContent = countdown + 's';
            });

            if (countdown <= 0) {
                doRefresh();
                bar.style.transition = 'none';
                bar.style.width = '0%';
                setTimeout(() => { bar.style.transition = 'width 1s linear'; }, 50);
            }
        }, 1000);
    }

    function doRefresh() {
        countdown = refreshSec;
        loadOrdersFromAPI();
        toast('info', 'Data refreshed');
    }


    function toast(type, msg) {
        const colors = { success:'#2f9e44', danger:'#e03131', info:'#1c7ed6', warning:'#e67700' };
        const icons = { success:'ki-check-circle', danger:'ki-cross-circle', info:'ki-information', warning:'ki-warning-2' };
        const el = document.createElement('div');
        el.className = 'wl-toast';
        el.style.background = colors[type] || '#333';
        el.innerHTML = `<i class="ki-outline ${icons[type]||'ki-information'} fs-4"></i>${msg}`;
        document.body.appendChild(el);
        setTimeout(() => { el.style.transition = 'opacity .3s'; el.style.opacity = '0'; setTimeout(() => el.remove(), 350); }, 3500);
    }


    function init() {
        loadOrdersFromAPI();
        startTimer();

        ['filter_date','filter_modality','filter_status','filter_priority'].forEach(id => {
            document.getElementById(id)?.addEventListener('change', applyFilter);
        });

        let debounce;
        document.getElementById('filter_search')?.addEventListener('input', () => {
            clearTimeout(debounce);
            debounce = setTimeout(applyFilter, 350);
        });

        document.getElementById('btn_reset_filter')?.addEventListener('click', () => {
            document.getElementById('filter_date').value = TODAY;
            document.getElementById('filter_modality').value = '';
            document.getElementById('filter_status').value = '';
            document.getElementById('filter_priority').value = '';
            document.getElementById('filter_search').value = '';
            applyFilter();
        });

        document.getElementById('btn_sort_toggle')?.addEventListener('click', () => {
            sortAsc = !sortAsc;
            const icon = document.getElementById('sort_icon');
            icon.className = sortAsc
                ? 'ki-outline ki-arrow-up fs-7 me-1'
                : 'ki-outline ki-arrow-down fs-7 me-1';
            applyFilter();
        });

        document.getElementById('btn_add_order')?.addEventListener('click', openAdd);
        document.getElementById('btn_open_add_order')?.addEventListener('click', openAdd);

        document.getElementById('btn_save_order')?.addEventListener('click', createOrderViaAPI);

        document.getElementById('btn_confirm_delete')?.addEventListener('click', () => {
            const accession = document.getElementById('delete_accession').value;
            deleteOrderViaAPI(accession);
        });

        ['btn_manual_refresh','btn_refresh2'].forEach(id => {
            document.getElementById(id)?.addEventListener('click', doRefresh);
        });

        document.getElementById('inp_ae_title')?.addEventListener('input', function() {
            this.value = this.value.toUpperCase();
        });

        document.getElementById('inp_patient_name')?.addEventListener('input', function() {
            const pos = this.selectionStart;
            this.value = this.value.toUpperCase();
            this.setSelectionRange(pos, pos);
        });
    }


    return {
        init,
        openDetail,
        openAdd,
        confirmDelete,
        toast
    };

})();

document.addEventListener('DOMContentLoaded', () => WL.init());
</script>
@endpush