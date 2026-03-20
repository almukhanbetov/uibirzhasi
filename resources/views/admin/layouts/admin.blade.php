<!DOCTYPE html>
<html lang="ru" class="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Admin Dashboard</title>
    @stack('styles')
</head>

<body class="bg-slate-900 text-slate-200 font-sans">

    <div class="flex h-screen overflow-hidden">
        @include('includes-admin.aside')


        <main class="flex-1 flex flex-col overflow-y-auto">

            @include('includes-admin.header')

            <div class="p-8">

                @yield('admin')

            </div>
        </main>
    </div>
   @stack('scripts')
</body>

</html>
