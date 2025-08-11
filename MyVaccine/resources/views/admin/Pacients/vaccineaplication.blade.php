<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('assets/style/style.css') }}" />
    <script src="https://kit.fontawesome.com/c8e307d42e.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="{{ asset('img/icon.png') }}">
    <title>Aplicar Vacina</title>
</head>

<body class="bg-gray-100 h-screen flex">

    <!-- Barra lateral do Admin -->
    <nav id="mobileMenu"
        class="flex flex-col justify-between transition-all relative p-5 items-center border-r-2 left-0 fixed h-full bg-white w-[70px] sm:w-[80px] md:w-[100px] z-50">
        <div class="flex flex-col items-center gap-4">
            <a href="{{ url('/admin/postos') }}">
                <img src="{{ asset('img/logo-mobile.png') }}" class="w-[36px]" alt="logo my-vaccine" />
            </a>

            <span class="h-[1px] w-full bg-gray-300 rounded-full"></span>

            <div class="grid grid-cols-1 gap-[32px] justify-items-center">
                <span class="uppercase text-xs text-gray-300 font-semibold">main</span>
                <a href="{{ route('admin.home') }}" title="Postos">
                    <i class="fa-solid fa-house-medical text-[20px] text-black"></i>
                </a>
                <a href="{{ route('admin.vaccine.application') }}" title="Aplicar Vacina">
                    <i
                        class="fa-solid fa-bed text-[20px] text-gray-400 hover:text-black transition-all"></i>
                </a>
                <a href="{{ route('admin.vaccines.home') }}" title="Vacinas">
                    <i
                        class="fa-solid fa-syringe text-[20px] text-gray-400 hover:text-black transition-all"></i>
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

    <!-- Conteúdo principal, com margem à esquerda para o menu -->
    <section class="flex justify-center items-start w-[90vw] mx-auto my-10 ml-[100px] md:ml-[120px]">
        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
            <h1 class="text-2xl font-semibold mb-6 text-center">Aplicar Vacina em Paciente</h1>

            @if(session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.patients.vaccinate.store') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label for="cpf" class="block mb-1 font-medium">CPF do Paciente</label>
                    <input type="text" id="cpf" name="user_cpf" maxlength="14" placeholder="000.000.000-00"
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required
                        value="{{ old('user_cpf') }}" />
                </div>

                <div>
                    <label for="post_id" class="block mb-1 font-medium">Posto de Vacinação</label>
                    <select id="post_id" name="post_id" required
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="" disabled selected>Selecione o posto</option>
                        @foreach($posts as $post)
                            <option value="{{ $post->id }}" {{ old('post_id') == $post->id ? 'selected' : '' }}>
                                {{ $post->name }} - {{ $post->city }}/{{ $post->state }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
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
    </section>

    <script>
        function toggleMenu() {
            const menu = document.getElementById('mobileMenu');
            const icon = document.getElementById('icon-arrow');
            menu.classList.toggle('left-[-300px]');
            menu.classList.toggle('left-0');

            if (icon.classList.contains('fa-xmark')) {
                icon.classList.remove('fa-xmark');
                icon.classList.add('fa-bars');
            } else {
                icon.classList.remove('fa-bars');
                icon.classList.add('fa-xmark');
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            const postSelect = document.getElementById('post_id');
            const vaccineSelect = document.getElementById('vaccine_id');
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            postSelect.addEventListener('change', () => {
                const postId = postSelect.value;

                if (!postId) {
                    vaccineSelect.innerHTML = '<option value="" disabled selected>Selecione um posto primeiro</option>';
                    vaccineSelect.disabled = true;
                    return;
                }

                vaccineSelect.innerHTML = '<option>Carregando vacinas...</option>';
                vaccineSelect.disabled = true;

                fetch(`/admin/posts/${postId}/vaccines`, {
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    if (!response.ok) throw new Error('Erro na requisição');
                    return response.json();
                })
                .then(data => {
                    vaccineSelect.innerHTML = '';
                    if (data.length === 0) {
                        vaccineSelect.innerHTML = '<option value="" disabled selected>Nenhuma vacina disponível neste posto</option>';
                        vaccineSelect.disabled = true;
                    } else {
                        vaccineSelect.disabled = false;
                        vaccineSelect.innerHTML = '<option value="" disabled selected>Selecione a vacina</option>';
                        data.forEach(vaccine => {
                            const option = document.createElement('option');
                            option.value = vaccine.id;
                            option.textContent = vaccine.name;
                            vaccineSelect.appendChild(option);
                        });

                        // Re-selecionar valor antigo, se existir
                        const oldVaccine = "{{ old('vaccine_id') }}";
                        if (oldVaccine) {
                            vaccineSelect.value = oldVaccine;
                        }
                    }
                })
                .catch(error => {
                    console.error('Erro ao buscar vacinas:', error);
                    vaccineSelect.innerHTML = '<option value="" disabled selected>Erro ao carregar vacinas</option>';
                    vaccineSelect.disabled = true;
                });
            });

            // Dispara o evento se já tiver posto selecionado (ex: após falha de validação)
            if(postSelect.value) {
                postSelect.dispatchEvent(new Event('change'));
            }
        });
    </script>

</body>

</html>
