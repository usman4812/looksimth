@extends('admin.main')
@push('style')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
@endpush
@section('content')
    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_toolbar" class="app-toolbar  d-flex flex-stack py-4 py-lg-8 ">
            <div class="d-flex flex-grow-1 flex-stack flex-wrap gap-2 mb-n10" id="kt_toolbar">
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3 ">

                    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                        Menus + Orders
                    </h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">

                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">Menus + Orders</li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-gray-900">List</li>
                    </ul>
                </div>
                <div class="card-footer d-flex justify-content-end py-6 px-9 gap-2">
                    @can('create menu')
                        <a title="Add Menu" href="{{ route('admin.menus.add') }}" class="btn btn-sm primary-latest-container fw-bold me-2 d-flex align-items-center justify-content-center"><i class="fa-solid fa-plus"></i>  Add Menu</a>
                    @endcan
                    <a title="Browse by week" href="{{ route('admin.menus.browse_week') }}" class="btn btn-sm success-latest-container fw-bold me-2 d-flex align-items-center justify-content-center"><i class="fa-solid fa-calendar-days"></i>  Browse by
                        week</a>
                    <a title="Browse by month" href="{{ route('admin.menus.browse_month') }}" class="btn btn-sm info-latest-container fw-bold me-2 d-flex align-items-center justify-content-center"><i class="fa-regular fa-calendar-days"></i>  Browse by
                        month</a>
                </div>
            </div>
        </div>
        <!--begin::Content-->
        <div id="kt_app_content" class="app-content mt-6 flex-column-fluid ">
            <div class="card">
                <div class="card-body py-3">
                    <div class="table-responsive">
                        <table class="table align-middle gs-0 gy-4 table-background-section" id="menuOrderTable">
                            <thead>
                                <tr class="fw-bold bg-light wrap-all-style">
                                    <th class="ps-4 min-w-100px rounded-start">Orders</th>
                                    <th class="">Title</th>
                                    <th class="">Menu Items</th>
                                    <th class="">Public</th>
                                    <th class="">Active</th>
                                    <th class="">Delivery Date</th>
                                    <th class="min-w-200px">Actions</th>
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
    <!-- Modal Structure -->
    <div class="modal fade" id="menu_order_items" tabindex="-1" style="display: none;">
        <div class="modal-dialog modal-xl">
            <div class="modal-content rounded">
                <div class="modal-header border-5 pb-0 mb-4 w-100 d-flex justify-content-between align-items-center">
                    <h5 class="modal-title text-start w-100" id="exampleModalLabel">Menu Items</h5>
                    <button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="ki-outline ki-cross fs-1"></i>
                    </button>
                </div>
                <div id="kt_app_content" class="app-content  flex-column-fluid ">
                    <div class="card">
                        <div class="card-body py-3">
                            <div class="table-responsive">
                                <table class="table align-middle gs-0 gy-4" id="menuItemTable">
                                    <thead>
                                        <tr class="fw-bold bg-light">
                                            <th class="ps-4 rounded-start">Image</th>
                                            <th class="">Title</th>
                                            <th class="min-w-70px">Meal Type</th>
                                            <th class="">Vendor</th>
                                            <th class="">Price</th>
                                            <th class="">Featured</th>
                                            <th class="min-w-100px">Auto-Select</th>
                                            <th class="min-w-200px ">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="menuItemsContent">
                                        <!-- Menu items will be dynamically injected here -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
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
        var menuOrderTable = $('#menuOrderTable').DataTable({
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
            }],
            "ajax": {
                "url": "{{ route('admin.menus') }}",
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
            menuOrderTable.search($(this).val()).draw();
        });
    </script>
    <script>
        $(document).on("click", ".delete-btn", function(event) {
            event.preventDefault();
            var uuid = $(this).data('uuid');
            var url = "{{ route('admin.menu.delete', ':uuid') }}".replace(':uuid', uuid);
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
                                $('#menuOrderTable').DataTable().ajax.reload(null, false);
                            } else {
                                swalAlert(response.message || 'Failed to delete the item.',
                                    'error', 'btn btn-danger');
                            }
                            $('#menuOrderTable').DataTable().ajax.reload();
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
        function loadMenuItems(uuid) {
            $.ajax({
                url: "{{ route('get.menu.items', ':uuid') }}".replace(':uuid', uuid),
                method: 'GET',
                success: function(response) {
                    if (response.success) {
                        $('#menuItemsContent').html(response.html);
                    } else {
                        $('#menuItemsContent').html('<tr><td colspan="7">No menu items found.</td></tr>');
                    }
                },
                error: function() {
                    $('#menuItemsContent').html(
                        '<tr><td colspan="7">An error occurred while loading menu items.</td></tr>');
                }
            });
        }
        $(document).on('click', '.view-menu-items', function(e) {
            e.preventDefault();
            const uuid = $(this).data('uuid');
            $('#menu_order_items').attr('data-uuid', uuid);
            $('#menu_order_items').modal('show');
            loadMenuItems(uuid);
        });
        $(document).on("click", ".remove-item", function(event) {
            event.preventDefault();
            var uuid = $(this).data('uuid');
            var url = "{{ route('menu.item.delete', ':uuid') }}".replace(':uuid', uuid);

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
                                var uuid = $('#menu_order_items').data('uuid');
                                loadMenuItems(uuid);
                                $('#menuOrderTable').DataTable().ajax.reload(null, false);

                            } else {
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
@endpush
