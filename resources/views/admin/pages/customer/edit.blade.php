@php
    $formData = old();
@endphp
@extends('admin.main')
@push('style')
    <style>
        .hidden {
            display: none;
        }

        .border-ul-delivery-pickup {
            width: auto;
            border: 1px solid #F4F4F4;
            padding: 5px;
            border-radius: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .border-ul-delivery-pickup ul {
            align-items: center;
            margin: 0px !important;
        }
        .custom-btn {
            padding: 0.5px 0.5px;
            font-size: 5px;
            border-radius: 2px;
        }

        .custom-btn i {
            font-size: 10px;
        }
    </style>
@endpush
@section('content')
    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_toolbar" class="app-toolbar  d-flex flex-stack py-4 py-lg-8 ">
            <div class="d-flex flex-grow-1 flex-stack flex-wrap gap-2 mb-n10" id="kt_toolbar">
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3 ">

                    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                        Update Customers
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
                        <li class="breadcrumb-item text-gray-900">Edit</li>
                    </ul>
                </div>
            </div>
        </div>
        <div id="kt_app_content" class="app-content  flex-column-fluid">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.customers.edit', $editCustomer->uuid) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card">
                            <div class="card-header" style="background: #ddd;">
                                <h2 class="card-title">Account Info</h2>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3 align-items-center">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="name*" class="required col-form-label fw-semibold fs-6">Full
                                                Name</label>
                                            <input required type="text" name="name" value="{{ $editCustomer->name }}"
                                                class="form-control form-control-sm" placeholder="Full Name">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="email*"
                                                class="required col-form-label fw-semibold fs-6">Email</label>
                                            <input required type="email" name="email" value="{{ $editCustomer->email }}"
                                                class="form-control form-control-sm" placeholder="Email">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="password*"
                                                class="required col-form-label fw-semibold fs-6">Password</label>
                                            <div class="position-relative mb-3">
                                                <input type="password" name="password" required
                                                    value="{{ @$formData['password'] }}"
                                                    class="form-control form-control-sm" minlength="6" maxlength="8"
                                                    id="passwordInput">
                                                <button type="button"
                                                    class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2"
                                                    id="togglePassword">
                                                    <i class="ki-outline ki-eye-slash fs-2"></i>
                                                    <i class="ki-outline ki-eye fs-2 d-none"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="phone*" class="required col-form-label fw-semibold fs-6">Phone
                                                Number</label>
                                            <input required type="integer" name="phone"
                                                value="{{ $editCustomer->address->phone }}"
                                                class="form-control form-control-sm" placeholder="phone">
                                            <label class="mt-5 form-check form-check-custom form-check-inline  me-5">
                                                <input class="form-check-input" name="text_enabled" type="checkbox"
                                                    value="1" data-gtm-form-interact-field-id="1"
                                                    {{ $editCustomer->address->text_enabled == 1 ? 'checked=""' : '' }}>
                                                <span class="fw-semibold ps-2 fs-6">
                                                    Send me text notifications
                                                </span><i class="bi bi-info-circle"
                                                    title="Mobile number required. Message & data rates may apply."
                                                    data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click"
                                                    data-bs-placement="top"></i>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="customer_group"
                                                class="required col-form-label fw-semibold fs-6">Customer Group</label>
                                            <button data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="Add Customer Group" type="button"
                                                class="btn custom-btn btn-sm btn-secondary ms-3"
                                                id="openCustomerGroupModal">
                                                <i class="ki-duotone ki-plus"></i>
                                            </button>
                                            <select id="customer_group_dropdwon" name="customer_group_id"
                                                class="form-control form-control-sm">
                                                <option value="">Select Customer Group</option>
                                                 @foreach ($customerGroups as $customerGroup)
                                                    <option value="{{ $customerGroup->uuid }}"
                                                        {{ $customerGroup->uuid == $editCustomer->customer_group_id ? 'selected' : '' }}>
                                                        {{ $customerGroup->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="auth_number*"
                                                class="required col-form-label fw-semibold fs-6">Auth
                                                Number</label>
                                            <input required type="text" name="auth_number"
                                                value="{{ $editCustomer->auth_number }}"
                                                class="form-control form-control-sm" placeholder="Auth Number">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="auth_number*"
                                                class="required col-form-label fw-semibold fs-6">Street Address</label>
                                            <input required type="text" name="street1"
                                                value="{{ $editCustomer->address->street1 }}"
                                                class="form-control form-control-sm" placeholder="Street">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="*" class="col-form-label fw-semibold fs-6">Apt /
                                                Unit</label>
                                            <input type="text" name="street2"
                                                value="{{ $editCustomer->address->street2 }}"
                                                class="form-control form-control-sm" placeholder="Apt / Unit">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="*" class="required col-form-label fw-semibold fs-6">City /
                                                State / Zip</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm" name="city"
                                                    value="{{ $editCustomer->address->city }}" placeholder="City"
                                                    aria-label="City" />
                                                <span class="input-group-text"
                                                    style="padding: 0.375rem 0.75rem; font-size: 0.875rem; height: 2.7rem;">
                                                    NY
                                                </span>
                                                <input type="text" class="form-control form-control-sm"
                                                    name="zip_code" placeholder="Zip Code" aria-label="Zip Code"
                                                    value="{{ $editCustomer->address->zip_code }}" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <label class="mt-5 form-check form-check-custom form-check-inline  me-5">
                                            <input class="form-check-input" name="active" type="checkbox"
                                                value="1" data-gtm-form-interact-field-id="1"
                                                {{ $editCustomer->active == 1 ? 'checked=""' : '' }}>
                                            <span class="fw-semibold ps-2 fs-6">
                                              Active Customer
                                            </span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <!--end::Card body-->
                        </div>
                        <div class="card mt-5">
                            <div class="card-header" style="background: #ddd;">
                                <h2 class="card-title">Meal Days</h2>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3 align-items-center">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="" class="col-form-label fw-semibold fs-6">When to begin
                                                meal plan?</label>
                                            <select required name="start_date" aria-label="Select a Meal Plan"
                                                data-placeholder="Select a Meal Plan..."
                                                class="form-control form-control-sm">
                                                <option value="">Select Begin Meal Plan</option>
                                                @foreach ($menuOrders as $menuOrder)
                                                    <option
                                                        value="{{ \Carbon\Carbon::parse($menuOrder->delivery_date)->format('Y-m-d') }}"
                                                        {{ \Carbon\Carbon::parse($editCustomer->ehMealSubscription->delivery_date)->format('Y-m-d') == \Carbon\Carbon::parse($menuOrder->delivery_date)->format('Y-m-d') ? 'selected' : '' }}>
                                                        {{ \Carbon\Carbon::parse($menuOrder->delivery_date)->format('Y-m-d') }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="end_date" class="col-form-label fw-semibold fs-6">When to end meal
                                                plan?</label>
                                            <input type="date" name="end_date" class="form-control form-control-sm"
                                                value="{{ \Carbon\Carbon::parse($editCustomer->ehMealSubscription->end_date)->format('Y-m-d') }}"
                                                placeholder=""  min="{{ \Carbon\Carbon::now()->toDateString() }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <?php
                                        $mealDay = explode(',', $mealDays[0]);
                                        $dayMapping = [
                                            'mon' => 'Monday',
                                            'tue' => 'Tuesday',
                                            'wed' => 'Wednesday',
                                            'thu' => 'Thursday',
                                            'fri' => 'Friday',
                                            'sat' => 'Saturday',
                                            'sun' => 'Sunday'
                                        ];
                                        $combinedOption = implode(' and ', array_map(function($day) use ($dayMapping) {
                                            return isset($dayMapping[$day]) ? $dayMapping[$day] : ucfirst($day);
                                        }, $mealDay));
                                        ?>
                                        <div class="form-group">
                                            <label for="meal_days" class="required col-form-label fw-semibold fs-6">
                                                What days to receive meals?
                                            </label>
                                            <select required id="meal_days" name="meal_days" class="form-control form-control-sm">
                                                <option value="">Select days Receive Meals</option>
                                                <option value="{{ implode(',', $mealDay) }}" {{ $editCustomer->ehMealSubscription->meal_days == implode(',', $mealDay) ? 'selected' : '' }}>
                                                    Meals on {{ $combinedOption }}
                                                </option>
                                                @foreach ($mealDay as $day)
                                                    <option value="{{ $day }}" {{ $editCustomer->ehMealSubscription->meal_days == $day ? 'selected' : '' }}>
                                                        All meals on {{ $dayMapping[$day] ?? ucfirst($day) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <h3 class="mt-8">Meal Plan</h3>
                                    <div class="col-lg-2 fv-row fv-plugins-icon-container">
                                        <div class="d-flex align-items-center">
                                            <label class="form-check form-check-custom form-check-inline me-2">
                                                <input class="form-check-input" name="is_medicaid" type="checkbox"
                                                    value="1" data-gtm-form-interact-field-id="1"
                                                    {{ $editCustomer->ehMealSubscription->is_medicaid == 1 ? 'checked' : '' }}>
                                                <span class="fw-semibold ps-2 fs-6">
                                                    Medicaid
                                                </span>
                                                <i class="bi bi-info-circle"
                                                    title="Account will get meals allowed for Medicaid."
                                                    data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                    data-bs-dismiss="click" data-bs-placement="top"></i>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-lg-2 fv-row fv-plugins-icon-container">
                                        <div class="d-flex align-items-center">
                                            <label class="form-check form-check-custom form-check-inline  me-2">
                                                <input class="form-check-input" name="is_cafeteria" type="checkbox"
                                                    value="1" data-gtm-form-interact-field-id="1"
                                                    {{ $editCustomer->ehMealSubscription->is_cafeteria == 1 ? 'checked' : '' }}>
                                                <span class="fw-semibold ps-2 fs-6">
                                                    Cafeteria
                                                </span><i class="bi bi-info-circle"
                                                    title="Account will get meals allowed for Cafeteria."
                                                    data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                    data-bs-dismiss="click" data-bs-placement="top"></i>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="quantity*"
                                                class="required col-form-label fw-semibold fs-6">Quantity</label>
                                            <div class="d-flex align-items-center">
                                                <input required type="text" name="quantity"
                                                    class="form-control form-control-sm"
                                                    value="{{ $editCustomer->planVariant->quantity }}" placeholder="">
                                                <span class="fw-semibold fs-6 ms-3" style="white-space: nowrap;">meals per
                                                    week</span>
                                            </div>
                                            <div class="d-flex align-items-center mt-3">
                                                <label
                                                    class="form-check form-check-custom form-check-inline  me-5 is-valid">
                                                    <input class="form-check-input" name="quantity_min" type="checkbox"
                                                        {{ $editCustomer->planVariant->quantity_min == 1 ? 'checked' : '' }}
                                                        value="1" data-gtm-form-interact-field-id="1">
                                                    <span class="fw-semibold ps-2 fs-6">
                                                        Minimum</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 mb-9">
                                        <div class="form-group">
                                            <label for="password*" class="required col-form-label fw-semibold fs-6">Meal
                                                Size</label>
                                            <select id="meal_size_id" name="meal_size_id"
                                                data-placeholder="Select a Meal Size..."
                                                class="form-control form-control-sm">
                                                <option value="">Select Meal Size</option>
                                                @foreach ($mealSizes as $mealSize)
                                                    <option value="{{ $mealSize->uuid }}"
                                                        {{ $mealSize->uuid == $editCustomer->planVariant->meal_size_id ? 'selected' : '' }}>
                                                        {{ $mealSize->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-5">
                                        <h5 class="">Meals included</h5>
                                        <div class="row">
                                            <!-- First Field -->
                                            <div class="col-lg-4">
                                                <label class="required fw-semibold fs-6">Any:</label>
                                                <input required type="number" class="form-control form-control-sm"
                                                    name="num_meals_any"
                                                    value="{{ $editCustomer->planVariant->num_meals_any }}"
                                                    placeholder="Any" />
                                            </div>
                                            <div class="col-lg-4">
                                                <label class="required fw-semibold fs-6">Breakfast:</label>
                                                <input required type="number" class="form-control form-control-sm"
                                                    name="num_meals_breakfast"
                                                    value="{{ $editCustomer->planVariant->num_meals_breakfast }}"
                                                    placeholder="Breakfast" />
                                            </div>
                                            <div class="col-lg-4">
                                                <label class="required fw-semibold fs-6">Lunch/Dinner:</label>
                                                <input required type="number" class="form-control form-control-sm"
                                                    name="num_meals_lunch_dinner"
                                                    value="{{ $editCustomer->planVariant->num_meals_lunch_dinner }}"
                                                    placeholder="Lunch/Dinner" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-7 mt-5">
                                        <span class="mt-5">Auto-select configuration</span><i
                                            class="bi bi-info-circle ms-2"
                                            title="Leave blank to split meals evenly for the week."
                                            data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click"
                                            data-bs-placement="top"></i>
                                        <div class="table">
                                            <table class="table" id="meal_size_table">
                                                <tr class="fw-bold bg-light">
                                                    <th class="ps-4 min-w-150px rounded-start"></th>
                                                    <th>Any</th>
                                                    <th>Breakfast</th>
                                                    <th>Lunch/Dinner</th>
                                                </tr>
                                                <?php $mealDay = explode(',', $mealDays[0]); ?>
                                                @foreach ($mealDay as $key => $day)
                                                    <tr>
                                                        <td class="align-middle">
                                                            <label class="fw-semibold fs-6">{{ ucfirst($day) }}</label>
                                                        </td>
                                                        <td>
                                                            <input type="text"
                                                                name="mealDay[auto_any_{{ $key }}]"
                                                                value="{{ $editCustomer->planVariant->{'auto_any_' . $key} }}"
                                                                id="auto_any_{{ $key }}"
                                                                class="form-control form-control-sm" placeholder="">
                                                        </td>
                                                        <td>
                                                            <input type="text"
                                                                name="mealDay[auto_breakfast_{{ $key }}]"
                                                                value="{{ $editCustomer->planVariant->{'auto_breakfast_' . $key} }}"
                                                                id="auto_breakfast_{{ $key }}"
                                                                class="form-control form-control-sm" placeholder="">
                                                        </td>
                                                        <td>
                                                            <input type="text"
                                                                name="mealDay[auto_lunch_dinner_{{ $key }}]"
                                                                value="{{ $editCustomer->planVariant->{'auto_lunch_dinner_' . $key} }}"
                                                                id="auto_lunch_dinner_{{ $key }}"
                                                                class="form-control form-control-sm" placeholder="">
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Card body-->
                        </div>
                        <div class="card mt-5">
                            <div class="card-header" style="background: #ddd;">
                                <h2 class="required card-title">Meal Preferences</h2>
                            </div>
                            <div class="card-body">
                                <div class="row mb-6 ingredient-container">
                                    <div>Please check if they can eat the item:</div>
                                    @foreach ($ingredients as $ingredient)
                                        <div class="col-lg-3 fv-row fv-plugins-icon-container mt-2">
                                            <div class="d-flex align-items-center">
                                                <label class="form-check form-check-custom form-check-inline me-2">
                                                    <input class="form-check-input" name="ingredients[]" type="checkbox"
                                                        value="{{ $ingredient->uuid }}"
                                                        {{ $editCustomer->userIngredients->contains('uuid', $ingredient->uuid) ? 'checked' : '' }}
                                                        data-gtm-form-interact-field-id="1">
                                                    <span class="fw-semibold ps-2 fs-6">
                                                        {{ $ingredient->name }}
                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="row mb-6 diets-container">
                                    <div>Please check any dietary requirements:</div>
                                    @foreach ($diets as $diet)
                                        <div class="col-lg-3 fv-row fv-plugins-icon-container mt-2">
                                            <div class="d-flex align-items-center">
                                                <label class="form-check form-check-custom form-check-inline me-2">
                                                    <input class="form-check-input" name="diets[]" type="checkbox"
                                                        value="{{ $diet->uuid }}" data-gtm-form-interact-field-id="1"
                                                        {{ $editCustomer->userDiets->contains('uuid', $diet->uuid) ? 'checked' : '' }}>
                                                    <span class="fw-semibold ps-2 fs-6">
                                                        {{ $diet->name }}
                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="card mt-5">
                            <div class="card-header" style="background: #ddd;">
                                <h2 class="card-title">Delivery or Pickup</h2>
                            </div>
                            <div class="card-body">
                                <div class="text-center">How do you want to receive your meals?</div>
                                <div class="d-flex w-100 justify-content-center mt-3">
                                    <div class="border-ul-delivery-pickup">
                                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
                                                    data-bs-target="#pills-home" type="button" role="tab"
                                                    aria-controls="pills-home" aria-selected="true">Delivery</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill"
                                                    data-bs-target="#pills-profile" type="button" role="tab"
                                                    aria-controls="pills-profile" aria-selected="false">Pickup at
                                                    Store</button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="tab-content" id="pills-tabContent">
                                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                                        aria-labelledby="pills-home-tab" tabindex="0">
                                        <div class="d-flex flex-column align-items-center text-center mt-5"
                                            id="drlivery-info">
                                            <div class="col-lg-2 mb-4">
                                                <label class="fw-semibold fs-6">Driver #</label>
                                                <input type="text" class="form-control form-control-sm"
                                                    name="driver_number"
                                                    value="{{ $editCustomer->address->driver_number }}"
                                                    placeholder="Driver #" />
                                            </div>
                                            <div class="fs-6 mt-3 mb-2">Special Delivery Instructions (Optional)</div>
                                            <div class="col-lg-5">
                                                <textarea name="delivery_instructions" class="form-control form-control-sm"
                                                    placeholder="Please enter preferred drop off location, ringing the doorbell, etc.">{{ $editCustomer->address->delivery_instructions }}</textarea>
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
                                class="btn btn-sm btn-primary d-flex justify-content-center align-items-center">
                                <i class="fa-solid fa-plus"></i>Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="dynamicModalContainer">

    </div>
@endsection
@push('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).on('click', '#openCustomerGroupModal', function() {
            loadCustomerGroupModal();
        });
        function loadCustomerGroupModal() {
            $.ajax({
                url: "{{ route('get.customer.group.modal') }}",
                type: 'GET',
                beforeSend: function() {
                    showOverlay();
                },
                success: function(response) {
                    hideOverlay();
                    if (response.success) {
                        $('#dynamicModalContainer').html(response.html);
                        var modal = new bootstrap.Modal(document.getElementById('add_customer_group'));
                        modal.show();
                    } else {
                        swalAlert('Failed to load modal. Please try again.', 'error', 'btn btn-danger');
                    }
                },
                error: function(xhr) {
                    hideOverlay();
                    swalAlert('Something went wrong while loading the modal.', 'error', 'btn btn-danger');
                },
            });
        }
    </script>
    <script>
        $(document).ready(function() {
            $('#togglePassword').on('click', function() {
                const passwordInput = $('#passwordInput');
                const eyeSlashIcon = $(this).find('.ki-eye-slash');
                const eyeIcon = $(this).find('.ki-eye');
                if (passwordInput.attr('type') === 'password') {
                    passwordInput.attr('type', 'text');
                    eyeSlashIcon.addClass('d-none');
                    eyeIcon.removeClass('d-none');
                } else {
                    passwordInput.attr('type', 'password');
                    eyeSlashIcon.removeClass('d-none');
                    eyeIcon.addClass('d-none');
                }
            });
        });
    </script>
@endpush
