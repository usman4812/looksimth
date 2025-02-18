@extends('admin.main')
@section('content')
    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_toolbar" class="app-toolbar  d-flex flex-stack py-4 py-lg-8 ">
            <div class="d-flex flex-grow-1 flex-stack flex-wrap gap-2 mb-n10" id="kt_toolbar">
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3 ">

                    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                        Edit Meal plan
                    </h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">

                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.plans') }}" class="text-muted text-hover-primary">Meal Plans</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-gray-900">Edit</li>
                    </ul>
                </div>
            </div>
        </div>
        <!--begin::Content-->
        <div id="kt_app_content" class="app-content  flex-column-fluid ">
            <form action="{{ route('admin.plans.edit', $uuid) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-header" style="background: #ddd;">
                        <h2 class="card-title">Plan Info</h2>
                    </div>
                    <div class="card-body">
                        <div class="row mb-6 align-items-center">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="title*" class="required col-form-label fw-semibold fs-6">Title</label>
                                    <input required type="text" name="title" class="form-control form-control-sm"
                                        value="{{ $plan->title }}" placeholder="Title">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="unit*" class="col-form-label fw-semibold fs-6">Unit</label>
                                    <input type="text" name="unit" class="form-control form-control-sm"
                                        value="{{ $plan->unit }}" placeholder="Unit">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="plan_type_id*" class="required col-form-label fw-semibold fs-6">Plan Type</label>
                                    <select id="plan_type_id" name="plan_type_id"
                                        data-placeholder="Select a Plan Type..."
                                        class="form-control form-control-sm">
                                        <option value="">Select Plan Type</option>
                                        @foreach ($plan_types as $plan_type)
                                            <option value="{{ $plan_type->uuid }}" {{ $plan_type->uuid == $plan->plan_type_id ? 'selected' :'' }}>{{ $plan_type->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-6">
                            <div class="form-group">
                                <label for="description*" class="col-form-label fw-semibold fs-6">Description</label>
                                <textarea name="description" class="form-control form-control-sm" rows="3">{{ $plan->description }}</textarea>
                            </div>
                        </div>
                        <div class="col-lg-4 mb-10">
                            <div class="d-flex align-items-center">
                                <label class="form-check form-check-custom form-check-inline  me-2">
                                    <input class="form-check-input" name="is_public" type="checkbox"
                                        value="1" data-gtm-form-interact-field-id="1" {{ $plan->is_public == 1 ? 'checked' : '' }}>
                                    <span class="fw-semibold ps-2 fs-6">Public</span>
                                </label>
                            </div>
                        </div>
                        @foreach ($plan->planVariants as $planVariant)
                            <div class="card mt-5">
                                <div class="card-header" style="background: #ddd;">
                                    <h2 class="card-title">Meal Plan Variations</h2>
                                </div>
                                <div class="card-body">
                                    <input type="hidden" name="plan_variants[{{ $loop->index }}][uuid]"
                                        value="{{ $planVariant->uuid }}" />
                                    <div class="row mb-6 align-items-center">
                                        <div class="col-lg-4">
                                            <div class="d-flex align-items-center">
                                                <label class="form-check form-check-custom form-check-inline  me-2">
                                                    <input class="form-check-input"
                                                        name="plan_variants[{{ $loop->index }}][is_public]" type="checkbox"
                                                        value="1" {{ $planVariant->is_public == 1 ? 'checked' : '' }}
                                                        data-gtm-form-interact-field-id="1">
                                                    <span class="fw-semibold ps-2 fs-6">Visible</span><i
                                                        class="bi bi-info-circle"
                                                        title="(must be checked for this meal plan variation to appear on sign up)"
                                                        data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                        data-bs-dismiss="click" data-bs-placement="top"></i>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-6 align-items-center">
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="quantity*"
                                                    class="required col-form-label fw-semibold fs-6">Quantity</label>
                                                <div class="d-flex align-items-center">
                                                    <input required type="text"
                                                        name="plan_variants[{{ $loop->index }}][quantity]"
                                                        class="form-control form-control-sm"
                                                        value="{{ $planVariant->quantity }}" placeholder="">
                                                    <span class="fw-semibold fs-6 ms-3" style="white-space: nowrap;">meals
                                                        per
                                                        week</span>
                                                </div>
                                                <div class="d-flex align-items-center mt-3">
                                                    <label
                                                        class="form-check form-check-custom form-check-inline  me-5 is-valid">
                                                        <input class="form-check-input"
                                                            name="plan_variants[{{ $loop->index }}][quantity_min]"
                                                            type="checkbox" value="1"
                                                            {{ $planVariant->quantity_min == 1 ? 'checked' : '' }}
                                                            data-gtm-form-interact-field-id="1">
                                                        <span class="fw-semibold ps-2 fs-6">
                                                            Minimum</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 mb-9">
                                            <div class="form-group">
                                                <label for="password*"
                                                    class="required col-form-label fw-semibold fs-6">Meal
                                                    Size</label>
                                                <select id="meal_size_id"
                                                    name="plan_variants[{{ $loop->index }}][meal_size_id]"
                                                    data-placeholder="Select a Meal Size..."
                                                    class="form-control form-control-sm">
                                                    <option value="">Select Meal Size</option>
                                                    @foreach ($mealSizes as $mealSize)
                                                        <option value="{{ $mealSize->uuid }}"
                                                            {{ $planVariant->meal_size_id == $mealSize->uuid ? 'selected' : '' }}>
                                                            {{ $mealSize->title }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 mb-9">
                                            <div class="form-group">
                                                <label for="password*"
                                                    class="required col-form-label fw-semibold fs-6">Price
                                                    Per Week</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">$</span>
                                                    <input type="integer" class="form-control form-control-sm"
                                                        name="plan_variants[{{ $loop->index }}][price_per_week]"
                                                        value="{{ $planVariant->price_per_week }}"
                                                        aria-label="Amount (to the nearest dollar)" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="password*"
                                                    class="required col-form-label fw-semibold fs-6">Price
                                                    Per Unit</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">$</span>
                                                    <input type="integer" class="form-control form-control-sm"
                                                        name="plan_variants[{{ $loop->index }}][price_per_unit]"
                                                        value="{{ $planVariant->price_per_unit }}"
                                                        aria-label="Amount (to the nearest dollar)" />
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center mt-3">
                                                <label
                                                    class="form-check form-check-custom form-check-inline  me-5 is-valid">
                                                    <input class="form-check-input"
                                                        name="plan_variants[{{ $loop->index }}][price_per_unit_starting_at]"
                                                        type="checkbox" value="1"
                                                        {{ $planVariant->price_per_unit_starting_at == 1 ? 'checked' : '' }}
                                                        data-gtm-form-interact-field-id="1">
                                                    <span class="fw-semibold ps-2 fs-6">Starting at</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-6 align-items-center">
                                        <h5 class="">Meals included</h5>
                                        <div class="row">
                                            <div class="col-lg-2">
                                                <label class="fw-semibold fs-6">Any:</label>
                                                <input type="number" class="form-control form-control-sm"
                                                    name="plan_variants[{{ $loop->index }}][num_meals_any]"
                                                    value="{{ $planVariant->num_meals_any }}" placeholder="Any" />
                                            </div>
                                            <div class="col-lg-2">
                                                <label class="fw-semibold fs-6">Breakfast:</label>
                                                <input type="number" class="form-control form-control-sm"
                                                    name="plan_variants[{{ $loop->index }}][num_meals_breakfast]"
                                                    value="{{ $planVariant->num_meals_breakfast }}"
                                                    placeholder="Breakfast" />
                                            </div>
                                            <div class="col-lg-2">
                                                <label class=" fw-semibold fs-6">Lunch:</label>
                                                <input type="number" class="form-control form-control-sm"
                                                    name="plan_variants[{{ $loop->index }}][num_meals_lunch]"
                                                    value="{{ $planVariant->num_meals_lunch }}" placeholder="Lunch" />
                                            </div>
                                            <div class="col-lg-2">
                                                <label class="fw-semibold fs-6">Dinner:</label>
                                                <input type="number" class="form-control form-control-sm"
                                                    name="plan_variants[{{ $loop->index }}][num_meals_dinner]"
                                                    value="{{ $planVariant->num_meals_dinner }}" placeholder="Dinner" />
                                            </div>
                                            <div class="col-lg-2">
                                                <label class="fw-semibold fs-6">Lunch/Dinner:</label>
                                                <input type="number" class="form-control form-control-sm"
                                                    name="plan_variants[{{ $loop->index }}][num_meals_lunch_dinner]"
                                                    value="{{ $planVariant->num_meals_lunch_dinner }}"
                                                    placeholder="Lunch/Dinner" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-6 align-items-center">
                                        <div class="col-lg-8">
                                            <span class="mt-5">Auto-select configuration</span><i
                                                class="bi bi-info-circle ms-2"
                                                title="Leave blank to split meals evenly for the week."
                                                data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click"
                                                data-bs-placement="top"></i>
                                            <div class="table">
                                                <table class="table" id="meal_size_table">
                                                    <tr class="fw-bold bg-light">
                                                        <th class="ps-4 min-w-150px rounded-start"></th>
                                                        <th>Any</th>
                                                        <th>Breakfast</th>
                                                        <th>Lunch/Dinner</th>
                                                    </tr>
                                                    <?php $mealDay = explode(',', $mealDays[0]); ?>
                                                    @foreach ($mealDay as $key => $day)
                                                        <tr>
                                                            <td class="align-middle">
                                                                <label
                                                                    class="fw-semibold fs-6">{{ ucfirst($day) }}</label>
                                                            </td>
                                                            <td>
                                                                <input type="text"
                                                                    name="plan_variants[{{ $loop->parent->index }}][mealDay][auto_any_{{ $key }}]"
                                                                    value="{{ $planVariant->{'auto_any_' . $key} }}"
                                                                    id="auto_any_{{ $key }}"
                                                                    class="form-control form-control-sm" placeholder="">
                                                            </td>
                                                            <td>
                                                                <input type="text"
                                                                    name="plan_variants[{{ $loop->parent->index }}][mealDay][auto_breakfast_{{ $key }}]"
                                                                    value="{{ $planVariant->{'auto_breakfast_' . $key} }}"
                                                                    id="auto_breakfast_{{ $key }}"
                                                                    class="form-control form-control-sm" placeholder="">
                                                            </td>
                                                            <td>
                                                                <input type="text"
                                                                    name="plan_variants[{{ $loop->parent->index }}][mealDay][auto_lunch_dinner_{{ $key }}]"
                                                                    value="{{ $planVariant->{'auto_lunch_dinner_' . $key} }}"
                                                                    id="auto_lunch_dinner_{{ $key }}"
                                                                    class="form-control form-control-sm" placeholder="">
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </table>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="prefer_meal_type_id"
                                                    class="col-form-label fw-semibold fs-6">Prefer</label>
                                                <select id="meal_type_dropdown"
                                                    name="plan_variants[{{ $loop->index }}][prefer_meal_type_id]"
                                                    aria-label="Select a Meal type"
                                                    data-placeholder="Select a Meal type..."
                                                    class="form-control form-control-sm">
                                                    <option value="">Select a Meal type...</option>
                                                    @foreach ($mealTypes as $mealType)
                                                        <option
                                                            {{ $planVariant->prefer_meal_type_id == $mealType->uuid ? 'selected=""' : '' }}
                                                            value="{{ $mealType->uuid }}">{{ $mealType->title }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-6">
                                        <div class="form-group">
                                            <label for="description" class="col-form-label fw-semibold fs-6">Additional
                                                description</label><i class="bi bi-info-circle ms-2"
                                                title="Text to include on bulk plan sign up plans and account plan settings pages."
                                                data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click"
                                                data-bs-placement="top"></i>
                                            <textarea name="plan_variants[{{ $loop->index }}][description]" class="form-control form-control-sm"
                                                placeholder="Description" rows="3">{{ $planVariant->description }}</textarea>
                                        </div>
                                    </div>
                                    <div class="card-body d-flex justify-content-end">
                                        <button class="btn btn-sm btn-danger removeCardBtn">Delete</button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div id="cardContainer">
                        </div>
                        <div class="mt-5 fw-semibold fs-6">
                            <button id="addCardBtn" class="btn btn-sm btn-success">Add plan variant</button>
                        </div>
                        <div class="d-flex justify-content-end py-6 px-9">
                            <button type="submit" class="btn btn-sm btn-primary">Update</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @push('script')
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script>
            $(document).ready(function() {
                var cardIndex = 0;
                $('#addCardBtn').click(function(event) {
                    event.preventDefault();
                    cardIndex++;
                    var newCard = `
                    <div class="card mt-5">
                        <div class="card-header" style="background: #ddd;">
                            <h2 class="card-title">Meal Plan Variations</h2>
                        </div>
                        <div class="card-body">
                            <div class="row mb-6 align-items-center">
                                <div class="col-lg-4">
                                    <div class="d-flex align-items-center">
                                        <label class="form-check form-check-custom form-check-inline me-2">
                                            <input class="form-check-input" name="plan_variants[${cardIndex}][is_public]" type="checkbox"
                                                value="1" data-gtm-form-interact-field-id="1">
                                            <span class="fw-semibold ps-2 fs-6">
                                                Visible
                                            </span><i class="bi bi-info-circle"
                                                title="(must be checked for this meal plan variation to appear on sign up)"
                                                data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click"
                                                data-bs-placement="top"></i>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-6 align-items-center">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="quantity*" class="required col-form-label fw-semibold fs-6">Quantity</label>
                                        <div class="d-flex align-items-center">
                                            <input required type="text" name="plan_variants[${cardIndex}][quantity]"
                                                class="form-control form-control-sm" placeholder="">
                                            <span class="fw-semibold fs-6 ms-3" style="white-space: nowrap;">meals per
                                                week</span>
                                        </div>
                                        <div class="d-flex align-items-center mt-3">
                                            <label class="form-check form-check-custom form-check-inline me-5 is-valid">
                                                <input class="form-check-input" name="plan_variants[${cardIndex}][quantity_min]" type="checkbox"
                                                    value="1" data-gtm-form-interact-field-id="1">
                                                <span class="fw-semibold ps-2 fs-6">
                                                    Minimum</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 mb-9">
                                    <div class="form-group">
                                        <label for="meal_size_id" class="required col-form-label fw-semibold fs-6">Meal Size</label>
                                        <select id="meal_size_id_${cardIndex}" name="plan_variants[${cardIndex}][meal_size_id]"
                                            data-placeholder="Select a Meal Size..." class="form-control form-control-sm">
                                            <option value="">Select Meal Size</option>
                                            @foreach ($mealSizes as $mealSize)
                                                <option value="{{ $mealSize->uuid }}">{{ $mealSize->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 mb-9">
                                    <div class="form-group">
                                        <label for="price_per_week" class="required col-form-label fw-semibold fs-6">Price Per Week</label>
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input type="integer" class="form-control form-control-sm"
                                                name="plan_variants[${cardIndex}][price_per_week]" aria-label="Amount (to the nearest dollar)" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="price_per_unit" class="required col-form-label fw-semibold fs-6">Price Per Unit</label>
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input type="integer" class="form-control form-control-sm"
                                                name="plan_variants[${cardIndex}][price_per_unit]" aria-label="Amount (to the nearest dollar)" />
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center mt-3">
                                        <label class="form-check form-check-custom form-check-inline me-5 is-valid">
                                            <input class="form-check-input" name="plan_variants[${cardIndex}][price_per_unit_starting_at]"
                                                type="checkbox" value="1" data-gtm-form-interact-field-id="1">
                                            <span class="fw-semibold ps-2 fs-6">Starting at</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <!-- Remaining content, updating all input name attributes with ${cardIndex} -->
                            <div class="row mb-6 align-items-center">
                                <h5 class="">Meals included</h5>
                                <div class="row">
                                    <div class="col-lg-2">
                                        <label class="fw-semibold fs-6">Any:</label>
                                        <input type="number" class="form-control form-control-sm"
                                            name="plan_variants[${cardIndex}][num_meals_any]" placeholder="Any" />
                                    </div>
                                    <div class="col-lg-2">
                                        <label class="fw-semibold fs-6">Breakfast:</label>
                                        <input type="number" class="form-control form-control-sm"
                                            name="plan_variants[${cardIndex}][num_meals_breakfast]" placeholder="Breakfast" />
                                    </div>
                                    <div class="col-lg-2">
                                        <label class="fw-semibold fs-6">Lunch:</label>
                                        <input type="number" class="form-control form-control-sm"
                                            name="plan_variants[${cardIndex}][num_meals_lunch]" placeholder="Lunch" />
                                    </div>
                                    <div class="col-lg-2">
                                        <label class="fw-semibold fs-6">Dinner:</label>
                                        <input type="number" class="form-control form-control-sm"
                                            name="plan_variants[${cardIndex}][num_meals_dinner]" placeholder="Dinner" />
                                    </div>
                                    <div class="col-lg-2">
                                        <label class="fw-semibold fs-6">Lunch/Dinner:</label>
                                        <input type="number" class="form-control form-control-sm"
                                            name="plan_variants[${cardIndex}][num_meals_lunch_dinner]" placeholder="Lunch/Dinner" />
                                    </div>
                                </div>
                            </div>
                             <div class="row mb-6 align-items-center">
                                    <div class="col-lg-8">
                                        <span class="mt-5">Auto-select configuration</span><i
                                            class="bi bi-info-circle ms-2"
                                            title="Leave blank to split meals evenly for the week."
                                            data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click"
                                            data-bs-placement="top"></i>
                                        <div class="table">
                                            <table class="table" id="meal_size_table">
                                                <tr class="fw-bold bg-light">
                                                    <th class="ps-4 min-w-150px rounded-start"></th>
                                                    <th>Any</th>
                                                    <th>Breakfast</th>
                                                    <th>Lunch/Dinner</th>
                                                </tr>
                                                <?php $mealDay = explode(',', $mealDays[0]); ?>
                                                @foreach ($mealDay as $key => $day)
                                                    <tr>
                                                        <td class="align-middle">
                                                            <label class="fw-semibold fs-6">{{ ucfirst($day) }}</label>
                                                        </td>
                                                        <td>
                                                            <input type="text"
                                                                name="plan_variants[${cardIndex}][mealDay][auto_any_{{ $key }}]"
                                                                id="auto_any_0_{{ $key }}"
                                                                class="form-control form-control-sm" placeholder="">
                                                        </td>
                                                        <td>
                                                            <input type="text"
                                                                name="plan_variants[${cardIndex}][mealDay][auto_breakfast_{{ $key }}]"
                                                                id="auto_breakfast_0_{{ $key }}"
                                                                class="form-control form-control-sm" placeholder="">
                                                        </td>
                                                        <td>
                                                            <input type="text"
                                                                name="plan_variants[${cardIndex}][mealDay][auto_lunch_dinner_{{ $key }}]"
                                                                id="auto_lunch_dinner_0_{{ $key }}"
                                                                class="form-control form-control-sm" placeholder="">
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="prefer_meal_type_id"
                                                class="col-form-label fw-semibold fs-6">Prefer</label>
                                            <select id="meal_type_dropdown" name="plan_variants[${cardIndex}][prefer_meal_type_id]"
                                                aria-label="Select a Meal type" data-placeholder="Select a Meal type..."
                                                class="form-control form-control-sm">
                                                <option value="">Select a Meal type...</option>
                                                @foreach ($mealTypes as $mealType)
                                                    <option
                                                        {{ @$formData['prefer_meal_type_id'] == $mealType->uuid ? 'selected=""' : '' }}
                                                        value="{{ $mealType->uuid }}">{{ $mealType->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            <!-- Additional configurations -->
                            <div class="row mb-6">
                                <div class="form-group">
                                    <label for="description_${cardIndex}" class="col-form-label fw-semibold fs-6">Additional description</label>
                                    <textarea name="plan_variants[${cardIndex}][description]" class="form-control form-control-sm" placeholder="Description" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="card-body d-flex justify-content-end">
                                <button class="btn btn-sm btn-danger removeCardBtn">Delete</button>
                            </div>
                        </div>
                    </div>
                    `;
                    $('#cardContainer').append(newCard);
                });
                $('#cardContainer').on('click', '.removeCardBtn', function(event) {
                    event.preventDefault();
                    $(this).closest('.card').remove();
                });
            });
        </script>
    @endpush
@endsection
