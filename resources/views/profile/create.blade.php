@extends('layouts.profile')
@section('content')
<div class="container py-4">
    <h2 class="fw-semibold mb-4" style="color:#176c61;">Добавить объявление</h2>
    {{-- Ошибки --}}
    @if($errors->any())
        <div class="alert alert-danger small py-2 px-3">
            <strong>Ошибка:</strong> проверьте поля ниже.
        </div>
    @endif
    {{-- Успех --}}
    @if(session('success'))
        <div class="alert alert-success small py-2 px-3">
            {{ session('success') }}
        </div>
    @endif
    <div class="card shadow-sm border-0 rounded-4 p-4">
        <form id="listingForm" action="{{ route('profile.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row g-3">
                {{-- Тип сделки --}}
                <div class="col-md-3">
                    <label class="form-label small text-muted mb-1">Тип сделки</label>
                    <select name="deal_type" class="form-select form-select-sm rounded-3 border-success-subtle">
                        @foreach (\App\Models\Listing::dealTypes() as $key => $label)
                            <option value="{{ $key }}" @selected(old('deal_type') === $key)>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('deal_type')<div class="invalid-feedback d-block small text-danger mt-1">{{ $message }}</div>@enderror
                </div>
                {{-- Тип недвижимости --}}
                <div class="col-md-3">
                    <label class="form-label small text-muted mb-1">Тип недвижимости</label>
                    <select name="type_id" class="form-select form-select-sm rounded-3 border-success-subtle">
                        <option value="">Выберите тип</option>
                        @foreach ($types as $type)
                            <option value="{{ $type->id }}" @selected(old('type_id') == $type->id)>{{ $type->name }}</option>
                        @endforeach
                    </select>
                    @error('type_id')<div class="invalid-feedback d-block small text-danger mt-1">{{ $message }}</div>@enderror
                </div>
                {{-- Регион --}}
                <div class="col-md-3">
                    <label class="form-label small text-muted mb-1">Регион</label>
                    <select name="region_id" id="regionSelect" class="form-select form-select-sm rounded-3 border-success-subtle">
                        <option value="">Выберите регион</option>
                        @foreach ($regions as $region)
                            <option value="{{ $region->id }}" @selected(old('region_id') == $region->id)>
                                {{ $region->name }}</option>
                        @endforeach
                    </select>
                    @error('region_id')<div class="invalid-feedback d-block small text-danger mt-1">{{ $message }}</div>@enderror
                </div>
                {{-- Город --}}
                <div class="col-md-3">
                    <label class="form-label small text-muted mb-1">Город</label>
                    <select name="city_id" id="citySelect" class="form-select form-select-sm rounded-3 border-success-subtle">
                        <option value="">Сначала выберите регион</option>
                    </select>
                    @error('city_id')<div class="invalid-feedback d-block small text-danger mt-1">{{ $message }}</div>@enderror
                </div>
                {{-- Район --}}
                <div class="col-md-3">
                    <label class="form-label small text-muted mb-1">Район</label>
                    <select name="district_id" id="districtSelect" class="form-select form-select-sm rounded-3 border-success-subtle">
                        <option value="">Сначала выберите город</option>
                    </select>
                    @error('district_id')<div class="invalid-feedback d-block small text-danger mt-1">{{ $message }}</div>@enderror
                </div>
                {{-- Карта --}}
                <div class="col-12">
                    <label class="form-label small text-muted mb-1">Местоположение на карте <span class="text-muted">(кликните, чтобы поставить метку)</span></label>
                    <div id="map-picker" style="height: 300px; border-radius: 12px; border: 1px solid #c3e6cb;"></div>
                    <input type="hidden" name="latitude"  id="lat-input"  value="{{ old('latitude') }}">
                    <input type="hidden" name="longitude" id="lng-input"  value="{{ old('longitude') }}">
                    <div id="coords-display" class="small text-muted mt-1" style="display:none;">
                        Координаты: <span id="coords-text"></span>
                        <a href="#" id="clear-marker" class="ms-2 text-danger" style="font-size:0.8rem;">✕ убрать метку</a>
                    </div>
                </div>

                {{-- Площадь --}}
                <div class="col-md-3">
                    <label class="form-label small text-muted mb-1">Площадь (м²)</label>
                    <input type="number" name="area" value="{{ old('area') }}" class="form-control form-control-sm rounded-3 border-success-subtle">
                    @error('area')<div class="invalid-feedback d-block small text-danger mt-1">{{ $message }}</div>@enderror
                </div>
                {{-- Комнат --}}
                <div class="col-md-3">
                    <label class="form-label small text-muted mb-1">Комнат</label>
                    <input type="number" name="rooms" value="{{ old('rooms') }}" class="form-control form-control-sm rounded-3 border-success-subtle">
                    @error('rooms')<div class="invalid-feedback d-block small text-danger mt-1">{{ $message }}</div>@enderror
                </div>
                {{-- Цена --}}
                <div class="col-md-3">
                    <label class="form-label small text-muted mb-1">Цена (₸)</label>
                    <input type="number" name="price_base" value="{{ old('price_base') }}" class="form-control form-control-sm rounded-3 border-success-subtle">
                    @error('price_base')<div class="invalid-feedback d-block small text-danger mt-1">{{ $message }}</div>@enderror
                </div>

                {{-- Описание --}}
                <div class="col-12">
                    <label class="form-label small text-muted mb-1">Описание</label>
                    <textarea name="description" rows="3" class="form-control form-control-sm rounded-3 border-success-subtle"
                        placeholder="Введите краткое описание...">{{ old('description') }}</textarea>
                    @error('description')<div class="invalid-feedback d-block small text-danger mt-1">{{ $message }}</div>@enderror
                </div>

                {{-- Фото --}}
                <div class="col-12">
                    <label class="form-label small text-muted mb-1">Фотографии</label>

                    <div id="dropBox" class="border rounded-4 text-center p-4 bg-light border-success-subtle"
                        style="cursor:pointer;border-style:dashed;">
                        <p class="small text-muted mb-2">Перетащите фото сюда или нажмите для выбора</p>
                        <p style="font-size:2rem;">📸</p>
                    </div>

                    <input type="file" name="photos[]" id="draftPhotos" style="display:none;" multiple accept="image/*">

                    <div id="previewArea" class="d-flex gap-2 flex-wrap mt-3"></div>

                    @error('photos')<div class="invalid-feedback d-block small text-danger mt-1">{{ $message }}</div>@enderror
                    @error('photos.*')<div class="invalid-feedback d-block small text-danger mt-1">{{ $message }}</div>@enderror

                    <small class="text-muted">Формат: JPG, PNG, WEBP. Максимум 2 МБ.</small>
                </div>

                {{-- Сохранить --}}
                <div class="col-12 text-end mt-3">
                    <button type="submit" class="btn btn-success px-4 py-2 rounded-3" style="background:#176c61;border:none;">
                        💾 Опубликовать
                    </button>
                </div>

            </div>
        </form>
    </div>

