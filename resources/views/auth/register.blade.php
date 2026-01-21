@extends('layouts.guest')
@section('content')
    <section id="center" class="center_o">
        <div class="container">
        </div>
    </section>
    <section id="register">
        <div class="container">
            <div class="row">
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="col-md-6 mx-auto">
                        <div class="login_1">
                            <h3 class="col_1">Регис<span class="col_4">трация</span></h3>
                            {{-- 🔴 Вывод ошибок --}}
                            @if ($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Закрыть"></button>
                                </div>
                            @endif
                            {{-- Имя --}}
                            <h6 style="margin-top:40px;">Имя</h6>
                            <input type="text" class="form-control" name="name" value="{{ old('name') }}"
                                placeholder="Ваше имя" required autofocus autocomplete="name" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            {{-- Телефон --}}
                            <h6 style="margin-top:30px;">Телефон</h6>
                            <input type="text" id="phone" class="form-control" name="phone"
                                value="{{ old('phone') }}" placeholder="+7 (___) ___-__-__" required autofocus
                                autocomplete="phone" />
                            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                            {{-- Пароль --}}
                            <h6 style="margin-top:30px;">Пароль</h6>
                            <input type="password" class="form-control" name="password" placeholder="Введите пароль"
                                required autocomplete="new-password">
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            {{-- Подтверждение пароля --}}
                            <h6 style="margin-top:30px;">Повторите пароль</h6>
                            <input type="password" class="form-control" name="password_confirmation"
                                placeholder="Повторите пароль" required autocomplete="new-password">
                        </div>
                        <div class="d-flex justify-content-between mt-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="remember">
                                <label class="form-check-label" for="remember">Запомнить меня</label>
                            </div>
                        </div>
                        {{-- Публичная оферта --}}
                        <div id="offerBlock" class="form-check mt-4">
                            <input class="form-check-input" type="checkbox" id="offerCheckbox" name="accepted_offer"
                                value="1">

                            <label class="form-check-label" for="offerCheckbox">
                                Я принимаю условия
                                <button type="button" onclick="openOfferModal()" class="underline text-emerald-400">
                                    публичной оферты
                                </button>
                            </label>

                            <div id="offerError" class="text-danger mt-1 d-none">
                                Для регистрации необходимо принять публичную оферту
                            </div>
                        </div>
                        <button class="btn btn-success mt-3" type="submit">
                            Отправить <i style="margin-left:5px;" class="fa fa-sign-in"></i>
                        </button>

                        <p class="mt-4 mb-0">
                            Уже имеется аккаунт?
                            <a class="col_1" href="{{ route('login') }}">Войти</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </section>
    {{-- OFFER MODAL --}}
    <div id="offerModal" class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50">

        <div class="bg-white w-full max-w-3xl max-h-[80vh] rounded-xl border border-slate-200 flex flex-col shadow-xl">

            {{-- Header --}}
            <div class="flex justify-between items-center px-6 py-4 border-b border-slate-200">
                <h2 class="text-lg font-semibold text-slate-900">
                    Публичная оферта
                </h2>
                <button onclick="closeOfferModal()" class="text-slate-400 hover:text-slate-700">
                    ✕
                </button>
            </div>

            {{-- Content --}}
            <div class="p-6 overflow-y-auto">
                <div class="prose prose-sm max-w-none text-slate-800">
                    @include('offer-content')
                </div>
            </div>

            {{-- Footer --}}
            <div class="px-6 py-4 border-t border-slate-200 flex justify-end gap-3">
                <button onclick="closeOfferModal()"
                    class="px-4 py-2 rounded-lg border border-slate-300 text-slate-700 hover:bg-slate-100">
                    Отмена
                </button>
                <button onclick="acceptOffer()"
                    class="px-4 py-2 rounded-lg bg-emerald-600 text-white font-semibold hover:bg-emerald-500">
                    Я принимаю
                </button>
            </div>

        </div>
    </div>


    {{-- SCRIPT --}}
    <script>
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            const checkbox = document.getElementById('offerCheckbox');
            const error = document.getElementById('offerError');
            const block = document.getElementById('offerBlock');

            if (!checkbox.checked) {
                e.preventDefault();

                error.classList.remove('hidden');
                block.classList.add('border', 'border-red-500', 'rounded-lg', 'p-2');

                checkbox.focus();
            }
        });

        // --------------------
        // OFFER MODAL
        // --------------------

        function openOfferModal() {
            const modal = document.getElementById('offerModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeOfferModal() {
            const modal = document.getElementById('offerModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function acceptOffer() {
            document.getElementById('offerCheckbox').checked = true;

            const error = document.getElementById('offerError');
            const block = document.getElementById('offerBlock');

            error.classList.add('hidden');
            block.classList.remove('border', 'border-red-500', 'p-2');

            closeOfferModal();
        }
    </script>
@endsection
