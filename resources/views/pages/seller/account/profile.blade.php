@extends('layouts.seller')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Profile Settings</h3>
                    <p class="text-subtitle text-muted">Customize and manage your profile information. Update your basic
                        details and preferences to ensure your account is up to date and personalized to your needs.
                    </p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('index') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">My Profile</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="page-content">
        <section class="section">
            <div class="container-fluid">
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
                        <form action="{{ route('account.profile.update') }}" name="form-basic-information" method="POST">
                            @csrf
                            <input type="hidden" name="form_type" value="basic_information">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Basic Information</h5>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="FirstName">First Name</label>
                                                    <input type="text" class="form-control" id="FirstName"
                                                        placeholder="Enter your first name" name="FirstName"
                                                        value="{{ Auth::user()->staff->first_name }}" disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="LastName">Last Name</label>
                                                    <input type="text" class="form-control" id="LastName"
                                                        placeholder="Enter your last name" name="LastName"
                                                        value="{{ Auth::user()->staff->last_name }}" disabled>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="EmailAddress">Email</label>
                                                    <input type="text"
                                                        class="form-control {{ Auth::user()->email_verified_at != null ? 'is-valid' : '' }}"
                                                        id="EmailAddress" placeholder="Enter your email" name="EmailAddress"
                                                        value="{{ Auth::user()->email }}" disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="mobile">Contact No.</label>
                                                    <div class="input-group mb-3">
                                                        <input type="text"
                                                            class="form-control {{ Auth::user()->mobile_verified_at != null ? 'is-valid' : '' }}"
                                                            id="mobile" placeholder="Mobile Number" name="mobile"
                                                            value="{{ Auth::user()->mobile }}" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="card-footer text-center">
                                    <button type="button" class="btn btn-primary edit-btn">Edit</button>
                                    <button type="button" class="btn btn-secondary cancel-btn" hidden>Cancel</button>
                                    <button type="submit" class="btn btn-primary save-btn" hidden>Save</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="col-md-6">
                        <form action="{{ route('account.profile.update') }}" name="form-additional-information"
                            method="POST">
                            @csrf
                            <input type="hidden" name="form_type" value="additional_information">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Additional Information</h5>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="Gender">Gender</label>
                                            <select class="form-select" id="Gender" name="Gender" disabled>
                                                <option value="0" disabled
                                                    {{ Auth::user()->staff->gender == null ? 'selected' : '' }}>
                                                    Choose ...</option>
                                                <option value="Male"
                                                    {{ Auth::user()->staff->gender == 'Male' ? 'selected' : '' }}>
                                                    Male</option>
                                                <option value="Female"
                                                    {{ Auth::user()->staff->gender == 'Female' ? 'selected' : '' }}>
                                                    Female</option>
                                                <option value="Prefer not to say"
                                                    {{ Auth::user()->staff->gender == 'Prefer not to say' ? 'selected' : '' }}>
                                                    Prefer not to say</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-center">
                                    <button type="button" class="btn btn-primary edit-btn">Edit</button>
                                    <button type="button" class="btn btn-secondary cancel-btn" hidden>Cancel</button>
                                    <button type="submit" class="btn btn-primary save-btn" hidden>Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('scripts')
    <script>
        // Enable or disable inputs and buttons when editing or canceling
        $('.edit-btn').click(function() {
            const form = $(this).closest('form');

            // Store the original values in data attributes
            form.find(':input').each(function() {
                const input = $(this);
                input.data('original-value', input.val());

                // Check if the input is for "mobile" or "email" and if it's verified
                if ((input.attr('name') === 'mobile' || input.attr('name') === 'EmailAddress') && input
                    .hasClass('is-valid')) {
                    input.prop('disabled', true); // Keep it disabled
                } else {
                    input.prop('disabled', false); // Enable for editing
                }
            });

            form.find('.edit-btn').prop('hidden', true);
            form.find('.cancel-btn').prop('hidden', false);
            form.find('.save-btn').prop('hidden', false);
        });


        $('.cancel-btn').click(function() {
            const form = $(this).closest('form');
            form.find(':input').each(function() {
                // Reset the fields to their original values
                $(this).val($(this).data('original-value'));
            });
            form.find(':input').prop('disabled', true);
            form.find('.edit-btn').prop('hidden', false);
            form.find('.edit-btn').prop('disabled', false);
            form.find('.save-btn, .cancel-btn').prop('hidden', true);
        });

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
