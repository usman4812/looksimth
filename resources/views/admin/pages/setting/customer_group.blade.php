@php
    $formData = old();
@endphp
@extends('admin.main')
@push('style')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    </style>
@endpush
@section('content')
    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_toolbar" class="app-toolbar  d-flex flex-stack py-4 py-lg-8 ">
            <div class="d-flex flex-grow-1 flex-stack flex-wrap gap-2 mb-n10" id="kt_toolbar">
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3 ">

                    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-3">
                        Customer Group
                    </h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">

                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.settings') }}" class="text-muted text-hover-primary">Settings</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-gray-900">Customer Group</li>
                    </ul>
                </div>
            </div>
        </div>
        <!--begin::Content-->
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div class="container-fluid">
                <div class="row g-7">
                    @include('admin.pages.setting.sidebar')
                    <div class="col-lg-9 p-2">
                        <div class="card">
                            <div class="card-header border-0 rest-padding">
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label fw-bold fs-3 mb-1">Customer Group</span>
                                </h3>
                                <div class="card-toolbar primary-latest-button">
                                    <a title="Add Customer Group" data-bs-toggle="modal" data-bs-target="#add_customer_group"
                                        class="btn btn-sm">
                                        <i class="ki-outline ki-plus fs-2"></i>Add Customer Group</a>&nbsp;
                                </div>
                            </div>
                            <div class="card-body py-3">
                                <div class="table-responsive">
                                    <table class="table align-middle gs-0 gy-4" id="customerGroup">
                                        <thead>
                                            <tr class="fw-bold text-muted bg-light">
                                                <th class="ps-4  rounded-start">Name</th>
                                                <th class="min-w-150px">Status</th>
                                                <th class="min-w-200px text-end rounded-end">Action</th>
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
            </div>
        </div>
        <!-- Add Customer Group Model-->
        <div class="modal fade" id="add_customer_group" tabindex="-1" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content rounded">
                    <div class="modal-header border-5 pb-0 mb-4">
                        <h5 class="modal-title" id="exampleModalLabel">Customer Group</h5>
                        <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                            <i class="ki-outline ki-cross fs-1"></i>
                        </div>
                    </div>
                    <div class="modal-body pt-0">
                        <form id="addCustomerGroup">
                            <div class="row">
                                <div class="col-lg-12 mb-4">
                                    <label class="required form-label fw-semibold">Name:</label>
                                    <input type="text" class="form-control form-control-sm" name="name" required/>
                                </div>
                                <div class="col-lg-12 mb-4">
                                    <label class="required form-label fw-semibold">Status:</label>
                                    <select name="status" class="form-select form-select-sm" required>
                                        <option value="">Select a Status...</option>
                                        <option value="1" selected>Active</option>
                                        <option value="0">In Active</option>
                                    </select>
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
        <!--Eidt Customer Group Model  -->
        <div class="modal fade" id="edit_customer_group" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content rounded">
                    <div class="modal-header border-5 pb-4 mb-5">
                        <h5 class="modal-title">Update Meal Type</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pt-0">
                        <form id="editCustomerGroup">
                            <input type="hidden" name="uuid" id="edit_customer_group_id">
                            <div class="row">
                                <div class="col-lg-12 mb-4">
                                    <label class="required form-label fw-semibold">Name:</label>
                                    <input type="text" class="form-control form-control-sm" id="edit_customer_group_name"
                                        name="name" required/>
                                </div>
                                <div class="col-lg-12 mb-4">
                                    <label class="required form-label fw-semibold">Status:</label>
                                    <select id="edit_customer_group_status" name="status" class="form-select form-select-sm" required>
                                        <option value="">Select a Status...</option>
                                        <option value="1" selected>Active</option>
                                        <option value="0">In Active</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-sm btn-light"
                                    data-bs-dismiss="modal">Close</button>
                                <input type="submit" value="Update" class="btn btn-sm btn-primary">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
@push('script')
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js">
    </script>
    <script>
        // Initialize DataTable
        var customerGroupTable = $('#customerGroup').DataTable({
            "pageLength": 25,
            "filter": true,
            "searching": true,
            "responsive": true,
            "autoWidth": false,
            "pagingType": "full_numbers",
            "dom": '<"top"f>rt<"bottom"ip><"clear">',
            "language": {
                "search": "_INPUT_",
                "searchPlaceholder": "Search records"
            },
            "initComplete": function() {
                $('.dataTables_filter input[type="search"]').removeClass('form-control-sm');
            },
            "columnDefs": [{
                "targets": "_all",
                "className": "text-center"
            }],
            "ajax": {
                "url": "{{ route('admin.settings.customer.group') }}",
                "type": "POST",
                "data": function(data) {
                    data._token = "{{ csrf_token() }}";
                },
                "beforeSend": function() {
                    showOverlay();
                },
                "complete": function() {
                    hideOverlay();
                    $('[data-toggle="tooltip"]').tooltip();
                }
            },
            order: [
                [0, 'desc']
            ]
        });

        $('#search').keyup(function() {
            customerGroupTable.search($(this).val()).draw();
        });
        $(document).on("click", ".delete-btn", function(event) {
            event.preventDefault();
            var url = $(this).attr("href");
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
                                $('#customerGroup').DataTable().ajax.reload();
                            } else {
                                r
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
    </script>

    <script>
        // Pass value into modal
        $(document).on('click', '.edit-btn', function() {
            var record = $.parseJSON($(this).attr('data-record'));
            var customerGroupUuid = record.uuid; // Get UUID
            var customerGroupName = record.name;
            var customerGroupStatus = record.status;
            // Set the values in the modal form
            $('#edit_customer_group_id').val(customerGroupUuid);
            $('#edit_customer_group_name').val(customerGroupName);
            $('#edit_customer_group_status').val(customerGroupStatus).trigger('change');
            $('#edit_customer_group').modal('show');
        });
        // Add Customer Group ajax
        $('#addCustomerGroup').submit(function(e) {
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                url: "{{ route('admin.settings.customer.group.add') }}",
                type: 'POST',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                beforeSend: function() {
                    showOverlay();
                },
                success: function(response) {
                    hideOverlay();
                    if (response.success) {
                        swalAlert('Customer Group added successfully.', 'success', 'btn btn-success');
                        $('#addCustomerGroup')[0].reset();
                        $('#addCustomerGroup').find(
                                'input:not([type="button"]):not([type="submit"]), textarea, select')
                            .val('').trigger('change');
                        $('#add_customer_group').modal('hide');
                        customerGroupTable.ajax.reload(null, false);
                    } else {
                        swalAlert('Failed to add Customer Group. Please try again.', 'error',
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
        // Edit Customer Group Ajax Request
        $('#editCustomerGroup').submit(function(e) {
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                url: "{{ route('admin.settings.customer.group.update') }}",
                type: 'POST',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                beforeSend: function() {
                    showOverlay();
                },
                success: function(response) {
                    hideOverlay();
                    if (response.success) {
                        swalAlert('Customer Group updated successfully.', 'success', 'btn btn-success');
                        $('#edit_customer_group').modal('hide');
                        $('#customerGroup').DataTable().ajax.reload();
                    } else {
                        swalAlert('Failed to update Customer Group. Please try again.', 'error',
                            'btn btn-danger');
                    }
                },
                error: function(xhr, status, error) {
                    hideOverlay();
                    swalAlert('An error occurred. Please try again later.', 'error', 'btn btn-danger');
                }
            });
        });
    </script>
@endpush
