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
                    Add Worker
                </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">

                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Home</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('worker') }}" class="text-muted text-hover-primary">Workers</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-gray-900">Add</li>
                </ul>
            </div>
        </div>
    </div>
    <!--begin::Content-->
    <div id="kt_app_content" class="app-content  flex-column-fluid ">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('worker.add') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                        <div class="card-header" style="background: #ddd;">
                            <h2 class="card-title">General Info</h2>
                        </div>
                        <div class="card-body">
                            <div class="row mb-6 align-items-center">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="name*"
                                            class="required col-form-label fw-semibold fs-6">Worker Name</label>
                                        <input required type="text" name="name"
                                            class="form-control form-control-sm" placeholder="Worker Name">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="title"
                                            class="required col-form-label fw-semibold fs-6">Email</label>
                                        <input required type="email" name="email"
                                            class="form-control form-control-sm" placeholder="Email">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="Phone"
                                            class="col-form-label fw-semibold fs-6">Phone</label>
                                        <input type="number" name="phone"
                                            class="form-control form-control-sm" placeholder="Phone">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="Phone"
                                            class="col-form-label fw-semibold fs-6">Address</label>
                                        <input type="text" name="address"
                                            class="form-control form-control-sm" placeholder="Address">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="Phone"
                                            class="col-form-label fw-semibold fs-6">Assigne Service</label>
                                        <select class="form-control form-control-sm" name="service_id">
                                            <option value="">Select Service</option>
                                            @foreach($services as $service)
                                            <option value="{{$service->id}}"> {{$service->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="image" class="col-form-label fw-semibold fs-6">Image</label>
                                        <input class="form-control form-control-sm" placeholder="" name="image" type="file">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="password" class="col-form-label fw-semibold fs-6">password</label>
                                        <input class="form-control form-control-sm" placeholder="" name="password" type="password">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="password_confirmation" class="col-form-label fw-semibold fs-6">Confirm Password</label>
                                        <input class="form-control form-control-sm" placeholder="" name="password_confirmation" type="password">
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-6">
                                <label for="image" class="col-form-label fw-semibold fs-6">Gender</label>
                                    <div class="flex flex-col items-start gap-10">
                                        <label class="form-label flex items-center gap-2.5">
                                            <input class="radio" name="gender" type="radio" value="male" />
                                            Male
                                        </label>
                                        <label class="form-label flex items-center gap-2.5">
                                            <input  class="radio" name="gender" type="radio" value="female" />
                                            Female
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-6 mt-5">
                                    <div class="flex flex-col items-start ">
                                        <label class="form-label flex items-center gap-2.5">
                                        <input class="checkbox" name="status" type="checkbox" value="1"/>
                                            Active Status
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end py-5 px-9">
                        <button type="submit" class="btn btn-sm btn-primary me-2"><i class="fa-solid fa-plus"></i>Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection