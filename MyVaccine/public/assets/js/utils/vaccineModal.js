document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('vaccineModal');
    const closeModalBtn = document.getElementById('closeModalBtn');
    const modalUserName = document.getElementById('modalUserName');
    const modalUserCpf = document.getElementById('modalUserCpf');
    const postSelect = document.getElementById('post_id');
    const vaccineSelect = document.getElementById('vaccine_id');
    const applyForm = document.getElementById('applyVaccineForm');

    // Fecha modal
    closeModalBtn.addEventListener('click', () => {
        closeModal();
    });

    // Fecha modal se clicar fora do conteúdo
    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            closeModal();
        }
    });

    // Abre o modal e seta os dados do usuário
    window.openVaccineModal = function(button) {
        const userCpf = button.getAttribute('data-user-cpf');
        const userName = button.getAttribute('data-user-name');

        modalUserName.textContent = userName;
        modalUserCpf.value = userCpf;

        // Reset selects
        postSelect.value = '';
        vaccineSelect.innerHTML = '<option value="" disabled selected>Selecione um posto primeiro</option>';
        vaccineSelect.disabled = true;

        modal.classList.remove('hidden');
        modal.classList.add('flex');
    };

    // Quando muda o posto, carregar vacinas disponíveis via AJAX
    postSelect.addEventListener('change', () => {
        const postId = postSelect.value;
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        if (!postId) {
            vaccineSelect.innerHTML = '<option value="" disabled selected>Selecione um posto primeiro</option>';
            vaccineSelect.disabled = true;
            return;
        }

        vaccineSelect.innerHTML = '<option>Carregando vacinas...</option>';
        vaccineSelect.disabled = true;

        fetch(`/admin/posts/${postId}/vaccines`, {
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            }
        })
        .then(response => {
            if (!response.ok) throw new Error('Erro na requisição');
            return response.json();
        })
        .then(data => {
            vaccineSelect.innerHTML = '';
            if (data.length === 0) {
                vaccineSelect.innerHTML = '<option value="" disabled selected>Nenhuma vacina disponível neste posto</option>';
                vaccineSelect.disabled = true;
            } else {
                vaccineSelect.disabled = false;
                vaccineSelect.innerHTML = '<option value="" disabled selected>Selecione a vacina</option>';
                data.forEach(vaccine => {
                    const option = document.createElement('option');
                    option.value = vaccine.id;
                    option.textContent = vaccine.name;
                    vaccineSelect.appendChild(option);
                });
            }
        })
        .catch(() => {
            vaccineSelect.innerHTML = '<option value="" disabled selected>Erro ao carregar vacinas</option>';
            vaccineSelect.disabled = true;
        });
    });

    // Submissão do formulário via AJAX para salvar aplicação
    applyForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const formData = new FormData(applyForm);
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch(applyForm.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            }
        })
        .then(response => {
            if (!response.ok) throw new Error('Erro ao aplicar vacina');
            return response.json();
        })
        .then(data => {
            alert('Vacina aplicada com sucesso!');
            closeModal();

            // Opcional: recarregar a página para atualizar o histórico
            window.location.reload();
        })
        .catch(err => {
            alert('Erro: ' + err.message);
        });
    });

    function closeModal() {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
});
