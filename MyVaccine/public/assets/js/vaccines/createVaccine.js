function showNotification(message, duration = 3000) {
    const notification = document.getElementById('notification');
    if (!notification) return;

    notification.textContent = message;
    notification.classList.remove('opacity-0', 'pointer-events-none');
    notification.classList.add('opacity-100');

    setTimeout(() => {
        notification.classList.add('opacity-0', 'pointer-events-none');
        notification.classList.remove('opacity-100');
    }, duration);
}

document.addEventListener("DOMContentLoaded", function () {
    const modalCreate = document.getElementById("modalCreateVaccine");
    const openCreateBtn = document.getElementById("openCreateModal");
    const closeCreateBtn = document.getElementById("closeCreateModal");
    const cancelCreateBtn = document.getElementById("cancelCreateBtn");
    const formCreate = document.getElementById("formCreateVaccine");
    const tableBody = document.querySelector("tbody");

    // Abrir modal de criação
    openCreateBtn.addEventListener("click", () => {
        modalCreate.classList.remove("hidden");
        formCreate.reset();
    });

    // Fechar modal de criação
    closeCreateBtn.addEventListener("click", () => modalCreate.classList.add("hidden"));
    cancelCreateBtn.addEventListener("click", () => modalCreate.classList.add("hidden"));

    // Envio do formulário de criação via AJAX
    formCreate.addEventListener("submit", function (e) {
        e.preventDefault();

        const formData = new FormData(formCreate);

        fetch(formCreate.action, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                "Accept": "application/json"
            },
            body: formData
        })
        .then(res => {
            if (!res.ok) return res.json().then(err => Promise.reject(err));
            return res.json();
        })
        .then(data => {
            if (data.success) {
                // Remove linha "Nenhuma vacina cadastrada", se existir
                const noVacRow = document.getElementById("noVaccinesRow");
                if (noVacRow) noVacRow.remove();

                const vaccine = data.vaccine;
                // Cria nova linha da vacina na tabela
                const newRow = document.createElement("tr");
                newRow.id = `vaccine-row-${vaccine.id}`;
                newRow.className = "border-b border-gray-200 hover:bg-gray-50";
                newRow.innerHTML = `
                    <td class="py-3 px-4 col-name">${vaccine.name}</td>
                    <td class="py-3 px-4 col-min-age">${vaccine.min_age}</td>
                    <td class="py-3 px-4 col-max-age">${vaccine.max_age ?? "-"}</td>
                    <td class="py-3 px-4 col-contra">${vaccine.contraindications ?? "-"}</td>
                    <td class="py-3 px-4 flex gap-2">
                        <button 
                            data-id="${vaccine.id}" 
                            class="edit-btn h-full border-blue-500 border-2 text-blue-500 px-3 py-1 md:text-sm rounded-md transition all hover:bg-blue-500 hover:text-white flex gap-2 items-center">
                            Editar
                        </button>
                        <button 
                            data-id="${vaccine.id}" 
                            class="remove-btn h-full border-red-500 border-2 text-red-500 px-3 py-1 md:text-sm rounded-md transition all hover:bg-red-500 hover:text-white flex gap-2 items-center">
                            Excluir
                        </button>
                    </td>
                `;
                tableBody.appendChild(newRow);

                // Fecha modal e reseta formulário
                modalCreate.classList.add("hidden");
                formCreate.reset();

                // Exibe notificação de sucesso
                showNotification(data.message || "Vacina cadastrada com sucesso!");

                // (Opcional) Atualizar listeners dos botões edit e remove para a nova linha
                // Se quiser posso ajudar a implementar
            } else {
                showNotification("Erro ao cadastrar vacina.");
            }
        })
        .catch(err => {
            console.error(err);
            showNotification("Erro na requisição ao cadastrar vacina.");
        });
    });
});
