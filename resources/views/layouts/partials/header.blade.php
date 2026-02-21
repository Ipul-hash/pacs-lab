<!--begin::Header-->
<div id="kt_app_header" class="app-header"
    data-kt-sticky="true"
    data-kt-sticky-activate="{default: true, lg: true}"
    data-kt-sticky-name="app-header-minimize"
    data-kt-sticky-offset="{default: '200px', lg: '0'}"
    data-kt-sticky-animation="false">

    <!--begin::Header container-->
    <div class="app-container container-fluid d-flex align-items-stretch justify-content-between" id="kt_app_header_container">

        <!--begin::Sidebar mobile toggle-->
        <div class="d-flex align-items-center d-lg-none ms-n3 me-1 me-md-2" title="Show sidebar menu">
            <div class="btn btn-icon btn-active-color-primary w-35px h-35px" id="kt_app_sidebar_mobile_toggle">
                <i class="ki-outline ki-abstract-14 fs-2 fs-md-1"></i>
            </div>
        </div>
        <!--end::Sidebar mobile toggle-->

        <!--begin::Mobile logo-->
        <div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0">
            <a href="{{ route('dashboard') }}" class="d-lg-none text-decoration-none d-flex align-items-center gap-2">
                <div class="d-flex align-items-center justify-content-center bg-primary rounded w-30px h-30px">
                    <i class="ki-outline ki-pulse fs-4 text-white"></i>
                </div>
                <span class="fw-bold fs-5 text-gray-900">Radi<span class="text-primary">System</span></span>
            </a>
        </div>
        <!--end::Mobile logo-->

        <!--begin::Header wrapper-->
        <div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1" id="kt_app_header_wrapper">

            <!--begin::Worklist quick stats (desktop only)-->
            <div class="d-none d-lg-flex align-items-center gap-3 ms-5">
                <span class="badge badge-light-danger fw-bold px-3 py-2 fs-8 d-flex align-items-center gap-1" data-bs-toggle="tooltip" title="Studi Urgent">
                    <i class="ki-outline ki-warning-2 fs-8 text-danger"></i>
                    <span id="header_urgent_count">12</span> Urgent
                </span>
                <span class="badge badge-light-warning fw-bold px-3 py-2 fs-8 d-flex align-items-center gap-1" data-bs-toggle="tooltip" title="Studi Pending">
                    <i class="ki-outline ki-time fs-8 text-warning"></i>
                    <span id="header_pending_count">47</span> Pending
                </span>
                <span class="badge badge-light-success fw-bold px-3 py-2 fs-8 d-flex align-items-center gap-1" data-bs-toggle="tooltip" title="Selesai Hari Ini">
                    <i class="ki-outline ki-check-circle fs-8 text-success"></i>
                    <span>66</span> Selesai
                </span>
            </div>
            <!--end::Worklist quick stats-->

            <!--begin::Navbar-->
            <div class="app-navbar flex-shrink-0 ms-auto">

                <!--begin::Search-->
                <div class="app-navbar-item align-items-stretch ms-1 ms-md-4"
                    id="kt_header_search"
                    data-kt-search-keypress="true"
                    data-kt-search-min-length="2"
                    data-kt-search-enter="enter"
                    data-kt-search-layout="menu"
                    data-kt-menu-trigger="auto"
                    data-kt-menu-overflow="false"
                    data-kt-menu-permanent="true"
                    data-kt-menu-placement="bottom-end">
                    <!--begin::Search toggle-->
                    <div class="d-flex align-items-center" data-kt-search-element="toggle" id="kt_header_search_toggle">
                        <div class="btn btn-icon btn-custom btn-icon-muted btn-active-light btn-active-color-primary w-35px h-35px">
                            <i class="ki-outline ki-magnifier fs-2"></i>
                        </div>
                    </div>
                    <!--end::Search toggle-->
                    <!--begin::Search menu-->
                    <div data-kt-search-element="content" class="menu menu-sub menu-sub-dropdown p-7 w-325px w-md-375px">
                        <div data-kt-search-element="wrapper">
                            <form data-kt-search-element="form" class="w-100 position-relative mb-3" autocomplete="off">
                                <i class="ki-outline ki-magnifier fs-2 text-gray-500 position-absolute top-50 translate-middle-y ms-0"></i>
                                <input type="text" class="search-input form-control form-control-flush ps-10" name="search" placeholder="Cari pasien, studi, accession..." data-kt-search-element="input" />
                                <span class="search-spinner position-absolute top-50 end-0 translate-middle-y lh-0 d-none me-1" data-kt-search-element="spinner">
                                    <span class="spinner-border h-15px w-15px align-middle text-gray-500"></span>
                                </span>
                                <span class="search-reset btn btn-flush btn-active-color-primary position-absolute top-50 end-0 translate-middle-y lh-0 d-none" data-kt-search-element="clear">
                                    <i class="ki-outline ki-cross fs-2 me-0"></i>
                                </span>
                                <div class="position-absolute top-50 end-0 translate-middle-y" data-kt-search-element="toolbar">
                                    <div data-kt-search-element="preferences-show" class="btn btn-icon w-20px btn-sm btn-active-color-primary me-1" data-bs-toggle="tooltip" title="Preferensi Pencarian">
                                        <i class="ki-outline ki-setting-2 fs-2"></i>
                                    </div>
                                    <div data-kt-search-element="advanced-options-form-show" class="btn btn-icon w-20px btn-sm btn-active-color-primary" data-bs-toggle="tooltip" title="Opsi Lanjutan">
                                        <i class="ki-outline ki-down fs-2"></i>
                                    </div>
                                </div>
                            </form>
                            <div class="separator border-gray-200 mb-6"></div>
                            <!--begin::Results-->
                            <div data-kt-search-element="results" class="d-none">
                                <div class="scroll-y mh-200px mh-lg-350px">
                                    <h3 class="fs-5 text-muted m-0 pb-5" data-kt-search-element="category-title">Pasien</h3>
                                    <a href="#" class="d-flex text-gray-900 text-hover-primary align-items-center mb-5">
                                        <div class="symbol symbol-40px me-4">
                                            <span class="symbol-label bg-light-primary">
                                                <i class="ki-outline ki-user-square fs-4 text-primary"></i>
                                            </span>
                                        </div>
                                        <div class="d-flex flex-column justify-content-start fw-semibold">
                                            <span class="fs-6 fw-semibold">Budi Santoso</span>
                                            <span class="fs-7 fw-semibold text-muted">MRN-2024-001 &bull; CT Scan Kepala</span>
                                        </div>
                                    </a>
                                    <h3 class="fs-5 text-muted m-0 pb-5 pt-5">Studi</h3>
                                    <a href="#" class="d-flex text-gray-900 text-hover-primary align-items-center mb-5">
                                        <div class="symbol symbol-40px me-4">
                                            <span class="symbol-label bg-light-info">
                                                <i class="ki-outline ki-picture fs-4 text-info"></i>
                                            </span>
                                        </div>
                                        <div class="d-flex flex-column justify-content-start fw-semibold">
                                            <span class="fs-6 fw-semibold">ACC-20241119-001</span>
                                            <span class="fs-7 fw-semibold text-muted">CT &bull; Kepala Polos &bull; Pending</span>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <!--end::Results-->
                            <!--begin::Main (default)-->
                            <div data-kt-search-element="main">
                                <div class="d-flex flex-stack fw-semibold mb-4">
                                    <span class="text-muted fs-6 me-2">Pencarian Terbaru:</span>
                                </div>
                                <div class="scroll-y mh-200px mh-lg-325px">
                                    <div class="d-flex align-items-center mb-5">
                                        <div class="symbol symbol-40px me-4">
                                            <span class="symbol-label bg-light-danger">
                                                <i class="ki-outline ki-magnifier fs-4 text-danger"></i>
                                            </span>
                                        </div>
                                        <div class="fw-semibold">
                                            <a href="#" class="fs-6 text-gray-800 text-hover-primary">Agus Setiawan</a>
                                            <div class="text-muted fs-7">Nama Pasien</div>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center mb-5">
                                        <div class="symbol symbol-40px me-4">
                                            <span class="symbol-label bg-light-primary">
                                                <i class="ki-outline ki-magnifier fs-4 text-primary"></i>
                                            </span>
                                        </div>
                                        <div class="fw-semibold">
                                            <a href="#" class="fs-6 text-gray-800 text-hover-primary">ACC-20241119</a>
                                            <div class="text-muted fs-7">Accession No.</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Main (default)-->
                        </div>
                    </div>
                    <!--end::Search menu-->
                </div>
                <!--end::Search-->

                <!--begin::Activities drawer toggle-->
                <div class="app-navbar-item ms-1 ms-md-4">
                    <div class="btn btn-icon btn-custom btn-icon-muted btn-active-light btn-active-color-primary w-35px h-35px" id="kt_activities_toggle">
                        <i class="ki-outline ki-timer fs-2"></i>
                    </div>
                </div>
                <!--end::Activities-->

                <!--begin::Notifications-->
                <div class="app-navbar-item ms-1 ms-md-4">
                    <div class="btn btn-icon btn-custom btn-icon-muted btn-active-light btn-active-color-primary w-35px h-35px position-relative"
                        data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
                        data-kt-menu-attach="parent"
                        data-kt-menu-placement="bottom-end"
                        id="kt_menu_item_notifications">
                        <i class="ki-outline ki-notification-status fs-2"></i>
                        <span class="position-absolute top-0 end-0 w-6px h-6px bg-danger rounded-circle"
                            style="margin-top:4px;margin-right:4px;"></span>
                    </div>
                    <!--begin::Notifications dropdown-->
                    <div class="menu menu-sub menu-sub-dropdown menu-column w-350px w-lg-375px" data-kt-menu="true" id="kt_menu_notifications">
                        <!--begin::Heading-->
                        <div class="d-flex flex-column bgi-no-repeat rounded-top" style="background-color: #1B283F; padding: 24px 24px 0">
                            <h3 class="text-white fw-semibold mb-2 fs-5">Notifikasi
                                <span class="fs-8 opacity-75 ps-3">5 baru hari ini</span>
                            </h3>
                            <ul class="nav nav-line-tabs nav-line-tabs-2x nav-stretch fw-semibold">
                                <li class="nav-item">
                                    <a class="nav-link text-white opacity-75 opacity-state-100 pb-4 active" data-bs-toggle="tab" href="#kt_notif_alerts">Alerts</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-white opacity-75 opacity-state-100 pb-4" data-bs-toggle="tab" href="#kt_notif_updates">Updates</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-white opacity-75 opacity-state-100 pb-4" data-bs-toggle="tab" href="#kt_notif_logs">Logs</a>
                                </li>
                            </ul>
                        </div>
                        <!--end::Heading-->
                        <div class="tab-content">
                            <!--begin::Tab Alerts-->
                            <div class="tab-pane fade show active" id="kt_notif_alerts" role="tabpanel">
                                <div class="scroll-y mh-325px my-5 px-8">
                                    @php $alerts = [
                                        ['icon'=>'ki-pulse','bg'=>'danger','title'=>'CT STAT - Agus Setiawan','desc'=>'Suspek ICH — diperlukan segera','time'=>'5 mnt'],
                                        ['icon'=>'ki-warning-2','bg'=>'warning','title'=>'TAT hampir habis','desc'=>'MRI Brain - Dewi Rahayu','time'=>'12 mnt'],
                                        ['icon'=>'ki-information','bg'=>'danger','title'=>'Studi urgent belum dibaca','desc'=>'CT Angiografi Paru','time'=>'28 mnt'],
                                        ['icon'=>'ki-abstract-28','bg'=>'primary','title'=>'Pasien baru dari UGD','desc'=>'3 studi baru masuk worklist','time'=>'1 j'],
                                        ['icon'=>'ki-timer','bg'=>'info','title'=>'Shift radiolog berakhir','desc'=>'Dr. Hendra — 2 studi belum selesai','time'=>'2 j'],
                                    ]; @endphp
                                    @foreach($alerts as $alert)
                                    <div class="d-flex flex-stack py-4">
                                        <div class="d-flex align-items-center me-2">
                                            <div class="symbol symbol-35px me-4">
                                                <span class="symbol-label bg-light-{{ $alert['bg'] }}">
                                                    <i class="ki-outline {{ $alert['icon'] }} fs-2 text-{{ $alert['bg'] }}"></i>
                                                </span>
                                            </div>
                                            <div class="mb-0 me-2">
                                                <a href="#" class="fs-6 text-gray-800 text-hover-primary fw-bold">{{ $alert['title'] }}</a>
                                                <div class="text-gray-500 fs-7">{{ $alert['desc'] }}</div>
                                            </div>
                                        </div>
                                        <span class="badge badge-light fs-8 text-nowrap">{{ $alert['time'] }}</span>
                                    </div>
                                    @endforeach
                                </div>
                                <div class="py-3 text-center border-top">
                                    <a href="#" class="btn btn-color-gray-600 btn-active-color-primary">Lihat Semua <i class="ki-outline ki-arrow-right fs-5"></i></a>
                                </div>
                            </div>
                            <!--end::Tab Alerts-->
                            <!--begin::Tab Updates-->
                            <div class="tab-pane fade" id="kt_notif_updates" role="tabpanel">
                                <div class="d-flex flex-column px-9 py-10 text-center">
                                    <div class="symbol symbol-75px mx-auto mb-4">
                                        <span class="symbol-label bg-light-primary">
                                            <i class="ki-outline ki-check-circle fs-1 text-primary"></i>
                                        </span>
                                    </div>
                                    <h3 class="text-gray-900 fw-bold">Tidak Ada Pembaruan</h3>
                                    <div class="text-muted fw-semibold fs-7">Semua studi sudah terkini.</div>
                                </div>
                                <div class="py-3 text-center border-top">
                                    <a href="#" class="btn btn-color-gray-600 btn-active-color-primary">Lihat Semua <i class="ki-outline ki-arrow-right fs-5"></i></a>
                                </div>
                            </div>
                            <!--end::Tab Updates-->
                            <!--begin::Tab Logs-->
                            <div class="tab-pane fade" id="kt_notif_logs" role="tabpanel">
                                <div class="scroll-y mh-325px my-5 px-8">
                                    @php $logs = [
                                        ['status'=>'200 OK','color'=>'success','text'=>'Laporan dikirim ke PACS','time'=>'Baru saja'],
                                        ['status'=>'200 OK','color'=>'success','text'=>'Studi berhasil diimpor dari modality','time'=>'15 mnt'],
                                        ['status'=>'500 ERR','color'=>'danger','text'=>'Gagal sinkronisasi DICOM server','time'=>'1 j'],
                                        ['status'=>'300 WRN','color'=>'warning','text'=>'Timeout koneksi viewer','time'=>'2 j'],
                                        ['status'=>'200 OK','color'=>'success','text'=>'Backup database sukses','time'=>'3 j'],
                                    ]; @endphp
                                    @foreach($logs as $log)
                                    <div class="d-flex flex-stack py-4">
                                        <div class="d-flex align-items-center me-2 flex-grow-1">
                                            <span class="w-70px badge badge-light-{{ $log['color'] }} me-4 flex-shrink-0">{{ $log['status'] }}</span>
                                            <a href="#" class="text-gray-800 text-hover-primary fw-semibold fs-7">{{ $log['text'] }}</a>
                                        </div>
                                        <span class="badge badge-light fs-8 text-nowrap ms-2">{{ $log['time'] }}</span>
                                    </div>
                                    @endforeach
                                </div>
                                <div class="py-3 text-center border-top">
                                    <a href="#" class="btn btn-color-gray-600 btn-active-color-primary">Lihat Semua Log <i class="ki-outline ki-arrow-right fs-5"></i></a>
                                </div>
                            </div>
                            <!--end::Tab Logs-->
                        </div>
                    </div>
                    <!--end::Notifications dropdown-->
                </div>
                <!--end::Notifications-->

                <!--begin::Theme mode switcher-->
                <div class="app-navbar-item ms-1 ms-md-4">
                    <a href="#"
                        class="btn btn-icon btn-custom btn-icon-muted btn-active-light btn-active-color-primary w-35px h-35px"
                        data-kt-menu-trigger="{default:'click', lg: 'hover'}"
                        data-kt-menu-attach="parent"
                        data-kt-menu-placement="bottom-end">
                        <i class="ki-outline ki-night-day theme-light-show fs-1"></i>
                        <i class="ki-outline ki-moon theme-dark-show fs-1"></i>
                    </a>
                    <!--begin::Theme mode menu-->
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 menu-icon-gray-500 menu-active-bg menu-state-color fw-semibold py-4 fs-base w-150px"
                        data-kt-menu="true"
                        data-kt-element="theme-mode-menu">
                        <div class="menu-item px-3 my-0">
                            <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="light">
                                <span class="menu-icon" data-kt-element="icon">
                                    <i class="ki-outline ki-night-day fs-2"></i>
                                </span>
                                <span class="menu-title">Light</span>
                            </a>
                        </div>
                        <div class="menu-item px-3 my-0">
                            <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="dark">
                                <span class="menu-icon" data-kt-element="icon">
                                    <i class="ki-outline ki-moon fs-2"></i>
                                </span>
                                <span class="menu-title">Dark</span>
                            </a>
                        </div>
                        <div class="menu-item px-3 my-0">
                            <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="system">
                                <span class="menu-icon" data-kt-element="icon">
                                    <i class="ki-outline ki-screen fs-2"></i>
                                </span>
                                <span class="menu-title">System</span>
                            </a>
                        </div>
                    </div>
                    <!--end::Theme mode menu-->
                </div>
                <!--end::Theme mode switcher-->

                <!--begin::User menu-->
                <div class="app-navbar-item ms-1 ms-md-4" id="kt_header_user_menu_toggle">
                    <div class="cursor-pointer symbol symbol-35px"
                        data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
                        data-kt-menu-attach="parent"
                        data-kt-menu-placement="bottom-end">
                        <div class="symbol-label fs-2 fw-semibold bg-primary text-white rounded-3">
                            {{ auth()->check() ? strtoupper(substr(auth()->user()->name, 0, 1)) : 'A' }}
                        </div>
                    </div>
                    <!--begin::User dropdown-->
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px" data-kt-menu="true">
                        <!--begin::User info-->
                        <div class="menu-item px-3">
                            <div class="menu-content d-flex align-items-center px-3">
                                <div class="symbol symbol-50px me-5">
                                    <div class="symbol-label fs-2 fw-bold bg-primary text-white rounded-3">
                                        {{ auth()->check() ? strtoupper(substr(auth()->user()->name, 0, 1)) : 'A' }}
                                    </div>
                                </div>
                                <div class="d-flex flex-column">
                                    <div class="fw-bold d-flex align-items-center fs-5">
                                        {{ auth()->check() ? auth()->user()->name : 'Admin User' }}
                                        <span class="badge badge-light-success fw-bold fs-8 px-2 py-1 ms-2">Radiolog</span>
                                    </div>
                                    <a href="#" class="fw-semibold text-muted text-hover-primary fs-7">
                                        {{ auth()->check() ? auth()->user()->email : 'admin@radisystem.com' }}
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!--end::User info-->
                        <div class="separator my-2"></div>
                        <div class="menu-item px-5">
                            <a href="#" class="menu-link px-5">Profil Saya</a>
                        </div>
                        <div class="menu-item px-5">
                            <a href="#" class="menu-link px-5">
                                <span class="menu-text">My Assignments</span>
                                <span class="menu-badge">
                                    <span class="badge badge-light-primary badge-circle fw-bold fs-7">8</span>
                                </span>
                            </a>
                        </div>
                        <!--begin::Tema nested submenu-->
                        <div class="menu-item px-5"
                            data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
                            data-kt-menu-placement="left-start"
                            data-kt-menu-offset="-15px, 0">
                            <a href="#" class="menu-link px-5">
                                <span class="menu-title position-relative">Tema
                                    <span class="ms-5 position-absolute translate-middle-y top-50 end-0">
                                        <i class="ki-outline ki-night-day theme-light-show fs-2"></i>
                                        <i class="ki-outline ki-moon theme-dark-show fs-2"></i>
                                    </span>
                                </span>
                            </a>
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 menu-icon-gray-500 menu-active-bg menu-state-color fw-semibold py-4 fs-base w-150px"
                                data-kt-menu="true"
                                data-kt-element="theme-mode-menu">
                                <div class="menu-item px-3 my-0">
                                    <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="light">
                                        <span class="menu-icon" data-kt-element="icon"><i class="ki-outline ki-night-day fs-2"></i></span>
                                        <span class="menu-title">Light</span>
                                    </a>
                                </div>
                                <div class="menu-item px-3 my-0">
                                    <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="dark">
                                        <span class="menu-icon" data-kt-element="icon"><i class="ki-outline ki-moon fs-2"></i></span>
                                        <span class="menu-title">Dark</span>
                                    </a>
                                </div>
                                <div class="menu-item px-3 my-0">
                                    <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="system">
                                        <span class="menu-icon" data-kt-element="icon"><i class="ki-outline ki-screen fs-2"></i></span>
                                        <span class="menu-title">System</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!--end::Tema nested submenu-->
                        <div class="separator my-2"></div>
                        <div class="menu-item px-5 my-1">
                            <a href="#" class="menu-link px-5">Pengaturan Akun</a>
                        </div>
                        <div class="menu-item px-5">
                            <a href="#" class="menu-link px-5"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Keluar</a>
                            <form id="logout-form" action="#" method="POST" class="d-none">@csrf</form>
                        </div>
                    </div>
                    <!--end::User dropdown-->
                </div>
                <!--end::User menu-->

                <!--begin::Header menu toggle (mobile)-->
                <div class="app-navbar-item d-lg-none ms-2 me-n2" title="Show header menu">
                    <div class="btn btn-flex btn-icon btn-active-color-primary w-30px h-30px" id="kt_app_header_menu_toggle">
                        <i class="ki-outline ki-element-4 fs-1"></i>
                    </div>
                </div>
                <!--end::Header menu toggle-->

            </div>
            <!--end::Navbar-->
        </div>
        <!--end::Header wrapper-->
    </div>
    <!--end::Header container-->
