<table class="table table-bordered table-hover align-middle">
    <thead class="table-light">
        <tr>
            <th width="60">ID</th>
            <th>Ваше объявление</th>
            <th>Партнёр</th>
            <th>Тел.партнёр</th>
            <th width="160">Цена сделки</th>
            <th width="140">Статус</th>
            <th width="160">Таймер</th>
            <th width="160">Действие</th>
        </tr>
    </thead>
    <tbody>
        @forelse($rows as $match)
            <tr>
                <td>{{ $match->id }}</td>

                <td>{{ $match->my_listing?->user?->name ?? '-' }}</td>
                <td>{{ $match->partner_listing?->user?->name }}</td>
                <td>{{ $match->my_listing?->user?->phone ?? '-' }}</td>
                <td>
                    <strong>{{ number_format($match->final_price, 0, '.', ' ') }} ₸</strong>
                </td>

                <td>
                    @include('components.status-badge', ['status' => $match->status])
                </td>

                <td>
                    @if ($match->status === 'awaiting_deposit')
                        <span class="text-danger fw-bold" data-end="{{ $match->expires_at }}">
                            24:00
                        </span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('profile.matches.show', $match) }}" class="btn btn-sm btn-outline-primary">
                        Детально
                    </a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center text-muted py-4">
                    Нет записей
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
