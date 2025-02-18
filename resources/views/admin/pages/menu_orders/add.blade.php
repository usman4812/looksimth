@extends('admin.main')
@push('style')
    <style>
        .meal {
            background-color: #f8f8f8;
            padding: 4px;
            margin: 2px 0 0 0;
        }

        .meal {
            /* margin: 0 0 15px 0; */
            display: flex;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            font-size: 14px;
            line-height: 1.428571429;
            color: #333333;
            background-color: #fff;
        }

        .meal .controls {
            margin-right: 15px;
        }

        .meal .controls {
            flex: 0 1 55px;
        }

        * {
            box-sizing: border-box;
        }

        * {
            box-sizing: border-box;
        }

        .meal .details {
            flex: 0 1 400px;
            align-self: start;
            margin-left: 10px;
        }

        * {
            box-sizing: border-box;
        }

        .meal .details .meal_title {
            margin: 0 0 2px 0;
            font-size: 14px;
            line-height: 1.2em;
        }

        * {
            box-sizing: border-box;
        }

        .meal .details .meal_description {
            margin: 0;
            font-size: 14px;
            line-height: 1.2em;
            font-style: italic;
            color: #666;
        }

        .meal .details .nutrition_facts {
            margin-top: 4px;
            margin-bottom: 4px;
            font-size: 12px;
            line-height: 1.2em;
            color: #999;
        }

        .scaffold .meals .nutrition_facts {
            color: #666;
        }

        div.meal_labels span.fam {
            background: #8cb1cc;
            color: #fff;
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

        div.meal_labels span.gf {
            background: #b8a392;
            color: #fff;
        }

        div.meal_labels span.df {
            background: #9292b8;
            color: #fff;
        }

        div.meal_labels span.v {
            background: #92b8a2;
            color: #fff;
        }

        div.meal_labels span.di {
            background: #b892b7;
            color: #fff;
        }

        div.meal_labels span.di {
            background: #b892b7;
            color: #fff;
        }

        div.meal_labels span.ls {
            background: #92adb8;
            color: #fff;
        }

        div.meal_labels span.lc {
            background: #c89762;
            color: #fff;
        }

        div.meal_labels span.ms {
            background: #a0aecc;
            color: #fff;
        }

        #mealResults {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .selectedMeal {
            display: flex;
            padding: 2px;
            border-radius: 8px;
            gap: 2px;
        }

        .sider-width-adjust {
            width: 700px;
        }

        @media (max-width: 1400px) {
            .sider-width-adjust {
                width: 500px;
            }
        }

        /* Three cards show on sider */
        #meals-container {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            /* Three cards per row */
            gap: 10px;
            /* Reduces the gap between cards */
        }

        @media (max-width: 992px) {
            #meals-container {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 576px) {
            #meals-container {
                grid-template-columns: 1fr;
            }
        }

        .unique-container__card {
            margin: 0;
            padding: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            cursor: pointer;
            display: flex;
            justify-content: start;
            align-items: start;
            flex-direction: column;
        }

        /* Card  add button style*/
        .add-meal-card {
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 200px;
        }

        .meal-text {
            margin-top: 10px;
        }

        .meal-added {
            border: 2px solid green;
            pointer-events: none;
            /* Prevent clicking again */
            opacity: 0.7;
            /* Visually differentiate added meals */
        }
    </style>
