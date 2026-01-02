@extends('layouts.profile')
@section('content')
    <div class="container">
        <a href="{{ route('profile.matches.index') }}" class="btn btn-outline-secondary mb-3">
            ← Назад к списку
        </a>
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h4 class="fw-bold">
                    Сделка № {{ $match->id }}
                </h4>
                <div class="mt-2">
                    Статус:
                    @include('components.status-badge', ['status' => $match->status])
                </div>
            </div>
        </div>
        <div class="card shadow-sm mt-4">
            <div class="card-body">
                <h5 class="fw-bold">📜 История сделки</h5>

                <ul class="list-group">
                    @foreach ($match->logs as $log)
                        <li class="list-group-item">
                            {{ $log->created_at->format('d.m.Y H:i') }}
                            — <b>{{ $log->action }}</b>
                            <br>
                            {{ $log->details }}
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        {{-- ==== УЧАСТНИКИ СДЕЛКИ ==== --}}
        <div class="row">
            {{-- Покупатель --}}
            <div class="col-md-6">
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-body">
                        <h5 class="fw-bold text-primary">
                            Покупатель
                            @if ($match->buyer_id === auth()->id())
                                <span class="badge bg-success ms-2">это вы</span>
                            @endif
                        </h5>
                        <div>
                            Имя: <strong>{{ $match->buyer?->name ?? '—' }}</strong>
                        </div>

                        <div class="text-muted">
                            Цена заявки:
                            {{ number_format($match->buy_price, 0, '.', ' ') }} ₸
                        </div>
                    </div>
                </div>
            </div>
            {{-- Продавец --}}
            <div class="col-md-6">
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-body">
                        <h5 class="fw-bold text-danger">
                            Продавец
                            @if ($match->seller_id === auth()->id())
                                <span class="badge bg-success ms-2">это вы</span>
                            @endif
                        </h5>
                        <div>
                            Имя: <strong>{{ $match->seller?->name ?? '—' }}</strong>
                        </div>
                        <div class="text-muted">
                            Цена продажи:
                            {{ number_format($match->sale_price, 0, '.', ' ') }} ₸
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- ==== ФИНАЛЬНАЯ ЦЕНА ==== --}}
        <div class="card shadow-sm mb-4">
            <div class="card-body text-center">
                <h5 class="text-muted">ФИНАЛЬНАЯ ЦЕНА</h5>
                <div class="display-6 fw-bold text-success">
                    {{ number_format($match->final_price, 0, '.', ' ') }} ₸
                </div>
            </div>
        </div>
        {{-- ==== ДЕПОЗИТ / ДОСТУП К КОНТАКТАМ ==== --}}
        @php
            $hasDeposit = $match
                ->deposits()
                ->where('user_id', auth()->id())
                ->where('status', 'paid')
                ->exists();
        @endphp
        @if ($match->status === 'contacts_open' || $hasDeposit)
            <div class="alert alert-success">
                Контакты контрагента открыты
            </div>
            @php
                $counterparty = $match->counterpartyFor(auth()->user());
            @endphp
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="fw-bold">Контакты контрагента</h5>
                    <div>
                        Имя: {{ $counterparty->name }}
                    </div>
                    <div>
                        Телефон: {{ $counterparty->phone }}
                    </div>
                </div>
            </div>
        @elseif($match->status === 'awaiting_deposit')
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="fw-bold text-warning">
                        Для открытия контактов необходимо внести депозит — 1%
                    </h5>
                    <form method="POST" action="{{ route('matches.deposit', $match) }}">
                        @csrf
                        <button class="btn btn-success btn-lg mt-2">
                            Внести депозит
                            ({{ number_format(round($match->final_price * 0.01), 0, '.', ' ') }} ₸)
                        </button>
                    </form>

                </div>
            </div>
        @endif
    </div>
@endsection
