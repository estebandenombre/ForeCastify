document.addEventListener("DOMContentLoaded", function() {
  const logoutLink = document.getElementById("logout-link");
  const addGraLink = document.getElementById("addGraLink");
 
  logoutLink.addEventListener("click", confirmLogout);
  addGraLink.addEventListener("click", addGrafica);


  const btn_add_modelo = document.getElementById("btn_add_modelo");
  btn_add_modelo.addEventListener("click", crearModelo);

  function confirmLogout(event) {
      event.preventDefault();

      const contenedor_aviso_cierre = document.getElementById("contenedor_aviso_cierre");
      contenedor_aviso_cierre.classList.toggle('ocultar');
      // Agregar evento al botón "Cancelar" para cerrar el aviso
      const cancelButton = document.getElementById("cancel-button");
      cancelButton.addEventListener("click", function() {
        contenedor_aviso_cierre.classList.toggle('ocultar');
      });

      // Agregar evento al botón "Confirmar" para cerrar la sesión
      const confirmButton = document.getElementById("confirm-button");
      confirmButton.addEventListener("click", function() {
          // Enviar solicitud AJAX al archivo "logout.php"
          const xhr = new XMLHttpRequest();
          xhr.open("POST", "../../logout.php", true);
          xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
          xhr.onload = function() {
              // Redireccionar al usuario después de cerrar la sesión
              window.location.href = "../../index.php"; // O cualquier otra página
          };
          xhr.send();
      });
  }
  function addGrafica(event) {
    event.preventDefault();

    
    movableWindow.classList.toggle('ocultar');
  }
  function crearModelo(event) {
    event.preventDefault();

    const crearModelo = document.getElementById("crearModelo");
    
    crearModelo.classList.toggle('ocultar');
    
    
  }
  
  
  
});
  