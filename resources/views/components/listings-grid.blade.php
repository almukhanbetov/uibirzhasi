<div class="properties-grid view-grid active" data-aos="fade-up" data-aos-delay="200">
    <div class="row g-4">
        @forelse($listings as $listing)
            <div class="col-lg-4 col-md-4">
                <div class="property-card">
                    {{-- 🖼 Блок фото со слайдером --}}
                    <div class="property-image position-relative">
                        @if ($listing->photos->isNotEmpty())
                            <div id="carouselListing{{ $listing->id }}" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner rounded" style="max-height: 300px;">
                                    @foreach ($listing->photos as $index => $photo)
                                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                            <img src="{{ asset($photo->url) }}" alt="Фото объявления"
                                                class="d-block w-100 img-fluid"
                                                style="object-fit: cover; height: 300px;">
                                        </div>
                                    @endforeach
                                </div>
                                {{-- Кнопки переключения --}}
                                @if ($listing->photos->count() > 1)
                                    <button class="carousel-control-prev" type="button"
                                        data-bs-target="#carouselListing{{ $listing->id }}" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon bg-dark rounded-circle p-2"
                                            aria-hidden="true"></span>
                                        <span class="visually-hidden">Назад</span>
                                    </button>
                                    <button class="carousel-control-next" type="button"
                                        data-bs-target="#carouselListing{{ $listing->id }}" data-bs-slide="next">
                                        <span class="carousel-control-next-icon bg-dark rounded-circle p-2"
                                            aria-hidden="true"></span>
                                        <span class="visually-hidden">Вперёд</span>
                                    </button>
                                @endif
                            </div>
                        @else
                            <img src="{{ asset('images/no-image.png') }}" alt="Нет фото"
                                class="img-fluid rounded" style="object-fit: cover; height: 300px;">
                        @endif
                        {{-- Overlay --}}
                        <div class="property-overlay">
                            <button class="favorite-btn"><i class="bi bi-heart"></i></button>
                            <button class="gallery-btn" data-count="{{ $listing->photos->count() }}"><i
                                    class="bi bi-images"></i></button>
                        </div>
                    </div>
                    {{-- Остальная часть карточки --}}
                    <div class="property-content">
                        <div class="property-price">{{ $listing->price_current }} ₸</div>
                        <h4 class="property-title">{{ $listing->type->name }}, {{ $listing->deal_name }}</h4>
                        <p class="property-location">
                            <i class="bi bi-geo-alt"></i>{{ $listing->city->name }}, {{ $listing->district->name }}
                        </p>
                        <div class="property-features">
                            <span><i class="bi bi-house"></i>{{ $listing->rooms }} комн.</span>
                            <span><i class="bi bi-water"></i>{{ $listing->area }} площ.</span>
                            <span style="color: green;">&#8376; {{ $listing->price_base }}</span>
                        </div>
                        <div class="property-agent">
                            <div style="
                                width: 36px; height: 36px; border-radius: 50%;
                                background: #176c61; color: #fff;
                                display: flex; align-items: center; justify-content: center;
                                font-size: 0.95rem; font-weight: 700; flex-shrink: 0;
                            ">{{ mb_strtoupper(mb_substr($listing->user->name ?? 'П', 0, 1)) }}</div>
                            <div class="agent-info">
                                <strong>{{ $listing->user->name }}</strong>
                            </div>
                        </div>
                        <a href="{{ route('listings.show', $listing->id) }}" class="btn btn-primary w-100">Детальный
                            обзор</a>
                    </div>

                </div>
            </div>
        @empty
            <div class="text-center text-muted py-5">
                <i class="bi bi-search fs-2 d-block mb-2"></i>
                Нет подходящих объявлений.
            </div>
        @endforelse
    </div>
</div>
