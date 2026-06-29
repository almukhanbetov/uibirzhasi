
<style>
    body {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }
    .main {
        flex: 1;
    }
</style>

@include("includes.header")
<main class="main">
    @yield('content')
</main>
@yield('scripts')
@include("includes.footer")