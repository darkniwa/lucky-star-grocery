<!DOCTYPE html>
<html lang="en">

<head>
    @include('inc.seller.head')
    @yield('styles')
</head>

<body>

    <div id="app">
        @if (Auth::check())
            @include('inc.seller.sidebar')
        @endif
        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>
            @yield('content')
            <footer>
                <div class="footer clearfix mb-0 text-muted">
                    <div class="float-start">
                        <p>{{ date('Y') }} &copy; Lucky Star Convenient Store</p>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="{{ mix('js/app.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="{{ asset('assets/seller/vendors/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/seller/js/bootstrap.bundle.min.js') }}"></script>
    @yield('scripts')
    <script src="{{ asset('assets/seller/js/mazer.js') }}"></script>
</body>

</html>
