@extends('admin.layouts.admin')
@section('admin')
    <form method="POST" action="{{ route('blocks.update',$block) }}">
    @csrf
    @method('PUT')

    <label>Тип</label>
    <input name="type" value="{{ $block->type }}">

    <label>Sort</label>
    <input name="sort_order" value="{{ $block->sort_order }}">

    <label>Активен</label>
    <input type="checkbox" name="is_active" {{ $block->is_active ? 'checked':'' }}>

    <label>JSON</label>
    <textarea name="data" rows="15">
    {{ json_encode($block->data, JSON_PRETTY_PRINT) }}
    </textarea>

    <button>Обновить</button>
    </form>
@endsection    