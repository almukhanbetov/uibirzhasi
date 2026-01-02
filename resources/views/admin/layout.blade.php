@extends('admin.layout')
@yield('title', 'Админ-панель')
@section('content')
    <div class="container-fluid">

        {{-- ====== HEADER ====== --}}

        @include('includes-admin.header')


        <div class="row g-0">

            {{-- ====== SIDEBAR ====== --}}

            @include('includes-admin.sidebar')


            {{-- ====== MAIN CONTENT ====== --}}
            <div class="col-md-10 p-4 bg-light min-vh-100">

                @yield('admin')

            </div>

        </div>

    </div>
@endsection
