@extends('admin.layouts.admin')

@section('admin')
    <div class="container mt-4">

        <h2>📊 Панель администратора</h2>

        <table class="table table-bordered w-50 mt-3">
            {{-- <tr>
                <th>👥 Пользователей</th>
                <td>{{ $counters['users'] }}</td>
            </tr> --}}

            {{-- <tr>
                <th>📢 Объявлений</th>
                <td>{{ $counters['listings'] }}</td>
            </tr> --}}

            {{-- <tr>
                <th>🤝 Сделок найдено</th>
                <td>{{ $counters['matches'] }}</td>
            </tr> --}}

            {{-- <tr>
                <th>💛 Ожидают депозит</th>
                <td>{{ $counters['awaiting'] }}</td>
            </tr> --}}

            {{-- <tr>
                <th>🟢 В процессе</th>
                <td>{{ $counters['progress'] }}</td>
            </tr> --}}

            {{-- <tr>
                <th>🔵 Завершено</th>
                <td>{{ $counters['done'] }}</td>
            </tr> --}}

            {{-- <tr>
                <th>🔴 Отменено</th>
                <td>{{ $counters['canceled'] }}</td>
            </tr>  --}}
        </table>
    </div>
@endsection
