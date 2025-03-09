@extends('_layout.base', [
    'navItemActive' => 'categories',
])

@section('sufix', 'Visualizar Categoria')

@section('body')
    <div class="container p-3">
        @component('_components.system-errors')
        @endcomponent

        <div class="d-flex mt-3" style="justify-content: space-between;align-items:center">
            <h2>Visualizar Categoria</h2>
            <a href="{{ route('categories.index') }}" class="btn btn-primary float-right">Voltar</a>
        </div>
        <hr>
        <div style="max-width: 450px; margin-top: 16px; margin-left:auto; margin-right: auto;">
            @component('category.form', [
                'category' => $category,
                'isVisible' => true,
            ])
            @endcomponent
        </div>
        <hr>
        <div class="d-flex mt-3" style="justify-content: space-between;align-items:center">
            <h2>Ideias da Categoria</h2>
            @if (!$category->is_default)
                <button class="btn btn-success float-right" data-bs-toggle="modal" data-bs-target="#modal-add-idea">Vincular Ideia</button>
            @endif
        </div>
        <hr>
        <div>
            @if ($ideas->count() > 0)
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
                                    @if (!$category->is_default)
                                        <form method="POST" action="{{ route('categories.remove-idea', ['ideia' => $idea->id]) }}">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="category_id" value="{{ $category->id }}">
                                            <button class="btn btn-danger">Desvincular</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{ $ideas->links('pagination::bootstrap-5') }}
            @else
                <p class="text-center text-secondary">Não há ideias</p>
            @endif
        </div>
    </div>

    @component('category.relations.add-idea', [
        'category' => $category,
        'unrelatedIdeas' => $unrelatedIdeas,
    ])

    @endcomponent
@endsection
