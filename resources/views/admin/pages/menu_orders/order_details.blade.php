@extends('admin.main')
@push('style')
    <style>
        .card {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .hover-scroll {
            scrollbar-width: thin;
            scrollbar-color: #dcdcdc transparent;
        }

        .hover-scroll::-webkit-scrollbar {
            width: 6px;
        }

        .hover-scroll::-webkit-scrollbar-thumb {
            background-color: #c4c4c4;
            border-radius: 4px;
        }

        .hover-scroll:hover::-webkit-scrollbar-thumb {
            background-color: #888;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #e0e0e0;
        }

        .list-group-item {
            padding: 10px 15px;
            font-size: 14px;
            border: none;
        }
    </style>
@endpush
@section('content')
    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_toolbar" class="app-toolbar  d-flex flex-stack py-4 py-lg-8 ">
            <div class="d-flex flex-grow-1 flex-stack flex-wrap gap-2 mb-n10" id="kt_toolbar">
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3 ">

                    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                        Order Fulfillment
                    </h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">

                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.menus') }}" class="text-muted text-hover-primary">Menus + Orders</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-gray-900">Orders Details</li>
                    </ul>
                </div>
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <a href="{{ route('admin.menus.add') }}" class="btn btn-sm btn-primary fw-bold me-2">Download as CSV</a>
                    <a href="{{ route('admin.menus.table_view', 1) }}" class="btn btn-sm btn-success fw-bold me-2">View as
                        Table</a>
                </div>
            </div>
        </div>
        <!--begin::Content-->
        <div id="kt_app_content" class="app-content  flex-column-fluid ">
            <div class="card">
                <div class="card">
                    <div class="card-body py-3">
                        <h1>Delivery Date</h1>
                        <p class="mt-5">Friday, December 5, 2025</p>
                        <h1 class="mt-5">Meals Summary</h1>
                        <div class="d-flex flex-wrap gap-3">
                            <div class="card hover-scroll mb-5" style="max-height: 300px; overflow-y: auto; width: 250px;">
                                <!-- Card Header -->
                                <div
                                    class="card-header border-0 pt-3 pb-1 d-flex justify-content-between align-items-center">
                                    <h5 class="card-title text-dark fw-bold mb-0">Meals</h5>
                                    <span class="text-muted fw-semibold fs-6">733</span>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body pt-2">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span>Standard</span>
                                            <span>733</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span>Deluxe</span>
                                            <span>0</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span>Junior</span>
                                            <span>0</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span>Bulk</span>
                                            <span>0</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="card hover-scroll mb-5" style="max-height: 300px; overflow-y: auto; width: 250px;">
                                <!-- Card Header -->
                                <div
                                    class="card-header border-0 pt-3 pb-1 d-flex justify-content-between align-items-center">
                                    <h5 class="card-title text-dark fw-bold mb-0">Regular</h5>
                                    <span class="text-muted fw-semibold fs-6">0</span>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body pt-2">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span>Breakfast</span>
                                            <span>0</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span>Lunch/Dinner</span>
                                            <span>0</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="card hover-scroll mb-5" style="max-height: 300px; overflow-y: auto; width: 250px;">
                                <!-- Card Header -->
                                <div
                                    class="card-header border-0 pt-3 pb-1 d-flex justify-content-between align-items-center">
                                    <h5 class="card-title text-dark fw-bold mb-0">Medicaid</h5>
                                    <span class="text-muted fw-semibold fs-6">0</span>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body pt-2">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span>ElderOne</span>
                                            <span>0</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span>Elderwood</span>
                                            <span>0</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span>Fidelis Care</span>
                                            <span>0</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span>iCircle</span>
                                            <span>0</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span>Influencer</span>
                                            <span>0</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span>VNSNY Choice</span>
                                            <span>0</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span>MLTC</span>
                                            <span>0</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="card hover-scroll mb-5" style="max-height: 300px; overflow-y: auto; width: 250px;">
                                <!-- Card Header -->
                                <div
                                    class="card-header border-0 pt-3 pb-1 d-flex justify-content-between align-items-center">
                                    <h5 class="card-title text-dark fw-bold mb-0">Cafeteria</h5>
                                    <span class="text-muted fw-semibold fs-6">733</span>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body pt-2">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span>Breakfast</span>
                                            <span>26</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span>Lunch/Dinner</span>
                                            <span>707</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <table class="table text-center table-rounded table-striped border gy-7 gs-7">
                            <thead class="fw-semibold fs-6 text-gray-800 border-bottom border-gray-200">
                                <tr>
                                    <th></th>
                                    <th>Standard</th>
                                    <th>Deluxe</th>
                                    <th>Junior</th>
                                    <th>Bulk</th>
                                    <th>Protein</th>
                                    <th>Sides</th>
                                    <th>Amount</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Regular</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>$0.00</td>
                                    <td>BREAKFAST SAUSAGE BURRITO</td>
                                </tr>
                                <tr>
                                    <td>Medicaid</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>$0.00</td>
                                </tr>
                                <tr>
                                    <td>Cafeteria</td>
                                    <td>13</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>13</td>
                                    <td>$0.00</td>
                                </tr>
                                <tr>
                                    <th>Total</th>
                                    <th>13</th>
                                    <th>0</th>
                                    <th>0</th>
                                    <th>0</th>
                                    <th>0</th>
                                    <th>13</th>
                                    <th>$0.00</th>
                                </tr>
                            </tbody>
                        </table>
                        <table class="table  text-center table-rounded table-striped border gy-7 gs-7">
                            <thead class="fw-semibold fs-6 text-gray-800 border-bottom border-gray-200">
                                <tr>
                                    <th></th> <!-- Empty cell for row labels -->
                                    <th>Standard</th>
                                    <th>Deluxe</th>
                                    <th>Junior</th>
                                    <th>Bulk</th>
                                    <th>Protein</th>
                                    <th>Sides</th>
                                    <th>Amount</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Regular</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>$0.00</td>
                                    <td>BREAKFAST SAUSAGE BURRITO</td>
                                </tr>
                                <tr>
                                    <td>Medicaid</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>$0.00</td>
                                </tr>
                                <tr>
                                    <td>Cafeteria</td>
                                    <td>13</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>13</td>
                                    <td>$0.00</td>
                                </tr>
                                <tr>
                                    <th>Total</th>
                                    <th>13</th>
                                    <th>0</th>
                                    <th>0</th>
                                    <th>0</th>
                                    <th>0</th>
                                    <th>13</th>
                                    <th>$0.00</th>
                                </tr>
                            </tbody>
                        </table>
                        <table class="table  text-center table-rounded table-striped border gy-7 gs-7">
                            <thead class="fw-semibold fs-6 text-gray-800 border-bottom border-gray-200">
                                <tr>
                                    <th></th> <!-- Empty cell for row labels -->
                                    <th>Standard</th>
                                    <th>Deluxe</th>
                                    <th>Junior</th>
                                    <th>Bulk</th>
                                    <th>Protein</th>
                                    <th>Sides</th>
                                    <th>Amount</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Regular</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>$0.00</td>
                                    <td>BREAKFAST SAUSAGE BURRITO</td>
                                </tr>
                                <tr>
                                    <td>Medicaid</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>$0.00</td>
                                </tr>
                                <tr>
                                    <td>Cafeteria</td>
                                    <td>13</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>13</td>
                                    <td>$0.00</td>
                                </tr>
                                <tr>
                                    <th>Total</th>
                                    <th>13</th>
                                    <th>0</th>
                                    <th>0</th>
                                    <th>0</th>
                                    <th>0</th>
                                    <th>13</th>
                                    <th>$0.00</th>
                                </tr>
                            </tbody>
                        </table>
                        <table class="table text-center table-rounded table-striped border gy-7 gs-7">
                            <thead class="fw-semibold fs-6 text-gray-800 border-bottom border-gray-200">
                                <tr>
                                    <th></th> <!-- Empty cell for row labels -->
                                    <th>Standard</th>
                                    <th>Deluxe</th>
                                    <th>Junior</th>
                                    <th>Bulk</th>
                                    <th>Protein</th>
                                    <th>Sides</th>
                                    <th>Amount</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Regular</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>$0.00</td>
                                    <td>BREAKFAST SAUSAGE BURRITO</td>
                                </tr>
                                <tr>
                                    <td>Medicaid</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>$0.00</td>
                                </tr>
                                <tr>
                                    <td>Cafeteria</td>
                                    <td>13</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>13</td>
                                    <td>$0.00</td>
                                </tr>
                                <tr>
                                    <th>Total</th>
                                    <th>13</th>
                                    <th>0</th>
                                    <th>0</th>
                                    <th>0</th>
                                    <th>0</th>
                                    <th>13</th>
                                    <th>$0.00</th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
