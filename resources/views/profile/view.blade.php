@extends('_layout.base', [
    'navItemActive' => 'profile',
])

@section('sufix', 'Perfil')

@section('body')
    <div class="container p-3">
        <div class="d-flex mt-3" style="justify-content: space-between;align-items:center">
            <h2>Meu Perfil</h2>
            <a href="{{ route('profile.edit', ['user_id' => $user->id]) }}" class="btn btn-primary float-right">Editar</a>
        </div>
        <hr>
        <div style="max-width: 450px; margin-top: 16px; margin-left:auto; margin-right: auto;">
            @component('profile.form', [
                'user' => $user,
                'isVisible' => true,
            ])
            @endcomponent
        </div>
    </div>
@endsection
