@extends('layouts.customer_secondary')

@section('content')
    <!--Hero Section-->
    <div class="hero-section hero-background">
        <h1 class="page-title">Create an Account</h1>
    </div>

    <!--Navigation section-->
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12"></div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <nav class="biolife-nav">
                    <ul>
                        <li class="nav-item"><a href="index-2.html" class="permal-link">Home</a></li>
                        <li class="nav-item"><span class="perma-link">Authentication</span></li>
                        <li class="nav-item"><span class="current-page">Register</span></li>
                    </ul>
                </nav>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12"></div>
        </div>
    </div>


    <div class="page-contain login-page">
        <!-- Main content -->
        <div id="main-content" class="main-content">
            <div class="container">

                <div class="row" id="step1Container">
                    <div class="col-md-6 col-md-offset-3">
                        <div class="panel panel-default">
                            <div class="panel-heading custom-panel-heading">
                                Step 1: Enter Mobile Number
                            </div>
                            <div class="panel-body custom-panel-body">
                                <form id="step1Form">
                                    <div class="form-group">
                                        <label for="mobile" class="custom-label">Mobile Number</label>
                                        <input type="tel" class="form-control custom-input" id="mobile"
                                            name="mobile" required>
                                        <span id="mobileError" class="error-message"></span>
                                    </div>
                                    <button type="button" class="btn btn-thin btn-block" id="verifyMobileBtn">SEND OTP</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row" id="step2Container" style="display: none;">
                    <div class="col-md-6 col-md-offset-3">
                        <div class="panel panel-default">
                            <div class="panel-heading custom-panel-heading">
                                Step 2: Verify Mobile Number
                            </div>
                            <div class="panel-body custom-panel-body">
                                <form id="step2Form">
                                    <div class="form-group">
                                        <label class="custom-label">Enter Verification Code:</label>
                                        <div class="verification-input">
                                            <input type="tel" maxlength="1"
                                                class="form-control custom-verification-input" id="digit1"
                                                data-next="digit2" required>
                                            <input type="tel" maxlength="1"
                                                class="form-control custom-verification-input" id="digit2"
                                                data-next="digit3" data-prev="digit1" required>
                                            <input type="tel" maxlength="1"
                                                class="form-control custom-verification-input" id="digit3"
                                                data-next="digit4" data-prev="digit2" required>
                                            <input type="tel" maxlength="1"
                                                class="form-control custom-verification-input" id="digit4"
                                                data-next="digit5" data-prev="digit3" required>
                                            <input type="tel" maxlength="1"
                                                class="form-control custom-verification-input" id="digit5"
                                                data-next="digit6" data-prev="digit4" required>
                                            <input type="tel" maxlength="1"
                                                class="form-control custom-verification-input" id="digit6"
                                                data-prev="digit5" required>
                                        </div>

                                        <p class="resend-code">
                                            Didn't receive the code?
                                            <span id="countdownText"></span>
                                        </p>
                                    </div>
                                    <button type="button" class="btn btn-thin btn-block"
                                        id="continueToStep3Btn">Continue</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row" id="step3Container" style="display: none;">
                    <div class="col-md-6 col-md-offset-3">
                        <div class="panel panel-default">
                            <div class="panel-heading custom-panel-heading">
                                Step 3: Set Password
                            </div>
                            <div class="panel-body custom-panel-body">
                                <form id="step3Form" action="{{ route('register') }}" name="frm-login" method="post">
                                    @csrf
                                    <input type="text" id="form-mobile" value="" name="mobile" hidden>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="first-name" class="custom-label">First Name</label>
                                            <input type="text" class="form-control custom-input" id="first-name"
                                                name="first-name" required>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="last-name" class="custom-label">Last Name</label>
                                            <input type="text" class="form-control custom-input" id="last-name"
                                                name="last-name" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="password" class="custom-label">Password</label>
                                        <input type="password" class="form-control custom-input" id="password"
                                            name="password" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="password-confirm" class="custom-label">Confirm Password</label>
                                        <input type="password" class="form-control custom-input" id="password-confirm"
                                            name="password_confirmation" required>
                                    </div>
                                    <button type="submit" class="btn btn-bold btn-block">Complete Registration</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/seller/vendors/toastify/toastify.css') }}">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .custom-panel-heading {
            background-color: #007bff;
            color: #ffffff;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }

        .custom-panel-body {
            border: none;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        .custom-label {
            font-weight: bold;
        }

        .custom-input {
            border-radius: 5px;
        }

        .custom-verification-input {
            text-align: center;
            padding: 0.5rem;
            font-size: 1.5rem;
            width: 5rem;
            margin: 0 0.25rem;
            border: 1px solid #ced4da;
            border-radius: 5px;
        }

        .verification-input {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .error-message {
            color: red;
        }
    </style>
@endsection

@section('scripts')
    <script src="{{ asset('assets/seller/vendors/toastify/toastify.js') }}"></script>
    <script>
        // Mobile Validation for Ajax
        function mobileVerificationWithOtp() {
            var enteredNumber = $('#mobile').val().trim();
            var numericNumber = enteredNumber.replace(/[^0-9+]/g, '');

            if (!numericNumber.startsWith('+639') || numericNumber.length !== 13) {
                $('#mobileError').text('Please enter a valid mobile number.');
            } else {
                // You can proceed with the verification process here
                // For example, show the next step in your form

                // Make an AJAX request to sendOtp function
                $.ajax({
                    url: `{{ route('mobile-sendOtp') }}`, // Replace with the actual URL
                    method: 'POST',
                    data: {
                        _token: `{{ csrf_token() }}`,
                        phone_number: numericNumber // Send the formatted mobile number
                    },
                    success: function(response) {
                        // Handle success, for example, show a success message
                        $("#step1Container").hide();
                        $("#step2Container").show();
                    },
                    error: function(xhr, status, error) {
                        // Handle error, for example, display an error message
                        alert(
                            'Error sending OTP. Please try again.'
                        ); // Change this according to your UI
                    }
                });
            }
        }

        function otpVerification() {
            var enteredNumber = $('#mobile').val().trim();
            var numericNumber = enteredNumber.replace(/[^0-9+]/g, '');
            let otpValue = "";
            $(".custom-verification-input").each(function() {
                otpValue += $(this).val();
            });

            if (!numericNumber.startsWith('+639') || numericNumber.length !== 13) {
                $('#mobileError').text('Please enter a valid mobile number.');
            } else {
                // You can proceed with the verification process here
                // For example, show the next step in your form

                // Make an AJAX request to sendOtp function
                $.ajax({
                    url: `{{ route('mobile-verifyOtp') }}`, // Replace with the actual URL
                    method: 'POST',
                    data: {
                        _token: `{{ csrf_token() }}`,
                        phone_number: numericNumber, // Send the formatted mobile number
                        otp: otpValue
                    },
                    success: function(response) {
                        // Handle success, for example, show a success message
                        $("#step2Container").hide();
                        $("#step3Container").show();
                        $('#form-mobile').val(numericNumber);
                        Toastify({
                            text: "OTP Verified Successfully",
                            duration: 3000,
                            close: true,
                            gravity: "top",
                            position: "center",
                            backgroundColor: "#4fbe87",
                        }).showToast();

                    },
                    error: function(xhr, status, error) {
                        if (xhr.status === 422) {
                            Toastify({
                                text: "Invalid OTP",
                                duration: 3000,
                                close: true,
                                gravity: "top",
                                position: "center",
                                backgroundColor: "#BE3F3F",
                            }).showToast();
                        }
                    }
                });
            }
        }

        // Mobile Validation
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

            $('#verifyMobileBtn').click(function() {
                var mobileNumber = $('#mobile').val();
                $.ajax({
                    type: 'POST',
                    url: `{{ route('mobile.unique.check') }}`,
                    data: {
                        _token: `{{ csrf_token() }}`,
                        mobileNumber: mobileNumber
                    },
                    success: function(response) {
                        if (response.status === 'exists') {
                            // Redirect to the login page if the user already exists
                            alert('Mobile Number Already Exists');
                            window.location.href = `{{ route('login') }}`;
                        } else {
                            // Proceed with mobile verification if the user doesn't exist
                            mobileVerificationWithOtp();
                        }
                    },
                    error: function(error) {
                        console.error('Error:', error);
                    }
                });
            });
        });

        // OTP Validation
        $(document).ready(function() {
            $("#continueToStep3Btn").click(function() {
                // Move to step 3 after verifying mobile number
                otpVerification();
            });
        })

        // OTP Resend Countdown
        $(document).ready(function() {
            let countdown = 60;
            let countdownInterval;

            function startCountdown() {
                $("#resendBtn").prop("disabled", true);
                $("#countdownText").html(`Resend in <span id="countdown">${countdown}</span> seconds`);

                countdownInterval = setInterval(function() {
                    countdown--;
                    $("#countdown").text(countdown);
                    if (countdown === 0) {
                        clearInterval(countdownInterval);
                        $("#resendBtn").text("Resend");
                        $("#countdownText").html('<a href="#" id="resendLink">click here to resend</a>');
                        $("#resendBtn").prop("disabled", false);
                    }
                }, 1000);
            }

            function resetCountdown() {
                countdown = 60;
                startCountdown();
            }

            $(document).on("click", "#resendLink", function(e) {
                e.preventDefault();
                mobileVerificationWithOtp();
                resetCountdown();
                // Replace this with your code to send a new verification code
                // For example, you can use an AJAX request to your server here
            });

            startCountdown();
        });

        // Custom Verification Input Auto Next or Prev
        $(document).ready(function() {
            const inputs = $(".custom-verification-input");

            inputs.on("input", function() {
                const value = $(this).val();

                if (value.length === 1) {
                    const nextInput = $(this).next(".custom-verification-input");
                    if (nextInput.length > 0) {
                        nextInput.focus();
                    }
                }

                if (value.length === 0) {
                    const prevInput = $(this).prev(".custom-verification-input");
                    if (prevInput.length > 0) {
                        prevInput.focus();
                    }
                }
            });
        });
    </script>
@endsection
