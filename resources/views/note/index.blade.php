
@extends('_layout.base')

@section('sufix', 'Ver Notas')

@section('body')
    <div class="container py-3">
        @if (!empty($isShared))
            <p class="lead">Ideia de: {{ $user->name }}</p>
        @endif
        <h2 class="mt-3">{{ $idea->title }}</h2>
        @if (empty($isShared))
            <div class="d-flex mt-1">
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modal-add-note">Adicionar Nota</button>
            </div>
        @endif
        @if (!empty($isShared))
            <p>A url de compartilhamento expira em: {{ date('H:i:s - d/m/Y', strtotime($ideaShare->expires_in)) }}</p>
        @endif
        @if (!empty($isShared) && $user->id !== auth()->user()->id)
            <a href="{{ route('ideas.copy', ['token' => $ideaShare->token]) }}" class="btn btn-success">Criar copia</a>
        @endif
        <hr>

        @foreach ($idea->notes()->orderBy('position')->get() as $note)
            <div class="card mt-3">
                @if (empty($isShared))
                    <div class="card-header" style="display: flex; justify-content: flex-end;">
                        <form method="POST" class="me-2" action="{{ route('notes.destroy', ['idea_id' => $idea->id, 'note_id' => $note->id]) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <svg xmlns="http://www.w3.org/2000/svg" style="height: 14px; fill: white;" viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M135.2 17.7L128 32 32 32C14.3 32 0 46.3 0 64S14.3 96 32 96l384 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-96 0-7.2-14.3C307.4 6.8 296.3 0 284.2 0L163.8 0c-12.1 0-23.2 6.8-28.6 17.7zM416 128L32 128 53.2 467c1.6 25.3 22.6 45 47.9 45l245.8 0c25.3 0 46.3-19.7 47.9-45L416 128z"/></svg>
                            </button>
                        </form>

                        <div class="btn-group" role="group">
                            <a href="{{ route('notes.down', ['idea_id' => $idea->id, 'note_id' => $note->id]) }}" class="btn btn-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" style="height: 14px; fill: white;" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M233.4 406.6c12.5 12.5 32.8 12.5 45.3 0l192-192c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L256 338.7 86.6 169.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l192 192z"/></svg>
                            </a>
                            <a href="{{ route('notes.up', ['idea_id' => $idea->id, 'note_id' => $note->id]) }}" class="btn btn-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" style="height: 14px; fill: white;" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M233.4 105.4c12.5-12.5 32.8-12.5 45.3 0l192 192c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L256 173.3 86.6 342.6c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3l192-192z"/></svg>
                            </a>
                        </div>
                    </div>
                @endif
                <div class="card-body note-body">
                    {!! $note->body !!}
                </div>
            </div>
        @endforeach

        @component('note.form', [
            'idea' => $idea,
        ])
        @endcomponent
    </div>
@endsection

@section('scripts')
    <script>
        const CKEDITOR_KEY = "{{$ckeditor_key}}";
    </script>
    <script src="{{asset('assets/js/views/note.js')}}"></script>
@endsection
