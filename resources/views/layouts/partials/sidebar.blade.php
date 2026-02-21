<!--begin::Sidebar-->
<div id="kt_app_sidebar" class="app-sidebar flex-column"
    data-kt-drawer="true"
    data-kt-drawer-name="app-sidebar"
    data-kt-drawer-activate="{default: true, lg: false}"
    data-kt-drawer-overlay="true"
    data-kt-drawer-width="225px"
    data-kt-drawer-direction="start"
    data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">

    <!--begin::Logo-->
    <div class="app-sidebar-logo px-6" id="kt_app_sidebar_logo">
        <!--begin::Logo-->
        <a href="{{ route('dashboard') }}" class="d-flex align-items-center gap-2 text-decoration-none">
            <div class="d-flex align-items-center justify-content-center bg-primary rounded w-35px h-35px flex-shrink-0 app-sidebar-logo-default">
                <i class="ki-outline ki-pulse fs-3 text-white"></i>
            </div>
            <span class="fw-bold fs-4 text-gray-900 app-sidebar-logo-default">PACS<span class="text-primary">System</span></span>
            
        </a>
        <!--end::Logo-->

        <!--begin::Sidebar toggle-->
        <div id="kt_app_sidebar_toggle"
            class="app-sidebar-toggle btn btn-icon btn-shadow btn-sm btn-color-muted btn-active-color-primary h-30px w-30px position-absolute top-50 start-100 translate-middle rotate"
            data-kt-toggle="true"
            data-kt-toggle-state="active"
            data-kt-toggle-target="body"
            data-kt-toggle-name="app-sidebar-minimize">
            <i class="ki-outline ki-black-left-line fs-3 rotate-180"></i>
        </div>
        <!--end::Sidebar toggle-->
    </div>
    <!--end::Logo-->

    <!--begin::Sidebar menu-->
    <div class="app-sidebar-menu overflow-hidden flex-column-fluid">
        <div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper">
            <div id="kt_app_sidebar_menu_scroll"
                class="scroll-y my-5 mx-3"
                data-kt-scroll="true"
                data-kt-scroll-activate="true"
                data-kt-scroll-height="auto"
                data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer"
                data-kt-scroll-wrappers="#kt_app_sidebar_menu"
                data-kt-scroll-offset="5px"
                data-kt-scroll-save-state="true">

                <!--begin::Menu-->
                <div class="menu menu-column menu-rounded menu-sub-indention fw-semibold fs-6"
                    id="kt_app_sidebar_menu"
                    data-kt-menu="true"
                    data-kt-menu-expand="false">

                    <!--begin::Menu separator-->
                    <div class="menu-item pt-5">
                        <div class="menu-content">
                            <span class="menu-heading fw-bold text-uppercase fs-7 text-muted ls-1">Utama</span>
                        </div>
                    </div>
                    <!--end::Menu separator-->

                    <!--begin::Dashboard-->
                    <div class="menu-item">
                        <a class="menu-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                            href="{{ route('dashboard') }}">
                            <span class="menu-icon">
                                <i class="ki-outline ki-element-11 fs-2"></i>
                            </span>
                            <span class="menu-title">Dashboard</span>
                        </a>
                    </div>
                    <!--end::Dashboard-->

                    <!--begin::Worklist-->
                    <div class="menu-item">
                        <a class="menu-link {{ request()->routeIs('worklist*') ? 'active' : '' }}"
                            href="#">
                            <span class="menu-icon">
                                <i class="ki-outline ki-abstract-26 fs-2"></i>
                            </span>
                            <span class="menu-title">Worklist</span>
                            <span class="menu-badge">
                                <span class="badge badge-light-danger badge-circle fw-bold fs-7" id="sidebar_urgent_badge">12</span>
                            </span>
                        </a>
                    </div>
                    <!--end::Worklist-->

                    <!--begin::Studies-->
                    <div class="menu-item">
                        <a class="menu-link {{ request()->routeIs('studies*') ? 'active' : '' }}"
                            href="#">
                            <span class="menu-icon">
                                <i class="ki-outline ki-picture fs-2"></i>
                            </span>
                            <span class="menu-title">Studies</span>
                        </a>
                    </div>
                    <!--end::Studies-->

                    <!--begin::Patients-->
                    <div class="menu-item">
                        <a class="menu-link {{ request()->routeIs('patients*') ? 'active' : '' }}"
                            href="#">
                            <span class="menu-icon">
                                <i class="ki-outline ki-user-square fs-2"></i>
                            </span>
                            <span class="menu-title">Patients</span>
                        </a>
                    </div>
                    <!--end::Patients-->

                    <!--begin::Reports-->
                    <div class="menu-item">
                        <a class="menu-link {{ request()->routeIs('reports*') ? 'active' : '' }}"
                            href="#">
                            <span class="menu-icon">
                                <i class="ki-outline ki-document fs-2"></i>
                            </span>
                            <span class="menu-title">Reports</span>
                        </a>
                    </div>
                    <!--end::Reports-->

                    <!--begin::Menu separator-->
                    <div class="menu-item pt-5">
                        <div class="menu-content">
                            <span class="menu-heading fw-bold text-uppercase fs-7 text-muted ls-1">Administrasi</span>
                        </div>
                    </div>
                    <!--end::Menu separator-->

                    <!--begin::Users-->
                    <div class="menu-item">
                        <a class="menu-link {{ request()->routeIs('users*') ? 'active' : '' }}"
                            href="#">
                            <span class="menu-icon">
                                <i class="ki-outline ki-people fs-2"></i>
                            </span>
                            <span class="menu-title">Users</span>
                        </a>
                    </div>
                    <!--end::Users-->

                    <!--begin::Settings-->
                    <div class="menu-item">
                        <a class="menu-link {{ request()->routeIs('settings*') ? 'active' : '' }}"
                        href="#">
                            <span class="menu-icon">
                                <i class="ki-outline ki-setting-2 fs-2"></i>
                            </span>
                            <span class="menu-title">Settings</span>
                        </a>
                    </div>
                    <!--end::Settings-->

                </div>
                <!--end::Menu-->

            </div>
        </div>
    </div>
    <!--end::Sidebar menu-->

    <!--begin::Sidebar footer-->
    <div class="app-sidebar-footer flex-column-auto pt-2 pb-6 px-6" id="kt_app_sidebar_footer">
        <!--begin::User quick info-->
        <div class="d-flex align-items-center gap-2 gap-lg-3">
            <div class="symbol symbol-35px">
                <div class="symbol-label fs-4 fw-semibold bg-primary text-white">
                    {{ auth()->check() ? strtoupper(substr(auth()->user()->name, 0, 1)) : 'A' }}
                </div>
            </div>
            <div class="d-flex flex-column app-sidebar-logo-default overflow-hidden">
                <span class="fw-semibold text-gray-900 fs-7 text-truncate">
                    {{ auth()->check() ? auth()->user()->name : 'Admin User' }}
                </span>
                <span class="text-muted fs-8 text-truncate">
                    {{ auth()->check() ? auth()->user()->email : 'admin@radisystem.com' }}
                </span>
            </div>
        </div>
        <!--end::User quick info-->
    </div>
    <!--end::Sidebar footer-->

</div>
<!--end::Sidebar-->