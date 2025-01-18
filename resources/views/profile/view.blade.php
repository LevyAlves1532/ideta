@extends('_layout.base', [
    'navItemActive' => 'profile',
])

@section('sufix', 'Perfil')

@section('body')
    <div class="container p-3">
        <div class="d-flex mt-3" style="justify-content: space-between;align-items:center">
            <div>
                <h2>{{ !$isViewProfile ? 'Meu Perfil' : 'Usuário: ' . $user->name }}</h2>
                <p>Tempo de uso do sistema: {{ $time_usage_system }}s</p>
            </div>
            @if (!$isViewProfile)
                <a href="{{ route('profile.edit', ['user_id' => $user->id]) }}" class="btn btn-primary float-right">Editar</a>
            @endif
        </div>
        <hr>
        <div class="row px-2" style="gap: 20px;">
            <div class="alert alert-light col-md" role="alert">
                <h4 class="alert-heading">Categorias ({{ $user->metric->total_categories }})</h4>
                <p class="mb-0">Quantidade de categorias cadastradas</p>
            </div>
            <div class="alert alert-light col-md" role="alert">
                <h4 class="alert-heading">Ideias ({{ $user->metric->total_ideas }})</h4>
                <p class="mb-0">Quantidade de ideias cadastradas</p>
            </div>
            <div class="alert alert-light col-md" role="alert">
                <h4 class="alert-heading">Notas ({{ $user->metric->total_notes }})</h4>
                <p class="mb-0">Quantidade de notas cadastradas</p>
            </div>
        </div>
        @if (!$isViewProfile)
            <hr>
            <div style="max-width: 450px; margin-top: 16px; margin-left:auto; margin-right: auto;">
                @component('profile.form', [
                    'user' => $user,
                    'isVisible' => true,
                ])
                @endcomponent
            </div>
        @endif
    </div>
@endsection
