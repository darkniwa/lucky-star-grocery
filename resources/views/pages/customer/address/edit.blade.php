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
                <li class="nav-item"><span class="current-page">Edit</span></li>
            </ul>
        </nav>
    </div>

    <div class="page-contain login-page">

        <!-- Main content -->
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="custom-form">
                        <h2 class="text-center">Edit Address</h2>
                        <form action="{{ route('address.update', ['id' => $address->id]) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="label">Label:</label>
                                <input type="text" class="form-control" id="label" name="label" required value="{{$address->label}}" disabled>
                            </div>
                            <div class="form-group">
                                <label for="street">Street:</label>
                                <input type="text" class="form-control" id="street" name="street" required value="{{$address->street}}" disabled>
                            </div>
                            <div class="form-group">
                                <label for="barangay">Barangay:</label>
                                <input type="text" class="form-control" id="barangay" name="barangay" required value="{{$address->barangay}}" disabled>
                            </div>
                            <div class="form-group">
                                <label for="city">City:</label>
                                <input type="text" class="form-control" id="city" name="city" required value="{{$address->city}}" disabled>
                            </div>
                            <div class="form-group">
                                <label for="province">Province:</label>
                                <input type="text" class="form-control" id="province" name="province" required value="{{$address->province}}" disabled>
                            </div>
                            <div class="form-group">
                                <label for="postal_code">Postal Code:</label>
                                <input type="text" class="form-control" id="postal_code" name="postal_code" required value="{{$address->postal_code}}" disabled>
                            </div>
                            <button id="edit-btn" type="button" class="btn btn-default btn-block">Edit Address</button>
                            <button id="cancel-btn" type="button" class="btn btn-danger btn-block" style="display: none;">Cancel</button>
                            <button id="save-btn" type="submit" class="btn btn-primary btn-block" style="display: none;">Save Address</button>
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
        $(document).ready(function () {
            var originalValues = {};

            $('#edit-btn').click(function () {
                // Store original values before editing
                originalValues.label = $('#label').val();
                originalValues.street = $('#street').val();
                originalValues.barangay = $('#barangay').val();
                originalValues.city = $('#city').val();
                originalValues.province = $('#province').val();
                originalValues.postal_code = $('#postal_code').val();

                $('#label, #street, #barangay, #city, #province, #postal_code').prop('disabled', false);
                $('#edit-btn').hide();
                $('#save-btn, #cancel-btn').show();
            });

            $('#cancel-btn').click(function () {
                $('#label').val(originalValues.label);
                $('#street').val(originalValues.street);
                $('#barangay').val(originalValues.barangay);
                $('#city').val(originalValues.city);
                $('#province').val(originalValues.province);
                $('#postal_code').val(originalValues.postal_code);

                $('#label, #street, #barangay, #city, #province, #postal_code').prop('disabled', true);
                $('#edit-btn').show();
                $('#save-btn, #cancel-btn').hide();
            });
        });
    </script>
@endsection
