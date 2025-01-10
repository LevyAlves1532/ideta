@extends('_layout.base')

@section('sufix', 'Editar Perfil')

@section('body')
    <div class="container p-3">
        <div class="d-flex mt-3" style="justify-content: space-between;align-items:center">
            <h2>Editar Perfil</h2>
            <a href="{{ route('profile.show', ['user_id' => $user->id]) }}" class="btn btn-primary float-right">Voltar</a>
        </div>
        <hr>
        <div style="max-width: 450px; margin-top: 16px; margin-left:auto; margin-right: auto;">
            @component('profile.form', [
                'user' => $user,
            ])
            @endcomponent
        </div>
    </div>
@endsection
