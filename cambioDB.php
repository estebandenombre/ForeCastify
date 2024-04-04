<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AnalyticaPro</title>
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
    
    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
    />
</head>

<body>
  <nav class="navbar ocultar" id="barra_nav">
      <div class="logo">
        <a href="index.php"><h3>Analytica <span>Pro</span></h3></a>
      </div>
      <ul class="nav-links">
        <a href="conexion_db.php"><button><img src="/build/img/cable.png" alt="Data Base Connection"></button></a>
        <a href="cambioDB.php"><button id="ML_Link"><img src="/build/img/dba.png" alt="Data Base"></button></a>
        <a href="panel.php"><button><img src="/build/img/table.png" alt="Tables"></button></a>
        <button id="addGraLink"><img src="/build/img/analysis.png" alt="Analysis"></button>
        <a href="ML.php"><button id="ML_Link"><img src="/build/img/ma.png" alt="MA"></button></a>
        <button id="logout-link"><img src="/build/img/exit.png" alt="Close"></button>
      </ul>
  </nav>
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
    $conn = new mysqli($host . ':' . $puerto, $usuario, $contrasena, $nombreDB);
    if ($conn->connect_error) {
    die("Error en la conexión: " . $conn->connect_error);
    }
    $sql = "SHOW TABLES";
    $result = $conn->query($sql);
    $conn->close();
?>

  
  
  
 
    
  
  


  


    
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