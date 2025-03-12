@extends('_layout.main-adminlte')

@section('content_header')
    <h2>Seja Bem-Vindo ao Note Free</h2>
    <hr>
@endsection

@section('content')    
    <div class="row">
        <div class="col-md-6">
            @component('components.common.card')
                @slot('card_header')
                    <p class="mb-0">Ultimas Ideias Trabalhadas</p>
                @endslot

                @component('components.common.table', [
                    'columns' => [
                        [
                            'label' => '#',
                            'style' => 'width: 10px',
                        ],
                        [
                            'label' => 'Ideia:'
                        ],
                        [
                            'label' => ''
                        ]
                    ],
                ])
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
                                            <button class="dropdown-item text-danger" onclick="document.getElementById('form-{{ $latestIdea->id }}').submit()">Deletar</button>
                                        </form>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item text-info" href="{{ route('notes.index', ['idea_id' => $latestIdea->id]) }}">Ver Anotações</a>
                                        <form id="form-share-{{ $latestIdea->id }}" method="POST" action="{{ route('ideas.share-idea') }}">
                                            @csrf
                                            <input type="hidden" name="idea_id" value="{{ $latestIdea->id }}">
                                            <button class="dropdown-item text-success" onclick="document.getElementById('form-share-{{ $latestIdea->id }}').submit()">Compartilhar</button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @endcomponent
                
                @slot('card_footer')
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
                @endslot
            @endcomponent
        </div>
    </div>
@endsection

@section('main_js')
    <script src="{{ asset('assets/js/views/home.js') }}"></script>
@endsection
