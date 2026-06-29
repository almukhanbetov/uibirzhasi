<div class="col-12 col-md-3 col-lg-2 bg-white border-end vh-100 p-3">

    <h5 class="fw-bold mb-4 text-success">📁 Меню</h5>

    <ul class="nav flex-column sidebar-menu">

        {{-- Список объявлений --}}
        <li class="nav-item mb-2">
            <a href="{{ route('profile.index') }}"
                class="nav-link sidebar-link {{ request()->routeIs('profile.index') ? 'active' : '' }}">
                <span class="me-2">📋</span> Список объявлений
            </a>
        </li>

        {{-- Добавить объявление --}}
        <li class="nav-item mb-2">
            <a href="{{ route('profile.create') }}"
                class="nav-link sidebar-link {{ request()->routeIs('profile.create') ? 'active' : '' }}">
                <span class="me-2">🏡</span> Добавить объявление
            </a>
        </li>
        <li class="nav-item mb-2">
            <a href="{{ route('profile.matches.index') }}" class="nav-link sidebar-link {{ request()->routeIs('profile.matches.*') ? 'active' : '' }}">
                🧩 Найденные пары
            </a>
        </li>
        <li class="nav-item mb-2">
            <a href="{{ route('profile.password.form') }}"
                class="nav-link sidebar-link {{ request()->routeIs('profile.password.*') ? 'active' : '' }}">
                🔑 Изменить пароль
            </a>
        </li>
        <li class="my-3">
            <hr class="text-muted">
        </li>

        {{-- Баланс --}}
        <li class="nav-item mb-2 px-2">
            <div class="small text-muted">Баланс депозита</div>

            <div class="fw-bold text-success fs-5">
                {{ number_format(auth()->user()->deposit ?? 0, 0, '.', ' ') }} ₸
            </div>
        </li>

        {{-- Внести депозит --}}
        <li class="nav-item mt-2">
            <a href="{{ route('payment.index') }}" class="btn btn-success w-100 rounded-pill fw-semibold">
                💰 Внести депозит
            </a>
        </li>

        {{-- <li class="nav-item mb-2">
            <a href="#"
               class="nav-link sidebar-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                <span class="me-2">👥</span> Пользователи
            </a>
        </li>

     
        <li class="nav-item mb-2">
            <a href="#"
               class="nav-link sidebar-link {{ request()->routeIs('settings.*') ? 'active' : '' }}">
                <span class="me-2">⚙️</span> Настройки
            </a>
        </li> --}}

    </ul>

</div>