</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    /* ===========================
       🖼 DRAG & DROP + PREVIEW + REMOVE
    ============================ */
    const dropBox = document.getElementById('dropBox');
    const preview = document.getElementById('previewArea');
    const input = document.getElementById('draftPhotos');
    let selectedFiles = [];
    if (dropBox && preview && input) {
        dropBox.addEventListener('click', () => input.click());

        ['dragenter', 'dragover'].forEach(evt => {
            dropBox.addEventListener(evt, e => {
                e.preventDefault();
                dropBox.style.background = "#e8fffa";
            });
        });

        ['dragleave', 'drop'].forEach(evt => {
            dropBox.addEventListener(evt, e => {
                e.preventDefault();
                dropBox.style.background = "#f8fdfb";
            });
        });

        input.addEventListener('change', function() {
            addFiles(Array.from(input.files));
            renderPreview();
        });

        dropBox.addEventListener('drop', function(ev) {
            ev.preventDefault();
            if (ev.dataTransfer.files.length > 0) {
                addFiles(Array.from(ev.dataTransfer.files));
                renderPreview();
            }
        });

        function addFiles(files) {
            files.forEach(file => selectedFiles.push(file));
            recreateFileInput();
        }

        function recreateFileInput() {
            const dataTransfer = new DataTransfer();
            selectedFiles.forEach(file => dataTransfer.items.add(file));
            input.files = dataTransfer.files;
        }

        function renderPreview() {
            preview.innerHTML = '';
            selectedFiles.forEach((file, index) => {
                let reader = new FileReader();
                reader.onload = function(e) {
                    const wrapper = document.createElement('div');
                    wrapper.style.position = 'relative';

                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.classList.add('rounded');
                    img.style.width = "110px";
                    img.style.height = "110px";
                    img.style.objectFit = "cover";

                    const removeBtn = document.createElement('button');
                    removeBtn.innerHTML = '❌';
                    removeBtn.style.position = "absolute";
                    removeBtn.style.top = "-6px";
                    removeBtn.style.right = "-6px";
                    removeBtn.style.background = "#ff4d4d";
                    removeBtn.style.border = "none";
                    removeBtn.style.color = "white";
                    removeBtn.style.fontSize = "12px";
                    removeBtn.style.width = "20px";
                    removeBtn.style.height = "20px";
                    removeBtn.style.borderRadius = "50%";
                    removeBtn.style.cursor = "pointer";

                    removeBtn.addEventListener('click', () => {
                        selectedFiles.splice(index, 1);
                        recreateFileInput();
                        renderPreview();
                    });

                    wrapper.appendChild(img);
                    wrapper.appendChild(removeBtn);
                    preview.appendChild(wrapper);
                };
                reader.readAsDataURL(file);
            });
        }
    }

    /* ===========================
       📍 SELECT (Region → City → District)
    ============================ */
    const regionSelect   = document.getElementById('regionSelect');
    const citySelect     = document.getElementById('citySelect');
    const districtSelect = document.getElementById('districtSelect');

    const allCityOptions     = @json($cities);
    const allDistrictOptions = @json($districts);

    const OLD_REGION   = "{{ old('region_id') }}";
    const OLD_CITY     = "{{ old('city_id') }}";
    const OLD_DISTRICT = "{{ old('district_id') }}";

    function loadCities(regionId) {
        citySelect.innerHTML = '<option value="">Выберите город</option>';
        districtSelect.innerHTML = '<option value="">Сначала выберите город</option>';

        allCityOptions.forEach(city => {
            if (city.region_id == regionId) {
                citySelect.innerHTML += `<option value="${city.id}">${city.name}</option>`;
            }
        });
    }

    function loadDistricts(cityId) {
        districtSelect.innerHTML = '<option value="">Выберите район</option>';

        allDistrictOptions.forEach(dist => {
            if (dist.city_id == cityId) {
                districtSelect.innerHTML += `<option value="${dist.id}">${dist.name}</option>`;
            }
        });
    }

    regionSelect.addEventListener('change', function() {
        loadCities(this.value);
    });

    citySelect.addEventListener('change', function() {
        loadDistricts(this.value);
    });

    if (OLD_REGION) {
        loadCities(OLD_REGION);
        regionSelect.value = OLD_REGION;
    }

    if (OLD_CITY) {
        loadDistricts(OLD_CITY);
        citySelect.value = OLD_CITY;
    }

    if (OLD_DISTRICT) {
        districtSelect.value = OLD_DISTRICT;
    }

});
</script>

