@extends('_layout.main-adminlte')

@section('title', 'Note Free - Editar Ideia')

@section('content_header')
    <h2>Editar Ideia</h2>
    <hr>
@endsection

@section('content')
    <div class="d-flex justify-content-end mb-3">
        <div class="btn-group">
            <a href="{{ route('ideas.index') }}" class="btn btn-primary">Voltar para ideias</a>
        </div>
    </div>

    @include('idea.form')
@endsection

@section('main_js')
    <script>
        $(function() {
            $('#categories').select2();
        })
    </script>
@endsection
