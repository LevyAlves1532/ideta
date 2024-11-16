@extends('_layout.base', [
    'navItemActive' => 'ideas',
])

@section('sufix', 'Editar Ideia')

@section('body')
    <div class="container p-3">
        <div class="d-flex mt-3" style="justify-content: space-between;align-items:center">
            <h2>Editar Ideia</h2>
            <a href="{{ route('ideias.index') }}" class="btn btn-primary float-right">Voltar</a>
        </div>
        <hr>
        <div style="max-width: 450px; margin-top: 16px; margin-left:auto; margin-right: auto;">
            @component('idea.form', [
                'idea' => $idea,
                'categories' => $categories,
                'selectedCategories' => $selectedCategories,
            ])
            @endcomponent
        </div>
    </div>
@endsection