{{-- Leaflet --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
(function () {
    const latInput   = document.getElementById('lat-input');
    const lngInput   = document.getElementById('lng-input');
    const display    = document.getElementById('coords-display');
    const coordsText = document.getElementById('coords-text');
    const clearBtn   = document.getElementById('clear-marker');
    const citySelect = document.getElementById('citySelect');
    const districtSelect = document.getElementById('districtSelect');

    const map = L.map('map-picker').setView([43.2220, 76.8512], 12);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    let marker = null;

    const savedLat = parseFloat(latInput.value);
    const savedLng = parseFloat(lngInput.value);
    if (savedLat && savedLng) {
        marker = L.marker([savedLat, savedLng]).addTo(map);
        map.setView([savedLat, savedLng], 15);
        showCoords(savedLat, savedLng);
    }

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

    // Автоцентрирование при выборе района → города
    districtSelect.addEventListener('change', function () {
        const name = this.options[this.selectedIndex]?.text;
        if (name && name !== 'Выберите район' && name !== 'Сначала выберите город') {
            geocodeAndCenter(name + ', Казахстан', 14);
        }
    });

    citySelect.addEventListener('change', function () {
        const name = this.options[this.selectedIndex]?.text;
        if (name && name !== 'Выберите город' && name !== 'Сначала выберите регион') {
            geocodeAndCenter(name + ', Казахстан', 12);
        }
    });

    function geocodeAndCenter(query, zoom) {
        fetch('https://nominatim.openstreetmap.org/search?format=json&limit=1&q=' + encodeURIComponent(query), {
            headers: { 'Accept-Language': 'ru' }
        })
        .then(r => r.json())
        .then(data => {
            if (data.length > 0) {
                const lat = parseFloat(data[0].lat);
                const lng = parseFloat(data[0].lon);
                map.setView([lat, lng], zoom);
            }
        })
        .catch(() => {});
    }

    function placeMarker(lat, lng) {
        if (marker) marker.remove();
        marker = L.marker([lat, lng]).addTo(map);
        latInput.value = lat.toFixed(7);
        lngInput.value = lng.toFixed(7);
        showCoords(lat.toFixed(5), lng.toFixed(5));
    }

    function showCoords(lat, lng) {
        coordsText.textContent = lat + ', ' + lng;
        display.style.display = 'block';
    }
})();
</script>
@endpush
