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
                    Update Service
                </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">

                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Home</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('service') }}" class="text-muted text-hover-primary">Services</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-gray-900">Update</li>
                </ul>
            </div>
        </div>
    </div>
    <!--begin::Content-->
    <div id="kt_app_content" class="app-content  flex-column-fluid ">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('service.edit', $service->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                        <div class="card-header" style="background: #ddd;">
                            <h2 class="card-title">General Info</h2>
                        </div>
                        <div class="card-body">
                            <div class="row mb-6 align-items-center">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="name *"
                                            class="required col-form-label fw-semibold fs-6"> Select Category</label>
                                        <select class="form-control" name="category_id">
                                            <option value="">Select Category</option>
                                            @foreach($categories as $category)
                                            <option value="{{$category->id}}" {{ $category->id == $service->category_id ? 'selected' : ''}}>{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="title"
                                            class="required col-form-label fw-semibold fs-6">Service Title</label>
                                        <input required type="text" name="title" value="{{ $service->title }}"
                                            class="form-control form-control-sm" placeholder="Service Title">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="price"
                                            class="col-form-label fw-semibold fs-6">Price</label>
                                        <input type="number" name="price" step="0.001" min="0" value="{{ $service->price }}"
                                            class="form-control form-control-sm" placeholder="">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="percent"
                                            class="col-form-label fw-semibold fs-6">Discount Percent</label>
                                        <input type="number" name="percent" step="0.001" min="0"
                                            class="form-control form-control-sm" placeholder="Discount Percent" value="{{ $service->percent }}" maxlength="3">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="image" class="col-form-label fw-semibold fs-6">Featured
                                            Image</label>
                                        <input class="form-control form-control-sm" placeholder="" name="image" type="file">
                                    </div>
                                </div>
                                <div class="col-lg-12 mb-6">
                                    <div class="form-group">
                                        <label for="description" class="col-form-label fw-semibold fs-6">Description</label>
                                        <textarea name="description" class="form-control form-control-sm" placeholder="Description" rows="3">{{ $service->description }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end py-5 px-9">
                        <button type="submit" class="btn btn-sm btn-primary me-2"><i class="fa-solid fa-plus"></i>Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
