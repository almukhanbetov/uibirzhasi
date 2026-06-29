@extends('layouts.guest')
@section('content')

<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-md-6 mx-auto">
                <div class="login_1">
                    <h3 class="col_1">Восстановление <span class="col_4">пароля</span></h3>

                    <p class="text-muted mt-3 mb-4" style="font-size: 14px;">
                        Введите email, указанный при регистрации — мы отправим ссылку для сброса пароля.
                    </p>

                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <h6 style="margin-top: 20px;">Email</h6>
                        <input type="email" name="email" class="form-control"
                            placeholder="example@mail.com"
                            value="{{ old('email') }}" required autofocus>

                        <h6 class="mt-4 mb-0">
                            <button class="btn btn-success" type="submit">
                                Отправить ссылку <i style="margin-left:5px;" class="fa fa-envelope"></i>
                            </button>
                        </h6>

                        <p class="mt-4 mb-0">
                            <a class="col_1" href="{{ route('login') }}">← Вернуться ко входу</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
