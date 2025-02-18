@extends('admin.main')
@push('style')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        table.dataTable thead th,
        table.dataTable thead td {
            padding: 10px 18px;
            border-bottom: 1px solid #111;
        }
        table {
            border-collapse: collapse;
            text-align: left !important;
            /* Default alignment for all table data */
        }

        table thead th {
            padding-left: 0.75rem !important;
        }

        tbody td p {
            margin: 0% !important;
        }

        tbody td:nth-child(2) {
            text-align: left !important;
        }

        /* Body row styling */
        table tbody tr:nth-child(even) {
            background-color: #f9f9f9 !important;
        }

        table tbody tr:nth-child(odd) {
            background-color: #fff !important;
        }
    </style>
@endpush
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
                        <li class="breadcrumb-item text-muted">Users</li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-gray-900">List</li>
                    </ul>
                </div>
                <div>
                    @can('create users')
                        <a data-bs-toggle="tooltip" title="Add User" href="{{ route('admin.user.add') }}" class="btn btn-sm primary-latest-container fw-bold">
                            <i class="fa-solid fa-plus"></i>
                            Add User
                        </a>&nbsp;
                    @endcan
                    @can('manage drivers')
                        <a data-bs-toggle="tooltip" title="Drivers" href="{{ route('admin.driver_number') }}" class="btn btn-sm success-latest-container fw-bold">
                            <i class="fa-solid fa-truck"></i>
                            Drivers
                        </a>
                    @endcan
                </div>
            </div>
        </div>
        <!--begin::Content-->
        <div id="kt_app_content" class="app-content  flex-column-fluid ">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <div class="">
                            <table class="table align-middle gs-0 gy-4 table-body-td-wrap table-background-section" id="usersTable">
                                <thead >
                                    <tr class="fw-bold bg-light table-wrap">
                                        {{-- <th>Sr #</th> --}}
                                        <th class="ps-4">Name</th>
                                        <th class="">Email</th>
                                        <th class="">Role</th>
                                        <th class="">Active</th>
                                        <th class="">Last Login</th>
                                        <th class=" ">Actions</th>
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
@endsection
@push('script')
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js">
    </script>
    <script>
        $('#usersTable').DataTable().destroy();
        var adminsTable = $('#usersTable').DataTable({
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
                "url": "{{ route('admin.users') }}",
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
            adminsTable.search($(this).val()).draw();
        });
        $(document).on("click", ".delete-btn", function(event) {
            // Prevent the default action of the anchor tag
            event.preventDefault();

            // Store the href attribute value (URL to redirect) of the clicked anchor tag
            var url = $(this).attr("href");

            // Display SweetAlert confirmation dialog
            Swal.fire({
                title: 'Are you sure to delete it?',
                text: 'You are deleting this user.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Delete it!',
                confirmButtonClass: 'btn-success',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                // If user clicks 'Yes', redirect to the specified URL
                if (result.isConfirmed) {
                    // $('#usersTable').DataTable();
                    $.ajax({
                        url: url,
                        method: 'get', // HTTP method
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}" // Include CSRF token for Laravel
                        },
                        success: function(response) {

                            swalAlert('The user has been deleted.', 'success',
                                'btn btn-success');
                            // Reload the DataTable
                            $('#usersTable').DataTable().ajax.reload();
                        },
                        error: function(xhr) {

                            swalAlert('Something went wrong. Please try again later.', 'error',
                                'btn btn-danger');
                        }
                    });
                }
            });
        });
    </script>
@endpush
