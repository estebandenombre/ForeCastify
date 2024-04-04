<?php
// Cerrar la conexión a la base de datos
$conn->close();

// Realizar otras acciones de cierre de sesión (por ejemplo, limpiar variables de sesión)

// Redireccionar al usuario a la página de inicio de sesión o cualquier otra página
header("Location: index.php");
exit; // Asegura que el código posterior no se ejecute
?>