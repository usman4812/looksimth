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
                        Add User
                    </h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">

                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.users') }}" class="text-muted text-hover-primary">Users</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-gray-900">Add</li>
                    </ul>
                </div>
            </div>
        </div>
        <!--begin::Content-->
        <div id="kt_app_content" class="app-content  flex-column-fluid ">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.user.edit', $user) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('post')
                        <div class="card-body">
                            <div class="row mb-6">
                                <label class="col-lg-4 col-form-label fw-semibold fs-6">Avatar</label>
                                <div class="col-lg-8">
                                    <div class="image-input image-input-outline" data-kt-image-input="true">
                                        <div class="image-input-wrapper w-125px h-125px"
                                            style="background-image: url('{{ asset('storage/public/web_assets/media/avatars/' . ($user->avatar ?? 'blank.png')) }}')">
                                        </div>
                                        <label
                                            class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                            data-kt-image-input-action="change" data-bs-toggle="tooltip"
                                            aria-label="Change avatar" data-bs-original-title="Change avatar"
                                            data-kt-initialized="1">
                                            <i class="ki-outline ki-pencil fs-7"></i>
                                            <input type="file" name="avatar" accept=".png, .jpg, .jpeg">
                                            <input type="hidden" name="avatar_remove">
                                        </label>
                                        <span
                                            class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                            data-kt-image-input-action="cancel" data-bs-toggle="tooltip"
                                            aria-label="Cancel avatar" data-bs-original-title="Cancel avatar"
                                            data-kt-initialized="1">
                                            <i class="ki-outline ki-cross fs-2"></i> </span>
                                        <span
                                            class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                            data-kt-image-input-action="remove" data-bs-toggle="tooltip"
                                            aria-label="Remove avatar" data-bs-original-title="Remove avatar"
                                            data-kt-initialized="1">
                                            <i class="ki-outline ki-cross fs-2"></i> </span>
                                    </div>
                                    <div class="form-text">Allowed file types: png, jpg, jpeg.</div>
                                </div>
                            </div>
                            <div class="row mb-6">
                                <label class="required col-lg-4 col-form-label fw-semibold fs-6">Full Name</label>
                                <div class="col-lg-8">
                                    <div class="row">
                                        <div class="col-lg-6 fv-row">
                                            <input type="text" required name="fname"
                                                class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                placeholder="First name" value="{{ $user->fname }}" />
                                            @error('fname')
                                                <div class="fv-plugins-message-container invalid-feedback">{{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-lg-6 fv-row">
                                            <input type="text" name="lname" value="{{ $user->lname }}"
                                                class="form-control form-control-lg form-control-solid"
                                                placeholder="Last name" />
                                            @error('lname')
                                                <div class="fv-plugins-message-container invalid-feedback">{{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-6">
                                <label class="required col-lg-4 col-form-label  fw-semibold fs-6">Email</label>
                                <div class="col-lg-8 fv-row fv-plugins-icon-container">
                                    <input type="email" required name="email"
                                        class="form-control form-control-lg form-control-solid" value="{{ $user->email }}"
                                        placeholder="Email Address">
                                    @error('email')
                                        <div class="fv-plugins-message-container invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-6">
                                <label class="required col-lg-4 col-form-label fw-semibold fs-6">Password</label>
                                <div class="col-lg-8 fv-row">
                                    <div class="position-relative mb-3">
                                        <input type="password" name="password" required
                                            value="{{ @$formData['password'] }}"
                                            class="form-control form-control-lg form-control-solid" minlength="6"
                                            maxlength="8" id="passwordInput">
                                        <button type="button"
                                            class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2"
                                            id="togglePassword">
                                            <i class="ki-outline ki-eye-slash fs-2"></i>
                                            <i class="ki-outline ki-eye fs-2 d-none"></i>
                                        </button>
                                    </div>
                                    @error('password')
                                        <div class="fv-plugins-message-container invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-6">
                                <label class="required col-lg-4 col-form-label  fw-semibold fs-6">Role</label>
                                <div class="col-lg-8 fv-row">
                                    <select name="role_id" aria-label="Select a Role" data-placeholder="Select a role..."
                                        class="form-select form-select-solid form-select-lg form-control" required>
                                        <option value="">Select a Role...</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}" @if ($user->roles->contains('id', $role->id)) selected @endif>{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('role_id')
                                        <div class="fv-plugins-message-container invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-6">
                                <label class="col-lg-4 col-form-label  fw-semibold fs-6">Active</label>
                                <div class="col-lg-8 fv-row fv-plugins-icon-container fv-plugins-bootstrap5-row-valid">
                                    <div class="d-flex align-items-center mt-3">
                                        <label
                                            class="form-check form-check-custom form-check-inline form-check-solid me-5 is-valid">
                                            <input class="form-check-input" name="status" type="checkbox"
                                                value="1" data-gtm-form-interact-field-id="1"
                                                {{ $user->status == 1 ? 'checked=""' : '' }}>
                                            <span class="fw-semibold ps-2 fs-6">
                                                Active
                                            </span>
                                            <div class="fs-6 text-gray-700 pe-7">Check this box to enable/disable access
                                            </div>
                                        </label>
                                    </div>
                                    <div
                                        class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end py-6 px-9">
                            <button type="submit" class="btn btn-sm btn-primary">Update</button>
                        </div>
                        <input type="hidden">
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#togglePassword').on('click', function() {
            const passwordInput = $('#passwordInput');
            const eyeSlashIcon = $(this).find('.ki-eye-slash');
            const eyeIcon = $(this).find('.ki-eye');
            // Toggle password visibility
            if (passwordInput.attr('type') === 'password') {
                passwordInput.attr('type', 'text'); 
                eyeSlashIcon.addClass('d-none'); 
                eyeIcon.removeClass('d-none'); 
            } else {
                passwordInput.attr('type', 'password'); 
                eyeSlashIcon.removeClass('d-none'); 
                eyeIcon.addClass('d-none'); 
            }
        });
    });
</script>