<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <title>Navadarshana Education Portal Login</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="keywords"
        content="Navadarshana">
    <meta name="author" content="Cybernetics">
    <meta name="robots" content="index, follow">
    <meta name="viewport"
        content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, minimal-ui, viewport-fit=cover">
    <meta name="description"
        content="Navadarshana">
    <meta property="og:title" content="Navadarshana Educations">
    <meta property="og:description"
        content="Navadarshana">
    <meta property="og:image" content="">
    <meta name="format-detection" content="telephone=no">

    <!-- FAVICONS ICON -->
    <link rel="shortcut icon" type="image/png" href="{{ asset('/assets/images/favicon.png') }}">
    <link href="{{ asset('/assets/vendor/bootstrap-select/dist/css/bootstrap-select.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/assets/css/style.css') }}" rel="stylesheet">

</head>

<body class="vh-100">
    <div class="authincation h-100">
        <div class="container-fluid h-100">
            <div class="row h-100">
                <div class="col-lg-6 col-md-12 col-sm-12 mx-auto align-self-center">
                    <div class="login-form">
                        <div class="text-center">
                            <img src="{{ asset('/assets/images/logo-full.png') }}" class="mb-3 login-sm-logo mx-auto" alt="">
                            <h3 class="title">Sign In</h3>
                            <p>Sign in to your account to start using Navadarshana Portal</p>
                        </div>
                        {{ html()->form('POST', route('login'))->open() }}
                        <div class="mb-4">
                            <label class="mb-1">Email<span class="text-danger"> *</span></label>
                            {{ html()->email('email')->class('form-control')->placeholder('Email') }}
                            @error('email')
                            <small class="text-danger">{{ $errors->first('email') }}</small>
                            @enderror
                        </div>
                        <div class="mb-4 position-relative">
                            <label class="mb-1">Password<span class="text-danger"> *</span></label>
                            {{ html()->password('password')->attribute('id', 'dz-password')->class('form-control form-control')->placeholder('******') }}
                            <span class="show-pass eye">
                                <i class="fa fa-eye-slash"></i>
                                <i class="fa fa-eye"></i>
                            </span>
                            @error('password')
                            <small class="text-danger">{{ $errors->first('password') }}</small>
                            @enderror
                        </div>
                        <div class="text-center mb-4 d-grid">
                            {{ html()->submit('Sign In')->class('btn btn-primary btn-submit') }}
                        </div>
                        @if(session()->has('success'))
                        <div class="text-center mb-4 d-grid">
                            <p class="text-success">{{ session()->get('success') }}</p>
                        </div>
                        @endif
                        <h6 class="login-title"><span class="px-3">Or continue with</span></h6>

                        <div class="mb-3">
                            <ul class="d-flex align-self-center justify-content-center">
                                <li><a target="_blank" href="https://www.facebook.com/"
                                        class="fab fa-facebook-f btn-facebook"></a></li>
                                <li><a target="_blank" href="https://www.google.com/"
                                        class="fab fa-google-plus-g btn-google-plus mx-2"></a></li>
                                <li><a target="_blank" href="https://www.linkedin.com/"
                                        class="fab fa-linkedin-in btn-linkedin me-2"></a></li>
                                <li><a target="_blank" href="https://twitter.com/"
                                        class="fab fa-twitter btn-twitter"></a></li>
                            </ul>
                        </div>
                        <p class="text-center">Not registered?
                            <a class="btn-link text-primary" href="#">Register</a>
                        </p>
                        {{ html()->form()->close() }}
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6">
                    <div class="pages-left h-100">
                        <div class="login-content">
                            <a href="{{ route('login') }}"><img src="{{ asset('/assets/images/logo-black.png') }}" class="mb-3" alt=""></a>
                            <p>NAVADARSHANA EDUCATIONS</p>
                        </div>
                        <!--<div class="login-media text-center">
                            <img src="{{ asset('/assets/images/login.webp') }}" alt="">
                        </div>-->
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!--**********************************
	Scripts
***********************************-->
    <!-- Required vendors -->
    <script src="{{ asset('/assets/vendor/global/global.min.js') }}"></script>

    <script src="{{ asset('/assets/vendor/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('/assets/js/deznav-init.js') }}"></script>
    <script src="{{ asset('/assets/js/custom.js') }}"></script>
    <script>
        $(function() {
            "use strict"
            $('form').submit(function() {
                $(this).find(".btn-submit").attr("disabled", true);
                $(this).find(".btn-submit").html("Authenticating...<span class='spinner-border spinner-border-sm' role='status' aria-hidden='true'></span>");
            });
        });
    </script>
</body>

</html>