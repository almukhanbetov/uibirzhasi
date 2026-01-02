@extends('layouts.guest')
@section('content')
    <section id="hero" class="hero section">
        <div class="container" data-aos="fade-up" data-aos-delay="100">
            {{-- ⭐ Заголовок --}}
            <div class="text-center mb-5" data-aos="fade-up" data-aos-delay="150">
                <p class="text-uppercase fw-semibold text-success mb-2" style="letter-spacing: 1.5px;">
                    Впервые в мире биржа недвижимости
                </p>
                <h1 class="fw-bold display-5 text-dark mb-3" style="font-family: 'Poppins', sans-serif;">
                    UIBIRZHASI.KZ
                </h1>
                <p class="lead text-muted" style="max-width: 600px; margin: 0 auto;">
                    <span class="text-success fw-semibold">Мы гарантируем, что продадим вашу недвижимость</span>.
                </p>
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
                        <img src="{{ asset('assets/img/real-estate/property-exterior-3.webp') }}"
                            class="img-fluid rounded-4 shadow-lg" alt="Property">

                        <div class="position-absolute top-0 end-0 bg-success text-white px-3 py-2 rounded-end-4 rounded-bottom-0 fw-semibold"
                            style="border-top-right-radius: 1rem;">
                            855 000 000 • РЕКОМЕНДУЕМЫЕ
                        </div>

                        <div class="position-absolute bottom-0 start-0 bg-white p-3 rounded-4 shadow-sm m-3"
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
                        </div>
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
                        {{-- @include('components.listings-grid', ['listings' => $listings]) --}}
                    </div>
                </div>
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
                loadCities(OLD_REGION); // загрузили города этого региона
                regionSelect.value = OLD_REGION;
            }

            // 2. Если ранее был выбран город — загрузить города и выбрать нужный
            if (OLD_CITY) {
                loadDistricts(OLD_CITY); // загрузили районы для города
                citySelect.value = OLD_CITY; // выбираем ранее выбранный город
            }

            // 3. Если ранее был район — выбираем его
            if (OLD_DISTRICT) {
                districtSelect.value = OLD_DISTRICT;
            }

        });
    </script>

</body>

</html>
