@extends('layouts.guest')
@section('content')

<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-md-6 mx-auto">
                <div class="login_1 text-center">
                    <h3 class="col_1">Забыли <span class="col_4">пароль?</span></h3>

                    <p class="text-muted mt-3 mb-4" style="font-size: 15px; line-height: 1.7;">
                        Регистрация на сайте производится по номеру телефона.<br>
                        Для восстановления пароля позвоните нам:
                    </p>

                    <a href="tel:+77027897120"
                       class="btn btn-success btn-lg px-5 mb-3"
                       style="font-size: 20px; letter-spacing: 1px; border-radius: 50px;">
                        <i class="bi bi-telephone-fill me-2"></i>+7 702 789-71-20
                    </a>

                    <p class="text-muted mt-2 mb-4" style="font-size: 13px;">
                        Администратор сбросит ваш пароль и сообщит новый.
                    </p>

                    <a class="col_1" href="{{ route('login') }}">← Вернуться ко входу</a>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
