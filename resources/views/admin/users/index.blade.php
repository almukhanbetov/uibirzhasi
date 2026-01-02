@extends('admin.layout.admin')

@section('admin')
    <h3>👥 Пользователи</h3>

    <table class="table table-bordered table-hover">
        <tr>
            <th>ID</th>
            <th>Имя</th>
            <th>Телефон</th>
            <th>Заблокирован</th>
        </tr>

        @foreach ($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->phone }}</td>
                <td>
                    @if ($user->is_blocked)
                        🔴 Да
                    @else
                        🟢 Нет
                    @endif
                </td>
            </tr>
        @endforeach
    </table>

    {{ $users->links() }}
@endsection
