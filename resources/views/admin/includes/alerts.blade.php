@if ($errors->any())
    <div class="alert alert-danger col-md-12 mt-4">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{!! $error !!}</li>
            @endforeach
        </ul>
    </div>
@endif
@if (session('success'))
    <p id="success-message" class="alert alert-success col-md-12 mt-4">{!! session('success') !!}</p>
@elseif(session('error'))
    <p id="error-message" class="alert alert-danger col-md-12 mt-4">{!! session('error') !!}</p>
@endif

@push('script')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Check if there's a success message
            var successMessage = document.getElementById('success-message');
            var errorMessage = document.getElementById('error-message');
            if (successMessage) {
                setTimeout(function() {
                    successMessage.style.display = 'none';
                }, 3000); // Hide after 3 seconds
            }
            // Hide error message after 5 seconds (optional)
            if (errorMessage) {
                setTimeout(function() {
                    errorMessage.style.display = 'none';
                }, 5000); // Hide after 5 seconds (optional)
            }
        });
    </script>
@endpush
