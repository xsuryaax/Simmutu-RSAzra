<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMMUTU RS Azra</title>

    {{-- CSS statis utama --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Manrope:wght@200..800&family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">


    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/css/bootstrap.css', 'resources/css/app-dark.css', 'resources/js/app.js'])
    @else
        <style>
            /*! tailwindcss v4.0.7 | MIT License | https://tailwindcss.com */
        </style>
    @endif

    {{-- CSS tambahan per halaman --}}
    @stack('css')
</head>

<body>
    <div id="app">

        {{-- Sidebar --}}
        @include('layouts.includes.sidebar')

        <div id="main">

            {{-- Header (Navbar Atas) --}}
            @include('layouts.includes.header')

            {{-- Konten --}}
            <div class="page-heading">
                {{-- Title Page dan Breadcrumb --}}
                @yield('page-title')
            </div>

            <div class="page-content">
                <section class="section">
                    {{-- Konten Utama Halaman --}}
                    @yield('content')
                </section>
            </div>

            {{-- Footer --}}
            {{-- @include('layouts.includes.footer') --}}

        </div>
    </div>

    {{-- JS tambahan per halaman --}}
    @stack('js')
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</html>
