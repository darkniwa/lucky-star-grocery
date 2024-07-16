<!DOCTYPE html>
<html lang="en">

<head>
    @include('inc.admin.head')
    @yield('styles')
</head>

<body style="background-color: #f2f7ff">
    @include('inc.admin.sidebar')
    @yield('content')
    @include('inc.admin.footer')
    @yield('scripts')
</body>

</html>
