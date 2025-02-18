@extends('admin.main')
@section('content')
    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_toolbar" class="app-toolbar  d-flex flex-stack py-4 py-lg-8 ">
            <div class="d-flex flex-grow-1 flex-stack flex-wrap gap-2 mb-n10" id="kt_toolbar">
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3 ">

                    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                        Customers
                    </h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">

                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">Customers</li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-gray-900">List</li>
                    </ul>
                </div>
                <div>
                    @can('create customers')
                        <a title="Add Customer" href="{{ route('admin.customers.add') }}" class="btn btn-sm primary-latest-container fw-bold"><i class="fa-solid fa-plus me-2"></i>Add Customer</a>
                    @endcan
                    @can('create customers')
                        <a title="Send a Message" href="{{ route('admin.messages') }}" class="btn btn-sm success-latest-container fw-bold"><i class="fa-regular fa-paper-plane me-2"></i>Send a Message</a>
                    @endcan

                    <a title="Download as CSV" href="#" class="btn btn-sm light-latest-container fw-bold"><i class="fa-solid fa-download me-2"></i>Download as CSV</a>

                    <a title="Reports" href="#" class="btn btn-sm info-latest-container fw-bold"><i class="fa-regular fa-file me-2"></i>Reports</a>
                </div>
            </div>
        </div>
        <div id="kt_app_content" class="app-content  flex-column-fluid">
            <div class="card">
                <div class="card-body py-3">
                    <div class="table-responsive">
                        <table class="table align-middle gs-0 gy-4" id="customerTable">
                            <thead>
                                <tr class="fw-bold bg-light">
                                    <th class="ps-4 min-w-150px rounded-start">Name</th>
                                    <th class="">Email</th>
                                    <th class="">Customer Group</th>
                                    <th class="">Status</th>
                                    <th class="">Member</th>
                                    <th class="">Action</th>
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
    <!-- Customer Profile Modal-->
    <div class="modal fade" id="customer_profiles" tabindex="-1" style="display: none;">
        <div class="modal-dialog modal-xl">
            <div class="modal-content rounded">
                <div class="modal-header border-5 pb-0 mb-4 w-100 d-flex justify-content-between align-items-center">
                    <h5 class="modal-title text-start w-100" id="exampleModalLabel">Customer Profiles</h5>
                    <button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="ki-outline ki-cross fs-1"></i>
                    </button>
                </div>
                <div id="kt_app_content" class="app-content  flex-column-fluid ">
                    <div class="text-end" id="add-profile-button-container">
                    </div>
                    <div class="card">
                        <div class="card-body py-3">
                            <div class="table-responsive">
                                <table class="table align-middle gs-0 gy-4" id="customerProfileTable">
                                    <thead>
                                        <tr class="fw-bold bg-light">
                                            <th class="ps-4 min-w-150px rounded-start">Name</th>
                                            <th class="">Email</th>
                                            <th class="">Customer Group</th>
                                            <th class="">Status</th>
                                            <th class="">Action</th>
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
@endsection
@push('script')
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js">
    </script>
    <script>
        var customerTable = $('#customerTable').DataTable({
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
                "url": "{{ route('admin.customers') }}",
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
            customerTable.search($(this).val()).draw();
        });
    </script>
    <script>
        $(document).on("click", ".delete-btn", function(event) {
            event.preventDefault();
            var uuid = $(this).data('uuid');
            var url = "{{ route('admin.customers.delete', ':uuid') }}".replace(':uuid', uuid);
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
                                $('#customerTable').DataTable().ajax.reload(null, false);
                            } else {
                                swalAlert(response.message || 'Failed to delete the item.',
                                    'error', 'btn btn-danger');
                            }
                            $('#customerTable').DataTable().ajax.reload();
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
        $(document).on('click', '.view-profile-list', function(e) {
            e.preventDefault();
            const customer_uuid = $(this).data('profile-uuid');
            $('#customer_profiles').find('tbody').html(
                '<tr><td colspan="5" class="text-center">Loading...</td></tr>');
            // Set the "Add New Profile" button dynamically
            $('#add-profile-button-container').html(`
            <a href="/customers/${customer_uuid}/add" class="btn btn-sm btn-primary fw-bold" style="display: inline-block; margin-right: 10px; padding-right: 12px; padding-left: 12px;">Add New Profile</a>
            `);
            const timestamp = new Date().getTime();
            const url = '/customers/' + customer_uuid + '/profile?timestamp=' + timestamp;
            $.ajax({
                url: url,
                type: 'GET',
                success: function(response) {
                    $('#customer_profiles').find('tbody').html(response.html);
                    $('#customer_profiles').modal('hide').modal('show');
                },
                error: function(xhr) {
                    $('#customer_profiles').find('tbody').html(
                        '<tr><td colspan="5" class="text-center">Failed to load profiles. Please try again later.</td></tr>'
                    );
                }
            });
        });
    </script>
@endpush
