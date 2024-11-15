@extends('_layout.base', [
    'navItemActive' => 'home',
])

@section('sufix', 'Home')

@section('body')
    <div class="container py-3">
        <h2 class="mt-3">Seja Bem-Vindo ao Ideta 1.0</h2>
        <hr>

        <div class="d-flex">
            <h4 class="mt-3 me-auto">Todas as Ideias</h4>

            <form class="row g-3 align-items-center float-right">
                <div class="col-auto">
                    <select class="form-select" aria-label="Default select example">
                        <option selected disabled>Selecione a categoria</option>
                    </select>
                </div>
                <div class="col-auto">
                    <button type="button" class="btn btn-success">Filtrar</button>
                </div>
            </form>
        </div>
    </div>
@endsection

