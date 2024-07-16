@extends('layouts.customer_secondary')

@section('content')
    <!--Hero Section-->
    <div class="hero-section hero-background">
        <h1 class="page-title">Login To Your Account</h1>
    </div>

    <!--Navigation section-->
    <div class="container">
        <nav class="biolife-nav">
            <ul>
                <li class="nav-item"><a href="{{ route('home') }}" class="permal-link">Home</a></li>
                <li class="nav-item"><span class="permal-link">Authentication</span></li>
                <li class="nav-item"><span class="current-page">Login</span></li>
            </ul>
        </nav>
    </div>

    <div class="page-contain login-page">

        <!-- Main content -->
        <div id="main-content" class="main-content">
            <div class="container">

                <div class="row">

                    <!--Form Sign In-->
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="signin-container">
                            @if (session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif
                            <form action="{{ route('login') }}" name="frm-login" method="post">
                                @csrf
                                <p class="form-row">
                                    <label for="fid-name">Phone No:<span class="requite">*</span></label>
                                    <input id="mobile" type="text" @error('mobile') is-invalid @enderror"
                                        name="mobile" value="{{ old('mobile') }}" required autocomplete="mobile" autofocus
                                        class="txt-input">
                                    <span id="mobileError" class="invalid-feedback" role="alert"></span>
                                    @error('mobile')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </p>
                                <p class="form-row">
                                    <label for="fid-pass">Password:<span class="requite">*</span></label>
                                    <input id="password" type="password" @error('password') is-invalid @enderror"
                                        name="password" required autocomplete="current-password" class="txt-input">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </p>
                                <p class="form-row wrap-btn">
                                    <button class="btn btn-submit btn-bold" type="submit">sign in</button>
                                    <a href="#" class="link-to-help">Forgot your password</a>
                                </p>
                            </form>
                            <hr>
                            <form action="{{ route('google.login') }}" name="frm-login-google" method="get">
                                <p class="form-row wrap-btn">
                                    <button class="btn btn-submit btn-danger btn-google-login" type="submit"><i
                                            class="fa fa-google"> </i> Login with Google</button>
                                </p>
                            </form>
                        </div>
                    </div>

                    <!--Go to Register form-->
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="register-in-container">
                            <div class="intro">
                                <h4 class="box-title">New Customer?</h4>
                                <p class="sub-title">Create an account with us and you’ll be able to:</p>
                                <ul class="lis">
                                    <li>Check out faster</li>
                                    <li>Save multiple shipping address</li>
                                    <li>Access your order history</li>
                                    <li>Track new orders</li>
                                    <li>Save items to your Wishlist</li>
                                </ul>
                                <a href="/register" class="btn btn-bold">Create an account</a>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>
@endsection

@section('styles')
    <style src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" type="stylesheet"></style>
    <style>
        #mobileError {
            color: red;
        }
    </style>
@endsection

@section('scripts')
    <script>
        $('#mobile').on('input', function() {
            $('#mobileError').text('');

            var enteredNumber = $(this).val().trim();
            var numericNumber = enteredNumber.replace(/\D/g, '');

            if (numericNumber.startsWith('09') && numericNumber.length === 11) {
                var formattedNumber = '+63' + numericNumber.substr(1);
                $(this).val(formattedNumber);
            } else {
                $(this).val(enteredNumber);
            }
        });

        $('#mobile').on('focusout', function() {
            var enteredNumber = $('#mobile').val().trim();
            var numericNumber = enteredNumber.replace(/[^0-9+]/g, '');

            if (numericNumber !== "") {
                if (!numericNumber.startsWith('+639') || numericNumber.length !== 13) {
                    $('#mobileError').text('Please enter a valid mobile number.');
                }
            }
        });
    </script>
@endsection
