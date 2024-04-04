<?php
// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Obtener los datos del formulario
    $nombreModelo = $_POST["nombre_modelo"];
    $descripcion = $_POST["descripcion"];
    $tablaEntrenamiento = $_POST["lista_opciones1"];
    $columnasSeleccionadas = isset($_POST["columnas"]) ? $_POST["columnas"] : array();
    $columnaObjetivo = $_POST["lista_opciones2"];
    $modeloSeleccionado = $_POST["lista_opciones3"];
    $tablaSeleccionada = $_POST["tabla_seleccionada"]; // Tabla a predecir

    // Procesar los datos como sea necesario (por ejemplo, guardarlos en la base de datos)
    // Aquí debes realizar las consultas o acciones necesarias para guardar los datos en la tabla "Modelos"
    // Por ejemplo, puedes usar la conexión a la base de datos y hacer una inserción en la tabla

    // Establecer la conexión a la base de datos
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "data_analytics"; // Reemplaza "tu_base_de_datos" con el nombre de tu base de datos

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Error en la conexión: " . $conn->connect_error);
    }

    // Escapar los datos para evitar inyección de SQL
    $nombreModelo = $conn->real_escape_string($nombreModelo);
    $descripcion = $conn->real_escape_string($descripcion);
    $tablaEntrenamiento = $conn->real_escape_string($tablaEntrenamiento);
    $columnaObjetivo = $conn->real_escape_string($columnaObjetivo);
    $modeloSeleccionado = $conn->real_escape_string($modeloSeleccionado);

    // Unir las columnas seleccionadas en un string separado por comas
    $columnasSeleccionadasString = implode(", ", $columnasSeleccionadas);

    // Crear la consulta para insertar el nuevo modelo en la tabla "Modelos"
    $sql = "INSERT INTO Modelos (NombreModelo, Descripcion, Tabla, Columnas, ColumnaObjetivo, ModeloSeleccionado, TablaSeleccionada)
            VALUES ('$nombreModelo', '$descripcion', '$tablaEntrenamiento', '$columnasSeleccionadasString', '$columnaObjetivo', '$modeloSeleccionado', '$tablaSeleccionada')";

    if ($conn->query($sql) === TRUE) {
        echo "Modelo creado correctamente.";
        header("Location: ML.php");
        exit();
    } else {
        echo "Error al crear el modelo: " . $conn->error;
    }

    $conn->close();

} else {
    // Si el formulario no ha sido enviado, redirigir al usuario a la página del formulario
    header("Location: form_modelo.php");
    exit();
}
?>
