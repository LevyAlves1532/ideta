@component('components.common.card')
    @slot('card_header')
        <h3 class="mb-0">
            Formulário
        </h3>
    @endslot

    <div class="p-3">
        @if (isset($idea))
            <form method="POST" action="{{ route('ideas.update', ['ideia' => $idea->id]) }}">
        @else
            <form method="POST" action="{{ route('ideas.store') }}">
        @endif
            @if (!isset($isVisible))
                @csrf
                @if (isset($idea))
                    @method('PUT')
                @endif
            @endif
            <div class="row">
                <div class="@if($isVisible) col-sm-12 @else col-sm-6 @endif">
                    @component('components.form.input-advanced', [
                        'id' => 'title',
                        'label' => 'Nome:',
                        'name' => 'title',
                        'placeholder' => 'Digite o título da ideia...',
                        'value' => old('title') ?? $idea->title ?? '',
                        'read_only' => isset($isVisible),
                    ])
                    @endcomponent
                </div>

                @if (!$isVisible)  
                    <div class="col-sm-6">
                        @component('components.form.input-advanced', [
                            'type' => 'select',
                            'id' => 'categories',
                            'label' => 'Categoria:',
                            'name' => 'categories[]',
                            'options' => $idea->categories->map(fn ($category) => [
                                'id' => $category->id,
                                'name' => $category->name
                            ]),
                            'isMutiple' => true,
                        ])
                        @endcomponent
                    </div>
                @endif

                <div class="col-sm-12 d-flex justify-content-end">
                    @if (!isset($isVisible))
                        <button type="submit" class="btn btn-success">
                            {{ isset($idea) ? 'Atualizar Ideia' : 'Criar Ideia' }}
                        </button>
                    @endif
                </div>
            </div>
        </form>
    </div>
@endcomponent
