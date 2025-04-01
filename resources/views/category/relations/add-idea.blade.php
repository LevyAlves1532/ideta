@component('components.modal.modal-form', [
    'id' => 'modal-add-idea',
    'btn_confirm_label' => 'Vincular',
    'action' => route('categories.add-idea'),
    'method' => 'post',
    'is_visible' => $errors->has('idea_id'),
])
    @slot('modal_header')
        <h4 class="modal-title">Vincular Ideia</h4>
    @endslot

    @csrf
    <input type="hidden" name="category_id" value="{{ $category->id }}">
    <select class="form-control" name="idea_id">
        <option value="" selected disabled>Selecione uma Ideia</option>
        @foreach ($unrelatedIdeas as $unrelatedIdea)
            <option value="{{ $unrelatedIdea->id }}">{{ $unrelatedIdea->title }}</option>
        @endforeach
    </select>
    @error('idea_id')
        <div class="form-text text-danger">{{ $message }}</div>
    @enderror
@endcomponent
