// Evita múltiplas execuções se o arquivo for incluído mais de uma vez
if (!window.editPostModuleInitialized) {
    window.editPostModuleInitialized = true;
  
    const editModal = document.getElementById('editModal');
    const editForm = document.getElementById('editPostForm');
    const closeModalBtn = document.getElementById('closeModalPostEdit');
  
    // Função para mostrar notificação (toast)
    function showNotification(message, type = 'success') {
      const notification = document.getElementById('notification');
      notification.textContent = message;
  
      if (type === 'success') {
        notification.classList.remove('bg-red-500');
        notification.classList.add('bg-green-500');
      } else if (type === 'error') {
        notification.classList.remove('bg-green-500');
        notification.classList.add('bg-red-500');
      }
  
      notification.classList.remove('opacity-0', 'pointer-events-none');
      notification.classList.add('opacity-100');
  
      setTimeout(() => {
        notification.classList.add('opacity-0');
        notification.classList.remove('opacity-100');
        notification.classList.add('pointer-events-none');
      }, 3000);
    }
  
    // Função para abrir modal e carregar dados do posto
    async function openEditModal(postId) {
      try {
        const response = await fetch(`/postos/${postId}/edit`, {
          headers: { 'Accept': 'application/json' },
        });
        if (!response.ok) throw new Error('Erro na requisição');
  
        const data = await response.json();
        if (data.success) {
          const post = data.post;
  
          // Preenche campos do formulário
          editForm.action = `/postos/${post.id}`;
          editForm.querySelector('#editPostId').value = post.id;
          editForm.querySelector('#editPostName').value = post.name;
          editForm.querySelector('#editPostAddress').value = post.address;
          editForm.querySelector('#editPostCity').value = post.city;
          editForm.querySelector('#editPostState').value = post.state;
  
          editModal.classList.remove('hidden');
        } else {
          alert('Erro ao carregar dados do posto.');
        }
      } catch {
        alert('Erro ao carregar dados do posto.');
      }
    }
  
    // Fecha modal
    closeModalBtn.addEventListener('click', () => {
      editModal.classList.add('hidden');
    });
  
    // Fecha modal clicando fora da caixa
    editModal.addEventListener('click', e => {
      if (e.target === editModal) {
        editModal.classList.add('hidden');
      }
    });
  
    // Envio do formulário via fetch (PUT)
    editForm.addEventListener('submit', async (e) => {
      e.preventDefault();
  
      const formData = new FormData(editForm);
  
      try {
        const response = await fetch(editForm.action, {
          method: 'POST',
          headers: {
            'X-CSRF-TOKEN': editForm.querySelector('input[name="_token"]').value,
            'X-HTTP-Method-Override': 'PUT',
            'Accept': 'application/json',
          },
          body: formData,
        });
  
        if (!response.ok) throw response;
  
        const data = await response.json();
  
        if (data.success) {
          const post = data.post;
  
          // Atualiza linha na tabela
          const row = document.querySelector(`tbody tr[data-id="${post.id}"]`);
          if (row) {
            row.querySelector('td:nth-child(1)').textContent = post.name;
            row.querySelector('td:nth-child(2)').textContent = post.address;
            row.querySelector('td:nth-child(3)').textContent = post.city;
            row.querySelector('td:nth-child(4)').textContent = post.state;
            row.querySelector('td:nth-child(6)').textContent = post.status.toUpperCase();
          }
  
          showNotification(data.message, 'success'); // pop-up de notificação
          editModal.classList.add('hidden');
        }
      } catch (error) {
        let errorMsg = 'Erro ao atualizar posto.';
        if (error.json) {
          const errJson = await error.json();
          if (errJson.errors) {
            errorMsg = Object.values(errJson.errors).flat().join('\n');
          }
        }
        alert(errorMsg);
      }
    });
  
    // Adiciona event listeners a todos os botões "Editar"
    function bindEditButtons() {
      const buttons = document.querySelectorAll('.btn-edit');
      buttons.forEach(button => {
        button.addEventListener('click', () => {
          const postId = button.getAttribute('data-id');
          openEditModal(postId);
        });
      });
    }
  
    // Executa ao carregar o script
    bindEditButtons();
  
    // Expõe a função globalmente (opcional)
    window.openEditModal = openEditModal;
  }
  