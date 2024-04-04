$(document).ready(function() {
    const btnaddTable = document.getElementById("btn-add-Table");
    btnaddTable.addEventListener("click", addTabla);
    function addTabla(event) {
        event.preventDefault();
        
       
        // Hacemos una solicitud GET al archivo PHP
        fetch('../../añadirTablaPredicciones.php')
        .then(response => {
            if (response.ok) {
                console.log('Archivo PHP ejecutado correctamente.');
            } else {
                console.error('Error al ejecutar el archivo PHP.');
            }
        })
        .catch(error => {
            console.error('Error en la solicitud:', error);
        });
        btnaddTable.style.backgroundImage = "url(../../build/img/garrapata.png)";
        btnaddTable.disabled = true;
        
    }
});