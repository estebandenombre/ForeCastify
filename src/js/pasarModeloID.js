const btnsEvaluar = document.querySelectorAll('.btnEvaluar');

// Agregar un evento de clic a cada botón EVALUAR
btnsEvaluar.forEach(btn => {
    btn.addEventListener('click', () => {
        // Obtener el ID del modelo desde el atributo data-modelo-id
        const modeloID = btn.getAttribute('data-modelo-id');

        // Realizar una redirección a Ejecucion_Prediccion.php con el ID del modelo como parámetro
        window.location.href = `Ejecucion_Prediccion.php?modeloID=${modeloID}`;
    });
});