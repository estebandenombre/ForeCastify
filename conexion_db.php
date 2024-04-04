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

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
</head>

<body>
  <nav class="navbar">
    <div class="logo">
      <a href="index.php">
        <h3>Fore<span>castify</span></h3>
      </a>
    </div>
    <ul class="nav-links">
      <a href="eleccion.php">
        <li><img src="/build/img/cable.png" alt="Data Base Connection"></li>
      </a>
    </ul>
  </nav>
  <section>
    <div class="contenedor_panel animate__animated animate__fadeIn">
      <div class="container">
        <h4>MySQL</h4>
        <form action="process_form.php" method="post">
          <label for="nombre-conexion">Connection Name:</label>
          <input type="text" id="nombre-conexion" name="nombre-conexion" required>

          <label for="host">Host:</label>
          <input type="text" id="host" name="host" required>

          <label for="puerto">Port:</label>
          <input type="text" id="puerto" name="puerto" required>

          <label for="usuario">Username:</label>
          <input type="text" id="usuario" name="usuario" required>

          <label for="contrasena">Password:</label>
          <input type="password" id="contrasena" name="contrasena" required>

          <label for="nombre-db">Database Name:</label>
          <input type="text" id="nombre-db" name="nombre-db" required>

          <input type="submit" value="Conectar">
        </form>
      </div>
    </div>
  </section>












  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
  <script type="text/javascript" src="vanilla-tilt.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script src="https://hammerjs.github.io/dist/hammer.min.js"></script>
  <script src="build/js/bundle.min.js"></script>





</body>

</html>