
@extends('_layout.main-adminlte')

@section('title', 'Wordea - Editar Categoria')

@section('content_header')
    <h2>Editar Categoria</h2>
    <hr>
@endsection

@section('content')
    <div class="d-flex justify-content-end mb-3">
        <div class="btn-group">
            <a href="{{ route('categories.index') }}" class="btn btn-primary">Voltar para Categorias</a>
        </div>
    </div>

    @include('category.form')
@endsection
