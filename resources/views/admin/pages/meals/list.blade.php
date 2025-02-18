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
        .meal_title {
            margin: 0 0 2px 0;
            font-size: 14px;
            line-height: 1.2em;
        }

        .meal_description {
            margin: 0;
            font-size: 14px;
            line-height: 1.2em;
            font-style: italic;
            color: #666;
        }

        .nutrition_facts {
            margin-top: 4px;
            margin-bottom: 4px;
            font-size: 12px;
            line-height: 1.2em;
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
            width: 100px !important;
            height: 102px !important;
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

        .gallery-slider {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .gallery-slider img,
        .gallery-slider video {
            max-width: 100%;
            max-height: 400px;
        }
        .prev {
            left: 0;
        }

        .next {
            right: 0;
        }

        .close {
            position: absolute;
            top: 10px;
            right: 20px;
            font-size: 30px;
            cursor: pointer;
        }

        tbody td:nth-child(2) {
    width: 50px;
    max-width: 300px;
    text-align: start !important;
}
tbody td:last-child {
    /* Add your styles here */
    text-align: end !important;
    white-space: nowrap;
}

/* .sorting_1{
    display: flex;
    align-items: center;
    justify-content: center;
} */
    </style>
@endpush
@section('content')
    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_toolbar" class="app-toolbar  d-flex flex-stack py-4 py-lg-8 ">
            <div class="d-flex flex-grow-1 flex-stack flex-wrap gap-2 mb-n10" id="kt_toolbar">
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3 ">

                    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                        Meals
                    </h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">

                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">Meals</li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-gray-900">List</li>
                    </ul>
                </div>
                <div>
                    @can('create meals')
                        <a title="New Meal" href="{{ route('admin.meals.add') }}" class="btn btn-sm primary-latest-container fw-bold"><i class="fa-regular fa-folder-open"></i>  New Meal</a>
                    @endcan
                </div>
            </div>
        </div>
        <!--begin::Content-->
        <div id="kt_app_content" class="app-content mt-6 flex-column-fluid ">
            <div class="card">
                <div class="card-body py-3">
                    <div class="table-responsive">
                        <table class="table align-middle gs-0 gy-4 table-background-section" id="mealsTable">
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
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="galleryModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <div class="gallery-slider">
                <!-- Gallery images and videos will be injected here -->
            </div>
            <div style="display: flex;justify-content: center;align-items: center;column-gap: 22px;" class="mt-4">
                <button class="prev btn btn-sm btn-light-primary">Previous</button>
                <button class="next btn btn-sm btn-light-primary">Next</button>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js">
    </script>
    <script>
        var mealsTable = $('#mealsTable').DataTable({
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
                // "className": "text-center"
            }],
            "ajax": {
                "url": "{{ route('admin.meals') }}",
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
            mealTable.search($(this).val()).draw();
        });
    </script>
    <script>
        $(document).ready(function() {
            // Open the modal when "View Gallery" is clicked
            $(document).on("click", ".view-gallery", function() {
                var galleryData = $(this).data("gallery"); // Get gallery data (images and videos)
                // galleryData = $.parseJSON(galleryData);
                console.log(galleryData);
                var galleryHtml = '';

                // Loop through each item (image/video) and create HTML
                galleryData.forEach(function(item, ind) {
                    var fileDisplay = (ind <= 0) ? '' : 'style="display: none;"';
                    if (item.endsWith(".mp4")) {
                        galleryHtml +=
                            `<video ` + fileDisplay +
                            ` controls><source src="${item}" type="video/mp4"></video>`;
                    } else if (item.endsWith(".jpg") || item.endsWith(".png")) {
                        galleryHtml += `<img ` + fileDisplay + ` src="${item}" alt="Gallery Item">`;
                    }
                });

                // Insert gallery content into the modal
                $(".gallery-slider").html(galleryHtml);
                $("#galleryModal").fadeIn();
            });

            // Close the modal
            $(".close").click(function() {
                $("#galleryModal").fadeOut();
            });

            // Next and previous buttons functionality
            var currentIndex = 0;

            $(".next").click(function() {
                var items = $(".gallery-slider img, .gallery-slider video");
                currentIndex = (currentIndex + 1) % items.length;
                updateGallery();
            });

            $(".prev").click(function() {
                var items = $(".gallery-slider img, .gallery-slider video");
                currentIndex = (currentIndex - 1 + items.length) % items.length;
                updateGallery();
            });

            // Update the gallery slider to show the current item
            function updateGallery() {
                $(".gallery-slider img, .gallery-slider video").hide();
                $(".gallery-slider img, .gallery-slider video").eq(currentIndex).show();
            }

            // Initialize gallery
            $(".gallery-slider img, .gallery-slider video").hide();
            $(".gallery-slider img, .gallery-slider video").eq(currentIndex).show();
        });
    </script>
    <script>
        $(document).on("click", ".delete-btn", function(event) {
            event.preventDefault();

            // Get the UUID dynamically from the data attribute or similar
            var uuid = $(this).data('uuid'); // Ensure your button has a `data-uuid` attribute

            // Generate the URL using Laravel's route
            var url = "{{ route('admin.meals.delete', ':uuid') }}".replace(':uuid', uuid);
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
                        type: 'DELETE', // Ensure this matches your route
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
                                    $('#mealsTable').DataTable().ajax.reload(null, false);
                            } else {
                                swalAlert(response.message || 'Failed to delete the item.',
                                    'error', 'btn btn-danger');
                            }
                            $('#mealsTable').DataTable().ajax.reload();
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
@endpush
