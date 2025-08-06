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
    <title>Aplicação de vacinas</title>
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
                    <i class="fa-solid fa-house-medical text-[20px] text-gray-400 hover:text-black transition all"></i>
                </a>
                <!-- Pacientes -->
                <a href="../patients/index.php">
                    <i class="fa-solid fa-bed text-[20px] text-black"></i>
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
    <main class="flex justify-center items-center w-screen">
        <div class="bg-white p-8 rounded shadow-md w-96">
            <h2 class="text-xl font-bold mb-4">Aplicar Vacina</h2>
            <?php if (isset($error_message)) echo "<p class='text-red-500 pb-4'>$error_message</p>"; ?>
            <?php if (isset($success_message)) echo "<p class='text-green-500  pb-4'>$success_message</p>"; ?>

            <form method="POST" action="./vaccine-application.php">
                <label class="block mb-2">CPF do Paciente:</label>
                <input type="text" name="cpf" required pattern="\d{3}\.?\d{3}\.?\d{3}-?\d{2}"
                    placeholder="Ex: 123.456.789.10" class="w-full border p-2 rounded mb-4">

                <label class="block mb-2">Posto de Vacinação:</label>
                <select name="post_id" required class="w-full border p-2 rounded mb-4">
                    <?php foreach ($posts as $post) { ?>
                    <option value="<?= $post['id'] ?>"><?= $post['name'] ?></option>
                    <?php } ?>
                </select>

                <label class="block mb-2">Vacina:</label>
                <select name="vaccine_id" required class="w-full border p-2 rounded mb-4">
                    <?php foreach ($vacinas as $vacina) { ?>
                    <option value="<?= $vacina['id'] ?>"><?= $vacina['name'] ?></option>
                    <?php } ?>
                </select>

                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded w-full hover:bg-blue-600">Aplicar
                    Vacina</button>
            </form>
        </div>
    </main>
</body>

</html>