
@extends('_layout.main-adminlte')

@section('title', 'Note Free - Criar Categoria')

@section('content_header')
    <h2>Criar Categoria</h2>
    <hr>
@endsection

@section('content')
    <div class="d-flex justify-content-end mb-3">
        <div class="btn-group">
            <a href="{{ route('categories.index') }}" class="btn btn-primary">Voltar para Categorias</a>
        </div>
    </div>

    @component('components.common.card')
        @slot('card_header')
            <h3 class="mb-0">
                Formulário
            </h3>
        @endslot

        <div class="p-3">
            @include('category.form')
        </div>
    @endcomponent
@endsection
