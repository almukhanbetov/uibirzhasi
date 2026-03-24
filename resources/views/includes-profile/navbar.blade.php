<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm px-4 py-3">
    <a class="navbar-brand fw-bold" href="#" style="color:#176c61 !important;">TOO "CPA"</a>

    <div class="ms-auto d-flex align-items-center">
        @auth
            <div class="dropdown me-3">
                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" id="userMenu"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-person-circle me-2 fs-5 text-secondary"></i>
                    <span class="text-dark fw-medium">{{ Auth::user()->name }}</span>
                </a>

                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0" aria-labelledby="userMenu">
                    <li>
                        <a class="dropdown-item py-2" href="{{ route('admin.index') }}">
                            <i class="bi bi-person me-2"></i>Админ
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}" class="m-0">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger py-2">
                                <i class="bi bi-box-arrow-right me-2"></i>Выйти
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        @endauth

        <i class="mobile-nav-toggle d-xl-none bi bi-list fs-3 me-3"></i>
    </div>
</nav>
