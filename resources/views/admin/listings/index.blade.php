@extends('admin.layouts.admin') {{-- если у тебя layout так называется --}}

@section('admin')
    <h2 class="mb-4">📋 Объявления</h2>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Пользователь</th>
                <th>Регион</th>
                <th>Цена</th>
                <th>Создано</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($listings as $listing)
                <tr>
                    <td>{{ $listing->id }}</td>
                    <td>{{ $listing->user->name ?? '—' }}</td>
                    <td>{{ $listing->region->name }}</td>
                    <td>{{ number_format($listing->price_current, 0, '', ' ') }} ₸</td>
                    <td>{{ $listing->created_at->format('d.m.Y H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $listings->links() }}
@endsection
