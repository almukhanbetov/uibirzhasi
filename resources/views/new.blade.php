@extends('layouts.guest')
@section('content')
    <div class="container mt-5">
        <h2 class="mb-4">Выбор региона, города и района</h2>
        {{-- РЕГИОН --}}
        <div class="mb-3">
            <label class="form-label">Регион</label>
            <select id="regionSelect" class="form-select">
                <option value="">Все регионы</option>
                @foreach ($regions as $region)
                    <option value="{{ $region->id }}">{{ $region->name }}</option>
                @endforeach
            </select>
        </div>
        {{-- ГОРОД --}}
        <div class="mb-3">
            <label class="form-label">Город</label>
            <select id="citySelect" class="form-select">
                <option value="">Все города</option>
                @foreach ($cities as $city)
                    <option value="{{ $city->id }}" data-region="{{ $city->region_id }}">
                        {{ $city->name }}
                    </option>
                @endforeach
            </select>
        </div>
        {{-- РАЙОН --}}
        <div class="mb-3">
            <label class="form-label">Район</label>
            <select id="districtSelect" class="form-select">
                <option value="">Все районы</option>
                @foreach ($districts as $district)
                    <option value="{{ $district->id }}" data-city="{{ $district->city_id }}">
                        {{ $district->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    {{-- ===== JS ===== --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const regionSelect = document.getElementById('regionSelect');
            const citySelect = document.getElementById('citySelect');
            const districtSelect = document.getElementById('districtSelect');

            // Фильтрация ГОРОДОВ по региону
            regionSelect.addEventListener('change', () => {
                const regionId = regionSelect.value;
                [...citySelect.options].forEach(opt => {
                    if (!opt.value) return;
                    opt.hidden = (opt.dataset.region !== regionId);
                });
                citySelect.value = "";
                districtSelect.value = "";
            });
            // Фильтрация РАЙОНОВ по городу
            citySelect.addEventListener('change', () => {
                const cityId = citySelect.value;
                [...districtSelect.options].forEach(opt => {
                    if (!opt.value) return;
                    opt.hidden = (opt.dataset.city !== cityId);
                });

                districtSelect.value = "";
            });
        });
    </script>
@endsection
