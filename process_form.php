<?php
// Iniciar la sesión
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombreConexion = $_POST["nombre-conexion"];
    $host = $_POST["host"];
    $puerto = $_POST["puerto"];
    $usuario = $_POST["usuario"];
    $contrasena = $_POST["contrasena"];
    $nombreDB = $_POST["nombre-db"];

    // Conectarse a la base de datos utilizando los parámetros recibidos
    $conn = new mysqli($host . ':' . $puerto, $usuario, $contrasena, $nombreDB);

    // Verificar la conexión
    if ($conn->connect_error) {
        header("Location: conexion_db.php");
        exit();
    }

    // Almacenar el nombre del usuario en una variable de sesión
    $_SESSION["nombre-conexion"] = $nombreConexion;
    $_SESSION["host"] = $host;
    $_SESSION["puerto"] = $puerto;
    $_SESSION["usuario"] = $usuario;
    $_SESSION["contrasena"] = $contrasena;
    $_SESSION["nombreDB"] = $nombreDB;

    // Cerrar la conexión después de realizar las operaciones necesarias
    $conn->close();

    // Redirigir al usuario a otra página donde se imprimirá el mensaje de bienvenida
    header("Location: panel.php");
    exit();
}
?>

