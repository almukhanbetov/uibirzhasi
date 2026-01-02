@extends('admin.layout.admin')

@section('admin')
    <h3>Сделка № {{ $match->id }}</h3>

    @include('components.status-badge', ['status' => $match->status])

    <hr>

    <h5>Покупатель</h5>
    <p>{{ $match->buyer?->name }} — {{ $match->buyer?->phone }}</p>

    <h5>Продавец</h5>
    <p>{{ $match->seller?->name }} — {{ $match->seller?->phone }}</p>

    <h5>Цена сделки</h5>
    <p>{{ number_format($match->final_price, 0, '.', ' ') }} ₸</p>

    <hr>

    <h5>История сделки</h5>

    <ul class="list-group">
        @foreach ($match->logs as $log)
            <li class="list-group-item">
                {{ $log->created_at->format('d.m.Y H:i') }} —
                <b>{{ $log->action }}</b><br>
                {{ $log->details }}
            </li>
        @endforeach
    </ul>

    <hr>

    <form method="POST" action="{{ route('admin.matches.update', $match) }}">
        @csrf
        @method('PUT')

        <label>Изменить статус:</label>

        <select name="status" class="form-select">
            <option value="awaiting_deposit">🟡 Ждём депозит</option>
            <option value="in_progress">🟢 Контакты открыты</option>
            <option value="done">🔵 Завершено</option>
            <option value="canceled">🔴 Отменено</option>
            <option value="expired">⚫ Истёк срок</option>
        </select>

        <button class="btn btn-primary mt-2">Сохранить</button>

    </form>
@endsection
