<?php
// Iniciar la sesión para poder acceder a la variable de sesión
session_start();

// Verificar si la variable de sesión existe antes de usarla
if (isset($_SESSION["nombre-conexion"]) && isset($_SESSION["host"]) && isset($_SESSION["puerto"]) && isset($_SESSION["usuario"]) && isset($_SESSION["contrasena"]) && isset($_SESSION["nombreDB"])) {
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
$conn = new mysqli($host . ':' . $puerto, $usuario, $contrasena, $nombreDB);
if ($conn->connect_error) {
  die("Error en la conexión: " . $conn->connect_error);
}
$sql = "SHOW TABLES";
$result = $conn->query($sql);
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>AnalyticaPro</title>
  <link rel="icon" href="/build/img/data-analytics.png" type="image/png">
  <link rel="stylesheet" href="build/css/app.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans&family=Playfair+Display:ital,wght@1,900&display=swap" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@1,900&display=swap" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>

<body>
  <nav class="navbar ocultar" id="barra_nav">
    <div class="logo">
      <a href="index.php">
        <h3>Fore<span>castify</span></h3>
      </a>
    </div>
    <ul class="nav-links">
      <a href="conexion_db.php"><button><img src="/build/img/cable.png" alt="Data Base Connection"></button></a>
      <a href=""><button id="ML_Link"><img src="/build/img/dba.png" alt="Data Base"></button></a>
      <button><img src="/build/img/table.png" alt="Tables"></button>
      <button id="addGraLink"><img src="/build/img/analysis.png" alt="Analysis"></button>
      <a href="ML.php"><button id="ML_Link"><img src="/build/img/ma.png" alt="MA"></button></a>
      <button id="logout-link"><img src="/build/img/exit.png" alt="Close"></button>
    </ul>
  </nav>
  <!--<div class="ocultar contenedor_mensajeBienvenida animate__animated animate__backOutUp animate__delay-2s">
    <div class="mesajeBienvenida">
      <h2>Se ha establecido la conexión con:</h2>
      <h2 class="conx"><?php echo $nombreConexion; ?></h2>
    </div>
  </div>
-->
  <section class="contenedor_panel_info animate__animated animate__fadeInLeft" id="contenedor_tabla">
    <div class="contenedor_info" id='resizable'>
      <div class="left">
        <h4 class="animate__animated animate__pulse animate__delay-2s"><?php echo $nombreConexion; ?></h4>
        <?php
        if ($result->num_rows > 0) {
          echo "<ul class='lista-tablas'>";
          while ($row = $result->fetch_row()) {
            echo "<li class='animate__animated animate__fadeInDown animate__delay-2s item' data-tabla-id='" . $row[0] . "'>" . $row[0] . "</li>";
          }
          echo "</ul>";
        } else {
          echo "No se encontraron tablas en la base de datos.";
        }
        ?>

      </div>
      <div class="right">
        <div id="tabla-contenedor"></div>
      </div>
    </div>
    <div id="contenedor_aviso_cierre" class="ocultar overlay">
      <div class="logout-warning">
        <h2>¡Atención!</h2>
        <p>Estás a punto de cerrar la sesión. ¿Estás seguro?</p>
        <button id="cancel-button">Cancelar</button>
        <button id="confirm-button">Confirmar</button>
      </div>
    </div>
    <div class="contendor_estadistica ocultar animate__animated animate__zoomInUp" id="movableWindow" onmousedown="startDragging(event)">
      <nav class="navbar">
        <div class="logo">
          <a href="index.php">
            <h3>Analytica <span>Pro</span></h3>
          </a>
        </div>

        <button class="minimize-button" onclick="minimizeWindow()"><img src="/build/img/minimizar.png" alt="mini"></button>
        <button class="maximize-button" onclick="maximizeWindow()"><img src="/build/img/max.png" alt="max"></button>
        <button class="close-button" onclick="closeWindow()"><img src="/build/img/close.png" alt="exit"></button>
      </nav>
      <div class="contenido_grafica">
        <button class="btn-add"><img src="/build/img/añada-tabla.png" alt="Tables"></button>
      </div>

    </div>
  </section>














  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
  <script type="text/javascript" src="vanilla-tilt.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script src="https://hammerjs.github.io/dist/hammer.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="build/js/bundle.min.js"></script>






</body>

</html>