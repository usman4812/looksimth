<div id="kt_app_footer" class="app-footer align-items-center justify-content-center justify-content-md-between flex-column flex-md-row py-3 py-lg-6">
    <!--begin::Copyright-->
    <div class="text-dark order-2 order-md-1">
        <span class="text-muted fw-semibold me-1">{{ date('Y') }}&copy;</span>
        <a href="{{ route('admin.dashboard') }}" target="_blank" class="text-gray-800 text-hover-primary">Ehmeals</a>
    </div>
    <!--end::Copyright-->
    <!--begin::Menu-->
    <ul class="menu menu-gray-600 menu-hover-primary fw-semibold order-1">
        <li class="menu-item">
            <a href="" target="_blank" class="menu-link px-2">About</a>
        </li>
        <li class="menu-item">
            <a href="" target="_blank" class="menu-link px-2">Support</a>
        </li>
        <li class="menu-item">
            <a href="" target="_blank" class="menu-link px-2">Purchase</a>
        </li>
    </ul>
    <!--end::Menu-->
</div>
<div class="loader-wrapper style_three" style="display: none">
    <div class="loader"></div>
    <span>Processing . . . </span>
</div>