@component('components.common.card')
    @slot('card_header')
        <h3 class="mb-0">
            Formulário
        </h3>
    @endslot

    <div class="p-3">
        @if (isset($category))
            <form method="POST" action="{{ route('categories.update', ['categoria' => $category->id]) }}">
        @else
            <form method="POST" action="{{ route('categories.store') }}">
        @endif
            @if (!isset($isVisible))
                @csrf
                @if (isset($category))
                    @method('PUT')
                @endif
            @endif
            <div class="row">
                <div class="col-sm-6">
                    @component('components.form.input-advanced', [
                        'id' => 'name',
                        'label' => 'Nome:',
                        'name' => 'name',
                        'placeholder' => 'Digite o nome da categoria...',
                        'value' => old('name') ?? $category->name ?? '',
                        'read_only' => isset($isVisible),
                    ])
                    @endcomponent
                </div>

                <div class="col-sm-6">
                    @component('components.form.input-advanced', [
                        'id' => 'color',
                        'label' => 'Cor:',
                        'name' => 'color',
                        'placeholder' => 'Selecione a cor da categoria...',
                        'type' => 'color',
                        'value' => old('color') ?? $category->color ?? '#000000',
                        'read_only' => isset($isVisible),
                    ])
                    @endcomponent
                </div>

                <div class="col-sm-12 d-flex justify-content-end">
                    @if (!isset($isVisible))
                        <button type="submit" class="btn btn-success">
                            {{ isset($category) ? 'Atualizar Categoria' : 'Criar Categoria' }}
                        </button>
                    @endif
                </div>
            </div>
        </form>
    </div>
@endcomponent