</div>
<!--end::Header-->

<!--begin::Activities drawer-->
<div id="kt_activities"
    class="bg-body"
    data-kt-drawer="true"
    data-kt-drawer-name="activities"
    data-kt-drawer-activate="true"
    data-kt-drawer-overlay="true"
    data-kt-drawer-width="{default:'300px', 'lg': '500px'}"
    data-kt-drawer-direction="end"
    data-kt-drawer-toggle="#kt_activities_toggle"
    data-kt-drawer-close="#kt_activities_close">
    <div class="card shadow-none border-0 rounded-0 h-100">
        <div class="card-header" id="kt_activities_header">
            <h3 class="card-title fw-bold text-gray-900">Log Aktivitas Sistem</h3>
            <div class="card-toolbar">
                <button type="button" class="btn btn-sm btn-icon btn-active-light-primary me-n5" id="kt_activities_close">
                    <i class="ki-outline ki-cross fs-1"></i>
                </button>
            </div>
        </div>
        <div class="card-body position-relative" id="kt_activities_body">
            <div id="kt_activities_scroll"
                class="position-relative scroll-y me-n5 pe-5"
                data-kt-scroll="true"
                data-kt-scroll-height="auto"
                data-kt-scroll-wrappers="#kt_activities_body"
                data-kt-scroll-dependencies="#kt_activities_header, #kt_activities_footer"
                data-kt-scroll-offset="5px">
                <div class="timeline timeline-border-dashed">
                    @php $activityFeed = [
                        ['time'=>'10:01','color'=>'success','icon'=>'ki-check-circle','title'=>'Laporan Selesai Dikirim','desc'=>'CT Kepala - Agus Santoso','user'=>'Dr. Hendra'],
                        ['time'=>'09:58','color'=>'primary','icon'=>'ki-eye','title'=>'Studi Dibuka di Viewer','desc'=>'MRI Lumbar - Eko Prasetyo','user'=>'Dr. Sinta'],
                        ['time'=>'09:45','color'=>'danger','icon'=>'ki-warning-2','title'=>'Studi Ditandai URGENT','desc'=>'CT Angio Paru - Dewi Rahayu','user'=>'Dr. Bowo'],
                        ['time'=>'09:30','color'=>'info','icon'=>'ki-abstract-26','title'=>'Studi Baru Masuk Worklist','desc'=>'X-Ray Thorax - Fitri Handayani','user'=>'Sistem'],
                        ['time'=>'09:15','color'=>'warning','icon'=>'ki-user-tick','title'=>'Assignment Diubah','desc'=>'USG Abdomen - Rina Marlina','user'=>'Admin'],
                        ['time'=>'08:45','color'=>'success','icon'=>'ki-check-circle','title'=>'Laporan Diverifikasi','desc'=>'MRI Brain - Sari Dewi','user'=>'Dr. Hendra'],
                        ['time'=>'08:20','color'=>'primary','icon'=>'ki-abstract-26','title'=>'CT Scan Selesai Diakuisisi','desc'=>'CT Thorax - Budi Santoso','user'=>'Teknisi'],
                        ['time'=>'07:55','color'=>'info','icon'=>'ki-people','title'=>'Radiolog Login','desc'=>'Dr. Hendra telah masuk sistem','user'=>'Sistem'],
                    ]; @endphp
                    @foreach($activityFeed as $act)
                    <div class="timeline-item">
                        <div class="timeline-line w-40px"></div>
                        <div class="timeline-icon symbol symbol-circle symbol-40px me-4">
                            <div class="symbol-label bg-light-{{ $act['color'] }}">
                                <i class="ki-outline {{ $act['icon'] }} fs-2 text-{{ $act['color'] }}"></i>
                            </div>
                        </div>
                        <div class="timeline-content mb-10 mt-n1">
                            <div class="pe-3 mb-5">
                                <div class="fs-5 fw-semibold mb-2">{{ $act['title'] }}</div>
                                <div class="text-muted fs-7">{{ $act['desc'] }}</div>
                                <div class="text-muted fs-8 mt-1">oleh <strong>{{ $act['user'] }}</strong> &bull; {{ $act['time'] }}</div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="card-footer py-5 text-center" id="kt_activities_footer">
            <a href="#" class="btn btn-bg-body text-primary">
                Lihat Semua Aktivitas
                <i class="ki-outline ki-arrow-right fs-3 text-primary"></i>
            </a>
        </div>
    </div>
</div>
<!--end::Activities drawer-->