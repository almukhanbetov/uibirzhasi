<div class="col-md-2 bg-dark text-white min-vh-100 border-end">

    <div class="p-3">

        <h6 class="text-uppercase text-secondary">
            Меню
        </h6>

        <ul class="nav nav-pills flex-column gap-1">

            <li>
                <a class="nav-link d-flex gap-2 align-items-center text-white {{ request()->routeIs('admin.dashboard') ? 'active bg-secondary' : '' }}"
                    href="{{ route('admin.dashboard') }}">
                    <i class="bi bi-bar-chart-line"></i>
                    Статистика
                </a>
            </li>

            <li>
                <a class="nav-link d-flex gap-2 align-items-center text-white {{ request()->routeIs('admin.users.*') ? 'active bg-secondary' : '' }}"
                    href="{{ route('admin.users.index') }}">
                    <i class="bi bi-people"></i>
                    Пользователи
                </a>
            </li>

            <li>
                <a class="nav-link d-flex gap-2 align-items-center text-white {{ request()->routeIs('admin.listings.*') ? 'active bg-secondary' : '' }}"
                    href="{{ route('admin.listings.index') }}">
                    <i class="bi bi-megaphone"></i>
                    Объявления
                </a>
            </li>

            <a class="nav-link text-white {{ request()->routeIs('admin.matches.*') ? 'active bg-secondary' : '' }}"
                href="{{ route('admin.matches.index') }}">
                <i class="fa-solid fa-handshake"></i>
                Сделки
            </a>

            <li>
                <a class="nav-link d-flex gap-2 align-items-center text-white {{ request()->routeIs('admin.deposits.*') ? 'active bg-secondary' : '' }}"
                    href="{{ route('admin.deposits.index') }}">
                    <i class="bi bi-piggy-bank"></i>
                    Депозиты
                </a>
            </li>

        </ul>

    </div>

</div>
