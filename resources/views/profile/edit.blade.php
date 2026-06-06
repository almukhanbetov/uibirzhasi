@extends('layouts.profile')
@section('content')
    <section id="hero" class="hero section">
        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <div class="row align-items-start">
                <div class="col-lg-6">
                    <h2 class="mb-4 text-center">Редактировать объявление</h2>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>Ошибка:</strong> проверьте поля ниже.
                        </div>
                    @endif
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    {{-- ОДНА ФОРМА --}}
                    <form action="{{ route('profile.update', $listing->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row g-3">
                            <div class="col-md-3">
                                <div class="form-floating">
                                    <select name="deal_type" class="form-select" required>
                                        <option value="sale" @selected(old('deal_type', $listing->deal_type) == 'sale')>Продажа</option>
                                        <option value="buy" @selected(old('deal_type', $listing->deal_type) == 'buy')>Покупка</option>
                                    </select>
                                    <label>Тип сделки</label>
                                </div>
                            </div>
                            {{-- Тип --}}
                            <div class="col-md-3">
                                <div class="form-floating">
                                    <select name="type_id" class="form-select" required>
                                        <option value="">Выберите тип</option>
                                        @foreach ($types as $t)
                                            <option value="{{ $t->id }}" @selected(old('type_id', $listing->type_id) == $t->id)>
                                                {{ $t->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label>Тип недвижимости 1</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating">
                                    <select id="region" name="region_id" class="form-select" required>
                                        <option value="">Выберите регион</option>
                                        @foreach ($regions as $region)
                                            <option value="{{ $region->id }}" @selected(old('region_id', $listing->region_id) == $region->id)>
                                                {{ $region->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label>Регионы</label>
                                </div>
                            </div>

                            {{-- Город --}}
                            <div class="col-md-3">
                                <div class="form-floating">
                                    <select id="city" name="city_id" class="form-select" required>
                                        <option value="">Выберите город</option>
                                        @foreach ($cities as $c)
                                            <option value="{{ $c->id }}" @selected(old('city_id', $listing->city_id) == $c->id)>
                                                {{ $c->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label>Город</label>
                                </div>
                            </div>

                            {{-- Район --}}
                            <div class="col-md-3">
                                <div class="form-floating">
                                    <select id="district" name="district_id" class="form-select" required>
                                        <option value="">Выберите район</option>
                                        @foreach ($districts as $d)
                                            <option value="{{ $d->id }}" @selected(old('district_id', $listing->district_id) == $d->id)>
                                                {{ $d->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label>Район</label>
                                </div>
                            </div>

                            {{-- Карта --}}
                            <div class="col-12">
                                <label class="form-label small text-muted mb-1">
                                    Местоположение на карте <span class="text-muted">(кликните, чтобы поставить метку)</span>
                                </label>
                                <div id="map-picker" style="height: 300px; border-radius: 12px; border: 1px solid #c3e6cb;"></div>
                                <input type="hidden" name="latitude"  id="lat-input"  value="{{ old('latitude', $listing->latitude) }}">
                                <input type="hidden" name="longitude" id="lng-input"  value="{{ old('longitude', $listing->longitude) }}">
                                <div id="coords-display" class="small text-muted mt-1" style="{{ ($listing->latitude && $listing->longitude) ? '' : 'display:none;' }}">
                                    Координаты: <span id="coords-text">{{ $listing->latitude }}, {{ $listing->longitude }}</span>
                                    <a href="#" id="clear-marker" class="ms-2 text-danger" style="font-size:0.8rem;">✕ убрать метку</a>
                                </div>
                            </div>

                            {{-- Площадь, комнаты, цена --}}
                            <div class="col-md-3">
                                <div class="form-floating">
                                    <input type="number" step="0.1" name="area" class="form-control"
                                        value="{{ $listing->area }}">
                                    <label>Площадь (м²)</label>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-floating">
                                    <input type="number" name="rooms" class="form-control" value="{{ $listing->rooms }}"
                                        required>
                                    <label>Комнат</label>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-floating">
                                    <input type="number" name="price_base" class="form-control"
                                        value="{{ $listing->price_base }}" required>
                                    <label>Цена в тенге</label>
                                </div>
                            </div>

                            {{-- Описание --}}
                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea class="form-control" name="description" placeholder="Описание">{{ $listing->description }}</textarea>
                                    <label>Описание</label>
                                </div>
                            </div>

                            {{-- Фото --}}
                            <div class="col-12">
                                <label class="form-label">Фотографии объекта</label>
                                <input type="file" name="photos[]" multiple class="form-control" accept="image/*">
                                <small class="text-muted">Можно выбрать сразу несколько изображений (до 4 МБ каждое)</small>
                            </div>

                            {{-- Кнопка сохранения --}}
                            <div class="col-12 mt-3">
                                <button type="submit" class="btn btn-success w-100">
                                    💾 Сохранить изменения
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                {{-- Правая колонка: просмотр фото --}}
                <div class="col-lg-6">
                    <h4 class="mb-3">Текущие фото</h4>

                    @if ($listing->photos->count())
                        <div class="row g-3">
                            @foreach ($listing->photos as $photo)
                                <div class="col-md-6 position-relative">
                                    <img src="{{ asset($photo->url) }}" class="img-fluid rounded shadow-sm"
                                        style="object-fit:cover; height:200px; width:100%;">
                                    <form
                                        action="{{ route('profile.listings.photos.delete', [$listing->id, $photo->id]) }}"
                                        method="POST" class="position-absolute top-0 end-0 m-1">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm px-2 py-1">✕</button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted">Фотографии пока не добавлены.</p>
                    @endif
                </div>
            </div>
        </div>
    </section>

@endsection
@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const region = document.getElementById('region');
            const city = document.getElementById('city');
            const district = document.getElementById('district');

            // --- Значения для восстановления ---
            const oldRegion = "{{ old('region_id', $listing->region_id ?? '') }}";
            const oldCity = "{{ old('city_id', $listing->city_id ?? '') }}";
            const oldDistrict = "{{ old('district_id', $listing->district_id ?? '') }}";

            // ------------------------------------------
            // 1. ЗАГРУЗКА ОБЛАСТЕЙ
            // ------------------------------------------
            fetch('/regions')
                .then(r => r.json())
                .then(data => {

                    region.innerHTML = '<option value="">Выберите регион</option>';

                    data.forEach(r => {
                        region.innerHTML += `<option value="${r.id}">${r.name}</option>`;
                    });

                    // --- Выбрать область при редактировании ---
                    if (oldRegion) {
                        region.value = oldRegion;
                        loadCities(oldRegion, true);
                    }
                });

            region.addEventListener('change', function() {
                loadCities(this.value, false);
            });

            // ------------------------------------------
            // 2. ЗАГРУЗКА ГОРОДОВ
            // ------------------------------------------
            function loadCities(regionId, restoreCity) {
                city.innerHTML = '<option value="">Загрузка...</option>';
                city.disabled = true;

                district.innerHTML = '<option value="">Сначала выберите город</option>';
                district.disabled = true;

                if (!regionId) {
                    return;
                }

                fetch(`/cities/${regionId}`)
                    .then(r => r.json())
                    .then(data => {

                        city.innerHTML = '<option value="">Выберите город</option>';

                        data.forEach(c => {
                            city.innerHTML += `<option value="${c.id}">${c.name}</option>`;
                        });

                        city.disabled = false;

                        // --- Выбрать город при редактировании ---
                        if (restoreCity && oldCity) {
                            city.value = oldCity;
                            loadDistricts(oldCity, true);
                        }
                    });
            }

            city.addEventListener('change', function() {
                loadDistricts(this.value, false);
            });

            // ------------------------------------------
            // 3. ЗАГРУЗКА РАЙОНОВ
            // ------------------------------------------
            function loadDistricts(cityId, restoreDistrict) {
                district.innerHTML = '<option value="">Загрузка...</option>';
                district.disabled = true;

                if (!cityId) return;

                fetch(`/districts/${cityId}`)
                    .then(r => r.json())
                    .then(data => {

                        district.innerHTML = '<option value="">Выберите район</option>';

                        data.forEach(d => {
                            district.innerHTML += `<option value="${d.id}">${d.name}</option>`;
                        });

                        district.disabled = false;

                        // --- Выбрать район при редактировании ---
                        if (restoreDistrict && oldDistrict) {
                            district.value = oldDistrict;
                        }
                    });
            }

        });
    </script>

    {{-- Leaflet map picker --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
    (function () {
        const latInput      = document.getElementById('lat-input');
        const lngInput      = document.getElementById('lng-input');
        const display       = document.getElementById('coords-display');
        const coordsText    = document.getElementById('coords-text');
        const clearBtn      = document.getElementById('clear-marker');
        const citySelect    = document.getElementById('city');
        const districtSelect = document.getElementById('district');

        const savedLat = parseFloat(latInput.value) || 43.2220;
        const savedLng = parseFloat(lngInput.value) || 76.8512;
        const hasCoords = latInput.value && lngInput.value;

        const map = L.map('map-picker').setView([savedLat, savedLng], hasCoords ? 16 : 12);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        let marker = hasCoords ? L.marker([savedLat, savedLng]).addTo(map) : null;

        map.on('click', function (e) {
            const { lat, lng } = e.latlng;
            placeMarker(lat, lng);
        });

        clearBtn.addEventListener('click', function (e) {
            e.preventDefault();
            if (marker) { marker.remove(); marker = null; }
            latInput.value = '';
            lngInput.value = '';
            display.style.display = 'none';
        });

        // Автоцентрирование при смене района → города
        if (districtSelect) {
            districtSelect.addEventListener('change', function () {
                const name = this.options[this.selectedIndex]?.text;
                if (name && name !== 'Выберите район') {
                    geocodeAndCenter(name + ', Казахстан', 14);
                }
            });
        }

        if (citySelect) {
            citySelect.addEventListener('change', function () {
                const name = this.options[this.selectedIndex]?.text;
                if (name && name !== 'Выберите город') {
                    geocodeAndCenter(name + ', Казахстан', 12);
                }
            });
        }

        function geocodeAndCenter(query, zoom) {
            fetch('https://nominatim.openstreetmap.org/search?format=json&limit=1&q=' + encodeURIComponent(query), {
                headers: { 'Accept-Language': 'ru' }
            })
            .then(r => r.json())
            .then(data => {
                if (data.length > 0) {
                    map.setView([parseFloat(data[0].lat), parseFloat(data[0].lon)], zoom);
                }
            })
            .catch(() => {});
        }

        function placeMarker(lat, lng) {
            if (marker) marker.remove();
            marker = L.marker([lat, lng]).addTo(map);
            latInput.value = lat.toFixed(7);
            lngInput.value = lng.toFixed(7);
            coordsText.textContent = lat.toFixed(5) + ', ' + lng.toFixed(5);
            display.style.display = 'block';
        }
    })();
    </script>
@endsection
