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
                    Edit Banner
                </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">

                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Home</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('banner') }}" class="text-muted text-hover-primary">Banners</a>
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
                <form action="{{ route('banner.edit', ['id' => $data['banner']->id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                        <div class="card-header" style="background: #ddd;">
                            <h2 class="card-title">General Info</h2>
                        </div>
                        <div class="card-body">
                            <div class="row mb-6 align-items-center">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="image *"
                                            class="required col-form-label fw-semibold fs-6">Image</label>
                                        <input required type="file" name="image"
                                            class="form-control form-control-sm" placeholder="" accept="jpeg,jpg,png,webp">
                                            <div class="symbol symbol-50px me-5 ms-5">
                                                <span class="symbol-label bg-light" style="display: flex; justify-content: center; align-items: center; height: 70px; width: 70px;">
                                                    <img src="{{ asset('storage/public/web_assets/media/banner/' . $data['banner']->image) }}"
                                                    style="height: 100%; width: auto; object-fit: cover;" alt=""/>
                                                </span>
                                            </div>                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="image" class="required col-form-label fw-semibold fs-6">Url</label>
                                        <input  class="form-control form-control-sm" placeholder="" name="url" type="url" value="{{ $data['banner']->url }}" required>
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
