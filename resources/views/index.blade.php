@extends('_layout.main-adminlte')

@section('content')    
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <p class="mb-0">Ultimas Ideias Trabalhadas</p>
                </div>

                <div class="card-body p-0">
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Ideia</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($latestIdeas as $latestIdea)
                                <tr>
                                    <td>{{ $latestIdea->id }}</td>
                                    <td>{{ $latestIdea->title }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <div class="btn btn-success">Ações</div>
                                            <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <div class="dropdown-menu" role="menu" style="">
                                                <a class="dropdown-item text-info" href="{{ route('ideas.show', ['ideia' => $latestIdea->id]) }}">Visualizar</a>
                                                <a class="dropdown-item text-primary" href="{{ route('ideas.edit', ['ideia' => $latestIdea->id]) }}">Editar</a>
                                                <form id="form-{{ $latestIdea->id }}" method="POST" action="{{ route('ideas.destroy', ['ideia' => $latestIdea->id]) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <a class="dropdown-item text-danger" href="#" onclick="document.getElementById('form-{{ $latestIdea->id }}').submit()">Deletar</a>
                                                </form>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item text-info" href="{{ route('notes.index', ['idea_id' => $latestIdea->id]) }}">Ver Anotações</a>
                                                <form id="form-share-{{ $latestIdea->id }}" method="POST" action="{{ route('ideas.share-idea') }}">
                                                    @csrf
                                                    <input type="hidden" name="idea_id" value="{{ $latestIdea->id }}">
                                                    <a class="dropdown-item text-success" href="#" onclick="document.getElementById('form-share-{{ $latestIdea->id }}').submit()">Compartilhar</a>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="card-footer">
                    <div class="form-group">
                        <label style="" for="categories">Categoria:</label>
                        <select class="form-control" id="categories" tabindex="-1" aria-hidden="true">
                            <option value="" disabled selected>Filtre pela categoria mais recente</option>
                            @foreach ($categoriesLatestIdeas as $categoryLatestIdeas)
                                <option value="{{ $categoryLatestIdeas->id }}" @if ($categoryLatestIdeas->id == $category_id) selected @endif>{{ $categoryLatestIdeas->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    @if (!empty($category_id))
                        <a href="{{ route('index') }}" class="btn btn-primary">Limpar Filtro</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('assets/js/views/home.js') }}"></script>
@endsection
