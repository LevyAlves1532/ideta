@component('components.modal.modal-form', [
    'id' => 'modal-add-note',
    'btn_confirm_label' => 'Criar',
    'method' => 'post',
    'action' => route('notes.store', ['idea_id' => $idea->id]),
])
    @slot('modal_header')
        <h4 class="modal-title">Criar Nota</h4>
    @endslot

    @csrf
    <textarea class="form-control" id="body" name="body" rows="3"></textarea>
    @error('body')
        <div class="form-text text-danger">{{ $message }}</div>
    @enderror
@endcomponent
