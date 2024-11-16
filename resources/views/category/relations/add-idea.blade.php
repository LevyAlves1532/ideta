<div class="modal fade" id="modal-add-idea" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" action="{{ route('categories.add-idea') }}" class="modal-content">
            @csrf
            <input type="hidden" name="category_id" value="{{ $category->id }}">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Vincular Ideia</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="idea_id" class="form-label">Ideia</label>
                    <select class="form-select" name="idea_id" id="idea_id">
                        <option selected disabled>Selecione uma ideia</option>
                        @foreach ($unrelatedIdeas as $unrelatedIdea)
                            <option value="{{ $unrelatedIdea->id }}">{{ $unrelatedIdea->title }}</option>
                        @endforeach
                      </select>
                    @error('idea_id')
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
