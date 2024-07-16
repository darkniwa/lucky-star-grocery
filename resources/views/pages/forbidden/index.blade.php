<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ACCESS DENIED</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/seller/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/seller/vendors/bootstrap-icons/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/seller/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/seller/css/pages/error.css') }}">
</head>

<body>
    <div id="error">
        <div class="error-page container">
            <div class="col-md-8 col-12 offset-md-2">
                <div class="row">
                    <div class="col-6">
                        <img class="img-error" src="{{ asset('assets/seller/images/samples/error-403.png') }}" alt="Not Found" >
                    </div>
                    <div class="col-6">
                        <div class="text-center">
                            <h1 class="error-title">Forbidden</h1>
                            <p class="fs-5 text-gray-600">You are unauthorized to access this website.</p>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</body>
</html>
