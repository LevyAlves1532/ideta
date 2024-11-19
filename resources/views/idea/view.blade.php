@extends('_layout.base', [
    'navItemActive' => 'ideas',
])

@section('sufix', 'Visualizar Ideia')

@section('body')
    <div class="container p-3">
        <div class="d-flex mt-3" style="justify-content: space-between;align-items:center">
            <h2>Visualizar Ideia</h2>
            <a href="{{ route('ideas.index') }}" class="btn btn-primary float-right">Voltar</a>
        </div>
        <hr>
        <div style="max-width: 450px; margin-top: 16px; margin-left:auto; margin-right: auto;">
            @component('idea.form', [
                'idea' => $idea,
                'categories' => $allCategories,
                'selectedCategories' => $selectedCategories,
                'isVisible' => true,
            ])
            @endcomponent
        </div>
        <hr>
        <div class="d-flex mt-3" style="justify-content: space-between;align-items:center">
            <h2>Categorias da Ideia</h2>
            <button class="btn btn-success float-right" data-bs-toggle="modal" data-bs-target="#modal-add-category">Vincular Categoria</button>
        </div>
        <hr>
        <div>
            @if ($categories->count() > 0)
                <table class="table table-hover table-dark">
                    <thead>
                        <tr>
                            <th scope="col">Nome</th>
                            <th scope="col">Cores</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                            <tr>
                                <td style="vertical-align: middle;">{{ $category->name }}</td>
                                <td style="vertical-align: middle;">
                                    <div class="d-flex" style="align-items: center; gap: 10px; text-transform: uppercase;">
                                        <div style="width: 20px; height: 20px; border-radius: 5px; background-color: {{$category->color}};"></div>
                                        {{ $category->color }}
                                    </div>
                                </td>
                                <td>
                                    <form method="POST" action="{{ route('ideas.remove-category', ['categoria' => $category->id]) }}">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="idea_id" value="{{ $idea->id }}">
                                        <button class="btn btn-danger">Desvincular</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{ $categories->links('pagination::bootstrap-5') }}
            @else
                <p class="text-center text-secondary">Não há categorias</p>
            @endif
        </div>
    </div>

    @component('idea.relations.add-category', [
        'idea' => $idea,
        'unrelatedCategories' => $unrelatedCategories,
    ])
    @endcomponent
@endsection
