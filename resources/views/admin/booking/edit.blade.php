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
                        Update Booking
                    </h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">

                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('booking') }}" class="text-muted text-hover-primary">Bookings</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-gray-900">Edit</li>
                    </ul>
                </div>
            </div>
        </div>
        <!--begin::Content-->
        <div id="kt_app_content" class="app-content  flex-column-fluid ">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('booking.edit', $booking->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card">
                            <div class="card-header" style="background: #ddd;">
                                <h2 class="card-title">General Info</h2>
                            </div>
                            <div class="card-body">
                                <div class="row mb-6 align-items-center">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="user_id*"
                                                class="required col-form-label fw-semibold fs-6">User</label>
                                            <select class="form-control form-control-sm" name="user_id">
                                                <option value="">Select User</option>
                                                @foreach ($users as $user)
                                                    <option value="{{ $user->id }}" {{ $user->id = $booking->user_id ? "selected" : "" }}>{{ $user->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="Phone" class="required col-form-label fw-semibold fs-6">Assigne
                                                Service</label>
                                            <select class="form-control form-control-sm" name="service_id" required>
                                                <option value="">Select Service</option>
                                                @foreach ($services as $service)
                                                    <option value="{{ $service->id }}" {{ $service->id = $booking->service_id ? "selected" : "" }}> {{ $service->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="address"
                                                class="required col-form-label fw-semibold fs-6">Address</label>
                                            <input required type="text" name="address" value="{{ $booking->address }}"
                                                class="form-control form-control-sm" placeholder="Address">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="date" class="col-form-label fw-semibold fs-6">Date</label>
                                            <input type="date" id="date-input" name="date"  value="{{ $booking->date}}" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="Phone" class="col-form-label fw-semibold fs-6">From</label>
                                            <input type="time" id="form" name="from" value="{{ $booking->from }}" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="Phone" class="col-form-label fw-semibold fs-6">To</label>
                                            <input type="time" id="to" name="to" value="{{ $booking->to }}" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="worker_id*"
                                                class="required col-form-label fw-semibold fs-6">Worker</label>
                                            <select class="form-control form-control-sm" name="worker_id">
                                                <option value="">Select Worker</option>
                                                @foreach ($workers as $worker)
                                                    <option value="{{ $worker->id }}" {{ $worker->id = $booking->worker_id ? "selected" : ""}} >{{ $worker->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 mt-10">
                                        <div class="flex flex-col items-start ">
                                            <label class="form-label flex items-center gap-2.5">
                                                <input class="checkbox" name="instance" type="checkbox" value="1"  {{ $booking-> instance == 1 ? "checked" : ""}}/>
                                                Instance
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="description"
                                                class="col-form-label fw-semibold fs-6">Description</label>
                                            <textarea class="form-control form-control-sm" placeholder="" name="description" type="text" row="4">{{ $booking->description}} </textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end py-5 px-9">
                            <button type="submit" class="btn btn-sm btn-primary me-2"><i
                                    class="fa-solid fa-plus"></i>Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $('.js-example-basic-multiple').select2();
    </script>
    <script>
        document.getElementById('date-input').addEventListener('click', function() {
            this.showPicker();
        });
        document.getElementById('form').addEventListener('click', function() {
            this.showPicker();
        });
        document.getElementById('to').addEventListener('click', function() {
            this.showPicker();
        });
    </script>
@endpush
