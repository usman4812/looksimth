@php
    $formData = old();
    $mealUuid = generate_uuid_key();
@endphp
@extends('admin.main')
@push('style')
    <style>
        body.no-scroll {
            overflow: hidden;
            position: fixed;
            width: 100%;
        }

        .img-uploader {
            width: 100%;
        }

        .img-uploader .labelFile {
            display: flex;
            flex-direction: column;
            justify-content: center;
            width: 100%;
            height: 145px;
            border: 1px dashed rgba(221, 221, 221, 1);
            align-items: center;
            text-align: center;
            padding: 5px;
            color: #404040;
            cursor: pointer;
            background: var(--file-uploader-bg);
            border-radius: 4px;
            font-size: 14px;
            margin: 0;
        }

        .position-relative {
            position: relative !important;
        }

        .img-uploader:is(.labelFile,
            .img-uploader) span.file-type {
            font-size: 12px;
            font-weight: 400;
        }

        .preview-container {
            margin-top: 15px;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 10px;
        }

        .preview-item {
            position: relative;
            display: inline-block;
            width: 120px;
            height: 120px;
            border: 1px solid #ddd;
            border-radius: 5px;
            overflow: visible;
        }

        .preview-item img,
        .preview-item video {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .preview-item .remove-icon {
            position: absolute;
            top: -10px;
            right: -6px;
            /* background: rgba(255, 0, 0, 0.8); */
            background: red;
            color: white;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            text-align: center;
            line-height: 17px;
            font-size: 14px;
            cursor: pointer;
            font-weight: bold;
            z-index: 10;
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            z-index: 9999;
            justify-content: center;
            align-items: center;
        }

        /* Content inside the modal */
        .modal-content {
            position: relative;
            background: white;
            padding: 10px;
            border-radius: 8px;
            max-width: 90%;
            max-height: 90%;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 43px auto;
        }

        /* Image and video specific size */
        .modal-content img,
        .modal-content video {
            width: 80%;
            /* Set a fixed percentage or pixel value */
            height: auto;
            /* Maintain aspect ratio */
            max-height: 500px;
            /* Limit max height */
            object-fit: contain;
            /* Prevent distortion */
        }

        /* Close button */
        .close-modal {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 20px;
            color: #000;
            cursor: pointer;
            background: #fff;
            border: none;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }



        .media-loader-container {
            height: 100%;
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            /* background: #80cfe58f; */
            background: #dddddd5c;
            position: absolute;
            top: 0;
            left: 0;
            z-index: 9;
        }

        .media-loader-container .loader {
            border: 4px solid #a4d4a1;
            border-left-color: transparent;
            width: 36px;
            height: 36px;
            animation: spinner 1s linear infinite;
            border-radius: 50%;
        }

        @keyframes spinner {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .custom-btn {
            padding: 0.5px 0.5px;
            font-size: 5px;
            border-radius: 2px;
        }

        .custom-btn i {
            font-size: 10px;
        }
    </style>
@endpush
@section('content')
    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_toolbar" class="app-toolbar  d-flex flex-stack py-4 py-lg-8 ">
            <div class="d-flex flex-grow-1 flex-stack flex-wrap gap-2 mb-n10" id="kt_toolbar">
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3 ">

                    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                        Add Meals
                    </h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">

                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.meals') }}" class="text-muted text-hover-primary">Meals</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-gray-900">Add</li>
                    </ul>
                </div>
            </div>
        </div>
        <!--begin::Content-->
        <div id="kt_app_content" class="app-content  flex-column-fluid ">
            <form action="{{ route('admin.meals.add') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="uuid" id="uuid" value="{{ $mealUuid }}">
                <div class="card">
                    <div class="card-header" style="background: #ddd;">
                        <h2 class="card-title">General Info</h2>
                    </div><!--begin::Card body-->
                    <div class="card-body">
                        <!--begin::Input group-->
                        <div class="row mb-6 align-items-center">
                            <!-- First Column -->
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="company_name *"
                                        class="required col-form-label fw-semibold fs-6">Title</label>
                                    <input required type="text" name="title" class="form-control form-control-lg" value="{{ @$formData['title'] }}"
                                        placeholder="Title">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="company_name *" class="required col-form-label fw-semibold fs-6">Select
                                        Vendor</label>
                                    <button data-bs-toggle="tooltip" data-bs-placement="top" title="Add Vendor"
                                        type="button" class="btn custom-btn btn-sm btn-secondary ms-3 mb-2"
                                        id="openVendorModal">
                                        <i class="ki-duotone ki-plus"></i>
                                    </button>
                                    <select required id="vendor_dropdown" name="vendor_id" aria-label="Select a Vendor"
                                        data-placeholder="Select a Vendor..." class=" form-control">
                                        <option value="">Select a Vendor...</option>
                                        @foreach ($vendors as $vendor)
                                            <option value="{{ $vendor->uuid }}" {{ @$formData['vendor_id'] == $vendor->uuid ? 'selected' : '' }}>{{ $vendor->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="row" style="justify-content: center;">

                                    <div class="col-lg-3 fv-row fv-plugins-icon-container">
                                        <label class="col-lg-4 col-form-label  fw-semibold fs-6">&nbsp;</label>
                                        <div class="d-flex align-items-center">
                                            <label class="form-check form-check-custom form-check-inline me-2">
                                                <input class="form-check-input" name="is_autoselectable" type="checkbox"
                                                    value="1" data-gtm-form-interact-field-id="1" {{ @$formData['is_autoselectable'] == 1 ? 'checked=""' : '' }}>
                                                <span class="fw-semibold ps-2 fs-6">
                                                    Auto-select
                                                </span><i class="bi bi-info-circle"
                                                    title="Check this box to allow the meal to be auto-selected weekly for customers"
                                                    data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click"
                                                    data-bs-placement="top"></i>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 fv-row fv-plugins-icon-container">
                                        <label class="col-lg-4 col-form-label  fw-semibold fs-6">&nbsp;</label>
                                        <div class="d-flex align-items-center">
                                            <label class="form-check form-check-custom form-check-inline me-2">
                                                <input class="form-check-input" name="is_featured" type="checkbox"
                                                    value="1" {{ @$formData['is_featured'] == 1 ? 'checked=""' : '' }} data-gtm-form-interact-field-id="1">
                                                <span class="fw-semibold ps-2 fs-6">
                                                    Featured
                                                </span><i class="bi bi-info-circle"
                                                    title="Check this box to feature in Adult or Junior meal spotlight sections"
                                                    data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click"
                                                    data-bs-placement="top"></i>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end::Input group-->
                        <div class="row mb-6">
                            <div class="form-group">
                                <label for="company_name *" class="col-form-label fw-semibold fs-6">Description</label>
                                <textarea name="description" class="form-control form-control-lg" placeholder="Description" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="row mb-6 align-items-center">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="company_name *" class="required col-form-label fw-semibold fs-6">Family
                                        Style</label>
                                    <select required name="family_style" aria-label="Select a Family Style"
                                        data-placeholder="Select a Family Style..." class=" form-control">
                                        <option value="">Select a Family Style...</option>
                                        <option value="0" {{  @$formData['family_style'] == 0 ? 'selected' : '' }}>No</option>
                                        <option value="1" {{  @$formData['family_style'] == 1 ? 'selected' : '' }}>Yes</option>
                                        <option value="2" {{  @$formData['family_style'] == 2 ? 'selected' : '' }}>Only</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="meal_type_id" class="required col-form-label fw-semibold fs-6">Meal
                                        type</label>
                                    <button data-bs-toggle="tooltip" data-bs-placement="top" title="Add Meal Type"
                                        type="button" class="btn custom-btn btn-sm btn-secondary ms-3"
                                        id="openMealTypeModal">
                                        <i class="ki-duotone ki-plus"></i>
                                    </button>
                                    <select id="meal_type_dropdown" required name="meal_type_id"
                                        aria-label="Select a Meal type" data-placeholder="Select a Meal type..."
                                        class=" form-control">
                                        <option value="">Select a Meal type...</option>
                                        @foreach ($mealTypes as $mealType)
                                            <option {{ @$formData['meal_type_id'] == $mealType->uuid ? 'selected=""' : '' }} value="{{ $mealType->uuid }}">{{ $mealType->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="company_name *"
                                        class="required col-form-label fw-semibold fs-6">Price</label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input required type="text" class="form-control" name="price" value="{{ @$formData['price']  }}"
                                            aria-label="Amount (to the nearest dollar)">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="company_name *" class="required col-form-label fw-semibold fs-6">Featured
                                        Image</label>
                                    <input required class="form-control" placeholder="" name="image" type="file">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="medicaid *"
                                        class="required col-form-label fw-semibold fs-6">Medicaid</label>
                                    <select required name="medicaid" aria-label="Select a Medicaid"
                                        data-placeholder="Select a Medicaid..." class=" form-control">
                                        <option value="">Select a Medicaid...</option>
                                        <option value="0" {{  @$formData['medicaid'] == 0 ? 'selected' : '' }}>No</option>
                                        <option value="1" {{  @$formData['medicaid'] == 1 ? 'selected' : '' }}>Yes</option>
                                        <option value="2" {{  @$formData['medicaid'] == 2 ? 'selected' : '' }}>Only</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="company_name *"
                                        class="required col-form-label fw-semibold fs-6">Cafeteria</label>
                                    <select required name="cafeteria" aria-label="Select a Cafeteria"
                                        data-placeholder="Select a Cafeteria..." class=" form-control">
                                        <option value="">Select a Cafeteria...</option>
                                        <option value="0" {{  @$formData['cafeteria'] == 0 ? 'selected' : '' }}>No</option>
                                        <option value="1" {{  @$formData['cafeteria'] == 1 ? 'selected' : '' }}>Yes</option>
                                        <option value="2" {{  @$formData['cafeteria'] == 2 ? 'selected' : '' }}>Only</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Card body-->
                </div>
                <div class="card mt-4">
                    <div class="card-header" style="background: #ddd;">
                        <h2 class="card-title">Media Gallery</h2>
                    </div>
                    <div class="card-body">
                        <div class="img-uploader file-upload-wrapper mt-4">
                            <label class="labelFile position-relative" for="product_documents">
                                <input type="file" multiple="" id="product_documents"
                                    accept=".png, .jpg, .jpeg, .webp, .mp4, .mov, .avi"
                                    style="position: absolute; top: 0px; left: 0px; width: 100%; height: 100%; opacity: 0; cursor: pointer;">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M0.75 14.85C1.16421 14.85 1.5 15.1858 1.5 15.6V19.35C1.5 20.1785 2.17157 20.85 3 20.85H21C21.8284 20.85 22.5 20.1785 22.5 19.35V15.6C22.5 15.1858 22.8358 14.85 23.25 14.85C23.6642 14.85 24 15.1858 24 15.6V19.35C24 21.0069 22.6569 22.35 21 22.35H3C1.34315 22.35 0 21.0069 0 19.35V15.6C0 15.1858 0.335786 14.85 0.75 14.85Z"
                                        fill="#212529"></path>
                                    <path
                                        d="M11.4697 1.71967C11.7626 1.42678 12.2374 1.42678 12.5303 1.71967L17.0303 6.21967C17.3232 6.51256 17.3232 6.98744 17.0303 7.28033C16.7374 7.57322 16.2626 7.57322 15.9697 7.28033L12.75 4.06066V17.25C12.75 17.6642 12.4142 18 12 18C11.5858 18 11.25 17.6642 11.25 17.25V4.06066L8.03033 7.28033C7.73744 7.57322 7.26256 7.57322 6.96967 7.28033C6.67678 6.98744 6.67678 6.51256 6.96967 6.21967L11.4697 1.71967Z"
                                        fill="#212529"></path>
                                </svg>Upload or drop images &amp; docs
                                <br><span class="file-type">accepts .png, .jpg, .jpeg, .webp, .mp4, .mov, .avi</span>
                            </label>
                            <div id="preview" class="preview-container">

                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mt-4">
                    <div class="card-header" style="background: #ddd;">
                        <h2 class="card-title">Ingredients &amp; Diets</h2>
                    </div>
                    <!--begin::Card body-->
                    <div class="card-body">
                        <div class="card-body">
                            <div class="form-group d-flex align-items-center">
                                <h3 class="required">Ingredients</h3>
                                <button data-bs-toggle="tooltip" data-bs-placement="top" title="Add Ingredient"
                                    type="button" class="btn custom-btn btn-sm btn-secondary ms-3 mb-2"
                                    id="openIngredientModal">
                                    <i class="ki-duotone ki-plus"></i>
                                </button>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <div class="row mb-6 ingredient-container">
                                        @foreach ($ingredients as $ingredient)
                                            <div class="col-lg-3 fv-row fv-plugins-icon-container mt-2">
                                                <div class="d-flex align-items-center">
                                                    <label class="form-check form-check-custom form-check-inline me-2">
                                                        <input id="ingredientData" class="form-check-input"
                                                            name="ingredients[]" type="checkbox"
                                                            value="{{ $ingredient->uuid }}"
                                                            {{ in_array($ingredient->uuid, old('ingredients', @$formData['ingredients'] ?? [])) ? 'checked' : '' }}
                                                            data-gtm-form-interact-field-id="1">
                                                        <span class="fw-semibold ps-2 fs-6">
                                                            {{ $ingredient->name }}
                                                        </span>
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="form-group d-flex align-items-center mt-5">
                                <h3 class="required">Diets</h3>
                                <button data-bs-toggle="tooltip" data-bs-placement="top" title="Add Diet" type="button"
                                    class="btn custom-btn btn-sm btn-secondary ms-3 mb-2" id="openDietModal">
                                    <i class="ki-duotone ki-plus"></i>
                                </button>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <div class="row mb-6 diets-container">
                                        <!--begin::Col-->
                                        @foreach ($diets as $diet)
                                            <div class="col-lg-3 fv-row fv-plugins-icon-container mt-2">
                                                <div class="d-flex align-items-center">
                                                    <label class="form-check form-check-custom form-check-inline me-2">
                                                        <input class="form-check-input" name="diets[]" type="checkbox"
                                                            value="{{ $diet->uuid }}"
                                                            {{ in_array($diet->uuid, old('diets', @$formData['diets'] ?? [])) ? 'checked' : '' }}
                                                            data-gtm-form-interact-field-id="1">
                                                        <span class="fw-semibold ps-2 fs-6">
                                                            {{ $diet->name }}
                                                        </span>
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Card body-->
                </div>
                <div class="card mt-4">
                    <div class="card-header" style="background: #ddd;">
                        <div class="d-flex align-items-center">
                            <h2 class="required card-title mb-0">Nutrition Facts</h2>
                            <button data-bs-toggle="tooltip" data-bs-placement="top" title="Add Meal Size"
                                style="background-color: #fff" type="button"
                                class="btn custom-btn btn-sm btn-secondary ms-3" id="openMealSizeModal">
                                <i class="ki-duotone ki-plus"></i>
                            </button>
                        </div>
                    </div>
                    <!--begin::Card body-->
                    <div class="card-body">
                        <div class="table align-middle gs-0 gy-4">
                            <table class="table" id="meal_size_table">
                                <tr class="fw-bold bg-light">
                                    <th class="ps-4 min-w-150px rounded-start">Size</th>
                                    <th>Cal</th>
                                    <th>Fat (g)</th>
                                    <th>Carb (g)</th>
                                    <th>Fiber (g)</th>
                                    <th>Protein (g)</th>
                                    <th>Sodium (mg)</th>
                                </tr>
                                @foreach ($mealSizes as $key => $size)
                                    <tr>
                                        <td class="align-middle">
                                            <label class="fw-semibold fs-6">{{ $size->title }}</label>
                                            <input type="hidden" value="{{ $size->uuid }}"
                                                name="meal[nutrition_facts_attributes][{{ $key }}][meal_size_id]"
                                                id="meal_nutrition_facts_attributes_{{ $key }}_meal_size_id">
                                        </td>
                                        <td>
                                            <input type="text"
                                                name="meal[nutrition_facts_attributes][{{ $key }}][calories]"
                                                id="meal_nutrition_facts_attributes_{{ $key }}_calories"
                                                class="form-control form-control-md" placeholder="">
                                        </td>
                                        <td>
                                            <input type="text"
                                                name="meal[nutrition_facts_attributes][{{ $key }}][fat]"
                                                id="meal_nutrition_facts_attributes_{{ $key }}_fat"
                                                class="form-control form-control-md" placeholder="">
                                        </td>
                                        <td>
                                            <input type="text"
                                                name="meal[nutrition_facts_attributes][{{ $key }}][carb]"
                                                id="meal_nutrition_facts_attributes_{{ $key }}_carb"
                                                class="form-control form-control-md" placeholder="">
                                        </td>
                                        <td>
                                            <input type="text"
                                                name="meal[nutrition_facts_attributes][{{ $key }}][fiber]"
                                                id="meal_nutrition_facts_attributes_{{ $key }}_fiber"
                                                class="form-control form-control-md" placeholder="">
                                        </td>
                                        <td>
                                            <input type="text"
                                                name="meal[nutrition_facts_attributes][{{ $key }}][protein]"
                                                id="meal_nutrition_facts_attributes_{{ $key }}_protein"
                                                class="form-control form-control-md" placeholder="">
                                        </td>
                                        <td>
                                            <input type="text"
                                                name="meal[nutrition_facts_attributes][{{ $key }}][sodium]"
                                                id="meal_nutrition_facts_attributes_{{ $key }}_sodium"
                                                class="form-control form-control-md" placeholder="">
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end py-3 px-5">
                        <button type="submit" class="btn btn-sm btn-primary">Create</button>
                    </div>
                    <!--end::Card body-->
                </div>
            </form>
        </div>
        <!--end::Content-->

    </div>
    <div id="dynamicModalContainer">

    </div>
    <div id="previewModal" class="modal">
        <span class="close-modal">&times;</span>
        <div class="modal-content">
            <!-- The large preview content will be dynamically added here -->
        </div>
    </div>
@endsection
@push('script')
    <script>
        $(document).ready(function() {
            let $fileInput = $('#product_documents');
            let $previewContainer = $('#preview');
            let $modal = $('#previewModal');
            let $modalContent = $('.modal-content');
            let fileQueue = []; // Queue to store files
            let isUploading = false; // Flag to track if an upload is in progress

            // Function to handle individual file upload
            function uploadFile(file, $previewItem) {
                return new Promise((resolve, reject) => {
                    let formData = new FormData();
                    formData.append('file', file);
                    formData.append('_token', "{{ csrf_token() }}");
                    formData.append('meal_id', "{{ $mealUuid }}");

                    // Simulate AJAX upload
                    $.ajax({
                        url: '{{ route('admin.meals.media.add') }}', // Update this with your upload endpoint
                        type: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        xhr: function() {
                            let xhr = new window.XMLHttpRequest();
                            xhr.upload.addEventListener('progress', function(e) {
                                if (e.lengthComputable) {
                                    $previewItem.find('.media-loader-container').show();
                                }
                            });
                            return xhr;
                        },
                        success: function(response) {
                            resolve(response);
                        },
                        error: function(err) {
                            reject(err);
                        },
                        complete: function(jqXHR) {
                            // Hide loader after completion
                            var fileUuid = jqXHR.responseJSON.media.uuid;
                            $previewItem.find('.media-loader-container').hide();
                            $previewItem.find('.remove-icon').attr('data-uuid', fileUuid);
                        }
                    });
                });
            }

            // Function to process the file queue
            function processQueue() {
                if (fileQueue.length === 0) {
                    isUploading = false; // All files processed
                    return;
                }

                isUploading = true;
                let {
                    file,
                    $previewItem
                } = fileQueue.shift(); // Dequeue the first file

                uploadFile(file, $previewItem)
                    .then((response) => {
                        console.log('File uploaded successfully:', response);
                    })
                    .catch((err) => {
                        console.error('File upload failed:', err);
                        $previewItem.remove();
                        swalAlert('Upload failed. Please try again.', 'error', 'btn btn-danger');
                    })
                    .finally(() => {
                        processQueue(); // Process the next file
                    });
            }

            function handleFiles(files) {
                Array.from(files).forEach((file) => {
                    let fileType = file.type;
                    let $previewItem;

                    if (fileType.startsWith('image/') || fileType.startsWith('video/')) {
                        let reader = new FileReader();
                        reader.onload = function(e) {
                            if (fileType.startsWith('image/')) {
                                $previewItem = $(`
                            <div class="preview-item">
                                <div class="media-loader-container">
                                    <div class="loader"></div>
                                </div>
                                <img src="${e.target.result}" alt="image preview">
                                <div class="remove-icon">×</div>
                            </div>
                        `);
                            } else if (fileType.startsWith('video/')) {
                                $previewItem = $(`
                            <div class="preview-item">
                                <div class="media-loader-container">
                                    <div class="loader"></div>
                                </div>
                                <video src="${e.target.result}" controls></video>
                                <div class="remove-icon">×</div>
                            </div>
                        `);
                            }
                            $previewContainer.append($previewItem);

                            // Add file to the queue
                            fileQueue.push({
                                file,
                                $previewItem
                            });

                            // Start processing if not already uploading
                            if (!isUploading) {
                                processQueue();
                            }
                        };
                        reader.readAsDataURL(file);
                    } else {
                        swalAlert('Only Images and Videos are allowed.', 'error', 'btn btn-danger');
                    }
                });
            }

            // Handle drag-and-drop
            $('.file-upload-wrapper').on('dragover', function(e) {
                e.preventDefault();
                e.stopPropagation();
                $(this).addClass('dragging');
            }).on('dragleave', function(e) {
                e.preventDefault();
                e.stopPropagation();
                $(this).removeClass('dragging');
            }).on('drop', function(e) {
                e.preventDefault();
                e.stopPropagation();
                $(this).removeClass('dragging');
                handleFiles(e.originalEvent.dataTransfer.files);
            });

            // Handle file input change
            $fileInput.on('change', function() {
                handleFiles(this.files);
            });

            // Remove preview item
            $previewContainer.on('click', '.remove-icon', function() {
                var fileUuid = $(this).attr('data-uuid');
                var objj = $(this);
                $.ajax({
                    url: "{{ route('admin.meals.file.delete') }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        uuid: fileUuid
                    },
                    dataType: "JSON",
                    beforeSend: function() {
                        objj.parent('.preview-item').find('.media-loader-container').show();
                    },
                    success: function(response) {
                        objj.parent('.preview-item').find('.media-loader-container').hide();
                        if (response.success) {
                            objj.parent('.preview-item').remove();
                        }
                    },
                    error: function() {
                        swalAlert('Something went wrong.', 'error', 'btn btn-danger');
                        objj.parent('.preview-item').find('.media-loader-container').hide();
                    }
                })

            });

            // Open modal for large preview
            $previewContainer.on('click', 'img, video', function() {
                let content;
                if ($(this).is('img')) {
                    content = `<img src="${$(this).attr('src')}" alt="large preview">`;
                } else if ($(this).is('video')) {
                    content = `<video src="${$(this).attr('src')}" controls autoplay></video>`;
                }
                $modalContent.html(content);
                $modal.fadeIn();
            });

            // Close modal
            $modal.on('click', '.close-modal', function() {
                $modal.fadeOut();
            });
        });
    </script>
    <script>
        // open  meal type modal
        $(document).on('click', '#openMealTypeModal', function() {
            loadMealTypeModal();
        });

        function loadMealTypeModal() {
            $.ajax({
                url: "{{ route('get.add.meal.type.modal') }}",
                type: 'GET',
                beforeSend: function() {
                    showOverlay();
                },
                success: function(response) {
                    hideOverlay(); // Hide loader
                    if (response.success) {
                        $('#dynamicModalContainer').html(response.html);
                        var modal = new bootstrap.Modal(document.getElementById('add_meal_type'));
                        modal.show();
                    } else {
                        swalAlert('Failed to load modal. Please try again.', 'error', 'btn btn-danger');
                    }
                },
                error: function(xhr) {
                    hideOverlay(); // Hide loader
                    swalAlert('Something went wrong while loading the modal.', 'error', 'btn btn-danger');
                },
            });
        }
    </script>
    <script>
        // open Ingredient Modal
        $(document).on('click', '#openIngredientModal', function() {
            loadIngredientModal();
        });

        function loadIngredientModal() {
            $.ajax({
                url: "{{ route('get.ingredient.modal') }}",
                type: 'GET',
                beforeSend: function() {
                    showOverlay();
                },
                success: function(response) {
                    hideOverlay();
                    if (response.success) {
                        $('#dynamicModalContainer').html(response.html);
                        var modal = new bootstrap.Modal(document.getElementById('add_ingredient'));
                        modal.show();
                    } else {
                        swalAlert('Failed to load modal. Please try again.', 'error', 'btn btn-danger');
                    }
                },
                error: function(xhr) {
                    hideOverlay();
                    swalAlert('Something went wrong while loading the modal.', 'error', 'btn btn-danger');
                },
            });
        }
    </script>

    <script>
        // open Diet Modal
        $(document).on('click', '#openDietModal', function() {
            loadDietModal();
        });

        function loadDietModal() {
            $.ajax({
                url: "{{ route('get.diet.modal') }}",
                type: 'GET',
                beforeSend: function() {
                    showOverlay();
                },
                success: function(response) {
                    hideOverlay();
                    if (response.success) {
                        $('#dynamicModalContainer').html(response.html);
                        var modal = new bootstrap.Modal(document.getElementById('add_diet'));
                        modal.show();
                    } else {
                        swalAlert('Failed to load modal. Please try again.', 'error', 'btn btn-danger');
                    }
                },
                error: function(xhr) {
                    hideOverlay();
                    swalAlert('Something went wrong while loading the modal.', 'error', 'btn btn-danger');
                },
            });
        }
    </script>
    <script>
        // open Nutrition facts Modal
        $(document).on('click', '#openMealSizeModal', function() {
            loadMealSizeModal();
        });

        function loadMealSizeModal() {
            $.ajax({
                url: "{{ route('get.meal.size.modal') }}",
                type: 'GET',
                beforeSend: function() {
                    showOverlay();
                },
                success: function(response) {
                    hideOverlay();
                    if (response.success) {
                        $('#dynamicModalContainer').html(response.html);
                        var modal = new bootstrap.Modal(document.getElementById('add_meal_size'));
                        modal.show();
                    } else {
                        swalAlert('Failed to load modal. Please try again.', 'error', 'btn btn-danger');
                    }
                },
                error: function(xhr) {
                    hideOverlay();
                    swalAlert('Something went wrong while loading the modal.', 'error', 'btn btn-danger');
                },
            });
        }
    </script>
    <script>
        // open Vendor Modal
        $(document).on('click', '#openVendorModal', function() {
            loadVendorModal();
        });

        function loadVendorModal() {
            $.ajax({
                url: "{{ route('get.vendor.modal') }}",
                type: 'GET',
                beforeSend: function() {
                    showOverlay();
                },
                success: function(response) {
                    hideOverlay();
                    if (response.success) {
                        $('#dynamicModalContainer').html(response.html);
                        var modal = new bootstrap.Modal(document.getElementById('add_vendor'));
                        modal.show();
                    } else {
                        swalAlert('Failed to load modal. Please try again.', 'error', 'btn btn-danger');
                    }
                },
                error: function(xhr) {
                    hideOverlay();
                    swalAlert('Something went wrong while loading the modal.', 'error', 'btn btn-danger');
                },
            });
        }
    </script>
@endpush
