@php
    $formData = old();
@endphp
@extends('admin.main')
@push('style')
    <style>
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
                                <h2 class="card-title">Account Info</h2>
                                <i title="Delivery Info" class="fa-solid fa-truck"></i>
                            </div>
                            <div class="d-flex flex-column flex-column-fluid">
                                <form action="{{ route('admin.customers.user', $customer) }}" method="Post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="card-body">
                                        <div class="row mb-3 align-items-center">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="name*"
                                                        class="required col-form-label fw-semibold fs-6">Full
                                                        Name</label>
                                                    <input required type="text" name="name"
                                                        value="{{ $customer->name }}" class="form-control form-control-sm"
                                                        placeholder="Full Name">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="email*"
                                                        class="required col-form-label fw-semibold fs-6">Email</label>
                                                    <input required type="email" name="email"
                                                        value="{{ $customer->email }}" class="form-control form-control-sm"
                                                        placeholder="Email">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="password*"
                                                        class="col-form-label fw-semibold fs-6">Password</label>
                                                    <div class="position-relative">
                                                        <input type="password" name="password"
                                                            value="{{ @$formData['password'] }}"
                                                            class="form-control form-control-sm" minlength="6"
                                                            maxlength="8" id="passwordInput">
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
                                                    <label for="phone*"
                                                        class="required col-form-label fw-semibold fs-6">Phone
                                                        Number</label>
                                                    <input required type="integer" name="phone"
                                                        value="{{ $customer->address->phone }}"
                                                        class="form-control form-control-sm" placeholder="phone">
                                                    <label
                                                        class="mt-5 form-check form-check-custom form-check-inline  me-5">
                                                        <input class="form-check-input" name="text_enabled" type="checkbox"
                                                            value="1" data-gtm-form-interact-field-id="1"
                                                            {{ $customer->address->text_enabled == 1 ? 'checked=""' : '' }}>
                                                        <span class="fw-semibold ps-2 fs-6">
                                                            Send me text notifications
                                                        </span><i class="bi bi-info-circle"
                                                            title="Mobile number required. Message & data rates may apply."
                                                            data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                            data-bs-dismiss="click" data-bs-placement="top"></i>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="institution*"
                                                        class="col-form-label fw-semibold fs-6">Institution</label>
                                                    <input type="text" name="institution"
                                                        value="{{ $customer->institution }}"
                                                        class="form-control form-control-sm" placeholder="">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="employee_id*"
                                                        class="col-form-label fw-semibold fs-6">Employee ID</label>
                                                    <input type="text" name="employee_id"
                                                        value="{{ $customer->employee_id }}"
                                                        class="form-control form-control-sm" placeholder="">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="employee_location*"
                                                        class="col-form-label fw-semibold fs-6">Employee
                                                        Location
                                                    </label>
                                                    <input type="text" name="employee_location"
                                                        value="{{ $customer->employee_location }}"
                                                        class="form-control form-control-sm" placeholder="">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="date_of_birth"
                                                        class="col-form-label fw-semibold fs-6">Date of Birth</label>
                                                    <input type="date" name="date_of_birth"
                                                        value="{{  \Carbon\Carbon::parse($customer->date_of_birth)->format('Y-m-d') }}"
                                                        class="form-control form-control-sm" placeholder="">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="customer_group"
                                                        class="required col-form-label fw-semibold fs-6">Customer
                                                        Group</label>
                                                    <button data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="Add Customer Group" type="button"
                                                        class="btn custom-btn btn-sm btn-secondary ms-3"
                                                        id="openCustomerGroupModal">
                                                        <i class="ki-duotone ki-plus"></i>
                                                    </button>
                                                    <select id="customer_group_dropdwon" name="customer_group_id"
                                                        ria-label="Select Customer Group"
                                                        data-placeholder="Select Customer Group..."
                                                        class="form-control form-control-sm">
                                                        <option value="">Select Customer Group</option>
                                                        @foreach ($customerGroups as $customerGroup)
                                                            <option value="{{ $customerGroup->uuid }}"{{ $customerGroup->uuid == $customer->customer_group_id ? 'selected' : '' }}>{{ $customerGroup->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="name*"
                                                        class="required col-form-label fw-semibold fs-6">Auth
                                                        Number</label>
                                                    <input required type="text" name="auth_number" value="{{ $customer->auth_number }}"
                                                        class="form-control form-control-sm" placeholder="">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="name*"
                                                        class="required col-form-label fw-semibold fs-6">Source</label>
                                                    <button data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="Add Source-" type="button"
                                                        class="btn custom-btn btn-sm btn-secondary ms-3"
                                                        id="openSourceModal">
                                                        <i class="ki-duotone ki-plus"></i>
                                                    </button>
                                                    <select id="source_dropdwon" name="source"
                                                        class="form-control form-control-sm">
                                                        <option value="">Select Source</option>
                                                        @foreach ($sources as $source)
                                                            <option value="{{ $source->name }}" {{ $source->name == $customer->source ? 'selected' : '' }}>{{ $source->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="paper_menu_type_id*"
                                                        class="col-form-label fw-semibold fs-6">Paper menu</label>
                                                    <select id="paper_menu_type_id" name="paper_menu_type_id"
                                                        class="form-control form-control-sm">
                                                        <option value="">Select Source</option>
                                                        <option value="none" {{ $customer->paper_menu_type_id == 'none' ? 'selected' : '' }}>None</option>
                                                        <option value="full" {{ $customer->paper_menu_type_id == 'full' ? 'selected' : '' }}>Full</option>
                                                        <option value="medicaid" {{ $customer->paper_menu_type_id == 'medicaid' ? 'selected' : '' }}>Medicaid</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <label class="mt-5 form-check form-check-custom form-check-inline  me-5">
                                                    <input class="form-check-input" name="active" type="checkbox"
                                                    value="1" {{ old('active', $customer->active) == 1 ? 'checked' : '' }}>
                                                    <span class="fw-semibold ps-2 fs-6">
                                                        Active Customer
                                                    </span>
                                                </label>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label
                                                        class="mt-5 form-check form-check-custom form-check-inline  me-5">
                                                        <input class="form-check-input" name="has_cooler_bag"
                                                            type="checkbox" value="1"
                                                            data-gtm-form-interact-field-id="1"
                                                            {{ $customer->has_cooler_bag == 1 ? 'checked=""' : '' }}>
                                                        <span class="fw-semibold ps-2 fs-6">
                                                            Has Cooler Bag
                                                        </span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-end py-6 px-9">
                                            <button type="submit"
                                                class="btn btn-sm btn-primary d-flex justify-content-center align-items-center">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="dynamicModalContainer">

    </div>
@endsection
{{-- @push('script') --}}
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
{{-- Source Modal Return --}}
<script>
    $(document).on('click', '#openSourceModal', function() {
        loadSourceModal();
    });

    function loadSourceModal() {
        $.ajax({
            url: "{{ route('get.source.modal') }}",
            type: 'GET',
            beforeSend: function() {
                showOverlay();
            },
            success: function(response) {
                hideOverlay();
                if (response.success) {
                    $('#dynamicModalContainer').html(response.html);
                    var modal = new bootstrap.Modal(document.getElementById('add_source_modal'));
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
{{-- @endpush --}}