@endpush
@section('content')
    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_toolbar" class="app-toolbar  d-flex flex-stack py-4 py-lg-8 ">
            <div class="d-flex flex-grow-1 flex-stack flex-wrap gap-2 mb-n10" id="kt_toolbar">
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3 ">

                    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                        Add Menu Orders
                    </h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">

                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.menus') }}" class="text-muted text-hover-primary">Menu + Orders</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-gray-900">Add</li>
                    </ul>
                </div>
            </div>
        </div>
        <div id="kt_app_content" class="app-content mt-6 flex-column-fluid ">

            <form id="menuForm" action="{{ route('admin.menus.add') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="card w-100 h-100 col-lg-12">
                        <div class="card-header rest-padding" style="background: #ddd;">
                            <h2 class="card-title fs-3">General Info</h2>
                            <i title="General Information" class="fa-solid fa-circle-info"></i>
                        </div><!--begin::Card body-->
                        <div class="card-body">
                            <!--begin::Input group-->
                            <div class="row align-items-center">
                                <!-- First Column -->
                                <div class="col-lg-3 col-md-4 col-sm-12 mt-0">
                                    <div class="form-group">
                                        <label for="title" class="required col-form-label fw-semibold fs-lg-5 fs-md-6 fs-sm-6">Title</label>
                                        <input required type="text" name="title" class="form-control form-control-sm"
                                            placeholder="">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4 col-sm-12 mt-0">
                                    <div class="form-group">
                                        <label for="delivery_date" class="required col-form-label fw-semibold fs-lg-5 fs-md-6 fs-sm-6">Delivery
                                            Date</label>
                                        <input required type="date" name="delivery_date"
                                            class="form-control form-control-sm" placeholder=""
                                            min="{{ \Carbon\Carbon::now()->toDateString() }}">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4 col-sm-12 mt-1">
                                    <div class="form-group">
                                        <label for="custom_delivery_date *" class="col-form-label fw-semibold fs-lg-5 fs-md-6 fs-sm-6">Custom
                                            Delivery Date</label>
                                        <input type="date" name="custom_delivery_date"
                                            class="form-control form-control-sm" placeholder=""
                                            min="{{ \Carbon\Carbon::now()->toDateString() }}">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4 col-sm-12 mt-1">
                                    <div class="form-group">
                                        <label for="custom_delivery_hours *" class="col-form-label fw-semibold fs-lg-5 fs-md-6 fs-sm-6">Custom
                                            delivery hours (e.g. 12pm - 5pm)</label>
                                        <input type="text" name="custom_delivery_hours"
                                            class="form-control form-control-sm" placeholder="">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4 col-sm-12 mt-1">
                                    <div class="form-group">
                                        <label for="custom_pickup_hours *" class="col-form-label fw-semibold fs-lg-5 fs-md-6 fs-sm-6">Custom
                                            pickup hours (e.g. 8am - 2pm)</label>
                                        <input type="text" name="custom_pickup_hours"
                                            class="form-control form-control-sm" placeholder="">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4 col-sm-12 mt-1">
                                    <div class="form-group">
                                        <div class="d-flex justify-content-between align-items-center w-100"><label
                                                for="deadline_date *" class="col-form-label fw-semibold fs-lg-5 fs-md-6 fs-sm-6">Custom order
                                                deadline date</label>
                                            <p class="text-gray-700 mt-4 fs-lg-5 fs-md-6 fs-sm-6"> at 12pm</p>
                                        </div>

                                        <div class="input-group d-flex align-items-center">
                                            <input type="date" name="deadline_date"
                                                class="form-control form-control-sm" placeholder=""
                                                min="{{ \Carbon\Carbon::now()->toDateString() }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12 col-sm-12 mt-0">
                                    <div class="row" style="justify-content: start;">
                                        <div class="col-lg-4 col-md-4 col-sm-6 fv-row fv-plugins-icon-container">
                                            <label class="col-lg-4 col-form-label  fw-semibold fs-6">&nbsp;</label>
                                            <div class="d-flex align-items-center">
                                                <label class="form-check form-check-custom form-check-inline me-2">
                                                    <input class="form-check-input" name="is_active" type="checkbox"
                                                        value="1" data-gtm-form-interact-field-id="1">
                                                    <span class="fw-semibold ps-2 fs-5">
                                                        Active
                                                    </span><i class="bi bi-info-circle" title="Enable orders on backend"
                                                        data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                        data-bs-dismiss="click" data-bs-placement="top"></i>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-6 fv-row fv-plugins-icon-container">
                                            <label class="col-lg-4 col-form-label fw-semibold fs-6">&nbsp;</label>
                                            <div class="d-flex align-items-center">
                                                <label class="form-check form-check-custom form-check-inline me-2">
                                                    <input class="form-check-input" name="is_public" type="checkbox"
                                                        value="1" data-gtm-form-interact-field-id="1">
                                                    <span class="fw-semibold ps-2 fs-5">
                                                        Public
                                                    </span><i class="bi bi-info-circle"
                                                        title="Enable customer orders, sign up,
                                                        and auto-select"
                                                        data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                        data-bs-dismiss="click" data-bs-placement="top"></i>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 mt-1">
                                    <div class="form-group">
                                        <label for="note *" class="col-form-label fw-semibold fs-lg-5 fs-md-6 fs-sm-6">Add Note</label>
                                        <textarea type="text" name="note" class="form-control form-control-sm" placeholder=""></textarea>
                                    </div>
                                    <div class="fs-6 text-primary pe-7">[DELIVERY_OPTION] will be auto-replaced by the
                                        user's chosen delivery option</div>
                                </div>

                            </div>
                            {{-- <div class="row mb-6 align-items-start">
                                <div class="col-lg-3 mt-1">
                                    <div class="form-group">
                                        <label for="custom_delivery_date *" class="col-form-label fw-semibold fs-5">Custom
                                            Delivery Date</label>
                                        <input type="date" name="custom_delivery_date"
                                            class="form-control form-control-sm" placeholder=""
                                            min="{{ \Carbon\Carbon::now()->toDateString() }}">
                                    </div>
                                </div>
                                <div class="col-lg-3 mt-1">
                                    <div class="form-group">
                                        <label for="custom_delivery_hours *" class="col-form-label fw-semibold fs-5">Custom
                                            delivery hours (e.g. 12pm - 5pm)</label>
                                        <input type="text" name="custom_delivery_hours"
                                            class="form-control form-control-sm" placeholder="">
                                    </div>
                                </div>
                                <div class="col-lg-3 mt-1">
                                    <div class="form-group">
                                        <label for="custom_pickup_hours *" class="col-form-label fw-semibold fs-5">Custom
                                            pickup hours (e.g. 8am - 2pm)</label>
                                        <input type="text" name="custom_pickup_hours"
                                            class="form-control form-control-sm" placeholder="">
                                    </div>
                                </div>
                                <div class="col-lg-3 mt-1">
                                    <div class="form-group">
                                        <div class="d-flex justify-content-between align-items-center w-100"><label
                                                for="deadline_date *" class="col-form-label fw-semibold fs-5">Custom order
                                                deadline date</label>
                                            <p class="text-gray-700 mt-4 fs-5"> at 12pm</p>
                                        </div>

                                        <div class="input-group d-flex align-items-center">
                                            <input type="date" name="deadline_date"
                                                class="form-control form-control-sm" placeholder=""
                                                min="{{ \Carbon\Carbon::now()->toDateString() }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 mt-1">
                                    <div class="form-group">
                                        <label for="note *" class="col-form-label fw-semibold fs-6">Add Note</label>
                                        <textarea type="text" name="note" class="form-control form-control-sm" placeholder=""></textarea>
                                    </div>
                                    <div class="fs-6 text-primary pe-7">[DELIVERY_OPTION] will be auto-replaced by the
                                        user's chosen delivery option</div>
                                </div>
                            </div> --}}
                            {{-- <div class="row align-items-center">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="deadline_date *" class="col-form-label fw-semibold fs-6">Custom order
                                            deadline date</label>
                                        <div class="input-group  d-flex align-items-center">
                                            <input type="date" name="deadline_date"
                                                class="form-control form-control-sm" placeholder=""
                                                min="{{ \Carbon\Carbon::now()->toDateString() }}">
                                            <p class="text-gray-700 me-3 ms-2 mt-3"> at 12pm</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="note *" class="col-form-label fw-semibold fs-6">Add Note</label>
                                        <textarea type="text" name="note" class="form-control form-control-sm" placeholder=""></textarea>
                                        <div class="fs-6 text-gray-700 pe-7">[DELIVERY_OPTION] will be auto-replaced by the
                                            user's chosen delivery option</div>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                        <!--end::Card body-->
                    </div>
                    <div class="d-flex justify-content-start py-5 pe-9 gap-2">
                        <button id="kt_app_layout_builder_toggle"
                            class="btn btn-sm primary-latest-container me-2 d-flex align-items-center justify-content-center"
                            data-bs-custom-class="tooltip-inverse" data-bs-toggle="tooltip" data-bs-placement="left"
                            data-bs-dismiss="click" data-bs-trigger="hover" data-bs-original-title="Metronic Builder"
                            data-kt-initialized="1"><i class="fa-solid fa-plus"></i>  Add Meals
                        </button>
                        <button type="button" id="openMealFormModal"
                            class="btn btn-sm light-latest-container ms-3 d-flex justify-content-center align-items-center"><i
                                class="fa-solid fa-plus"></i>New
                            Meal</button>
                    </div>
                    <div id="mealResults" class="selectedMeal">

                    </div>
                    <!--begin:: CMenu Items card-->
                    <div class="menu-items-container">
                        @foreach ($mealTypes as $mealType)
                            <div class="card w-100 h-100 col-lg-12 mt-5 mb-5">
                                <div class="card-header rest-padding" style="background: #ddd;">
                                    <h2 class="card-title fs-3">{{ $mealType->title }}</h2>
                                </div><!--begin::Card body-->
                                <div class="card-body d-flex justify-content-start flex-wrap {{ $mealType->uuid }}">
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="d-flex justify-content-end py-3 px-5">
                    <button type="submit"
                        class="btn btn-sm primary-latest-container d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-plus"></i>Create</button>
                </div>
                <input type="hidden" name="selected_meals" id="selectedMealsInput">
            </form>
        </div>
    </div>
    <!--Sider-->
    <div id="kt_app_layout_builder" class="bg-body drawer drawer-end drawer-on" data-kt-drawer="true"
        data-kt-drawer-activate="true" data-kt-drawer-overlay="true" data-kt-drawer-direction="end"
        data-kt-drawer-toggle="#kt_app_layout_builder_toggle" data-kt-drawer-close="#kt_app_layout_builder_close">
        <!--begin::Card-->
        <div class="card border-0 shadow-none rounded-0 sider-width-adjust" style="display:none;">
            <!--begin::Card header-->
            <div class="card-header bgi-position-y-bottom bgi-position-x-end bgi-size-cover bgi-no-repeat rounded-0 border-0 py-4"
                id="kt_app_layout_builder_header"
                style="background-image: url('https://preview.keenthemes.com/metronic8/demo30/assets/media/misc/layout/customizer-header-bg.jpg');">

                <!--begin::Card title-->
                <h3 class="card-title fs-3 fw-bold text-white flex-column m-0">
                    Meals Type
                </h3>
                <div class="card-toolbar">
                    <button type="button" class="btn btn-sm btn-icon btn-color-white p-0 w-20px h-20px rounded-1"
                        id="kt_app_layout_builder_close">
                        <i class="ki-outline ki-cross-square fs-2"></i> </button>
                </div>
            </div>
            <div class="card-body position-relative" id="kt_app_layout_builder_body">
                <div id="kt_app_settings_content" class="position-relative scroll-y me-n5 pe-5" data-kt-scroll="true"
                    data-kt-scroll-height="auto" data-kt-scroll-wrappers="#kt_app_layout_builder_body"
                    data-kt-scroll-dependencies="#kt_app_layout_builder_header, #kt_app_layout_builder_footer"
                    data-kt-scroll-offset="5px" style="/* height: 211px; */">
                    <div class="card-body pt-2">
                        <ul class="nav nav-pills nav-pills-custom mb-3 nav-pills-custom-scroll" role="tablist"
                            style="justify-content: center;border-bottom: 1px solid #ddd;display: flex;flex-wrap: nowrap;overflow: scroll;">
                            @foreach ($mealTypes as $index => $mealType)
                                <li class="nav-item mb-3 me-3 me-lg-6" role="presentation">
                                    <a class="nav-link d-flex justify-content-between flex-column flex-center overflow-hidden w-80px h-85px py-4 {{ $index === 0 ? 'active' : '' }}"
                                        data-bs-toggle="pill" href="" data-uuid="{{ $mealType->uuid }}"
                                        aria-selected="{{ $index === 0 ? 'true' : 'false' }}" role="tab">
                                        <div class="nav-icon">
                                            <img src="{{ asset('images/meal_types/' . $mealType->image) }}"
                                                alt="">
                                        </div>
                                        <span class="nav-text text-muted fs-8 lh-1">
                                            {{ Str::limit($mealType->title, 10) }}
                                        </span>
                                        <span
                                            class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                        <hr>
                        <div id="meals-container" class="row g-2" style="row-gap: 10px; column-gap: 10px;">
                        </div>
                    </div>
                    <!--end::Form-->
                </div>
                <!--end::Content-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->
    </div>
    <div id="mealModalContainer">

    </div>
@endsection
@push('script')
    <!-- Pass the base path for images -->
    <script>
        const imageBasePath = "{{ asset('storage/public/web_assets/media/meals') }}";
    </script>
    <script>
        var mealTypeUuid = $('#kt_app_layout_builder .nav-link:first').data('uuid');
        console.log();

        function getMealTypesAjax(mealTypeUuid) {
            $.ajax({
                url: "{{ route('get.meals.by.type') }}",
                type: 'GET',
                data: {
                    meal_type_id: mealTypeUuid
                },
                success: function(response) {
                    renderMealsToContainer(response, mealTypeUuid);
                },
                error: function(xhr) {
                    console.error('Error fetching meals:', xhr.responseText);
                    alert('An error occurred while fetching meals.');
                }
            });
        }
        $(document).ready(function() {
            var firstMealType = "mealTypeUuid";
            getMealTypesAjax(firstMealType);
            $(document).on('click', '.nav-link', function(e) {
                e.preventDefault();
                let mealTypeUuid = $(this).data('uuid');
                console.log("Selected Meal Type UUID:", mealTypeUuid);
                getMealTypesAjax(mealTypeUuid);
            });

        });
        // Render meals into #meals-container
        function renderMealsToContainer(meals, mealTypeUuid) {
            let container = $('#meals-container');
            container.empty();

            const addedMealUUIDs = new Set();
            $(`.card-body.${mealTypeUuid} .added-meal`).each(function() {
                addedMealUUIDs.add($(this).data('uuid'));
            });
            if (meals.length > 0) {
                meals.forEach(meal => {
                    const imageUrl = `${imageBasePath}/${meal.uuid}/${meal.image}`;
                    const isAdded = addedMealUUIDs.has(meal.uuid);
                    container.append(`
                    <div class="unique-container add_menu_item ${isAdded ? 'meal-added' : ''}"
                        data-uuid="${meal.uuid}"
                        data-json='${JSON.stringify(meal)}'>
                        <div class="unique-container__card ${isAdded ? 'border-success' : ''}">
                            <!-- Row: Image and Button -->
                            <div class="unique-container__card-display">
                                <div class="unique-container__card-header">
                                    <img src="${imageUrl}" class="unique-container__image">
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-start flex-column h-100">
                                <div class="d-flex justify-content-start align-items-start flex-column">
                                    <!-- Title Component -->
                                    <div class="unique-container__title">
                                        <h3>${meal.title}</h3>
                                    </div>
                                    <!-- Description Component -->
                                    <div class="unique-container__description">
                                        <p>${meal.description || "No description available."}</p>
                                    </div>
                                </div>
                                <!-- Price Component -->
                                <div class="unique-container__price">
                                    <span>Price: $${meal.price}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    `);
                });
            } else {
                container.append('<p>No meals available for this type.</p>');
            }
            // Append the "New Meal" button card at the end
            container.append(`
            <div class="unique-container">
                <div class="unique-container__card add-meal-card">
                    <a type="button" id="openMealFormModal" class="btn btn-sm btn-primary fw-bold" data-meal-type-uuid="${mealTypeUuid}">
                        <i class="ki-outline ki-plus fs-1"></i>
                    </a>
                    <div class="meal-text">New Meal</div>
                    <div class="meal-text">Click here to add new meal</div>
                </div>
            </div>
            `);
        }
    </script>
    <script>
        // open  meal type modal
        $(document).on('click', '#openMealFormModal', function() {
            let mealTypeUuid = $(this).data('meal-type-uuid')
            loadMealFormModal(mealTypeUuid);
        });

        function loadMealFormModal(mealTypeUuid) {
            $.ajax({
                url: "{{ route('get.meal.form.modal') }}",
                type: 'GET',
                data: {
                    meal_type_id: mealTypeUuid // send meal_type_id in the request
                },
                beforeSend: function() {
                    showOverlay();
                },
                success: function(response) {
                    hideOverlay();
                    if (response.success) {
                        $('#mealModalContainer').html(response.html);
                        var modal = new bootstrap.Modal(document.getElementById('add_meal_form'));
                        modal.show();
                        if (mealTypeUuid) {
                            $('#add_meal_form  select[name="meal_type_id"]').val(mealTypeUuid).trigger(
                                'change');
                            $('#add_meal_form select[name="meal_type_id"] option').each(function() {
                                if ($(this).val() !== mealTypeUuid && $(this).val() !== '') {
                                    $(this).prop('disabled', true); // Disable option
                                } else {
                                    $(this).prop('disabled', false); // Enable the selected option
                                }
                            });
                        }
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
        $(document).on('click', '.add_menu_item', function(e) {
            e.preventDefault();
            const meal = $(this).data('json');
            const mealTypeUUID = meal.meal_type_id;
            const targetCardBody = $(`.card-body.${mealTypeUUID}`);
            // Check if the meal is already added
            if (targetCardBody.find(`.added-meal[data-uuid="${meal.uuid}"]`).length > 0) {
                console.warn('Meal is already added:', meal.uuid);
                return; // Exit if the meal is already added
            }
            const imageUrl = `${imageBasePath}/${meal.uuid}/${meal.image}`;
            const mealHtml = `
            <div class="col-lg-4 col-md-6 col-sm-12 width-only-small">
           <div class="meal-order-card-section w-100">
                <div class="meal-order-main-outer-card-section">
                    <div class="meal m-0 added-meal" data-uuid="${meal.uuid}">
                        <div class="d-flex align-items-center justify-content-between w-100">
                            <div class="symbol symbol-100px me-5">
                                <span class="symbol-label bg-light">
                                    <img src="${imageUrl}" style="width:100%; height:100%;" alt=""/>
                                </span>
                            </div>
                            <div class="details ms-3 w-100">
                                <div class="meal-title-description">
                                    <div class="meal_title">${meal.title}</div>
                                    <div class="meal_description"><em>${meal.description}</em></div>
                                </div>
                                <div class="meal-order-inner-prise-buttons">
                                    <div class="controls d-flex gap-1">
                                        <div class="button-container">
                                            <button type="button" id="openEditMealFormModal" class="btn btn-sm btn-primary" data-uuid="${meal.uuid}">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </button>
                                            <div class="toggle-tooltip">Edit Meal</div>
                                        </div>
                                        <div class="button-container">
                                            <button class="btn  btn-sm btn-danger remove_menu_item">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                            <div class="toggle-tooltip">Remove Meal</div>
                                        </div>
                                    </div>

                                    <div class="price">+ $${meal.price}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        `;
            if (targetCardBody.length) {
                targetCardBody.append(mealHtml);
                $(this).addClass('meal-added').css('border', '2px solid green'); // Mark meal as added
            } else {
                console.error('No matching card-body found for meal_type_id:', mealTypeUUID);
            }
            $(this).closest('.meal').remove();
        });
        // Remove button click handler
        $(document).on('click', '.remove_menu_item', function(e) {
            e.preventDefault();
            // Remove the added meal from the card
            const mealElement = $(this).closest('.added-meal');
            const mealUUID = mealElement.data('uuid');
            // Remove the meal element from the card-body
            mealElement.remove();
            const mealInList = $(`.unique-container[data-uuid="${mealUUID}"]`);
            if (mealInList.length) {
                mealInList.removeClass('meal-added').css('border', '');
            }
        });
        // get meals from all cards
        $(document).ready(function() {
            $('#menuForm').on('submit', function(e) {
                const selectedMeals = [];
                $('.menu-items-container .card-body').each(function() {
                    const mealTypeUUID = $(this).attr('class').split(' ')
                        .pop(); // Extract mealType UUID
                    const meals = [];
                    $(this).find('.added-meal').each(function() {
                        const mealData = {
                            uuid: $(this).data('uuid'),
                            meal_type_id: mealTypeUUID
                        };
                        meals.push(mealData);
                    });
                    if (meals.length > 0) {
                        selectedMeals.push({
                            meal_type_id: mealTypeUUID,
                            meals: meals
                        });
                    }
                });
                $('#selectedMealsInput').val(JSON.stringify(selectedMeals));
            });
        });
        // hide and show siderbar
        $(document).ready(function() {
            $('#kt_app_layout_builder_toggle').on('click', function() {
                getMealTypesAjax(mealTypeUuid);
                $('.card.sider-width-adjust').show();
            });
            $('#kt_app_layout_builder_close').on('click', function() {
                $('.card.sider-width-adjust').hide();
            });
        });
    </script>
    <script>
        // Open Edit Meals Modal
        $(document).on('click', '#openEditMealFormModal', function() {
            const mealUUID = $(this).data('uuid');
            loadEditMealFormModal(mealUUID);
        });

        function loadEditMealFormModal(mealUUID) {
            $.ajax({
                url: "{{ route('get.edit.meal.form.modal') }}",
                type: 'GET',
                data: {
                    _token: "{{ csrf_token() }}", // CSRF token for security
                    meal_uuid: mealUUID, // Send meal UUID
                },
                beforeSend: function() {
                    showOverlay();
                },
                success: function(response) {
                    hideOverlay();
                    if (response.success) {
                        $('#mealModalContainer').html(response.html);
                        var modal = new bootstrap.Modal(document.getElementById('edit_meal_form'));
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
