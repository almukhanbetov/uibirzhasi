@extends("layouts.guest")
@section("content")
<div class="page-title">
    <div class="heading">
        <div class="container">
            <div class="row d-flex justify-content-center text-center">
                <div class="col-lg-8">
                    <h1 class="heading-title">{{ optional($listing->type)->name ?? 'Объявление' }}</h1>
                    <p class="mb-0">{{ $listing->description }}</p>
                </div>
            </div>
        </div>
    </div>
    <nav class="breadcrumbs">
        <div class="container">
            <ol>
                <li><a href="{{ route('welcome') }}">Главная</a></li>
                <li class="current">Детальный обзор</li>
            </ol>
        </div>
    </nav>
</div>
<section id="property-details" class="property-details section">
    <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row gy-4">
            <div class="col-lg-8">

                {{-- Главное фото --}}
                @if($listing->photos->count())
                    <div class="main-image mb-3 text-center">
                        <img id="main-photo"
                             src="{{ asset($listing->photos->first()->url) }}"
                             class="img-fluid rounded shadow-sm"
                             style="object-fit: cover; width: 100%; max-height: 500px;"
                             alt="Основное фото">
                    </div>

                    {{-- Галерея миниатюр --}}
                    @if($listing->photos->count() > 1)
                    <div class="thumbnail-gallery d-flex flex-wrap gap-2 justify-content-center mb-3">
                        @foreach($listing->photos as $photo)
                            <img src="{{ asset($photo->url) }}"
                                 class="img-thumbnail"
                                 style="width: 120px; height: 100px; object-fit: cover; cursor: pointer;"
                                 onclick="document.getElementById('main-photo').src='{{ asset($photo->url) }}'">
                        @endforeach
                    </div>
                    @endif
                @else
                    <div class="main-image mb-3 text-center">
                        <img src="{{ asset('images/no-image.png') }}"
                             class="img-fluid rounded shadow-sm"
                             style="object-fit: cover; width: 100%; max-height: 500px;"
                             alt="Фото отсутствует">
                    </div>
                @endif

                {{-- Описание --}}
                <div class="property-description" data-aos="fade-up" data-aos-delay="300">
                    <h3>{{ optional($listing->type)->name ?? 'Объявление' }}</h3>
                    @if($listing->description)
                        <p>{{ $listing->description }}</p>
                    @endif
                </div>

                <div class="property-map" data-aos="fade-up" data-aos-delay="500">
                    <h3>Местонахождение</h3>
                    <div class="map-container">
                        @if($listing->latitude && $listing->longitude)
                            <div id="listing-map" style="height: 400px; border-radius: 8px;"></div>
                        @else
                            {{-- Fallback: поиск по городу через OpenStreetMap --}}
                            @php
                                $searchQuery = collect([
                                    optional($listing->district)->name,
                                    optional($listing->city)->name,
                                    optional($listing->region)->name,
                                    'Казахстан'
                                ])->filter()->implode(', ');
                            @endphp
                            <iframe
                                src="https://maps.google.com/maps?q={{ urlencode($searchQuery) }}&output=embed"
                                width="100%" height="400"
                                style="border:0; border-radius:8px;"
                                allowfullscreen="" loading="lazy">
                            </iframe>
                            <p class="small text-muted mt-1">
                                <i class="bi bi-info-circle"></i>
                                Точный адрес не указан — показан район: {{ $searchQuery }}
                            </p>
                        @endif
                    </div>
                </div>

            </div>

            <div class="col-lg-4">

                <div class="property-overview sticky-top" data-aos="fade-up" data-aos-delay="200">

                    <div class="price-tag">
                        {{ number_format($listing->price_current ?? $listing->price_base, 0, '.', ' ') }} ₸
                    </div>

                    <div class="property-status">
                        {{ $listing->deal_type === 'sale' ? 'Продажа' : 'Покупка' }}
                    </div>

                    <div class="property-address">
                        @if(optional($listing->city)->name)
                            <h4>{{ $listing->city->name }}</h4>
                        @endif
                        @if(optional($listing->district)->name)
                            <p>{{ $listing->district->name }}</p>
                        @endif
                        @if(optional($listing->region)->name)
                            <p class="text-muted small">{{ $listing->region->name }}</p>
                        @endif
                    </div>

                    <div class="property-stats">
                        <div class="stat-item">
                            <i class="bi bi-house"></i>
                            <div>
                                <span class="value">{{ $listing->rooms }}</span>
                                <span class="label">Комнат</span>
                            </div>
                        </div>
                        @if($listing->area)
                        <div class="stat-item">
                            <i class="bi bi-rulers"></i>
                            <div>
                                <span class="value">{{ $listing->area }}</span>
                                <span class="label">м²</span>
                            </div>
                        </div>
                        @endif
                        <div class="stat-item">
                            <i class="bi bi-graph-down-arrow"></i>
                            <div>
                                <span class="value">{{ $listing->price_step_pct }}%</span>
                                <span class="label">Шаг / {{ $listing->price_step_days }} дн.</span>
                            </div>
                        </div>
                    </div>

                    <!-- Agent Info -->
                    <div class="agent-info">
                        <div class="agent-avatar">
                            <img src="{{ asset('assets/img/real-estate/agent-3.webp') }}" alt="Продавец" class="img-fluid">
                        </div>
                        <div class="agent-details">
                            <h4>{{ optional($listing->user)->name ?? 'Пользователь' }}</h4>
                            @if(optional($listing->user)->phone)
                                <p class="agent-phone"><i class="bi bi-telephone"></i> {{ $listing->user->phone }}</p>
                            @endif
                            @if(optional($listing->user)->email)
                                <p class="agent-email"><i class="bi bi-envelope"></i> {{ $listing->user->email }}</p>
                            @endif
                        </div>
                    </div>

                    <!-- Contact Form -->
                    <div class="contact-form">
                        <h4>Связаться с продавцом</h4>
                        <form action="#" method="post" class="php-email-form">
                            @csrf
                            <div class="row">
                                <div class="col-12 form-group">
                                    <input type="text" name="name" class="form-control" placeholder="Ваше имя" required>
                                </div>
                                <div class="col-12 form-group">
                                    <input type="email" name="email" class="form-control" placeholder="Ваш Email" required>
                                </div>
                                <div class="col-12 form-group">
                                    <input type="tel" name="phone" class="form-control" placeholder="Ваш телефон">
                                </div>
                                <div class="col-12 form-group">
                                    <textarea class="form-control" name="message" rows="4" placeholder="Ваше сообщение"></textarea>
                                </div>
                                <div class="col-12 text-center">
                                    <button type="submit" class="btn btn-primary">Отправить</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Social Share -->
                    <div class="social-share">
                        <h5>Поделиться</h5>
                        <div class="share-buttons">
                            <a href="#" class="share-btn facebook"><i class="bi bi-facebook"></i></a>
                            <a href="#" class="share-btn twitter"><i class="bi bi-twitter"></i></a>
                            <a href="#" class="share-btn whatsapp"><i class="bi bi-whatsapp"></i></a>
                            <a href="#" class="share-btn email"><i class="bi bi-envelope"></i></a>
                            <a href="#" class="share-btn print"><i class="bi bi-printer"></i></a>
                        </div>
                    </div>

                </div><!-- End Property Overview -->

            </div>

        </div>
    </div>
</section>
@endsection

@if($listing->latitude && $listing->longitude)
@section('scripts')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const lat = {{ $listing->latitude }};
    const lng = {{ $listing->longitude }};
    const map = L.map('listing-map').setView([lat, lng], 16);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);
    L.marker([lat, lng])
        .addTo(map)
        .bindPopup('{{ optional($listing->type)->name ?? "Объявление" }}')
        .openPopup();
});
</script>
@endsection
@endif
