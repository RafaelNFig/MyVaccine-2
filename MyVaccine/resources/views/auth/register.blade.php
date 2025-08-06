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
<body class="overflow-x-hidden min-h-screen bg-gray-50 flex flex-col">

  <nav class="px-[6%] h-16 flex justify-between items-center navbar text-[#100E3D] bg-white shadow-md">
    <a href="{{ route('home') }}">
      <img src="{{ asset('img/logo.png') }}" alt="Logo" class="w-[140px] 2xl:w-[190px]" />
    </a>
  </nav>

  <main class="flex flex-1 w-full">
    <!-- Imagem lateral -->
    <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-r from-blue-900 to-blue-950"></div>

    <!-- Formulário -->
    <section class="flex justify-center items-start w-full lg:w-1/2 min-h-screen py-12 px-6 lg:px-[32px] overflow-y-auto">
      <form action="{{ route('register') }}" method="POST" class="w-full max-w-md flex flex-col gap-6">
        @csrf

        <h1 class="text-xl 2xl:text-2xl font-semibold mb-4">Cadastro</h1>

        @if ($errors->any())
          <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
            <ul class="list-disc list-inside text-sm">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <div class="flex flex-col gap-2">
          <label for="name" class="font-semibold text-[#100E3D]">Nome completo</label>
          <input
            type="text"
            id="name"
            name="name"
            value="{{ old('name') }}"
            required
            class="border-2 p-2 2xl:p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#0B5FFF]"
          />
        </div>

        <div class="flex flex-col gap-2">
          <label for="email" class="font-semibold text-[#100E3D]">E-mail</label>
          <input
            type="email"
            id="email"
            name="email"
            value="{{ old('email') }}"
            required
            class="border-2 p-2 2xl:p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#0B5FFF]"
          />
        </div>

        <div class="flex gap-4">
          <div class="w-1/2 flex flex-col gap-2">
            <label for="cpf" class="font-semibold text-[#100E3D]">CPF</label>
            <input
              type="text"
              id="cpf"
              name="cpf"
              maxlength="14"
              value="{{ old('cpf') }}"
              required
              class="border-2 p-2 2xl:p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#0B5FFF]"
            />
          </div>

          <div class="w-1/2 flex flex-col gap-2">
            <label for="telephone" class="font-semibold text-[#100E3D]">Telefone</label>
            <input
              type="text"
              id="telephone"
              name="telephone"
              maxlength="15"
              value="{{ old('telephone') }}"
              required
              class="border-2 p-2 2xl:p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#0B5FFF]"
            />
          </div>
        </div>

        <div class="flex flex-col gap-2">
          <label for="dob" class="font-semibold text-[#100E3D]">Data de nascimento</label>
          <input
            type="date"
            id="dob"
            name="dob"
            value="{{ old('dob') }}"
            required
            class="border-2 p-2 2xl:p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#0B5FFF]"
          />
        </div>

        <div class="flex flex-col gap-2">
          <label for="address" class="font-semibold text-[#100E3D]">Endereço</label>
          <input
            type="text"
            id="address"
            name="address"
            value="{{ old('address') }}"
            required
            class="border-2 p-2 2xl:p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#0B5FFF]"
          />
        </div>

        <div class="flex flex-col gap-2 relative">
          <label for="password" class="font-semibold text-[#100E3D]">Senha</label>
          <input
            type="password"
            id="password"
            name="password"
            required
            class="border-2 p-2 pr-10 2xl:p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#0B5FFF]"
          />
          <button
            type="button"
            onclick="togglePassword('password', 'eyeIcon1')"
            class="absolute right-3 top-12 text-gray-600"
            tabindex="-1"
          >
            <i id="eyeIcon1" class="fa-solid fa-eye-slash"></i>
          </button>
        </div>

        <div class="flex flex-col gap-2 relative">
          <label for="password_confirmation" class="font-semibold text-[#100E3D]">Confirmar senha</label>
          <input
            type="password"
            id="password_confirmation"
            name="password_confirmation"
            required
            class="border-2 p-2 pr-10 2xl:p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#0B5FFF]"
          />
          <button
            type="button"
            onclick="togglePassword('password_confirmation', 'eyeIcon2')"
            class="absolute right-3 top-12 text-gray-600"
            tabindex="-1"
          >
            <i id="eyeIcon2" class="fa-solid fa-eye-slash"></i>
          </button>
        </div>

        <div class="flex justify-between items-center mt-5">
          <button
            type="submit"
            class="bg-[#0B5FFF] hover:bg-[#074DD2] text-white font-semibold py-2 px-8 2xl:py-4 2xl:px-10 rounded-lg cursor-pointer"
          >
            Cadastrar
          </button>
          <a href="{{ route('login') }}" class="text-[#0B5FFF] hover:underline text-sm">
            Já tem conta? Entrar
          </a>
        </div>
      </form>
    </section>
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
