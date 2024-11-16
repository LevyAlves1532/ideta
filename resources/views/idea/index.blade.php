@extends('_layout.base', [
    'navItemActive' => 'ideas',
])

@section('sufix', 'Ideias')

@section('body')
    <div class="container p-3">
        <div class="d-flex mt-3" style="justify-content: space-between;align-items:center">
            <h2>Lista de Ideias</h2>
            <a href="{{ route('ideias.create') }}" class="btn btn-success float-right">Criar Ideia</a>
        </div>
        <hr>
        @if ($ideas->count() > 0)
            <div class="d-flex" style="justify-content: flex-end">
                <form action="{{ route('ideias.index') }}" class="mb-3 row g-3 align-items-center">
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
                            <a href="{{ route('ideias.index') }}" class="btn btn-primary">Limpar Filtro</a>
                        </div>
                    @endif
                </form>
            </div>

            <table class="table table-hover table-dark">
                <thead>
                    <tr>
                        <th scope="col">Título</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ideas as $idea)
                        <tr>
                            <td style="vertical-align: middle;">{{ $idea->title }}</td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-danger dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                        Ações
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item text-secondary" href="{{ route('ideias.show', ['ideia' => $idea->id]) }}">Visualizar</a></li>
                                        <li><a class="dropdown-item text-primary" href="{{ route('ideias.edit', ['ideia' => $idea->id]) }}">Editar</a></li>
                                        <li>
                                            <form id="form-{{ $idea->id }}" method="POST" action="{{ route('ideias.destroy', ['ideia' => $idea->id]) }}">
                                                @csrf
                                                @method('DELETE')
                                                <a class="dropdown-item text-danger" href="#" onclick="document.getElementById('form-{{ $idea->id }}').submit()">Deletar</a>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $ideas->appends($request)->links('pagination::bootstrap-5') }}
        @else
            <p class="text-center text-secondary">Não há ideias</p>
        @endif
    </div>
@endsection
