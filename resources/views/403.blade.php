@extends('layouts.guest')
@section('content')
<h1 class="text-xl font-bold">Требуется согласие</h1>
<p class="mt-2">
  Для продолжения работы с сервисом необходимо принять
  <a href="{{ route('offer') }}" class="text-emerald-500 underline">
    публичную оферту
  </a>.
</p>
@endsection