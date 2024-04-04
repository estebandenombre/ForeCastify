<?php


// Iniciar la sesión para poder acceder a la variable de sesión
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

// Verificar la conexión
if ($conn->connect_error) {
  die("Error en la conexión: " . $conn->connect_error);
}

// Obtener el id de la tabla seleccionada desde la solicitud AJAX
if (isset($_POST["tablaId"])) {
  $tablaId = $_POST["tablaId"];

  // Consulta para obtener el contenido de la tabla seleccionada
  $sql = "SELECT * FROM $tablaId"; // Reemplaza "nombre_de_la_tabla" con el nombre de tu tabla
  $result = $conn->query($sql);

  // Verificar si hay resultados y construir la tabla HTML con los datos
  if ($result && $result->num_rows >= 0) {
    $tablaHTML = "<table class='tabla'>";
    $columnNames = $result->fetch_assoc();

    // Encabezados de la tabla
    $tablaHTML .= "<tr>";
    foreach ($columnNames as $columnName => $value) {
      $tablaHTML .= "<th>" . $columnName . "</th>";
    }
    $tablaHTML .= "</tr>";
    mysqli_data_seek($result, 0);

    // Contenido de la tabla
    if ($result->num_rows == 0){
      $tablaHTML.= '<p>No se han encontrado registros.</p>';
    }else{
      while ($row = $result->fetch_assoc()) {
        $tablaHTML .= "<tr>";
        foreach ($row as $value) {
          $tablaHTML .= "<td>" . $value . "</td>";
        }
        $tablaHTML .= "</tr>";
      }
    }
    

    $tablaHTML .= "</table>";
    header('Content-Type: text/html; charset=utf-8');
    $tablaHTML = utf8_encode($tablaHTML);
    echo $tablaHTML;
  } else {
    echo "Tabla no encontrada o sin datos.";
  }
} else {
  echo "Error al obtener el contenido de la tabla.";
}

// Cerrar la conexión
$conn->close();
?>

