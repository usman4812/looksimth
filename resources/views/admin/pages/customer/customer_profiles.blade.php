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
                        <a href="{{ route('admin.customers.profile.add',['uuid' => $uuid])}}" class="btn btn-sm btn-primary fw-bold">Add New Profile</a>
                    @endcan
                    {{-- @can('create customers')
                    <a href="{{ route('admin.messages') }}" class="btn btn-sm btn-success fw-bold">Send a Message</a>
                    @endcan

                    <a href="#" class="btn btn-sm btn-secondary fw-bold">Download as CSV</a>

                    <a href="#" class="btn btn-sm btn-info fw-bold">Reports</a> --}}
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
                                    {{-- <th class="">Order</th>
                                    <th class="">Plan</th>
                                    <th class="">Zip</th>
                                    <th class="">Sign Up</th>
                                    <th class="">Start</th>
                                    <th class="">End</th> --}}
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
                // "className": "text-center"
            }],
            "ajax": {
                "url": "{{ route('admin.customers.profile',':uuid') }}".replace(':uuid', uuid)
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
@endpush