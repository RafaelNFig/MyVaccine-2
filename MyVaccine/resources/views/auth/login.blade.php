<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Login - My Vaccine</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

    <header>
        <nav>
            <div>
                <a href="{{ route('home') }}">
                    <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" style="height: 60px;">
                </a>
            </div>

            <ul>
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="#">Postos de Vacinação</a></li>
                <li><a href="#">Histórico de Vacinas</a></li>
            </ul>

            @auth
                <div>
                    <span>Olá, {{ Auth::user()->name }}!</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit">Sair</button>
                    </form>
                </div>
            @endauth

            @guest
                <a href="{{ route('login') }}">Login</a>
            @endguest
        </nav>
    </header>

    <main>
        <div>
            <h1>Login</h1>

            @if (session('status'))
                <div>{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- CPF -->
                <div>
                    <label for="cpf">CPF:</label>
                    <input type="text" name="cpf" id="cpf" value="{{ old('cpf') }}" required autofocus>
                    @error('cpf')
                        <div>{{ $message }}</div>
                    @enderror
                </div>

                <!-- Senha -->
                <div>
                    <label for="password">Senha:</label>
                    <input type="password" name="password" id="password" required>
                    @error('password')
                        <div>{{ $message }}</div>
                    @enderror
                </div>

                <!-- Botões -->
                <div>
                    <button type="submit">Entrar</button>
                    <a href="{{ route('register') }}">Criar conta</a>
                </div>
            </form>
        </div>
    </main>

</body>
</html>
