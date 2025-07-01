<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/c8e307d42e.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" />
    <title>Cadastro - My Vaccine</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">

    <header class="bg-white shadow-md">
        <nav class="container mx-auto flex items-center justify-between p-4">
            <a href="{{ route('home') }}">
                <img src="{{ asset('build/assets/img/logo.png') }}" alt="Logo" class="h-14" />
            </a>
        </nav>
    </header>

    <main class="flex-grow flex items-center justify-center p-6">
        <div class="bg-white rounded-lg shadow-lg p-8 max-w-lg w-full">
            <h1 class="text-3xl font-bold mb-6 text-center text-blue-700">Cadastro</h1>

            @if ($errors->any())
                <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700">Nome completo</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>

                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700">E-mail</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>

                <div class="flex gap-4">
                    <div class="w-1/2">
                        <label for="cpf" class="block text-sm font-semibold text-gray-700">CPF</label>
                        <input type="text" id="cpf" name="cpf" maxlength="14" value="{{ old('cpf') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>

                    <div class="w-1/2">
                        <label for="telephone" class="block text-sm font-semibold text-gray-700">Telefone</label>
                        <input type="text" id="telephone" name="telephone" maxlength="15" value="{{ old('telephone') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>
                </div>

                <div>
                    <label for="dob" class="block text-sm font-semibold text-gray-700">Data de nascimento</label>
                    <input type="date" id="dob" name="dob" value="{{ old('dob') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>

                <div>
                    <label for="address" class="block text-sm font-semibold text-gray-700">Endereço</label>
                    <input type="text" id="address" name="address" value="{{ old('address') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>

                <div>
                    <div class="relative">
                     <label for="password" class="block text-sm font-semibold text-gray-700">Senha</label>
                         <input type="password" id="password" name="password"
                         class="w-full px-4 py-2 pr-10 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                      <button type="button" onclick="togglePassword('password', 'eyeIcon1')"
                          class="absolute right-3 top-[2.3rem] text-gray-600">
                         <i id="eyeIcon1" class="fa-solid fa-eye-slash"></i>
                        </button>
                    </div> 
                </div>

                <div>
                    <div class="relative">
                     <label for="password_confirmation" class="block text-sm font-semibold text-gray-700">Confirmar senha</label>
                     <input type="password" id="password_confirmation" name="password_confirmation"
                       class="w-full px-4 py-2 pr-10 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                      <button type="button" onclick="togglePassword('password_confirmation', 'eyeIcon2')"
                         class="absolute right-3 top-[2.3rem] text-gray-600">
                           <i id="eyeIcon2" class="fa-solid fa-eye-slash"></i>
                        </button>
                    </div>
                </div>

                <div class="flex justify-between items-center">
                    <button type="submit"
                        class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
                        Cadastrar
                    </button>
                    <a href="{{ route('login') }}" class="text-blue-600 hover:underline text-sm">
                        Já tem conta? Entrar
                    </a>
                </div>
            </form>
        </div>
    </main>

    <script>
function togglePassword(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(iconId);

    if (input.type === "password") {
        input.type = "text";
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
    } else {
        input.type = "password";
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
    }
}
</script>

</body>
</html>
