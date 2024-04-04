<?php
// Configurar la conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "data_Analytics";

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error en la conexión: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Consulta para verificar las credenciales
    $sql = "SELECT * FROM usuarios WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // Inicio de sesión exitoso
        // Puedes redirigir al usuario a la página que desees
        echo "Inicio de sesión exitoso. ¡Bienvenido!";
        header("Location: eleccion.php");
        echo "Registro exitoso. Ahora puedes iniciar sesión.";
        exit(); // Asegura que no se ejecuten más líneas después de la redirección
    } else {
        // Credenciales inválidas
        echo "Usuario o contraseña incorrectos.";
    }
}

// Cerrar la conexión
$conn->close();
?>
