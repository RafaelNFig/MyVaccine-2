<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('assets/style/style.css') }}" />
    <script src="https://kit.fontawesome.com/c8e307d42e.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="{{ asset('img/icon.png') }}">
    <title>Gerenciar Vacinas</title>
</head>
<body class="bg-gray-100 h-screen flex">

    <!-- Menu lateral -->
    <nav class="flex flex-col justify-between p-5 items-center border-r-2">
        <div class="flex flex-col items-center gap-4">
            <a href="{{ route('admin.home') }}">
                <img src="{{ asset('img/logo-mobile.png') }}" class="w-[36px]" alt="logo my-vaccine" />
            </a>
            <span class="h-[1px] w-full bg-gray-300 rounded-full"></span>
            <div class="grid grid-cols-1 gap-[32px] justify-items-center">
                <span class="uppercase text-xs text-gray-300 font-semibold">main</span>
            
                <a href="{{ route('admin.home') }}">
                    <i class="fa-solid fa-house-medical text-[20px] {{ request()->routeIs('admin.home') ? 'text-black' : 'text-gray-400 hover:text-black transition' }}"></i>
                </a>
            
                <a href="{{ route('admin.vaccine.application') }}">
                    <i class="fa-solid fa-bed text-[20px] {{ request()->routeIs('vaccination-history.*') ? 'text-black' : 'text-gray-400 hover:text-black transition' }}"></i>
                </a>
            
                <a href="{{ route('admin.vaccines.home') }}">
                    <i class="fa-solid fa-syringe text-[20px] {{ request()->routeIs('admin.vaccines.*') ? 'text-black' : 'text-gray-400 hover:text-black transition' }}"></i>
                </a>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit" class="focus:outline-none">
                <i class="fa-solid fa-arrow-right-from-bracket text-[20px] text-red-400 hover:text-red-600 transition"></i>
            </button>
        </form>
    </nav>

    <!-- Conteúdo principal -->
    <section class="w-[90vw] flex justify-center">
        <div class="w-[70%] flex flex-col gap-[5vh] mt-[5vh] mx-[5vw]">

            <div class="flex justify-between items-center">
                <h1 class="text-xl md:text-3xl">Gerenciar Vacinas</h1>
                <button id="openCreateModal" class="bg-blue-500 text-white px-4 py-2 text-xs md:text-sm rounded-md hover:bg-blue-600">
                    Cadastrar vacina
                </button>
            </div>

            <!-- Tabela -->
            <table id="vaccinesTable" class="min-w-full max-w-[100vw] bg-white border border-gray-200 shadow-md text-nowrap">
                <thead>
                    <tr class="bg-[#EEEEEE] text-left text-xs md:text-sm text-[#B5B5B5]">
                        <th class="py-3 px-4">Nome</th>
                        <th class="py-3 px-4">Idade Mínima</th>
                        <th class="py-3 px-4">Idade Máxima</th>
                        <th class="py-3 px-4">Contraindicações</th>
                        <th class="py-3 px-4">Ações</th>
                    </tr>
                </thead>
                <tbody class="text-xs md:text-sm text-gray-700">
                    @forelse ($vaccines as $vaccine)
                        <tr id="vaccine-row-{{ $vaccine->id }}" data-id="{{ $vaccine->id }}" class="border-b border-gray-200 hover:bg-gray-50">
                            <td class="py-3 px-4 col-name">{{ $vaccine->name }}</td>
                            <td class="py-3 px-4 col-min-age">{{ $vaccine->min_age }}</td>
                            <td class="py-3 px-4 col-max-age">{{ $vaccine->max_age ?? '-' }}</td>
                            <td class="py-3 px-4 col-contra">{{ $vaccine->contraindications ?? '-' }}</td>
                            <td class="py-3 px-4 flex gap-2">
                                <button 
                                    data-id="{{ $vaccine->id }}" 
                                    data-name="{{ $vaccine->name }}"
                                    data-min_age="{{ $vaccine->min_age }}"
                                    data-max_age="{{ $vaccine->max_age }}"
                                    data-contraindications="{{ $vaccine->contraindications }}"
                                    class="edit-btn h-full border-blue-500 border-2 text-blue-500 px-3 py-1 md:text-sm rounded-md transition all hover:bg-blue-500 hover:text-white flex gap-2 items-center">
                                    Editar
                                </button>
                                <button 
                                    data-id="{{ $vaccine->id }}" 
                                    class="remove-btn h-full border-red-500 border-2 text-red-500 px-3 py-1 md:text-sm rounded-md transition all hover:bg-red-500 hover:text-white flex gap-2 items-center">
                                    Excluir
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr id="noVaccinesRow">
                            <td colspan="5" class="py-3 px-4 text-center text-gray-500">
                                Nenhuma vacina cadastrada.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
    </section>

    <!-- Modal Criar Vacina -->
    <div id="modalCreateVaccine" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center z-50">
        <div class="bg-white p-6 rounded-lg w-[90%] md:w-[50%] shadow-lg relative">
            <button id="closeCreateModal" class="absolute top-2 right-2 text-gray-600 hover:text-gray-900 text-xl font-bold">&times;</button>
            <h2 class="text-lg font-semibold mb-4">Cadastrar Nova Vacina</h2>
    
            <form id="formCreateVaccine" action="{{ route('vaccines.store') }}">
                @csrf
    
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Nome da Vacina:</label>
                    <input type="text" name="name" id="create_name" required class="w-full p-2 border rounded" placeholder="Ex: Febre Amarela" />
                </div>
    
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Idade Mínima (anos):</label>
                    <input type="number" name="min_age" id="create_min_age" min="0" required class="w-full p-2 border rounded" />
                </div>
    
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Idade Máxima (anos):</label>
                    <input type="number" name="max_age" id="create_max_age" min="0" class="w-full p-2 border rounded" />
                </div>
    
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Contraindicações:</label>
                    <textarea name="contraindications" id="create_contraindications" rows="3" class="w-full p-2 border rounded" placeholder="Ex: Pessoas com alergia ao ovo"></textarea>
                </div>
    
                <div class="flex justify-end gap-2">
                    <button type="button" id="cancelCreateBtn" class="px-4 py-2 bg-gray-500 text-white rounded">Cancelar</button>
                    <button type="submit" id="submitCreateBtn" class="px-4 py-2 bg-blue-500 text-white rounded">Cadastrar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Editar Vacina -->
    <div id="modalEditVaccine" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center z-50">
        <div class="bg-white p-6 rounded-lg w-[90%] md:w-[50%] shadow-lg relative">
            <button id="closeEditModal" class="absolute top-2 right-2 text-gray-600 hover:text-gray-900 text-xl font-bold">&times;</button>
            <h2 class="text-lg font-semibold mb-4">Editar Vacina</h2>
    
            <form id="formEditVaccine" action="">
                @csrf
                @method('PATCH')
                <input type="hidden" name="vaccine_id" id="edit_vaccine_id" />
    
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Nome da Vacina:</label>
                    <input type="text" name="name" id="edit_name" required class="w-full p-2 border rounded" placeholder="Ex: Febre Amarela" />
                </div>
    
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Idade Mínima (anos):</label>
                    <input type="number" name="min_age" id="edit_min_age" min="0" required class="w-full p-2 border rounded" />
                </div>
    
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Idade Máxima (anos):</label>
                    <input type="number" name="max_age" id="edit_max_age" min="0" class="w-full p-2 border rounded" />
                </div>
    
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Contraindicações:</label>
                    <textarea name="contraindications" id="edit_contraindications" rows="3" class="w-full p-2 border rounded" placeholder="Ex: Pessoas com alergia ao ovo"></textarea>
                </div>
    
                <div class="flex justify-end gap-2">
                    <button type="button" id="cancelEditBtn" class="px-4 py-2 bg-gray-500 text-white rounded">Cancelar</button>
                    <button type="submit" id="submitEditBtn" class="px-4 py-2 bg-blue-500 text-white rounded">Salvar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal de Confirmação -->
