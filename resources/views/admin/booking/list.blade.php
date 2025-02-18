@extends('admin.main')
@push('style')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <style>
        table.dataTable thead th,
        table.dataTable thead td {
            padding: 10px 18px;
            border-bottom: 1px solid #111;
        }
    </style>
    <style>
        .page_title {
            margin: 0 0 2px 0;
            font-size: 14px;
            line-height: 1.2em;
        }

        .page_description {
            margin: 0;
            font-size: 14px;
            line-height: 1.2em;
            font-style: italic;
            color: #666;
        }

        div.meal_labels span {
            display: inline-block;
            background: #f8f8f8;
            color: #666;
            padding: 0 4px;
            font-size: 13px;
            text-align: center;
            margin: 0 0 2px 0;
            border-radius: 2px;
        }

        div.meal_labels span.fam {
            background: #8cb1cc;
            color: #fff;
            margin-right: 4px
        }

        .symbol .symbol-label {
            /* width: 100px !important;
                    height: 102px !important; */
            overflow: hidden
        }

        /* Basic Modal styling */
        .modal {
            display: none;
            position: fixed;
            z-index: 99;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: #fff;
            margin: 4% auto;
            padding: 20px;
            width: 28%;
            /* width: 80%; */
            position: relative;
        }

        table thead th,
        tbody td {
            border-collapse: collapse;
            text-align: center !important;
            padding: 0.75rem !important;
            /* Default alignment for all table data */
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

        tbody td:nth-child(2) {
            width: 50px;
            max-width: 300px;
        }

        tbody td .meal_description {
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
            font-size: 16px;
        }

        table tbody tr:nth-child(odd) {
            background-color: #fff !important;
        }

        .meal_description p strong {
            background-color: transparent !important;
        }
    </style>
@endpush
@section('content')
    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_toolbar" class="app-toolbar  d-flex flex-stack py-4 py-lg-8 ">
            <div class="d-flex flex-grow-1 flex-stack flex-wrap gap-2 mb-n10" id="kt_toolbar">
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3 ">

                    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                        Bookings
                    </h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">

                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">Bookings</li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-gray-900">List</li>
                    </ul>
                </div>
                @can('create bookings')
                    <a href="{{ route('booking.add') }}" class="btn btn-sm primary-latest-container fw-bold">
                        <i class="fa-solid fa-plus"></i>
                        Add Booking</a>
                @endcan
            </div>
        </div>
        <div id="kt_app_content" class="app-content  flex-column-fluid ">
            <div class="card">
                <div class="card-body py-3">
                    <div class="table-responsive">
                        <table class="table align-middle gs-0 gy-4 table-body-td-wrap table-background-section"
                            id="bookingTable">
                            <thead>
                                <tr class="fw-bold bg-light table-wrap">
                                    <th class="ps-4 min-w-100px rounded-start">User</th>
                                    <th class="">Booking Date</th>
                                    <th class="">Time</th>
                                    <th class="">Description</th>
                                    <th class="">Service</th>
                                    <th class="">Payment Type</th>
                                    <th class="">Total Cash</th>
                                    <th class="">Material Cash</th>
                                    <th class="">Rest Cash</th>
                                    <th class="">Worker Cash</th>
                                    <th class="">Office Cash</th>
                                    <th class="">Status</th>
                                    <th class="">Actions</th>
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
        var bookingTable = $('#bookingTable').DataTable({
            "pageLength": 10,
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
                "url": "{{ route('booking') }}",
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
            bookingTable.search($(this).val()).draw();
        });
    </script>

    <script>
        $(document).on("click", ".delete-btn", function(event) {
            event.preventDefault();
            var id = $(this).data('id');
            var url = "{{ route('booking.delete', ':id') }}".replace(':id', id);
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
                        type: 'POST',
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
                                $('#bookingTable').DataTable().ajax.reload(null, false);
                            } else {
                                swalAlert(response.message || 'Failed to delete the item.',
                                    'error', 'btn btn-danger');
                            }
                            $('#bookingTable').DataTable().ajax.reload();
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
