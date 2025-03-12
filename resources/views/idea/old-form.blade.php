@if (isset($idea))
    <form method="POST" action="{{ route('ideas.update', ['ideia' => $idea->id]) }}">
@else
    <form method="POST" action="{{ route('ideas.store') }}">
@endif
    @if (!isset($isVisible))
        @csrf
        @if (isset($idea))
            @method('PUT')
        @endif
    @endif
    @php
        $sCategories = old('categories') ?? $selectedCategories ?? [];
    @endphp
    <div class="mb-3">
        <label for="title" class="form-label">Título</label>
        <input type="text" class="form-control" id="title" name="title" value="{{ old('title') ?? $idea->title ?? '' }}" @if (isset($isVisible)) disabled @endif>
        @error('title')
            <div class="form-text text-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3">
        <label for="categories" class="form-label">Categorias</label>
        <select class="form-select" multiple name="categories[]" id="categories" @if (isset($isVisible)) disabled @endif>
            <option @if (empty($sCategories)) selected @endif disabled>Selecione uma ou mais categorias</option>
            @foreach ($categories as $category)
                @if (!$category->is_default)
                    <option
                        value="{{ $category->id }}"
                        @if (in_array($category->id, $sCategories))
                        selected
                        @endif
                    >
                        {{ $category->name }}
                    </option>
                @endif
            @endforeach
        </select>
        @error('categories')
            <div class="form-text text-danger">{{ $message }}</div>
        @enderror
    </div>
    @if (!isset($isVisible))
        <button type="idea" class="btn btn-success">
            {{ isset($idea) ? 'Atualizar Ideia' : 'Criar Ideia' }}
        </button>
    @endif
</form>
