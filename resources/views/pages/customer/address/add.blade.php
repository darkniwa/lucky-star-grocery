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
                <li class="nav-item"><a href="{{route('home')}}" class="permal-link">Home</a></li>
                <li class="nav-item"><span class="perma-link">Account</span></li>
                <li class="nav-item"><a href="{{route('address')}}" class="permal-link">Delivery Address</a></li>
                <li class="nav-item"><span class="current-page">Add</span></li>
            </ul>
        </nav>
    </div>

    <div class="page-contain login-page">

        <!-- Main content -->
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="custom-form">
                        <h2 class="text-center">Add New Address</h2>
                        <form action="{{ route('address.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="source" id="source" value="">
                            <div class="form-group">
                                <label for="label">Label:</label>
                                <input type="text" class="form-control" id="label" name="label" required>
                            </div>
                            <div class="form-group">
                                <label for="street">Street:</label>
                                <input type="text" class="form-control" id="street" name="street" required>
                            </div>
                            <div class="form-group">
                                <label for="barangay">Barangay:</label>
                                <input type="text" class="form-control" id="barangay" name="barangay" required>
                            </div>
                            <div class="form-group">
                                <label for="city">City:</label>
                                <input type="text" class="form-control" id="city" name="city" required>
                            </div>
                            <div class="form-group">
                                <label for="province">Province:</label>
                                <input type="text" class="form-control" id="province" name="province" required>
                            </div>
                            <div class="form-group">
                                <label for="postal_code">Postal Code:</label>
                                <input type="text" class="form-control" id="postal_code" name="postal_code" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Save Address</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <br>
    <br>
    </div>
@endsection

@section('styles')
    <style>
        /* Custom styling for the form */
        .custom-form {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 5px;
        }

        .custom-form .form-group {
            margin-bottom: 15px;
        }

        .custom-form label {
            font-weight: bold;
        }

        .custom-form button[type="submit"] {
            background-color: #05a503;
            /* Updated primary color */
            border-color: #05a503;
            /* Updated primary color */
        }

        .custom-form button[type="submit"]:hover {
            background-color: #048d02;
            /* Slightly darker shade on hover */
        }
    </style>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Extract the source value from the URL
        var currentUrl = window.location.href;
        var source = currentUrl.includes('checkout') ? 'checkout' : 'address';

        // Set the source value in the hidden input field
        $('#source').val(source);
    });
</script>
@endsection