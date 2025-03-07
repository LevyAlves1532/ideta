
@extends('adminlte::page')

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
