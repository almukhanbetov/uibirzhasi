<!DOCTYPE html>
<html lang="ru">

<head>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=AW-18244312936"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'AW-18244312936');
    </script>
    <meta charset="UTF-8">
    <title>Админка недвижимости</title>
    <link href="{{ asset('profile/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('profile/css/styles.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body>
    <!-- Верхняя панель -->
    @include('includes-profile.navbar')
    <div class="container-fluid">
        <div class="row">
            <!-- Боковое меню -->
            @include('includes-profile.sidebar')
            <!-- Контент -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
                @yield('content')
            </main>
            {{-- @stack('scripts') --}}
        </div>
    </div>
    @stack('scripts')
    <script src="{{ asset('profile/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('profile/js/main.js') }}"></script>
</body>

</html>
