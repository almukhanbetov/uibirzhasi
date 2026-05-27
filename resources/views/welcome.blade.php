@extends('layouts.guest')
@section('content')
    <section id="hero" class="hero section mt-5">
        <div class="container" data-aos="fade-up" data-aos-delay="100">
            {{-- ⭐ Заголовок --}}
            <div class="text-center mb-5" data-aos="fade-up" data-aos-delay="150">
                <p class="text-uppercase fw-semibold text-success mb-2" style="letter-spacing: 1.5px;">
                    Впервые в мире биржа недвижимости
                </p>
                <h1 class="fw-bold display-5 text-dark mb-3" style="font-family: 'Poppins', sans-serif;">
                    UIBIRZHASI.KZ1
                </h1>
                <p class="lead text-muted" style="max-width: 600px; margin: 0 auto;">
                    <span class="text-success fw-semibold">Мы гарантируем, что продадим вашу недвижимость. </span>
                </p>
                <div class="row g-3 mt-3">
                    {{-- Карточка 1 --}}
                    <div class="col-md-6">
                        <div class="d-flex align-items-center gap-3 px-4 py-3 shadow-sm"
                            style="background: #fff; border-radius: 50px; border: 1px solid #d4edda;">
                            <div class="flex-shrink-0 rounded-circle d-flex align-items-center justify-content-center"
                                style="width:44px; height:44px; min-width:44px; background: #e8f5ee;">
                                <i class="bi bi-info-circle-fill text-success fs-5"></i>
                            </div>
                            <p class="mb-0 text-secondary" style="font-size: 13.5px; line-height: 1.5;">
                                Ежедневно в 00.00 Астаны у <strong class="text-dark">продавцов</strong> недвижимости цена
                                <strong class="text-danger">падает на 1%</strong>.
                            </p>
                        </div>
                    </div>
                    {{-- Карточка 2 --}}
                    <div class="col-md-6">
                        <div class="d-flex align-items-center gap-3 px-4 py-3 shadow-sm"
                            style="background: #fff; border-radius: 50px; border: 1px solid #d4edda;">
                            <div class="flex-shrink-0 rounded-circle d-flex align-items-center justify-content-center"
                                style="width:44px; height:44px; min-width:44px; background: #e8f5ee;">
                                <i class="bi bi-info-circle-fill text-success fs-5"></i>
                            </div>
                            <p class="mb-0 text-secondary" style="font-size: 13.5px; line-height: 1.5;">
                                Ежедневно в 00.00 Астаны у <strong class="text-dark">покупателей</strong> недвижимости цена
                                <strong class="text-success">поднимается на 1%</strong>.
                            </p>
                        </div>
                    </div>
                    {{-- Карточка 3 --}}
                    <div class="col-md-6">
                        <div class="d-flex align-items-center gap-3 px-4 py-3 shadow-sm"
                            style="background: #fff; border-radius: 50px; border: 1px solid #d4edda;">
                            <div class="flex-shrink-0 rounded-circle d-flex align-items-center justify-content-center"
                                style="width:44px; height:44px; min-width:44px; background: #e8f5ee;">
                                <i class="bi bi-info-circle-fill text-success fs-5"></i>
                            </div>
                            <p class="mb-0 text-secondary" style="font-size: 13.5px; line-height: 1.5;">
                                При совпадении цен с точностью до <strong class="text-dark">2%</strong> и основных
                                характеристик — продавцу и покупателю высылаются <strong class="text-dark">уведомления в
                                    WhatsApp</strong>.
                            </p>
                        </div>
                    </div>
                    {{-- Карточка 4 --}}
                    <div class="col-md-6">
                        <div class="d-flex align-items-center gap-3 px-4 py-3 shadow-sm"
                            style="background: #fff; border-radius: 50px; border: 1px solid #d4edda;">
                            <div class="flex-shrink-0 rounded-circle d-flex align-items-center justify-content-center"
                                style="width:44px; height:44px; min-width:44px; background: #e8f5ee;">
                                <i class="bi bi-info-circle-fill text-success fs-5"></i>
                            </div>
                            <p class="mb-0 text-secondary" style="font-size: 13.5px; line-height: 1.5;">
                                После уведомления пользователь вносит <strong class="text-dark">депозит 1%</strong> от цены
                                в личном кабинете и получает <strong class="text-dark">контакты контрагента</strong>.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row align-items-center g-5">
                {{-- 📝 Форма --}}
                <div class="col-lg-6" data-aos="fade-right" data-aos-delay="200">
                    <div class="p-4 rounded-4 shadow-lg bg-white" style="backdrop-filter: blur(8px);">
                        <h2 class="text-center mb-4 fw-bold text-success">Поиск объявления</h2>
                        <form id="filterForm" method="GET" action="{{ route('listings.index') }}"
                            class="row g-3 align-items-end">
                            {{-- Тип недвижимости --}}
                            <div class="col-md-6">
                                <label class="form-label small text-muted mb-1">Тип сделки</label>
                                <select name="deal_type"
                                    class="form-select form-select-sm rounded-3 border border-success-subtle">
                                    <option value="">Выберите тип сделки</option>
                                    <option value="sale" @selected(old('deal_type') == 'sale')>Продажа</option>
                                    <option value="buy" @selected(old('deal_type') == 'buy')>Покупка</option>
                                </select>
                            </div>
                            {{-- Тип недвижимости --}}
                            <div class="col-md-6">
                                <label class="form-label small text-muted mb-1">Тип недвижимости</label>
                                <select name="type_id"
                                    class="form-select form-select-sm rounded-3 border border-success-subtle">
                                    <option value="">Все типы</option>
                                    @foreach ($types as $type)
                                        <option value="{{ $type->id }}"
                                            {{ request('type_id') == $type->id ? 'selected' : '' }}>
                                            {{ $type->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            {{-- 🔹 РЕГИОН --}}
                            <div class="col-md-6">
                                <label class="form-label small text-muted mb-1">Регион</label>
                                <select name="region_id" id="regionSelect"
                                    class="form-select form-select-sm rounded-3 border border-success-subtle">
                                    <option value="">Все регионы</option>
                                    @foreach ($regions as $region)
                                        <option value="{{ $region->id }}"
                                            {{ request('region_id') == $region->id ? 'selected' : '' }}>
                                            {{ $region->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            {{-- 🔹 ГОРОД (динамический) --}}
                            <div class="col-md-6">
                                <label class="form-label small text-muted mb-1">Город</label>
                                <select name="city_id" id="citySelect"
                                    class="form-select form-select-sm rounded-3 border border-success-subtle">
                                    <option value="">Все города</option>
                                </select>
                            </div>
                            {{-- 🔹 РАЙОН (динамический) --}}
                            <div class="col-md-6">
                                <label class="form-label small text-muted mb-1">Район</label>
                                <select name="district_id" id="districtSelect"
                                    class="form-select form-select-sm rounded-3 border border-success-subtle">
                                    <option value="">Все районы</option>
                                </select>
                            </div>
                            {{-- Количество комнат --}}
                            <div class="col-md-6">
                                <label class="form-label small text-muted mb-1">Комнат</label>
                                <input type="number" class="form-control rounded-3 border border-success-subtle"
                                    name="rooms" value="{{ request('rooms') }}" min="1" placeholder="1">
                            </div>
                            {{-- Площадь --}}
                            <div class="col-md-6">
                                <label class="form-label small text-muted mb-1">Площадь (м²)</label>
                                <div class="input-group">
                                    <input type="number" name="area_min"
                                        class="form-control rounded-3 border border-success-subtle" placeholder="от"
                                        value="{{ request('area_min') }}">
                                    <input type="number" name="area_max"
                                        class="form-control rounded-3 border border-success-subtle" placeholder="до"
                                        value="{{ request('area_max') }}">
                                </div>
                            </div>
                            {{-- Цена --}}
                            <div class="col-md-6">
                                <label class="form-label small text-muted mb-1">Цена (₸)</label>
                                <div class="input-group">
                                    <input type="number" name="price_min"
                                        class="form-control rounded-3 border border-success-subtle" placeholder="от"
                                        value="{{ request('price_min') }}">
                                    <input type="number" name="price_max"
                                        class="form-control rounded-3 border border-success-subtle" placeholder="до"
                                        value="{{ request('price_max') }}">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                {{-- 🏞 Правая картинка --}}
                <div class="col-lg-6" data-aos="fade-left" data-aos-delay="300">
                    <div class="position-relative">
                        {{-- <img src="{{ asset('assets/img/real-estate/property-exterior-3.webp') }}"
                            class="img-fluid rounded-4 shadow-lg" alt="Property"> --}}
                        <img src="{{ asset('images/payments/halyk-qr.jpeg') }}"
                            class="img-fluid rounded-4 shadow-lg bg-white p-3"
                            style="max-height: 420px; object-fit: contain;" alt="Halyk QR">

                        {{-- <div class="position-absolute top-0 end-0 bg-success text-white px-3 py-2 rounded-end-4 rounded-bottom-0 fw-semibold"
                            style="border-top-right-radius: 1rem;">
                            855 000 000 • РЕКОМЕНДУЕМЫЕ
                        </div> --}}
                        {{-- <div class="position-absolute bottom-0 start-0 bg-white p-3 rounded-4 shadow-sm m-3"
                            style="max-width: 250px;">
                            <div class="d-flex align-items-center">
                                <img src="{{ asset('assets/img/real-estate/agent-4.webp') }}" class="rounded-circle me-2"
                                    width="40" height="40" alt="Agent">
                                <div>
                                    <h6 class="mb-0 fw-bold text-dark">Аимбетов Жусуп</h6>
                                    <small class="text-muted">ТОО "CPA"</small>
                                </div>
                            </div>
                            <div class="mt-2 text-warning small">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-half"></i>
                                <span class="text-muted ms-1">4.9 (127)</span>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="properties" class="properties section">
        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <div class="row">
                <div class="col-lg-12">
                    <div id="listing-container">
                        @include('components.listings-grid', ['listings' => $listings])
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="different-section py-5" style="background: #f8faf9; border-top: 1px solid #dee2e6;">
        <div class="container" data-aos="fade-up">
            <div class="text-center mb-5">
                <!-- <p class="text-uppercase fw-semibold text-success mb-2" style="letter-spacing: 1.5px; font-size: 13px;">
                                                                Оплата
                                                            </p>
                                                            <h2 class="fw-bold text-dark mb-2" style="font-family: 'Poppins', sans-serif;">
                                                                Способы оплаты
                                                            </h2> -->
                <!-- <p class="text-muted">Прозрачные тарифы без скрытых платежей</p> -->
            </div>
            <div class="row g-4 justify-content-center">
                {{-- Банковские карты --}}
                <div class="col-lg-3 col-md-6">
                    <div class="card border-0 rounded-4 shadow-sm h-100 text-center p-4">
                        <div class="mb-3 d-flex justify-content-center gap-3">
                            {{-- VISA --}}
                            <div class="border rounded-3 px-3 py-2 d-flex align-items-center justify-content-center"
                                style="width:90px; height:54px; background:#fff;">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 16" width="60"
                                    height="20">
                                    <text x="0" y="14" font-family="Arial, sans-serif" font-size="16" font-weight="900"
                                        font-style="italic" fill="#1A1F71">VISA</text>
                                </svg>
                            </div>
                            {{-- Mastercard --}}
                            <div class="border rounded-3 px-3 py-2 d-flex align-items-center justify-content-center gap-1"
                                style="width:90px; height:54px; background:#fff;">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 30" width="54"
                                    height="34">
                                    <circle cx="16" cy="15" r="13" fill="#EB001B" />
                                    <circle cx="32" cy="15" r="13" fill="#F79E1B" />
                                    <path d="M24 4.8a13 13 0 0 1 0 20.4A13 13 0 0 1 24 4.8z" fill="#FF5F00" />
                                </svg>
                            </div>
                        </div>
                        <h5 class="fw-bold text-dark mb-2">Банковская карта</h5>
                        <p class="text-muted small mb-0">Безналичная оплата через защищённый платёжный шлюз</p>
                    </div>
                </div>
                @forelse ($differents as $different)
                    <div class="col-lg-3 col-md-6">
                        <div class="card border-0 rounded-4 shadow-sm h-100 p-4">
                            <div class="mb-3 text-success" style="font-size: 28px;">
                                <i class="bi bi-arrow-repeat"></i>
                            </div>
                            <h5 class="fw-bold text-dark mb-2">{{ $different->title }}</h5>
                            <p class="text-muted small mb-0">
                                {{ \Illuminate\Support\Str::limit($different->short_desc, 90) }}

                                <a href="{{ route('different.show', $different->id) }}" class="text-success fw-semibold">
                                    Читать →
                                </a>
                            </p>
                        </div>
                    </div>
                @empty
                    <div class="col-lg-3 col-md-6">
                        <p class="text-muted small mb-0">
                        <h3>Нет данных</h3>
                        </p>
                    </div>
                @endforelse

            </div>
        </div>
    </section>
@endsection
<script>
    document.addEventListener('DOMContentLoaded', function() {

        // -------------------------
        // Данные из Laravel
        // -------------------------
        const cities = @json($cities);
        const districts = @json($districts);

        // -------------------------
        // HTML элементы
        // -------------------------
        const regionSelect = document.getElementById('regionSelect');
        const citySelect = document.getElementById('citySelect');
        const districtSelect = document.getElementById('districtSelect');

        // -------------------------
        // Значения old()
        // -------------------------
        const OLD_REGION = "{{ old('region_id') }}";
        const OLD_CITY = "{{ old('city_id') }}";
        const OLD_DISTRICT = "{{ old('district_id') }}";

        // -------------------------
        // ФУНКЦИЯ: загрузить города
        // -------------------------
        function loadCities(regionId) {
            citySelect.innerHTML = `<option value="">Выберите город</option>`;
            districtSelect.innerHTML = `<option value="">Сначала выберите город</option>`;

            cities.forEach(city => {
                if (city.region_id == regionId) {
                    citySelect.innerHTML += `
                    <option value="${city.id}">${city.name}</option>
                `;
                }
            });
        }

        // -------------------------
        // ФУНКЦИЯ: загрузить районы
        // -------------------------
        function loadDistricts(cityId) {
            districtSelect.innerHTML = `<option value="">Выберите район</option>`;

            districts.forEach(dist => {
                if (dist.city_id == cityId) {
                    districtSelect.innerHTML += `
                    <option value="${dist.id}">${dist.name}</option>
                `;
                }
            });
        }

        // -------------------------
        // Событие: выбор региона
        // -------------------------
        regionSelect.addEventListener('change', function() {
            loadCities(this.value);
        });

        // -------------------------
        // Событие: выбор города
        // -------------------------
        citySelect.addEventListener('change', function() {
            loadDistricts(this.value);
        });

        // ===========================================================
        // 🟢 ВОССТАНОВЛЕНИЕ old() ПРИ ЗАГРУЗКЕ СТРАНИЦЫ
        // ===========================================================

        // 1. Если ранее был выбран регион
        if (OLD_REGION) {
            regionSelect.value = OLD_REGION;
            loadCities(OLD_REGION);
        }
        // 2. Если ранее был выбран город — загрузить города и выбрать нужный
        if (OLD_CITY) {
            citySelect.value = OLD_CITY;
            loadDistricts(OLD_CITY);
        }

        // 3. Если ранее был район — выбираем его
        if (OLD_DISTRICT) {
            districtSelect.value = OLD_DISTRICT;
        }
    });
</script>
</body>

</html>
