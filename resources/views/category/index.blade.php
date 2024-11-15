@extends('_layout.base', [
    'navItemActive' => 'categories',
])

@section('sufix', 'Categorias')

@section('body')
    <div class="container p-3">
        <div class="d-flex mt-3" style="justify-content: space-between;align-items:center">
            <h2>Lista de Categorias</h2>
            <a href="{{ route('categorias.create') }}" class="btn btn-success float-right">Criar Categoria</a>
        </div>
        <hr>
        Categorias
    </div>
@endsection
