@component('components.modal.modal-form', [
    'id' => 'modal-add-category',
    'btn_confirm_label' => 'Vincular',
    'action' => route('ideas.add-category'),
    'method' => 'post',
])
    @slot('modal_header')
        <h4 class="modal-title">Vincular Categoria</h4>
    @endslot

    @csrf
    <input type="hidden" name="idea_id" value="{{ $idea->id }}">
    @component('components.form.input-advanced', [
        'type' => 'select',
        'id' => 'category',
        'label' => 'Categoria:',
        'name' => 'category_id',
        'options' => $unrelatedCategories,
    ])
    @endcomponent
@endcomponent
