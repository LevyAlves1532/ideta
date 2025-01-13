@extends('_layout.base', [
    'navItemActive' => 'ideas',
])

@section('sufix', 'Ideias')

@section('body')
    <div class="container p-3">
        <div class="d-flex mt-3" style="justify-content: space-between;align-items:center">
            <h2>Lista de Ideias</h2>
            <a href="{{ route('ideas.create') }}" class="btn btn-success float-right">Criar Ideia</a>
        </div>
        <hr>
        @if ($ideas->count() > 0)
            <div class="d-flex" style="justify-content: flex-end">
                <form action="{{ route('ideas.index') }}" class="mb-3 row g-3 align-items-center">
                    <div class="col-auto">
                        <label for="search" class="col-form-label">Pesquisar</label>
                    </div>
                    <div class="col-auto">
                        <input type="text" id="search" class="form-control" name="search" value="{{ $request['search'] ?? '' }}">
                    </div>
                    <div class="col-auto">
                        <select class="form-select" name="category_id">
                            <option selected disabled>Selecione uma categoria</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @if (!empty($request['category_id']) && $request['category_id'] == $category->id) selected @endif>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-success">Buscar</button>
                    </div>
                    @if (!empty($request['search']) || !empty($request['category_id']))
                        <div class="col-auto">
                            <a href="{{ route('ideas.index') }}" class="btn btn-primary">Limpar Filtro</a>
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
                                        <li><a class="dropdown-item text-secondary" href="{{ route('ideas.show', ['ideia' => $idea->id]) }}">Visualizar</a></li>
                                        <li><a class="dropdown-item text-primary" href="{{ route('ideas.edit', ['ideia' => $idea->id]) }}">Editar</a></li>
                                        <li>
                                            <form id="form-{{ $idea->id }}" method="POST" action="{{ route('ideas.destroy', ['ideia' => $idea->id]) }}">
                                                @csrf
                                                @method('DELETE')
                                                <a class="dropdown-item text-danger" href="#" onclick="document.getElementById('form-{{ $idea->id }}').submit()">Deletar</a>
                                            </form>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item" href="{{ route('notes.index', ['idea_id' => $idea->id]) }}">Ver Anotações</a></li>
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
