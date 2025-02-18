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
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div class="container-fluid">
                <div class="d-flex flex-wrap">
                    <!-- Include Customer Sidebar -->
                    @include('admin.pages.customer.customer_view_sidebar', ['customer' => $customer])
                    <div class="col-lg-9 col-md-8 col-sm-12 p-2">
                        <div class="card w-100 h-100 col-lg-12">
                            <div class="card-header rest-padding colored-customer-detail" style="background: #a4d4a1;">
                                <h2 class="card-title">Payment Info</h2>
                                <i title="Delivery Info" class="fa-solid fa-truck"></i>
                            </div>
                            <div class="card-body">
                                <div class="d-flex flex-wrap">
                                    <div class="col-lg-6 col-md-4 col-sm-12 p-2">
                                        <div class="card w-100 h-100 col-lg-12">
                                            <div class="card-header rest-padding" style="background: #ddd;">
                                                <h2 class="card-title">Credit Card</h2>
                                                <i title="Delivery Info" class="fa-solid fa-truck"></i>
                                            </div>

                                            <div class="card-body">
                                                <h5 class="fw-bold  mb-3">{{ $customer->name }}</h5>
                                                <p class="mb-2">
                                                    <i class="ki-duotone ki-sms fs-5 text-muted"></i>
                                                    <a class="text-dark text-hover-primary">Card ending in 0000 (expr
                                                        08/27)</a>
                                                </p>
                                                <div class="py-5">
                                                    <button type="submit"
                                                        class="btn btn-sm btn-success  credit-card-listing"
                                                        data-uuid="{{ $customer->uuid }}"
                                                        id="openCardTypeModalButton">Update Credit Card</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-4 col-sm-12 p-2">
                                        <div class="card w-100 h-100 col-lg-12">
                                            <div class="card-header rest-padding" style="background: #ddd;">
                                                <h2 class="card-title">Gift Card</h2>
                                                <i title="Delivery Info" class="fa-solid fa-truck"></i>
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table class="table align-middle gs-0 gy-4">
                                                        <thead>
                                                            <tr class="fw-bold bg-light">
                                                                <th class="ps-4 min-w-150px">Code</th>
                                                                <th class="min-w-80px">Initial Value</th>
                                                                <th class="min-w-80px">Balance</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($customer_gifts as $gift)
                                                                <tr>
                                                                    <td>
                                                                        <a href="#"
                                                                            class="ps-4 text-dark mb-1 fs-6">{{ $gift->code }}</a>
                                                                    </td>
                                                                    <td>
                                                                        <a href="#"
                                                                            class="text-dark mb-1 fs-6">${{ $gift->purchased_amount }}</a>
                                                                    </td>
                                                                    <td>
                                                                        <a href="#"
                                                                            class="text-dark d-block mb-1 fs-6">${{ $gift->remaining_amount ?? 0 }}</a>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card w-100 h-100 col-lg-12">
                        <div class="card-header rest-padding" style="background: #ddd;">
                            <h2 class="card-title">Billing and Payment History</h2>
                            <i title="Delivery Info" class="fa-solid fa-truck"></i>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table align-middle gs-0 gy-4">
                                    <thead>
                                        <tr class="fw-bold bg-light">
                                            <th class="ps-4 min-w-150px">Date</th>
                                            <th class="min-w-80px">Order</th>
                                            <th class="min-w-80px">Amount</th>
                                            <th class="min-w-80px">Payment</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <a href="#" class="ps-4 text-dark mb-1 fs-6">10/13/2024</a>
                                            </td>
                                            <td>
                                                <a href="#" class="text-dark mb-1 fs-6">5 Meals Per
                                                    Week, Standard
                                                    10/07/2024 - 10/13/2024</a>
                                            </td>
                                            <td>
                                                <a href="#" class="text-dark d-block mb-1 fs-6">$0.00</a>
                                            </td>
                                            <td>
                                                <a href="#" class="text-dark d-block mb-1 fs-6">N/A</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <a href="#" class="ps-4 text-dark mb-1 fs-6">09/29/2024

                                                </a>
                                            </td>
                                            <td>
                                                <a href="#" class="text-dark mb-1 fs-6">5 Meals Per
                                                    Week, Standard
                                                    09/23/2024 - 09/29/2024</a>
                                            </td>
                                            <td>
                                                <a href="#" class="text-dark d-block mb-1 fs-6">$0.00</a>
                                            </td>
                                            <td>
                                                <a href="#" class="text-dark d-block mb-1 fs-6">N/A</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <a href="#" class="ps-4 text-dark mb-1 fs-6">10/13/2024</a>
                                            </td>
                                            <td>
                                                <a href="#" class="text-dark mb-1 fs-6">Weekly Meals
                                                    Plan
                                                    5 Meals Per Week, Standard</a>
                                            </td>
                                            <td>
                                                <a href="#" class="text-dark d-block mb-1 fs-6">$0.00</a>
                                            </td>
                                            <td>
                                                <a href="#" class="text-dark d-block mb-1 fs-6">N/A</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <a href="#" class="ps-4 text-dark mb-1 fs-6">10/13/2024</a>
                                            </td>
                                            <td>
                                                <a href="#" class="text-dark mb-1 fs-6">Weekly Meals
                                                    Plan
                                                    5 Meals Per Week, Standard</a>
                                            </td>
                                            <td>
                                                <a href="#" class="text-dark d-block mb-1 fs-6">$0.00</a>
                                            </td>
                                            <td>
                                                <a href="#" class="text-dark d-block mb-1 fs-6">N/A</a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Card Type Modal -->
    <div class="modal fade" id="updateCreditCardModal" tabindex="-1" style="display: none;">
        <div class="modal-dialog modal-xl">
            <div class="modal-content rounded">
                <div class="modal-header border-5 pb-0 mb-4 w-100 d-flex justify-content-between align-items-center">
                    <h5 class="modal-title text-start w-100" id="exampleModalLabel">Credit Card</h5>
                    <button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal"
                        id="closeModalButton" aria-label="Close">
                        <i class="ki-outline ki-cross fs-1"></i>
                    </button>
                </div>
                <div class="modal-body pt-0">
                    <div class="py-5 text-end">
                        <button type="submit" class="btn btn-sm btn-primary" id="openNewCreditCardTypeButton">Add Credit
                            Card</button>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-middle gs-0 gy-4 table-background-section" id="creditCardTable">
                            <thead>
                                <tr class="fw-bold bg-light">
                                    <th class="ps-4 rounded-start">User</th>
                                    <th class="">Credit Card Type</th>
                                    <th class="">Card Holdr Name</th>
                                    <th class="">Expiration Date</th>
                                    <th class="">Status</th>
                                    <th class="min-w-200px ">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Add Credit Card Type -->

    <div class="modal fade" id="addNewCreditCardModal" tabindex="-1" style="display: none; z-index:1051;">
        <div class="modal-dialog modal-md">
            <div class="modal-content rounded">
                <div class="modal-header border-5 pb-0 mb-4 w-100 d-flex justify-content-between align-items-center">
                    <h5 class="modal-title text-start w-100" id="exampleModalLabel">Credit Card</h5>
                    <button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="ki-outline ki-cross fs-1"></i>
                    </button>
                </div>
                <div class="modal-body pt-0">
                    <form id="addCreditCardFrom" enctype="multipart/form-data">
                        <input type="hidden" name="parent_id"
                            value="{{ $customer->customer_type == 1 ? $customer->uuid : $customer->parent_id }}" />
                        <input type="hidden" name="member_id" value="{{ $customer->uuid }}" />
                        @csrf
                        <div class="row">
                            <div class="col-lg-12 mb-4">
                                <label class="required form-label fw-semibold">Name on Card:</label>
                                <input type="text" class="form-control form-control-sm" name="card_holder_name"
                                    required />
                            </div>
                            <div class="col-lg-12 mb-4">
                                <label class="required form-label fw-semibold">Credit Card Number:</label>
                                <input type="number" class="form-control form-control-sm" name="last_4_digits"
                                    required />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 mb-4">
                                <label class="required form-label fw-semibold">Expiration Date:</label>
                                <input type="date" class="form-control form-control-sm" name="expiration_date"
                                    required />
                            </div>
                            <div class="col-lg-12 mb-4">
                                <label class="required form-label fw-semibold">Security Code:</label>
                                <input type="number" class="form-control form-control-sm" name="deep_stack_token"
                                    required />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 mb-4">
                                <label class="required form-label fw-semibold">Credit Card Type:</label>
                                <select name="credit_card_type_id" class="form-select form-select-sm" required>
                                    <option value="">Select a Credit Card Type...</option>
                                    @foreach ($credit_crad_types as $credit_card_type)
                                        <option value="{{ $credit_card_type->uuid }}">{{ $credit_card_type->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-12 mb-4">
                                <label class="required form-label fw-semibold">Status:</label>
                                <select name="is_active" class="form-select form-select-sm" required>
                                    <option value="">Select a Status...</option>
                                    <option value="1" selected>Active</option>
                                    <option value="0">In Active</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 mb-4">
                                <label class="mt-5 form-check form-check-custom form-check-inline  me-5">
                                    <input class="form-check-input" name="is_default" type="checkbox" value="1"
                                        data-gtm-form-interact-field-id="1">
                                    <span class="fw-semibold ps-2 fs-6">
                                        Default
                                    </span>
                                </label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Close</button>
                            <input type="submit" value="Create" class="btn btn-sm btn-primary">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Edit Credit Card -->
    <div class="modal fade" id="editCreditCardModal" tabindex="-1" style="display: none; z-index:1051;">
        <div class="modal-dialog modal-md">
            <div class="modal-content rounded">
                <div class="modal-header border-5 pb-0 mb-4 w-100 d-flex justify-content-between align-items-center">
                    <h5 class="modal-title text-start w-100" id="exampleModalLabel">Credit Card Update</h5>
                    <button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="ki-outline ki-cross fs-1"></i>
                    </button>
                </div>
                <div class="modal-body pt-0">
                    <form id="editCreditCardFrom" enctype="multipart/form-data">
                        <input type="hidden" name="parent_id"
                            value="{{ $customer->customer_type == 1 ? $customer->uuid : $customer->parent_id }}" />
                        <input type="hidden" name="member_id" value="{{ $customer->uuid }}" />
                        <input type="hidden" name="id" value="" id="cardUuid" />
                        @csrf
                        <div class="row">
                            <div class="col-lg-12 mb-4">
                                <label class="required form-label fw-semibold">Name on Card:</label>
                                <input type="text" class="form-control form-control-sm" id="cardHolderName"
                                    name="card_holder_name" required />
                            </div>
                            <div class="col-lg-12 mb-4">
                                <label class="required form-label fw-semibold">Credit Card Number:</label>
                                <input type="number" class="form-control form-control-sm" id="last4Digits"
                                    name="last_4_digits" required />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 mb-4">
                                <label class="required form-label fw-semibold">Expiration Date:</label>
                                <input type="date" class="form-control form-control-sm" id="expirationDate"
                                    name="expiration_date" required />
                            </div>
                            <div class="col-lg-12 mb-4">
                                <label class="required form-label fw-semibold">Security Code:</label>
                                <input type="number" class="form-control form-control-sm" id="cardNumber"
                                    name="deep_stack_token" required />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 mb-4">
                                <label class="required form-label fw-semibold">Credit Card Type:</label>
                                <select name="credit_card_type_id" id="creditCardType" class="form-select form-select-sm"
                                    required>
                                    <option value="">Select a Credit Card Type...</option>
                                    @foreach ($credit_crad_types as $credit_card_type)
                                        <option value="{{ $credit_card_type->uuid }}"{{ old('credit_card_type_id', @$formData['credit_card_type_id']) == $credit_card_type->uuid ? 'selected' : '' }}>{{ $credit_card_type->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-12 mb-4">
                                <label class="required form-label fw-semibold">Status:</label>
                                <select name="is_active" id="isActive" class="form-select form-select-sm" required>
                                    <option value="">Select a Status...</option>
                                    <option value="1">Active</option>
                                    <option value="0">In Active</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 mb-4">
                                <label class="mt-5 form-check form-check-custom form-check-inline  me-5">
                                    <input class="form-check-input" id="isDefault" name="is_default" type="checkbox"
                                        value="1" data-gtm-form-interact-field-id="1">
                                    <span class="fw-semibold ps-2 fs-6">
                                        Default
                                    </span>
                                </label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Close</button>
                            <input type="submit" value="Update" class="btn btn-sm btn-primary">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        $(document).ready(function() {
            $('#openCardTypeModalButton').on('click', function() {
                $('#updateCreditCardModal').modal('show');
                $('#addNewCreditCardModal').modal('hide');
            });
            // Close Modal
            $('#closeModalButton').on('click', function() {
                $('#updateCreditCardModal').modal('hide');
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#openNewCreditCardTypeButton').on('click', function() {
                $('#addNewCreditCardModal').modal('show');
                $('#updateCreditCardModal').modal('hide');
            });
            // Close Modal
            $('#closeModalButton').on('click', function() {
                $('#updateCreditCardModal').modal('hide');
            });
        });
    </script>
    <script>
        $('#addCreditCardFrom').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                url: "{{ route('admin.customers.credit.card.add') }}",
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                beforeSend: function() {
                    showOverlay();
                },
                success: function(response) {
                    hideOverlay();
                    if (response.success) {
                        swalAlert('Credit Card added successfully.', 'success', 'btn btn-success');
                        $('#addCreditCardFrom')[0].reset();
                        $('#addCreditCardFrom').find(
                                'input:not([type="button"]):not([type="submit"]), textarea, select')
                            .val('').trigger('change');
                        $('#addNewCreditCardModal').modal('hide');
                    } else {
                        swalAlert('Failed to add meal type. Please try again.', 'error',
                            'btn btn-danger');
                    }
                },
                error: function(xhr) {
                    hideOverlay();
                    var errorMessage = xhr.responseJSON?.message ||
                        'Something went wrong. Please try again later.';
                    swalAlert(errorMessage, 'error', 'btn btn-danger');
                }
            });
        });
    </script>
    <script>
        $(document).on("click", ".credit-card-listing", function(event) {
            event.preventDefault();
            var uuid = $(this).data("uuid");
            var url = "{{ route('admin.customers.get.credit.cards', ':uuid') }}".replace(':uuid', uuid);
            $.ajax({
                url: url,
                method: "GET",
                success: function(response) {
                    $('#creditCardTable tbody').empty();
                    if (response.data.length > 0) {
                        response.data.forEach(function(card) {
                            $('#creditCardTable tbody').append(`
                            <tr>
                                <td>${card.user.name}</td>
                                <td>${card.credit_card_type.title}</td>
                                <td>${card.card_holder_name}</td>
                                <td>${card.expiration_date}</td>
                                <td>${card.is_active ? 'Active' : 'Inactive'}</td>
                                <td>
                                     ${card.is_default !== 1 
                                        ? `<button class="btn main-primary-color btn-active-color-primary btn-sm px-4 me-2 make-default-btn wrap-all-style" data-uuid="${card.uuid}">Make Default</button>`: ''}
                                          <button class="btn main-primary-color btn-active-color-primary btn-sm px-4 me-2 edit-btn wrap-all-style" data-record='${JSON.stringify(card)}'>Edit</button>                                    
                                        <button class="btn  main-warning-color delete-btn btn-active-color-danger btn-sm px-4 me-2 wrap-all-style" data-uuid="${card.uuid}">Delete</button>
                                </td>
                            </tr>
                        `)
                        });
                    } else {
                        $('#creditCardTable tbody').html(
                            '<tr><td colspan="6" class="text-center">No records found</td></tr>');
                    }
                },
                error: function(xhr) {
                    console.error(xhr);
                    $('#creditCardTable tbody').html(
                        '<tr><td colspan="6" class="text-center text-danger">Failed to load data</td></tr>'
                    );
                },
            });
        });
        // Pass value into modal
        $(document).on('click', '.edit-btn', function() {
            var cardData = $(this).data("record");
            $('#updateCreditCardModal').modal('hide');
            $('#editCreditCardModal').modal('show');
            $('#cardUuid').val(cardData.uuid);
            $('#cardHolderName').val(cardData.card_holder_name);
            $('#creditCardType').val(cardData.credit_card_type_id).trigger('change');
            $('#last4Digits').val(cardData.last_4_digits);
            $('#expirationDate').val(cardData.expiration_date);
            $('#cardNumber').val(cardData.deep_stack_token);
            $('#isActive').val(cardData.is_active).trigger('change');
            $('#isDefault').prop('checked', cardData.is_default == 1);
            $('#cardUuid').val(cardData.uuid);
        });
        // Update credit card
        $('#editCreditCardFrom').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            var cardUuid = $('#cardUuid').val();
            $.ajax({
                url: "{{ route('admin.customers.credit.card.update', ':uuid') }}".replace(':uuid',
                    cardUuid),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                beforeSend: function() {
                    showOverlay();
                },
                success: function(response) {
                    hideOverlay();
                    if (response.success) {
                        swalAlert('Credit Card Update successfully.', 'success', 'btn btn-success');
                        $('#editCreditCardFrom')[0].reset();
                        $('#editCreditCardFrom').find(
                                'input:not([type="button"]):not([type="submit"]), textarea, select')
                            .val('').trigger('change');
                        $('#editCreditCardModal').modal('hide');
                    } else {
                        swalAlert('Failed to add Credit Card. Please try again.', 'error',
                            'btn btn-danger');
                    }
                },
                error: function(xhr) {
                    hideOverlay();
                    var errorMessage = xhr.responseJSON?.message ||
                        'Something went wrong. Please try again later.';
                    swalAlert(errorMessage, 'error', 'btn btn-danger');
                }
            });
        });
    </script>
    <!-- Delete Credit card -->
    <script>
        $(document).on("click", ".delete-btn", function(event) {
            event.preventDefault();
            var uuid = $(this).data('uuid');
            var url = "{{ route('admin.customers.credit.cards.delete', ':uuid') }}".replace(':uuid', uuid);
            Swal.fire({
                title: 'Are you sure?',
                text: 'This action will permanently delete the item.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Delete it!',
                cancelButtonText: 'No, Cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        beforeSend: function() {
                            showOverlay();
                        },
                        success: function(response) {
                            hideOverlay();
                            if (response.success) {
                                swalAlert(response.message || 'Item deleted successfully.',
                                    'success', 'btn btn-success');
                                $('#creditCardTable').DataTable().ajax.reload(null, false);
                            } else {
                                swalAlert(response.message || 'Failed to delete the item.',
                                    'error', 'btn btn-danger');
                            }
                        },
                        error: function(xhr) {
                            hideOverlay();
                            var errorMessage = xhr.responseJSON?.message ||
                                'Something went wrong. Please try again later.';
                            swalAlert(errorMessage, 'error', 'btn btn-danger');
                        }
                    });
                }
            });
        });

        // Make Crad Defult 
        $(document).on("click", ".make-default-btn", function(event) {
            event.preventDefault();
            var uuid = $(this).data('uuid');
            var url = "{{ route('admin.customers.credit.cards.make.default', ':uuid') }}".replace(':uuid', uuid);
            Swal.fire({
                title: 'Are you sure?',
                text: 'This action will make the selected card as default.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Make it default!',
                cancelButtonText: 'No, Cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        beforeSend: function() {
                            showOverlay();
                        },
                        success: function(response) {
                            hideOverlay();
                            if (response.success) {
                                $('#creditCardTable').DataTable().ajax.reload(null, false);
                                Swal.fire('Success!', response.message, 'success');
                            } else {
                                Swal.fire('Error!', response.message, 'error');
                            }
                        },
                        error: function(xhr) {
                            hideOverlay();
                            var errorMessage = xhr.responseJSON?.message ||
                                'Something went wrong. Please try again later.';
                            Swal.fire('Error!', errorMessage, 'error');
                        }
                    });
                }
            });
        });
    </script>
@endpush
