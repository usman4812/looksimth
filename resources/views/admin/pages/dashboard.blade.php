@extends('admin.main')
@section('content')
<div class="d-flex flex-column flex-column-fluid">
    <!--begin::Toolbar-->
    <div id="kt_app_toolbar" class="app-toolbar d-flex flex-stack py-4 py-lg-8">
        <!--begin::Toolbar wrapper-->
        <div class="d-flex flex-grow-1 flex-stack flex-wrap gap-2 mb-n10" id="kt_toolbar">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <!--begin::Title-->
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">LookSmith Dashboard</h1>
                <!--end::Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Home</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-dark">Dashboards</li>
                    <!--end::Item-->
                </ul>
                <!--end::Breadcrumb-->
            </div>
        </div>
        <!--end::Toolbar wrapper-->
    </div>
    <!--end::Toolbar-->
    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Row-->
        <div class="row g-5 g-xl-10 mb-xl-10">
            <!--begin::Col-->
            <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-md-5 mb-xl-10">
                <!--begin::Card widget 4-->
                <div class="card card-flush h-md-50 mb-5 mb-xl-10">
                    <!--begin::Header-->
                    <div class="card-header pt-5">
                        <!--begin::Title-->
                        <div class="card-title d-flex flex-column">
                            <!--begin::Info-->
                            <div class="d-flex align-items-center">
                                <!--begin::Currency-->
                                <span class="fs-4 fw-semibold text-gray-400 me-1 align-self-start">$</span>
                                <!--end::Currency-->
                                <!--begin::Amount-->
                                <span class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2">69,700</span>
                                <!--end::Amount-->
                                <!--begin::Badge-->
                                <span class="badge badge-light-success fs-base">
                                <i class="ki-outline ki-arrow-up fs-5 text-success ms-n1"></i>2.2%</span>
                                <!--end::Badge-->
                            </div>
                            <!--end::Info-->
                            <!--begin::Subtitle-->
                            <span class="text-gray-400 pt-1 fw-semibold fs-6">Expected Earnings</span>
                            <!--end::Subtitle-->
                        </div>
                        <!--end::Title-->
                    </div>
                    <!--end::Header-->
                    <!--begin::Card body-->
                    <div class="card-body pt-2 pb-4 d-flex align-items-center">
                        <!--begin::Chart-->
                        <div class="d-flex flex-center me-5 pt-2">
                            <div id="kt_card_widget_4_chart" style="min-width: 70px; min-height: 70px" data-kt-size="70" data-kt-line="11"></div>
                        </div>
                        <!--end::Chart-->
                        <!--begin::Labels-->
                        <div class="d-flex flex-column content-justify-center w-100">
                            <!--begin::Label-->
                            <div class="d-flex fs-6 fw-semibold align-items-center">
                                <!--begin::Bullet-->
                                <div class="bullet w-8px h-6px rounded-2 bg-danger me-3"></div>
                                <!--end::Bullet-->
                                <!--begin::Label-->
                                <div class="text-gray-500 flex-grow-1 me-4">Shoes</div>
                                <!--end::Label-->
                                <!--begin::Stats-->
                                <div class="fw-bolder text-gray-700 text-xxl-end">$7,660</div>
                                <!--end::Stats-->
                            </div>
                            <!--end::Label-->
                            <!--begin::Label-->
                            <div class="d-flex fs-6 fw-semibold align-items-center my-3">
                                <!--begin::Bullet-->
                                <div class="bullet w-8px h-6px rounded-2 bg-primary me-3"></div>
                                <!--end::Bullet-->
                                <!--begin::Label-->
                                <div class="text-gray-500 flex-grow-1 me-4">Gaming</div>
                                <!--end::Label-->
                                <!--begin::Stats-->
                                <div class="fw-bolder text-gray-700 text-xxl-end">$2,820</div>
                                <!--end::Stats-->
                            </div>
                            <!--end::Label-->
                            <!--begin::Label-->
                            <div class="d-flex fs-6 fw-semibold align-items-center">
                                <!--begin::Bullet-->
                                <div class="bullet w-8px h-6px rounded-2 me-3" style="background-color: #E4E6EF"></div>
                                <!--end::Bullet-->
                                <!--begin::Label-->
                                <div class="text-gray-500 flex-grow-1 me-4">Others</div>
                                <!--end::Label-->
                                <!--begin::Stats-->
                                <div class="fw-bolder text-gray-700 text-xxl-end">$45,257</div>
                                <!--end::Stats-->
                            </div>
                            <!--end::Label-->
                        </div>
                        <!--end::Labels-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card widget 4-->
                <!--begin::Card widget 5-->
                <div class="card card-flush h-md-50 mb-xl-10">
                    <!--begin::Header-->
                    <div class="card-header pt-5">
                        <!--begin::Title-->
                        <div class="card-title d-flex flex-column">
                            <!--begin::Info-->
                            <div class="d-flex align-items-center">
                                <!--begin::Amount-->
                                <span class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2">1,836</span>
                                <!--end::Amount-->
                                <!--begin::Badge-->
                                <span class="badge badge-light-danger fs-base">
                                <i class="ki-outline ki-arrow-down fs-5 text-danger ms-n1"></i>2.2%</span>
                                <!--end::Badge-->
                            </div>
                            <!--end::Info-->
                            <!--begin::Subtitle-->
                            <span class="text-gray-400 pt-1 fw-semibold fs-6">Orders This Month</span>
                            <!--end::Subtitle-->
                        </div>
                        <!--end::Title-->
                    </div>
                    <!--end::Header-->
                    <!--begin::Card body-->
                    <div class="card-body d-flex align-items-end pt-0">
                        <!--begin::Progress-->
                        <div class="d-flex align-items-center flex-column mt-3 w-100">
                            <div class="d-flex justify-content-between w-100 mt-auto mb-2">
                                <span class="fw-bolder fs-6 text-dark">1,048 to Goal</span>
                                <span class="fw-bold fs-6 text-gray-400">62%</span>
                            </div>
                            <div class="h-8px mx-3 w-100 bg-light-success rounded">
                                <div class="bg-success rounded h-8px" role="progressbar" style="width: 62%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <!--end::Progress-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card widget 5-->
            </div>
            <!--end::Col-->
            <!--begin::Col-->
            <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-md-5 mb-xl-10">
                <!--begin::Card widget 6-->
                <div class="card card-flush h-md-50 mb-5 mb-xl-10">
                    <!--begin::Header-->
                    <div class="card-header pt-5">
                        <!--begin::Title-->
                        <div class="card-title d-flex flex-column">
                            <!--begin::Info-->
                            <div class="d-flex align-items-center">
                                <!--begin::Currency-->
                                <span class="fs-4 fw-semibold text-gray-400 me-1 align-self-start">$</span>
                                <!--end::Currency-->
                                <!--begin::Amount-->
                                <span class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2">2,420</span>
                                <!--end::Amount-->
                                <!--begin::Badge-->
                                <span class="badge badge-light-success fs-base">
                                <i class="ki-outline ki-arrow-up fs-5 text-success ms-n1"></i>2.6%</span>
                                <!--end::Badge-->
                            </div>
                            <!--end::Info-->
                            <!--begin::Subtitle-->
                            <span class="text-gray-400 pt-1 fw-semibold fs-6">Average Daily Sales</span>
                            <!--end::Subtitle-->
                        </div>
                        <!--end::Title-->
                    </div>
                    <!--end::Header-->
                    <!--begin::Card body-->
                    <div class="card-body d-flex align-items-end px-0 pb-0">
                        <!--begin::Chart-->
                        <div id="kt_card_widget_6_chart" class="w-100" style="height: 80px"></div>
                        <!--end::Chart-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card widget 6-->
                <!--begin::Card widget 7-->
                <div class="col-xl-8 mb-5 mb-xl-10">
                <!--end::Card widget 7-->
            </div>


        </div>


    </div>
</div>
@endsection
