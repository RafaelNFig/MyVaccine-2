<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('assets/style/style.css') }}" />
    <script src="https://kit.fontawesome.com/c8e307d42e.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="{{ asset('img/icon.png') }}">
    <title>Estoque de vacinas</title>
</head>

<body class="bg-gray-100 h-screen flex">

    <nav class="flex flex-col justify-between p-5 items-center border-r-2">
        <div class="flex flex-col items-center gap-4">
            <a href="{{ route('admin.home') }}">
                <img src="{{ asset('img/logo-mobile.png') }}" class="w-[36px]" alt="logo my-vaccine" />
            </a>

            <span class="h-[1px] w-full bg-gray-300 rounded-full"></span>

            <div class="grid grid-cols-1 gap-[32px] justify-items-center">
                <span class="uppercase text-xs text-gray-300 font-semibold">main</span>
                <a href="{{ route('admin.home') }}">
                    <i class="fa-solid fa-house-medical text-[20px] text-black"></i>
                </a>
                <a href="{{ route('vaccination-history.index') }}">
                    <i class="fa-solid fa-bed text-[20px] text-gray-400 hover:text-black transition all"></i>
                </a>
                <a href="{{ isset($post) && $post ? route('admin.vaccines.home', ['post_id' => $post->id]) : route('admin.vaccines.home') }}">
                    <i class="fa-solid fa-syringe text-[20px] text-gray-400 hover:text-black transition all"></i>
                </a>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit" class="focus:outline-none">
                <i class="fa-solid fa-arrow-right-from-bracket text-[20px] text-red-400 hover:text-red-600 transition all"></i>
            </button>
        </form>
    </nav>

    <section class="w-[90vw] flex justify-center">
        <div class="w-[70%] flex flex-col gap-[5vh] mt-[5vh] mx-[5vw]">

            <div class="flex justify-between">
                <h1 class="text-xl md:text-3xl">
                    Gerenciar Estoque - {{ $post->name ?? 'Nenhum posto selecionado' }}
                </h1>

                @if(isset($post) && $post)
                    <button id="openModal"
                        class="bg-blue-500 text-white px-4 py-2 text-xs md:text-sm rounded-md hover:bg-blue-600">
                        Cadastrar novo lote
                    </button>
                @endif
            </div>

            <table class="min-w-full max-w-[100vw] bg-white border border-gray-200 shadow-md text-nowrap">
                <thead>
                    <tr class="bg-[#EEEEEE] text-left text-xs md:text-sm text-[#B5B7C0]">
                        <th class="font-light py-3 px-2 w-1/5 border-b">Vacina</th>
                        <th class="font-light px-2 py-2 border-b w-1/5">Quantidade em estoque</th>
                        <th class="font-light px-2 py-2 border-b w-1/5">Lote</th>
                        <th class="font-light px-2 py-2 border-b w-1/5">Validade do Lote</th>
                        <th class="font-light px-2 py-2 border-b w-1/5">Ações</th>
                        <th class="font-light px-2 py-2 border-b w-1/5">Última atualização</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($stocks as $stock)
                        <tr class="hover:bg-gray-50">
                            <td class="px-2 py-2 border-b text-xs md:text-sm text-gray-800">{{ $stock->vaccine->name ?? 'N/D' }}</td>
                            <td class="px-2 py-2 border-b text-xs md:text-sm text-gray-800">{{ $stock->quantity }}</td>
                            <td class="px-2 py-2 border-b text-xs md:text-sm text-gray-800">{{ $stock->batch }}</td>
                            <td class="px-2 py-2 border-b text-xs md:text-sm text-gray-800">{{ \Carbon\Carbon::parse($stock->expiration_date)->format('d/m/Y') }}</td>
                            <td class="px-2 py-2 border-b text-xs md:text-xs flex gap-2 flex-col md:flex-row">
                                <a href="{{ route('stock.edit', $stock->id) }}" class="h-full border-blue-500 border-2 text-blue-500 px-3 py-1 md:text-sm rounded-md transition all hover:bg-blue-500 hover:text-white flex gap-2 items-center">
                                    Editar <i class="fa-solid fa-pencil"></i>
                                </a>
                                <form action="{{ route('stock.destroy', $stock->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este lote?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="h-full border-red-500 border-2 text-red-500 px-3 py-1 md:text-sm rounded-md transition all hover:bg-red-500 hover:text-white flex gap-2 items-center">
                                        Excluir <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                            <td class="px-2 py-2 border-b text-xs md:text-sm text-gray-800">
                                {{ \Carbon\Carbon::parse($stock->updated_at)->format('d/m/Y - H:i:s') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-4 text-center text-gray-400">
                                Nenhum estoque cadastrado{{ isset($post) && $post ? ' neste posto' : '' }}!
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <!-- Modal -->
    @if(isset($post) && $post)
    <div id="modal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center">
        <div class="bg-white p-6 rounded-lg w-[90%] md:w-[50%] shadow-lg">
            <h2 class="text-lg font-semibold mb-4">Cadastrar Novo Estoque</h2>

            <form id="stockForm" method="POST" action="{{ route('stock.store') }}">
                @csrf
                <input type="hidden" name="post_id" value="{{ $post->id }}" />

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Vacina:</label>
                    <select name="vaccine_id" required class="w-full p-2 border rounded">
                        <option value="">Selecione uma vacina</option>
                        @foreach ($vaccines as $vaccine)
                            <option value="{{ $vaccine->id }}">{{ $vaccine->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Quantidade:</label>
                    <input type="number" name="quantity" required class="w-full p-2 border rounded" />
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Lote:</label>
                    <input type="text" name="batch" required class="w-full p-2 border rounded" />
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Data de Validade:</label>
                    <input type="date" name="expiration_date" required class="w-full p-2 border rounded" />
                </div>

                <div class="flex justify-end gap-2">
                    <button type="button" id="closeModal" class="px-4 py-2 bg-gray-500 text-white rounded">Cancelar</button>
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">Cadastrar</button>
                </div>
            </form>
        </div>
    </div>
    @endif

    <script src="{{ asset('assets/js/stocks.js') }}"></script>

</body>

</html>
