
@extends('adminlte::page')

@section('content_header')
    <h2>Seja Bem-Vindo ao Note Free</h2>
    <hr>
    @yield('main_content_header')
@endsection

@section('content_top_nav_left')
    <div style="display: flex; align-items: center;">
        <p class="mb-0">v2.0.0</p>
    </div>

    @yield('main_content_top_nav_left')
@endsection
