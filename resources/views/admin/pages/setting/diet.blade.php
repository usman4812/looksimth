@php
    $formData = old();
@endphp
@extends('admin.main')
@push('style')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <style>
        tbody td:last-child {
            /* Add your styles here */
            text-align: center !important;
            white-space: nowrap;
        }
        tbody td:first-child {
            display: flex;
            /* Add your styles here */
            text-align: center !important;
            justify-content: start !important;
            /* padding: 0% !important; */
            white-space: nowrap;
        }
        tbody td:nth-child(4) {
            width: 200px !important;
   text-align: start !important;
}

thead th {
        white-space: nowrap;
    }

    </style>
@endpush
@section('content')
    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_toolbar" class="app-toolbar  d-flex flex-stack py-4 py-lg-8 ">
            <div class="d-flex flex-grow-1 flex-stack flex-wrap gap-2 mb-n10" id="kt_toolbar">
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3 ">

                    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-3">
                        Diets
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
                        <li class="breadcrumb-item text-gray-900">Diets</li>
                    </ul>
                </div>
            </div>
        </div>
        <!--begin::Content-->
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div class="container-fluid">
                <div class="row g-7">
                    <!-- Card 1 (3 columns) -->
                    @include('admin.pages.setting.sidebar')
                    <!-- Card 2 (9 columns) -->
                    <div class="col-lg-9 p-2">
                        <div class="card">
                            <!--begin::Header-->
                            <div class="card-header border-0 rest-padding">
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label fw-bold fs-3 mb-1">Diets</span>
                                </h3>
                                <div class="card-toolbar primary-latest-button">
                                    <a title="Add Diet" data-bs-toggle="modal" data-bs-target="#add_diet"
                                        class="btn btn-sm">
                                        <i class="ki-outline ki-plus fs-2"></i>Add Diet</a>&nbsp;
                                </div>
                            </div>
                            <div class="card-body py-3">
                                <div class="table-responsive">
                                    <table class="table align-middle gs-0 gy-4" id="diets">
                                        <thead>
                                            <tr class="fw-bold text-muted bg-light">
                                                <th class="ps-4  rounded-start">Name</th>
                                                <th class="">Abbr</th>
                                                <th class="">Sort Order</th>
                                                <th class="">Description</th>
                                                <th class="">Status</th>
                                                <th class="min-w-200px text-end rounded-end">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!--end::Body-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Add diets Model-->
        <div class="modal fade" id="add_diet" tabindex="-1" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content rounded">
                    <div class="modal-header  border-5 pb-0 mb-4">
                        <h5 class="modal-title" id="exampleModalLabel">Diet</h5>
                        <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                            <i class="ki-outline ki-cross fs-1"></i>
                        </div>
                    </div>
                    <div class="modal-body pt-0">
                        <form id="addDietForm">
                            <div class="row">
                                <div class="col-lg-12 mb-4">
                                    <label class="required form-label fw-semibold">Name:</label>
                                    <input type="text" class="form-control form-control-sm" name="name" required/>
                                </div>

                                <div class="col-lg-12 mb-4">
                                    <label class="required form-label fw-semibold">Abbr:</label>
                                    <input type="text" class="form-control form-control-sm" name="abbr" required/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 mb-4">
                                    <label class="required form-label fw-semibold">Sort Order:</label>
                                    <input type="number" class="form-control form-control-sm" name="sort_order" required/>
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
                            <div class="row">
                                <div class="col-lg-12 mb-4">
                                    <label class="form-label fw-semibold">Description:</label>
                                    <textarea type="text" class="form-control form-control-sm" name="description"></textarea>
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
        <!--Eidt Meal Model  -->
        <div class="modal fade" id="edit_diet" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content rounded">
                    <div class="modal-header border-5 pb-4 mb-5">
                        <h5 class="modal-title">Update Diet</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pt-0">
                        <form id="editDietForm">

                            <input type="hidden" name="uuid" id="edit_diet_id">
                            <div class="row">
                                <div class="col-lg-12 mb-4">
                                    <label class="required form-label fw-semibold">Name:</label>
                                    <input type="text" class="form-control form-control-sm" id="edit_diet_name" name="name" required/>
                                </div>
                                <div class="col-lg-12 mb-4">
                                    <label class="required form-label fw-semibold">Abbr:</label>
                                    <input type="text" class="form-control form-control-sm" id="edit_diet_abbr" name="abbr" required/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 mb-4">
                                    <label class="required form-label fw-semibold">Sort Order:</label>
                                    <input type="number" class="form-control form-control-sm" id="edit_diet_sort_order" name="sort_order" required/>
                                </div>
                                <div class="col-lg-12 mb-4">
                                    <label class="required form-label fw-semibold">Status:</label>
                                    <select name="status" id="edit_diet_status" class="form-select form-select-sm" required>
                                        <option value="">Select a Status...</option>
                                        <option value="1">Active</option>
                                        <option value="0">In Active</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 mb-4">
                                    <label class="form-label fw-semibold">Description:</label>
                                    <textarea type="text" class="form-control form-control-sm" id="edit_diet_description" name="description"></textarea>
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
        $('#diets').DataTable().destroy();
        var dietTable = $('#diets').DataTable({
            "pageLength": 25, // Show 25 records by default
            "filter": true,
            "searching": true,
            "responsive": true, // Enable responsive
            "autoWidth": false, // Disable auto width calculation
            "pagingType": "full_numbers",
            "dom": '<"top"f>rt<"bottom"ip><"clear">',
            "language": {
                "search": "_INPUT_",
                "searchPlaceholder": "Search records"
            },
            "initComplete": function() {
                // Remove form-control-sm class from the search input
                $('.dataTables_filter input[type="search"]').removeClass('form-control-sm');
            },
            "columnDefs": [{
                "targets": "_all",
                "className": "text-center"
            }],
            "ajax": {
                "url": "{{ route('admin.settings.diets') }}",
                "type": "POST",
                "data": function(data) {
                    data._token = "{{ csrf_token() }}";
                },
                "beforeSend": function() {
                    showOverlay(); // Show overlay before data fetch
                },
                "complete": function() {
                    hideOverlay(); // Hide overlay after data fetch
                    $('[data-toggle="tooltip"]').tooltip()
                }
            },
            order: [
                [0, 'desc']
            ]
        });
        $('#search').keyup(function() {
            dietTable.search($(this).val()).draw();
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
                    // AJAX request to delete the item
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        beforeSend: function() {
                            showOverlay(); // Show overlay before data fetch
                        },
                        success: function(response) {
                            hideOverlay();
                            if (response.success) {
                                swalAlert(response.message || 'Item deleted successfully.',
                                    'success', 'btn btn-success');
                                $('#diets').DataTable().ajax.reload();
                            } else {
                                r
                                swalAlert(response.message || 'Failed to delete the item.',
                                    'error', 'btn btn-danger');
                            }

                        },
                        error: function(xhr) {
                            // Handle error response
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
            var dietUuid = record.uuid;
            var dietName = record.name;
            var dietAbbr = record.abbr;
            var dietSortOrder = record.sort_order;
            var dietDescription = record.description;
            var dietStatus = record.status;
            // Populate the modal with the meal type data
            $('#edit_diet_id').val(dietUuid);
            $('#edit_diet_name').val(dietName);
            $('#edit_diet_abbr').val(dietAbbr);
            $('#edit_diet_sort_order').val(dietSortOrder);
            $('#edit_diet_description').val(dietDescription);
            $('#edit_diet_status').val(dietStatus).trigger('change');

            $('#edit_diet').modal('show');
        });
        // Add Diet ajax
        $('#addDietForm').submit(function(e) {
            e.preventDefault(); // Prevent default form submission
            var formData = $(this).serialize();
            $.ajax({
                url: "{{ route('admin.settings.diets.add') }}",
                type: 'POST',
                data: formData, // Form data to send
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                beforeSend: function() {
                    showOverlay(); // Show overlay before data fetch
                },
                success: function(response) {
                    hideOverlay();
                    if (response.success) {
                        swalAlert(response.message, 'success', 'btn btn-success');
                        $('#addDietForm')[0].reset();
                        $('#addDietForm').find(
                                'input:not([type="button"]):not([type="submit"]), textarea, select')
                            .val('').trigger('change');
                        $('#add_diet').modal('hide');
                        dietTable.ajax.reload(null, false);
                    } else {
                        swalAlert('Failed to add diet. Please try again.', 'error',
                            'btn btn-danger');
                    }
                },
                error: function(xhr) {
                    // Handle error response
                    hideOverlay();
                    var errorMessage = xhr.responseJSON?.message ||
                        'Something went wrong. Please try again later.';
                    swalAlert(errorMessage, 'error', 'btn btn-danger');
                }
            });
        });

        // Edit Diet Ajax Request
        $('#editDietForm').submit(function(e) {
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                url: "{{ route('admin.settings.diets.update') }}",
                type: 'POST',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                beforeSend: function() {
                    showOverlay(); // Show overlay before data fetch
                },
                success: function(response) {
                    hideOverlay();
                    if (response.success) {
                        swalAlert('Diet updated successfully.', 'success', 'btn btn-success');
                        $('#edit_diet').modal('hide');
                        $('#diets').DataTable().ajax.reload();
                    } else {
                        swalAlert('Failed to update Diet. Please try again.', 'error',
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
