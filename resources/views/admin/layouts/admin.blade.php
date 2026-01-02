<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>
        @hasSection('title')
            @yield('title') — Админ-панель
        @else
            Админ-панель
        @endif
    </title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    {{-- <link rel="stylesheet" href="{{ asset('css/app.css') }}"> --}}
</head>

<body class="bg-dark text-light">
    {{-- ===== HEADER ===== --}}
    @include('includes-admin.header')
    <div class="container-fluid">
        <div class="row">
            {{-- ===== SIDEBAR ===== --}}

            @include('includes-admin.sidebar')

            {{-- ===== MAIN CONTENT ===== --}}
            <div class="col-md-10 p-4 bg-light text-dark min-vh-100">
                @yield('admin')
            </div>

        </div>
    </div>
    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
