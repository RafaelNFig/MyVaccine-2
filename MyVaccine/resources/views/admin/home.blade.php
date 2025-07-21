<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../assets/style/style.css" />
    <script src="https://kit.fontawesome.com/c8e307d42e.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="../assets/img/icon.png">
    <title>Gerenciamento de Postos</title>
</head>

<body class="bg-gray-100 h-screen flex">

    <nav id="mobileMenu" class="flex flex-col justify-between transition-all relative p-5 items-center border-r-2">
        <div class="flex flex-col items-center gap-4">
            <a href="../posts/read-post.php"><img src="../assets/img/logo-mobile.png" class="w-[36px]"
                    alt="logo my-vaccine"></a>

            <!-- barrinha -->
            <span class="h-[1px] w-full bg-gray-300 rounded-full"></span>

            <div class="grid grid-cols-1 gap-[32px] justify-items-center">
                <span class="uppercase text-xs text-gray-300 font-semibold">main</span>
                <!-- Postos de saude -->
                <a href="../posts/read-post.php">
                    <i class="fa-solid fa-house-medical text-[20px] text-black"></i>
                </a>
                <!-- Pacientes -->
                <a href="../patients/vaccine-application.php">
                    <i class="fa-solid fa-bed text-[20px] text-gray-400 hover:text-black transition all"></i>
                </a>
                <!-- Vacinas -->
                <a href="../vaccines/read-vaccine.php">
                    <i class="fa-solid fa-syringe text-[20px] text-gray-400 hover:text-black transition all"></i>
                </a>
            </div>
        </div>

        <a href="../admin/logout-admin.php">
            <i
                class="fa-solid fa-arrow-right-from-bracket text-[20px] text-red-400 hover:text-red-600 transition all"></i>
        </a>

    </nav>

    <button id="btn" onclick="toggleMenu()"
        class="block sm:hidden fixed p-2 bg-white top-3 rounded-md left-[50px] transition-all">
        <i id="icon-arrow" class="fa-solid fa-xmark block text-[16px]"></i>
    </button>

    <!-- Modal Cadastrar posto -->
    <div id="modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
        <div class="bg-white p-6 rounded-lg w-96">
            <h2 class="text-xl mb-4">Cadastrar Novo Posto</h2>
            <form id="createPostForm">
                <input type="text" name="name" placeholder="Nome do Posto" class="w-full p-2 border rounded mb-2"
                    required>
                <input type="text" name="address" placeholder="Rua" class="w-full p-2 border rounded mb-2" required>
                <input type="text" name="city" placeholder="Cidade" class="w-full p-2 border rounded mb-2" required>
                <select name="state" class="w-full border p-2 rounded-md mb-3">
                    <option value="" selected disabled class="">Selecione um estado</option>
                    <option value="AC">AC - Acre</option>
                    <option value="AL">AL - Alagoas</option>
                    <option value="AP">AP - Amapá</option>
                    <option value="AM">AM - Amazonas</option>
                    <option value="BA">BA - Bahia</option>
                    <option value="CE">CE - Ceará</option>
                    <option value="DF">DF - Distrito Federal</option>
                    <option value="ES">ES - Espírito Santo</option>
                    <option value="GO">GO - Goiás</option>
                    <option value="MA">MA - Maranhão</option>
                    <option value="MT">MT - Mato Grosso</option>
                    <option value="MS">MS - Mato Grosso do Sul</option>
                    <option value="MG">MG - Minas Gerais</option>
                    <option value="PA">PA - Pará</option>
                    <option value="PB">PB - Paraíba</option>
                    <option value="PR">PR - Paraná</option>
                    <option value="PE">PE - Pernambuco</option>
                    <option value="PI">PI - Piauí</option>
                    <option value="RJ">RJ - Rio de Janeiro</option>
                    <option value="RN">RN - Rio Grande do Norte</option>
                    <option value="RS">RS - Rio Grande do Sul</option>
                    <option value="RO">RO - Rondônia</option>
                    <option value="RR">RR - Roraima</option>
                    <option value="SC">SC - Santa Catarina</option>
                    <option value="SP">SP - São Paulo</option>
                    <option value="SE">SE - Sergipe</option>
                    <option value="TO">TO - Tocantins</option>
                </select>
                <div class="flex justify-end gap-2">
                    <button type="button" id="closeModalPost" class="bg-gray-400 px-3 py-1 rounded">Cancelar</button>
                    <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded">Salvar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Editar posto -->
    <div id="editModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
        <div class="bg-white p-6 rounded-lg w-96">
            <h2 class="text-xl mb-4">Editar Posto</h2>
            <form id="editPostForm">
                <input type="hidden" name="id" id="editPostId">
                <input type="text" name="name" id="editPostName" placeholder="Nome do Posto"
                    class="w-full p-2 border rounded mb-2" required>
                <input type="text" name="address" id="editPostAddress" placeholder="Rua"
                    class="w-full p-2 border rounded mb-2" required>
                <input type="text" name="city" id="editPostCity" placeholder="Cidade"
                    class="w-full p-2 border rounded mb-2" required>
                <select name="state" class="w-full border p-2 rounded-md mb-3">
                    <option value="" selected disabled class="">Selecione um estado</option>
                    <option value="AC">AC - Acre</option>
                    <option value="AL">AL - Alagoas</option>
                    <option value="AP">AP - Amapá</option>
                    <option value="AM">AM - Amazonas</option>
                    <option value="BA">BA - Bahia</option>
                    <option value="CE">CE - Ceará</option>
                    <option value="DF">DF - Distrito Federal</option>
                    <option value="ES">ES - Espírito Santo</option>
                    <option value="GO">GO - Goiás</option>
                    <option value="MA">MA - Maranhão</option>
                    <option value="MT">MT - Mato Grosso</option>
                    <option value="MS">MS - Mato Grosso do Sul</option>
                    <option value="MG">MG - Minas Gerais</option>
                    <option value="PA">PA - Pará</option>
                    <option value="PB">PB - Paraíba</option>
                    <option value="PR">PR - Paraná</option>
                    <option value="PE">PE - Pernambuco</option>
                    <option value="PI">PI - Piauí</option>
                    <option value="RJ">RJ - Rio de Janeiro</option>
                    <option value="RN">RN - Rio Grande do Norte</option>
                    <option value="RS">RS - Rio Grande do Sul</option>
                    <option value="RO">RO - Rondônia</option>
                    <option value="RR">RR - Roraima</option>
                    <option value="SC">SC - Santa Catarina</option>
                    <option value="SP">SP - São Paulo</option>
                    <option value="SE">SE - Sergipe</option>
                    <option value="TO">TO - Tocantins</option>
                </select>
                <div class="flex justify-end gap-2">
                <button type="button" id="closeModalPostEdit" class="bg-gray-400 px-3 py-1 rounded">Cancelar</button>
                    <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded">Salvar</button>
                </div>
            </form>
        </div>
    </div>

    <div id="editModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
        <div class="bg-white p-6 rounded-lg w-96">
            <h2 class="text-xl mb-4">Editar Posto</h2>
            <form id="editPostForm">
                <input type="hidden" name="id" id="editPostId">
                <input type="text" name="name" id="editPostName" placeholder="Nome do Posto"
                    class="w-full p-2 border rounded mb-2" required>
                <input type="text" name="address" id="editPostAddress" placeholder="Rua"
                    class="w-full p-2 border rounded mb-2" required>
                <input type="text" name="city" id="editPostCity" placeholder="Cidade"
                    class="w-full p-2 border rounded mb-2" required>
                <input type="text" name="state" id="editPostState" placeholder="Estado"
                    class="w-full p-2 border rounded mb-2" required>
                <div class="flex justify-end gap-2">
                    <button type="button" id="closeEditModal" class="bg-gray-400 px-3 py-1 rounded">Cancelar</button>
                    <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded">Salvar</button>
                </div>
            </form>
        </div>
    </div>


    <section class="w-[90vw] flex justify-center">
        <div class="w-[70%] flex flex-col gap-[5vh] mt-[5vh] mx-[5vw]">
            <div class="flex justify-between">
                <h1 class="text-xl md:text-3xl">Painel de postos</h1>
                <div class="flex gap-6">
                    <button id="openModalPost"
                        class="bg-blue-500 text-white px-4 py-2 text-xs md:text-sm rounded-md hover:bg-blue-600">
                        Cadastrar novo posto
                    </button>
                </div>
            </div>

            <table class="min-w-full max-w-[100vw] bg-white border border-gray-200 shadow-md text-nowrap">
                <thead>
                    <tr class="bg-[#EEEEEE] text-left text-xs md:text-sm text-[#B5B7C0]">
                        <th class="font-light border-b py-2 px-6">Nome do Posto</th>
                        <th class="font-light p-2 border-b w-1/4">Rua</th>
                        <th class="font-light p-2 border-b w-1/4">Cidade</th>
                        <th class="font-light p-2">Estado</th>
                        <th class="font-light p-2">Ações</th>
                        <th class="font-light p-2">Status</th> <!-- A célula de Status deve ficar no final da linha -->
                    </tr>
                </thead>
                <tbody>

                    <?php if (empty($posts)): ?>
                    <tr>
                        <td colspan="6" class="px-4 py-3 text-center text-gray-400">Nenhum posto cadastrado!</td>
                    </tr>
                    <?php endif; ?>
                    <?php foreach ($posts as $post): ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-3 border-b text-xs md:text-sm text-gray-800"><?= $post['name'] ?></td>
                        <td class="px-2 py-3 border-b text-xs md:text-sm text-gray-800"><?= $post['address'] ?></td>
                        <td class="px-2 py-3 border-b text-xs md:text-sm text-gray-800"><?= $post['city'] ?></td>
                        <td class="px-2 py-3 border-b text-xs md:text-sm text-gray-800"><?= $post['state'] ?></td>
                        <td class="pl-2 pr-4 py-3 border-b text-xs md:text-xs flex gap-2 flex-col md:flex-row">
                            <a href="../stocks/read-stock.php?id=<?= $post['id']; ?>"
                                class="border-green-500 border-2 text-green-500 px-3 py-1 md:text-sm rounded-md transition all hover:bg-green-500 hover:text-white flex gap-2 items-center">Gerenciar
                                estoque <i class="fa-solid fa-suitcase-medical"></i></a>

                            <button
                                class="h-full border-blue-500 border-2 text-blue-500 px-3 py-1 md:text-sm rounded-md transition all hover:bg-blue-500 hover:text-white flex gap-2 items-center"
                                onclick="openEditModal(<?= $post['id']; ?>)">Editar <i
                                    class="fa-solid fa-pencil"></i></button>
                            <?php if ($post['status'] === 'ativo'): ?>
                            <a href="./disable-post.php?id=<?= $post['id']; ?>"
                                class="h-full border-red-500 border-2 text-red-500 px-3 py-1 md:text-sm rounded-md transition all hover:bg-red-500 hover:text-white flex gap-2 items-center"
                                onclick="return confirm('Tem certeza que deseja desativar este posto?');">
                                Desativar posto <i class="fa-solid fa-power-off"></i>
                            </a>
                            <?php elseif ($post['status'] === 'inativo'): ?>
                            <a href="./active-post.php?id=<?= $post['id']; ?>"
                                class="h-full border-green-500 border-2 text-green-500 px-3 py-1 md:text-sm rounded-md transition all hover:bg-green-500 hover:text-white flex gap-2 items-center"
                                onclick="return confirm('Tem certeza que deseja ativar este posto?');">
                                Ativar posto <i class="fa-solid fa-power-off"></i>
                            </a>
                            <?php endif; ?>



                        </td>

                        <td class="p-2 py-3 border-b text-xs md:text-xs text-center uppercase">
                            <?= $post['status'] ?>
                        </td>

                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>


        </div>
    </section>


    <script src="../assets/js/index.js"></script>
    <script>
    let icon = document.getElementById('icon-arrow');
    let btn = document.getElementById('btn');

    function toggleMenu() {
        const menu = document.getElementById('mobileMenu');
        menu.classList.toggle('hidden');

        if (icon.classList.contains("fa-xmark")) {
            icon.classList.remove("fa-xmark");
            icon.classList.add("fa-bars");
            btn.classList.add("left-[20px]");
        } else {
            icon.classList.remove("fa-bars");
            icon.classList.add("fa-xmark");
            btn.classList.remove("left-[20px]");
        }
    }
    </script>
</body>

</html>