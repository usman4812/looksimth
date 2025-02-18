@php
    $formData = old();
@endphp
@extends('admin.main')
@section('content')
    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_toolbar" class="app-toolbar  d-flex flex-stack py-4 py-lg-8 ">
            <div class="d-flex flex-grow-1 flex-stack flex-wrap gap-2 mb-n10" id="kt_toolbar">
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3 ">

                    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                        Customers Details
                    </h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">

                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.customers') }}" class="text-muted text-hover-primary">Customers</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-gray-900">Details</li>
                    </ul>
                </div>
            </div>
        </div>
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div class="container-fluid">
                <div class="d-flex flex-wrap">
                    <!-- Include Customer Sidebar -->
                    @include('admin.pages.customer.customer_view_sidebar', ['customer' => $customer])
                    <div class="col-lg-9 col-md-8 col-sm-12 p-2">
                        <div class="card w-100 h-100 col-lg-12">
                            <div class="card-header rest-padding colored-customer-detail" style="background: #a4d4a1;">
                                <h2 class="card-title">Dietary Preferences</h2>
                                <i title="Delivery Info" class="fa-solid fa-truck"></i>
                            </div>
                            <div class="card-body p-0">
                                {{-- <hr class="my-4"> --}}
                                <div class="d-flex flex-column flex-column-fluid">
                                    <form id="selectionForm"
                                        action="{{ route('admin.customers.preferences', $customer->uuid) }}" method="Post"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="card-body">
                                            <div class="dietary-text-section">
                                                <div class="fs-5 text-muted-1000 fw-semibold">Tell us what you want to eat.
                                                </div>
                                                <div class="fs-5 text-gray-600 fw-semibold">We'll make sure to send you
                                                    only meals that fit your unique dietary needs.</div>
                                                <div class="fs-5 text-muted-1000 fw-semibold">PLEASE ONLY CLICK THE ITEMS
                                                    THAT YOU DO WANT TO EAT.</div>
                                            </div>
                                            <div
                                                class="d-flex align-items-start justify-content-center gap-5 flex-wrap mt-5">
                                                @foreach ($Ingredients as $Ingredient)
                                                    <div class="dietary-preferences-card-section">
                                                        <label class="dietary-preferences-main-card btn"
                                                            data-kt-button="true">
                                                            @if ($Ingredient->icon)
                                                                <div class="dietary-preferences-inner-image">
                                                                    <img src="{{ asset('images/ingredients/' . $Ingredient->icon) }}"
                                                                        alt="" />
                                                                </div>
                                                            @else
                                                                <div class="dietary-preferences-inner-image">
                                                                    <span style="width: 100px; height: 100px;"></span>
                                                                </div>
                                                            @endif
                                                            <div class="dietary-preferences-main-card-info">
                                                                <h6 class="fw-bold text-success mb-1">
                                                                    {{ $Ingredient->name }}</h6>
                                                                <input type="checkbox" name="ingredient_uuids[]"
                                                                    value="{{ $Ingredient->uuid }}" class="custom-checkbox"
                                                                    {{ $customerIngredients->contains('ingredient_id', $Ingredient->uuid) ? 'checked' : '' }}>
                                                                <span class="custom-checkbox-indicator"></span>
                                                            </div>
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>

                                            <div class="dietary-text-input-section mt-5">
                                                <label class="custom-dietary-checkbox">
                                                    <div class="custom-dietary-checkbox-text-section">
                                                        <input type="checkbox" name="strict_meal_recommendations" value="1"
                                                        {{ $customer->strict_meal_recommendations == 1 ? 'checked' : '' }}>
                                                    <span class="dietary-checkbox-circle"></span>
                                                    <span class="fw-semibold ps-2 fs-6">
                                                        Strict Meal Recommendations
                                                    </span>
                                                    </div>
                                                    <div class="fs-6 text-gray-700 pe-7">
                                                        Only recommend meals that contain the ingredients selected above.
                                                        (For example, if you only selected beef we won’t recommend a meal with macaroni and cheese unless it contains beef too.)
                                                    </div>
                                                </label>
                                            </div>

                                            <div class="fs-5 text-muted-600 fw-semibold mt-5">Do you require meals that are
                                                any of the following?</div>
                                                <div class="row">
                                                    @foreach ($diets as $diet)
                                                        <div class="col-md-6 col-lg-6 col-xxl-6 mt-5">
                                                            <label class="btn main-requirement-box custom-card">
                                                                <div class="main-requirement-box-text-section">
                                                                    <input
                                                                        type="checkbox"
                                                                        name="diet_uuids[]"
                                                                        value="{{ $diet->uuid }}"
                                                                        {{ $customerDiets->contains('diet_id', $diet->uuid) ? 'checked' : '' }}
                                                                        class="custom-checkbox"
                                                                    >
                                                                    <div class="checkbox-circle">
                                                                        <span class="tick-icon"></span>
                                                                    </div>
                                                                    <p>{{ $diet->name }}</p>
                                                                </div>
                                                                <span>{{ $diet->description }}</span>
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>



                                            <div class="dietary-text-section mt-5">
                                                <div> Please note
                                                    our system will do its best to select meals based on your preferences;
                                                    however we still urge you to log in weekly and select your own meals to
                                                    customize your perfect menu.</div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-end py-6 px-9">
                                            <button type="submit" class="btn btn-sm btn-primary">Submit</button>
                                        </div>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        function toggleIcon(element) {
            const emptyCircle = element.querySelector('.empty-circle');
            const checkIcon = element.querySelector('.check-icon');

            // Toggle visibility
            if (checkIcon.style.display === 'none') {
                checkIcon.style.display = 'inline';
                emptyCircle.style.display = 'none';
            } else {
                checkIcon.style.display = 'none';
                emptyCircle.style.display = 'inline';
            }
        }
    </script>
    <script>
        function toggleSelection(labelElement, uuid, type) {
            const form = document.getElementById('selectionForm');
            const existingInput = form.querySelector(`input[name="${type}_uuids[]"][value="${uuid}"]`);
            const checkIcon = labelElement.querySelector('.check-icon');

            // If the UUID is not already selected, add it
            if (!existingInput) {
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = `${type}_uuids[]`; // Differentiating ingredient and diet UUIDs
                hiddenInput.value = uuid;
                form.appendChild(hiddenInput);

                // Show the check icon when selected
                checkIcon.style.display = 'inline';
            } else {
                // If the UUID is already selected, remove it
                form.removeChild(existingInput);

                // Hide the check icon when deselected
                checkIcon.style.display = 'none';
            }
        }
    </script>
@endpush
