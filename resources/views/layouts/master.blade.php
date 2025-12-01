<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Simmutu</title>

    @stack('stylesfirst')

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('style/assets/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('style/assets/vendors/perfect-scrollbar/perfect-scrollbar.css') }}">
    <link rel="stylesheet" href="{{ asset('style/assets/vendors/bootstrap-icons/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('style/assets/css/app.css') }}">
    <link rel="shortcut icon" href="{{ asset('style/assets/favicon.svg') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('style/assets/vendors/iconly/bold.css') }}">
    <link rel="stylesheet" href="{{ asset('style/assets/vendors/iconly/light.css') }}">

    @stack('styles')

</head>

<body>
    <div id="app">
        <div id="sidebar" class="active">
            @include('layouts.sidebar')
        </div>
        <div id="main">
            <header class="header-bar mb-3" style="background-color: #f8f9fa; padding: 12px 18px; border-radius: 10px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                <div class="d-flex justify-content-between align-items-center">

                    <!-- Left: Burger Button -->
                    <a href="#" class="burger-btn d-block d-xl-none">
                        <i class="bi bi-justify fs-3"></i>
                    </a>

                    <!-- Right: Login / Logout Button -->
                    <div class="ms-auto">
                        @auth
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button class="btn btn-danger btn-sm">
                                    <i class="bi bi-box-arrow-right"></i> Logout
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-primary btn-sm">
                                <i class="bi bi-box-arrow-in-right"></i> Login
                            </a>
                        @endauth
                    </div>

                </div>
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

    <script src="{{ asset('style/assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('style/assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('style/assets/vendors/apexcharts/apexcharts.js') }}"></script>
    <script src="{{ asset('style/assets/js/pages/dashboard.js') }}"></script>
    <script src="{{ asset('style/assets/js/main.js') }}"></script>

    <script src="{{ asset('style/assets/vendors/simple-datatables/simple-datatables.js') }}"></script>


    @stack('scripts')

</body>

</html>