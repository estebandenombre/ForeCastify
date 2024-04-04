$(document).ready(function() {
  
  // Capturar el clic en una tabla de la lista
  $(".lista-tablas li").click(function() {
    const tablaId = $(this).data("tabla-id");
    console.log(tablaId);
    imprimirTabla(tablaId);
  });
  
  
});

// Función para imprimir el contenido de la tabla seleccionada
function imprimirTabla(tablaId) {
  $.ajax({
    url: "../../obtener_contenido_tabla.php",
    method: "POST",
    data: { tablaId: tablaId },
    success: function(data) {
      $("#tabla-contenedor").html(data);
    },
    error: function() {
      alert("Error al obtener el contenido de la tabla.");
    }
  });
  
}


  const movableWindow = document.getElementById('movableWindow');
  let isDragging = false;
  let offset = { x: 0, y: 0 };
  let isMaximized = false;
  let savedPosition = {};
  
  
  function startDragging(e) {
    isDragging = true;
    offset.x = e.clientX - movableWindow.getBoundingClientRect().left;
    offset.y = e.clientY - movableWindow.getBoundingClientRect().top;
  }
  
  document.addEventListener('mousemove', (e) => {
    if (isDragging && !isMaximized) {
      movableWindow.style.left = (e.clientX - offset.x) + 'px';
      movableWindow.style.top = (e.clientY - offset.y) + 'px';
    }
  });
  
  document.addEventListener('mouseup', () => {
    isDragging = false;
  });
  
  function minimizeWindow() {
    movableWindow.classList.toggle('ocultar');
  }
  
  function maximizeWindow() {
    if (isMaximized) {
      // Restore the window to its previous position
      movableWindow.style.left = savedPosition.left;
      movableWindow.style.top = savedPosition.top;
      movableWindow.style.width = savedPosition.width;
      movableWindow.style.height = savedPosition.height;
      isMaximized = false;
    } else {
      // Maximize the window and save its current position
      savedPosition.left = movableWindow.style.left;
      savedPosition.top = movableWindow.style.top;
      savedPosition.width = movableWindow.style.width;
      savedPosition.height = movableWindow.style.height;
      movableWindow.style.left = '0';
      movableWindow.style.top = '0';
      movableWindow.style.width = '100%';
      movableWindow.style.height = '100%';
      isMaximized = true;
      
    }
  }
  
  function closeWindow() {
    movableWindow.classList.toggle('ocultar');
  }

  const items = document.querySelectorAll('.item');

  items.forEach(item => {
    item.addEventListener('click', () => {
      // Remove 'selected' class from all items
      items.forEach(otherItem => {
        otherItem.classList.remove('selected');
      });
  
      // Add 'selected' class to clicked item
      item.classList.add('selected');
    });
  });
    