@php
$segments = request()->segments();
@endphp
<div id="kt_app_header" class="app-header" style="border-bottom: 1px solid #E4E7F0;">
    <!--begin::Header primary-->
    <div class="app-header-primary" data-kt-sticky="true" data-kt-sticky-name="app-header-primary-sticky"
        data-kt-sticky-offset="{default: 'false', lg: '300px'}">
        <!--begin::Header primary container-->
        <div class="app-container container-xxl d-flex align-items-stretch justify-content-between">
            <!--begin::Logo and search-->
            <div class="d-flex flex-grow-1 flex-lg-grow-0">
                <!--begin::Logo wrapper-->
                <div class="d-flex align-items-center" id="kt_app_header_logo_wrapper">
                    <!--begin::Header toggle-->
                    <button
                        class="d-lg-none btn btn-icon btn-flex btn-color-gray-600 btn-active-color-primary w-35px h-35px ms-n2 me-2"
                        id="kt_app_header_menu_toggle">
                        <i class="ki-outline ki-abstract-14 fs-2"></i>
                    </button>
                    <!--end::Header toggle-->
                    <!--begin::Logo-->
                    <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center me-lg-20 me-5">
                        <img alt="Logo" src="{{ asset('admin_assets/logos/locksmith.png') }}"
                            style="height: 65px;" class="d-sm-none d-inline" />
                        <img alt="Logo" src="{{ asset('admin_assets/logos/locksmith.png') }}"
                            style="height: 65px;" class="theme-light-show d-none d-sm-inline" />

                    </a>
                    <!--end::Logo-->
                </div>
                <!--end::Logo wrapper-->
                <!--begin::Menu wrapper-->
                <div class="app-header-menu app-header-mobile-drawer align-items-stretch" data-kt-drawer="true"
                    data-kt-drawer-name="app-header-menu" data-kt-drawer-activate="{default: true, lg: false}"
                    data-kt-drawer-overlay="true" data-kt-drawer-width="250px" data-kt-drawer-direction="start"
                    data-kt-drawer-toggle="#kt_app_header_menu_toggle" data-kt-swapper="true"
                    data-kt-swapper-mode="{default: 'append', lg: 'prepend'}"
                    data-kt-swapper-parent="{default: '#kt_app_body', lg: '#kt_app_header_wrapper'}">
                    <!--begin::Menu-->
                    <div class="menu menu-rounded menu-active-bg menu-state-primary menu-column menu-lg-row menu-title-gray-700 menu-icon-gray-500 menu-arrow-gray-500 menu-bullet-gray-500 my-5 my-lg-0 align-items-stretch fw-semibold px-2 px-lg-0"
                        id="kt_app_header_menu" data-kt-menu="true">
                        <div
                            class="menu-item menu-lg-down-accordion me-0 me-lg-2 {{ @$segments[0] == '' ? 'here' : '' }}">
                            <a class="menu-link py-3" href="{{ route('admin.dashboard') }}">
                                <span class="menu-title"> Dashboards</span>
                            </a>
                        </div>
                        @can('manage users')
                        <div
                            class="menu-item menu-lg-down-accordion me-0 me-lg-2 {{ @$segments[0] == 'app-user' ? 'here' : '' }}">
                            <a class="menu-link py-3" href="{{ route('app.user') }}">
                                <span class="menu-title">Users</span>
                            </a>
                        </div>
                        @endcan
                        @can('manage banners')
                        <div
                            class="menu-item menu-lg-down-accordion me-0 me-lg-2 {{ @$segments[0] == 'banner' ? 'here' : '' }}">
                            <a class="menu-link py-3" href="{{ route('banner') }}">
                                <span class="menu-title">Banners</span>
                            </a>
                        </div>
                        @endcan
                        @can('manage categories')
                        <div
                            class="menu-item menu-lg-down-accordion me-0 me-lg-2 {{ @$segments[0] == 'category' ? 'here' : '' }}">
                            <a class="menu-link py-3" href="{{ route('category') }}">
                                <span class="menu-title">Categories</span>
                            </a>
                        </div>
                        @endcan
                        @can('manage services')
                        <div
                            class="menu-item menu-lg-down-accordion me-0 me-lg-2 {{ @$segments[0] == 'service' ? 'here' : '' }}">
                            <a class="menu-link py-3" href="{{ route('service') }}">
                                <span class="menu-title">Services</span>
                            </a>
                        </div>
                        @endcan
                        @can('manage workers')
                        <div
                            class="menu-item menu-lg-down-accordion me-0 me-lg-2 {{ @$segments[0] == 'worker' ? 'here' : '' }}">
                            <a class="menu-link py-3" href="{{ route('worker') }}">
                                <span class="menu-title">Workers</span>
                            </a>
                        </div>
                        @endcan
                        @can('manage bookings')
                        <div
                            class="menu-item menu-lg-down-accordion me-0 me-lg-2 {{ @$segments[0] == 'booking' ? 'here' : '' }}">
                            <a class="menu-link py-3" href="{{ route('booking') }}">
                                <span class="menu-title">Bookings</span>
                            </a>
                        </div>
                        @endcan
                        <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
                            data-kt-menu-placement="bottom-start"
                            class="menu-item menu-lg-down-accordion menu-sub-lg-down-indention me-0 me-lg-2">
                            <span class="menu-link py-3">
                                <span class="menu-title">Nexus</span>
                                <span class="menu-arrow d-lg-none"></span>
                            </span>

                            <div
                                class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown px-lg-2 py-lg-4 w-lg-200px">
                                @if (auth()->user()->can('manage users') || auth()->user()->can('manage roles'))
                                <div data-kt-menu-trigger="{default:'click', lg: 'hover'}"
                                    data-kt-menu-placement="right-start" class="menu-item menu-lg-down-accordion">
                                    <!--begin:Menu link-->
                                    <span class="menu-link py-3">
                                        <span class="menu-icon">
                                            <i class="ki-outline ki-people fs-2"></i>
                                        </span>
                                        <span class="menu-title">User Management</span>
                                        <span class="menu-arrow"></span>
                                    </span>
                                    <!--end:Menu link-->
                                    <!--begin:Menu sub-->
                                    <div
                                        class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown menu-active-bg px-lg-2 py-lg-4 w-lg-225px">
                                        <!--begin:Menu item-->
                                        @can('manage users')
                                        <div class="menu-item">
                                            <!--begin:Menu link-->
                                            <a class="menu-link py-3" href="{{ route('admin.users') }}"
                                                data-bs-trigger="hover" data-bs-dismiss="click"
                                                data-bs-placement="right">
                                                <span class="menu-bullet">
                                                    <span class="ki-outline ki-user-square fs-2"></span>
                                                </span>
                                                <span class="menu-title">Users</span>
                                            </a>
                                            <!--end:Menu link-->
                                        </div>
                                        @endcan
                                        @can('manage roles')
                                        <div class="menu-item">
                                            <!--begin:Menu link-->
                                            <a class="menu-link py-3" href="{{ route('admin.roles') }}"
                                                data-bs-trigger="hover" data-bs-dismiss="click"
                                                data-bs-placement="right">
                                                <span class="menu-bullet">
                                                    <span class="ki-outline ki-key fs-2"></span>
                                                </span>
                                                <span class="menu-title">Role & Permissions</span>
                                            </a>
                                            <!--end:Menu link-->
                                        </div>
                                        @endcan
                                    </div>
                                </div>
                                @endif
                                @can('manage settings')
                                <div class="menu-item">
                                    <a class="menu-link py-3" href="{{ route('admin.settings') }}"
                                        data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                                        <span class="menu-icon">
                                            <i class="ki-outline ki-setting-2 fs-2"></i>
                                        </span>
                                        <span class="menu-title">Settings</span>
                                    </a>
                                </div>
                                @endcan

                                @can('manage transactions')
                                <div class="menu-item">
                                    <a class="menu-link py-3" href="{{ route('admin.transactions') }}"
                                        data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                                        <span class="menu-icon">
                                            <i class="ki-outline ki-dollar fs-2"></i>
                                        </span>
                                        <span class="menu-title">Transactions</span>
                                    </a>
                                </div>
                                @endcan
                                @can('manage gift cards')
                                <div class="menu-item">
                                    <a class="menu-link py-3" href="{{ route('admin.gift.cards') }}"
                                        data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                                        <span class="menu-icon">
                                            <i class="ki-outline ki-gift fs-2"></i>
                                        </span>
                                        <span class="menu-title">Gift Cards</span>
                                    </a>
                                </div>
                                @endcan
                                @can('manage discounts')
                                <div class="menu-item">
                                    <a class="menu-link py-3" href="{{ route('admin.discount.codes') }}"
                                        data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                                        <span class="menu-icon">
                                            <i class="ki-outline ki-discount fs-2"></i>
                                        </span>
                                        <span class="menu-title">Discounts</span>
                                    </a>
                                </div>
                                @endcan
                                @can('manage plans')
                                <div class="menu-item">
                                    <a class="menu-link py-3" href="{{ route('admin.plans') }}"
                                        data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                                        <span class="menu-icon">
                                            <i class="ki-outline ki-shop fs-2"></i>
                                        </span>
                                        <span class="menu-title">Plans</span>
                                    </a>
                                </div>
                                @endcan
                            </div>
                        </div>
                        @can('manage meals')
                        <div
                            class="menu-item menu-lg-down-accordion me-0 me-lg-2 {{ @$segments[0] == 'meals' ? 'here' : '' }}">
                            <a class="menu-link py-3" href="{{ route('admin.meals') }}">
                                <span class="menu-title">Meals</span>
                            </a>
                        </div>
                        @endcan
                        @can('manage menu')
                        <div
                            class="menu-item menu-lg-down-accordion me-0 me-lg-2 {{ @$segments[0] == 'menus' ? 'here' : '' }}">
                            <a class="menu-link py-3" href="{{ route('admin.menus') }}">
                                <span class="menu-title">Menu + Orders</span>
                            </a>
                        </div>
                        @endcan
                        @can('manage customers')
                        <div
                            class="menu-item menu-lg-down-accordion me-0 me-lg-2 {{ @$segments[0] == 'customers' ? 'here' : '' }}">
                            <a class="menu-link py-3" href="{{ route('admin.customers') }}">
                                <span class="menu-title">Customers</span>
                            </a>
                        </div>
                        @endcan
                    </div>
                    <!--end::Menu-->
                </div>
                <!--end::Menu wrapper-->
            </div>
            <!--end::Logo and search-->
            <!--begin::Navbar-->
            <div class="app-navbar flex-shrink-0">
                <div class="app-navbar-item">
                    <!--begin::Menu- wrapper-->
                    <div class="btn btn-icon btn-icon-gray-600 btn-active-color-primary"
                        data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent"
                        data-kt-menu-placement="bottom">
                        <i class="ki-outline ki-notification-on fs-1"></i>
                    </div>
                    <!--begin::Menu-->
                    <div class="menu menu-sub menu-sub-dropdown menu-column w-350px w-lg-375px" data-kt-menu="true"
                        id="kt_menu_notifications">
                        <!--begin::Heading-->
                        <div class="d-flex flex-column bgi-no-repeat rounded-top"
                            style="background-image:url('{{ asset('admin_assets/media/misc/menu-header-bg.jpg') }}')">
                            <!--begin::Title-->
                            <h3 class="text-white fw-semibold px-9 mt-10 mb-6">Notifications
                                <span class="fs-8 opacity-75 ps-3">24 reports</span>
                            </h3>
                            <!--end::Title-->
                            <!--begin::Tabs-->
                            <ul class="nav nav-line-tabs nav-line-tabs-2x nav-stretch fw-semibold px-9">
                                <li class="nav-item">
                                    <a class="nav-link text-white opacity-75 opacity-state-100 pb-4"
                                        data-bs-toggle="tab" href="#kt_topbar_notifications_1">Alerts</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-white opacity-75 opacity-state-100 pb-4 active"
                                        data-bs-toggle="tab" href="#kt_topbar_notifications_2">Updates</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-white opacity-75 opacity-state-100 pb-4"
                                        data-bs-toggle="tab" href="#kt_topbar_notifications_3">Logs</a>
                                </li>
                            </ul>
                            <!--end::Tabs-->
                        </div>
                        <!--end::Heading-->
                        <!--begin::Tab content-->
                        <div class="tab-content">
                            <!--begin::Tab panel-->
                            <div class="tab-pane fade" id="kt_topbar_notifications_1" role="tabpanel">
                                <!--begin::Items-->
                                <div class="scroll-y mh-325px my-5 px-8">
                                    <!--begin::Item-->
                                    <div class="d-flex flex-stack py-4">
                                        <!--begin::Section-->
                                        <div class="d-flex align-items-center">
                                            <!--begin::Symbol-->
                                            <div class="symbol symbol-35px me-4">
                                                <span class="symbol-label bg-light-primary">
                                                    <i class="ki-outline ki-abstract-28 fs-2 text-primary"></i>
                                                </span>
                                            </div>
                                            <!--end::Symbol-->
                                            <!--begin::Title-->
                                            <div class="mb-0 me-2">
                                                <a href="#"
                                                    class="fs-6 text-gray-800 text-hover-primary fw-bold">Project
                                                    Alice</a>
                                                <div class="text-gray-400 fs-7">Phase 1 development</div>
                                            </div>
                                            <!--end::Title-->
                                        </div>
                                        <!--end::Section-->
                                        <!--begin::Label-->
                                        <span class="badge badge-light fs-8">1 hr</span>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Item-->
                                    <!--begin::Item-->
                                    <div class="d-flex flex-stack py-4">
                                        <!--begin::Section-->
                                        <div class="d-flex align-items-center">
                                            <!--begin::Symbol-->
                                            <div class="symbol symbol-35px me-4">
                                                <span class="symbol-label bg-light-danger">
                                                    <i class="ki-outline ki-information fs-2 text-danger"></i>
                                                </span>
                                            </div>
                                            <!--end::Symbol-->
                                            <!--begin::Title-->
                                            <div class="mb-0 me-2">
                                                <a href="#"
                                                    class="fs-6 text-gray-800 text-hover-primary fw-bold">HR
                                                    Confidential</a>
                                                <div class="text-gray-400 fs-7">Confidential staff documents</div>
                                            </div>
                                            <!--end::Title-->
                                        </div>
                                        <!--end::Section-->
                                        <!--begin::Label-->
                                        <span class="badge badge-light fs-8">2 hrs</span>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Item-->
                                    <!--begin::Item-->
                                    <div class="d-flex flex-stack py-4">
                                        <!--begin::Section-->
                                        <div class="d-flex align-items-center">
                                            <!--begin::Symbol-->
                                            <div class="symbol symbol-35px me-4">
                                                <span class="symbol-label bg-light-warning">
                                                    <i class="ki-outline ki-briefcase fs-2 text-warning"></i>
                                                </span>
                                            </div>
                                            <!--end::Symbol-->
                                            <!--begin::Title-->
                                            <div class="mb-0 me-2">
                                                <a href="#"
                                                    class="fs-6 text-gray-800 text-hover-primary fw-bold">Company
                                                    HR</a>
                                                <div class="text-gray-400 fs-7">Corporeate staff profiles</div>
                                            </div>
                                            <!--end::Title-->
                                        </div>
                                        <!--end::Section-->
                                        <!--begin::Label-->
                                        <span class="badge badge-light fs-8">5 hrs</span>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Item-->
                                    <!--begin::Item-->
                                    <div class="d-flex flex-stack py-4">
                                        <!--begin::Section-->
                                        <div class="d-flex align-items-center">
                                            <!--begin::Symbol-->
                                            <div class="symbol symbol-35px me-4">
                                                <span class="symbol-label bg-light-success">
                                                    <i class="ki-outline ki-abstract-12 fs-2 text-success"></i>
                                                </span>
                                            </div>
                                            <!--end::Symbol-->
                                            <!--begin::Title-->
                                            <div class="mb-0 me-2">
                                                <a href="#"
                                                    class="fs-6 text-gray-800 text-hover-primary fw-bold">Project
                                                    Redux</a>
                                                <div class="text-gray-400 fs-7">New frontend admin theme</div>
                                            </div>
                                            <!--end::Title-->
                                        </div>
                                        <!--end::Section-->
                                        <!--begin::Label-->
                                        <span class="badge badge-light fs-8">2 days</span>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Item-->
                                    <!--begin::Item-->
                                    <div class="d-flex flex-stack py-4">
                                        <!--begin::Section-->
                                        <div class="d-flex align-items-center">
                                            <!--begin::Symbol-->
                                            <div class="symbol symbol-35px me-4">
                                                <span class="symbol-label bg-light-primary">
                                                    <i class="ki-outline ki-colors-square fs-2 text-primary"></i>
                                                </span>
                                            </div>
                                            <!--end::Symbol-->
                                            <!--begin::Title-->
                                            <div class="mb-0 me-2">
                                                <a href="#"
                                                    class="fs-6 text-gray-800 text-hover-primary fw-bold">Project
                                                    Breafing</a>
                                                <div class="text-gray-400 fs-7">Product launch status update</div>
                                            </div>
                                            <!--end::Title-->
                                        </div>
                                        <!--end::Section-->
                                        <!--begin::Label-->
                                        <span class="badge badge-light fs-8">21 Jan</span>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Item-->
                                    <!--begin::Item-->
                                    <div class="d-flex flex-stack py-4">
                                        <!--begin::Section-->
                                        <div class="d-flex align-items-center">
                                            <!--begin::Symbol-->
                                            <div class="symbol symbol-35px me-4">
                                                <span class="symbol-label bg-light-info">
                                                    <i class="ki-outline ki-picture fs-2 text-info"></i>
                                                </span>
                                            </div>
                                            <!--end::Symbol-->
                                            <!--begin::Title-->
                                            <div class="mb-0 me-2">
                                                <a href="#"
                                                    class="fs-6 text-gray-800 text-hover-primary fw-bold">Banner
                                                    Assets</a>
                                                <div class="text-gray-400 fs-7">Collection of banner images</div>
                                            </div>
                                            <!--end::Title-->
                                        </div>
                                        <!--end::Section-->
                                        <!--begin::Label-->
                                        <span class="badge badge-light fs-8">21 Jan</span>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Item-->
                                    <!--begin::Item-->
                                    <div class="d-flex flex-stack py-4">
                                        <!--begin::Section-->
                                        <div class="d-flex align-items-center">
                                            <!--begin::Symbol-->
                                            <div class="symbol symbol-35px me-4">
                                                <span class="symbol-label bg-light-warning">
                                                    <i class="ki-outline ki-color-swatch fs-2 text-warning"></i>
                                                </span>
                                            </div>
                                            <!--end::Symbol-->
                                            <!--begin::Title-->
                                            <div class="mb-0 me-2">
                                                <a href="#"
                                                    class="fs-6 text-gray-800 text-hover-primary fw-bold">Icon
                                                    Assets</a>
                                                <div class="text-gray-400 fs-7">Collection of SVG icons</div>
                                            </div>
                                            <!--end::Title-->
                                        </div>
                                        <!--end::Section-->
                                        <!--begin::Label-->
                                        <span class="badge badge-light fs-8">20 March</span>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Item-->
                                </div>
                                <!--end::Items-->
                                <!--begin::View more-->
                                <div class="py-3 text-center border-top">
                                    <a href="../../demo35/dist/pages/user-profile/activity.html"
                                        class="btn btn-color-gray-600 btn-active-color-primary">View All
                                        <i class="ki-outline ki-arrow-right fs-5"></i></a>
                                </div>
                                <!--end::View more-->
                            </div>
                            <!--end::Tab panel-->
                            <!--begin::Tab panel-->
                            <div class="tab-pane fade show active" id="kt_topbar_notifications_2" role="tabpanel">
                                <!--begin::Wrapper-->
                                <div class="d-flex flex-column px-9">
                                    <!--begin::Section-->
                                    <div class="pt-10 pb-0">
                                        <!--begin::Title-->
                                        <h3 class="text-dark text-center fw-bold">Get Pro Access</h3>
                                        <!--end::Title-->
                                        <!--begin::Text-->
                                        <div class="text-center text-gray-600 fw-semibold pt-1">Outlines keep you
                                            honest. They stoping you from amazing poorly about drive</div>
                                        <!--end::Text-->
                                        <!--begin::Action-->
                                        <div class="text-center mt-5 mb-9">
                                            <a href="#" class="btn btn-sm btn-primary px-6"
                                                data-bs-toggle="modal"
                                                data-bs-target="#kt_modal_upgrade_plan">Upgrade</a>
                                        </div>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Section-->
                                    <!--begin::Illustration-->
                                    <div class="text-center px-4">
                                        <img class="mw-100 mh-200px" alt="image"
                                            src="{{ asset('admin_assets/media/illustrations/sketchy-1/1.png') }}" />
                                    </div>
                                    <!--end::Illustration-->
                                </div>
                                <!--end::Wrapper-->
                            </div>
                            <!--end::Tab panel-->
                            <!--begin::Tab panel-->
                            <div class="tab-pane fade" id="kt_topbar_notifications_3" role="tabpanel">
                                <!--begin::Items-->
                                <div class="scroll-y mh-325px my-5 px-8">
                                    <!--begin::Item-->
                                    <div class="d-flex flex-stack py-4">
                                        <!--begin::Section-->
                                        <div class="d-flex align-items-center me-2">
                                            <!--begin::Code-->
                                            <span class="w-70px badge badge-light-success me-4">200 OK</span>
                                            <!--end::Code-->
                                            <!--begin::Title-->
                                            <a href="#" class="text-gray-800 text-hover-primary fw-semibold">New
                                                order</a>
                                            <!--end::Title-->
                                        </div>
                                        <!--end::Section-->
                                        <!--begin::Label-->
                                        <span class="badge badge-light fs-8">Just now</span>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Item-->
                                    <!--begin::Item-->
                                    <div class="d-flex flex-stack py-4">
                                        <!--begin::Section-->
                                        <div class="d-flex align-items-center me-2">
                                            <!--begin::Code-->
                                            <span class="w-70px badge badge-light-danger me-4">500 ERR</span>
                                            <!--end::Code-->
                                            <!--begin::Title-->
                                            <a href="#" class="text-gray-800 text-hover-primary fw-semibold">New
                                                customer</a>
                                            <!--end::Title-->
                                        </div>
                                        <!--end::Section-->
                                        <!--begin::Label-->
                                        <span class="badge badge-light fs-8">2 hrs</span>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Item-->
                                    <!--begin::Item-->
                                    <div class="d-flex flex-stack py-4">
                                        <!--begin::Section-->
                                        <div class="d-flex align-items-center me-2">
                                            <!--begin::Code-->
                                            <span class="w-70px badge badge-light-success me-4">200 OK</span>
                                            <!--end::Code-->
                                            <!--begin::Title-->
                                            <a href="#"
                                                class="text-gray-800 text-hover-primary fw-semibold">Payment
                                                process</a>
                                            <!--end::Title-->
                                        </div>
                                        <!--end::Section-->
                                        <!--begin::Label-->
                                        <span class="badge badge-light fs-8">5 hrs</span>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Item-->
                                    <!--begin::Item-->
                                    <div class="d-flex flex-stack py-4">
                                        <!--begin::Section-->
                                        <div class="d-flex align-items-center me-2">
                                            <!--begin::Code-->
                                            <span class="w-70px badge badge-light-warning me-4">300 WRN</span>
                                            <!--end::Code-->
                                            <!--begin::Title-->
                                            <a href="#"
                                                class="text-gray-800 text-hover-primary fw-semibold">Search query</a>
                                            <!--end::Title-->
                                        </div>
                                        <!--end::Section-->
                                        <!--begin::Label-->
                                        <span class="badge badge-light fs-8">2 days</span>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Item-->
                                    <!--begin::Item-->
                                    <div class="d-flex flex-stack py-4">
                                        <!--begin::Section-->
                                        <div class="d-flex align-items-center me-2">
                                            <!--begin::Code-->
                                            <span class="w-70px badge badge-light-success me-4">200 OK</span>
                                            <!--end::Code-->
                                            <!--begin::Title-->
                                            <a href="#" class="text-gray-800 text-hover-primary fw-semibold">API
                                                connection</a>
                                            <!--end::Title-->
                                        </div>
                                        <!--end::Section-->
                                        <!--begin::Label-->
                                        <span class="badge badge-light fs-8">1 week</span>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Item-->
                                    <!--begin::Item-->
                                    <div class="d-flex flex-stack py-4">
                                        <!--begin::Section-->
                                        <div class="d-flex align-items-center me-2">
                                            <!--begin::Code-->
                                            <span class="w-70px badge badge-light-success me-4">200 OK</span>
                                            <!--end::Code-->
                                            <!--begin::Title-->
                                            <a href="#"
                                                class="text-gray-800 text-hover-primary fw-semibold">Database
                                                restore</a>
                                            <!--end::Title-->
                                        </div>
                                        <!--end::Section-->
                                        <!--begin::Label-->
                                        <span class="badge badge-light fs-8">Mar 5</span>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Item-->
                                    <!--begin::Item-->
                                    <div class="d-flex flex-stack py-4">
                                        <!--begin::Section-->
                                        <div class="d-flex align-items-center me-2">
                                            <!--begin::Code-->
                                            <span class="w-70px badge badge-light-warning me-4">300 WRN</span>
                                            <!--end::Code-->
                                            <!--begin::Title-->
                                            <a href="#"
                                                class="text-gray-800 text-hover-primary fw-semibold">System update</a>
                                            <!--end::Title-->
                                        </div>
                                        <!--end::Section-->
                                        <!--begin::Label-->
                                        <span class="badge badge-light fs-8">May 15</span>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Item-->
                                    <!--begin::Item-->
                                    <div class="d-flex flex-stack py-4">
                                        <!--begin::Section-->
                                        <div class="d-flex align-items-center me-2">
                                            <!--begin::Code-->
                                            <span class="w-70px badge badge-light-warning me-4">300 WRN</span>
                                            <!--end::Code-->
                                            <!--begin::Title-->
                                            <a href="#"
                                                class="text-gray-800 text-hover-primary fw-semibold">Server OS
                                                update</a>
                                            <!--end::Title-->
                                        </div>
                                        <!--end::Section-->
                                        <!--begin::Label-->
                                        <span class="badge badge-light fs-8">Apr 3</span>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Item-->
                                    <!--begin::Item-->
                                    <div class="d-flex flex-stack py-4">
                                        <!--begin::Section-->
                                        <div class="d-flex align-items-center me-2">
                                            <!--begin::Code-->
                                            <span class="w-70px badge badge-light-warning me-4">300 WRN</span>
                                            <!--end::Code-->
                                            <!--begin::Title-->
                                            <a href="#" class="text-gray-800 text-hover-primary fw-semibold">API
                                                rollback</a>
                                            <!--end::Title-->
                                        </div>
                                        <!--end::Section-->
                                        <!--begin::Label-->
                                        <span class="badge badge-light fs-8">Jun 30</span>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Item-->
                                    <!--begin::Item-->
                                    <div class="d-flex flex-stack py-4">
                                        <!--begin::Section-->
                                        <div class="d-flex align-items-center me-2">
                                            <!--begin::Code-->
                                            <span class="w-70px badge badge-light-danger me-4">500 ERR</span>
                                            <!--end::Code-->
                                            <!--begin::Title-->
                                            <a href="#"
                                                class="text-gray-800 text-hover-primary fw-semibold">Refund process</a>
                                            <!--end::Title-->
                                        </div>
                                        <!--end::Section-->
                                        <!--begin::Label-->
                                        <span class="badge badge-light fs-8">Jul 10</span>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Item-->
                                    <!--begin::Item-->
                                    <div class="d-flex flex-stack py-4">
                                        <!--begin::Section-->
                                        <div class="d-flex align-items-center me-2">
                                            <!--begin::Code-->
                                            <span class="w-70px badge badge-light-danger me-4">500 ERR</span>
                                            <!--end::Code-->
                                            <!--begin::Title-->
                                            <a href="#"
                                                class="text-gray-800 text-hover-primary fw-semibold">Withdrawal
                                                process</a>
                                            <!--end::Title-->
                                        </div>
                                        <!--end::Section-->
                                        <!--begin::Label-->
                                        <span class="badge badge-light fs-8">Sep 10</span>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Item-->
                                    <!--begin::Item-->
                                    <div class="d-flex flex-stack py-4">
                                        <!--begin::Section-->
                                        <div class="d-flex align-items-center me-2">
                                            <!--begin::Code-->
                                            <span class="w-70px badge badge-light-danger me-4">500 ERR</span>
                                            <!--end::Code-->
                                            <!--begin::Title-->
                                            <a href="#"
                                                class="text-gray-800 text-hover-primary fw-semibold">Mail tasks</a>
                                            <!--end::Title-->
                                        </div>
                                        <!--end::Section-->
                                        <!--begin::Label-->
                                        <span class="badge badge-light fs-8">Dec 10</span>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Item-->
                                </div>
                                <!--end::Items-->
                                <!--begin::View more-->
                                <div class="py-3 text-center border-top">
                                    <a href="../../demo35/dist/pages/user-profile/activity.html"
                                        class="btn btn-color-gray-600 btn-active-color-primary">View All
                                        <i class="ki-outline ki-arrow-right fs-5"></i></a>
                                </div>
                                <!--end::View more-->
                            </div>
                            <!--end::Tab panel-->
                        </div>
                        <!--end::Tab content-->
                    </div>
                    <!--end::Menu-->
                    <!--end::Menu wrapper-->
                </div>
                <div class="app-navbar-item">
                    <!--begin:Info-->
                    <a href="/metronic8/demo35/account/billing.html"
                        class="d-flex flex-column bg-light text-end rounded px-4 py-1 ms-3 ms-lg-6">
                        <span class="text-gray-500 fs-8 fw-bold">Balance</span>

                        <span class="text-gray-800 fs-5 fw-bold">$32,084</span>
                    </a>
                    <!--end:Info-->
                </div>
                <div class="app-navbar-item ms-3 ms-lg-9" id="kt_header_user_menu_toggle">
                    <!--begin::Menu wrapper-->
                    <div class="d-flex align-items-center" data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
                        data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                        <!--begin:Info-->
                        <div class="text-end d-none d-sm-flex flex-column justify-content-center me-3">
                            <span class="text-gray-500 fs-8 fw-bold">Hello</span>
                            <a href="../../demo35/dist/pages/user-profile/overview.html"
                                class="text-gray-800 text-hover-primary fs-7 fw-bold d-block">{{ ucfirst(auth()->user()->name) }}</a>
                        </div>
                        <!--end:Info-->
                        <!--begin::User-->
                        <div class="cursor-pointer symbol symbol symbol-circle symbol-35px symbol-md-40px">
                            <img class=""
                                src="{{ asset('storage/public/web_assets/media/avatars/' . auth()->user()->avatar) }}"
                                alt="user" />
                            <div
                                class="position-absolute translate-middle bottom-0 mb-1 start-100 ms-n1 bg-success rounded-circle h-8px w-8px">
                            </div>
                        </div>
                        <!--end::User-->
                    </div>
                    <!--begin::User account menu-->
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px"
                        data-kt-menu="true">
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <div class="menu-content d-flex align-items-center px-3">
                                <!--begin::Avatar-->
                                <div class="symbol symbol-50px me-5">
                                    <img alt="Logo"
                                        src="{{ asset('storage/public/web_assets/media/avatars/' . auth()->user()->avatar) }}" />
                                </div>
                                <!--end::Avatar-->
                                <!--begin::Username-->
                                <div class="d-flex flex-column">
                                    <div class="fw-bold d-flex align-items-center fs-5">
                                        {{ ucfirst(auth()->user()->name) }}
                                    </div>
                                    <a href="#"
                                        class="fw-semibold text-muted text-hover-primary fs-7">{{ auth()->user()->email }}</a>
                                </div>
                                <!--end::Username-->
                            </div>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu separator-->
                        <div class="separator my-2"></div>
                        <!--end::Menu separator-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-5">
                            <a href="../../demo35/dist/account/overview.html" class="menu-link px-5">My Profile</a>
                        </div>
                        <div class="separator my-2"></div>
                        <div class="menu-item px-5">
                            <a href="{{ route('admin.logout') }}" class="menu-link px-5">Sign Out</a>
                        </div>
                        <!--end::Menu item-->
                    </div>
                    <!--end::User account menu-->
                    <!--end::Menu wrapper-->
                </div>
                <!--end::User menu-->
                <!--begin::Header menu toggle-->
                {{-- <div class="app-navbar-item d-lg-none ms-2 me-n3" title="Show header menu">
                    <div class="btn btn-icon btn-color-gray-500 btn-active-color-primary w-35px h-35px"
                        id="kt_app_header_menu_toggle">
                        <i class="ki-outline ki-text-align-left fs-1"></i>
                    </div>
                </div> --}}
                <!--end::Header menu toggle-->
            </div>
            <!--end::Navbar-->
        </div>
        <!--end::Header primary container-->
    </div>
</div>
