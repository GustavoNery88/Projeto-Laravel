<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">Home</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
                @auth <!-- Exibir se o usuário está logado -->
                    <li class="nav-item"><a class="nav-link" href="{{ route('usuarios.index') }}">Usuários</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('logout') }}">Logout</a></li>
                @endauth
                @guest <!-- Exibir se o usuário não está logado -->
                    <li class="nav-item"><a class="nav-link" href="{{ route('usuarios.create') }}">Cadastrar</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
