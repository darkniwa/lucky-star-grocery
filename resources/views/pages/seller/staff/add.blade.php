@extends('layouts.seller')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Staff Management</h3>
                    <p class="text-subtitle text-muted">Efficiently manage your team of staff members. Add, edit, or remove
                        staff with ease and assign them appropriate roles for better organization and control.</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('index') }}">Dashboard</a></li>
                            <li class="breadcrumb-item" aria-current="page"><a href="{{ route('staff.index') }}">Staff
                                    Management</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Add</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="page-content">
        <section class="section">
            <div class="row">
                <!-- Existing Add Staff Card -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h1 class="card-title">Add Staff</h1>
                            <form action="{{ route('staff.store') }}" method="POST">
                                @csrf
                                <!-- Display validation errors -->
                                @if (session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="first_name" class="form-label">First Name</label>
                                            <input type="text" class="form-control" id="first_name" name="first_name"
                                                required placeholder="Enter First Name" value="{{ old('first_name') }}">
                                            <!-- Use old('input_name') to populate input fields with previous user input -->
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="last_name" class="form-label">Last Name</label>
                                            <input type="text" class="form-control" id="last_name" name="last_name"
                                                required placeholder="Enter Last Name" value="{{ old('last_name') }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="mobile" class="form-label">Mobile</label>
                                    <input type="text" class="form-control" id="mobile" name="mobile" required
                                        placeholder="Enter Mobile Number" value="{{ old('mobile') }}">
                                </div>

                                <div class="mb-3">
                                    <label for="roles" class="form-label">Select Role</label>
                                    <select class="form-select" id="roles" name="roles[]" multiple required>
                                        <option value="manager"
                                            {{ in_array('manager', old('roles', [])) ? 'selected' : '' }}>Manager</option>
                                        <option value="cashier"
                                            {{ in_array('cashier', old('roles', [])) ? 'selected' : '' }}>Cashier</option>
                                        <option value="courier"
                                            {{ in_array('courier', old('roles', [])) ? 'selected' : '' }}>Courier</option>
                                        <option value="promodiser"
                                            {{ in_array('promodiser', old('roles', [])) ? 'selected' : '' }}>Promodiser
                                        </option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="password" name="password" required
                                            placeholder="Enter Password" value="{{ old('password') }}">
                                        <button class="btn btn-outline-secondary" type="button" id="togglePasswordBtn">
                                            <i class="bi bi-eye-slash"></i>
                                        </button>
                                        <button class="btn btn-outline-secondary" type="button"
                                            id="generatePasswordBtn">Generate</button>
                                        <button class="btn btn-outline-secondary" type="button"
                                            id="copyPasswordBtn">Copy</button>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success">Add Staff</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- New Card for Sending Invite Links -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h1 class="card-title">Send Invite Link</h1>
                            <form action="#" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" class="form-control" id="email" name="email" required
                                        placeholder="Enter Email Address">
                                </div>
                                <div class="mb-3">
                                    <label for="invite_roles" class="form-label">Select Role</label>
                                    <select class="form-select" id="invite_roles" name="invite_roles[]" multiple
                                        required>
                                        <option value="manager">Manager</option>
                                        <option value="cashier">Cashier</option>
                                        <option value="courier">Courier</option>
                                        <option value="promodiser">Promodiser</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Send Invite</button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/seller/vendors/toastify/toastify.css') }}">
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('assets/seller/vendors/toastify/toastify.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#roles').select2();
            $('#invite_roles').select2();
        });

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

        $(document).ready(function() {
            const passwordInput = $('#password');
            const togglePasswordBtn = $('#togglePasswordBtn');
            const generatePasswordBtn = $('#generatePasswordBtn');
            const copyPasswordBtn = $('#copyPasswordBtn');
            let passwordVisible = false;

            // Toggle password visibility
            togglePasswordBtn.click(function() {
                passwordVisible = !passwordVisible;
                passwordInput.attr('type', passwordVisible ? 'text' : 'password');
                togglePasswordBtn.html(passwordVisible ? '<i class="bi bi-eye"></i>' :
                    '<i class="bi bi-eye-slash"></i>');
            });

            // Generate a random password
            generatePasswordBtn.click(function() {
                const randomPassword =
                    generateRandomPassword(); // Implement your password generation logic here
                passwordInput.val(randomPassword);
            });

            // Copy password to clipboard
            copyPasswordBtn.click(function() {
                const passwordText = passwordInput.val();
                if (passwordText) {
                    const tempInput = $('<input>');
                    $('body').append(tempInput);
                    tempInput.val(passwordText).select();
                    document.execCommand('copy');
                    tempInput.remove();

                    // Create a Toastify notification
                    Toastify({
                        text: "Password copied to clipboard",
                        duration: 3000, // Duration in milliseconds
                        close: true,
                        gravity: "top", // Position: "top", "bottom", "center"
                    }).showToast();
                }
            });

            // Function to generate a random password (You can customize this)
            function generateRandomPassword(length = 12) {
                const charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789@";
                const passwordArray = [];

                for (let i = 0; i < length; i++) {
                    const randomIndex = Math.floor(Math.random() * charset.length);
                    const randomChar = charset.charAt(randomIndex);
                    passwordArray.push(randomChar);
                }

                return passwordArray.join('');
            }
        });
    </script>
@endsection
