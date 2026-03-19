@extends('admin.layouts.admin')
@section('admin')
    <h2>Страницы</h2>

    <a href="{{ route('admin.pages.create') }}">+ Создать страницу</a>

    <table>
    <tr>
        <th>ID</th>
        <th>Slug</th>
        <th>Активна</th>
        <th></th>
    </tr>

    @foreach($pages as $page)
    <tr>
        <td>{{ $page->id }}</td>
        <td>{{ $page->slug }}</td>
        <td>{{ $page->is_active ? 'Да' : 'Нет' }}</td>
        <td>
            <a href="{{ route('admin.pages.edit',$page) }}">Редактировать</a>
        </td>
    </tr>
    @endforeach
    </table>
@endsection    