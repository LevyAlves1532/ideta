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
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            @component('components.common.card')
                @slot('card_header')
                    <h3 class="mb-0">
                        Formulário
                    </h3>
                @endslot

                <div class="p-3">
                    @include('category.form', [
                        'category' => $category,
                        'isVisible' => true,
                    ])
                </div>
            @endcomponent
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
@endsection

@section('js')
    <script src="{{ asset('assets/js/app.js') }}"></script>
@endsection
