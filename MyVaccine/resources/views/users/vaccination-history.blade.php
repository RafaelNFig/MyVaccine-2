<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Histórico de Vacinação - My Vaccine</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/c8e307d42e.js" crossorigin="anonymous"></script>
</head>
<body class="overflow-x-hidden text-[#100E3D] font-['Roboto'] flex flex-col min-h-screen">

    <header>
        <nav class="px-[6%] h-[8vh] flex justify-between items-center shadow-lg text-[#100E3D] relative">
            <a href="{{ route('home') }}">
                <img src="{{ asset('img/logo.png') }}" alt="logo" class="md:hidden w-[190px]" />
            </a>
            <div class="hidden md:block w-full">
                <div class="flex w-full justify-between items-center">
                    <a href="{{ route('home') }}">
                        <img src="{{ asset('img/logo.png') }}" alt="logo" class="hidden md:block w-[190px]" />
                    </a>
                    <ul class="flex gap-12 uppercase text-[12px]">
                        <li class="flex flex-col items-center">
                            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'font-semibold' : '' }}">home</a>
                            @if(request()->routeIs('home'))
                                <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
                            @endif
                        </li>
                        <li class="flex flex-col items-center">
                            <a href="{{ route('posts.index') }}" class="{{ request()->routeIs('posts.index') ? 'font-semibold' : 'hover:font-semibold' }}">postos de vacinação</a>
                            @if(request()->routeIs('posts.index'))
                                <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
                            @endif
                        </li>
                        <li class="flex flex-col items-center">
                            <a href="{{ route('vaccination-history.index') }}" class="{{ request()->routeIs('vaccination-history.index') ? 'font-semibold' : 'hover:font-semibold' }}">histórico de vacinas</a>
                            @if(request()->routeIs('vaccination-history.index'))
                                <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
                            @endif
                        </li>
                    </ul>
                    <div class="flex items-center gap-4">
                        @auth
                            <span class="text-sm font-semibold">Olá, {{ Auth::user()->name }}</span>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="bg-red-500 text-white px-4 py-2 text-sm rounded-md hover:bg-red-600">Sair</button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="bg-blue-500 text-white px-4 py-2 text-sm rounded-md hover:bg-blue-600">Login</a>
                            <a href="{{ route('register') }}" class="bg-blue-500 text-white px-4 py-2 text-sm rounded-md hover:bg-blue-600">Cadastro</a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <main class="container mx-auto px-6 py-10 flex-grow">
        <h1 class="text-2xl font-bold mb-8 text-center text-[#100E3D]">Histórico de Vacinação</h1>

        @if ($histories->isEmpty())
            <p class="text-gray-500 text-center">Você ainda não tomou nenhuma vacina registrada.</p>
        @else
            <div class="overflow-x-auto bg-white rounded-lg shadow-md">
                <table class="min-w-full table-auto">
                    <thead>
                        <tr class="bg-[#100E3D] text-white text-left text-sm">
                            <th class="font-light py-2 px-4 rounded-tl-lg">Vacina</th>
                            <th class="font-light py-2 px-4">Dose</th>
                            <th class="font-light py-2 px-4">Data</th>
                            <th class="font-light py-2 px-4">Lote</th>
                            <th class="font-light py-2 px-4 rounded-tr-lg">Local</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($histories as $history)
                            <tr class="border-b hover:bg-gray-50 text-gray-800 text-sm">
                                <td class="py-2 px-4">{{ $history->vaccine->name }}</td>
                                <td class="py-2 px-4">{{ $history->dose_number ?? '—' }}</td>
                                <td class="py-2 px-4">
                                    {{ \Carbon\Carbon::parse($history->application_date)->format('d/m/Y H:i') }}
                                </td>
                                <td class="py-2 px-4">{{ $history->batch ?? '—' }}</td>
                                <td class="py-2 px-4">{{ $history->post->name ?? '—' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </main>

    <footer class="bg-[#100E3D] text-white py-6 mt-auto">
        <div class="container mx-auto flex flex-col md:flex-row justify-between items-center px-6">
            <div class="mb-4 md:mb-0">
                <img src="{{ asset('img/logo-white.png') }}" alt="Logo My Vaccine" class="w-40" />
                <p class="text-gray-300 text-sm mt-2">Facilitando o acesso à vacinação.</p>
            </div>
            <div class="flex gap-6">
                <a href="#" class="hover:underline">Home</a>
                <a href="#" class="hover:underline">Postos de Vacinação</a>
                <a href="#" class="hover:underline">Histórico de Vacinas</a>
            </div>
            <div class="flex gap-4 mt-4 md:mt-0 text-xl text-gray-400">
                <a href="#" class="hover:text-white"><i class="fab fa-facebook"></i></a>
                <a href="#" class="hover:text-white"><i class="fab fa-instagram"></i></a>
                <a href="#" class="hover:text-white"><i class="fab fa-twitter"></i></a>
            </div>
        </div>
        <div class="text-center text-gray-400 text-xs mt-4 border-t border-gray-600 pt-4">
            &copy; 2025 My Vaccine. Todos os direitos reservados.
        </div>
    </footer>

</body>
</html>
