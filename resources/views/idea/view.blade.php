
@extends('_layout.main-adminlte')

@section('title', 'Wordea - Visualizar Ideia')

@section('content_header')
    <h2>Visualizar Ideia</h2>
    <hr>
@endsection

@section('content')
    <div class="d-flex justify-content-end mb-3">
        <div class="btn-group">
            <a href="{{ route('ideas.index') }}" class="btn btn-primary">Voltar para Ideias</a>
            <button class="btn btn-success" data-toggle="modal" data-target="#modal-add-category">Vincular Ideia</button>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            @include('idea.form', [
                'isVisible' => true,
            ])
        </div>

        <div class="col-md-6">
            @component('components.common.card')
                @slot('card_header')
                    <h3 class="mb-0">
                        Categorias
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
                                @if (!$category->is_default)
                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-delete" data-action="{{ route('ideas.remove-category', ['categoria' => $category->id]) }}">
                                        Desvincular
                                    </button>
                                @endif
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
        </div>
    </div>

    @include('idea.relations.add-category')

    @component('components.modal.modal-form', [
        'id' => 'modal-delete',
        'method' => 'post',
        'btn_type_color_confirm' => 'danger',
        'btn_type_color_cancel' => 'dark',
        'btn_confirm_label' => 'Desvincular',
        'action' => '',
    ])
        @slot('modal_header')
            <h4 class="modal-title">Desvincular Categoria</h4>
        @endslot

        @csrf
        @method('DELETE')
        <input type="hidden" name="idea_id" value="{{ $idea->id }}">
        <p>Você deseja desvincular esta categoria dessa ideia?</p>
    @endcomponent
@endsection

@section('main_js')
    <script>
        $(function() {
            $('#category').select2();
        })
    </script>
@endsection
