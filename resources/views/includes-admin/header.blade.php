<header class="h-16 border-b border-slate-800 bg-slate-900/50 backdrop-blur-md flex items-center justify-between px-8 sticky top-0 z-10">
    <h1 class="text-lg font-semibold text-slate-100">Обзор системы</h1>
    
    <div class="flex items-center gap-3">
        @if (Route::has('login'))
            @auth
                <button class="p-2 text-slate-400 hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                    </svg>
                </button>

                <a href="#" class="text-slate-300 hover:text-white px-4 py-2 text-sm font-medium transition-colors">
                    {{Auth::user()->name}}
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="bg-slate-800 hover:bg-red-900/20 hover:text-red-400 text-slate-400 px-4 py-2 rounded-lg text-sm font-medium transition-all border border-slate-700 hover:border-red-900/50">
                        Выйти
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="text-slate-400 hover:text-slate-100 px-4 py-2 text-sm font-medium transition-colors">
                    Войти
                </a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-all shadow-lg shadow-indigo-500/20">
                        Регистрация
                    </a>
                @endif
            @endauth
        @endif
    </div>
</header>