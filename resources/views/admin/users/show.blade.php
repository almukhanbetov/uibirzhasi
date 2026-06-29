@extends('admin.layouts.admin')

@section('admin')

<div class="mb-6 flex items-center gap-4">
    <a href="{{ route('admin.users.index') }}"
       class="flex items-center gap-2 text-slate-400 hover:text-white text-sm transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Назад к пользователям
    </a>
</div>

@if(session('success'))
    <div class="mb-4 px-4 py-3 bg-green-600/20 border border-green-500/40 text-green-400 rounded-xl text-sm">
        {{ session('success') }}
    </div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- Левая колонка: информация о пользователе --}}
    <div class="lg:col-span-1 flex flex-col gap-4">

        {{-- Карточка профиля --}}
        <div class="bg-slate-800 border border-slate-700 rounded-2xl p-6">
            <div class="flex items-center gap-4 mb-5">
                <div class="w-16 h-16 rounded-full bg-indigo-600 flex items-center justify-center text-white font-bold text-2xl flex-shrink-0">
                    {{ mb_strtoupper(mb_substr($user->name ?? '?', 0, 1)) }}
                </div>
                <div>
                    <h2 class="text-white font-bold text-lg">{{ $user->name ?? '—' }}</h2>
                    <p class="text-slate-500 text-sm">ID: {{ $user->id }}</p>
                </div>
            </div>

            <div class="space-y-3 text-sm">
                <div class="flex items-center gap-3 text-slate-300">
                    <svg class="w-4 h-4 text-slate-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                    <span>{{ $user->phone ?? '—' }}</span>
                </div>
                <div class="flex items-center gap-3 text-slate-300">
                    <svg class="w-4 h-4 text-slate-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span>Зарегистрирован: {{ $user->created_at->format('d.m.Y') }}</span>
                </div>
                <div class="flex items-center gap-3 text-slate-300">
                    <svg class="w-4 h-4 text-slate-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>Депозит: <span class="text-green-400 font-semibold">{{ number_format($user->deposit ?? 0, 0, '.', ' ') }} ₸</span></span>
                </div>
            </div>

            {{-- Статистика --}}
            <div class="flex gap-3 mt-5">
                <div class="flex-1 bg-slate-700/50 rounded-xl py-3 text-center">
                    <p class="text-white font-bold text-xl">{{ $user->listings_count }}</p>
                    <p class="text-slate-500 text-xs mt-1">Объявлений</p>
                </div>
                <div class="flex-1 bg-slate-700/50 rounded-xl py-3 text-center">
                    <p class="text-white font-bold text-xl">{{ $user->deposits_count }}</p>
                    <p class="text-slate-500 text-xs mt-1">Депозитов</p>
                </div>
            </div>
        </div>

        {{-- Роль --}}
        <div class="bg-slate-800 border border-slate-700 rounded-2xl p-5">
            <h3 class="text-white font-semibold text-sm mb-3">Назначить роль</h3>
            @php
                $roleColors = [
                    'admin'     => 'bg-red-500/20 text-red-400 border-red-500/30',
                    'moderator' => 'bg-yellow-500/20 text-yellow-400 border-yellow-500/30',
                    'user'      => 'bg-slate-600/50 text-slate-400 border-slate-600',
                ];
                $currentRole = $user->role?->name ?? 'user';
                $badgeClass  = $roleColors[$currentRole] ?? $roleColors['user'];
            @endphp
            <p class="text-slate-500 text-xs mb-2">Текущая роль:</p>
            <span class="inline-block px-3 py-1 text-xs rounded-full border {{ $badgeClass }} mb-4">
                {{ $user->role?->display_name ?? 'Не назначена' }}
            </span>

            <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="flex gap-2">
                    <select name="role_id"
                        class="flex-1 bg-slate-700 border border-slate-600 text-white text-sm rounded-lg px-3 py-2 focus:outline-none focus:border-indigo-500">
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}" @selected($user->role_id == $role->id)>
                                {{ $role->display_name }}
                            </option>
                        @endforeach
                    </select>
                    <button type="submit"
                        class="px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white text-sm rounded-lg transition-colors">
                        Сохранить
                    </button>
                </div>
            </form>
        </div>

        {{-- Сброс пароля --}}
        <div class="bg-slate-800 border border-slate-700 rounded-2xl p-5">
            <h3 class="text-white font-semibold text-sm mb-3">Управление паролем</h3>
            <form action="{{ route('admin.users.update', $user->id) }}" method="POST"
                  onsubmit="return confirm('Сбросить пароль для {{ addslashes($user->name) }}?')">
                @csrf
                @method('PUT')
                <input type="hidden" name="reset_password" value="1">
                <button type="submit"
                    class="w-full px-4 py-2.5 bg-red-700 hover:bg-red-600 text-white text-sm rounded-lg transition-colors">
                    🔑 Сгенерировать новый пароль
                </button>
            </form>
            <p class="text-slate-500 text-xs mt-2">Будет создан случайный 6-значный пароль и показан в уведомлении.</p>
        </div>

    </div>

    {{-- Правая колонка: объявления --}}
    <div class="lg:col-span-2">
        <h3 class="text-white font-bold text-lg mb-4">
            Объявления пользователя
            <span class="text-slate-500 font-normal text-sm ml-2">({{ $user->listings_count }})</span>
        </h3>

        @if($user->listings->isEmpty())
            <div class="bg-slate-800 border border-slate-700 rounded-2xl p-12 text-center text-slate-500">
                <svg class="w-12 h-12 mx-auto mb-3 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                <p>Объявлений нет</p>
            </div>
        @else
            <div class="flex flex-col gap-3">
                @foreach($user->listings as $listing)
                <div class="bg-slate-800 border border-slate-700 hover:border-slate-600 rounded-2xl p-4 flex gap-4 transition-colors">

                    {{-- Фото --}}
                    <div class="w-20 h-20 flex-shrink-0 rounded-xl overflow-hidden bg-slate-700">
                        @if($listing->photos->isNotEmpty())
                            <img src="{{ asset($listing->photos->first()->url) }}"
                                 class="w-full h-full object-cover"
                                 alt="фото">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-slate-600">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        @endif
                    </div>

                    {{-- Инфо --}}
                    <div class="flex-1 min-w-0">
                        <p class="text-white font-semibold text-sm truncate">{{ $listing->area }} м² — {{ $listing->price_base ? number_format($listing->price_base, 0, '.', ' ').' ₸' : '—' }}</p>
                        <p class="text-slate-400 text-xs mt-1 truncate">{{ $listing->city?->name ?? '—' }}, {{ $listing->district?->name ?? '' }}</p>
                        <p class="text-slate-500 text-xs mt-1">{{ $listing->created_at->format('d.m.Y') }}</p>
                        <div class="flex items-center gap-2 mt-2">
                            @if($listing->is_active ?? true)
                                <span class="px-2 py-0.5 text-xs rounded-full bg-green-500/20 text-green-400 border border-green-500/30">Активно</span>
                            @else
                                <span class="px-2 py-0.5 text-xs rounded-full bg-slate-600/50 text-slate-400 border border-slate-600">Неактивно</span>
                            @endif
                        </div>
                    </div>

                    {{-- Ссылка --}}
                    <div class="flex-shrink-0 flex items-center">
                        <a href="{{ route('listings.show', $listing->id) }}" target="_blank"
                           class="px-3 py-2 bg-slate-700 hover:bg-slate-600 text-slate-300 text-xs rounded-lg transition-colors whitespace-nowrap">
                            Открыть →
                        </a>
                    </div>

                </div>
                @endforeach
            </div>
        @endif
    </div>

</div>

@endsection
