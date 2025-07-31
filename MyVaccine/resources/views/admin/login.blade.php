<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/c8e307d42e.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="{{ asset('img/icon.png') }}">
    <title>Login Admin - My Vaccine</title>
</head>

<body class="overflow-x-hidden h-screen">

    <nav class="px-[6%] h-[8%] flex justify-between items-center navbar text-[#100E3D] bg-white shadow-md">
        <a href="{{ route('home') }}">
            <img src="{{ asset('img/logo.png') }}" alt="logo" class="w-[140px] 2xl:w-[190px]" />
        </a>
    </nav>

    <div class="w-full flex">

        <!-- Left login background (imagem) -->
        <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-r from-[#686E1A] to-[#3D130E]">
        </div>

        <!-- Right login form -->
        <section class="flex justify-center items-center w-full lg:w-1/2 h-[92vh]">
            <form method="POST" action="{{ route('admin.login.post') }}"
                class="text-[12px] 2xl:text-base flex flex-col gap-2 2xl:gap-3 px-6 lg:px-[32px] w-full lg:w-4/6 justify-center">
                @csrf

                <h1 class="text-xl 2xl:text-2xl font-semibold mb-4">Login Admin</h1>

                <div class="flex flex-col gap-2">
                    <label for="email">Email:</label>
                    <input
                        type="email"
                        name="email"
                        id="email"
                        placeholder="Digite seu Email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        class="border-2 p-2 2xl:p-3 rounded-lg"
                    />
                    @error('email')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex flex-col gap-2 relative">
                    <label for="password">Senha:</label>
                    <input
                        type="password"
                        name="password"
                        id="password"
                        placeholder="Digite sua senha"
                        required
                        class="border-2 p-2 pr-10 2xl:p-3 rounded-lg"
                    />
                    <button
                        type="button"
                        onclick="togglePassword('password', 'eyeIcon1')"
                        class="absolute right-3 top-12 text-gray-600"
                        tabindex="-1"
                    >
                        <i id="eyeIcon1" class="fa-solid fa-eye-slash"></i>
                    </button>
                    @error('password')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Aqui pode adicionar mensagem de status --}}
                @if(session('status'))
                    <p class="text-green-600 text-center mt-2">{{ session('status') }}</p>
                @endif

                <div class="flex flex-col sm:flex-row gap-3 w-full text-xs md:text-base text-center sm:text-start mt-5">
                    <button
                        type="submit"
                        class="bg-[#0B5FFF] text-white font-semibold py-2 px-8 2xl:py-4 2xl:px-10 rounded-lg hover:bg-[#074DD2] cursor-pointer"
                    >
                        Login
                    </button>
                </div>
            </form>
        </section>

    </div>

    <script>
        // Função para mostrar/esconder senha (toggle)
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