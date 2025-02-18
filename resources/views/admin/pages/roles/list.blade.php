@extends('admin.main')
@push('style')
    <style>
        /* .form-check-input:checked {
                            background-color: #6FD943;
                            border-color: #6FD943;
                        } */

        .form-check-input[type="checkbox"] {
            border-radius: 0.25em;
        }

        .form-check-input {
            width: 1.25em;
            height: 1.25em;
            margin-top: 0.125em;
            vertical-align: top;
            background-color: #ffffff;
            background-repeat: no-repeat;
            background-position: center;
            background-size: contain;
            border: 1px solid rgba(0, 0, 0, 0.25);
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            print-color-adjust: exact;
            transition: background-color 0.15s ease-in-out, background-position 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .badge-info {
            margin-top: 0.4rem !important;
        }
    </style>
@endpush
@section('content')
    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_toolbar" class="app-toolbar  d-flex flex-stack py-4 py-lg-8 ">
            <div class="d-flex flex-grow-1 flex-stack flex-wrap gap-2 mb-n10" id="kt_toolbar">
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3 ">

                    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                        Roles
                    </h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">

                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">Roles</li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-gray-900">All Roles</li>
                    </ul>
                </div>
                @can('create roles')
                    <a data-bs-toggle="modal" data-bs-target="#add_role" class="btn btn-sm primary-latest-container fw-bold"><i class="fa-solid fa-plus"></i>  Add Role</a>
                @endcan
            </div>
        </div>
        <!--begin::Content-->
        <div id="kt_app_content" class="app-content  flex-column-fluid ">

            <!--begin::Card-->
            <div class="card">
                <!--begin::Card body-->
                <!--begin::Body-->
                <div class="card-body py-3">
                    <!--begin::Table container-->
                    <div class="table-responsive">
                        <!--begin::Table-->
                        <table class="table align-middle gs-0 gy-4">
                            <!--begin::Table head-->
                            <thead>
                                <tr class="fw-bold bg-light">
                                    <th class="ps-4 min-w-300px rounded-start">Role</th>
                                    <th class="min-w-125px">Permissions</th>
                                    <th class="min-w-200px ">Actions</th>
                                </tr>
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody>
                                @foreach ($rolesFromDB as $role)
                                    <tr>
                                        <td>{{ $role->name }}</td>
                                        <td style="white-space: inherit">
                                            @foreach ($role->permissions as $permission)
                                                <span class="badge badge-info">{{ ucfirst($permission->name) }}</span>
                                            @endforeach

                                        </td>
                                        <td class="Action">
                                            @can('edit roles')
                                                <a data-bs-toggle="modal" data-bs-target="#edit_role_{{ $role->id }}"
                                                    class="btn btn-icon btn-sm me-1 btn-primary">
                                                    <i class="fa fa-pencil"></i>
                                                </a>
                                            @endcan
                                            @can('delete roles')
                                                <a href="javascript:void(0);"
                                                    class="btn btn-icon btn-sm me-1 btn-danger delete-btn"
                                                    data-id="{{ $role->id }}">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <!--end::Table body-->
                        </table>
                        <!--end::Table-->
                    </div>
                    <!--end::Table container-->
                </div>
                <!--begin::Body-->
                <!--end::Card body-->
            </div>
            <!--end::Card-->
        </div>
        <!--end::Content-->

    </div>
    @can('create roles')
        <div class="modal fade" id="add_role" tabindex="-1" style="display: none;" aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-lg">
                <!--begin::Modal content-->
                <div class="modal-content rounded">
                    <!--begin::Modal header-->
                    <div class="modal-header  border-0 pb-0">
                        <!--begin::Close-->
                        <h5 class="modal-title" id="exampleModalLabel">Create New Role</h5>
                        <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                            <i class="ki-outline ki-cross fs-1"></i>
                        </div>
                        <!--end::Close-->
                    </div>
                    <!--end::Modal header-->
                    <!--begin::Modal body-->
                    <div class="modal-body pt-0 pb-15 px-5 px-xl-20">

                        <form onsubmit="showoverlay()" method="POST" action="{{ route('admins.roles.add') }}"
                            accept-charset="UTF-8">
                            @csrf
                            <div class="modal-body">
                                <div class="row">
                                    <div class="form-group">
                                        <label for="name" class="required form-label">Name</label>
                                        <div class="form-icon-user">
                                            <input class="form-control" required="required" placeholder="Enter Role Name"
                                                name="name" type="text" id="name">
                                        </div>
                                        @error('name')
                                            <div class="fv-plugins-message-container invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <div class="form-group">
                                        <h6 class="my-3">Assign Permission to Roles </h6>
                                        <table class="table table-striped table-bordered table-sm mb-0" id="dataTable-1">
                                            <thead>
                                                <tr>
                                                    <th>
                                                        <input type="checkbox"
                                                            class="align-middle checkbox_middle form-check-input"
                                                            name="checkall" id="checkall">
                                                    </th>
                                                    <th>Module </th>
                                                    <th>Permissions </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($roles as $ind => $role)
                                                    @php $cntr = 0; @endphp
                                                    <tr>
                                                        <td>
                                                            <input type="checkbox" class="align-middle ischeck form-check-input"
                                                                name="checkall" data-id="{{ str_replace(' ', '_', $ind) }}">
                                                        </td>
                                                        <td>
                                                            <label class="ischeck form-label"
                                                                data-id="{{ str_replace(' ', '_', $ind) }}">{{ $ind }}</label>
                                                        </td>
                                                        <td width="60%">
                                                            <div class="row ">
                                                                @foreach ($role as $roleS)
                                                                    <div class="col-md-3 custom-control">
                                                                        <input
                                                                            class="form-check-input isscheck isscheck_{{ str_replace(' ', '_', $ind) }}"
                                                                            id="permission{{ $cntr }}"
                                                                            name="permissions[]" type="checkbox"
                                                                            value="{{ $roleS['name'] }}">
                                                                        <label for="permission{{ $cntr }}"
                                                                            class="form-label font-weight-500">{{ ucfirst(explode(' ', $roleS['name'])[0]) }}</label>
                                                                        <br>
                                                                    </div>
                                                                    @error('permissions[]')
                                                                        <div class="fv-plugins-message-container invalid-feedback">
                                                                            {{ $message }}</div>
                                                                    @enderror
                                                                    @php $cntr++ @endphp
                                                                @endforeach
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn  btn-light" data-bs-dismiss="modal">Close</button>
                                <input type="submit" value="Create" class="btn  btn-primary">
                            </div>
                        </form>
                    </div>
                    <!--end::Modal body-->
                </div>
                <!--end::Modal content-->
            </div>
            <!--end::Modal dialog-->
        </div>
    @endcan
    @can('edit roles')
        @foreach ($rolesFromDB as $roleM)
            <div class="modal fade" id="edit_role_{{ $roleM->id }}" tabindex="-1" style="display: none;"
                aria-hidden="true">
                <!--begin::Modal dialog-->
                <div class="modal-dialog modal-lg">
                    <!--begin::Modal content-->
                    <div class="modal-content rounded">
                        <!--begin::Modal header-->
                        <div class="modal-header  border-0 pb-0">
                            <!--begin::Close-->
                            <h5 class="modal-title" id="exampleModalLabel">Edit Role - {{ $roleM->name }}</h5>
                            <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                                <i class="ki-outline ki-cross fs-1"></i>
                            </div>
                            <!--end::Close-->
                        </div>
                        <!--end::Modal header-->
                        <!--begin::Modal body-->
                        <div class="modal-body pt-0 pb-15 px-5 px-xl-20">

                            <form onsubmit="showoverlay()" method="POST"
                                action="{{ route('admins.roles.edit', ['id' => $roleM->id]) }}" accept-charset="UTF-8">
                                @csrf
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="name" class="form-label">Name</label>
                                            <div class="form-icon-user">
                                                <input class="form-control" required="required" value="{{ $roleM->name }}"
                                                    placeholder="Enter Role Name" name="name" type="text"
                                                    id="name">
                                            </div>
                                            @error('name')
                                                <div class="fv-plugins-message-container invalid-feedback">{{ $message }}
                                                </div>
                                            @enderror
                                        </div>


                                        <div class="form-group">
                                            <h6 class="my-3">Assign Permission to Roles </h6>
                                            <table class="table table-striped table-bordered table-sm  mb-0" id="dataTable-1">
                                                <thead>
                                                    <tr>
                                                        <th>
                                                            <input type="checkbox"
                                                                class="align-middle checkbox_middle form-check-input checkall_edit"
                                                                name="checkall_edit" id="checkall_edit">
                                                        </th>
                                                        <th>Module </th>
                                                        <th>Permissions </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($roles as $ind => $role)
                                                        @php
                                                            $cntr = 0;
                                                            $permis = isset($roleM->permissions)
                                                                ? @$roleM->permissions->toArray()
                                                                : '';
                                                        @endphp
                                                        <tr>
                                                            <td>
                                                                <input type="checkbox"
                                                                    class="align-middle ischeck_edit form-check-input"
                                                                    name="checkall"
                                                                    data-id="{{ str_replace(' ', '_', $ind) }}">
                                                            </td>
                                                            <td>
                                                                <label class="ischeck form-label"
                                                                    data-id="{{ str_replace(' ', '_', $ind) }}">{{ $ind }}</label>
                                                            </td>
                                                            <td width="60%">
                                                                <div class="row ">
                                                                    @foreach ($role as $roleS)
                                                                        @php
                                                                            $pID = $roleS['id'];
                                                                            if (isset($roleM->permissions)) {
                                                                                $foundElement = array_filter(
                                                                                    $permis,
                                                                                    function ($element) use ($pID) {
                                                                                        return $element['id'] === $pID;
                                                                                    },
                                                                                );
                                                                            } else {
                                                                                $foundElement = '';
                                                                            }
                                                                        @endphp
                                                                        <div class="col-md-3 custom-control">
                                                                            <input
                                                                                {{ !empty($foundElement) ? 'checked=""' : '' }}
                                                                                class="form-check-input isscheck isscheck_edit_{{ str_replace(' ', '_', $ind) }}"
                                                                                id="permission{{ $cntr }}"
                                                                                name="permissions[]" type="checkbox"
                                                                                value="{{ $roleS['name'] }}">
                                                                            <label for="permission{{ $cntr }}"
                                                                                class="form-label font-weight-500">{{ ucfirst(explode(' ', $roleS['name'])[0]) }}</label>
                                                                            <br>
                                                                        </div>
                                                                        @error('permissions[]')
                                                                            <div
                                                                                class="fv-plugins-message-container invalid-feedback">
                                                                                {{ $message }}</div>
                                                                        @enderror
                                                                        @php $cntr++ @endphp
                                                                    @endforeach
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn  btn-light" data-bs-dismiss="modal">Close</button>
                                    <input type="submit" value="Update" class="btn  btn-primary">
                                </div>
                            </form>
                        </div>
                        <!--end::Modal body-->
                    </div>
                    <!--end::Modal content-->
                </div>
                <!--end::Modal dialog-->
            </div>
        @endforeach
    @endcan
@endsection
@push('script')
    <script>
        $(document).ready(function() {
            $("#checkall").click(function() {
                $('input:checkbox').not(this).prop('checked', this.checked);
            });
            $(".checkall_edit").click(function() {
                $(this).parent().parent().parent().parent().find('input:checkbox').not(this).prop('checked',
                    this.checked);
            });
            $(".ischeck").click(function() {
                var ischeck = $(this).attr('data-id');
                $('.isscheck_' + ischeck).prop('checked', this.checked);
            });
            $(".ischeck_edit").click(function() {
                var ischeck = $(this).attr('data-id');
                $('.isscheck_edit_' + ischeck).prop('checked', this.checked);
            });
        });
    </script>
    <script>
        $(document).on("click", ".delete-btn", function(event) {
            event.preventDefault();
            var id = $(this).data('id');
            if (!id) {
                console.error("ID is undefined!");
                return;
            }
            var url = "{{ route('admins.roles.delete', ':id') }}".replace(':id', id);
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
                            'X-CSRF-TOKEN': "{{ csrf_token() }}",
                            'Accept': 'application/json'
                        },
                        beforeSend: function() {
                            showOverlay();
                        },
                        success: function(response) {
                            hideOverlay();
                            if (response.success) {
                                swalAlert(response.message || 'Item deleted successfully.',
                                    'success', 'btn btn-success');
                                    loadUpdatedTableData();
                            } else {
                                swalAlert(response.message || 'Failed to delete the item.',
                                    'error', 'btn btn-danger');
                            }
                            loadUpdatedTableData();
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
        // Custom function to reload table data
        function loadUpdatedTableData() {
            $.ajax({
                url: "{{ route('admin.roles') }}", // Adjust route if necessary
                type: 'GET',
                success: function(response) {
                    if (response.success) {
                        // Assuming you have a <tbody id="table-body"> to replace
                            $('#dataTable-1').DataTable().clear().rows.add(response.data).draw(); // Clear and redraw the table with new data
                        }
                },
                error: function(xhr) {
                    console.error('Failed to load updated table data.');
                }
            });
        }
    </script>
@endpush
