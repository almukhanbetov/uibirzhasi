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
                        @include('components.listings-grid', ['listings' => $listings])
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Terms Of Service Section -->
    <section id="terms-of-service" class="terms-of-service section">

        <div class="container" data-aos="fade-up">
            <!-- Page Header -->
            <div class="tos-header text-center" data-aos="fade-up">
                {{-- <span class="last-updated">Last Updated: February 27, 2025</span> --}}
                {{-- <h2>Сведения о работе Биржи Недвижимости</h2> --}}
                {{-- <p>Please read these terms of service carefully before using our services</p> --}}
            </div>

            <!-- Content -->
            <div class="tos-content" data-aos="fade-up" data-aos-delay="200">
                <!-- Agreement Section -->
                <div id="agreement" class="content-section">
                    <h3>1. Сведения о работе Биржи Недвижимости</h3>

                    <p>Тарифы: 1% от стоимости недвижимости для Продавца и Покупателя недвижимости.</p>
                    <div class="info-box">
                        <i class="bi bi-info-circle"></i>
                        <p>Ежедневно в 00.00 Астаны у продавцов недижимости цена падает на 1%.</p>
                        <i class="bi bi-info-circle"></i>
                        <p>Ежедневно в 00.00 Астаны у покупателей недижимости цена поднимается на 1%.</p>
                    </div>
                    <div class="info-box">

                        <i class="bi bi-info-circle"></i>
                        <p>При совпадении цен с точностью до 2% и основных характеристик недвижимости продавцу и покупателю
                            на ватсап высылаются уведомления.</p>
                        <i class="bi bi-info-circle"></i>
                        <p>После получения уведомления на ватсап Пользователь заходит в личный кабинет, вносит депозит в
                            размере 1% от цены недвижимости и видит контакты контрагента. </p>
                    </div>
                    <div class="alert-box">
                        <i class="bi bi-exclamation-triangle"></i>
                        <div class="alert-content">
                            <h5>Важное уведомление</h5>
                            <p>После получения уведомления на ватсап Пользователь заходит в личный кабинет, вносит депозит в
                                размере 1% от цены недвижимости и видит контакты контрагента.</p>
                        </div>
                    </div>
                </div>

                <!-- Intellectual Property -->
                {{-- <div id="intellectual-property" class="content-section">
                    <h3>2. Intellectual Property Rights</h3>
                    <p>Our service and its original content, features, and functionality are owned by us and are protected
                        by international copyright, trademark, patent, trade secret, and other intellectual property laws.
                    </p>
                    <ul class="list-items">
                        <li>All content is our exclusive property</li>
                        <li>You may not copy or modify the content</li>
                        <li>Our trademarks may not be used without permission</li>
                        <li>Content is for personal, non-commercial use only</li>
                    </ul>
                </div> --}}

                <!-- User Accounts -->
                {{-- <div id="user-accounts" class="content-section">
                    <h3>3. User Accounts</h3>
                    <p>When you create an account with us, you must provide accurate, complete, and current information.
                        Failure to do so constitutes a breach of the Terms, which may result in immediate termination of
                        your account.</p>
                    <div class="alert-box">
                        <i class="bi bi-exclamation-triangle"></i>
                        <div class="alert-content">
                            <h5>Important Notice</h5>
                            <p>You are responsible for safeguarding the password and for all activities that occur under
                                your account.</p>
                        </div>
                    </div>
                </div> --}}

                <!-- Prohibited Activities -->
                {{-- <div id="prohibited" class="content-section">
                    <h3>4. Prohibited Activities</h3>
                    <p>You may not access or use the Service for any purpose other than that for which we make it available.
                    </p>
                    <div class="prohibited-list">
                        <div class="prohibited-item">
                            <i class="bi bi-x-circle"></i>
                            <span>Systematic retrieval of data or content</span>
                        </div>
                        <div class="prohibited-item">
                            <i class="bi bi-x-circle"></i>
                            <span>Publishing malicious content</span>
                        </div>
                        <div class="prohibited-item">
                            <i class="bi bi-x-circle"></i>
                            <span>Engaging in unauthorized framing</span>
                        </div>
                        <div class="prohibited-item">
                            <i class="bi bi-x-circle"></i>
                            <span>Attempting to gain unauthorized access</span>
                        </div>
                    </div>
                </div> --}}

                <!-- Disclaimers -->
                {{-- <div id="disclaimer" class="content-section">
                    <h3>5. Disclaimers</h3>
                    <p>Your use of our service is at your sole risk. The service is provided "AS IS" and "AS AVAILABLE"
                        without warranties of any kind, whether express or implied.</p>
                    <div class="disclaimer-box">
                        <p>We do not guarantee that:</p>
                        <ul>
                            <li>The service will meet your requirements</li>
                            <li>The service will be uninterrupted or error-free</li>
                            <li>Results from using the service will be accurate</li>
                            <li>Any errors will be corrected</li>
                        </ul>
                    </div>
                </div> --}}

                <!-- Limitation of Liability -->
                {{-- <div id="limitation" class="content-section">
                    <h3>6. Limitation of Liability</h3>
                    <p>In no event shall we be liable for any indirect, punitive, incidental, special, consequential, or
                        exemplary damages arising out of or in connection with your use of the service.</p>
                </div>

                <!-- Indemnification -->
                <div id="indemnification" class="content-section">
                    <h3>7. Indemnification</h3>
                    <p>You agree to defend, indemnify, and hold us harmless from and against any claims, liabilities,
                        damages, losses, and expenses arising out of your use of the service.</p>
                </div>

                <!-- Termination -->
                <div id="termination" class="content-section">
                    <h3>8. Termination</h3>
                    <p>We may terminate or suspend your account immediately, without prior notice or liability, for any
                        reason whatsoever, including without limitation if you breach the Terms.</p>
                </div> --}}

                <!-- Governing Law -->
                {{-- <div id="governing-law" class="content-section">
                    <h3>9. Governing Law</h3>
                    <p>These Terms shall be governed by and construed in accordance with the laws of [Your Country], without
                        regard to its conflict of law provisions.</p>
                </div>

                <!-- Changes -->
                <div id="changes" class="content-section">
                    <h3>10. Changes to Terms</h3>
                    <p>We reserve the right to modify or replace these Terms at any time. We will provide notice of any
                        changes by posting the new Terms on this page.</p>
                    <div class="notice-box">
                        <i class="bi bi-bell"></i>
                        <p>By continuing to access or use our service after those revisions become effective, you agree to
                            be bound by the revised terms.</p>
                    </div>
                </div>
            </div> --}}

                <!-- Contact Section -->
                {{-- <div class="tos-contact" data-aos="fade-up" data-aos-delay="300">
                    <div class="contact-box">
                        <div class="contact-icon">
                            <i class="bi bi-envelope"></i>
                        </div>
                        <div class="contact-content">
                            <h4>Questions About Terms?</h4>
                            <p>If you have any questions about these Terms, please contact us.</p>
                            <a href="#" class="contact-link">Contact Support</a>
                        </div>
                    </div>
                </div> --}}
            </div>

    </section><!-- /Terms Of Service Section -->
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
