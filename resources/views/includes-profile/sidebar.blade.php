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
        <li class="nav-item">
            <a href="{{ route('profile.matches.index') }}" class="nav-link sidebar-link">
                🧩 Найденные пары
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
