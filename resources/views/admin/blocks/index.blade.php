@extends('admin.layouts.admin')
@section('admin')
    <h2>Блоки страницы: {{ $page->slug }}</h2>

    <a href="{{ route('pages.blocks.create',$page) }}">+ Добавить блок</a>

    <table>
        <tr>
            <th>ID</th>
            <th>Тип</th>
            <th>Порядок</th>
            <th>Активен</th>
            <th></th>
        </tr>

    @foreach($blocks as $block)
    <tr>
        <td>{{ $block->id }}</td>
        <td>{{ $block->type }}</td>
        <td>{{ $block->sort_order }}</td>
        <td>{{ $block->is_active ? 'Да' : 'Нет' }}</td>
        <td>
            <a href="{{ route('blocks.edit',$block) }}">Редактировать</a>
        </td>
    </tr>
    @endforeach
    </table>
@endsection

