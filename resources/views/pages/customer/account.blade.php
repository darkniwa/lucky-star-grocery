@extends('layouts.customer_secondary')
@section('content')
    <!--Hero Section-->
    <div class="hero-section hero-background">
        <h1 class="page-title">Account Settings</h1>
    </div>

    <!--Navigation section-->
    <div class="container">
        <nav class="biolife-nav">
            <ul>
                <li class="nav-item"><a href="{{ route('home') }}" class="permal-link">Home</a></li>
                <li class="nav-item"><span class="perma-link">Account</span></li>
                <li class="nav-item"><span class="current-page">Personal Information</span></li>
            </ul>
        </nav>
    </div>

    <div class="page-contain login-page">

        <!-- Main content -->
        <div id="main-content" class="main-content">

            {{-- <div class="container">
                <div class="card split-card">
                    <div class="row no-gutters">
                        <div class="col-md-4 dark-background">
                            <div class="card-body dark-card">
                                <h2 class="card-title text-center"><strong>Personal Information</strong></h2>
                                <p class="card-text text-center">This information is used for shipping purposes and will be kept secure and confidential.</p>
                            </div>
                        </div>
                        <div class="col-md-8 light-background">
                            <div class="card-body">
                                <form action="{{ route('account.update') }}" name="frm-profile" method="post">
                                    <input type="text" hidden value="form-profile" name="form">
                                    <!-- Personal info form fields here -->
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                        <div class="signin-container">
                                            <p class="form-row">
                                                <label for="first_name">First Name:</label>
                                                <input id="first_name" type="text" @error('first_name') is-invalid @enderror"
                                                    name="first_name" value="{{ Auth::user()->getCustomerRelation->first_name }}"
                                                    required autocomplete="first_name" autofocus class="txt-input">
                                                @error('first_name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                        <div class="signin-container">
                                            <p class="form-row">
                                                <label for="middle_name">Middle Name:</label>
                                                <input id="middle_name" type="text" @error('middle_name') is-invalid @enderror"
                                                    name="middle_name" value="{{ Auth::user()->getCustomerRelation->middle_name }}"
                                                    autocomplete="middle_name" autofocus class="txt-input">
                                                @error('middle_name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                        <div class="signin-container">
                                            <p class="form-row">
                                                <label for="last_name">Last Name:</label>
                                                <input id="last_name" type="text" @error('last_name') is-invalid @enderror"
                                                    name="last_name" value="{{ Auth::user()->getCustomerRelation->last_name }}"
                                                    required autocomplete="last_name" autofocus class="txt-input">
                                                @error('last_name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </p>
        
                                        </div>
                                    </div>
                                    <!-- Add more form fields as needed -->
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
             --}}

            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <!--Form My Profile-->
                        <form action="{{ route('account.update') }}" name="frm-profile" method="post">
                            @csrf
                            <center>
                                <h3>My Profile</h3>
                            </center>
                            <hr>
                            <input type="text" hidden value="form-profile" name="form">

                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <div class="signin-container">
                                    <p class="form-row">
                                        <label for="first_name">First Name:</label>
                                        <input id="first_name" type="text" @error('first_name') is-invalid @enderror"
                                            name="first_name" value="{{ Auth::user()->getCustomerRelation->first_name }}"
                                            required autocomplete="first_name" autofocus class="txt-input">
                                        @error('first_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </p>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <div class="signin-container">
                                    <p class="form-row">
                                        <label for="middle_name">Middle Name:</label>
                                        <input id="middle_name" type="text" @error('middle_name') is-invalid @enderror"
                                            name="middle_name" value="{{ Auth::user()->getCustomerRelation->middle_name }}"
                                            autocomplete="middle_name" autofocus class="txt-input">
                                        @error('middle_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </p>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <div class="signin-container">
                                    <p class="form-row">
                                        <label for="last_name">Last Name:</label>
                                        <input id="last_name" type="text" @error('last_name') is-invalid @enderror"
                                            name="last_name" value="{{ Auth::user()->getCustomerRelation->last_name }}"
                                            required autocomplete="last_name" autofocus class="txt-input">
                                        @error('last_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </p>

                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="signin-container">
                                    <p class="form-row">
                                        <label for="email">Email:
                                            @if (Auth::user()->email_verified_at)
                                                <code class="verified-code">Verified</code>
                                            @else
                                                <code class="not-verified-code">Not Verified</code>
                                            @endif
                                        </label>
                                        <input id="email" type="text"
                                            @error('email') 
                                        is-invalid @enderror"
                                            name="email" value="{{ Auth::user()->email }}" autocomplete="email" autofocus
                                            class="txt-input" @if(Auth::user()->email_verified_at) disabled @endif>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </p>

                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="signin-container">
                                    <p class="form-row">
                                        <label for="mobile">Mobile No:
                                            @if (Auth::user()->mobile_verified_at)
                                                <code class="verified-code">Verified</code>
                                            @else
                                                <code class="not-verified-code">Not Verified</code>
                                            @endif
                                        </label>
                                        <input id="mobile" type="text" @error('mobile') is-invalid @enderror"
                                            name="mobile" value="{{ Auth::user()->mobile }}" required
                                            autocomplete="mobile" autofocus class="txt-input" @if(Auth::user()->mobile_verified_at) disabled @endif>
                                        @error('mobile')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </p>

                                </div>
                            </div>
                            <br />
                            <div class="col-lg-12 col-md-2 col-sm-12 col-xs-12">
                                <div class="signin-container register-in-container">
                                    <center>
                                        <p class="form-row wrap-btn">
                                            <button class="btn btn-success btn-bold" type="submit">Save Profile</button>
                                            <br /><br />
                                        </p>
                                    </center>
                                </div>
                            </div>
                        </form>

                    </div>

                    <div class="col-md-6">
                        <!--Form My Password-->
                        <form action="{{ route('account.update') }}" name="frm-password" method="post">
                            @csrf
                            <center>
                                <h3>Password</h3>
                            </center>
                            <hr>
                            <input type="text" hidden value="form-password" name="form">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="signin-container">
                                    <p class="form-row">
                                        <label for="current_password">Current Password:</label>
                                        <input id="current_password" type="password"
                                            @error('current_password') is-invalid @enderror" name="current_password"
                                            value="" required autocomplete="current_password" autofocus
                                            class="txt-input" placeholder="Current Password">
                                        @error('current_password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </p>

                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="signin-container">
                                    <p class="form-row">
                                        <label for="new_password">New Password: </label>
                                        <input id="new_password" type="password"
                                            @error('new_password') is-invalid @enderror" name="new_password" required
                                            autocomplete="new_password" autofocus class="txt-input"
                                            placeholder="New Password">
                                        @error('new_password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </p>

                                </div>
                            </div>

                            <br />
                            <div class="col-lg-12 col-md-2 col-sm-12 col-xs-12">
                                <div class="signin-container register-in-container">
                                    <center>
                                        <p class="form-row wrap-btn">
                                            <button class="btn btn-submit btn-bold" type="submit">Save
                                                Password</button><br /><br />
                                        </p>
                                    </center>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
