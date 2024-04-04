<?php
// Obtener el nombre de la tabla seleccionada desde la URL
session_start();

// Verificar si la variable de sesión existe antes de usarla
if (isset($_SESSION["nombre-conexion"]) && isset($_SESSION["host"]) && isset($_SESSION["puerto"]) && isset($_SESSION["usuario"]) && isset($_SESSION["contrasena"]) && isset($_SESSION["nombreDB"])){
    $nombreConexion = $_SESSION["nombre-conexion"];
    $host = $_SESSION["host"];
    $puerto = $_SESSION["puerto"];
    $usuario = $_SESSION["usuario"];
    $contrasena = $_SESSION["contrasena"];
    $nombreDB = $_SESSION["nombreDB"];
} else {
    // Si la variable de sesión no existe, redirigir al usuario de vuelta al formulario o a otra página de error
    header("Location: process_form.php");
    exit();
}

// Crear la conexión a la base de datos
$conn = new mysqli($host, $usuario, $contrasena, $nombreDB);

if (isset($_GET["tabla"])) {
    $tablaSeleccionada = $_GET["tabla"];

    // Aquí debes reemplazar la siguiente línea con la conexión a tu base de datos
    $conn = new mysqli($host, $usuario, $contrasena, $nombreDB);
    if ($conn->connect_error) {
        die("Error en la conexión: " . $conn->connect_error);
    }

    // Consulta para obtener las columnas de la tabla seleccionada
    $sql = "SHOW COLUMNS FROM " . $tablaSeleccionada;
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $columnas = array();

        while ($row = $result->fetch_assoc()) {
            $columnas[] = $row["Field"];
        }

        // Devolver las columnas como un objeto JSON
        header('Content-Type: application/json');
        echo json_encode($columnas);
    } else {
        echo "No se encontraron columnas en la tabla.";
    }

    $conn->close();
} else {
    echo "Error al obtener la tabla seleccionada.";
}
?>
