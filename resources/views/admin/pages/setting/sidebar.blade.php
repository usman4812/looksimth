@php
    $segments = request()->segments();
@endphp
<div class="col-lg-3 p-2 mb-0">
    <div class="card card-flush" style="width: 100%;">
        <div class="card-header rest-padding" id="kt_chat_contacts_header">
            <div class="card-title">
                <h2>SETTINGS</h2>
            </div>
        </div>
        <div class="card-body pt-5">
            <div class="d-flex flex-column gap-5">
                <div class="d-flex flex-stack">
                    <a href="{{ route('admin.settings') }}"
                        class="fs-6 fw-bold text-gray-800 text-hover-primary text-active-primary {{ @$segments[1] == 'general' ? 'active' : '' }}">
                        General
                    </a>
                </div>
                <div class="d-flex flex-stack">
                    <a href="{{ route('admin.settings.meal.types') }}"
                        class="fs-6 fw-bold text-gray-800 text-hover-primary text-active-primary {{ @$segments[1] == 'meal-types' ? 'active' : '' }}">
                        Meals Type
                    </a>
                    <div class="badge badge-light-primary">{{ $totalMealType }}</div>
                </div>
                <div class="d-flex flex-stack">
                    <a href="{{ route('admin.settings.ingredients') }}"
                        class="fs-6 fw-bold text-gray-800 text-hover-primary text-active-primary {{ @$segments[1] == 'ingredients' ? 'active' : '' }}">
                        Ingredients
                    </a>
                    <div class="badge badge-light-primary">{{ $totalIngredients }}</div>
                </div>
                <div class="d-flex flex-stack">
                    <a href="{{ route('admin.settings.diets') }}"
                        class="fs-6 fw-bold text-gray-800 text-hover-primary text-active-primary {{ @$segments[1] == 'diets' ? 'active' : '' }}">
                        Diets
                    </a>
                    <div class="badge badge-light-primary">{{ $totalDiets }}</div>
                </div>
                <div class="d-flex flex-stack">
                    <a href="{{ route('admin.settings.meal.size') }}"
                        class="fs-6 fw-bold text-gray-800 text-hover-primary text-active-primary {{ @$segments[1] == 'meal-size' ? 'active' : '' }}">
                        Meal Size
                    </a>
                    <div class="badge badge-light-primary">{{ $totalMealSize }}</div>
                </div>
                <div class="d-flex flex-stack">
                    <a href="{{ route('admin.settings.plan.types') }}"
                        class="fs-6 fw-bold text-gray-800 text-hover-primary text-active-primary {{ @$segments[1] == 'plan-types' ? 'active' : '' }}">
                        Plan Types
                    </a>
                    <div class="badge badge-light-primary">{{ $totalPlanType }}</div>
                </div>
                <div class="d-flex flex-stack">
                    <a href="{{ route('admin.settings.vendors') }}"
                        class="fs-6 fw-bold text-gray-800 text-hover-primary text-active-primary {{ @$segments[1] == 'vendors' ? 'active' : '' }}">
                       Vendors
                    </a>
                    <div class="badge badge-light-primary">{{ $totalVendor }}</div>
                </div>
                <div class="d-flex flex-stack">
                    <a href="{{ route('admin.settings.status') }}"
                        class="fs-6 fw-bold text-gray-800 text-hover-primary text-active-primary {{ @$segments[1] == 'status' ? 'active' : '' }}">
                       Status
                    </a>
                    <div class="badge badge-light-primary">{{ $totalStatus }}</div>
                </div>
                <div class="d-flex flex-stack">
                    <a href="{{ route('admin.settings.customer.group') }}"
                        class="fs-6 fw-bold text-gray-800 text-hover-primary text-active-primary {{ @$segments[1] == 'customer-group' ? 'active' : '' }}">
                       Customer Group
                    </a>
                    <div class="badge badge-light-primary">{{ $totalCustomerGroup }}</div>
                </div>
                <div class="d-flex flex-stack">
                    <a href="{{ route('admin.settings.source') }}"
                        class="fs-6 fw-bold text-gray-800 text-hover-primary text-active-primary {{ @$segments[1] == 'source' ? 'active' : '' }}">
                       Source
                    </a>
                    <div class="badge badge-light-primary">{{ $totalSource }}</div>
                </div>
                <div class="d-flex flex-stack">
                    <a href="{{ route('admin.settings.discount.type') }}"
                        class="fs-6 fw-bold text-gray-800 text-hover-primary text-active-primary {{ @$segments[1] == 'discount-type' ? 'active' : '' }}">
                       Discount Type
                    </a>
                    <div class="badge badge-light-primary">{{ $totalDiscountType}}</div>
                </div>
                <div class="d-flex flex-stack">
                    <a href="{{ route('admin.settings.credit.card.type') }}"
                        class="fs-6 fw-bold text-gray-800 text-hover-primary text-active-primary {{ @$segments[1] == 'credit-card-type' ? 'active' : '' }}">
                       Credit Card Types
                    </a>
                    <div class="badge badge-light-primary">{{ $totalCreditCardType}}</div>
                </div>
            </div>
        </div>
    </div>
</div>
