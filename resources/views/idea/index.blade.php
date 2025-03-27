
@extends('_layout.main-adminlte')

@section('title', 'Wordea - Ideias')

@section('content_header')
    <h2>Lista de Ideias</h2>
    <hr>
@endsection

@section('content')
    <div class="d-flex justify-content-end mb-3">
        <div class="btn-group">
            <a href="{{ route('ideas.create') }}" class="btn btn-success">Criar Ideia</a>
            <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#modal-filters">Filtros</button>
            @if (!empty($request['search']) || !empty($request['category_id']) || (!empty($request['qtd_rows']) && (int) $request['qtd_rows'] > 5))
                <a href="{{ route('ideas.index') }}" class="btn btn-danger">Limpar Filtro</a>
            @endif
        </div>
    </div>

    @component('components.common.card')
        @slot('card_header')
            <h3>
                Tabela
            </h3>
        @endslot

        @component('components.common.table', [
            'columns' => [
                [
                    'label' => '#',
                    'style' => 'width: 10px',
                ],
                [
                    'label' => 'Título:'
                ],
                [
                    'label' => 'Categorias:',
        ],
                [
                    'label' => ''
                ]
            ],
        ])
            @foreach ($ideas as $idea)
                <tr>
                    <td>{{ $idea->id }}</td>
                    <td>{{ $idea->title }}</td>
                    <td>
                        <div class="d-flex flex-wrap" style="gap: 5px">
                            @foreach ($idea->categories as $category)
                                <p class="badge" style="border: 2px solid {{ $category->color }}">{{ $category->name }}</p>
                            @endforeach
                        </div>
                    </td>
                    <td>
                        <div class="btn-group">
                            <div class="btn btn-success">Ações</div>
                            <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <div class="dropdown-menu" role="menu" style="">
                                <a class="dropdown-item text-info" href="{{ route('ideas.show', ['ideia' => $idea->id]) }}">Visualizar</a>
                                <a class="dropdown-item text-primary" href="{{ route('ideas.edit', ['ideia' => $idea->id]) }}">Editar</a>
                                <button type="button" class="dropdown-item text-danger" data-toggle="modal" data-target="#modal-delete" data-action="{{ route('ideas.destroy', ['ideia' => $idea->id]) }}">Deletar</button>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-info" href="{{ route('notes.index', ['idea_id' => $idea->id]) }}">Ver Anotações</a>
                                <form id="form-share-{{ $idea->id }}" method="POST" action="{{ route('ideas.share-idea') }}">
                                    @csrf
                                    <input type="hidden" name="idea_id" value="{{ $idea->id }}">
                                    <button class="dropdown-item text-success" onclick="document.getElementById('form-share-{{ $idea->id }}').submit()">Compartilhar</button>
                                </form>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        @endcomponent

        @if ($total > $qtd_rows)
            @slot('card_footer')
                {{ $ideas->appends($request)->links('pagination::bootstrap-5') }}
            @endslot
        @endif
    @endcomponent

    @component('components.modal.modal-form', [
        'id' => 'modal-filters',
        'btn_confirm_label' => 'Filtrar',
        'action' => route('ideas.index'),
    ])
        @slot('modal_header')
            <h4 class="modal-title">Filtrar Ideias</h4>
        @endslot

        @component('components.form.input-advanced', [
            'id' => 'search',
            'label' => 'Buscar:',
            'name' => 'search',
            'placeholder' => 'Buscar ideia...',
        ])                                
        @endcomponent

        <div class="form-group">
            <label>Categorias:</label>
            <select class="form-control" id="category" name="category_id" style="width: 100%;">                
                @foreach ($categories as $category)
                    <option @if($category->id == $category_id) selected @endif value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
    @endcomponent

    @component('components.modal.modal-form', [
        'id' => 'modal-delete',
        'method' => 'post',
        'btn_type_color_confirm' => 'danger',
        'btn_type_color_cancel' => 'dark',
        'btn_confirm_label' => 'Deletar',
        'action' => '',
    ])
        @slot('modal_header')
            <h4 class="modal-title">Deletar Ideia</h4>
        @endslot

        @csrf
        @method('DELETE')
        <p>Você deseja deletar essa ideia?</p>
    @endcomponent
@endsection

@section('main_js')
    <script>
        $(function() {
            $('#category').select2();
        })
    </script>
@endsection
