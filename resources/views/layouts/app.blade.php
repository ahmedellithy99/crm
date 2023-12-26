<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body class="c-app">
    <div class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show" id="sidebar">
        <div class="c-sidebar-brand d-lg-down-none">
            CRM
        </div>
        @include('partials.menu')
        <button class="c-sidebar-minimizer c-class-toggler" type="button" data-target="_parent"
                data-class="c-sidebar-minimized"></button>
    </div>
    <div class="c-wrapper c-fixed-components">
        <header class="c-header c-header-light c-header-fixed c-header-with-subheader">
            <button class="c-header-toggler c-class-toggler d-lg-none mfe-auto" type="button" data-target="#sidebar"
                    data-class="c-sidebar-show">
                <i class="fas fa-fw fa-bars"></i>
            </button>
            <a class="c-header-brand d-lg-none" href="#">
                <svg width="118" height="46" alt="CoreUI Logo">
                    <use xlink:href="assets/brand/coreui.svg#full"></use>
                </svg>
            </a>
            <button class="c-header-toggler c-class-toggler mfs-3 d-md-down-none" type="button" data-target="#sidebar"
                    data-class="c-sidebar-lg-show" responsive="true">
                <i class="fas fa-fw fa-bars"></i>
            </button>
    
            @include('partials.user-dropdown')
        </header>
        <div class="c-body">
            <main class="c-main">
                <div class="container-fluid">
                    <div class="fade-in">
                        @yield('content')
                    </div>
                </div>
                <form id="logoutform" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </main>
            <footer class="c-footer">
                <div><a href="https://coreui.io">CoreUI</a> © 2020 creativeLabs.</div>
                <div class="ml-auto">Powered by&nbsp;<a href="https://coreui.io/">CoreUI</a></div>
            </footer>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/1.5.0/perfect-scrollbar.min.js"></script>
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="https://unpkg.com/@coreui/coreui@3.4/dist/js/coreui.min.js"></script>
    
</body>
    
</html>
