<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../assets/style/style.css" />
    <script src="https://kit.fontawesome.com/c8e307d42e.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="./assets/img/icon.png">
    <title>Gerenciamento de vacinas</title>
</head>

<body class="bg-gray-100 h-screen flex">

    <nav class="flex flex-col justify-between p-5 items-center border-r-2">
        <div class="flex flex-col items-center gap-4">
            <a href="../posts/read-post.php"><img src="../assets/img/logo-mobile.png" class="w-[36px]"
                    alt="logo my-vaccine"></a>

            <!-- barrinha -->
            <span class="h-[1px] w-full bg-gray-300 rounded-full"></span>

            <div class="grid grid-cols-1 gap-[32px] justify-items-center">
                <span class="uppercase text-xs text-gray-300 font-semibold">main</span>
                <!-- Postos de saude -->
                <a href="../posts/read-post.php">
                    <i class="fa-solid fa-house-medical text-[20px] text-gray-400 hover:text-black"></i>
                </a>
                <!-- Pacientes -->
                <a href="../patients/vaccine-application.php">
                    <i class="fa-solid fa-bed text-[20px] text-gray-400 hover:text-black transition all"></i>
                </a>
                <!-- Vacinas -->
                <a href="../vaccines/read-vaccine.php">
                    <i class="fa-solid fa-syringe text-[20px] text-black"></i>
                </a>
            </div>





        </div>

        <a href="../admin/logout-admin.php">
            <i
                class="fa-solid fa-arrow-right-from-bracket text-[20px] text-red-400 hover:text-red-600 transition all"></i>
        </a>

    </nav>
    <section class="w-[90vw] flex justify-center">
        <div class="w-[70%] flex flex-col gap-[5vh] mt-[5vh] mx-[5vw]">
            <div class="flex justify-between">
                <h1 class="text-xl md:text-3xl">Painel de vacinas</h1>
                <button id="openModal"
                    class="bg-blue-500 text-white px-4 py-2 text-xs md:text-sm rounded-md hover:bg-blue-600">
                    Cadastrar nova vacina
                </button>
            </div>

            <table class="min-w-full max-w-[100vw] bg-white border border-gray-200 shadow-md text-nowrap">
                <thead>
                    <tr class="bg-[#EEEEEE] text-left text-xs md:text-sm text-[#B5B7C0]">
                        <th class="font-light px-6 py-2 border-b">Nome</th>
                        <th class="font-light px-6 py-2 border-b">Faixa etária</th>
                        <th class="font-light px-6 py-2 border-b w-full">Contraindicações</th>
                        <th class="font-light px-6 py-2 border-b">Data de cadastro</th>
                        <th class="font-light px-6 py-2 border-b">Ações</th>

                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($vaccines)): ?>
                    <tr>
                        <td colspan="7" class="px-4 py-4 text-center text-gray-400">Nenhuma vacina cadastrada!</td>
                    </tr>
                    <?php endif; ?>

                    <?php foreach ($vaccines as $vaccine): ?>
                    <tr class="hover:bg-gray-50 h-full">

                        <td class="py-2  px-6 border-b text-xs md:text-sm text-gray-800"><?= $vaccine['name'] ?></td>
                        <td class="px-6 border-b py-2 text-xs md:text-sm text-gray-800"><?= $vaccine['min_age'] ?>
                            - <?= $vaccine['max_age'] ?> anos</td>
                        <td class="px-6 border-b py-2 text-xs md:text-sm text-gray-800 w-full text-wrap">
                            <?= $vaccine['contraindications'] ?> </td>
                        <td class="px-2 py-2 border-b text-xs md:text-sm text-gray-800">
                            <?php 
                                $lastUpdated = new DateTime($vaccine['date_up']);
                                echo $lastUpdated->format('d/m/Y - H:i:s');
                            ?>
                        </td>

                        <td class="px-2 py-2 border-b text-xs md:text-xs">
                                <a href="../vaccines/delete-vaccine.php?id=<?= $vaccine['id']; ?>"
                                    onclick="return confirm('Tem certeza que deseja excluir esta vacina?');"
                                    class="h-full border-red-500 border-2 text-red-500 px-3 py-1 md:text-sm rounded-md transition all hover:bg-red-500 hover:text-white flex gap-2 items-center">
                                    Excluir <i class="fa-solid fa-trash"></i>
                                </a>
                        </td>

                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>

    <!-- Modal -->
    <div id="modal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center">
        <div class="bg-white p-6 rounded-lg w-[90%] md:w-[50%] shadow-lg">
            <h2 class="text-lg font-semibold mb-4">Cadastrar Nova Vacina</h2>

            <!-- Formulário -->
            <form id="vaccineForm">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Nome:</label>
                    <input type="text" name="name" required class="w-full p-2 border rounded" />
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Idade mínima:</label>
                        <input type="number" name="min_age" required class="w-full p-2 border rounded" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Idade máxima:</label>
                        <input type="number" name="max_age" class="w-full p-2 border rounded" />
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Contraindicações:</label>
                    <textarea name="contraindications" class="w-full p-2 border rounded"></textarea>
                </div>

                <div class="flex justify-end gap-2">
                    <button type="button" id="closeModal" class="px-4 py-2 bg-gray-500 text-white rounded">
                        Cancelar
                    </button>
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">
                        Cadastrar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="../assets/js/vaccines.js"></script>
</body>

</html>