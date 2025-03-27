@extends('_layout.main-adminlte')

@section('title', 'Wordea - Editar Perfil')

@section('content_header')
    <h2>Editar Perfil</h2>
    <hr>
@endsection

@section('content')
    <div class="d-flex justify-content-end mb-3">
        <div class="btn-group">
            <a href="{{ route('profile.show', ['user_id' => $user->id]) }}" class="btn btn-success">Voltar</a>
        </div>
    </div>
    @include('profile.form')
@endsection
