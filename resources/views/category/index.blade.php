@extends('_layout.main-adminlte')

@section('title', 'Note Free - Categorias')

@section('content_header')
    <h2>Lista de Categorias</h2>
    <hr>
@endsection

@section('content')
    <div class="d-flex justify-content-end mb-3">
        <div class="btn-group">
            <a href="{{ route('categories.create') }}" class="btn btn-success">Criar Categoria</a>
            <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#modal-filters">Filtros</button>
            @if (!empty($request['search']) || (!empty($request['qtd_rows']) && (int) $request['qtd_rows'] > 5))
                <a href="{{ route('categories.index') }}" class="btn btn-danger">Limpar Filtro</a>
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
                    'label' => 'Nome:'
                ],
                [
                    'label' => 'Cor:'
                ],
                [
                    'label' => ''
                ]
            ],
        ])
            @foreach ($categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td style="color: {{ $category->color }}">{{ $category->name }}</td>
                    <td>
                        <div class="d-flex" style="align-items: center; gap: 10px; text-transform: uppercase;">
                            <div style="width: 20px; height: 20px; border-radius: 5px; background-color: {{$category->color}};"></div>
                            {{ $category->color }}
                        </div>
                    </td>
                    <td>
                        <div class="btn-group">
                            <div class="btn btn-success">Ações</div>
                            <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <div class="dropdown-menu" role="menu" style="">
                                <a class="dropdown-item text-info" href="{{ route('categories.show', ['categoria' => $category->id]) }}">Visualizar</a>
                                <a class="dropdown-item text-primary" href="{{ route('categories.edit', ['categoria' => $category->id]) }}">Editar</a>
                                @if (!$category->is_default)
                                    <button type="button" class="dropdown-item text-danger" data-toggle="modal" data-target="#modal-delete" data-action="{{ route('categories.destroy', ['categoria' => $category->id]) }}">Deletar</button>
                                @endif
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        @endcomponent
        
        @if ($total > $qtd_rows)
            @slot('card_footer')
                {{ $categories->appends($request)->links('pagination::bootstrap-5') }}
            @endslot
        @endif
    @endcomponent

    @component('components.modal.modal-form', [
        'id' => 'modal-filters',
        'btn_confirm_label' => 'Filtrar',
        'action' => route('categories.index'),
    ])
        @slot('modal_header')
            <h4 class="modal-title">Filtrar Categorias</h4>
        @endslot

        @component('components.form.input-advanced', [
            'id' => 'search',
            'label' => 'Buscar:',
            'name' => 'search',
            'placeholder' => 'Buscar categoria...',
        ])                                
        @endcomponent
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
            <h4 class="modal-title">Deletar Categoria</h4>
        @endslot

        @csrf
        @method('DELETE')
        <p>Você deseja deletar a categoria?</p>
    @endcomponent
@endsection
