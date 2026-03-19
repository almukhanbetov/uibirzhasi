@extends('layouts.app')

@section('content')
    <div
        class="min-h-screen flex items-center justify-center bg-gradient-to-br from-gray-900 via-gray-800 to-black relative overflow-hidden">

        <!-- Плавающий фон -->
        <div
            class="absolute inset-0 opacity-10 animate-pulse bg-[radial-gradient(circle_at_30%_30%,#22c55e,transparent_40%),radial-gradient(circle_at_70%_70%,#16a34a,transparent_40%)]">
        </div>

        <div
            class="relative bg-gray-900/80 backdrop-blur-xl border border-gray-700 shadow-2xl rounded-3xl p-12 text-center max-w-xl">

            <div class="text-green-500 text-6xl mb-6 animate-bounce">
                🔒
            </div>

            <h1 class="text-5xl font-bold text-white mb-4">
                403
            </h1>

            <h2 class="text-2xl font-semibold text-gray-200 mb-4">
                Доступ запрещён
            </h2>

            <p class="text-gray-400 mb-6">
                Вы не являетесь администратором.
                Если вы считаете, что это ошибка — запросите доступ.
            </p>

            <p class="text-sm text-gray-500 mb-8">
                Автоматический возврат на главную через
                <span id="countdown" class="text-green-500 font-bold">5</span> сек.
            </p>

            <div class="flex justify-center gap-4">

                <a href="{{ route('welcome') }}"
                    class="px-6 py-3 rounded-xl bg-green-600 text-white hover:bg-green-700 transition shadow-lg">
                    На главную
                </a>

                @auth
                    <a href="{{ route('profile.matches.index') }}"
                        class="px-6 py-3 rounded-xl border border-gray-600 text-gray-300 hover:bg-gray-800 transition">
                        Личный кабинет
                    </a>
                @endauth

            </div>

        </div>

    </div>

    <script>
        let seconds = 5;
        const countdown = document.getElementById('countdown');

        const timer = setInterval(() => {
            seconds--;
            countdown.textContent = seconds;

            if (seconds <= 0) {
                clearInterval(timer);
                window.location.href = "{{ route('welcome') }}";
            }
        }, 1000);
    </script>
@endsection
