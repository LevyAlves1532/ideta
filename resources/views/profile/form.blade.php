@component('components.common.card')
    @slot('card_header')
        <h3 class="mb-0">
            Meus Dados
        </h3>
    @endslot

    <div class="p-3">
        <form method="POST" action="{{ route('profile.update', ['user_id' => $user->id]) }}">
            @if (!isset($isVisible))
                @csrf
                @method('PUT')
            @endif
            <div class="row">
                <div class="col-sm-6">
                    @component('components.form.input-advanced', [
                        'id' => 'name',
                        'label' => 'Nome:',
                        'name' => 'name',
                        'placeholder' => 'Digite seu nome...',
                        'value' => old('name') ?? $user->name ?? '',
                        'read_only' => isset($isVisible),
                    ])
                    @endcomponent
                </div>

                <div class="col-sm-6">
                    @component('components.form.input-advanced', [
                        'id' => 'email',
                        'label' => 'E-mail:',
                        'name' => 'email',
                        'placeholder' => 'Digite seu email...',
                        'type' => 'email',
                        'value' => old('email') ?? $user->email ?? '',
                        'read_only' => isset($isVisible),
                    ])
                    @endcomponent
                </div>

                <div class="col-sm-12 d-flex justify-content-end">
                    @if (!isset($isVisible))
                        <button type="submit" class="btn btn-success">
                            Atualizar Perfil
                        </button>
                    @endif
                </div>
            </div>
        </form>
    </div>
@endcomponent

