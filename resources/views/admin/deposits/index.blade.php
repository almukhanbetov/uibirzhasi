@extends('admin.layouts.admin')
@section('admin')
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Сделка</th>
                <th>Пользователь</th>
                <th>Сумма</th>
                <th>Статус</th>
                <th>Создан</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($deposits as $d)
                <tr>
                    <td>{{ $d->id }}</td>

                    <td>
                        <a href="{{ route('profile.matches.show', $d->match_id) }}">
                            Сделка #{{ $d->match_id }}
                        </a>
                    </td>

                    <td>{{ $d->user->name }}</td>

                    <td>
                        {{ number_format($d->amount, 0, '.', ' ') }} ₸
                    </td>

                    <td>
                        @include('components.status-badge', ['status' => $d->status])
                    </td>

                    <td>{{ $d->created_at->format('d.m.Y H:i') }}</td>

                    <td>
                        <form method="POST" action="{{ route('admin.deposits.update', $d) }}">
                            @csrf
                            @method('PUT')

                            <select name="status" class="form-select d-inline w-auto">
                                <option value="paid" {{ $d->status == 'paid' ? 'selected' : '' }}>Оплачен</option>
                                <option value="refunded" {{ $d->status == 'refunded' ? 'selected' : '' }}>Возвращён</option>
                                <option value="blocked" {{ $d->status == 'blocked' ? 'selected' : '' }}>Заблокирован</option>
                            </select>

                            <button class="btn btn-primary btn-sm">
                                💾 Сохранить
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $deposits->links() }}
@endsection
