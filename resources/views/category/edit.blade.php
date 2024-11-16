@extends('_layout.base', [
    'navItemActive' => 'categories',
])

@section('sufix', 'Criar Categoria')

@section('body')
    <div class="container p-3">
        <div class="d-flex mt-3" style="justify-content: space-between;align-items:center">
            <h2>Editar Categoria</h2>
            <a href="{{ route('categories.index') }}" class="btn btn-primary float-right">Voltar</a>
        </div>
        <hr>
        <div style="max-width: 450px; margin-top: 16px; margin-left:auto; margin-right: auto;">
            @component('category.form', [
                'category' => $category,
            ])
            @endcomponent
        </div>
    </div>
@endsection
