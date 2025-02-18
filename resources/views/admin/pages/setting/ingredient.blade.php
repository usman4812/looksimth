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
                        Ingredients
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
                        <li class="breadcrumb-item text-gray-900">Ingredients</li>
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
                            <div class="card-header border-0  rest-padding">
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label fw-bold fs-3 mb-1">Ingredients</span>
                                </h3>
                                {{-- <div class="card-toolbar">
                                    <a data-bs-toggle="modal" data-bs-target="#add_diet"
                                        class="btn btn-sm btn-light-primary">
                                        <i class="ki-outline ki-plus fs-2"></i>Add Diet</a>&nbsp;
                                </div> --}}
                                <div class="card-toolbar primary-latest-button">
                                    <a title="Add Ingredient" data-bs-toggle="modal" data-bs-target="#add_ingredient"
                                        class="btn btn-sm">
                                        <i class="ki-outline ki-plus"></i>Add Ingredient</a>&nbsp;
                                </div>
                            </div>
                            <div class="card-body py-3">
                                <div class="table-responsive">
                                    <table class="table align-middle gs-0 gy-4 table-body-td-wrap table-background-section" id="ingredients">
                                        <thead>
                                            <tr class="fw-bold text-muted bg-light">
                                                <th class="ps-4 rounded-start">Name</th>
                                                <th class="">Sort Order</th>
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
        <!-- Add Ingredients Model-->
        <div class="modal fade" id="add_ingredient" tabindex="-1" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content rounded">
                    <div class="modal-header border-5 pb-0 mb-4">
                        <h5 class="modal-title" id="exampleModalLabel">Ingredient</h5>
                        <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                            <i class="ki-outline ki-cross fs-1"></i>
                        </div>
                    </div>
                    <div class="modal-body pt-0">
                        <form id="addIngredientForm" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-lg-12 mb-4">
                                    <label class="required form-label fw-semibold">Name:</label>
                                    <input type="text" class="form-control form-control-sm" name="name" placeholder=""
                                        value="" required />
                                </div>
                                <div class="col-lg-12 mb-4">
                                    <label class="required form-label fw-semibold">Sort Order:</label>
                                    <input type="number" class="form-control form-control-sm" name="sort_order"
                                        placeholder="" value="" required />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 mb-4">
                                    <label class="required form-label fw-semibold">Status:</label>
                                    <select name="status" class="form-select form-select-sm" required>
                                        <option value="">Select a Status...</option>
                                        <option value="1" selected>Active</option>
                                        <option value="0">In Active</option>
                                    </select>
                                </div>
                                <div class="col-lg-12 mb-4">
                                    <label class="required form-label fw-semibold">Image</label>
                                    <input type="file" class="form-control form-control-sm" name="icon" required/>
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
        <div class="modal fade" id="edit_ingredient" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content rounded">
                    <div class="modal-header border-5 pb-4 mb-5">
                        <h5 class="modal-title">Update Ingredient</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pt-0">
                        <form id="editIngredientForm" enctype="multipart/form-data">
                            <input type="hidden" name="uuid" id="edit_ingredient_id">
                            <div class="row">
                                <div class="col-lg-12 mb-4">
                                    <label class="required form-label fw-semibold">Name:</label>
                                    <input type="text" class="form-control form-control-sm" id="edit_ingredient_name"
                                        name="name" required />
                                </div>
                                <div class="col-lg-12 mb-4">
                                    <label class="required form-label fw-semibold">Sort Order:</label>
                                    <input type="number" class="form-control form-control-sm" id="edit_ingredient_order"
                                        name="sort_order" required />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 mb-4">
                                    <label class="required form-label fw-semibold">Status:</label>
                                    <select name="status" id="edit_ingredient_status" class="form-select form-select-sm"
                                        required>
                                        <option value="">Select a Status...</option>
                                        <option value="1">Active</option>
                                        <option value="0">In Active</option>
                                    </select>
                                </div>
                                <div class="col-lg-12 mb-4">
                                    <label class="form-label fw-semibold">Image</label>
                                    <input type="file" class="form-control form-control-sm" id="edit_ingredient_icon"
                                        name="icon"/>
                                    <span class="symbol-label bg-light">
                                        <!-- Image Preview -->
                                        <img id="edit_ingredient_image_preview" class="mt-2" style="width: 60px; height: 50px;"
                                            alt="Ingredient Icon" />
                                    </span>
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
        var ingredientTable = $('#ingredients').DataTable({
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
                // Remove form-control-sm class from the search input
                $('.dataTables_filter input[type="search"]').removeClass('form-control-sm');
            },
            "columnDefs": [{
                "targets": "_all",
                "className": "text-center"
            }],
            "ajax": {
                "url": "{{ route('admin.settings.ingredients') }}",
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
            ingredientTable.search($(this).val()).draw();
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
                                $('#ingredients').DataTable().ajax.reload();
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
            var ingredientUuid = record.uuid;
            var ingredientName = record.name;
            var ingredientSortOrder = record.sort_order;
            var ingredientStatus = record.status;
            var ingredientIcon = record.icon;
            // Populate the modal with the meal type data
            $('#edit_ingredient_id').val(ingredientUuid);
            $('#edit_ingredient_name').val(ingredientName);
            $('#edit_ingredient_order').val(ingredientSortOrder);
            $('#edit_ingredient_status').val(ingredientStatus);
            $('#edit_ingredient_status').val(ingredientStatus).trigger('change');
            // Dynamically update the image preview
            var imagePath = ingredientIcon ? `/images/ingredients/${ingredientIcon}` : '/images/placeholder.png';
            $('#edit_ingredient_image_preview').attr('src', imagePath);
            $('#edit_ingredient').modal('show');
        });
        // Add Ingredients ajax
        $('#addIngredientForm').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                url: "{{ route('admin.settings.ingredient.add') }}",
                type: 'POST',
                data: formData,
                processData: false, // Prevent jQuery from automatically processing the data
                contentType: false,
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
                        $('#addIngredientForm')[0].reset();
                        $('#addIngredientForm').find(
                                'input:not([type="button"]):not([type="submit"]), textarea, select')
                            .val('').trigger('change');
                        $('#add_ingredient').modal('hide');
                        ingredientTable.ajax.reload(null, false);

                    } else {
                        swalAlert('Failed to add ingredient. Please try again.', 'error',
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

        // Edit Meal Type Ajax Request
        $('#editIngredientForm').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                url: "{{ route('admin.settings.ingredient.update') }}",
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                beforeSend: function() {
                    showOverlay(); // Show overlay before data fetch
                },
                success: function(response) {
                    hideOverlay();
                    if (response.success) {
                        swalAlert('Ingredient updated successfully.', 'success', 'btn btn-success');
                        $('#edit_ingredient').modal('hide');
                        $('#ingredients').DataTable().ajax.reload();
                    } else {
                        swalAlert('Failed to update ingredient. Please try again.', 'error',
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
