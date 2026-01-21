@extends('layouts.guest')
@section('content')
    <div class="max-w-2xl mx-auto py-12">
        <h1 class="text-2xl font-bold">Обновление условий</h1>

        <p class="mt-4 text-slate-300">
            Условия публичной оферты были обновлены.
            Для продолжения работы необходимо принять новую версию
            (v{{ $version }}).
        </p>

        <div class="mt-6 p-4 bg-slate-800 rounded-lg">
            <a href="{{ route('offer') }}" target="_blank"
               class="text-emerald-400 underline">
                Ознакомиться с публичной офертой
            </a>
        </div>

        <form method="POST" class="mt-6">
            @csrf

            <label class="flex items-start gap-2">
                <input type="checkbox" name="accepted_offer" required
                       class="mt-1 accent-emerald-500">

                <span>
                    Я принимаю условия публичной оферты
                </span>
            </label>

            <button class="mt-6 px-6 py-2 bg-emerald-600 rounded">
                Принять и продолжить
            </button>
        </form>
    </div>
@endsection
