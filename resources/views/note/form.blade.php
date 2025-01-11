<div class="modal fade" id="modal-add-note" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 768px;">
        <form method="POST" action="{{ route('notes.store', ['idea_id' => $idea->id]) }}" class="modal-content">
            @csrf
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Sua nota</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <textarea class="form-control" id="body" name="body" rows="3"></textarea>
                    @error('body')
                        <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button type="submit" class="btn btn-success">Adicionar Nota</button>
            </div>
        </form>
    </div>
</div>
