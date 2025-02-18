<style>
    .custom-btn {
        padding: 0.5px 0.5px;
        font-size: 5px;
        border-radius: 2px;
    }

    .custom-btn i {
        font-size: 10px;
    }

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
</style>
<div class="modal fade" id="edit_meal_form" tabindex="-1" style="display: none;">
    <div class="modal-dialog modal-xl">
        <div class="modal-content rounded">
            <div class="modal-header border-5 pb-0 mb-4 w-100 d-flex justify-content-between align-items-center">
                <h5 class="modal-title text-start w-100" id="exampleModalLabel">Edit Meal</h5>
                <button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i class="ki-outline ki-cross fs-1"></i>
                </button>
            </div>
            <div class="modal-body pt-0">
                <form id="EditmenuOrderMealForm" enctype="multipart/form-data">
                    <input type="hidden" id="uuid" name="uuid" value="{{ $mealUUID }}">
                    <div class="card">
                        <div class="card-header" style="background: #ddd;">
                            <h2 class="card-title">General Info</h2>
                        </div>
                        <div class="card-body">
                            <div class="row mb-6 align-items-center">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="title*"
                                            class="required col-form-label fw-semibold fs-6">Title</label>
                                        <input required type="text" name="title" value="{{ $meal->title }}"
                                            class="form-control form-control-sm" placeholder="Title">
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="company_name *"
                                            class="required col-form-label fw-semibold fs-6">Select
                                            Vendor</label>
                                        <button data-bs-toggle="tooltip" data-bs-placement="top" title="Add Vendor"
                                            type="button" class="btn custom-btn btn-sm btn-secondary ms-3 mb-2"
                                            id="openVendorModal">
                                            <i class="ki-duotone ki-plus"></i>
                                        </button>
                                        <select required id="vendor_dropdown" name="vendor_id"
                                            aria-label="Select a Vendor" data-placeholder="Select a Vendor..."
                                            class=" form-control form-control-sm">
                                            <option value="">Select a Vendor...</option>
                                            @foreach ($vendors as $vendor)
                                                <option value="{{ $vendor->uuid }}"
                                                    {{ $vendor->uuid == $meal->vendor_id ? 'selected' : '' }}>
                                                    {{ $vendor->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="row" style="justify-content: center;">
                                        <div class="col-lg-6 fv-row fv-plugins-icon-container">
                                            <label class="col-lg-4 col-form-label  fw-semibold fs-6">&nbsp;</label>
                                            <div class="d-flex align-items-center">
                                                <label class="form-check form-check-custom form-check-inline me-2">
                                                    <input class="form-check-input" name="is_autoselectable"
                                                        type="checkbox" value="1"
                                                        {{ $meal->is_autoselectable == 1 ? 'checked=""' : '' }}
                                                        data-gtm-form-interact-field-id="1">
                                                    <span class="fw-semibold ps-1 fs-6">Auto-select</span><i
                                                        class="bi bi-info-circle"
                                                        title="Check this box to allow the meal to be auto-selected weekly for customers"
                                                        data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                        data-bs-dismiss="click" data-bs-placement="top"></i>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 fv-row fv-plugins-icon-container">
                                            <label class="col-lg-4 col-form-label  fw-semibold fs-6">&nbsp;</label>
                                            <div class="d-flex align-items-center">
                                                <label class="form-check form-check-custom form-check-inline me-2">
                                                    <input class="form-check-input" name="is_featured" type="checkbox"
                                                        value="1" data-gtm-form-interact-field-id="1"
                                                        {{ $meal->is_featured == 1 ? 'checked=""' : '' }}>
                                                    <span class="fw-semibold ps-1  fs-6">Featured
                                                    </span><i class="bi bi-info-circle"
                                                        title="Check this box to feature in Adult or Junior meal spotlight sections"
                                                        data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                        data-bs-dismiss="click" data-bs-placement="top"></i>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-6">
                                <div class="form-group">
                                    <label for="company_name *"
                                        class="col-form-label fw-semibold fs-6">Description</label>
                                    <textarea name="description" class="form-control form-control-sm" placeholder="Description" rows="5">{{ $meal->description }}</textarea>
                                </div>
                            </div>
                            <div class="row mb-6 align-items-center">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="company_name *"
                                            class="required col-form-label fw-semibold fs-6">Family
                                            Style</label>
                                        <select required name="family_style" aria-label="Select a Family Style"
                                            data-placeholder="Select a Family Style..."
                                            class="form-control form-control-sm">
                                            <option value="">Select a Family Style...</option>
                                            <option value="0" {{ $meal->family_style == 0 ? 'selected' : '' }}>No
                                            </option>
                                            <option value="1" {{ $meal->family_style == 1 ? 'selected' : '' }}>Yes
                                            </option>
                                            <option value="2" {{ $meal->family_style == 2 ? 'selected' : '' }}>
                                                Only</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="meal_type_id"
                                            class="required col-form-label fw-semibold fs-6">Meal
                                            type</label>
                                        <button data-bs-toggle="tooltip" data-bs-placement="top"
                                            title="Add Meal Type" type="button"
                                            class="btn custom-btn btn-sm btn-secondary ms-3" id="openMealTypeModal">
                                            <i class="ki-duotone ki-plus"></i>
                                        </button>
                                        <select id="meal_type_dropdown" required name="meal_type_id"
                                            aria-label="Select a Meal type" data-placeholder="Select a Meal type..."
                                            class="form-control form-control-sm">
                                            <option value="">Select a Meal type...</option>
                                            @foreach ($mealTypes as $mealType)
                                                <option
                                                    {{ @$formData['meal_type_id'] == $mealType->uuid ? 'selected=""' : '' }}
                                                    value="{{ $mealType->uuid }}"
                                                    {{ $mealType->uuid == $meal->meal_type_id ? 'selected' : '' }}>
                                                    {{ $mealType->title }}</option>
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
                                            <input required type="text" class="form-control form-control-sm"
                                                name="price" value="{{ $meal->price }}"
                                                aria-label="Amount (to the nearest dollar)">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="company_name *" class="col-form-label fw-semibold fs-6">Featured
                                            Image</label>
                                        <input class="form-control form-control-sm" placeholder="" name="image"
                                            type="file">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="medicaid *"
                                            class="required col-form-label fw-semibold fs-6">Medicaid</label>
                                        <select required name="medicaid" aria-label="Select a Medicaid"
                                            data-placeholder="Select a Medicaid..."
                                            class="form-control form-control-sm">
                                            <option value="">Select a Medicaid...</option>
                                            <option value="0" {{ $meal->medicaid == 0 ? 'selected' : '' }}>No
                                            </option>
                                            <option value="1" {{ $meal->medicaid == 1 ? 'selected' : '' }}>Yes
                                            </option>
                                            <option value="2" {{ $meal->medicaid == 2 ? 'selected' : '' }}>Only
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="company_name *"
                                            class="required col-form-label fw-semibold fs-6">Cafeteria</label>
                                        <select required name="cafeteria" aria-label="Select a Cafeteria"
                                            data-placeholder="Select a Cafeteria..."
                                            class="form-control form-control-sm">
                                            <option value="">Select a Cafeteria...</option>
                                            <option value="0" {{ $meal->cafeteria == 0 ? 'selected' : '' }}>No
                                            </option>
                                            <option value="1" {{ $meal->cafeteria == 1 ? 'selected' : '' }}>Yes
                                            </option>
                                            <option value="2" {{ $meal->cafeteria == 2 ? 'selected' : '' }}>Only
                                            </option>
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
                                    <br><span class="file-type">accepts .png, .jpg, .jpeg, .webp, .mp4, .mov,
                                        .avi</span>
                                </label>
                                <div id="preview" class="preview-container">
                                    @foreach ($mealMedia as $media)
                                        <div class="preview-item">
                                            <div class="media-loader-container" style="display: none">
                                                <div class="loader"></div>
                                            </div>
                                            @if (in_array(pathinfo($media->file, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'webp']))
                                                <img src="{{ asset('storage/public/web_assets/media/meals/' . $media->meal_id . '/' . $media->file) }}"
                                                    alt="Meal Media" class="preview-image">
                                                <div class="remove-icon" data-uuid="{{ $media->uuid }}">×</div>
                                            @elseif(in_array(pathinfo($media->file, PATHINFO_EXTENSION), ['mp4', 'mov', 'avi']))
                                                <video
                                                    src="{{ asset('storage/public/web_assets/media/meals/' . $media->meal_id . '/' . $media->file) }}"
                                                    controls></video>
                                                <div class="remove-icon" data-uuid="{{ $media->uuid }}">×</div>
                                            @endif
                                        </div>
                                    @endforeach
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
                                            <!--begin::Col-->
                                            @foreach ($ingredients as $ingredient)
                                                <div class="col-lg-3 fv-row fv-plugins-icon-container mt-2">
                                                    <div class="d-flex align-items-center">
                                                        <label
                                                            class="form-check form-check-custom form-check-inline me-2">
                                                            <input class="form-check-input" name="ingredients[]"
                                                                type="checkbox" value="{{ $ingredient->uuid }}"
                                                                data-gtm-form-interact-field-id="1"
                                                                {{ in_array($ingredient->uuid, $mealIngredients) ? 'checked' : '' }}>
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
                                    <button data-bs-toggle="tooltip" data-bs-placement="top" title="Add Diet"
                                        type="button" class="btn custom-btn btn-sm btn-secondary ms-3 mb-2"
                                        id="openDietModal">
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
                                                        <label
                                                            class="form-check form-check-custom form-check-inline me-2">
                                                            <input class="form-check-input" name="diets[]"
                                                                type="checkbox" value="{{ $diet->uuid }}"
                                                                data-gtm-form-interact-field-id="1"
                                                                {{ in_array($diet->uuid, $mealDiets) ? 'checked' : '' }}>
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
                                        @php
                                            $nutritionFact = $mealNutritionFacts->get($size->uuid);
                                        @endphp
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
                                                    class="form-control form-control-sm"
                                                    value="{{ $nutritionFact->calories ?? '' }}">
                                            </td>
                                            <td>
                                                <input type="text"
                                                    name="meal[nutrition_facts_attributes][{{ $key }}][fat]"
                                                    id="meal_nutrition_facts_attributes_{{ $key }}_fat"
                                                    class="form-control form-control-sm"
                                                    value="{{ $nutritionFact->fat ?? '' }}">
                                            </td>
                                            <td>
                                                <input type="text"
                                                    name="meal[nutrition_facts_attributes][{{ $key }}][carb]"
                                                    id="meal_nutrition_facts_attributes_{{ $key }}_carb"
                                                    class="form-control form-control-sm"
                                                    value="{{ $nutritionFact->carb ?? '' }}">
                                            </td>
                                            <td>
                                                <input type="text"
                                                    name="meal[nutrition_facts_attributes][{{ $key }}][fiber]"
                                                    id="meal_nutrition_facts_attributes_{{ $key }}_fiber"
                                                    class="form-control form-control-sm"
                                                    value="{{ $nutritionFact->fiber ?? '' }}">
                                            </td>
                                            <td>
                                                <input type="text"
                                                    name="meal[nutrition_facts_attributes][{{ $key }}][protein]"
                                                    id="meal_nutrition_facts_attributes_{{ $key }}_protein"
                                                    class="form-control form-control-sm"
                                                    value="{{ $nutritionFact->protein ?? '' }}">
                                            </td>
                                            <td>
                                                <input type="text"
                                                    name="meal[nutrition_facts_attributes][{{ $key }}][sodium]"
                                                    id="meal_nutrition_facts_attributes_{{ $key }}_sodium"
                                                    class="form-control form-control-sm"
                                                    value="{{ $nutritionFact->sodium ?? '' }}">
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end py-3 px-5">
                            <button type="submit" class="btn btn-sm btn-primary">Update</button>
                        </div>
                        <!--end::Card body-->
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Vendor Modal Body-->
<div class="modal fade" id="add_vendor" tabindex="-1" style="display: none;" aria-hidden="false">
    <div class="modal-dialog modal-md">
        <div class="modal-content rounded">
            <div class="modal-header border-5 pb-0 mb-4 w-100 d-flex justify-content-between align-items-center">
                <h5 class="modal-title text-start w-100" id="exampleModalLabel">Vendor</h5>
                <button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i class="ki-outline ki-cross fs-1"></i>
                </button>
            </div>
            <div class="modal-body pt-0">
                <form id="addVendor">
                    <div class="row">
                        <div class="col-lg-12 mb-4">
                            <label class="required form-label fw-semibold">Name:</label>
                            <input type="text" class="form-control form-control-sm" name="name" required />
                        </div>
                        <div class="col-lg-12 mb-4">
                            <label class="form-label fw-semibold">Description:</label>
                            <textarea type="text" class="form-control form-control-sm" name="description"></textarea>
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
<!-- Meal type Modal Body-->
<div class="modal fade" id="add_meal_type" tabindex="-1" style="display: none;">
    <div class="modal-dialog modal-md">
        <div class="modal-content rounded">
            <div class="modal-header border-5 pb-0 mb-4 w-100 d-flex justify-content-between align-items-center">
                <h5 class="modal-title text-start w-100" id="exampleModalLabel">Meal Types</h5>
                <button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i class="ki-outline ki-cross fs-1"></i>
                </button>
            </div>
            <div class="modal-body pt-0">
                <form id="addMealTypeForm">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12 mb-4">
                            <label class="required form-label fw-semibold">Title:</label>
                            <input type="text" class="form-control form-control-sm" name="title" required />
                        </div>
                        <div class="col-lg-12 mb-4">
                            <label class="required form-label fw-semibold">Name:</label>
                            <input type="text" class="form-control form-control-sm" name="name" required />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 mb-4">
                            <label class="required form-label fw-semibold">Sort Order:</label>
                            <input type="number" class="form-control form-control-sm" name="sort_order" required />
                        </div>
                        <div class="col-lg-12 mb-4">
                            <label class="requiredform-label fw-semibold">Status:</label>
                            <select name="status" class="form-select form-select-sm" required>
                                <option value="">Select a Status...</option>
                                <option value="1" selected>Active</option>
                                <option value="0">In Active</option>
                            </select>
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
<!-- Ingredient Modal Body-->
<div class="modal fade" id="add_ingredient" tabindex="-1" style="display: none;">
    <div class="modal-dialog modal-md">
        <div class="modal-content rounded">
            <div class="modal-header border-5 pb-0 mb-4 w-100 d-flex justify-content-between align-items-center">
                <h5 class="modal-title text-start w-100" id="exampleModalLabel">Ingredient</h5>
                <button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i class="ki-outline ki-cross fs-1"></i>
                </button>
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
                            <input type="file" class="form-control form-control-sm" name="icon" required />
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
<!-- Diet Modal Body-->
<div class="modal fade" id="add_diet" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content rounded">
            <div class="modal-header border-5 pb-0 mb-4 w-100 d-flex justify-content-between align-items-center">
                <h5 class="modal-title text-start w-100" id="exampleModalLabel">Diet</h5>
                <button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i class="ki-outline ki-cross fs-1"></i>
                </button>
            </div>
            <div class="modal-body pt-0">
                <form id="addDietForm">
                    <div class="row">
                        <div class="col-lg-12 mb-4">
                            <label class="required form-label fw-semibold">Name:</label>
                            <input type="text" class="form-control form-control-sm" name="name" required />
                        </div>

                        <div class="col-lg-12 mb-4">
                            <label class="required form-label fw-semibold">Abbr:</label>
                            <input type="text" class="form-control form-control-sm" name="abbr" required />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 mb-4">
                            <label class="required form-label fw-semibold">Sort Order:</label>
                            <input type="number" class="form-control form-control-sm" name="sort_order" required />
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
<!-- Meal Size Modal Body-->
<div class="modal fade" id="add_meal_size" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content rounded">
            <div class="modal-header border-5 pb-0 mb-4 w-100 d-flex justify-content-between align-items-center">
                <h5 class="modal-title text-start w-100" id="exampleModalLabel">Meal Size</h5>
                <button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i class="ki-outline ki-cross fs-1"></i>
                </button>
            </div>
            <div class="modal-body" style="width: 100%;">
                <form id="addMealSizeForm">
                    <div class="row mb-4">
                        <div class="col-lg-6">
                            <label class="required form-label fw-semibold">Title:</label>
                            <input type="text" class="form-control form-control-sm" name="title" required />
                        </div>
                        <div class="col-lg-6">
                            <label class="required form-label fw-semibold">Sort Order:</label>
                            <input type="number" class="form-control form-control-sm" name="sort_order" required />
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
                            <input type="number" class="form-control form-control-sm" name="protein" placeholder=""
                                value="" />
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label fw-semibold">Sides:</label>
                            <input type="number" class="form-control form-control-sm" name="sides" placeholder=""
                                value="" />
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
                        <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Close</button>
                        <input type="submit" value="Create" class="btn btn-sm btn-primary">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $('#menuOrderMealForm').submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: "{{ route('admin.meals.add') }}",
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            beforeSend: function() {
                showOverlay();
            },
            success: function(response) {
                hideOverlay();
                if (response.success) {
                    swalAlert(response.message, 'success', 'btn btn-success');
                    $('#menuOrderMealForm')[0].reset();
                    $('#menuOrderMealForm').find(
                            'input:not([type="button"]):not([type="submit"]), textarea, select')
                        .val('').trigger('change');
                    $('#add_meal_form').modal('hide');

                    // var modal = new bootstrap.Modal(document.getElementById('add_meal_form'));
                    // modal.hide();
                    mealsTable.ajax.reload(null, false);
                } else {
                    swalAlert('Failed to add ingredient. Please try again.', 'error',
                        'btn btn-danger');
                }
            },
            error: function(xhr) {
                hideOverlay();
                var errorMessage = xhr.responseJSON?.message ||
                    'Something went wrong. Please try again later.';
                swalAlert(errorMessage, 'error', 'btn btn-danger');
            }
        });
    });
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
    $('#addVendor').submit(function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            url: "{{ route('admin.settings.vendors.add') }}",
            type: 'POST',
            data: formData,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            beforeSend: function() {
                showOverlay();
            },
            success: function(response) {
                hideOverlay();
                if (response.success) {
                    swalAlert('Vendor added successfully.', 'success', 'btn btn-success');
                    $('#addVendor')[0].reset();
                    $('#addVendor').find(
                            'input:not([type="button"]):not([type="submit"]), textarea, select')
                        .val('').trigger('change');
                    $('#add_vendor').modal('hide');
                    updateVendorDropdown();
                } else {
                    swalAlert('Failed to add Vendor. Please try again.', 'error',
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
    // Update Vendors Dropdown
    function updateVendorDropdown() {
        $.ajax({
            url: "{{ route('get.vendors') }}",
            type: 'GET',
            success: function(response) {
                if (response.success) {
                    var vendors = response.data;
                    var $dropdown = $('#vendor_dropdown');
                    $dropdown.empty();
                    $dropdown.append('<option value="">Select a Vendor...</option>');
                    $.each(vendors, function(index, vendor) {
                        $dropdown.append('<option value="' + vendor.uuid + '">' + vendor.name +
                            '</option>');
                    });
                    $dropdown.trigger('change');
                } else {
                    swalAlert('Failed to fetch vendors. Please try again.', 'error', 'btn btn-danger');
                }
            },
            error: function(xhr) {
                swalAlert('Error fetching vendors. Please try again later.', 'error', 'btn btn-danger');
            }
        });
    }
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
                hideOverlay();
                if (response.success) {
                    $('#dynamicModalContainer').html(response.html);
                    var modal = new bootstrap.Modal(document.getElementById('add_meal_type'));
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
    $(document).on('submit', '#addMealTypeForm', function(e) {
        e.preventDefault(); // Prevent the default form submission
        var formData = $(this).serialize();

        $.ajax({
            url: "{{ route('admin.settings.meal.types.add') }}",
            type: 'POST',
            data: formData,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            beforeSend: function() {
                showOverlay(); // Show loader
            },
            success: function(response) {
                hideOverlay(); // Hide loader
                if (response.success) {
                    swalAlert('Meal type added successfully.', 'success', 'btn btn-success');
                    $('#addMealTypeForm')[0].reset();
                    $('#addMealTypeForm').find('input, select').val('').trigger('change');
                    $('#add_meal_type').modal('hide');
                    updateMealTypeDropdown();
                } else {
                    swalAlert('Failed to add meal type. Please try again.', 'error',
                        'btn btn-danger');
                }
            },
            error: function(xhr) {
                hideOverlay();
                swalAlert('An error occurred. Please try again later.', 'error', 'btn btn-danger');
            }
        });
    });
    // Update Meal Type Dropdown
    function updateMealTypeDropdown() {
        $.ajax({
            url: "{{ route('admin.settings.get.meal.types') }}",
            type: 'GET',
            success: function(response) {
                if (response.success) {
                    var mealTypes = response.data;
                    var $dropdown = $('#meal_type_dropdown');
                    $dropdown.empty();
                    $dropdown.append('<option value="">Select a Meal Type...</option>');
                    $.each(mealTypes, function(index, mealType) {
                        $dropdown.append('<option value="' + mealType.uuid + '">' + mealType.title +
                            '</option>');
                    });
                    $dropdown.trigger('change');
                } else {
                    swalAlert('Failed to fetch meal types. Please try again.', 'error', 'btn btn-danger');
                }
            },
            error: function(xhr) {
                swalAlert('Error fetching meal types. Please try again later.', 'error', 'btn btn-danger');
            }
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
    $('#addIngredientForm').submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: "{{ route('admin.settings.ingredient.add') }}",
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            beforeSend: function() {
                showOverlay();
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
                    updateIngredients();
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
    //  get update ingredients
    function updateIngredients() {
        $.ajax({
            url: "{{ route('get.ingredients') }}",
            type: 'GET',
            success: function(response) {
                if (response.success) {
                    var ingredients = response.data;
                    var $ingredientContainer = $('.ingredient-container');
                    $ingredientContainer.empty();
                    $.each(ingredients, function(index, ingredient) {
                        var checkboxHtml = `
                        <div class="col-lg-3 fv-row fv-plugins-icon-container mt-2">
                            <div class="d-flex align-items-center">
                                <label class="form-check form-check-custom form-check-inline me-2">
                                    <input class="form-check-input"
                                           name="ingredients[]" type="checkbox"
                                           value="${ingredient.uuid}">
                                    <span class="fw-semibold ps-2 fs-6">${ingredient.name}</span>
                                </label>
                            </div>
                        </div>
                    `;
                        $ingredientContainer.append(checkboxHtml);
                    });
                } else {
                    swalAlert('Failed to fetch ingredients. Please try again.', 'error', 'btn btn-danger');
                }
            },
            error: function(xhr) {
                swalAlert('Error fetching ingredients. Please try again later.', 'error', 'btn btn-danger');
            }
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
    $(document).on('submit', '#addDietForm', function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            url: "{{ route('admin.settings.diets.add') }}",
            type: 'POST',
            data: formData,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            beforeSend: function() {
                showOverlay();
            },
            success: function(response) {
                hideOverlay();
                if (response.success) {
                    swalAlert('Meal type added successfully.', 'success', 'btn btn-success');
                    $('#addDietForm')[0].reset();
                    $('#addDietForm').find('input, select').val('').trigger('change');
                    $('#add_diet').modal('hide');
                    updateDietsData();
                } else {
                    swalAlert('Failed to add meal type. Please try again.', 'error',
                        'btn btn-danger');
                }
            },
            error: function(xhr) {
                hideOverlay();
                swalAlert('An error occurred. Please try again later.', 'error', 'btn btn-danger');
            }
        });
    });
    // Update Diet Data
    function updateDietsData() {
        $.ajax({
            url: "{{ route('get.diets') }}",
            type: 'GET',
            success: function(response) {
                if (response.success) {
                    var diets = response.data;
                    var $dietsContainer = $('.diets-container');
                    $dietsContainer.empty();
                    $.each(diets, function(index, diet) {
                        var checkboxHtml = `
                        <div class="col-lg-3 fv-row fv-plugins-icon-container mt-2">
                            <div class="d-flex align-items-center">
                                <label class="form-check form-check-custom form-check-inline me-2">
                                    <input class="form-check-input" name="diets[]" type="checkbox"
                                           value="${diet.uuid}">
                                    <span class="fw-semibold ps-2 fs-6">${diet.name}</span>
                                </label>
                            </div>
                        </div>
                    `;
                        $dietsContainer.append(checkboxHtml);
                    });
                } else {
                    swalAlert('Failed to fetch meal types. Please try again.', 'error', 'btn btn-danger');
                }
            },
            error: function(xhr) {
                swalAlert('Error fetching meal types. Please try again later.', 'error', 'btn btn-danger');
            }
        });
    }
</script>
<script>
    // open Meal Size Modal
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
    $('#addMealSizeForm').submit(function(e) {
        e.preventDefault();
        var formData = $(this).serialize();

        $.ajax({
            url: "{{ route('admin.settings.meal.size.add') }}",
            type: 'POST',
            data: formData,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}",
            },
            beforeSend: function() {
                showOverlay();
            },
            success: function(response) {
                hideOverlay();
                if (response.success) {
                    swalAlert(response.message, 'success', 'btn btn-success');
                    $('#addMealSizeForm')[0].reset();
                    $('#addMealSizeForm')
                        .find('input:not([type="button"]):not([type="submit"]), textarea, select')
                        .val('')
                        .trigger('change');
                    $('#add_meal_size').modal('hide');

                    // Append the new row to the table
                    appendMealSizeRow(response.mealSize);
                } else {
                    swalAlert('Failed to add Meal Size. Please try again.', 'error',
                        'btn btn-danger');
                }
            },
            error: function(xhr) {
                hideOverlay();
                var errorMessage = xhr.responseJSON?.message ||
                    'Something went wrong. Please try again later.';
                swalAlert(errorMessage, 'error', 'btn btn-danger');
            },
        });
    });
    // Function to append a new row to the meal size table dynamically
    function appendMealSizeRow() {
        $.ajax({
            url: "{{ route('get.meal.size') }}",
            type: 'GET',
            success: function(response) {
                if (response.success) {
                    var mealSizes = response.data;
                    var $table = $('#meal_size_table tbody');
                    $table.empty();
                    $.each(mealSizes, function(index, mealSize) {
                        const newRow = `
                        <tr>
                            <td class="align-middle">
                                <label class="fw-semibold fs-6">${mealSize.title}</label>
                                <input type="hidden" value="${mealSize.uuid}"
                                       name="meal[nutrition_facts_attributes][meal_size_id]"
                                       id="meal_nutrition_facts_attributes_${mealSize.uuid}_meal_size_id">
                            </td>
                            <td>
                                <input type="text"
                                       name="meal[nutrition_facts_attributes][calories]"
                                       class="form-control form-control-sm" placeholder="">
                            </td>
                            <td>
                                <input type="text"
                                       name="meal[nutrition_facts_attributes][fat]"
                                       class="form-control form-control-sm" placeholder="">
                            </td>
                            <td>
                                <input type="text"
                                       name="meal[nutrition_facts_attributes][carb]"
                                       class="form-control form-control-sm" placeholder="">
                            </td>
                            <td>
                                <input type="text"
                                       name="meal[nutrition_facts_attributes][fiber]"
                                       class="form-control form-control-sm" placeholder="">
                            </td>
                            <td>
                                <input type="text"
                                       name="meal[nutrition_facts_attributes][protein]"
                                       class="form-control form-control-sm" placeholder="">
                            </td>8
                            <td>
                                <input type="text"
                                       name="meal[nutrition_facts_attributes][sodium]"
                                       class="form-control form-control-sm" placeholder="">
                            </td>
                        </tr>
                    `;
                        $table.append(newRow);
                    });
                } else {
                    swalAlert('Failed to fetch meal sizes. Please try again.', 'error', 'btn btn-danger');
                }
            },
            error: function(xhr) {
                swalAlert('Error fetching meal sizes. Please try again later.', 'error', 'btn btn-danger');
            }
        });
    }
</script>
<script>
    $(document).ready(function() {
        let $fileInput = $('#product_documents');
        let $previewContainer = $('#preview');
        let fileQueue = []; // Queue to store files
        let isUploading = false; // Flag to track if an upload is in progress

        // Function to handle individual file upload
        function uploadFile(file, $previewItem) {
            return new Promise((resolve, reject) => {
                let formData = new FormData();
                formData.append('file', file);
                formData.append('_token', "{{ csrf_token() }}");
                formData.append('meal_id', "{{ $meal->uuid }}");
                formData.append('edit_meal', "1");


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
    // Edit Meals Ajax Request
    $('#EditmenuOrderMealForm').submit(function(e) {
        e.preventDefault();
        const mealUUID = $('#uuid').val();
        var formData = new FormData(this);
        $.ajax({
            url: "{{ route('admin.meals.edit', ':uuid') }}".replace(':uuid', mealUUID),
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
                    const updatedMeal = response.meal;
                    // Locate the card for the updated meal
                    const mealCard = $(`.added-meal[data-uuid="${updatedMeal.uuid}"]`);
                    if (mealCard.length) {
                        // Update the card content
                        const imageUrl =
                        `${imageBasePath}/${updatedMeal.uuid}/${updatedMeal.image}`;
                        mealCard.find('img').attr('src', imageUrl);
                        mealCard.find('.meal_title').text(updatedMeal.title);
                        mealCard.find('.meal_description').text(updatedMeal.description);
                        mealCard.find('.price').text(`+ $${updatedMeal.price}`);
                    }
                    swalAlert('Meal updated successfully.', 'success', 'btn btn-success');
                    $('#edit_meal_form').modal('hide');
                    $('#mealsTable').DataTable().ajax.reload();
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
