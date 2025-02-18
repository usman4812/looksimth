@php
    $formData = old();
@endphp
@extends('admin.main')
@section('content')
    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_toolbar" class="app-toolbar  d-flex flex-stack py-4 py-lg-8 ">
            <div class="d-flex flex-grow-1 flex-stack flex-wrap gap-2 mb-n10" id="kt_toolbar">
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3 ">

                    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                        Customers Details
                    </h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">

                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.customers') }}" class="text-muted text-hover-primary">Customers</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-gray-900">Details</li>
                    </ul>
                </div>
            </div>
        </div>
        <!--begin::Content-->
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div class="container-fluid">
                <div class="d-flex flex-wrap">
                    <!-- Include Customer Sidebar -->
                    @include('admin.pages.customer.customer_view_sidebar', ['customer' => $customer])
                    <div class="col-lg-9 col-md-8 col-sm-12 p-2">
                        <div class="card w-100 h-100 col-lg-12">
                            <div class="card-header rest-padding colored-customer-detail" style="background: #a4d4a1;">
                                <h2 class="card-title">Meal Plan Settings</h2>
                                <i title="Delivery Info" class="fa-solid fa-truck"></i>
                            </div>
                            <div class="card-body">
                                <div class="w-100 d-flex justify-content-between flex-wrap">
                                    <div><h3>Need a break from our delicious meals?</h3></div>
                                    <div><a href="">Pause or Cancel Your Plan</a></div>
                                </div>
                                <form action="{{ route('admin.customers.plan', $customer->uuid) }}" method="Post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="d-flex flex-wrap">
                                        <div class="col-lg-6 col-md-6 col-sm-12 p-2">
                                            <div class="card w-100 h-100 col-lg-12">
                                                <div class="card-header rest-padding" style="background: #ddd;">
                                                    <h2 class="card-title">Meal Plan</h2>
                                                    <i title="Delivery Info" class="fa-solid fa-truck"></i>
                                                </div>

                                                <div class="card-body">
                                                    <div class="card-inner-sections-setup">
                                                            <div class="form-group">
                                                                <label for="start_date" class="col-form-label fw-semibold fs-6">
                                                                    When to begin meal plan?
                                                                </label>
                                                                <select required name="start_date" aria-label="Select a Meal Plan" data-placeholder="Select a Meal Plan..." class="form-control form-control-sm">
                                                                    <option value="">Select Begin Meal Plan</option>
                                                                    @foreach ($menuOrders as $menuOrder)
                                                                        @php
                                                                            $formattedDeliveryDate = \Carbon\Carbon::parse($menuOrder->delivery_date)->format('Y-m-d');
                                                                            $formattedStartDate = \Carbon\Carbon::parse($customerSubscription->start_date)->format('Y-m-d');
                                                                        @endphp
                                                                        <option value="{{ $formattedDeliveryDate }}"
                                                                                {{ $formattedStartDate == $formattedDeliveryDate ? 'selected' : '' }}>
                                                                            {{ $formattedDeliveryDate }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>

                                                            </div>
                                                            <div class="form-group">
                                                                <label for="email*"
                                                                    class="col-form-label fw-semibold fs-6">When to end meal
                                                                    plan?</label>
                                                                <input type="date" name="end_date"
                                                                    class="form-control form-control-sm"
                                                                    value="{{ \Carbon\Carbon::parse($customerSubscription->end_date)->format('Y-m-d') }}"
                                                                    placeholder="">
                                                            </div>
                                                        <div>
                                                            <?php
                                                            $mealDay = explode(',', $mealDays[0]);
                                                            $dayMapping = [
                                                                'mon' => 'Monday',
                                                                'tue' => 'Tuesday',
                                                                'wed' => 'Wednesday',
                                                                'thu' => 'Thursday',
                                                                'fri' => 'Friday',
                                                                'sat' => 'Saturday',
                                                                'sun' => 'Sunday',
                                                            ];
                                                            $combinedOption = implode(
                                                                ' and ',
                                                                array_map(function ($day) use ($dayMapping) {
                                                                    return isset($dayMapping[$day]) ? $dayMapping[$day] : ucfirst($day);
                                                                }, $mealDay),
                                                            );
                                                            ?>
                                                            <div class="form-group">
                                                                <label for="meal_days"
                                                                    class="required col-form-label fw-semibold fs-6">
                                                                    What days to receive meals?
                                                                </label>
                                                                <select required id="meal_days" name="meal_days"
                                                                    class="form-control form-control-sm">
                                                                    <option value="">Select days Receive Meals
                                                                    </option>
                                                                    <option value="{{ implode(',', $mealDay) }}"
                                                                        {{ $customerSubscription->meal_days == implode(',', $mealDay) ? 'selected' : '' }}>
                                                                        Meals on {{ $combinedOption }}</option>
                                                                    @foreach ($mealDay as $day)
                                                                        <option value="{{ $day }}"
                                                                            {{ $customerSubscription->meal_days == $day ? 'selected' : '' }}>
                                                                            All meals on
                                                                            {{ $dayMapping[$day] ?? ucfirst($day) }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12 p-2">
                                            <div class="card w-100 h-100 col-lg-12">
                                                <div class="card-header rest-padding" style="background: #ddd;">
                                                    <h2 class="card-title">Address</h2>
                                                    <i title="Delivery Info" class="fa-solid fa-truck"></i>
                                                </div>
                                                <div class="card-body">
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label for="auth_number*"
                                                                class="required col-form-label fw-semibold fs-6">Street
                                                                Address</label>
                                                            <input required type="text" name="street1"
                                                                value="{{ $customerAddress->street1 }}"
                                                                class="form-control form-control-sm" placeholder="Street">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label for="*"
                                                                class="col-form-label fw-semibold fs-6">Apt /
                                                                Unit</label>
                                                            <input type="text" name="street2"
                                                                value="{{ $customerAddress->street2 }}"
                                                                class="form-control form-control-sm"
                                                                placeholder="Apt / Unit">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label for="*"
                                                                class="required col-form-label fw-semibold fs-6">City /
                                                                State /
                                                                Zip</label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control form-control-sm"
                                                                    name="city" value="{{ $customerAddress->city }}"
                                                                    placeholder="City" aria-label="City" />
                                                                <span class="input-group-text"
                                                                    style="padding: 0.375rem 0.75rem; font-size: 0.875rem; height: 2.7rem;">
                                                                    NY
                                                                </span>
                                                                <input type="text" class="form-control form-control-sm"
                                                                    name="zip_code" placeholder="Zip Code"
                                                                    aria-label="Zip Code"
                                                                    value="{{ $customerAddress->zip_code }}" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 p-2">

                                        <div class="card w-100 h-100 col-lg-12">
                                            <div class="card-header rest-padding-twenty" style="background: #ddd;">
                                                <h2 class="card-title m-0">Meal Days</h2>
                                                {{-- <i class="fa-solid fa-bowl-food"></i> --}}
                                                <i title="Meal Days & Order Deadline" class="fa-solid fa-bowl-food"></i>
                                            </div>
                                            <div class="card-body">
                                                <div class="row mb-3 align-items-start justify-content-start">
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label for="" class="col-form-label fw-semibold fs-6">When to
                                                                begin
                                                                meal plan?</label>
                                                            <select required name="start_date" aria-label="Select a Meal Plan"
                                                                data-placeholder="Select a Meal Plan..."
                                                                class="form-control form-control-sm">
                                                                <option value="">Select Begin Meal Plan</option>
                                                                @foreach ($menuOrders as $menuOrder)
                                                                    <option value="{{ $menuOrder->delivery_date }}">
                                                                        {{ $menuOrder->delivery_date }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label for="email*" class="col-form-label fw-semibold fs-6">When to end
                                                                meal
                                                                plan?</label>
                                                            <input type="date" name="end_date"
                                                                class="form-control form-control-sm"
                                                                value="{{ @$formData['end_date'] }}" placeholder=""
                                                                min="{{ \Carbon\Carbon::now()->toDateString() }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <?php
                                                        $mealDay = explode(',', @$mealDays[0]);
                                                        $dayMapping = [
                                                            'mon' => 'Monday',
                                                            'tue' => 'Tuesday',
                                                            'wed' => 'Wednesday',
                                                            'thu' => 'Thursday',
                                                            'fri' => 'Friday',
                                                            'sat' => 'Saturday',
                                                            'sun' => 'Sunday',
                                                        ];
                                                        $combinedOption = implode(
                                                            ' and ',
                                                            array_map(function ($day) use ($dayMapping) {
                                                                return isset($dayMapping[$day]) ? $dayMapping[$day] : ucfirst($day);
                                                            }, $mealDay),
                                                        );
                                                        ?>
                                                        <div class="form-group">
                                                            <label for="meal_days" class="required col-form-label fw-semibold fs-6">
                                                                What days to receive meals?
                                                            </label>
                                                            <select required id="meal_days" name="meal_days"
                                                                class="form-control form-control-sm">
                                                                <option value="">Select days Receive Meals</option>
                                                                <option value="<?= implode(',', $mealDay) ?>">
                                                                    Meals on <?= $combinedOption ?>
                                                                </option>
                                                                <?php foreach ($mealDay as $day): ?>
                                                                <option value="<?= $day ?>">
                                                                    All meals on
                                                                    <?= isset($dayMapping[$day]) ? $dayMapping[$day] : ucfirst($day) ?>
                                                                </option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    {{-- <h3 class="mt-8">Meal Plan & Meals included</h3> --}}
                                                    <div class="meal-plan-section">
                                                        <div class="meal-plan-minor-section">
                                                            <h3 class=" mt-lg-4 mt-md-2 mt-sm-2">Meal Plan</h3>
                                                            <div class="mealplan-board-section">
                                                                <div class="d-flex justify-content-between align-items-start w-100 mb-3">
                                                                    <div class="col-lg-6 fv-row fv-plugins-icon-container">
                                                                        <div class="d-flex align-items-center">
                                                                            <label class="form-check form-check-custom form-check-inline  me-2">
                                                                                <input class="form-check-input" name="is_medicaid" type="checkbox"
                                                                                    value="1" data-gtm-form-interact-field-id="1">
                                                                                <span class="fw-semibold ps-2 fs-6">
                                                                                    Medicaid
                                                                                </span><i class="bi bi-info-circle"
                                                                                    title="Account will get meals allowed for Medicaid."
                                                                                    data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                                                    data-bs-dismiss="click" data-bs-placement="top"></i>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6 fv-row fv-plugins-icon-container">
                                                                        <div class="d-flex align-items-center">
                                                                            <label class="form-check form-check-custom form-check-inline  me-2">
                                                                                <input class="form-check-input" name="is_cafeteria" type="checkbox"
                                                                                    value="1" data-gtm-form-interact-field-id="1">
                                                                                <span class="fw-semibold ps-2 fs-6">
                                                                                    Cafeteria
                                                                                </span><i class="bi bi-info-circle"
                                                                                    title="Account will get meals allowed for Cafeteria."
                                                                                    data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                                                    data-bs-dismiss="click" data-bs-placement="top"></i>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="mealplan-board-second-section">
                                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                                        <div class="form-group">
                                                                            {{-- <div class="w-100 d-flex justify-content-between align-items-start"> --}}
                                                                                <label for="quantity*"
                                                                                class="required col-form-label fw-semibold fs-6">Quantity</label>
                                                                                {{-- <label
                                                                                    class="form-check form-check-custom form-check-inline is-valid">
                                                                                    <input class="form-check-input" name="quantity_min"
                                                                                        type="checkbox" value="{{ @$formData['quantity_min'] }}"
                                                                                        value="1" data-gtm-form-interact-field-id="1">
                                                                                    <span class="fw-semibold ps-2 fs-6">
                                                                                        Minimum</span>
                                                                                </label>
                                                                            </div> --}}
                                                                            {{-- <label for="quantity*"
                                                                                class="required col-form-label fw-semibold fs-6">Quantity</label> --}}
                                                                            <div class="d-flex align-items-center">
                                                                                <input required type="text" name="quantity"
                                                                                    class="form-control form-control-sm"
                                                                                    value="{{ @$formData['quantity'] }}" placeholder="Meals per week">
                                                                                {{-- <span class="fw-semibold fs-6 ms-3" style="white-space: nowrap;">meals
                                                                                    per
                                                                                    week</span> --}}
                                                                            </div>
                                                                            <div class="d-flex align-items-center mt-3">
                                                                                <label
                                                                                    class="form-check form-check-custom form-check-inline  me-5 is-valid">
                                                                                    <input class="form-check-input" name="quantity_min"
                                                                                        type="checkbox" value="{{ @$formData['quantity_min'] }}"
                                                                                        value="1" data-gtm-form-interact-field-id="1">
                                                                                    <span class="fw-semibold ps-2 fs-6">
                                                                                        Minimum</span>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                                        <div class="form-group">
                                                                            <label for="password*"
                                                                                class="required col-form-label fw-semibold fs-6">Meal
                                                                                Size</label>
                                                                            <select id="meal_size_id" name="meal_size_id"
                                                                                data-placeholder="Select a Meal Size..."
                                                                                class="form-control form-control-sm">
                                                                                <option value="">Select Meal Size</option>
                                                                                @foreach ($mealSizes as $mealSize)
                                                                                    <option value="{{ $mealSize->uuid }}">{{ $mealSize->title }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="meal-plan-major-section">
                                                            <h3 class=" mt-lg-4 mt-md-2 mt-sm-2">Meals Included</h3>
                                                            <div class="mealplan-board-section">
                                                                <div class="col-lg-12">
                                                                    {{-- <h5 class="">Meals included</h5> --}}
                                                                    <div class="row">
                                                                        <div class="col-lg-4 col-md-4 col-sm-12">
                                                                            <label class="required fw-semibold fs-6">Any:</label>
                                                                            <input required type="number" class="form-control form-control-sm"
                                                                                name="num_meals_any" value="{{ @$formData['num_meals_any'] }}"
                                                                                placeholder="Any" />
                                                                        </div>
                                                                        <div class="col-lg-4 col-md-4 col-sm-12">
                                                                            <label class="required fw-semibold fs-6">Breakfast:</label>
                                                                            <input required type="number" class="form-control form-control-sm"
                                                                                name="num_meals_breakfast"
                                                                                value="{{ @$formData['num_meals_breakfast'] }}"
                                                                                placeholder="Breakfast" />
                                                                        </div>
                                                                        <div class="col-lg-4 col-md-4 col-sm-12">
                                                                            <label class="required fw-semibold fs-6">Lunch/Dinner:</label>
                                                                            <input required type="number" class="form-control form-control-sm"
                                                                                name="num_meals_lunch_dinner"
                                                                                value="{{ @$formData['num_meals_lunch_dinner'] }}"
                                                                                placeholder="Lunch/Dinner" />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-12 mt-5">
                                                                    <span class="mt-5">Auto-select configuration</span><i
                                                                        class="bi bi-info-circle ms-2"
                                                                        title="Leave blank to split meals evenly for the week."
                                                                        data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click"
                                                                        data-bs-placement="top"></i>
                                                                    <div class="table mb-0">
                                                                        <table class="table mb-0" id="meal_size_table">
                                                                            <tr class="fw-bold bg-light text-align-center">
                                                                                <th class="ps-4">Days</th>
                                                                                <th class="center-table-text">Any</th>
                                                                                <th class="center-table-text">Breakfast</th>
                                                                                <th class="center-table-text">Lunch/Dinner</th>
                                                                            </tr>
                                                                            <?php $mealDay = explode(',', $mealDays[0]); ?>
                                                                            @foreach ($mealDay as $key => $day)
                                                                                <tr>
                                                                                    <td class="align-middle">
                                                                                        <label
                                                                                            class="fw-semibold fs-6">{{ ucfirst($day) }}</label>
                                                                                    </td>
                                                                                    <td>
                                                                                        <input type="text"
                                                                                            name="mealDay[auto_any_{{ $key }}]"
                                                                                            id="auto_any_0_{{ $key }}"
                                                                                            class="form-control form-control-sm" placeholder="">
                                                                                    </td>
                                                                                    <td>
                                                                                        <input type="text"
                                                                                            name="mealDay[auto_breakfast_{{ $key }}]"
                                                                                            id="auto_breakfast_0_{{ $key }}"
                                                                                            class="form-control form-control-sm" placeholder="">
                                                                                    </td>
                                                                                    <td>
                                                                                        <input type="text"
                                                                                            name="mealDay[auto_lunch_dinner_{{ $key }}]"
                                                                                            id="auto_lunch_dinner_0_{{ $key }}"
                                                                                            class="form-control form-control-sm" placeholder="">
                                                                                    </td>
                                                                                </tr>
                                                                            @endforeach
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end::Card body-->
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 p-2">
                                        <div class="card w-100 h-100 col-lg-12">
                                            <div class="card-header rest-padding" style="background: #ddd;">
                                                <h2 class="card-title">Delivery or Pickup</h2>
                                                <i title="Delivery Info" class="fa-solid fa-truck"></i>
                                            </div>


                                            <div class="card-body">
                                                <div class="row mb-3 align-items-center">
                                                    <div class="col-lg-12">
                                                        <div class="d-flex align-items-center justify-content-center">
                                                            <label
                                                                class="form-check form-check-custom form-check-inline  me-2">
                                                                How do you want to receive your Meal
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="d-flex align-items-center justify-content-center w-100">
                                                <div class="col-md-11 col-lg-11 col-xxl-11">
                                                    <label class="btn main-requirement-box custom-card">
                                                        <div class="main-requirement-box-text-section">
                                                            <input
                                                                type="checkbox"
                                                                name="diet_uuids[]"
                                                                class="custom-checkbox"
                                                            >
                                                            <div class="checkbox-circle">
                                                                <span class="tick-icon"></span>
                                                            </div>
                                                            <p>
                                                                Delivery on Tue and Fri (2pm - 8pm)</p>
                                                        </div>
                                                        <span>Home Delivery- Meals Delivered
                                                            by hand to your home by our own drivers. First delivery includes
                                                            an EH cooler bag. Please leave bag out with ice packs if you
                                                            will not be home.</span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-center w-100 mt-5">
                                                <div class="col-md-11 col-lg-11 col-xxl-11">
                                                    <label class="btn main-requirement-box custom-card">
                                                        <div class="main-requirement-box-text-section">
                                                            <input
                                                                type="checkbox"
                                                                name="diet_uuids[]"
                                                                class="custom-checkbox"
                                                            >
                                                            <div class="checkbox-circle">
                                                                <span class="tick-icon"></span>
                                                            </div>
                                                            <p>
                                                                Delivery on Tue and Fri (2pm - 8pm)</p>
                                                        </div>
                                                        <span>Pickup at our Store: 1440 Scottsville Road, 14624 – Tue and Fri
                                                            (Tue: 8am - 5:30pm | Fri: 10am - 4:30pm)</span>
                                                    </label>
                                                </div>

                                            </div>
                                            <div class="d-flex align-items-center justify-content-center w-100 mt-5">
                                                <div class="col-md-11 col-lg-11 col-xxl-11">
                                                    <label class="btn main-requirement-box custom-card">
                                                        <div class="main-requirement-box-text-section">
                                                            <input
                                                                type="checkbox"
                                                                name="diet_uuids[]"
                                                                class="custom-checkbox"
                                                            >
                                                            <div class="checkbox-circle">
                                                                <span class="tick-icon"></span>
                                                            </div>
                                                            <p>
                                                                Delivery on Tue and Fri (2pm - 8pm)</p>
                                                        </div>
                                                        <span>Pickup at our Store: 1440 Scottsville Road, 14624 – Wed and Fri
                                                            (Wed: 9am - 2pm | Fri: 10am - 4pm)</span>
                                                    </label>
                                                </div>

                                            </div>
                                            <div class="d-flex align-items-center justify-content-center w-100 mt-5">
                                                <div class="col-md-11 col-lg-11 col-xxl-11">
                                                    <label class="btn main-requirement-box custom-card">
                                                        <div class="main-requirement-box-text-section">
                                                            <input
                                                                type="checkbox"
                                                                name="diet_uuids[]"
                                                                class="custom-checkbox"
                                                            >
                                                            <div class="checkbox-circle">
                                                                <span class="tick-icon"></span>
                                                            </div>
                                                            <p>
                                                                Delivery on Tue and Fri (2pm - 8pm)</p>
                                                        </div>
                                                        <span>Pickup at URMC: School of Medicine Silver Clock Lot- on Tue and
                                                            Fri (Tue: 4pm - 6pm | Fri: 4pm - 5:30pm)</span>
                                                    </label>
                                                </div>

                                            </div>

                                            <div class="tab-content mt-5 mb-10" id="pills-tabContent">
                                                <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                                                    aria-labelledby="pills-home-tab" tabindex="0">
                                                    <div class="d-flex flex-column align-items-center text-center mt-5"
                                                        id="drlivery-info">
                                                        <div class="col-lg-2 mb-4">
                                                            <label class="fw-semibold fs-6">Driver #</label>
                                                            <input type="text" class="form-control form-control-sm"
                                                                name="driver_number"
                                                                value="{{ @$formData['driver_number'] }}"
                                                                placeholder="Driver #" />
                                                        </div>
                                                        <div class="fs-6 mt-3 mb-2">Special Delivery Instructions
                                                            (Optional)</div>
                                                        <div class="col-lg-5">
                                                            <textarea name="delivery_instructions" class="form-control form-control-sm"
                                                                placeholder="Please enter preferred drop off location, ringing the doorbell, etc."></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" id="pills-profile" role="tabpanel"
                                                    aria-labelledby="pills-profile-tab" tabindex="0"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-end py-6 px-9">
                                        <button type="submit"
                                            class="btn btn-sm btn-primary d-flex justify-content-center align-items-center">Update
                                            Plan</button>
                                    </div>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Content-->
        </div>
    @endsection
