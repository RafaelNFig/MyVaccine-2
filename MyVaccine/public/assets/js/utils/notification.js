// notification.js

function showNotification(message, type = "success") {
    let notification = document.getElementById("notification");
  
    if (!notification) {
      // Se não existir, cria o elemento e adiciona no body
      notification = document.createElement("div");
      notification.id = "notification";
      notification.className = "fixed top-5 right-5 text-white px-4 py-2 rounded shadow-lg opacity-0 pointer-events-none transition-opacity duration-300 z-50";
      document.body.appendChild(notification);
    }
  
    notification.textContent = message;
  
    // Definir cores conforme tipo
    if (type === "success") {
      notification.style.backgroundColor = "#22c55e"; // verde
    } else if (type === "error") {
      notification.style.backgroundColor = "#ef4444"; // vermelho
    } else {
      notification.style.backgroundColor = "#3b82f6"; // azul
    }
  
    // Mostrar com fade in
    notification.style.opacity = "1";
    notification.style.pointerEvents = "auto";
  
    // Ocultar depois de 3 segundos
    setTimeout(() => {
      notification.style.opacity = "0";
      notification.style.pointerEvents = "none";
    }, 3000);
  }
  window.showNotification = showNotification;
  