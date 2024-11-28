<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Ideta - @yield('sufix')</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    </head>
    <body>
        <nav class="navbar py-3" style="background-color: whitesmoke">
            <div class="container">
                <a class="navbar-brand" href="{{ route('index') }}">Ideta</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Ideta Menu</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                            <li class="nav-item">
                                <a class="nav-link @isset($navItemActive) {{ $navItemActive === 'home' ? 'active' : '' }} @endisset" aria-current="page" href="{{ route('index') }}">Home</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link @isset($navItemActive) {{ $navItemActive === 'categories' ? 'active' : '' }} @endisset" aria-current="page" href="{{ route('categories.index') }}">Categorias</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link @isset($navItemActive) {{ $navItemActive === 'ideas' ? 'active' : '' }} @endisset" aria-current="page" href="{{ route('ideas.index') }}">Ideias</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>

        @yield('body')
    </body>
</html>
