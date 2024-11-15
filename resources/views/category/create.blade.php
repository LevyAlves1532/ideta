@extends('_layout.base', [
    'navItemActive' => 'categories',
])

@section('sufix', 'Criar Categoria')

@section('body')
    <div class="container p-3">
        <div class="d-flex mt-3" style="justify-content: space-between;align-items:center">
            <h2>Criar Categoria</h2>
            <a href="{{ route('categorias.index') }}" class="btn btn-primary float-right">Voltar</a>
        </div>
        <hr>
        <div style="max-width: 450px; margin-top: 16px; margin-left:auto; margin-right: auto;">
            <form method="POST" action="{{ route('categorias.store') }}">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Nome</label>
                    <input type="name" class="form-control" id="name" name="name" value="{{ old('name') }}">
                    @error('name')
                        <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="color" class="form-label">Cor</label>
                    <input type="color" class="form-control form-control-color" id="color" value="{{ old('color') ?? '#000000' }}" title="Selecione uma cor" name="color">
                    @error('color')
                        <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-success">Criar Categoria</button>
            </form>
        </div>
    </div>
@endsection
