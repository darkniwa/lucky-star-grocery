@extends('layouts.customer_secondary')
@section('content')
    <!--Hero Section-->
    <div class="hero-section hero-background">
        <h1 class="page-title">Delivery Address</h1>
    </div>

    <!--Navigation section-->
    <div class="container">
        <nav class="biolife-nav">
            <ul>
                <li class="nav-item"><a href="{{ route('home') }}" class="permal-link">Home</a></li>
                <li class="nav-item"><span class="perma-link">Account</span></li>
                <li class="nav-item"><span class="current-page">Delivery Address</span></li>
            </ul>
        </nav>
    </div>

    <div class="page-contain login-page">

        <!-- Main content -->
        <div id="main-content" class="main-content">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-md-12 btn">
                        <a class="btn btn-default btn-block" type="button"
                            href="{{ route('address.create', ['source' => 'address']) }}"><i class="fa fa-plus"
                                aria-hidden="true"></i> Add Address</a>
                        <br>
                    </div>
                </div>
                <div class="row">

                    @if (Auth::user()->addresses->count() > 0)
                        @foreach (Auth::user()->addresses as $address)
                            <div class="col-xs-12 col-md-6">
                                <div class="panel panel-success">
                                    <div class="panel-heading">
                                        {{ ucfirst($address->label) }} Address

                                        <div class="pull-right">
                                            <form action="{{ route('address.delete', $address->id) }}" method="post">
                                                @csrf
                                                @method('delete')
                                                <!-- Other form fields for editing address -->
                                                <a href="{{ route('address.edit', ['id' => $address->id]) }}"
                                                    class="btn btn-xs btn-warning">
                                                    Edit
                                                </a>
                                                <button type="submit" class="btn btn-xs btn-danger">Remove</button>
                                            </form>
                                           
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <p class="form-row">
                                            <label for="{{ $address->label }}" class="checkout_form_label">
                                                {{ $address->getFormattedAddress() }}
                                            </label>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p>No addresses found.</p>
                    @endif


                    {{-- <!--Form My Address-->
                    <form action="{{ route('account.update') }}" name="frm-address" method="post">
                        @csrf
                        <center>
                            <h3>My Address</h3>
                        </center>
                        <hr>
                        <input type="text" hidden value="form-address" name="form">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="signin-container">
                                <p class="form-row">
                                    <label for="homeAddress">Home Address:</label>
                                    <input id="homeAddress" type="text" @error('homeAddress') is-invalid @enderror"
                                        name="homeAddress"
                                        value="{{ Auth::user()->homeAddress ? Auth::user()->homeAddress->getFormattedAddress() : '' }}"
                                        required autocomplete="homeAddress" autofocus class="txt-input" disabled>
                                    @error('homeAddress')
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
                                            Address</button><br /><br />
                                    </p>
                                </center>
                            </div>
                        </div>
                    </form> --}}

                </div>




            </div>

        </div>

    </div>
@endsection
