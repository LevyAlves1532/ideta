<form method="POST" action="#">
    @if (!isset($isVisible))
        @csrf
        @if (isset($user))
            @method('PUT')
        @endif
    @endif
    <div class="mb-3">
        <label for="name" class="form-label">Nome</label>
        <input type="name" class="form-control" id="name" name="name" value="{{ old('name') ?? $user->name ?? '' }}" @if (isset($isVisible)) disabled @endif>
        @error('name')
            <div class="form-text text-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">E-mail</label>
        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') ?? $user->email ?? '' }}" @if (isset($isVisible)) disabled @endif>
        @error('email')
            <div class="form-text text-danger">{{ $message }}</div>
        @enderror
    </div>
    @if (!isset($isVisible))
        <button type="submit" class="btn btn-success">
            Atualizar Perfil
        </button>
    @endif
</form>
