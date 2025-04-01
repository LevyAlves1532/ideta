@extends('adminlte::auth.auth-page')

@section('title', 'Wordea - Registrar')

@section('auth_header')
    <p class="m-0"><strong>Registre-se</strong></p>
@endsection

@section('auth_body')
    <form method="POST" action="{{ route('register.post') }}">
        @csrf
        @component('components.form.input-advanced', [
            'id' => 'name',
            'label' => 'Nome:',
            'name' => 'name',
            'placeholder' => 'Digite seu nome...'
        ])
        @endcomponent
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
        @component('components.form.input-advanced', [
            'id' => 'password-confirmation',
            'label' => 'Confirmar Senha:',
            'name' => 'password_confirmation',
            'placeholder' => 'Confirme sua senha...',
            'type' => 'password'
        ])
        @endcomponent
        <button type="submit" class="btn btn-dark">Registrar</button>
    </form>
@endsection

@section('auth_footer')
    <div class="text-center">
        <p class="text-muted mb-0">Tem conta? <a href="{{ route('login') }}">Clique Aqui</a></p>
    </div>
@endsection

@section('js')
    <script src="{{ asset('assets/js/app.js') }}"></script>
@endsection
