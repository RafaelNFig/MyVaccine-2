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
    const modalEdit = document.getElementById("modalEditVaccine");
    const closeEditBtn = document.getElementById("closeEditModal");
    const cancelEditBtn = document.getElementById("cancelEditBtn");
    const formEdit = document.getElementById("formEditVaccine");

    // Função para abrir modal de edição e preencher dados
    function openEditModal(vaccine) {
        document.getElementById("edit_vaccine_id").value = vaccine.id;
        document.getElementById("edit_name").value = vaccine.name;
        document.getElementById("edit_min_age").value = vaccine.min_age;
        document.getElementById("edit_max_age").value = vaccine.max_age || "";
        document.getElementById("edit_contraindications").value = vaccine.contraindications || "";
        modalEdit.classList.remove("hidden");
    }

    // Anexa evento de abrir modal para todos os botões editar existentes
    function attachEditListeners() {
        document.querySelectorAll(".edit-btn").forEach(button => {
            button.onclick = () => {
                const row = button.closest("tr");
                const vaccine = {
                    id: button.dataset.id,
                    name: row.querySelector(".col-name").textContent,
                    min_age: row.querySelector(".col-min-age").textContent,
                    max_age: row.querySelector(".col-max-age").textContent === "-" ? "" : row.querySelector(".col-max-age").textContent,
                    contraindications: row.querySelector(".col-contra").textContent === "-" ? "" : row.querySelector(".col-contra").textContent
                };
                openEditModal(vaccine);
            };
        });
    }

    // Fecha modal de edição
    closeEditBtn.addEventListener("click", () => modalEdit.classList.add("hidden"));
    cancelEditBtn.addEventListener("click", () => modalEdit.classList.add("hidden"));

    // Submete formulário de edição via AJAX
    formEdit.addEventListener("submit", function (e) {
        e.preventDefault();

        const id = document.getElementById("edit_vaccine_id").value;
        const formData = new FormData(formEdit);
        formData.append("_method", "PATCH"); // Laravel espera PATCH para update

        fetch(`/vaccines/${id}`, {
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
                const vaccine = data.vaccine;
                const row = document.getElementById(`vaccine-row-${vaccine.id}`);
                if (row) {
                    row.querySelector(".col-name").textContent = vaccine.name;
                    row.querySelector(".col-min-age").textContent = vaccine.min_age;
                    row.querySelector(".col-max-age").textContent = vaccine.max_age ?? "-";
                    row.querySelector(".col-contra").textContent = vaccine.contraindications ?? "-";
                }
                modalEdit.classList.add("hidden");
                showNotification(data.message || "Vacina atualizada com sucesso!");
                attachEditListeners(); // Reativa os listeners para atualizar o modal no futuro
            } else {
                showNotification("Erro ao atualizar vacina.");
            }
        })
        .catch(err => {
            console.error(err);
            showNotification("Erro na requisição ao atualizar vacina.");
        });
    });

    // Chama o attach na carga inicial para ativar os botões existentes
    attachEditListeners();
});
