@extends('_layout.main-adminlte')

@section('title', 'Wordea - Meu Perfil')

@section('content_header')
    <h2>{{ !$isViewProfile ? 'Meu Perfil' : 'Usuário: ' . $user->name }}</h2>
    <p>Tempo de uso do sistema: {{ $time_usage_system }}s</p>
    <hr>
@endsection

@section('content')
    <div class="d-flex justify-content-end mb-3">
        <div class="btn-group">
            @if (!$isViewProfile)
                <a href="{{ route('profile.edit', ['user_id' => $user->id]) }}" class="btn btn-success">Editar</a>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4 col-6">
            <div class="small-box bg-dark">
                <div class="inner">
                    <h3>{{ $user->metric->total_categories }}</h3>
                    <p>Quantidade de categorias cadastradas</p>
                </div>
                <div class="icon">
                    <i class="fas fa-tags"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-6">
            <div class="small-box bg-dark">
                <div class="inner">
                    <h3>{{ $user->metric->total_ideas }}</h3>
                    <p>Quantidade de ideias cadastradas</p>
                </div>
                <div class="icon">
                    <i class="fas fa-lightbulb"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-6">
            <div class="small-box bg-dark">
                <div class="inner">
                    <h3>{{ $user->metric->total_notes }}</h3>
                    <p>Quantidade de notas cadastradas</p>
                </div>
                <div class="icon">
                    <i class="fas fa-sticky-note"></i>
                </div>
            </div>
        </div>
    </div>
    @include('profile.form')
@endsection
