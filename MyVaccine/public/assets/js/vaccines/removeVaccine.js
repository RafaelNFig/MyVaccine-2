document.addEventListener("DOMContentLoaded", () => {
    const modal = document.getElementById("confirmModal");
    const btnConfirmYes = document.getElementById("confirmYesBtn");
    const btnConfirmNo = document.getElementById("confirmNoBtn");
  
    let vaccineIdToDelete = null;
  
    document.querySelectorAll(".remove-btn").forEach(button => {
      button.addEventListener("click", () => {
        vaccineIdToDelete = button.dataset.id;
        modal.classList.remove("hidden");
      });
    });
  
    btnConfirmNo.addEventListener("click", () => {
      vaccineIdToDelete = null;
      modal.classList.add("hidden");
    });
  
    btnConfirmYes.addEventListener("click", () => {
      if (!vaccineIdToDelete) return;
  
      const token = document.querySelector('meta[name="csrf-token"]').content;
  
      fetch(`/vaccines/${vaccineIdToDelete}`, {
        method: "POST",
        headers: {
          "X-CSRF-TOKEN": token,
          "Accept": "application/json",
          "Content-Type": "application/x-www-form-urlencoded"
        },
        body: new URLSearchParams({
          _method: "DELETE"
        })
      })
        .then(res => {
          if (!res.ok) return res.json().then(err => Promise.reject(err));
          return res.json();
        })
        .then(data => {
          if (data.success) {
            const row = document.querySelector(`[data-id="${vaccineIdToDelete}"]`);
            if (row) row.remove();
            showNotification(data.message || "Vacina excluída com sucesso!", "success");
          } else {
            showNotification(data.message || "Erro ao excluir vacina.", "error");
          }
        })
        .catch(err => {
          console.error(err);
          showNotification("Erro ao excluir vacina.", "error");
        })
        .finally(() => {
          vaccineIdToDelete = null;
          modal.classList.add("hidden");
        });
    });
  });
  