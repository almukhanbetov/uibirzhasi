@extends('layouts.profile')
@section('content')
<div class="container py-4" style="max-width: 480px;">
    <h2 class="fw-semibold mb-4" style="color:#176c61;">Изменить пароль</h2>

    @if(session('success'))
        <div class="alert alert-success small py-2 px-3 rounded-3">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger small py-2 px-3 rounded-3">
            <ul class="mb-0 ps-3">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-sm border-0 rounded-4 p-4">
        <form method="POST" action="{{ route('profile.password.update') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label small text-muted mb-1">Текущий пароль</label>
                <input type="password" name="current_password"
                    class="form-control form-control-sm rounded-3 border-success-subtle @error('current_password') is-invalid @enderror"
                    placeholder="Введите текущий пароль" required>
                @error('current_password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label small text-muted mb-1">Новый пароль</label>
                <input type="password" name="password"
                    class="form-control form-control-sm rounded-3 border-success-subtle @error('password') is-invalid @enderror"
                    placeholder="Минимум 6 символов" required>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label class="form-label small text-muted mb-1">Повторите новый пароль</label>
                <input type="password" name="password_confirmation"
                    class="form-control form-control-sm rounded-3 border-success-subtle"
                    placeholder="Повторите новый пароль" required>
            </div>

            <button type="submit" class="btn btn-success w-100 rounded-3 fw-semibold"
                style="background:#176c61; border:none;">
                🔑 Сохранить новый пароль
            </button>
        </form>
    </div>
</div>
@endsection
