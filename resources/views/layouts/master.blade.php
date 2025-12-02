<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simmutu</title>
    @yield('stylesfirst')
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('style/assets/css/bootstrap.css') }}">

    <link rel="stylesheet" href="{{ asset('style/assets/vendors/perfect-scrollbar/perfect-scrollbar.css') }}">
    <link rel="stylesheet" href="{{ asset('style/assets/vendors/bootstrap-icons/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('style/assets/css/app.css') }}">
    <link rel="shortcut icon" href="{{ asset('style/assets/favicon.svg') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('style/assets/vendors/iconly/bold.css') }}">
    <link rel="stylesheet" href="{{ asset('style/assets/vendors/iconly/light.css') }}">

    @yield('styles')
</head>

<body>
    <div id="app">
        <div id="sidebar" class="active">
            @include('layouts.sidebar')
        </div>
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
                        <p>2025 &copy; RS AZRA</p>
                    </div>
                    <div class="float-end">
                        <p>Crafted with <span class="text-danger"><i class="bi bi-heart"></i></span> by <a
                                href="https://rsazra.co.id/">SIMMUTU RS AZRA</a></p>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    @yield('js')

    <script src="{{ asset('style/assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('style/assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('style/assets/vendors/apexcharts/apexcharts.js') }}"></script>
    <script src="{{ asset('style/assets/js/pages/dashboard.js') }}"></script>
    <script src="{{ asset('style/assets/js/main.js') }}"></script>
</body>

</html>