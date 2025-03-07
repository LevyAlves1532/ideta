@component('components.modal.modal', [
    'id' => $id ?? '',
])
    @slot('modal_header')
        {{ $modal_header }}
    @endslot

    <form action="{{ $action ?? '' }}">
        <div class="modal-body">
            {{ $slot }}
        </div>
        <div class="modal-footer justify-content-end">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            <button class="btn btn-success">Filtrar</button>
        </div>
    </form>
@endcomponent