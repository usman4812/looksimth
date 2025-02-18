<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Admin Login - Ehmeals</title>
		<meta charset="utf-8" />
		<meta name="description" content="Login page to access admin panel" />
		<meta name="keywords" content="admin panel" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta property="og:locale" content="en_US" />
		<meta property="og:title" content="Admin Login - Ehmeals" />
		<link rel="shortcut icon" href="{{ asset('admin_assets/logos/logo.png') }}" />
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
		<link href="{{ asset('admin_assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('admin_assets/css/style.bundle.css?v=1.1') }}" rel="stylesheet" type="text/css" />
		<!-- Font Awesome for Icons -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
	</head>
	<body id="kt_body" class="app-blank">
		<div class="d-flex flex-column flex-root" id="kt_app_root">
			<div class="d-flex flex-column flex-lg-row flex-column-fluid">
				<div class="d-flex flex-column flex-lg-row-fluid w-lg-50 p-10 order-2 order-lg-1">
					<div class="d-flex flex-center flex-column flex-lg-row-fluid">
						<div class="w-lg-500px p-10">
							@if ($errors->any())
								<div class="alert alert-danger col-md-12">
									<ul>
										@foreach ($errors->all() as $error)
											<li>{!! $error !!}</li>
										@endforeach
									</ul>
								</div>
							@endif
							@if (session('success'))
								<p class="alert alert-success col-md-12">{!! session('success') !!}</p>
							@elseif(session('error'))
								<p class="alert alert-danger col-md-12">{!! session('error') !!}</p>
							@endif
							<form class="form w-100" action="{{ route('admin.login') }}" method="POST">
								@csrf
								<div class="text-center mb-11">
									<h1 class="text-dark fw-bolder mb-3">Sign In</h1>
									<div class="text-gray-500 fw-semibold fs-6">LockSmith Admin Panel </div>
								</div>
								<div class="fv-row mb-8">
									<input type="text" placeholder="Email" name="email" autocomplete="off" class="form-control bg-transparent" />
								</div>
								<div class="fv-row mb-3 position-relative">
									<input type="password" placeholder="Password" name="password" autocomplete="off" class="form-control bg-transparent" id="password" />
									<span class="position-absolute top-50 end-0 translate-middle-y me-3 cursor-pointer" id="togglePassword">
										<i class="fa-solid fa-eye"></i>
									</span>
								</div>
								<div class="d-grid mb-10">
									<button type="submit" id="kt_sign_in_submit" class="btn btn-primary">
										<span class="indicator-label">Sign In</span>
									</button>
								</div>
							</form>
						</div>
					</div>
				</div>
				<div class="d-flex flex-lg-row-fluid w-lg-50 bgi-size-cover bgi-position-center order-1 order-lg-2" style="background-image: url({{ asset('admin_assets/media/misc/auth-bg.png') }})">
					<div class="d-flex flex-column flex-center py-7 py-lg-15 px-5 px-md-15 w-100">
						<a href="{{ route('admin.dashboard') }}" class="mb-0 mb-lg-12">
							<img alt="Logo" src="{{ asset('admin_assets/logos/locksmith.png') }}" class="h-60px h-lg-75px" />
						</a>
						<img class="d-none d-lg-block mx-auto w-275px w-md-50 w-xl-500px mb-10 mb-lg-20" src="{{ asset('admin_assets/media/misc/auth-screens.png') }}" alt="" />
						<h1 class="d-none d-lg-block text-white fs-2qx fw-bolder text-center mb-7">Fast, Efficient and Productive</h1>
						<div class="d-none d-lg-block text-white fs-base text-center">In this kind of post,
						<a href="#" class="opacity-75-hover text-warning fw-bold me-1">the blogger</a>introduces a person they’ve interviewed
						<br />and provides some background information about
						<a href="#" class="opacity-75-hover text-warning fw-bold me-1">the interviewee</a>and their
						<br />work following this is a transcript of the interview.</div>
					</div>
				</div>
			</div>
		</div>
		<script>
			var hostUrl = "admin_assets/";
		</script>
		<script src="https://code.jquery.com/jquery-3.7.1.min.js"
			integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
		<script src="{{ asset('admin_assets/plugins/global/plugins.bundle.js') }}"></script>
		<script src="{{ asset('admin_assets/js/scripts.bundle.js') }}"></script>
		<script>
			$(document).ready(function () {
				$('#togglePassword').on('click', function () {
					const passwordField = $('#password');
					const type = passwordField.attr('type') === 'password' ? 'text' : 'password';
					passwordField.attr('type', type);
					// Toggle icon class
					$(this).find('i').toggleClass('fa-eye fa-eye-slash');
				});
			});
		</script>
	</body>
</html>
