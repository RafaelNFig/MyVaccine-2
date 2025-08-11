<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/c8e307d42e.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{ asset('assets/style/style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="{{ asset('img/icon.png') }}">
    <title>Postos de Vacinação - My Vaccine</title>
</head>

<body class="overflow-x-hidden min-h-screen text-[#100E3D] flex flex-col">

    {{-- HEADER --}}
    <header>
        <nav class="px-[6%] h-[8vh] flex justify-between items-center shadow-lg navbar text-[#100E3D] relative">
            {{-- Logo mobile --}}
            <a href="{{ url('/') }}">
                <img src="{{ asset('img/logo.png') }}" alt="logo" class="md:hidden w-[190px]" />
            </a>

            {{-- Menu desktop --}}
            <div class="hidden md:block w-full">
                <div class="flex w-full justify-between">
                    <a href="{{ url('/') }}">
                        <img src="{{ asset('img/logo.png') }}" alt="logo" class="hidden md:block w-[190px]" />
                    </a>

                    <ul class="flex gap-12 uppercase text-[12px] transition-all">
                        <li class="cursor-pointer hover:font-semibold">
                            <a href="{{ url('/') }}">Home</a>
                        </li>
                        <li class="flex flex-col items-center">
                            <a href="{{ url('/posts') }}" class="font-semibold">Postos de Vacinação</a>
                            <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
                        </li>
                        <li class="cursor-pointer hover:font-semibold">
                            <a href="{{ route('vaccination-history.index') }}"
                               @guest onclick="event.preventDefault(); window.location.href='{{ route('login') }}'" @endguest>
                               Histórico de Vacinas
                            </a>
                        </li>
                    </ul>

                    {{-- Botão Login / Nome do usuário --}}
                    @auth
                        <span class="text-sm">Olá, {{ auth()->user()->name }}</span>
                    @else
                        <a href="{{ route('login') }}"
                           class="bg-blue-500 text-white px-4 py-2 text-xs md:text-sm rounded-md hover:bg-blue-600">
                            Login
                        </a>
                    @endauth
                </div>
            </div>

            {{-- Botão menu mobile --}}
            <button class="block md:hidden" onclick="toggleMenu()">
                <i class="fa-solid fa-bars text-xl"></i>
            </button>

            {{-- Menu mobile --}}
            <div id="mobileMenu"
                 class="hidden absolute top-[8vh] right-0 w-2/3 rounded-br-lg rounded-bl-lg bg-white shadow-md md:hidden flex flex-col items-center p-4">
                <ul class="flex flex-col items-center gap-4 text-[14px]">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li><a href="{{ url('/posts') }}">Postos de Vacinação</a></li>
                    <li>
                        <a href="{{ route('vaccination-history.index') }}"
                           @guest onclick="event.preventDefault(); window.location.href='{{ route('login') }}'" @endguest>
                           Histórico de Vacinas
                        </a>
                    </li>
                </ul>
                <div class="mt-6 mb-3">
                    @auth
                        <span>Olá, {{ auth()->user()->name }}</span>
                    @else
                        <a href="{{ route('login') }}"
                           class="bg-blue-500 text-white px-4 py-2 text-sm rounded-md hover:bg-blue-600">
                            Login
                        </a>
                    @endauth
                </div>
            </div>
        </nav>
    </header>

    {{-- CONTEÚDO PRINCIPAL --}}
    <main class="grow flex flex-col px-[6%] gap-[32px] my-[4rem] items-center">

        {{-- Pesquisa --}}
        <div class="w-full md:w-[600px] flex flex-col">
            <h1 class="text-sm md:text-[24px] text-center font-bold">Pesquisar postos de saúde</h1>
            <input name="search" id="searchInput"
                   class="text-[12px] md:text-[16px] mt-4 w-full p-3 border rounded-[16px] border-black"
                   type="text" placeholder="Insira a cidade ou vacina que deseja pesquisar. Ex: Campinas ou COVID"
                   value="{{ $search ?? '' }}">
        </div>

        {{-- Tabela Desktop --}}
        <table class="hidden md:table min-w-full bg-white border border-gray-200 shadow-md text-nowrap table-fixed">
            <thead>
                <tr class="bg-[#100E3D] text-left text-xs md:text-sm text-white">
                    <th class="font-light py-2 px-4 md:px-6 w-1/5">Nome</th>
                    <th class="font-light p-2 w-1/3">Rua</th>
                    <th class="font-light p-2 w-1/5">Cidade</th>
                    <th class="font-light p-2 w-1/6">Estado</th>
                    <th class="font-light p-2 w-1/6">Ações</th>
                </tr>
            </thead>
            <tbody class="align-top">
                @forelse ($posts as $post)
                    <tr class="hover:bg-gray-50" data-vaccines="{{ $post->stocks->pluck('vaccine.name')->join(' ') }}">
                        <td class="px-4 md:px-6 py-2">{{ $post->name }}</td>
                        <td class="px-2 py-2">{{ $post->address }}</td>
                        <td class="px-2 py-2">{{ $post->city }}</td>
                        <td class="px-2 py-2">{{ $post->state }}</td>
                        <td class="px-2 py-2 flex gap-2">
                            <a href="#" data-post-id="{{ $post->id }}" class="btn-show-stocks border-blue-500 border px-3 py-1 rounded-md text-blue-500 hover:bg-blue-500 hover:text-white flex gap-2 items-center">
                                Visualizar vacinas <i class="fa-solid fa-syringe"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr class="no-db-results">
                        <td colspan="5" class="px-4 py-6 text-center text-gray-400">
                            Nenhum posto cadastrado!
                        </td>
                    </tr>
                @endforelse

                {{-- Linha exibida pelo JS quando filtro não encontra nada --}}
                <tr id="no-results-row" style="display:none;">
                    <td colspan="5" class="px-4 py-6 text-center text-gray-400">
                        Nenhum posto foi encontrado!
                    </td>
                </tr>
            </tbody>
        </table>

        {{-- Cards Mobile --}}
        <section class="block md:hidden grid grid-cols-1 gap-4 w-full">
            @forelse ($posts as $post)
                <div class="post-card shadow-md p-3 rounded-lg flex flex-col gap-2 text-black text-xs"
                     data-state="{{ strtolower($post->state) }}"
                     data-vaccines="{{ $post->stocks->pluck('vaccine.name')->join(' ') }}">
                    <div class="flex justify-between"><span class="font-semibold">Nome:</span><span>{{ $post->name }}</span></div>
                    <div class="flex justify-between"><span class="font-semibold">Endereço:</span><span>{{ $post->address }}</span></div>
                    <div class="flex justify-between"><span class="font-semibold">Cidade:</span><span>{{ $post->city }}</span></div>
                    <div class="flex justify-between"><span class="font-semibold">Estado:</span><span>{{ $post->state }}</span></div>
                    <div>
                        <button class="view-stocks-btn w-full border-blue-500 border text-blue-500 text-center px-3 py-1 rounded-md hover:bg-blue-500 hover:text-white flex gap-2 items-center justify-center" data-post-id="{{ $post->id }}">
                            Visualizar vacinas <i class="fa-solid fa-syringe"></i>
                        </button>
                    </div>
                </div>
            @empty
                <p class="text-center text-gray-400 no-db-results">Nenhum posto cadastrado!</p>
            @endforelse

            {{-- Mensagem mobile exibida pelo JS quando filtro não encontra nada --}}
            <p id="no-results-mobile" class="text-center text-gray-400" style="display:none;">Nenhum posto foi encontrado!</p>
        </section>

    </main>

    {{-- FOOTER --}}
    <footer class="bg-[#100E3D] text-white py-8 md:mt-12 px-[6%]">
        <div class="container mx-auto flex flex-col md:flex-row justify-between items-center">
            <div class="flex flex-col items-center md:items-start">
                <img src="{{ asset('img/logo-white.png') }}" class="w-40 mb-2">
                <p class="text-sm text-gray-400">Facilitando o acesso à vacinação.</p>
            </div>
            <div class="flex flex-wrap justify-center gap-6 mt-6 md:mt-0">
                <a href="{{ url('/') }}" class="text-sm hover:underline">Home</a>
                <a href="{{ url('/posts') }}" class="text-sm hover:underline">Postos</a>
                <a href="{{ route('vaccination-history.index') }}" class="text-sm hover:underline">Histórico</a>
            </div>
            <div class="flex gap-4 mt-6 md:mt-0">
                <i class="fab fa-facebook text-gray-400 hover:text-white"></i>
                <i class="fab fa-instagram text-gray-400 hover:text-white"></i>
                <i class="fab fa-twitter text-gray-400 hover:text-white"></i>
            </div>
        </div>
        <div class="text-center text-gray-400 text-xs mt-6 border-t border-gray-600 pt-4">
            &copy; 2025 My Vaccine. Todos os direitos reservados.
        </div>
    </footer>

    <script src="{{ asset('assets/js/utils/filtroPostos.js') }}"></script>
    <script src="{{ asset('assets/js/utils/showStocks.js') }}"></script>
    <script>
        function toggleMenu() {
            document.getElementById('mobileMenu').classList.toggle('hidden');
        }
    </script>

    <!-- Modal Estoque -->
    <div id="stockModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-lg max-w-lg w-full p-6 relative">
            <button id="closeModalBtn" class="absolute top-2 right-2 text-gray-600 hover:text-gray-900">&times;</button>
            <h2 class="text-xl font-bold mb-4">Estoque do Posto</h2>
            <div id="stockContent" class="overflow-y-auto max-h-64">
                <!-- Conteúdo do estoque carregado pelo JS -->
            </div>
        </div>
    </div>

</body>

</html>
