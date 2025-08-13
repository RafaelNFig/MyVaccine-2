// statusPost.js

const confirmModal = document.getElementById('confirmModal');
const confirmYesBtn = document.getElementById('confirmYesBtn');
const confirmNoBtn = document.getElementById('confirmNoBtn');

let currentPostId = null;
let currentButton = null;

function confirmToggleStatus(postId, button) {
  currentPostId = postId;
  currentButton = button;
  confirmModal.classList.remove('hidden');
}

confirmNoBtn.addEventListener('click', () => {
  confirmModal.classList.add('hidden');
  currentPostId = null;
  currentButton = null;
});

confirmYesBtn.addEventListener('click', () => {
  confirmModal.classList.add('hidden');
  if (currentPostId && currentButton) {
    toggleStatus(currentPostId, currentButton);
  }
  currentPostId = null;
  currentButton = null;
});

function toggleStatus(postId, button) {
  const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

  fetch(`/admin/postos/${postId}/toggle-status`, {
  method: 'PATCH',
  headers: {
    'Content-Type': 'application/json',
    'X-CSRF-TOKEN': token,
    'Accept': 'application/json',
  },
})
  .then(res => {
    if (!res.ok) throw new Error('Erro ao alterar status');
    return res.json();
  })
  .then(data => {
    const tr = button.closest('tr');
    if (!tr) return;

    const statusTd = tr.querySelector('td:last-child');
    statusTd.textContent = data.post.status;

    if (data.post.status === 'ativo') {
      button.classList.remove('border-green-500', 'text-green-500', 'hover:bg-green-500');
      button.classList.add('border-red-500', 'text-red-500', 'hover:bg-red-500');
      button.innerHTML = 'Desativar posto <i class="fa-solid fa-power-off"></i>';
    } else {
      button.classList.remove('border-red-500', 'text-red-500', 'hover:bg-red-500');
      button.classList.add('border-green-500', 'text-green-500', 'hover:bg-green-500');
      button.innerHTML = 'Ativar posto <i class="fa-solid fa-power-off"></i>';
    }

    showNotification(data.message || 'Status alterado com sucesso');
  })
  .catch(() => {
    showNotification('Erro ao alterar status', true);
  });
}

function showNotification(message, error = false) {
  const notification = document.getElementById('notification');
  notification.textContent = message;
  notification.classList.remove('opacity-0', 'pointer-events-none', 'bg-green-500', 'bg-red-500');
  notification.classList.add(error ? 'bg-red-500' : 'bg-green-500');
  notification.classList.add('opacity-100');
  notification.classList.remove('pointer-events-none');

  setTimeout(() => {
    notification.classList.add('opacity-0');
    notification.classList.add('pointer-events-none');
  }, 3000);
}
