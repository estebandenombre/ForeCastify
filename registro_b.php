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

    // Consulta para verificar si el usuario ya existe
    $check_user_sql = "SELECT * FROM usuarios WHERE username='$username'";
    $check_user_result = $conn->query($check_user_sql);

    if ($check_user_result->num_rows > 0) {
        echo "El usuario ya existe. Intenta con otro nombre de usuario.";
    } else {
        // Consulta para insertar el nuevo usuario en la base de datos
        $insert_sql = "INSERT INTO usuarios (username, password) VALUES ('$username', '$password')";
        if ($conn->query($insert_sql) === TRUE) {
            header("Location: eleccion.php");
            echo "Registro exitoso. Ahora puedes iniciar sesión.";
            exit(); // Asegura que no se ejecuten más líneas después de la redirección
        } else {
            echo "Error al registrar el usuario: " . $conn->error;
        }
    }
}

// Cerrar la conexión
$conn->close();
?>
