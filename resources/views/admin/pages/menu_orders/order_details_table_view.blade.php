@extends('admin.main')
@section('content')
    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_toolbar" class="app-toolbar  d-flex flex-stack py-4 py-lg-8 ">
            <div class="d-flex flex-grow-1 flex-stack flex-wrap gap-2 mb-n10" id="kt_toolbar">
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3 ">

                    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                        Table View
                    </h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">

                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.menus') }}" class="text-muted text-hover-primary">Menu + Orders</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.menus.orders', 1) }}" class="text-muted text-hover-primary">Orders
                                Details</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-gray-900">Table View</li>
                    </ul>
                </div>
            </div>
        </div>
        <!--begin::Content-->
        <div id="kt_app_content" class="app-content  flex-column-fluid ">
            <div class="card">
                <div class="card-body py-3">
                    <div class="table-responsive">
                        <table class="table align-middle gs-0 gy-4">
                            <thead>
                                <tr class="fw-bold bg-light">
                                    <th class="ps-4 min-w-200px rounded-start">Paid</th>
                                    <th class="min-w-125px">Paid Date</th>
                                    <th class="min-w-125px">Amount Due</th>
                                    <th class="min-w-200px">Amount Paid</th>
                                    <th class="min-w-200px">Tip Amount</th>
                                    <th class="min-w-200px">Provider</th>
                                    <th class="min-w-200px">Provider Transaction ID</th>
                                    <th class="min-w-200px">Free Plan</th>
                                    <th class="min-w-200px">Customer Type</th>
                                    <th class="min-w-200px">Customer Group</th>
                                    <th class="min-w-200px">Auth Number</th>
                                    <th class="min-w-200px">First Name</th>
                                    <th class="min-w-200px">Last Name</th>
                                    <th class="min-w-200px">Phone</th>
                                    <th class="min-w-200px">Email</th>
                                    <th class="min-w-200px">Street Address</th>
                                    <th class="min-w-200px">Zip Code</th>
                                    <th class="min-w-200px">Delivery Option</th>
                                    <th class="min-w-200px">Delivery Instructions</th>
                                    <th class="min-w-200px">Driver #</th>
                                    <th class="min-w-200px">Meal Size</th>
                                    <th class="min-w-200px">Plan</th>
                                    <th class="min-w-200px">Price Per Meal</th>
                                    <th class="min-w-200px">SPrice Per Meal With Discount</th>
                                    <th class="min-w-200px">Meal Days</th>
                                    <th class="min-w-200px">Diets</th>
                                    <th class="min-w-200px">Fulfilled At</th>
                                    <th class="min-w-200px">Fulfilled Time</th>
                                    <th class="min-w-200px">Fulfilled By</th>
                                    <th class="min-w-200px">Driver Left At</th>
                                    <th class="min-w-200px">Driver Notes</th>
                                    <th class="min-w-200px">Text</th>
                                    <th class="min-w-200px">Auto-Selected</th>
                                    <th class="min-w-200px">Has cooler Bag</th>
                                    <th class="min-w-200px">Paper Menu</th>
                                    <th class="min-w-200px">Breakfast Sausage Burrito</th>
                                    <th class="min-w-200px">Bacon Breakfast Burrito</th>
                                    <th class="min-w-200px">Vegan Southwest Tofu Salad</th>
                                    <th class="min-w-200px">Southwestern Salad Sirness</th>
                                    <th class="min-w-200px">Chicken Caesar Salad</th>
                                    <th class="min-w-200px">Traditional Chicken Salad Wrap</th>
                                    <th class="min-w-200px">Chicken Parm Burrito</th>
                                    <th class="min-w-200px">Buffalo</th>
                                    <th class="min-w-200px">Lemon Poppy seed</th>
                                    <th class="min-w-200px">Apricot Quinoa</th>
                                    <th class="min-w-200px">Waldorf</th>
                                    <th class="min-w-200px">Dill</th>
                                    <th class="min-w-200px">Caesar</th>
                                    <th class="min-w-200px">Pesto</th>
                                    <th class="min-w-200px">CBR</th>
                                    <th class="min-w-200px">HAM</th>
                                    <th class="min-w-200px">Turkey</th>
                                    <th class="min-w-200px">Tofu</th>
                                    <th class="min-w-200px">Chickpea</th>
                                    <th class="min-w-200px">Tuna</th>
                                    <th class="min-w-200px">Veggie Power Wrap</th>
                                    <th class="min-w-200px">Low Carb Chicken Parm Burrito</th>
                                    <th class="min-w-200px">Low Carb Chicken Salad Wrap</th>
                                    <th class="min-w-200px">Low Carb Lemon Poppy Seed Wrap</th>
                                    <th class="min-w-200px">Low Carb Buffalo Chicken Wrap</th>
                                    <th class="min-w-200px">Low Carb Dill Waldorf Wrap</th>
                                    <th class="min-w-200px">Turkey Swiss Sandwich-Kaiser</th>
                                    <th class="min-w-200px">Ham Cheddar Sandwich-Kaiser</th>
                                    <th class="min-w-200px">Tuna Sandwich-Kaiser</th>
                                    <th class="min-w-200px">FFT Sandwiches</th>
                                    <th class="min-w-200px">Italian Assorted Sandwich</th>
                                    <th class="min-w-200px">Ham Cheddar Sandwich-9 Grain Bread</th>
                                    <th class="min-w-200px">Dill Chicken Waldorf Sandwich-9 Grain Bread</th>
                                    <th class="min-w-200px">Tuna Sandwich-9 Grain Bread</th>
                                    <th class="min-w-200px">Turkesy Swiss Sandwich-9 Grain Bread</th>
                                    <th class="min-w-200px">Italian Assorted Sandwich Gluten Free</th>
                                    <th class="min-w-200px">Tuna Sandwich Gluten Free</th>
                                    <th class="min-w-200px">Mexi Chicken Burrito</th>
                                    <th class="min-w-200px">Mexi Veg Burrito</th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <a href="#" class="text-dark mb-1 fs-6">Medicaid</a>
                                    </td>
                                    <td>
                                        <a href="#" class="text-dark mb-1 fs-6">2024-11-15 02:29 PM</a>
                                    </td>
                                    <td>
                                        <a href="#" class="text-dark mb-1 fs-6">$0.00</a>
                                    </td>
                                    <td>
                                        <a href="#" class="text-dark d-block mb-1 fs-6">$0.00</a>
                                    </td>
                                    <td>
                                        <a href="#" class="text-dark d-block mb-1 fs-6">$0.00</a>
                                    </td>
                                    <td>
                                        <a href="#" class="text-dark d-block mb-1 fs-6">$0.00</a>
                                    </td>
                                    <td>
                                        <a href="#" class="text-dark d-block mb-1 fs-6">$0.00</a>
                                    </td>
                                    <td>
                                        <a href="#" class="text-dark d-block mb-1 fs-6">No</a>
                                    </td>
                                    <td>
                                        <a href="#" class="text-dark d-block mb-1 fs-6">Cafeteria</a>
                                    </td>
                                    <td>
                                        <a href="#" class="text-dark d-block mb-1 fs-6"></a>
                                    </td>
                                    <td>
                                        <a href="#" class="text-dark d-block mb-1 fs-6"></a>
                                    </td>
                                    <td>
                                        <a href="#" class="text-dark d-block mb-1 fs-6">HILLSIDE</a>
                                    </td>
                                    <td>
                                        <a href="#" class="text-dark d-block mb-1 fs-6">FRIDAY CLAMSHELLS 102</a>
                                    </td>
                                    <td>
                                        <a href="#" class="text-dark d-block mb-1 fs-6"></a>
                                    </td>
                                    <td>
                                        <a href="#" class="text-dark d-block mb-1 fs-6"></a>
                                    </td>
                                    <td>
                                        <a href="#" class="text-dark d-block mb-1 fs-6"></a>
                                    </td>
                                    <td>
                                        <a href="#" class="text-dark d-block mb-1 fs-6"></a>
                                    </td>
                                    <td>
                                        <a href="#" class="text-dark d-block mb-1 fs-6">Pickup at Our Store</a>
                                    </td>
                                    <td>
                                        <a href="#" class="text-dark d-block mb-1 fs-6"></a>
                                    </td>
                                    <td>
                                        <a href="#" class="text-dark d-block mb-1 fs-6"></a>
                                    </td>
                                    <td>
                                        <a href="#" class="text-dark d-block mb-1 fs-6">Standard</a>
                                    </td>
                                    <td>
                                        <a href="#" class="text-dark d-block mb-1 fs-6">Custom Plan, 328 Meals Per
                                            Week, Standard</a>
                                    </td>
                                    <td>
                                        <a href="#" class="text-dark d-block mb-1 fs-6"></a>
                                    </td>
                                    <td>
                                        <a href="#" class="text-dark d-block mb-1 fs-6">2024-11-08 03:00 AM</a>
                                    </td>
                                    <td>
                                        <a href="#" class="text-dark d-block mb-1 fs-6">Fri</a>
                                    </td>
                                    <td>
                                        <a href="#" class="text-dark d-block mb-1 fs-6"></a>
                                    </td>
                                    <td>
                                        <a href="#" class="text-dark d-block mb-1 fs-6">03:00 AM</a>
                                    </td>
                                    <td>
                                        <a href="#" class="text-dark d-block mb-1 fs-6">USMAN U</a>
                                    </td>
                                    <td>
                                        <a href="#" class="text-dark d-block mb-1 fs-6"></a>
                                    </td>
                                    <td>
                                        <a href="#" class="text-dark d-block mb-1 fs-6"></a>
                                    </td>
                                    <td>
                                        <a href="#" class="text-dark d-block mb-1 fs-6"></a>
                                    </td>
                                    <td>
                                        <a href="#" class="text-dark d-block mb-1 fs-6">No</a>
                                    </td>
                                    <td>
                                        <a href="#" class="text-dark d-block mb-1 fs-6">No</a>
                                    </td>
                                    <td>
                                        <a href="#" class="text-dark d-block mb-1 fs-6">None</a>
                                    </td>
                                    <td>
                                        <a href="#" class="text-dark d-block mb-1 fs-6">10</a>
                                    </td>
                                    <td>
                                        <a href="#" class="text-dark d-block mb-1 fs-6">10</a>
                                    </td>
                                    <td>
                                        <a href="#" class="text-dark d-block mb-1 fs-6"></a>
                                    </td>
                                    <td>
                                        <a href="#" class="text-dark d-block mb-1 fs-6"></a>
                                    </td>
                                    <td>
                                        <a href="#" class="text-dark d-block mb-1 fs-6">10</a>
                                    </td>
                                    <td>
                                        <a href="#" class="text-dark d-block mb-1 fs-6">7</a>
                                    </td>
                                    <td>
                                        <a href="#" class="text-dark d-block mb-1 fs-6"></a>
                                    </td>
                                    <td>
                                        <a href="#" class="text-dark d-block mb-1 fs-6">14</a>
                                    </td>
                                    <td>
                                        <a href="#" class="text-dark d-block mb-1 fs-6">17</a>
                                    </td>
                                    <td>
                                        <a href="#" class="text-dark d-block mb-1 fs-6"></a>
                                    </td>
                                    <td>
                                        <a href="#" class="text-dark d-block mb-1 fs-6"></a>
                                    </td>
                                    <td>
                                        <a href="#" class="text-dark d-block mb-1 fs-6">14</a>
                                    </td>
                                    <td>
                                        <a href="#" class="text-dark d-block mb-1 fs-6">10</a>
                                    </td>
                                    <td>
                                        <a href="#" class="text-dark d-block mb-1 fs-6">17</a>
                                    </td>
                                    <td>
                                        <a href="#" class="text-dark d-block mb-1 fs-6"></a>
                                    </td>
                                    <td>
                                        <a href="#" class="text-dark d-block mb-1 fs-6">10</a>
                                    </td>
                                    <td>
                                        <a href="#" class="text-dark d-block mb-1 fs-6"></a>
                                    </td>
                                    <td>
                                        <a href="#" class="text-dark d-block mb-1 fs-6"></a>
                                    </td>
                                    <td>
                                        <a href="#" class="text-dark d-block mb-1 fs-6">20</a>
                                    </td>
                                    <td>
                                        <a href="#" class="text-dark d-block mb-1 fs-6">10</a>
                                    </td>
                                    <td>
                                        <a href="#" class="text-dark d-block mb-1 fs-6">34</a>
                                    </td>
                                    <td>
                                        <a href="#" class="text-dark d-block mb-1 fs-6">10</a>
                                    </td>
                                    <td>
                                        <a href="#" class="text-dark d-block mb-1 fs-6">22</a>
                                    </td>
                                    <td>
                                        <a href="#" class="text-dark d-block mb-1 fs-6">34</a>
                                    </td>
                                    <td>
                                        <a href="#" class="text-dark d-block mb-1 fs-6"></a>
                                    </td>
                                    <td>
                                        <a href="#" class="text-dark d-block mb-1 fs-6"></a>
                                    </td>
                                    <td>
                                        <a href="#" class="text-dark d-block mb-1 fs-6">45</a>
                                    </td>
                                    <td>
                                        <a href="#" class="text-dark d-block mb-1 fs-6"></a>
                                    </td>
                                    <td>
                                        <a href="#" class="text-dark d-block mb-1 fs-6">45</a>
                                    </td>
                                    <td>
                                        <a href="#" class="text-dark d-block mb-1 fs-6"></a>
                                    </td>
                                    <td>
                                        <a href="#" class="text-dark d-block mb-1 fs-6">45</a>
                                    </td>
                                    <td>
                                        <a href="#" class="text-dark d-block mb-1 fs-6">20</a>
                                    </td>
                                    <td>
                                        <a href="#" class="text-dark d-block mb-1 fs-6">45</a>
                                    </td>
                                    <td>
                                        <a href="#" class="text-dark d-block mb-1 fs-6">10</a>
                                    </td>
                                    <td>
                                        <a href="#" class="text-dark d-block mb-1 fs-6"></a>
                                    </td>
                                    <td>
                                        <a href="#" class="text-dark d-block mb-1 fs-6"></a>
                                    </td>
                                    <td>
                                        <a href="#" class="text-dark d-block mb-1 fs-6">45</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
