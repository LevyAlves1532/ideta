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
        @if ($categories->count() > 0)
            <div class="d-flex" style="justify-content: flex-end">
                <form action="{{ route('categorias.index') }}" class="mb-3 row g-3 align-items-center">
                    <div class="col-auto">
                        <label for="search" class="col-form-label">Pesquisar</label>
                    </div>
                    <div class="col-auto">
                        <input type="text" id="search" class="form-control" name="search">
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-success">Buscar</button>
                    </div>
                    @if (!empty($request['search']))
                        <div class="col-auto">
                            <a href="{{ route('categorias.index') }}" class="btn btn-primary">Limpar Filtro</a>
                        </div>
                    @endif
                </form>
            </div>

            <table class="table table-hover table-dark">
                <thead>
                    <tr>
                        <th scope="col">Nome</th>
                        <th scope="col">Cor</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                        <tr>
                            <td style="vertical-align: middle;">{{ $category->name }}</td>
                            <td style="vertical-align: middle;">
                                <div class="d-flex" style="align-items: center; gap: 10px; text-transform: uppercase;">
                                    <div style="width: 20px; height: 20px; border-radius: 5px; background-color: {{$category->color}};"></div>
                                    {{ $category->color }}
                                </div>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-danger dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                        Ações
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item text-secondary" href="{{ route('categorias.show', ['categoria' => $category->slug]) }}">Visualizar</a></li>
                                        <li><a class="dropdown-item text-primary" href="{{ route('categorias.edit', ['categoria' => $category->slug]) }}">Editar</a></li>
                                        <li>
                                            <form id="form-{{ $category->id }}" method="POST" action="{{ route('categorias.destroy', ['categoria' => $category->id]) }}">
                                                @csrf
                                                @method('DELETE')
                                                <a class="dropdown-item text-danger" href="#" onclick="document.getElementById('form-{{ $category->slug }}').submit()">Deletar</a>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $categories->appends($request)->links('pagination::bootstrap-5') }}
        @else
            <p class="text-center text-secondary">Não há categorias</p>
        @endif
    </div>
@endsection
