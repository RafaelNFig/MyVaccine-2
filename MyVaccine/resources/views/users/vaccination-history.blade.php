<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Histórico de Vacinação - My Vaccine</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/c8e307d42e.js" crossorigin="anonymous"></script>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">

    <header class="bg-white shadow-md">
        <nav class="container mx-auto flex items-center justify-between p-4">
            <a href="{{ route('home') }}">
                <img src="{{ asset('img/logo.png') }}" alt="Logo" class="h-14" />
            </a>
            <!-- Aqui você pode colocar outros links / menu se quiser -->
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
                            <th class="font-light py-2 px-4 rounded-tl-lg">Usuário</th>
                            <th class="font-light py-2 px-4">Vacina</th>
                            <th class="font-light py-2 px-4">Dose</th>
                            <th class="font-light py-2 px-4">Data</th>
                            <th class="font-light py-2 px-4">Lote</th>
                            <th class="font-light py-2 px-4 rounded-tr-lg">Local</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($histories as $history)
                            <tr class="border-b hover:bg-gray-50 text-gray-800 text-sm">
                                <td class="py-2 px-4">{{ $history->user->name }}</td>
                                <td class="py-2 px-4">{{ $history->vaccine->name }}</td>
                                <td class="py-2 px-4">{{ $history->dose ?? '—' }}</td>
                                <td class="py-2 px-4">
                                    {{ \Carbon\Carbon::parse($history->application_date)->format('d/m/Y H:i') }}
                                </td>
                                <td class="py-2 px-4">{{ $history->batch ?? '—' }}</td>
                                <td class="py-2 px-4">{{ $history->location ?? '—' }}</td>
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
