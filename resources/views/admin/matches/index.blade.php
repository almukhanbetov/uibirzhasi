@extends('admin.layout.admin')

@section('admin')
    <h3>🤝 Все сделки</h3>

    <table class="table table-bordered table-hover mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>Покупатель</th>
                <th>Продавец</th>
                <th>Цена</th>
                <th>Статус</th>
                <th></th>
            </tr>
        </thead>

        <tbody>
            @foreach ($matches as $match)
                <tr>
                    <td>{{ $match->id }}</td>
                    <td>{{ $match->buyer?->name }}</td>
                    <td>{{ $match->seller?->name }}</td>
                    <td>{{ number_format($match->final_price, 0, '.', ' ') }} ₸</td>
                    <td>@include('components.status-badge', ['status' => $match->status])</td>

                    <td>
                        <a href="{{ route('admin.matches.show', $match) }}" class="btn btn-sm btn-outline-primary">
                            Детали
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $matches->links() }}
@endsection
