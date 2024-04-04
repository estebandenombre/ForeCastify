
function getTablaColumns() {
    const tablaSeleccionada = document.getElementById("lista_opciones1").value;
    console.log(tablaSeleccionada);

    // Realizar una solicitud AJAX al servidor para obtener las columnas de la tabla seleccionada
    // Puedes utilizar JavaScript puro o una biblioteca como jQuery para realizar la solicitud
    // Aquí se muestra un ejemplo utilizando fetch (JavaScript moderno)
    fetch('get_tabla_columns.php?tabla=' + tablaSeleccionada)
        .then(response => response.json())
        .then(data => {
            // Llenar la lista de columnas con los datos obtenidos
            const listaColumnas = document.getElementById("columnasTabla");
            listaColumnas.innerHTML = "";

            for (const columna of data) {
                const label = document.createElement("label");
                const input = document.createElement("input");
                input.type = "checkbox";
                input.name = "columnas[]";
                input.value = columna;
                label.appendChild(input);
                label.appendChild(document.createTextNode(columna));
                listaColumnas.appendChild(label);
                
            }
        })
        .catch(error => {
            console.error('Error al obtener las columnas:', error);
        });
        fetch('get_tabla_columns.php?tabla=' + tablaSeleccionada)
        .then(response => response.json())
        .then(data => {
            // Llenar la lista de columnas con los datos obtenidos
            const listaColumnas = document.getElementById("lista_opciones2");
            listaColumnas.innerHTML = "";

            for (const columna of data) {
                const opcion = document.createElement("option");
                opcion.text = columna;
                opcion.value = columna;
                listaColumnas.add(opcion);
            }
        })
        .catch(error => {
            console.error('Error al obtener las columnas:', error);
        });    
}

function toggleMarcarDesmarcar() {
    const checkboxes = document.querySelectorAll("#columnasTabla input[type='checkbox']");
    const marcarDesmarcarBtn = document.getElementById("marcarDesmarcar");

    checkboxes.forEach(checkbox => {
        checkbox.checked = !checkbox.checked;
    });

    marcarDesmarcarBtn.innerText = checkboxes[0].checked ? "Desmarcar Todo" : "Marcar Todo";
}
      
const botonesCrearModelo = document.querySelectorAll(".btnEvaluar");
botonesCrearModelo.forEach((boton) => {
    boton.addEventListener("click", selecionarTablaPrediccion);
});
function selecionarTablaPrediccion(event) {
    event.preventDefault();

    const contenedor_cargar = document.querySelector(".contenedor_cargar");
    contenedor_cargar.classList.toggle('ocultar');

    const contenedor_tabla_evaluar = document.querySelector(".contenedor_tabla_evaluar");
   
    contenedor_tabla_evaluar.classList.toggle('ocultar');
}  
const tablaSelecionadaPrediccion = document.querySelectorAll(".tablaSelecionadaPrediccion");
tablaSelecionadaPrediccion.forEach((boton) => {
    boton.addEventListener("click", verSiguientePrediccion);
  });
function verSiguientePrediccion(event) {
    event.preventDefault();

    const btn_siguientePrediccion = document.querySelector(".btn_siguientePrediccion");
   
    btn_siguientePrediccion.classList.remove("ocultar");
}  

  