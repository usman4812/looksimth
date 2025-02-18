@extends('admin.main')
@section('content')
    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_toolbar" class="app-toolbar  d-flex flex-stack py-4 py-lg-8 ">
            <div class="d-flex flex-grow-1 flex-stack flex-wrap gap-2 mb-n10" id="kt_toolbar">
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3 ">

                    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                        Add Gift Cards
                    </h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">

                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.gift.cards') }}" class="text-muted text-hover-primary">Gift Cards</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-gray-900">Add</li>
                    </ul>
                </div>
            </div>
        </div>
        <div id="kt_app_content" class="app-content  flex-column-fluid">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.gift.cards.add') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="col-lg-12 w-100 d-flex justify-content-between align-items-start gap-5 flex-column">
                            <div class="card w-100 h-100 col-lg-12">
                                <div class="card-header rest-padding-twenty" style="background: #ddd;">
                                    <h2 class="card-title m-0">Gift Card</h2>
                                    <i title="Meal Days & Order Deadline" class="fa-solid fa-circle-info"></i>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-3 align-items-start justify-content-start">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="purchaser_first_name*"
                                                    class="required col-form-label fw-semibold fs-6">Purchaser First
                                                    Name</label>
                                                <input required type="text" name="purchaser_first_name"
                                                    value="{{ @$formData['purchaser_first_name'] }}"
                                                    class="form-control form-control-sm" placeholder="First Name">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="purchaser_last_name*"
                                                    class="required col-form-label fw-semibold fs-6">Purchaser Last
                                                    Name</label>
                                                <input required type="text" name="purchaser_last_name"
                                                    value="{{ @$formData['purchaser_last_name'] }}"
                                                    class="form-control form-control-sm" placeholder="Last Name">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="password*"
                                                    class="required col-form-label fw-semibold fs-6">Purchaser Email</label>
                                                <div class="position-relative">
                                                    <input type="email" name="purchaser_email" required
                                                        value="{{ @$formData['purchaser_email'] }}"
                                                        class="form-control form-control-sm" placeholder="Purchaser Email">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="purchaser_phone*" class="required col-form-label fw-semibold fs-6">Purchaser Phone</label>
                                                <input required type="integer" name="purchaser_phone"
                                                    value="{{ @$formData['purchaser_phone'] }}" class="form-control form-control-sm"
                                                    placeholder="Purchaser Phone">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="company_name *"
                                                    class="required col-form-label fw-semibold fs-6">Purchased Amount</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">$</span>
                                                    <input required type="number" class="form-control form-control-sm" name="purchased_amount" value="{{ @$formData['purchased_amount']  }}"
                                                        aria-label="Amount (to the nearest dollar)">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="gift_type*" class="required col-form-label fw-semibold fs-6">Gift Type</label>
                                                <select required id="gift_type" name="gift_type"
                                                    data-placeholder="Select a Gift Type..."
                                                    class="form-control form-control-sm">
                                                    <option value="">Select a Gift Type</option>
                                                   <option value="Donation">Donation</option>
                                                   <option value="Regular">Regular</option>
                                                </select>
                                            </div>
                                        </div>
                                        <h3 class="mt-4">Printable Gift Card</h3>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="to*" class="required col-form-label fw-semibold fs-6">To</label>
                                                <input required type="text" name="recipient_name"
                                                    value="{{ @$formData['recipient_name'] }}" class="form-control form-control-sm"
                                                    placeholder="Recipient Name">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="sender_name*" class="required col-form-label fw-semibold fs-6">From</label>
                                                <input required type="text" name="sender_name"
                                                    value="{{ @$formData['sender_name'] }}" class="form-control form-control-sm"
                                                    placeholder="Sender Name">
                                            </div>
                                        </div>
                                        <div class="row mb-6">
                                            <div class="form-group">
                                                <label for="message*" class="col-form-label fw-semibold fs-6">Message</label>
                                                <textarea name="message" class="form-control form-control-lg" placeholder="Add a message (Optional)" rows="3"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 mb-9">
                                            <div class="form-group">
                                                <label for="customer_user_id*" class="required col-form-label fw-semibold fs-6">Assign to customer</label>
                                                <select id="customer_user_id" name="customer_user_id"
                                                    data-placeholder="Select a Customer..."
                                                    class="form-control form-control-sm">
                                                    <option value="">Select a Customer</option>
                                                    @foreach ($customers as $customer)
                                                        <option value="{{ $customer->uuid }}">{{ $customer->name }} - {{ $customer->email }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 mt-10">
                                            <label class="mt-5 form-check form-check-custom form-check-inline  me-5">
                                                <input class="form-check-input" name="is_active" type="checkbox"
                                                    value="1" data-gtm-form-interact-field-id="1">
                                                <span class="fw-semibold ps-2 fs-6">
                                                    Active
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="w-100 d-flex justify-content-end py-0 px-0">
                                <button type="submit"
                                    class="btn btn-sm btn-primary d-flex justify-content-center align-items-center">
                                    <i class="fa-solid fa-plus"></i>Create</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
