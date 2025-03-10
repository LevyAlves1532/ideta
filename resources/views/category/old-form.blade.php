@if (isset($category))
    <form method="POST" action="{{ route('categories.update', ['categoria' => $category->id]) }}">
@else
    <form method="POST" action="{{ route('categories.store') }}">
@endif
    @if (!isset($isVisible))
        @csrf
        @if (isset($category))
            @method('PUT')
        @endif
    @endif
    <div class="mb-3">
        <label for="name" class="form-label">Nome</label>
        <input type="name" class="form-control" id="name" name="name" value="{{ old('name') ?? $category->name ?? '' }}" @if (isset($isVisible)) disabled @endif>
        @error('name')
            <div class="form-text text-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3">
        <label for="color" class="form-label">Cor</label>
        <input type="color" class="form-control form-control-color" id="color" value="{{ old('color') ?? $category->color ?? '#000000' }}" title="Selecione uma cor" name="color"  @if (isset($isVisible)) disabled @endif>
        @error('color')
            <div class="form-text text-danger">{{ $message }}</div>
        @enderror
    </div>
    @if (!isset($isVisible))
        <button type="submit" class="btn btn-success">
            {{ isset($category) ? 'Atualizar Categoria' : 'Criar Categoria' }}
        </button>
    @endif
</form>
