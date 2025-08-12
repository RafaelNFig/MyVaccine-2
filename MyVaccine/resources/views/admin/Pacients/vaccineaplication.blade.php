<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('assets/style/style.css') }}" />
    <script src="https://kit.fontawesome.com/c8e307d42e.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="{{ asset('img/icon.png') }}">
    <title>Aplicar Vacina</title>
</head>

<body class="bg-gray-100 min-h-screen flex">

    <!-- Barra lateral do Admin -->
    <nav id="mobileMenu"
        class="flex flex-col justify-between p-5 items-center border-r-2 fixed left-0 top-0 h-full bg-white w-[70px] sm:w-[80px] md:w-[100px] z-50">
        <div class="flex flex-col items-center gap-4">
            <a href="{{ url('/admin/postos') }}">
                <img src="{{ asset('img/logo-mobile.png') }}" class="w-[36px]" alt="logo my-vaccine" />
            </a>

            <span class="h-[1px] w-full bg-gray-300 rounded-full"></span>

            <div class="grid grid-cols-1 gap-[32px] justify-items-center">
                <span class="uppercase text-xs text-gray-300 font-semibold">main</span>

                <a href="{{ route('admin.home') }}" title="Postos"
                   class="text-gray-400 hover:text-black transition-colors cursor-pointer">
                    <i class="fa-solid fa-house-medical text-[20px]"></i>
                </a>

                <!-- Página atual: Aplicar Vacina -->
                <a href="{{ route('admin.vaccine.application') }}" title="Aplicar Vacina"
                   class="text-black cursor-default">
                    <i class="fa-solid fa-bed text-[20px]"></i>
                </a>

                <a href="{{ route('admin.vaccines.home') }}" title="Vacinas"
                   class="text-gray-400 hover:text-black transition-colors cursor-pointer">
                    <i class="fa-solid fa-syringe text-[20px]"></i>
                </a>
            </div>

        </div>

        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit" class="focus:outline-none" title="Sair">
                <i
                    class="fa-solid fa-arrow-right-from-bracket text-[20px] text-red-400 hover:text-red-600 transition-all"></i>
            </button>
        </form>
    </nav>

    <!-- Botão menu mobile -->
    <button id="btn" onclick="toggleMenu()"
        class="block sm:hidden fixed p-2 bg-white top-3 rounded-md left-[90px] z-50 transition-all">
        <i id="icon-arrow" class="fa-solid fa-xmark block text-[16px]"></i>
    </button>

    <!-- Conteúdo principal -->
    <main
        class="flex-grow ml-[70px] sm:ml-[80px] md:ml-[100px] px-6 py-10 flex flex-col items-center bg-gray-100 min-h-screen">

        <h1 class="text-3xl font-semibold mb-8 text-center">Aplicação de Vacinas</h1>

        <!-- Lista de usuários em boxes -->
        <div
            class="w-full max-w-5xl grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 overflow-y-auto max-h-[70vh] p-4 border rounded bg-white shadow-md">
            @foreach($users as $user)
                @php
                    $age = \Carbon\Carbon::parse($user->dob)->age;
                    $formattedCpf = preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $user->cpf);
                @endphp
                <div
                    class="flex flex-col justify-between border rounded p-4 shadow hover:shadow-lg transition relative bg-gray-50">
                    <div>
                        <h2 class="font-semibold text-lg mb-2">{{ $user->name }}</h2>
                        <p><strong>CPF:</strong> {{ $formattedCpf }}</p>
                        <p><strong>Contato:</strong> {{ $user->telephone }}</p>
                        <p><strong>Idade:</strong> {{ $age }} anos</p>
                    </div>
                    <button
                        class="mt-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded transition"
                        onclick="openVaccineModal(this)"
                        data-user-cpf="{{ $user->cpf }}"
                        data-user-name="{{ $user->name }}"
                        type="button"
                    >
                        Vacinar
                    </button>
                </div>
            @endforeach
        </div>

    </main>

    <!-- Modal de Vacinação -->
    <div id="vaccineModal"
        class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 px-4">
        <div class="bg-white rounded-lg p-6 max-w-md w-full relative">
            <button id="closeModalBtn" class="absolute top-2 right-3 text-gray-600 hover:text-gray-900 text-xl font-bold">&times;</button>
            <h2 class="text-xl font-semibold mb-4">Vacinar Paciente</h2>
            <p class="mb-2"><strong>Paciente:</strong> <span id="modalUserName"></span></p>

            <form id="vaccineForm" action="{{ route('admin.patients.vaccinate.store') }}" method="POST">
                @csrf
                <input type="hidden" id="modalUserCpf" name="user_cpf" value="">

                <div class="mb-4">
                    <label for="post_id" class="block mb-1 font-medium">Posto de Vacinação</label>
                    <select id="post_id" name="post_id" required
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="" disabled selected>Selecione o posto</option>
                        @foreach($posts as $post)
                            <option value="{{ $post->id }}">{{ $post->name }} - {{ $post->city }}/{{ $post->state }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-6">
                    <label for="vaccine_id" class="block mb-1 font-medium">Vacina</label>
                    <select id="vaccine_id" name="vaccine_id" required
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" disabled>
                        <option value="" disabled selected>Selecione um posto primeiro</option>
                    </select>
                </div>

                <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded transition">
                    Aplicar Vacina
                </button>
            </form>
        </div>
    </div>

    {{-- Importa o JS do modal e notification --}}
    <script src="{{ asset('assets/js/utils/vaccineModal.js') }}"></script>
    <script src="{{ asset('assets/js/utils/notification.js') }}"></script>

    <script>
        function toggleMenu() {
            const menu = document.getElementById('mobileMenu');
            const icon = document.getElementById('icon-arrow');
            menu.classList.toggle('-left-[300px]');
            menu.classList.toggle('left-0');

            if (icon.classList.contains('fa-xmark')) {
                icon.classList.remove('fa-xmark');
                icon.classList.add('fa-bars');
            } else {
                icon.classList.remove('fa-bars');
                icon.classList.add('fa-xmark');
            }
        }

        // Exemplo: Se quiser mostrar notificação na página após redirecionar, pode usar:
        @if(session('success'))
            window.addEventListener('load', () => {
                showNotification("{{ session('success') }}", "success");
            });
        @endif

        @if($errors->any())
            window.addEventListener('load', () => {
                let messages = "";
                @foreach ($errors->all() as $error)
                    messages += "{{ $error }}\n";
                @endforeach
                showNotification(messages.trim(), "error");
            });
        @endif
    </script>

</body>

</html>
