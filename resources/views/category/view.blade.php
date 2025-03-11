@extends('_layout.main-adminlte')

@section('title', 'Note Free - Visualizar Categoria')

@section('content_header')
    <h2>Visualizar Categoria</h2>
    <hr>
@endsection

@section('content')
    <div class="d-flex justify-content-end mb-3">
        <div class="btn-group">
            <a href="{{ route('categories.index') }}" class="btn btn-primary">Voltar para Categorias</a>
            <button class="btn btn-success" data-toggle="modal" data-target="#modal-add-idea">Vincular Ideia</button>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            @include('category.form', [
                'isVisible' => true,
            ])
        </div>

        <div class="col-md-6">
            @component('components.common.card')
                @slot('card_header')
                    <h3 class="mb-0">
                        Ideias
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
                            'label' => '',
                            'style' => 'width: 75px'
                        ],
                    ],
                ])
                    @foreach ($ideas as $idea)
                        <tr>
                            <td>{{ $idea->id }}</td>
                            <td style="color: {{ $category->color }}">
                                <a href="{{ route('ideas.show', ['ideia' => $idea->id]) }}">
                                    {{ $idea->title }}
                                </a>
                            </td>
                            <td style="color: {{ $category->color }}">
                                @if (!$category->is_default)
                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-delete" data-action="{{ route('categories.remove-idea', ['ideia' => $idea->id]) }}">
                                        Desvincular
                                    </button>
                                @endif
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
        </div>
    </div>

    @include('category.relations.add-idea')

    @component('components.modal.modal-form', [
        'id' => 'modal-delete',
        'method' => 'post',
        'btn_type_color_confirm' => 'danger',
        'btn_type_color_cancel' => 'dark',
        'btn_confirm_label' => 'Desvincular',
        'action' => '',
    ])
        @slot('modal_header')
            <h4 class="modal-title">Desvincular Ideia</h4>
        @endslot

        @csrf
        @method('DELETE')
        <input type="hidden" name="category_id" value="{{ $category->id }}">
        <p>Você deseja desvincular esta ideia dessa categoria?</p>
    @endcomponent
@endsection

@section('js')
    <script src="{{ asset('assets/js/app.js') }}"></script>
@endsection
