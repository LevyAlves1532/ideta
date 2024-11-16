<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Ideta - Login</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    </head>
    <body>
        <nav class="navbar navbar-expand-lg" style="background-color: whitesmoke">
            <div class="container py-2">
                <a class="navbar-brand" href="{{ route('login') }}">Ideta</a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Cadastre-se</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="p-3">
            <div class="container-form">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h4 class="py-2" style="margin-bottom: 0; text-align: center;">Faça seu login</h4>
                    </div>
                    <div class="card-body">
                        @component('_components.system-errors')
                        @endcomponent

                        <form method="POST" action="{{ route('login.post') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">E-mail:</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}">
                                @error('email')
                                    <div class="form-text text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Senha</label>
                                <input type="password" class="form-control" id="password" name="password" value="{{ old('password') }}">
                                @error('password')
                                    <div class="form-text text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Logar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
