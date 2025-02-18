@php
    $formData = old();
@endphp
@extends('admin.main')
@push('style')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <style>

    </style>
@endpush
@section('content')
    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_toolbar" class="app-toolbar  d-flex flex-stack py-4 py-lg-8 ">
            <div class="d-flex flex-grow-1 flex-stack flex-wrap gap-2 mb-n10" id="kt_toolbar">
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3 ">

                    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-3">
                        Meal Sizes
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
                        <li class="breadcrumb-item text-gray-900">Meal Sizes</li>
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
                                    <span class="card-label fw-bold fs-3 mb-1">Meal Sizes</span>
                                </h3>
                                <div class="card-toolbar primary-latest-button">
                                    <a title="Add Meal Size" data-bs-toggle="modal" data-bs-target="#add_meal_size"
                                        class="btn btn-sm">
                                        <i class="ki-outline ki-plus fs-2"></i>Add Meal Size</a>&nbsp;
                                </div>
                            </div>
                            <div class="card-body py-3">
                                <div class="table-responsive">
                                    <table class="table align-middle gs-0 gy-4" id="mealSize">
                                        <thead>
                                            <tr class="fw-bold text-muted bg-light">
                                                <th class="ps-4 min-w-100px rounded-start">Title</th>
                                                <th class="">Order</th>
                                                <th class="">Description</th>
                                                <th class="min-w-100px">Short Des</th>
                                                <th class="">Calories</th>
                                                <th class="">Servings</th>
                                                <th class="">Protein</th>
                                                <th class="">Sides</th>
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
        <div class="modal fade" id="add_meal_size" tabindex="-1" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content rounded">
                    <div class="modal-header  border-5 pb-0 mb-4">
                        <h5 class="modal-title" id="exampleModalLabel">Meal Size</h5>
                        <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                            <i class="ki-outline ki-cross fs-1"></i>
                        </div>
                    </div>
                    <div class="modal-body pt-0">
                        <form id="addMealSizeForm">
                            <div class="row mb-4">
                                <div class="col-lg-6">
                                    <label class="required form-label fw-semibold">Title:</label>
                                    <input type="text" class="form-control form-control-sm" name="title" required/>
                                </div>
                                <div class="col-lg-6">
                                    <label class="required form-label fw-semibold">Sort Order:</label>
                                    <input type="number" class="form-control form-control-sm" name="sort_order" required/>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-lg-6">
                                    <label class="form-label fw-semibold">Description:</label>
                                    <textarea type="text" class="form-control form-control-sm" name="description"></textarea>
                                </div>
                                <div class="col-lg-6">
                                    <label class="form-label fw-semibold">Sort Description:</label>
                                    <textarea type="text" class="form-control form-control-sm" name="short_description"></textarea>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-lg-6">
                                    <label class="form-label fw-semibold">Calories Per Day:</label>
                                    <input type="text" class="form-control form-control-sm" name="calories_per_day"
                                        placeholder="" value="" />
                                </div>
                                <div class="col-lg-6">
                                    <label class="required form-label fw-semibold">Servings:</label>
                                    <input type="number" class="form-control form-control-sm" name="servings"
                                        placeholder="" value="" />
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-lg-6">
                                    <label class="form-label fw-semibold">Protein:</label>
                                    <input type="number" class="form-control form-control-sm" name="protein"
                                        placeholder="" value="" />
                                </div>
                                <div class="col-lg-6">
                                    <label class="form-label fw-semibold">Sides:</label>
                                    <input type="number" class="form-control form-control-sm" name="sides"
                                        placeholder="" value="" />
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-lg-6">
                                    <label class="required form-label fw-semibold">Status:</label>
                                    <select name="status" class="form-select form-select-sm" required>
                                        <option value="">Select a Status...</option>
                                        <option value="1" selected>Active</option>
                                        <option value="0">In Active</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-sm btn-light"
                                    data-bs-dismiss="modal">Close</button>
                                <input type="submit" value="Create" class="btn btn-sm btn-primary">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--Eidt Meal Size Model  -->
        <div class="modal fade" id="edit_meal_size" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content rounded">
                    <div class="modal-header border-5 pb-4 mb-5">
                        <h5 class="modal-title">Update Meal Size</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pt-0">
                        <form id="editMealSizeForm">
                            <input type="hidden" name="uuid" id="edit_meal_size_id">
                            <div class="row mb-4">
                                <div class="col-lg-6">
                                    <label class="required form-label fw-semibold">Title:</label>
                                    <input type="text" class="form-control form-control-sm" id="edit_title"
                                        name="title" required />
                                </div>
                                <div class="col-lg-6">
                                    <label class="required form-label fw-semibold">Sort Order:</label>
                                    <input type="number" class="form-control form-control-sm" id="edit_sort_order"
                                        name="sort_order" required/>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-lg-6">
                                    <label class="form-label fw-semibold">Description:</label>
                                    <textarea type="text" class="form-control form-control-sm" id="edit_description" name="description"></textarea>
                                </div>
                                <div class="col-lg-6">
                                    <label class="form-label fw-semibold">Sort Description:</label>
                                    <textarea type="text" class="form-control form-control-sm" id="edit_short_description" name="short_description"></textarea>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-lg-6">
                                    <label class="form-label fw-semibold">Calories Per Day:</label>
                                    <input type="text" class="form-control form-control-sm" id="edit_calories_per_day"
                                        name="calories_per_day" placeholder="" value="" />
                                </div>
                                <div class="col-lg-6">
                                    <label class="required form-label fw-semibold">Servings:</label>
                                    <input type="number" class="form-control form-control-sm" id="edit_servings"
                                        name="servings" placeholder="" value="" />
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-lg-6">
                                    <label class="form-label fw-semibold">Protein:</label>
                                    <input type="number" class="form-control form-control-sm" id="edit_protein"
                                        name="protein" placeholder="" value="" />
                                </div>
                                <div class="col-lg-6">
                                    <label class="form-label fw-semibold">Sides:</label>
                                    <input type="number" class="form-control form-control-sm" id="edit_sides"
                                        name="sides" placeholder="" value="" />
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-lg-6">
                                    <label class="required form-label fw-semibold">Status:</label>
                                    <select name="status" id="edit_status" class="form-select form-select-sm" required>
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
        var mealSizeTable = $('#mealSize').DataTable({
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
                "url": "{{ route('admin.settings.meal.size') }}",
                "type": "POST",
                "data": function(data) {
                    data._token = "{{ csrf_token() }}";
                },
                "beforeSend": function() {
                    showOverlay();
                },
                "complete": function() {
                    hideOverlay();
                    $('[data-toggle="tooltip"]').tooltip()
                }
            },
            order: [
                [0, 'desc']
            ]
        });
        $('#search').keyup(function() {
            mealSizeTable.search($(this).val()).draw();
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
                                $('#mealSize').DataTable().ajax.reload();
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
            var mealSizeUuid = record.uuid;
            var mealSizeTitle = record.title;
            var mealSizeSortOrder = record.sort_order;
            var mealSizeDescription = record.description;
            var mealSizeShortDescription = record.short_description;
            var mealSizeCalories = record.calories_per_day;
            var mealSizeServings = record.servings;
            var mealSizeProtein = record.protein;
            var mealSizeSides = record.sides;
            var mealSizeStatus = record.status;
            // Populate the modal with the meal type data
            $('#edit_meal_size_id').val(mealSizeUuid);
            $('#edit_title').val(mealSizeTitle);
            $('#edit_sort_order').val(mealSizeSortOrder);
            $('#edit_description').val(mealSizeDescription);
            $('#edit_short_description').val(mealSizeShortDescription);
            $('#edit_calories_per_day').val(mealSizeCalories);
            $('#edit_servings').val(mealSizeServings);
            $('#edit_protein').val(mealSizeProtein);
            $('#edit_sides').val(mealSizeSides);
            $('#edit_status').val(mealSizeStatus).trigger('change');
            $('#edit_meal_size').modal('show');
        });
        // Add Meal Size
        $('#addMealSizeForm').submit(function(e) {
            e.preventDefault(); // Prevent default form submission
            var formData = $(this).serialize();
            $.ajax({
                url: "{{ route('admin.settings.meal.size.add') }}",
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
                        $('#addMealSizeForm')[0].reset();
                        $('#addMealSizeForm').find(
                                'input:not([type="button"]):not([type="submit"]), textarea, select')
                            .val('').trigger('change');
                        $('#add_meal_size').modal('hide');
                        mealSizeTable.ajax.reload(null, false);
                    } else {
                        swalAlert('Failed to add Meal Size. Please try again.', 'error',
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
        $('#editMealSizeForm').submit(function(e) {
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                url: "{{ route('admin.settings.meal.size.update') }}",
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
                        swalAlert('Meal Size updated successfully.', 'success', 'btn btn-success');
                        $('#edit_meal_size').modal('hide');
                        $('#mealSize').DataTable().ajax.reload();
                    } else {
                        swalAlert('Failed to Meal Size. Please try again.', 'error',
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
