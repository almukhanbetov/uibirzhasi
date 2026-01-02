@extends('layouts.profile')
@section('content')
    <h2 class="fw-semibold mb-4" style="color:#163f3c;">Профайл {{ $user->name }}</h2>
    <div class="row g-4 mb-5">
    </div>
    <h5 class="fw-semibold mb-3" style="color:#163f3c;">Последние объявления</h5>
    <div class="table-responsive shadow-sm rounded-4 bg-white">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Тип</th>
                    <th>Тип сделки</th>
                    <th>Город</th>
                    <th>Фото</th>
                    <th>Цена</th>
                    <th>Статус</th>
                    <th class="text-center">Действия</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($listings as $listing)
                    <tr>
                        <td>{{ $listing->id }}</td>
                        <td>{{ $listing->type->name ?? '-' }}</td>
                        {{-- <td>{{ $listing->deal_type ?? '-' }}</td> --}}
                        <td>
                            <span class="badge {{ $listing->deal_type === 'sale' ? 'bg-success' : 'bg-primary' }}">
                                {{ $listing->deal_name }}
                            </span>
                        </td>
                        <td>{{ $listing->city->name ?? '-' }}</td>
                        <td>
                            @if ($listing->photos->isNotEmpty())
                                <img src="{{ asset($listing->photos->first()->url) }}" alt="Фото" width="60"
                                    height="40" style="object-fit: cover;">
                            @else
                                <img src="{{ asset('storage/images/no-image.png') }}" alt="Нет фото" width="60"
                                    height="40">
                            @endif
                        </td>
                        <td>{{ number_format($listing->price_base, 0, ',', ' ') }} ₸</td>
                        <td>
                            @include('components.status-badge', ['status' => $listing->status])
                        </td>
                        <td class="text-center">
                            <a href="{{ route('profile.show', $listing->id) }}" class="btn btn-sm btn-outline-info me-1"
                                title="Просмотр">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('profile.edit', $listing->id) }}" class="btn btn-sm btn-outline-primary me-1"
                                title="Редактировать">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('profile.destroy', $listing->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Удалить"
                                    onclick="return confirm('Удалить объявление?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
