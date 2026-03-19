@extends('admin.layouts.admin')
@section('admin')
    <form method="POST" action="{{ route('admin.pages.update',$page) }}">
    @csrf
    @method('PUT')

    <label>Slug</label>
    <input type="text" name="slug" value="{{ $page->slug }}">

    <label>Активна</label>
    <input type="checkbox" name="is_active" {{ $page->is_active ? 'checked':'' }}>

    <button>Обновить</button>
    </form>