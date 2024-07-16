@extends('layouts.seller-auth')
@section('content')
    <div id="auth">
        <div class="row h-100">
            <div class="col-lg-5 col-12">
                <div id="auth-left">
                    <div class="auth-logo">
                    </div>
                    <h1 class="auth-title">Log in.</h1>
                    <p class="auth-subtitle mb-5">Log in with your data that you entered during registration.</p>
                    <form action="{{ route('google.login.seller') }}" method="get">
                        <button class="btn btn-lg btn-block btn-primary" style="background-color: #dd4b39;" type="submit">
                            <i class="fab fa-google me-2"></i> Sign in with Google
                        </button>
                    </form>
                    <hr class="my-4">
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    <form action="{{ route('login') }}" name="frm-login" method="post">
                        @csrf
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="text" id="mobile" class="form-control form-control-xl" placeholder="Phone No"
                                name="mobile" value="{{ old('mobile') }}" autocomplete="tel">
                            <div class="form-control-icon">
                                <i class="bi bi-person"></i>
                            </div>
                            @error('mobile')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="password" class="form-control form-control-xl" placeholder="Password"
                                name="password" autocomplete="current-password">
                            <div class="form-control-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-check form-check-lg d-flex align-items-end">
                            <input class="form-check-input me-2" type="checkbox" value="" id="flexCheckDefault"
                                name="remember" >
                            <label class="form-check-label text-gray-600" for="flexCheckDefault">
                                Keep me logged in
                            </label>
                        </div>
                        <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5" type="submit">Log in</button>
                    </form>

                    {{-- <div class="text-center mt-5 text-lg fs-4">
                        <p><a class="font-bold" href="auth-forgot-password.html">Forgot password?</a></p>
                    </div> --}}
                </div>
            </div>
            <div class="col-lg-7 d-none d-lg-block">
                <div id="auth-right"
                    style="background: url({{ asset('assets/seller/images/bg/bg-store.jpg') }}),linear-gradient(90deg,#2d499d,#3f5491); background-size: cover; background-repeat: no-repeat; background-position: center;">
                </div>
            </div>
        </div>

    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(document).ready(function() {
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
        });
    </script>
@endsection
