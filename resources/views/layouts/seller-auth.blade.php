
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lucky Star Seller Center</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('assets/seller/css/bootstrap.css')}}">
    <link rel="stylesheet" href="{{asset('assets/seller/vendors/bootstrap-icons/bootstrap-icons.css')}}">
    <link rel="stylesheet" href="{{asset('assets/seller/css/app.css')}}">
    <link rel="stylesheet" href="{{asset('assets/seller/css/pages/auth.css')}}">
    @yield('styles')

</head>

<body>
    @yield('content')
    @yield('scripts')
</body>

</html>