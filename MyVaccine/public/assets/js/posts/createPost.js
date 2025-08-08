// Modal cadastro de posto
const openModalBtn = document.getElementById('openModalPost');
const closeModalBtn = document.getElementById('closeModalPost');
const modal = document.getElementById('modal');

// Abrir modal
openModalBtn?.addEventListener('click', () => {
    modal.classList.remove('hidden');
});

// Fechar modal
closeModalBtn?.addEventListener('click', () => {
    modal.classList.add('hidden');
});

// Fecha modal clicando fora
modal?.addEventListener('click', (e) => {
    if (e.target === modal) {
        modal.classList.add('hidden');
    }
});

// Função para mostrar notificação (toast)
function showNotification(message, type = 'success') {
    const notification = document.getElementById('notification');
    notification.textContent = message;

    // Remove classes antigas
    notification.classList.remove('bg-green-500', 'bg-red-500', 'opacity-0', 'pointer-events-none');
    notification.classList.add('opacity-100');

    // Define cor com base no tipo
    if (type === 'success') {
        notification.classList.add('bg-green-500');
    } else if (type === 'error') {
        notification.classList.add('bg-red-500');
    } else {
        // fallback, pode usar azul ou cinza
        notification.classList.add('bg-gray-500');
    }

    // Mostra notificação
    notification.style.pointerEvents = 'auto';

    // Remove após 3 segundos
    setTimeout(() => {
        notification.classList.remove('opacity-100');
        notification.classList.add('opacity-0');
        notification.style.pointerEvents = 'none';
    }, 3000);
}

// Submit AJAX para criar posto e atualizar tabela
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('createPostForm');
    const modal = document.getElementById('modal');
    const tbody = document.querySelector('table tbody');
    const closeModalBtn = document.getElementById('closeModalPost');

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(form);

        fetch(form.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value,
                'Accept': 'application/json',
            },
            body: formData
        })
        .then(response => {
            if (!response.ok) throw response;
            return response.json();
        })
        .then(data => {
            if(data.success){
                const post = data.post;
                const tr = document.createElement('tr');
                tr.classList.add('hover:bg-gray-50');
                tr.setAttribute('data-id', post.id);
                tr.innerHTML = `
                    <td class="px-6 py-3 border-b text-xs md:text-sm text-gray-800">${post.name}</td>
                    <td class="px-2 py-3 border-b text-xs md:text-sm text-gray-800">${post.address}</td>
                    <td class="px-2 py-3 border-b text-xs md:text-sm text-gray-800">${post.city}</td>
                    <td class="px-2 py-3 border-b text-xs md:text-sm text-gray-800">${post.state}</td>
                    <td class="pl-2 pr-4 py-3 border-b text-xs md:text-xs flex gap-2 flex-col md:flex-row">
                        <a href="/stock/${post.id}" class="border-green-500 border-2 text-green-500 px-3 py-1 md:text-sm rounded-md transition all hover:bg-green-500 hover:text-white flex gap-2 items-center">
                            Gerenciar estoque <i class="fa-solid fa-suitcase-medical"></i>
                        </a>
                        <button
                            onclick="if(window.openEditModal){ window.openEditModal(${post.id}); } else { window.location.href = '/postos/${post.id}/edit'; }"
                            class="h-full border-blue-500 border-2 text-blue-500 px-3 py-1 md:text-sm rounded-md transition all hover:bg-blue-500 hover:text-white flex gap-2 items-center"
                        >
                            Editar <i class="fa-solid fa-pencil"></i>
                        </button>
                        <form action="/postos/${post.id}/disable" method="POST" onsubmit="return confirm('Tem certeza que deseja desativar este posto?');" class="inline">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="_method" value="PATCH">
                            <button class="h-full border-red-500 border-2 text-red-500 px-3 py-1 md:text-sm rounded-md transition all hover:bg-red-500 hover:text-white flex gap-2 items-center" type="submit">
                                Desativar posto <i class="fa-solid fa-power-off"></i>
                            </button>
                        </form>
                    </td>
                    <td class="p-2 py-3 border-b text-xs md:text-xs text-center uppercase">
                        ${post.status}
                    </td>
                `;

                // Remove linha "Nenhum posto cadastrado!" se existir
                const emptyRow = tbody.querySelector('tr td[colspan="6"]');
                if (emptyRow) emptyRow.parentElement.remove();

                tbody.appendChild(tr);

                modal.classList.add('hidden');
                form.reset();

                // Aqui chamamos a notificação de sucesso
                showNotification(data.message, 'success');
            }
        })
        .catch(async (error) => {
            let errorMsg = 'Erro ao criar posto.';
            if (error.json) {
                const errJson = await error.json();
                if (errJson.errors) {
                    errorMsg = Object.values(errJson.errors).flat().join('\n');
                }
            }
            alert(errorMsg);
        });
    });

    closeModalBtn.addEventListener('click', () => {
        modal.classList.add('hidden');
    });
});
