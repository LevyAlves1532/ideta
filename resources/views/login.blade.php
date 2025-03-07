@extends('adminlte::auth.auth-page')

@section('title', 'Note Free - Login')

@section('auth_header')
    <p class="m-0"><strong>Fazer Login</strong></p>
@endsection

@section('auth_body')
    <form method="POST" action="{{ route('login.post') }}">
        @csrf
        @component('components.form.input-advanced', [
            'id' => 'email',
            'label' => 'E-mail:',
            'name' => 'email',
            'placeholder' => 'Digite seu e-mail...',
            'type' => 'email'
        ])
        @endcomponent
        @component('components.form.input-advanced', [
            'id' => 'password',
            'label' => 'Senha:',
            'name' => 'password',
            'placeholder' => 'Digite sua senha...',
            'type' => 'password'
        ])
        @endcomponent
        <button type="submit" class="btn btn-dark">Logar</button>
    </form>
@endsection

@section('auth_footer')
    <div class="text-center">
        <p class="text-muted">Não tem conta? <a href="{{ route('register') }}">Clique Aqui</a></p>
        <p class="text-muted mb-0">Esqueceu a senha? <a href="#">Clique Aqui</a></p>
    </div>
@endsection

@section('js')
    <script src="{{ asset('assets/js/app.js') }}"></script>
@endsection
