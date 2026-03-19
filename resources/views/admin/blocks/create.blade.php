@extends('admin.layouts.admin')
@section('admin')
    <form method="POST" action="{{ route('pages.blocks.store',$page) }}">
    @csrf

    <label>Тип блока</label>
    <select name="type">
        <option value="hero">Hero</option>
        <option value="info_card">Info Card</option>
        <option value="content_section">Content Section</option>
    </select>

    <label>Sort Order</label>
    <input type="number" name="sort_order">

    <label>JSON данные</label>
    <textarea name="data" rows="15">
    {
        "title": "Заголовок",
        "content": "Контент"
    }
    </textarea>

    <button type="submit">Сохранить</button>
    </form>
@endsection    