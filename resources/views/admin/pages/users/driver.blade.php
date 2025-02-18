@extends('admin.main')
@section('content')
    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_toolbar" class="app-toolbar  d-flex flex-stack py-4 py-lg-8 ">
            <div class="d-flex flex-grow-1 flex-stack flex-wrap gap-2 mb-n10" id="kt_toolbar">
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3 ">

                    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                        Users
                    </h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">

                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.users') }}" class="text-muted text-hover-primary">Users</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-gray-900">Drivers</li>
                    </ul>
                </div>
                <div>
                    @can('manage drivers')
                        <a title="Add Drivers" data-bs-toggle="modal" data-bs-target="#add_driver" class="btn btn-sm success-latest-container fw-bold"><i class="fa-solid fa-truck"></i>Add
                            Drivers</a>&nbsp;
                    @endcan
                </div>
            </div>
        </div>
        <!--begin::Content-->
        <div id="kt_app_content" class="app-content  flex-column-fluid ">
            <div class="card">
                <div class="card-body py-3">
                    <div class="table-responsive">
                        <table class="table align-middle gs-0 gy-4">
                            <thead>
                                <tr class="fw-bold bg-light">
                                    <th class="ps-4 min-w-125px rounded-start">Number</th>
                                    <th class="min-w-125px">Driver</th>
                                    <th class="min-w-200px ">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <a href="#" class="ps-4 text-dark mb-1 fs-6">B0001</a>
                                    </td>
                                    <td>
                                        <a href="#" class="text-dark d-block mb-1 fs-6">Doee234</a>
                                    </td>
                                    <td class="">
                                        @can('edit users')
                                            <a data-bs-toggle="modal" title="Edit Drivers" data-bs-target="#add_driver"
                                                class="btn main-primary-color btn-active-color-primary btn-sm px-4 me-2 edit-btn wrap-all-style"><i class="fa-solid fa-pen"></i>Edit</a>
                                        @endcan
                                        @can('delete users')
                                            <a href="#" title="Delete Drivers"
                                                class="btn  main-warning-color delete-btn btn-active-color-danger btn-sm px-4 me-2 wrap-all-style"><i class="fa-solid fa-trash"></i>Delete</a>
                                        @endcan
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @can('create roles')
            <div class="modal fade" id="add_driver" tabindex="-1" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-md">
                    <div class="modal-content rounded">
                        <div class="modal-header px-5 border-0 pb-0">
                            <h5 class="modal-title" id="exampleModalLabel">Driver Number</h5>
                            <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                                <i class="ki-outline ki-cross fs-1"></i>
                            </div>
                        </div>
                        <div class="modal-body pt-0 px-5">
                            <form onsubmit="showoverlay()" method="POST" action="{{ route('admins.roles.add') }}"
                                accept-charset="UTF-8">
                                @csrf
                                <div class="row mb-6">
                                    <label class="col-lg-4 col-form-label  fw-semibold fs-6">Number</label>
                                    <div class="col-lg-8 fv-row">
                                        <input type="text" name=""
                                            class="form-control form-control-lg form-control-solid" placeholder="Number">
                                    </div>
                                </div>
                                <div class="row mb-6">
                                    <label class="col-lg-4 col-form-label  fw-semibold fs-6">Driver</label>
                                    <div class="col-lg-8 fv-row">
                                        <select name="role_id" aria-label="Select a Role" data-placeholder="Select a role..."
                                            class="form-select form-select-solid form-select-lg form-control">
                                            <option value="">Select a Role...</option>
                                            <option data-kt-flag="flags/indonesia.svg" value="A">Driver A</option>
                                            <option data-kt-flag="flags/malaysia.svg" value="B">Driver B</option>
                                            <option data-kt-flag="flags/canada.svg" value="C">Driver C</option>
                                            <option data-kt-flag="flags/czech-republic.svg" value="D">Driver D</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="modal-footer d-flex gap-3 pe-0 ps-0 pb-0">
                                    <button type="button" class="btn light-latest-container" data-bs-dismiss="modal"><i class="fa-solid fa-xmark"></i>Close</button>
                                    <button type="button" class="btn primary-latest-container" data-bs-dismiss="modal"><i class="fa-solid fa-plus"></i>Create</button>
                                    {{-- <input type="submit" value="Create" class="btn primary-latest-container"> --}}
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endcan
    </div>
@endsection
