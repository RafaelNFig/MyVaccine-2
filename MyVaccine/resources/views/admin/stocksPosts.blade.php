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
    <title>Estoque do Posto - {{ $post->name }}</title>
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

    <div>
        <nav class="relative bg-white shadow px-6 py-4 flex items-center justify-center">
          <a href="{{ route('admin.home') }}" 
             class="absolute left-6 text-blue-600 font-bold text-lg hover:underline">
            &larr; Voltar aos Postos
          </a>
          <h1 class="text-xl font-semibold text-center">Estoque do posto: {{ $post->name }}</h1>
        </nav>
      </div>

    <section class="flex-1 w-[90vw] mx-auto mt-8 mb-16">
        @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
        @endif

        <button id="openAddModal" class="mb-6 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
            Adicionar vacina
            <i class="fa-solid fa-plus ml-2"></i>
        </button>

        <table class="min-w-full bg-white border border-gray-200 shadow rounded text-sm">
            <thead class="bg-gray-100 text-gray-600 uppercase">
                <tr>
                    <th class="py-3 px-6 text-left">Vacina</th>
                    <th class="py-3 px-6 text-left">Quantidade</th>
                    <th class="py-3 px-6 text-left">Lote</th>
                    <th class="py-3 px-6 text-left">Validade</th>
                    <th class="py-3 px-6 text-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($stocks as $stock)
                <tr class="border-b hover:bg-gray-50">
                    <td class="py-3 px-6">{{ $stock->vaccine->name }}</td>
                    <td class="py-3 px-6">{{ $stock->quantity }}</td>
                    <td class="py-3 px-6">{{ $stock->batch }}</td>
                    <td class="py-3 px-6">{{ \Carbon\Carbon::parse($stock->expiration_date)->format('d/m/Y') }}</td>
                    <td class="py-3 px-6 text-center">
                        <button
                            data-stock-id="{{ $stock->id }}"
                            class="removeBtn text-red-600 hover:text-red-800 font-semibold"
                            title="Remover lote"
                        >
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-6 text-gray-400">Nenhum lote cadastrado no estoque.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </section>

    {{-- Modal Adicionar Vacina --}}
    <div id="addModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex justify-center items-center z-50">

        <div class="bg-white rounded-lg p-6 w-96">
            <h2 class="text-xl font-semibold mb-4">Adicionar Vacina ao Estoque</h2>
            <form id="addStockForm" method="POST" action="{{ route('stock.store', $post->id) }}">
                @csrf
                <label class="block mb-2 font-semibold" for="vaccine_id">Vacina</label>
                <select name="vaccine_id" id="vaccine_id" required
                    class="w-full border border-gray-300 rounded px-3 py-2 mb-4 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="" selected disabled>Selecione uma vacina</option>
                    @foreach ($vaccines as $vaccine)
                    <option value="{{ $vaccine->id }}">{{ $vaccine->name }}</option>
                    @endforeach
                </select>

                <label class="block mb-2 font-semibold" for="quantity">Quantidade</label>
                <input type="number" name="quantity" id="quantity" min="0" required
                    class="w-full border border-gray-300 rounded px-3 py-2 mb-4 focus:outline-none focus:ring-2 focus:ring-blue-500">

                <label class="block mb-2 font-semibold" for="batch">Lote</label>
                <input type="text" name="batch" id="batch" maxlength="50" required
                    class="w-full border border-gray-300 rounded px-3 py-2 mb-4 focus:outline-none focus:ring-2 focus:ring-blue-500">

                <label class="block mb-2 font-semibold" for="expiration_date">Validade</label>
                <input type="date" name="expiration_date" id="expiration_date" required
                    class="w-full border border-gray-300 rounded px-3 py-2 mb-4 focus:outline-none focus:ring-2 focus:ring-blue-500">

                <div class="flex justify-end gap-3">
                    <button type="button" id="closeAddModal" class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400">Cancelar</button>
                    <button type="submit" class="px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700">Salvar</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Confirmar Remoção --}}
    <div id="confirmRemoveModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex justify-center items-center z-50">
        <div class="bg-white rounded-lg p-6 w-80 max-w-full text-center shadow-lg">
            <p class="text-lg font-medium mb-6">Deseja realmente remover este lote?</p>
            <form id="removeStockForm" method="POST" action="" class="inline-block">
                @csrf
                @method('DELETE')
                <button type="button" id="cancelRemove" class="border border-red-500 text-red-500 px-4 py-2 rounded hover:bg-red-500 hover:text-white mr-4">Cancelar</button>
                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Remover</button>
            </form>
        </div>
    </div>

    <script>
        // CSRF token para fetch/ajax se precisar (aqui só submit via formulário mesmo)
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Abrir modal adicionar vacina
        document.getElementById('openAddModal').addEventListener('click', () => {
            document.getElementById('addModal').classList.remove('hidden');
        });

        // Fechar modal adicionar vacina
        document.getElementById('closeAddModal').addEventListener('click', () => {
            document.getElementById('addModal').classList.add('hidden');
        });

        // Abrir modal remover lote, setar action do form com id do stock
        document.querySelectorAll('.removeBtn').forEach(button => {
            button.addEventListener('click', () => {
                const stockId = button.getAttribute('data-stock-id');
                const form = document.getElementById('removeStockForm');
                form.action = `{{ url('postos/' . $post->id . '/stocks') }}/${stockId}`;
                document.getElementById('confirmRemoveModal').classList.remove('hidden');
            });
        });

        // Cancelar remoção
        document.getElementById('cancelRemove').addEventListener('click', () => {
            document.getElementById('confirmRemoveModal').classList.add('hidden');
        });
    </script>

</body>

</html>
