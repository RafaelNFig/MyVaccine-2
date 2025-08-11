document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById("stockModal");
    const stockTableBody = modal.querySelector("#stockContent");
    const closeModalBtn = document.getElementById("closeModalBtn");
    const buttons = document.querySelectorAll(".btn-show-stocks");
  
    closeModalBtn.addEventListener("click", () => {
      modal.classList.add("hidden");
      stockTableBody.innerHTML = ""; // limpa ao fechar
    });
  
    modal.addEventListener("click", (e) => {
      if (e.target === modal) {
        modal.classList.add("hidden");
        stockTableBody.innerHTML = "";
      }
    });
  
    buttons.forEach((button) => {
      button.addEventListener("click", async (e) => {
        e.preventDefault();
  
        const postId = button.dataset.postId;
        if (!postId) return alert("ID do posto não encontrado.");
  
        stockTableBody.innerHTML = `<p class="text-center py-4">Carregando...</p>`;
        modal.classList.remove("hidden");
  
        try {
          // Ajuste importante: rota sem /api, porque está em web.php
          const response = await fetch(`/posts/${postId}/stocks`);
          if (!response.ok) throw new Error("Erro ao carregar estoque.");
  
          const stocks = await response.json();
  
          if (stocks.length === 0) {
            stockTableBody.innerHTML = `<p class="text-center py-4">Sem vacinas em estoque.</p>`;
            return;
          }
  
          let html = `
            <table class="w-full text-left border-collapse">
              <thead>
                <tr class="bg-[#100E3D] text-white">
                  <th class="p-2">Vacina</th>
                  <th class="p-2 text-right">Quantidade</th>
                  <th class="p-2 text-right">Validade</th>
                </tr>
              </thead>
              <tbody>
          `;
  
          stocks.forEach(stock => {
            html += `
              <tr class="border-b">
                <td class="p-2">${stock.vaccine_name}</td>
                <td class="p-2 text-right">${stock.quantity}</td>
                <td class="p-2 text-right">${new Date(stock.expiration_date).toLocaleDateString('pt-BR')}</td>
              </tr>`;
          });
  
          html += `</tbody></table>`;
  
          stockTableBody.innerHTML = html;
  
        } catch (error) {
          stockTableBody.innerHTML = `<p class="text-center py-4 text-red-600">${error.message}</p>`;
        }
      });
    });
  });
  