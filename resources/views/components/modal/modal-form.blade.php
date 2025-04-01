@component('components.modal.modal', [
    'id' => $id ?? '',
])
    @slot('modal_header')
        {{ $modal_header }}
    @endslot

    <form method="{{ $method ?? 'get' }}" action="{{ $action ?? '' }}">
        <div class="modal-body">
            {{ $slot }}
        </div>
        <div class="modal-footer justify-content-end">
            <button type="button" class="btn btn-{{ $btn_type_color_cancel ?? 'danger' }}" data-dismiss="modal">Cancelar</button>
            <button class="btn btn-{{ $btn_type_color_confirm ?? 'success' }}">{{ $btn_confirm_label ?? 'Enviar' }}</button>
        </div>
    </form>
@endcomponent