<div id="confirmModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
    <div class="bg-white rounded-lg p-6 w-80 max-w-full text-center shadow-lg">
      <p class="text-lg font-medium mb-6">Deseja continuar com a ação?</p>
      <div class="flex justify-center gap-4">
        <button id="confirmNoBtn" class="h-full border-red-500 border-2 text-red-500 px-3 py-1 md:text-sm rounded-md transition all hover:bg-red-500 hover:text-white flex gap-2 items-center">Não</button>
        <button id="confirmYesBtn" class="h-full border-green-500 border-2 text-green-500 px-3 py-1 md:text-sm rounded-md transition all hover:bg-green-500 hover:text-white flex gap-2 items-center">Sim</button>
      </div>
    </div>
  </div>
  

  <div id="notification" 
  class="fixed top-5 right-5 text-white px-4 py-2 rounded shadow-lg opacity-0 pointer-events-none transition-opacity duration-300 z-50">
</div>

    <!-- Scripts JS externos -->
    <script src="{{ asset('assets/js/vaccines/createVaccine.js') }}"></script>
    <script src="{{ asset('assets/js/vaccines/editVaccine.js') }}"></script>
    <script src="{{ asset('assets/js/vaccines/removeVaccine.js') }}"></script>
    <script src="{{ asset('assets/js/utils/notification.js') }}"></script>

</body>
</html>
