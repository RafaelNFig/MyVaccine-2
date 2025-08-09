<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/c8e307d42e.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="{{ asset('img/icon.png') }}">
    <title>My Vaccine</title>
</head>
<body class="overflow-x-hidden text-[#100E3D] font-['Roboto']">
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
                            <a href="{{ route('home') }}" class="font-semibold">home</a>
                            <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
                        </li>
                        <li><a href="{{ route('vaccines.index') }}" class="hover:font-semibold">postos de vacinação</a></li>
                        <li><a href="{{ route('vaccination-history.index') }}" class="hover:font-semibold">histórico de vacinas</a></li>
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

    <main class="md:h-[70vh] flex flex-col md:flex-row justify-center px-[6%] gap-[32px] md:gap-[64px] lg:gap-[120px] mt-[4rem]">
        <div class="flex flex-col justify-center gap-6 max-w-[640px]">
            <h1 class="font-bold text-[24px] lg:text-[40px]">Encontre <span class="text-blue-400">postos de vacinação</span> próximos a você.</h1>
            <p class="text-sm text-gray-500">O My Vaccine facilita o acesso à vacinação, permitindo que você encontre postos de saúde, consulte vacinas disponíveis e gerencie seu histórico de imunização de forma prática e segura.</p>
            <a href="{{ route('vaccines.index') }}" class="bg-blue-500 text-white px-6 py-2 text-sm rounded-md hover:bg-blue-600">Encontrar Postos</a>
        </div>
        <div class="flex justify-center items-center">
            <img src="{{ asset('img/vetor-main.jpg') }}" alt="Vacinação" class="w-[250px] md:w-[500px]">
        </div>
    </main>

    <section class="px-[6%] py-[2rem] border-b border-gray-200">
        <ul class="flex flex-col md:flex-row justify-evenly gap-6">
            <li class="flex gap-4 items-center">
                <img src="{{ asset('img/check-heart-icon.png') }}" alt="" class="w-[40px]">
                <div>
                    <p class="font-semibold text-sm">Imunização Segura</p>
                    <p class="text-xs text-gray-500">Encontre vacinas recomendadas para você.</p>
                </div>
            </li>
            <li class="flex gap-4 items-center">
                <img src="{{ asset('img/health-check-icon.png') }}" alt="" class="w-[40px]">
                <div>
                    <p class="font-semibold text-sm">Gestão Inteligente</p>
                    <p class="text-xs text-gray-500">Postos podem atualizar estoques em tempo real.</p>
                </div>
            </li>
            <li class="flex gap-4 items-center">
                <img src="{{ asset('img/syringe-vaccine-icon.png') }}" alt="" class="w-[40px]">
                <div>
                    <p class="font-semibold text-sm">Histórico de Vacinas</p>
                    <p class="text-xs text-gray-500">Acompanhe suas doses e próximas aplicações.</p>
                </div>
            </li>
        </ul>
    </section>

    <footer class="bg-[#100E3D] text-white py-8 px-[6%] mt-12">
        <div class="container mx-auto flex flex-col md:flex-row justify-between items-center">
            <div class="flex flex-col items-center md:items-start">
                <img src="{{ asset('img/logo-white.png') }}" alt="Logo My Vaccine" class="w-40 mb-2">
                <p class="text-sm text-gray-400">Facilitando o acesso à vacinação.</p>
            </div>
            <div class="flex flex-wrap justify-center gap-6 mt-6 md:mt-0">
                <a href="{{ route('home') }}" class="text-sm hover:underline">Home</a>
                <a href="{{ route('vaccines.index') }}" class="text-sm hover:underline">Postos de Vacinação</a>
                <a href="{{ route('vaccination-history.index') }}" class="text-sm hover:underline">Histórico de Vacinas</a>
            </div>
            <div class="flex gap-4 mt-6 md:mt-0">
                <a href="#" class="text-gray-400 hover:text-white text-xl"><i class="fab fa-facebook"></i></a>
                <a href="#" class="text-gray-400 hover:text-white text-xl"><i class="fab fa-instagram"></i></a>
                <a href="#" class="text-gray-400 hover:text-white text-xl"><i class="fab fa-twitter"></i></a>
            </div>
        </div>
        <div class="text-center text-gray-400 text-xs mt-6 border-t border-gray-600 pt-4">
            &copy; 2025 My Vaccine. Todos os direitos reservados.
        </div>
    </footer>
</body>
</html>
