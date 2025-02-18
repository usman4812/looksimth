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
                    Update Category
                </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">

                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Home</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('category') }}" class="text-muted text-hover-primary">Categories</a>
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
                <form action="{{ route('category.edit',$category->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                        <div class="card-header" style="background: #ddd;">
                            <h2 class="card-title">General Info</h2>
                        </div><!--begin::Card body-->
                        <div class="card-body">
                            <!--begin::Input group-->
                            <div class="row mb-6 align-items-center">
                                <!-- First Column -->
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="name *"
                                            class="required col-form-label fw-semibold fs-6">Category Name</label>
                                        <input required type="text" name="name" value="{{ $category->name}}"
                                            class="form-control form-control-sm" placeholder="Category Name">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="image" class="col-form-label fw-semibold fs-6">Featured
                                            Image</label>
                                        <input  class="form-control form-control-sm" placeholder="" name="image" type="file">
                                    </div>
                                </div>
                                <div class="col-lg-4 mt-12">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <label class="form-check form-check-custom form-check-inline me-2 mb-0">
                                            <input class="form-check-input" name="status" type="checkbox"
                                                value="1" data-gtm-form-interact-field-id="1" {{ $category->status = 1 ? 'checked=""' : ''}} > 
                                            <span class="fw-semibold ps-2 fs-6">
                                                Published
                                            </span>
                                        </label>
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