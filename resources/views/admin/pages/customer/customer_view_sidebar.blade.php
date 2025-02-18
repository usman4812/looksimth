@php
    $segments = request()->segments();
@endphp
<style>
    /* Default styles for all links */
    .border-section-anchor a {
        display: block;
        padding: 7px;
        border-radius: 5px;
        transition: all 0.3s ease;
        text-decoration: none;
        border-style: dashed;
        pointer-events: auto;
        display: flex;
        align-items: center;
        justify-content: space-between;
        transition: color 0.3s ease;
    }

    .border-section-anchor span {
        white-space: nowrap !important;
    }

    /* Default icon styling */
    .border-section-anchor a i {
        transition: color 0.3s ease;
    }

    /* Disabled link styling */
    .border-section-anchor a.disabled {
        pointer-events: none;
        opacity: 0.6;
        transition: color 0.3s ease;
    }

    /* Single color for all link borders */
    .link-schedule,
    .link-plan,
    .link-preferences,
    .link-payment,
    .link-user {
        border: 1px solid #a4d4a1;
        /* Change to your desired color */
        transition: color 0.3s ease;
        color: #a4d4a1;
    }

    /* Active and hover states */
    .link-schedule.active,
    .link-schedule:hover,
    .link-plan.active,
    .link-plan:hover,
    .link-preferences.active,
    .link-preferences:hover,
    .link-payment.active,
    .link-payment:hover,
    .link-user.active,
    .link-user:hover {
        background-color: #a4d4a1;
        /* Single color for background */
        color: #fff !important;
        /* White text when active or hovered */
    }

    /* Icon colors */
    .link-schedule i,
    .link-plan i,
    .link-preferences i,
    .link-payment i,
    .link-user i {
        color: #a4d4a1;
        /* Single color for icon */
        transition: color 0.3s ease;
    }

    /* Change icon color when link is active or hovered */
    .link-schedule.active i,
    .link-schedule:hover i,
    .link-plan.active i,
    .link-plan:hover i,
    .link-preferences.active i,
    .link-preferences:hover i,
    .link-payment.active i,
    .link-payment:hover i,
    .link-user.active i,
    .link-user:hover i {
        color: #fff !important;
        /* White icon when active or hovered */
    }
</style>

<div class="col-lg-3 col-md-4 col-sm-12 main-customer-card-width p-2 h-100">
    <div class="card w-100 h-100 col-lg-12" style="border: 1px solid transparent !important;">
        {{-- <div class="card-header rest-padding" style="background: #ddd;">
            <h2 class="card-title">Customer Details</h2>
            <i title="Meal Days & Order Deadline" class="fa-solid fa-database"></i>
        </div> --}}
        <div class="card-body customer-heading">
            <div class="customer-image-info-sections">
                <div class="customer-image-top-border">
                    {{-- <i class="fa-regular fa-circle-user"></i> --}}
                </div>
                <div class="customer-image-sections-padding">
                    <div class="customer-image-sections">
                        <div class="customer-inner-image-section">
                            <img src="https://www.foodiesfeed.com/wp-content/uploads/2023/06/burger-with-melted-cheese.jpg"
                                alt="">
                        </div>
                    </div>
                </div>
                <div class="customer-image-sections-padding">
                    <div class="customer-info-section">
                        <!-- User Name -->
                        <div class="customer-heading-name">
                            <h5 class="fw-bold mb-3">{{ $customer->name }}</h5>
                        </div>
                        <div class="customer-only-info-section">
                            <!-- User Info -->
                            <p class="customer-border-information mb-2">
                                <i class="fa-solid fa-envelope fs-5 me-2"></i>
                                <a href="mailto:user10381@ehmeals.com" class="text-dark">{{ $customer->email }}</a>
                            </p>
                            <p class="customer-border-information mb-2">
                                <i class="fa-solid fa-phone fs-5 me-2"></i>
                                <a href="tel:5852540078"
                                    class="text-dark text-hover-primary">{{ $customer->address->phone }}</a>
                            </p>
                            <p class="customer-border-information mb-3">
                                <i class="ki-duotone ki-home fs-5 me-2"></i>
                                {{ $customer->address->street1 }},<br> {{ $customer->address->city }}, <b>NY</b> ,
                                {{ $customer->address->zip_code }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            {{-- <hr> --}}
            <div class="customer-button-sections">
                <div class="d-flex flex-column gap-2 border-section-anchor">
                    <a id="schedule-link" href="{{ route('admin.customers.schedule', $uuid) }}"
                        class="fs-6 fw-bold text-gray-800 text-hover-primary text-active-primary link-schedule"
                        onclick="setActive(this)">
                        <span>Pickup Schedule</span>
                        <i class="fa-solid fa-truck-ramp-box"></i>
                    </a>
                    <a id="plan-link" href="{{ route('admin.customers.plan', $uuid) }}"
                        class="fs-6 fw-bold text-gray-800 text-hover-primary text-active-primary link-plan"
                        onclick="setActive(this)">
                        <span>Meal Plan Settings</span>
                        <i class="fa-solid fa-utensils"></i>
                    </a>
                    <a id="preferences-link" href="{{ route('admin.customers.preferences', $uuid) }}"
                        class="fs-6 fw-bold text-gray-800 text-hover-primary text-active-primary link-preferences"
                        onclick="setActive(this)">
                        <span>Dietary Preferences</span><i class="fa-solid fa-cookie-bite"></i>
                    </a>
                    <a id="payment-link" href="{{ route('admin.customers.payment', $uuid) }}"
                        class="fs-6 fw-bold text-gray-800 text-hover-primary text-active-primary link-payment"
                        onclick="setActive(this)">
                        <span>Payment Info</span><i class="fa-solid fa-dollar-sign"></i>
                    </a>
                    <a id="user-link" href="{{ route('admin.customers.user', $uuid) }}"
                        class="fs-6 fw-bold text-gray-800 text-hover-primary text-active-primary link-user"
                        onclick="setActive(this)">
                        <span>Account Info</span><i class="fa-solid fa-circle-info"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        // Check if there's an active link stored in localStorage
        const activeLink = localStorage.getItem('activeLink');
        if (activeLink) {
            // Set the active link from localStorage
            document.querySelector(`#${activeLink}`)?.classList.add('active');
        }

        // Add event listener to all the links to track click and set active state
        const links = document.querySelectorAll('.border-section-anchor a');
        links.forEach(link => {
            link.addEventListener('click', (e) => {
                setActive(e.target);
            });
        });
    });

    function setActive(clickedLink) {
        // Get all the links in the container
        const links = document.querySelectorAll('.border-section-anchor a');

        // Loop through the links and remove active/disabled classes
        links.forEach((link) => {
            // Remove 'active' class from all links
            link.classList.remove('active');
        });

        // Add 'active' class to the clicked link
        clickedLink.classList.add('active');

        // Save the id of the clicked link to localStorage
        localStorage.setItem('activeLink', clickedLink.id);
    }
</script>
