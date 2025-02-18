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
        <!--begin::Content-->
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div class="container-fluid">

                <div class="d-flex flex-wrap">
                    <!-- Include Customer Sidebar -->
                    @include('admin.pages.customer.customer_view_sidebar', ['customer' => $customer])

                    <div class="col-lg-9 col-md-8 col-sm-12 p-2">
                        <div class="card w-100 h-100 col-lg-12">
                            <div class="card-header rest-padding colored-customer-detail" style="background: #a4d4a1;">
                                <h2 class="card-title">Pickup Schedule</h2>
                                <i title="Delivery Info" class="fa-solid fa-truck-ramp-box"></i>
                                {{-- <i title="Delivery Info" class="fa-solid fa-truck"></i> --}}
                            </div>
                            <div class="card-body">
                                <div class="w-100 d-flex flex-wrap">
                                    <div class="col-lg-12 col-md-12 col-sm-12 pickup-scheduled-section mb-3 mt-0">
                                        <p>
                                            Pickup your meals at <strong>Effortlessly Healthy</strong>
                                        </p>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 pickup-scheduled-section">
                                        <p class="text-muted">
                                        <div class="mb-2">
                                            <i class="fa-solid fa-house me-1"></i> 1440 Scottsville Road, Rochester, NY
                                            14624
                                        </div>
                                        <div class="">
                                            <i class="fa-solid fa-phone me-1"></i> Call <a
                                                href="tel:5853554527">585-355-4527</a>
                                            and meals will
                                            be ready for you to pick up inside.
                                        </div>
                                        </p>
                                    </div>
                                </div>
                                <div class="w-100 d-flex justify-content-end align-items-center">
                                    {{-- <div class="lineset-hr-section"></div> --}}
                                    <a href="#" class="text-hover-underline"><i
                                            class="fa-solid fa-location-dot me-1"></i>Get Directions</a>
                                </div>
                                <hr class="my-4">
                                <div class="d-flex justify-content-between flex-wrap align-items-center">
                                    <div class="pickup-scheduled-body">
                                        <p class="p-0 m-0"><b>Plan End Date:</b> Wed, feb 19</p>
                                    </div>
                                    <div class="pickup-scheduled-body">
                                        <i class="fa-solid fa-calendar-days p-0 m-0"></i>
                                        <p class="p-0 m-0">Next Delivery is 4 days away on Tue, Jan 21, 2pm - 8pm</p>
                                    </div>
                                </div>

                                <!-- Tabs Section -->
                                <div class="w-100 d-flex align-items-center justify-content-between">
                                    <ul class="nav nav-pills mb-2 mt-4" id="pills-tab" role="tablist">
                                        <div class="pickup-meal-border">
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link active" id="pills-home-tab pills-tab-home"
                                                    data-bs-toggle="pill" data-bs-target="#pills-home" type="button"
                                                    role="tab" aria-controls="pills-home"
                                                    aria-selected="true">Upcoming</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="pills-profile-tab pills-tab-profile"
                                                    data-bs-toggle="pill" data-bs-target="#pills-profile" type="button"
                                                    role="tab" aria-controls="pills-profile"
                                                    aria-selected="false">Completed</button>
                                            </li>
                                        </div>
                                    </ul>
                                    {{-- <div class="tab-content pickup-pills-section-upcomming-icons" id="pills-tabContent">
                                        <div class="tab-pane fade show active pickup-meal-upcomming-box" id="pills-home-tab"
                                            role="tabpanel" aria-labelledby="pills-tab-home">
                                            <i class="fa-solid fa-calendar-days"></i>
                                        </div>
                                        <div class="tab-pane fade pickup-meal-upcomming-box" id="pills-profile-tab"
                                            role="tabpanel" aria-labelledby="pills-tab-profile">
                                            <i class="fa-solid fa-house"></i>
                                        </div>
                                    </div> --}}
                                </div>
                                <div class="tab-content" id="pills-tabContent">
                                    <div class="tab-pane fade show active pickup-meal-upcomming-box" id="pills-home"
                                        role="tabpanel" aria-labelledby="pills-home-tab">
                                        <div class="pickup-meal-upcomming-box-header">
                                            <div class="pickup-meal-upcomming-box-header-heading">
                                                <h3>Weak of Monday, January 2013</h3>
                                                <a href=""><i class="fa-solid fa-pen-to-square"></i> Select Meal</a>
                                                <a href=""><i class="fa-solid fa-ban"></i> Skip Week</a>
                                            </div>
                                            <div class="pickup-meal-upcomming-box-header-body">
                                                <p>Order Deadline: |</p>
                                                <p>Order auto-Selected: |</p>
                                            </div>

                                        </div>
                                        <hr>

                                        <div class="pickup-meal-outer-body-section">
                                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Vero, veniam!</p>
                                            <div class="d-flex align-items-center justify-content-start flex-wrap">
                                                <span>Delivery on Tue, Jan 14, 2pm - 8pm (7 meals)</span>
                                                <a href="" class="ms-5">
                                                    Auto-Select
                                                </a>
                                            </div>
                                        </div>
                                        <div class="container-for-card-elements">
                                            <!-- Card 1 -->
                                            <div class="main-wrapper-for-single-card-box">
                                                <div class="wrapper-for-single-card-box">
                                                    <div class="layout-for-card-content">
                                                        <div class="image-section-for-card">
                                                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTrm45IT7TPDizgfnHZXQPDqLqTyIxJBt0D4Q&s"
                                                                alt="Card 1 Image">
                                                        </div>
                                                        <div class="content-section-for-card">
                                                            <h3 class="header-text-for-card-title">Card 1 Card 1 Card 1
                                                                Card 1 Card 1 Card 1 Card 1 Card 1 Card 1 Card 1 Card 1 Card
                                                                1 Card 1 Card 1 </h3>
                                                            <p class="description-text-for-card">Description of the
                                                                card.Card 1 Card 1 Card 1 Card 1 Card 1 Card 1 Card 1 Card 1
                                                                Card 1 Card 1 Card 1 </p>
                                                            <p class="paragraph-text-for-card">This card contains badges
                                                                that appear on hover.Card 1 Card 1 Card 1 Card 1 Card 1 Card
                                                                1 Card 1 Card 1 </p>
                                                            <p class="text-display-for-badge-count">Quantity: 4</p>
                                                        </div>
                                                    </div>
                                                    <div class="overlay-wrapper-for-badges">
                                                        <div class="individual-box-for-badges">Badge 1</div>
                                                        <div class="individual-box-for-badges">Badge 2</div>
                                                        <div class="individual-box-for-badges">Badge 3</div>
                                                        <div class="individual-box-for-badges">Badge 4</div>
                                                        <div class="individual-box-for-badges">Badge 1</div>
                                                        <div class="individual-box-for-badges">Badge 2</div>
                                                        <div class="individual-box-for-badges">Badge 3</div>
                                                        <div class="individual-box-for-badges">Badge 4</div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Card 2 -->
                                            <div class="main-wrapper-for-single-card-box">
                                                <div class="wrapper-for-single-card-box">
                                                    <div class="layout-for-card-content">
                                                        <div class="image-section-for-card">
                                                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTrm45IT7TPDizgfnHZXQPDqLqTyIxJBt0D4Q&s"
                                                                alt="Card 2 Image">
                                                        </div>
                                                        <div class="content-section-for-card">
                                                            <h3 class="header-text-for-card-title">Card 2</h3>
                                                            <p class="description-text-for-card">A different description
                                                                for this card.</p>
                                                            <p class="paragraph-text-for-card">Hover to see the badges
                                                                appear.</p>
                                                            <p class="text-display-for-badge-count">Quantity: 3</p>
                                                        </div>
                                                    </div>
                                                    <div class="overlay-wrapper-for-badges">
                                                        <div class="individual-box-for-badges">Badge A</div>
                                                        <div class="individual-box-for-badges">Badge B</div>
                                                        <div class="individual-box-for-badges">Badge C</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="tab-pane fade pickup-meal-upcomming-box" id="pills-profile"
                                        role="tabpanel" aria-labelledby="pills-profile-tab">
                                        <div class="pickup-meal-upcomming-box-header">
                                            <div class="pickup-meal-complete-box-header-heading">
                                                <div class="d-flex align-items-end">
                                                    <h3>Weak of Monday, January 2013</h3>
                                                    <p class="m-0 p-0">Completed</p>
                                                </div>
                                                <button>
                                                    Paid
                                                </button>
                                                {{-- <a href=""><i class="fa-solid fa-pen-to-square"></i> Select Meal</a>
                                                <a href=""><i class="fa-solid fa-ban"></i> Skip Week</a> --}}
                                            </div>
                                            <div class="pickup-meal-upcomming-box-header-body">
                                                <p>Order Deadline: |</p>
                                                <p>Order auto-Selected: |</p>
                                            </div>

                                        </div>
                                        <hr>

                                        <div class="pickup-meal-outer-body-section">
                                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Vero, veniam!</p>
                                            <div class="d-flex align-items-center justify-content-start">
                                                <span>Delivery on Tue, Jan 14, 2pm - 8pm (7 meals)</span>
                                                <a href="">
                                                    Auto-Select
                                                </a>
                                            </div>
                                        </div>
                                        <div class="container-for-card-elements">
                                            <!-- Card 1 -->
                                            <div class="main-wrapper-for-single-card-box">
                                                <div class="wrapper-for-single-card-box">
                                                    <div class="layout-for-card-content">
                                                        <div class="image-section-for-card">
                                                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTrm45IT7TPDizgfnHZXQPDqLqTyIxJBt0D4Q&s"
                                                                alt="Card 1 Image">
                                                        </div>
                                                        <div class="content-section-for-card">
                                                            <h3 class="header-text-for-card-title">Card 1 Card 1 Card 1
                                                                Card 1 Card 1 Card 1 Card 1 Card 1 Card 1 Card 1 Card 1 Card
                                                                1 Card 1 Card 1 </h3>
                                                            <p class="description-text-for-card">Description of the
                                                                card.Card 1 Card 1 Card 1 Card 1 Card 1 Card 1 Card 1 Card 1
                                                                Card 1 Card 1 Card 1 </p>
                                                            <p class="paragraph-text-for-card">This card contains badges
                                                                that appear on hover.Card 1 Card 1 Card 1 Card 1 Card 1 Card
                                                                1 Card 1 Card 1 </p>
                                                            <p class="text-display-for-badge-count">Quantity: 4</p>
                                                        </div>
                                                    </div>
                                                    <div class="overlay-wrapper-for-badges">
                                                        <div class="individual-box-for-badges">Badge 1</div>
                                                        <div class="individual-box-for-badges">Badge 2</div>
                                                        <div class="individual-box-for-badges">Badge 3</div>
                                                        <div class="individual-box-for-badges">Badge 4</div>
                                                        <div class="individual-box-for-badges">Badge 1</div>
                                                        <div class="individual-box-for-badges">Badge 2</div>
                                                        <div class="individual-box-for-badges">Badge 3</div>
                                                        <div class="individual-box-for-badges">Badge 4</div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Card 2 -->
                                            <div class="main-wrapper-for-single-card-box">
                                                <div class="wrapper-for-single-card-box">
                                                    <div class="layout-for-card-content">
                                                        <div class="image-section-for-card">
                                                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTrm45IT7TPDizgfnHZXQPDqLqTyIxJBt0D4Q&s"
                                                                alt="Card 2 Image">
                                                        </div>
                                                        <div class="content-section-for-card">
                                                            <h3 class="header-text-for-card-title">Card 2</h3>
                                                            <p class="description-text-for-card">A different description
                                                                for this card.</p>
                                                            <p class="paragraph-text-for-card">Hover to see the badges
                                                                appear.</p>
                                                            <p class="text-display-for-badge-count">Quantity: 3</p>
                                                        </div>
                                                    </div>
                                                    <div class="overlay-wrapper-for-badges">
                                                        <div class="individual-box-for-badges">Badge A</div>
                                                        <div class="individual-box-for-badges">Badge B</div>
                                                        <div class="individual-box-for-badges">Badge C</div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Card 3 -->
                                            <div class="main-wrapper-for-single-card-box">
                                                <div class="wrapper-for-single-card-box">
                                                    <div class="layout-for-card-content">
                                                        <div class="image-section-for-card">
                                                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTrm45IT7TPDizgfnHZXQPDqLqTyIxJBt0D4Q&s"
                                                                alt="Card 1 Image">
                                                        </div>
                                                        <div class="content-section-for-card">
                                                            <h3 class="header-text-for-card-title">Card 1 Card 1 Card 1
                                                                Card 1 Card 1 Card 1 Card 1 Card 1 Card 1 Card 1 Card 1 Card
                                                                1 Card 1 Card 1 </h3>
                                                            <p class="description-text-for-card">Description of the
                                                                card.Card 1 Card 1 Card 1 Card 1 Card 1 Card 1 Card 1 Card 1
                                                                Card 1 Card 1 Card 1 </p>
                                                            <p class="paragraph-text-for-card">This card contains badges
                                                                that appear on hover.Card 1 Card 1 Card 1 Card 1 Card 1 Card
                                                                1 Card 1 Card 1 </p>
                                                            <p class="text-display-for-badge-count">Quantity: 4</p>
                                                        </div>
                                                    </div>
                                                    <div class="overlay-wrapper-for-badges">
                                                        <div class="individual-box-for-badges">Badge 1</div>
                                                        <div class="individual-box-for-badges">Badge 2</div>
                                                        <div class="individual-box-for-badges">Badge 3</div>
                                                        <div class="individual-box-for-badges">Badge 4</div>
                                                        <div class="individual-box-for-badges">Badge 1</div>
                                                        <div class="individual-box-for-badges">Badge 2</div>
                                                        <div class="individual-box-for-badges">Badge 3</div>
                                                        <div class="individual-box-for-badges">Badge 4</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Weekly Details -->
                                {{-- <div>
                                    <h5 class="fw-semibold text-dark mb-2">Week of Monday, December 2</h5>
                                    <p class="text-muted mb-4">Order deadline: Wed, Nov 27 at 12:00pm</p>

                                    <div class="d-flex align-items-center gap-4 mb-4">
                                        <button class="btn btn-outline-primary btn-sm">Select Meals</button>
                                        <button class="btn btn-outline-danger btn-sm">Skip Week</button>
                                    </div>

                                    <p class="text-dark mb-2">
                                        Weekly Meals, 5 Meals Per Week, Standard | Meals on Tuesday
                                    </p>
                                    <hr>
                                    <p class="text-dark mb-1">
                                        <strong>Pickup at Our Store on Mon, Dec 2, Tue:</strong> 8am - 5:30pm |
                                        <strong>Fri:</strong> 10am - 4:30pm
                                    </p>
                                    <p class="text-muted">No meals ordered for this day.</p>
                                    <hr>
                                    <p class="text-dark mb-1">
                                        <strong>Pickup at Our Store on Fri, Dec 6:</strong> 10am - 4:30pm
                                    </p>
                                    <p class="text-muted">No meals ordered for this day.</p>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Content-->
    </div>
    <script>
        // Define badge colors dynamically
        const badgeColors = ["#e74c3c", "#3498db", "#2ecc71", "#f1c40f", "#9b59b6", "#34495e", "#e67e22", "#1abc9c"];

        // Apply colors to badges dynamically
        document.querySelectorAll(".wrapper-for-single-card-box").forEach((card, index) => {
            const badges = card.querySelectorAll(".individual-box-for-badges");
            badges.forEach((badge, i) => {
                // Assign colors from the array in a loop
                const colorIndex = (i + index) % badgeColors.length;
                badge.style.backgroundColor = badgeColors[colorIndex];
            });
        });
    </script>
@endsection
