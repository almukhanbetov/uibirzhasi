@extends('admin.layouts.admin')

@section('admin')

<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-2xl font-bold text-white">Пользователи</h2>
        <p class="text-slate-400 text-sm mt-1">Всего: {{ $users->total() }}</p>
    </div>
</div>

@if(session('success'))
    <div class="mb-4 px-4 py-3 bg-green-600/20 border border-green-500/40 text-green-400 rounded-xl text-sm">
        {{ session('success') }}
    </div>
@endif

{{-- Поиск --}}
<form method="GET" action="{{ route('admin.users.index') }}" class="mb-6">
    <div class="flex gap-3">
        <input
            type="text"
            name="search"
            value="{{ request('search') }}"
            placeholder="Поиск по имени или телефону..."
            class="flex-1 bg-slate-800 border border-slate-700 text-white rounded-xl px-4 py-2.5 text-sm placeholder-slate-500 focus:outline-none focus:border-indigo-500"
        >
        <button type="submit"
            class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl text-sm font-medium transition-colors">
            Найти
        </button>
        @if(request('search'))
            <a href="{{ route('admin.users.index') }}"
               class="px-4 py-2.5 bg-slate-700 hover:bg-slate-600 text-slate-300 rounded-xl text-sm transition-colors">
                Сбросить
            </a>
        @endif
    </div>
</form>

{{-- Карточки --}}
@if($users->isEmpty())
    <div class="text-center py-20 text-slate-500">
        <svg class="w-12 h-12 mx-auto mb-4 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
        </svg>
        <p>Пользователи не найдены</p>
    </div>
@else
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
        @foreach($users as $user)
        <div class="bg-slate-800 border border-slate-700 rounded-2xl p-5 hover:border-slate-600 transition-colors flex flex-col gap-4">

            {{-- Аватар + имя --}}
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-full bg-indigo-600 flex items-center justify-center text-white font-bold text-lg flex-shrink-0">
                    {{ mb_strtoupper(mb_substr($user->name ?? '?', 0, 1)) }}
                </div>
                <div class="min-w-0">
                    <p class="text-white font-semibold truncate text-sm">{{ $user->name ?? '—' }}</p>
                    <p class="text-slate-500 text-xs">ID: {{ $user->id }}</p>
                </div>
            </div>

            {{-- Данные --}}
            <div class="space-y-1.5 text-sm">
                <div class="flex items-center gap-2 text-slate-400">
                    <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                    <span class="truncate">{{ $user->phone ?? '—' }}</span>
                </div>
                <div class="flex items-center gap-2 text-slate-400">
                    <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span>{{ $user->created_at->format('d.m.Y') }}</span>
                </div>
            </div>

            {{-- Статистика --}}
            <div class="flex gap-2 text-center">
                <div class="flex-1 bg-slate-700/50 rounded-lg py-2">
                    <p class="text-white font-bold">{{ $user->listings_count }}</p>
                    <p class="text-slate-500 text-xs">Объявл.</p>
                </div>
                <div class="flex-1 bg-slate-700/50 rounded-lg py-2">
                    <p class="text-white font-bold">{{ $user->deposits_count }}</p>
                    <p class="text-slate-500 text-xs">Депозиты</p>
                </div>
                <div class="flex-1 bg-slate-700/50 rounded-lg py-2">
                    @if($user->verified)
                        <p class="text-green-400 font-bold">✓</p>
                        <p class="text-slate-500 text-xs">Верифиц.</p>
                    @else
                        <p class="text-slate-500 font-bold">—</p>
                        <p class="text-slate-500 text-xs">Не верифиц.</p>
                    @endif
                </div>
            </div>

            {{-- Текущая роль + форма назначения --}}
            <div class="border-t border-slate-700 pt-3">
                <p class="text-slate-500 text-xs mb-2">Роль:</p>

                @php
                    $roleColors = [
                        'admin'     => 'bg-red-500/20 text-red-400 border-red-500/30',
                        'moderator' => 'bg-yellow-500/20 text-yellow-400 border-yellow-500/30',
                        'user'      => 'bg-slate-600/50 text-slate-400 border-slate-600',
                    ];
                    $currentRole = $user->role?->name ?? 'user';
                    $badgeClass  = $roleColors[$currentRole] ?? $roleColors['user'];
                @endphp

                <span class="inline-block px-2 py-0.5 text-xs rounded-full border {{ $badgeClass }} mb-3">
                    {{ $user->role?->display_name ?? 'Не назначена' }}
                </span>

                <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="flex gap-2">
                        <select name="role_id"
                            class="flex-1 bg-slate-700 border border-slate-600 text-white text-xs rounded-lg px-2 py-1.5 focus:outline-none focus:border-indigo-500">
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" @selected($user->role_id == $role->id)>
                                    {{ $role->display_name }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit"
                            class="px-3 py-1.5 bg-indigo-600 hover:bg-indigo-500 text-white text-xs rounded-lg transition-colors whitespace-nowrap">
                            Сохранить
                        </button>
                    </div>
                </form>
            </div>

        </div>
        @endforeach
    </div>

    <div class="mt-8">
        {{ $users->links() }}
    </div>
@endif

@endsection
