@php
    $formData = old();
@endphp
@extends('admin.main')
@section('content')
    <div class="d-flex flex-column flex-column-fluid">
        <div id="meal-days-warning" class="alert alert-danger alert-dismissible mt-3 d-none" role="alert">
            <strong>Warning:</strong> System does not support more than 2 meal days a week, and will require
            improvements to the meal auto-selector. Contact developer.
            <button type="button" class="btn-close" aria-label="Close" onclick="dismissWarning()"></button>
        </div>
        <div id="kt_app_toolbar" class="app-toolbar  d-flex flex-stack py-4 py-lg-8 ">
            <div class="d-flex flex-grow-1 flex-stack flex-wrap gap-2 mb-n10" id="kt_toolbar">
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3 ">

                    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-3">
                        Settings
                    </h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">

                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-1px"></span>
                        <li class="breadcrumb-item text-gray-900">Settings</li>
                    </ul>
                </div>
            </div>
        </div>
        <!--begin::Content-->
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div class="container-fluid">

                <div class="row g-7">
                    <!-- Card 1 (3 columns) -->
                    @include('admin.pages.setting.sidebar')
                    <!-- Card 2 (9 columns) -->
                    <div class="col-lg-9 col-md-12 col-sm-12 setting-table-left-right-portion">
                        @can('edit settings')
                            <form action="{{ route('admin.settings') }}" method="POST" enctype="multipart/form-data">
                            @endcan
                            @csrf
                            <div class="d-flex flex-wrap">
                                <div class="col-lg-6 col-md-6 col-sm-12 p-2">
                                    <div class="card w-100 h-100 col-lg-12">
                                        <div class="card-header rest-padding" style="background: #ddd;">
                                            <h2 class="card-title">Meal Days & Order Deadline</h2>
                                            <i title="Meal Days & Order Deadline" class="fa-solid fa-timeline"></i>
                                        </div>
                                        <div class="card-body">
                                            <h3 class="d-flex  fs-5 fw-bold mb-3">Meal days</h3>
                                            <div class="d-flex flex-wrap">
                                                @php
                                                    $selectedMealDays =
                                                        isset($setting) && $setting->meal_days
                                                            ? (is_array($setting->meal_days)
                                                                ? $setting->meal_days
                                                                : explode(',', $setting->meal_days))
                                                            : [];
                                                @endphp
                                                @foreach (['tue' => 'Tue', 'wed' => 'Wed', 'thu' => 'Thu', 'fri' => 'Fri', 'sat' => 'Sat', 'sun' => 'Sun'] as $day => $label)
                                                    <label class="form-check d-flex align-items-center me-5">
                                                        <input class="form-check-input meal-day-checkbox" name="meal_days[]"
                                                            type="checkbox" value="{{ $day }}"
                                                            {{ in_array($day, $selectedMealDays) ? 'checked' : '' }} />
                                                        <span class="fw-semibold fs-6 ms-2">{{ $label }}</span>
                                                    </label>
                                                @endforeach
                                            </div>
                                            <div class="fs-6 text-gray-700 pe-7">Days that meals are delivered or picked up (ex:
                                                Tue and Fri).
                                            </div>
                                            <h3 class="fs-5 fw-bold mt-3">Auto-select</h3>
                                            <h3 class="fs-6 text-gray-700 pe-7">Fri 12pm</h3>
                                            <div class="fs-6 text-gray-700 pe-7">Day and time of the week that meals will be
                                                auto-selected</div>

                                            <h3 class="fs-5 fw-bold mt-3">Order deadline</h3>
                                            <div class="d-flex justify-content-between mt-2">
                                                <div class="d-flex align-items-center">
                                                    <select name="deadline_day" class="form-select form-select-sm">
                                                        <option value="mon" {{ isset($setting) && $setting->deadline_day == 'mon' ? 'selected' : '' }}>Mon</option>
                                                        <option value="tue" {{ isset($setting) && $setting->deadline_day == 'tue' ? 'selected' : '' }}>Tue</option>
                                                        <option value="wed" {{ isset($setting) && $setting->deadline_day == 'wed' ? 'selected' : '' }}>Wed</option>
                                                        <option value="thu" {{ isset($setting) && $setting->deadline_day == 'thu' ? 'selected' : '' }}>Thu</option>
                                                        <option value="fri" {{ isset($setting) && $setting->deadline_day == 'fri' ? 'selected' : '' }}>Fri</option>
                                                        <option value="sat" {{ isset($setting) && $setting->deadline_day == 'sat' ? 'selected' : '' }}>Sat</option>
                                                        <option value="sun" {{ isset($setting) && $setting->deadline_day == 'sun' ? 'selected' : '' }}>Sun</option>
                                                    </select>
                                                    <p class="text-gray-700 pe-2"></p>12pm</p>
                                                </div>
                                            </div>
                                            <div class="fs-6 text-gray-700 pe-7">Last day and time of the week prior to
                                                delivery that meal
                                                orders can be submitted</div>
                                            <h3 class="fw-bold mt-3">Sign up deadline</h3>
                                            <div class="d-flex justify-content-between mt-2">
                                                <div class="d-flex align-items-center">
                                                    <select name="deadline_day_new" class="form-select form-select-sm">
                                                        <option value="mon" {{ isset($setting) && $setting->deadline_day_new == 'mon' ? 'selected' : '' }}>Mon</option>
                                                        <option value="tue" {{ isset($setting) && $setting->deadline_day_new == 'tue' ? 'selected' : '' }}>Tue</option>
                                                        <option value="wed" {{ isset($setting) && $setting->deadline_day_new == 'wed' ? 'selected' : '' }}>Wed</option>
                                                        <option value="thu" {{ isset($setting) && $setting->deadline_day_new == 'thu' ? 'selected' : '' }}>Thu</option>
                                                        <option value="fri" {{ isset($setting) && $setting->deadline_day_new == 'fri' ? 'selected' : '' }}>Fri</option>
                                                        <option value="sat" {{ isset($setting) && $setting->deadline_day_new == 'sat' ? 'selected' : '' }}>Sat</option>
                                                        <option value="sun"{{ isset($setting) && $setting->deadline_day_new == 'sun' ? 'selected' : '' }}> Sun</option>
                                                    </select>
                                                    <p class="text-gray-700 pe-2"></p>12pm</p>
                                                </div>
                                            </div>
                                            <div class="fs-6 text-gray-700 pe-7">Last day and time of the week prior to
                                                delivery that new
                                                customer can sign up</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 p-2">
                                    <div class="card w-100 h-100 col-lg-12">
                                        <div class="card-header rest-padding" style="background: #ddd;">
                                            <h2 class="card-title">Delivery Info</h2>
                                            <i title="Delivery Info" class="fa-solid fa-truck"></i>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-10">
                                                <label for="delivery_times" class="fs-5 fw-bold form-label">Delivery
                                                    times</label>
                                                <input type="text" name="delivery_times" id=""
                                                    class="form-control form-control-sm"
                                                    value="{{ isset($setting) ? $setting->delivery_times : '' }}" />
                                                <div class="fs-6 text-gray-700 pe-7">Time range when meals will be delivered
                                                    (ex: 3pm - 8pm).
                                                    Appears in emails, Schedule page, and web site footer.
                                                    Delivery disclaimer</div>
                                            </div>
                                            <div class="mb-10">
                                                <label for="delivery_disclaimer" class="fs-5 fw-bold form-label">Delivery
                                                    disclaimer</label>
                                                <textarea type="text" name="delivery_disclaimer" class="form-control form-control-sm">{{ isset($setting) ? $setting->delivery_disclaimer : '' }}</textarea>
                                                <div class="fs-6 text-gray-700 pe-7">Appears on the sign up checkout and meal
                                                    plan settings
                                                    pages
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6 col-sm-12 p-2">
                                    <div class="card w-100 h-100 col-lg-12">
                                        <div class="card-header rest-padding" style="background: #ddd;">
                                            <h2 class="card-title">Pickup Info</h2>
                                            <i title="Pickup Info" class="fa-solid fa-cart-shopping"></i>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-10">
                                                <label for="pickup_times" class="fs-5 fw-bold form-label">Pickup times</label>
                                                <input type="text" name="pickup_times" id=""
                                                    class="form-control form-control-sm"
                                                    value="{{ isset($setting) ? $setting->pickup_times : '' }}" />
                                                <div class="fs-6 text-gray-700 pe-7">Time range when meals will be picked up
                                                    (ex: 11am - 7pm).
                                                    Appears in emails, Schedule page, and web site footer.</div>
                                            </div>
                                            <div class="mb-10">
                                                <label for="pickup_disclaimer" class="fs-5 fw-bold form-label">Pickup
                                                    disclaimer</label>
                                                <textarea type="text" name="pickup_disclaimer" class="form-control form-control-sm">{{ isset($setting) ? $setting->pickup_disclaimer : '' }}</textarea>
                                                <div class="fs-6 text-gray-700 pe-7">Appears on the sign up checkout and meal
                                                    plan settings
                                                    pages
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6 col-sm-12 p-2">
                                    <div class="card w-100 h-100 col-lg-12">
                                        <div class="card-header rest-padding" style="background: #ddd;">
                                            <h2 class="card-title">To Go Info</h2>
                                            <i title="To Go Info" class="fa-solid fa-clipboard-list"></i>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-10">
                                                <label for="cafe_hours" class="fs-5 fw-bold form-label">To go hours</label>
                                                <input type="text" name="cafe_hours" id=""
                                                    class="form-control form-control-sm"
                                                    value="{{ isset($setting) ? $setting->cafe_hours : '' }}" />
                                                <div class="fs-6 text-gray-700 pe-7">Abbreviated days and times to go is
                                                    available (ex: Mon -
                                                    Fri,
                                                    11am - 7pm). Appears on To Go page and in web site footer.</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12 col-md-12 col-sm-12 p-2 w-100">
                                    <div class="card w-100 h-100 col-lg-12">
                                        <div class="card-header rest-padding" style="background: #ddd;">
                                            <h2 class="card-title">UR Settings</h2>
                                            <i title="UR Settings" class="fa-solid fa-list-check"></i>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-10">
                                                <label for="pickup_urmc_times" class="fs-5 fw-bold form-label">Pickup URMC
                                                    times</label>
                                                <input type="text" name="pickup_urmc_times" id=""
                                                    class="form-control form-control-sm"
                                                    value="{{ isset($setting) ? $setting->pickup_urmc_times : '' }}" />
                                                <div class="fs-6 text-gray-700 pe-7">Time range when meals can be picked up
                                                    (ex: 4pm - 7pm).
                                                </div>
                                            </div>
                                            <div class="mb-10">
                                                <label class="form-check d-flex align-items-center me-5">
                                                    <input class="form-check-input" name="urmc_delivery_disabled" type="checkbox"
                                                        value="1"
                                                        {{ isset($setting) && $setting->urmc_delivery_disabled ? 'checked' : '' }} />
                                                    <span class="fw-semibold fs-6 ms-2">Disable delivery for new UR customers
                                                        and display this
                                                        message:</span>
                                                </label>
                                                <input type="text" name="urmc_delivery_message" id=""
                                                    class="form-control form-control-sm"
                                                    value="{{ isset($setting) ? $setting->urmc_delivery_message : '' }}" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end py-2 px-2">
                                @can('edit settings')
                                    <button type="submit" class="btn btn-sm btn-primary"><i class="fa-solid fa-rotate"></i>Update</button>
                                @endcan
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Content-->
    </div>
@endsection
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkboxes = document.querySelectorAll('.meal-day-checkbox');
        const maxSelection = 2;
        const warningCard = document.getElementById('meal-days-warning');
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const checkedBoxes = document.querySelectorAll('.meal-day-checkbox:checked');
                if (checkedBoxes.length > maxSelection) {
                    warningCard.classList.remove('d-none');
                    this.checked = false;
                } else {
                    warningCard.classList.add('d-none');
                }
            });
        });
    });

    function dismissWarning() {
        const warningCard = document.getElementById('meal-days-warning');
        warningCard.classList.add('d-none');
    }
</script>
