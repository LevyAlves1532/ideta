<div class="modal fade" id="modal-add-category" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" action="{{ route('ideas.add-category') }}" class="modal-content">
            @csrf
            <input type="hidden" name="idea_id" value="{{ $idea->id }}">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Vincular Categoria</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="category_id" class="form-label">Categoria</label>
                    <select class="form-select" name="category_id" id="category_id">
                        <option selected disabled>Selecione uma categoria</option>
                        @foreach ($unrelatedCategories as $unrelatedCategory)
                            <option value="{{ $unrelatedCategory->id }}">{{ $unrelatedCategory->name }}</option>
                        @endforeach
                      </select>
                    @error('category_id')
                        <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button type="submit" class="btn btn-success">Fazer Vinculo</button>
            </div>
        </form>
    </div>
</div>
