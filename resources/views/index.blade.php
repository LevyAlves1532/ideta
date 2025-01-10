@extends('_layout.base', [
    'navItemActive' => 'home',
])

@section('sufix', 'Home')

@section('body')
    <div class="container py-3">
        <h2 class="mt-3">Seja Bem-Vindo ao Ideta 1.1.0</h2>
        <hr>

        <div class="d-flex">
            <h4 class="mt-3 me-auto">Ultimas Ideias Trabalhadas</h4>

            @if ($latestIdeas->count() > 0)
                <form class="row g-3 align-items-center float-right">
                    <div class="col-auto">
                        <select class="form-select" name="category_id">
                            <option selected disabled>Selecione a categoria</option>
                            @foreach ($categoriesLatestIdeas as $category)
                                <option value="{{ $category->id }}" @if ($category->id == $category_id) selected @endif>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-success">Filtrar</button>
                    </div>
                    @if (!empty($category_id))
                        <div class="col-auto">
                            <a href="{{ route('index') }}" class="btn btn-primary">Limpar Filtro</a>
                        </div>
                    @endif
                </form>
            @endif
        </div>

        @if ($latestIdeas->count() > 0)
            <table class="table table-hover table-dark">
                <thead>
                    <tr>
                        <th scope="col">Título</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($latestIdeas as $idea)
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
        @else
            <p class="text-center text-secondary">Não há ideias</p>
        @endif
    </div>
@endsection

