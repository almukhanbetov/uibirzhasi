<aside class="w-64 bg-slate-800 border-r border-slate-700 flex-shrink-0 hidden md:flex flex-col">
    <div class="p-6 flex items-center gap-3">
        <div class="w-8 h-8 bg-indigo-500 rounded-lg flex items-center justify-center font-bold text-white">T</div>
        <a href="{{ route('welcome') }}"><span class="text-xl font-bold tracking-tight">Админ панель</span></a>
    </div>
    <nav class="flex-1 px-4 space-y-1 mt-4">
        <a href="{{ route('admin.users.index') }}"
            class="flex items-center gap-3 px-3 py-2 {{ request()->routeIs('admin.users.*') ? 'bg-slate-700 text-white' : 'text-slate-400 hover:bg-slate-700 hover:text-white' }} rounded-lg transition-all">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                </path>
            </svg>
            <span>Пользователи</span>
        </a>
        <a href="{{ route('admin.different-sections.index') }}"
            class="flex items-center gap-3 px-3 py-2 text-slate-400 hover:bg-slate-700 hover:text-white rounded-lg transition-all">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                </path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
            </svg>
            <span>Пункт оплаты</span>
        </a>
    </nav>
    <div class="p-4 border-t border-slate-700">
        <div class="flex items-center gap-3 p-2">
            <div class="w-10 h-10 rounded-full bg-slate-600"></div>
            <div>
                <p class="text-sm font-medium">Tima</p>
                <p class="text-xs text-slate-500">Разработчик</p>
            </div>
        </div>
    </div>
</aside>
