@extends('admin.layouts.admin')
@section('admin')
    <form method="POST" action="{{ route('admin.pages.store') }}">
    @csrf

    <label>Slug</label>
    <input type="text" name="slug">

    <label>Активна</label>
    <input type="checkbox" name="is_active" checked>

    <button>Сохранить</button>
    </form>