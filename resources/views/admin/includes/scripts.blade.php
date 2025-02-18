<script>
    var hostUrl = "admin_assets/";
</script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="{{ asset('admin_assets/plugins/global/plugins.bundle.js') }}"></script>
<script src="{{ asset('admin_assets/js/scripts.bundle.js') }}"></script>
<script src="{{ asset('admin_assets/js/widgets.bundle.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<!-- ============other scripts======  -->
<script>
    var defaultThemeMode = "light";
    var themeMode;
    if (document.documentElement) {
        if (document.documentElement.hasAttribute("data-bs-theme-mode")) {
            themeMode = document.documentElement.getAttribute("data-bs-theme-mode");
        } else {
            if (localStorage.getItem("data-bs-theme") !== null) {
                themeMode = localStorage.getItem("data-bs-theme");
            } else {
                themeMode = defaultThemeMode;
            }
        }
        if (themeMode === "system") {
            themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
        }
        document.documentElement.setAttribute("data-bs-theme", themeMode);
    }
</script>

<script>
    function swalAlert(text, icon, btn_class) {
        Swal.fire({
            html: text,
            icon: icon,
            buttonsStyling: false,
            confirmButtonText: "Ok, got it!",
            customClass: {
                confirmButton: btn_class
            }
        });
    }
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    });

    function showOverlay() {
        $("body").addClass('bodyClass');
        $(".style_three").show();
        $("button").attr('disabled', true);
        $("input[type='submit']").attr('disabled', true);
    }

    function hideOverlay() {
        $("body").removeClass('bodyClass')
        $(".style_three").hide();
        $("button").removeAttr('disabled');
        $("input[type='submit']").removeAttr('disabled');
    }
    $(document).ready(function() {
        $('select:not(.colorSelect)').select2();
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Check if there's a success message
        var successMessage = document.getElementById('success-message');
        if (successMessage) {
            // Set a timeout to hide the message after 3 seconds (3000ms)
            setTimeout(function() {
                successMessage.style.display = 'none';
            }, 3000); // Change 3000 to the number of milliseconds you want to wait
        }
    });
    $('form').on('submit', function (e) {
        showOverlay();
        setTimeout(function () {
            hideOverlay();
        }, 3000);
    });
</script>

@stack('script')
