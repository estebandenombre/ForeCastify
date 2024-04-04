// Obtener el select de la tabla y el div para las características
const tablaSelect = document.getElementById("tabla");
const caracteristicasDiv = document.getElementById("caracteristicas");


// Función para mostrar las características de la tabla seleccionada
function mostrarCaracteristicas() {
    const tablaSeleccionada = tablaSelect.value;

    // Realizar una petición AJAX para obtener las características de la tabla seleccionada
    const xhr = new XMLHttpRequest();
    xhr.open("GET", "../../ML2.php?tabla=" + tablaSeleccionada, true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            const caracteristicas = JSON.parse(xhr.responseText);

            // Construir el HTML para mostrar las características
            let htmlCaracteristicas = "";
            caracteristicas.forEach(caracteristica => {
                htmlCaracteristicas += "<label>";
                htmlCaracteristicas += "<input type='checkbox' name='caracteristicas[]' value='" + caracteristica + "'>";
                htmlCaracteristicas += caracteristica;
                htmlCaracteristicas += "</label>";
            });

            // Insertar el HTML en el div de las características
            caracteristicasDiv.innerHTML = htmlCaracteristicas;
        }
    };
    xhr.send();
}

// Agregar el evento change al select de la tabla para que se muestren las características
tablaSelect.addEventListener("change", mostrarCaracteristicas);

// Mostrar las características inicialmente si hay una tabla seleccionada
if (tablaSelect.value !== "") {
    mostrarCaracteristicas();
}