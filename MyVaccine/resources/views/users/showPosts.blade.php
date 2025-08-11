<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/c8e307d42e.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{ asset('assets/style/style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="{{asset('img/icon.png') }}">
    <title>Postos de vacinação - My Vaccine</title>
</head>

<body class="overflow-x-hidden min-h-screen text-[#100E3D] flex flex-col min-h-screen">

    <header>
        <nav class="px-[6%] h-[8vh] flex justify-between items-center shadow-lg navbar text-[#100E3D] relative">
            <a href="{{ url('/') }}"><img src="{{ asset('img/logo.png') }}" alt="logo" class="md:hidden w-[190px]" /></a>

            <!-- Desktop Menu -->
            <div class="hidden md:block w-full">
                <div class="flex w-full justify-between">
                    <a href="{{ url('/') }}"><img src="{{ asset('img/logo.png') }}" alt="logo"
                            class="hidden md:block w-[190px]" /></a>
                    <ul class="flex gap-12 uppercase text-[12px] transition-all">
                        <li class="cursor-pointer hover:font-semibold">
                            <a href="{{ url('/') }}" class="cursor-pointer">home</a>
                        </li>
                        <li class="flex flex-col items-center">
                            <a href="{{ url('/posts') }}" class="cursor-pointer font-semibold">postos de vacinação</a>
                            <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
                        </li>
                        <li class="cursor-pointer hover:font-semibold">
                            <a href="{{ url('/history-vaccine') }}" class="cursor-pointer hover:font-semibold">histórico de
                                vacinas</a>
                        </li>
                    </ul>

                    {{-- Aqui pode colocar condição de login, se quiser --}}
                    {{-- Por enquanto sem sessão, então só mostrar botão Login --}}
                    <a href="{{ url('/login') }}"
                        class="bg-blue-500 text-white px-4 py-2 text-xs md:text-sm rounded-md hover:bg-blue-600 cursor-pointer">
                        Login
                    </a>
                </div>
            </div>

            <!-- Mobile Menu Button -->
            <button class="block md:hidden" onclick="toggleMenu()">
                <i class="fa-solid fa-bars text-xl"></i>
            </button>

            <!-- Mobile Menu -->
            <div id="mobileMenu"
                class="hidden absolute top-[8vh] right-0 w-2/3 rounded-br-lg rounded-bl-lg bg-white shadow-md md:hidden flex flex-col items-center p-4">
                <ul class="flex flex-col items-center gap-4 text-[14px]">
                    <li class="cursor-pointer hover:font-semibold"><a href="{{ url('/') }}">Home</a></li>
                    <li class="cursor-pointer hover:font-semibold"><a href="{{ url('/posts') }}">Postos de Vacinação</a>
                    </li>
                    <li class="cursor-pointer hover:font-semibold"><a href="{{ url('/history-vaccine') }}">Histórico de
                            vacinação</a></li>
                </ul>
                <div class="mt-6 mb-3">
                    <a href="{{ url('/login') }}"
                        class="bg-blue-500 text-white px-4 py-2 text-sm rounded-md hover:bg-blue-600 cursor-pointer">
                        Login
                    </a>
                </div>
            </div>
        </nav>
    </header>

    <main class="grow flex flex-col grow px-[6%] gap-[32px] my-[4rem] items-center">

        <div class="w-full md:w-[600px] flex flex-col">
            <h1 class="text-sm md:text-[24px] text-center font-bold">Pesquisar postos de saúde</h1>
            <input id="searchInput"
                class="text-[12px] md:text-[16px] mt-4 w-full p-3 border-[1px] rounded-[16px] border-black" type="text"
                placeholder="Insira a cidade que deseja pesquisar. Ex: Campinas">
        </div>

        <table class="hidden md:block min-w-full bg-white border border-gray-200 shadow-md text-nowrap">
            <thead>
                <tr class="bg-[#100E3D] text-left text-xs md:text-sm text-white">
                    <th class="font-light border-b py-2 px-4 md:px-6 rounded-tl-lg w-1/5">Nome do Posto</th>
                    <th class="font-light p-2 border-b w-full">Rua</th>
                    <th class="font-light p-2 border-b w-1/5">Cidade</th>
                    <th class="font-light p-2 w-1/5">Estado</th>
                    <th class="font-light p-2 rounded-tr-lg w-1/5">Ações</th>
                </tr>
            </thead>
            <tbody>
                @if ($posts->isEmpty())
                    <tr>
                        <td colspan="5" class="px-4 py-4 text-center text-gray-400">Nenhum posto cadastrado!</td>
                    </tr>
                @endif

                @foreach ($posts as $post)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 md:px-6 py-2 border-b text-xs md:text-sm text-gray-800">{{ $post->name }}</td>
                        <td class="px-2 py-2 border-b text-xs md:text-sm text-gray-800">{{ $post->address }}</td>
                        <td class="px-2 py-2 border-b text-xs md:text-sm text-gray-800">{{ $post->city }}</td>
                        <td class="px-2 py-2 border-b text-xs md:text-sm text-gray-800">{{ $post->state }}</td>
                        <td class="px-2 py-2 border-b text-xs flex gap-2 flex-col md:flex-row">
                            <a href="{{ url('vaccines?id=' . $post->id) }}"
                                class="border-blue-500 border-2 text-blue-500 px-3 py-1 text-xs md:text-sm rounded-md transition-all hover:bg-blue-500 hover:text-white flex gap-2 items-center">
                                Visualizar vacinas
                                <i class="fa-solid fa-syringe"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- table mobile -->
        <!-- Mobile cards (postos) -->
        <section class="block md:hidden grid grid-cols-1 gap-4 w-full">
            @foreach ($posts as $post)
                <div class="post-card shadow-md p-3 rounded-lg flex flex-col gap-2 text-black text-xs"
                    data-state="{{ strtolower($post->state) }}">
                    <div class="flex justify-between w-full">
                        <span class="font-semibold">Nome:</span>
                        <span>{{ $post->name }}</span>
                    </div>
                    <div class="flex justify-between w-full">
                        <span class="font-semibold">Endereço:</span>
                        <span>{{ $post->address }}</span>
                    </div>
                    <div class="flex justify-between w-full">
                        <span class="font-semibold">Cidade:</span>
                        <span>{{ $post->city }}</span>
                    </div>
                    <div class="flex justify-between w-full">
                        <span class="font-semibold">Estado:</span>
                        <span>{{ $post->state }}</span>
                    </div>
                    <div class="flex w-full">
                        <a href="{{ url('vaccines?id=' . $post->id) }}"
                            class="w-full border-blue-500 font-semibold border-[1px] text-[10px] text-blue-500 text-center flex justify-center px-3 py-1 rounded-md transition-all hover:bg-blue-500 hover:text-white flex gap-2 items-center">
                            Visualizar vacinas
                            <i class="fa-solid fa-syringe"></i>
                        </a>
                    </div>
                </div>
            @endforeach
        </section>

    </main>

    <footer class=" bg-[#100E3D] text-white py-8 md:mt-12 px-[6%]">
        <div class="container mx-auto flex flex-col md:flex-row justify-between items-center">
            <!-- Logo e Nome -->
            <div class="flex flex-col items-center md:items-start">
                <img src="{{ asset('img/logo-white.png') }}" alt="Logo My Vaccine" class="w-40 mb-2">
                <p class="text-sm text-gray-400">Facilitando o acesso à vacinação.</p>
            </div>

            <!-- Links -->
            <div class="flex flex-wrap justify-center gap-6 mt-6 md:mt-0">
                <a href="{{ url('/') }}" class="text-sm hover:underline">Home</a>
                <a href="{{ url('/posts') }}" class="text-sm hover:underline">Postos de Vacinação</a>
                <a href="{{ url('/history-vaccine') }}" class="text-sm hover:underline">Histórico de Vacinas</a>
            </div>

            <!-- Redes Sociais -->
            <div class="flex gap-4 mt-6 md:mt-0">
                <button href="" class="text-gray-400 hover:text-white text-xl"><i class="fab fa-facebook"></i></button>
                <button href="" class="text-gray-400 hover:text-white text-xl"><i class="fab fa-instagram"></i></button>
                <button href="" class="text-gray-400 hover:text-white text-xl"><i class="fab fa-twitter"></i></button>
            </div>
        </div>

        <!-- Direitos Autorais -->
        <div class="text-center text-gray-400 text-xs mt-6 border-t border-gray-600 pt-4">
            &copy; 2025 My Vaccine. Todos os direitos reservados.
        </div>
    </footer>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const searchInput = document.getElementById("searchInput");

            const tableRows = document.querySelectorAll("table tbody tr");
            const mobileCards = document.querySelectorAll(".post-card");

            searchInput.addEventListener("input", function() {
                const searchValue = searchInput.value.trim().toLowerCase();

                let foundInTable = false;
                let foundInCards = false;

                // --- Filtro para tabela (desktop) ---
                tableRows.forEach(row => {
                    const stateCell = row.cells[2]; // Acessa a 3ª coluna (Estado)
                    if (stateCell) {
                        const stateText = stateCell.textContent.trim().toLowerCase();
                        if (stateText.includes(searchValue)) {
                            row.style.display = "";
                            foundInTable = true;
                        } else {
                            row.style.display = "none";
                        }
                    }
                });

                // Remove ou adiciona "Nenhum posto encontrado!" na tabela
                const noResultsRow = document.querySelector(".no-results");
                if (!foundInTable) {
                    if (!noResultsRow) {
                        const noResults = document.createElement("tr");
                        noResults.classList.add("no-results");
                        noResults.innerHTML =
                            '<td colspan="5" class="px-4 py-4 text-center text-gray-400">Nenhum posto encontrado!</td>';
                        document.querySelector("table tbody").appendChild(noResults);
                    }
                } else if (noResultsRow) {
                    noResultsRow.remove();
                }

                // --- Filtro para cards (mobile) ---
                mobileCards.forEach(card => {
                    const state = card.dataset.state;
                    if (state.includes(searchValue)) {
                        card.style.display = "";
                        foundInCards = true;
                    } else {
                        card.style.display = "none";
                    }
                });

                // Opcional: mostrar mensagem no mobile se quiser (ex: <div id="noMobileResults">Nenhum posto encontrado</div>)
                // Basta adicionar e usar `document.getElementById('noMobileResults').style.display = foundInCards ? 'none' : 'block';`
            });
        });

        function toggleMenu() {
            document.getElementById('mobileMenu').classList.toggle('hidden');
        }
    </script>

</body>

</html>
