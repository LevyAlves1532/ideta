
@extends('adminlte::page')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    @yield('main_css')
@endsection

@section('usermenu_header')
    <div class="p-2">
        <ul class="nav nav-pills nav-sidebar flex-column">
            <li class="nav-item">
                <a href="{{ route('profile.show', ['user_id' => auth()->id()]) }}" class="nav-link">
                    <i class="fas fa-fw fa-user-circle"></i>
                    <p>Meu Perfil</p>
                </a>
            </li>
        </ul>
    </div>
@endsection

@section('content_top_nav_left')
    <div style="display: flex; align-items: center;">
        <p class="mb-0">v2.0.0</p>
    </div>

    @yield('main_content_top_nav_left')
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>
    @yield('main_js')
@endsection
