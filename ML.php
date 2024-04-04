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
      <button><img src="/build/img/dba.png" alt="Data Base"></button>
      <a href="panel.php"><button><img src="/build/img/table.png" alt="Tables"></button></a>
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
  <section class="contenedor_seccion" id="contenedor_ML">
    <div>
      <div class="contenedor_btn animate__animated animate__fadeIn animate__delay-1s">
        <div></div>
        <button class="btnCrearModelo" id="btn_add_modelo"><img src="/build/img/add.png" alt=""></button>
      </div>
      <div class="ocultar contenedor_crear_modelo animate__animated animate__fadeIn" id="crearModelo">
        <form action="procesar_modelo.php" method="post">
          <div class="grid-container">
            <div class="grid-item">
              <label for="nombre_modelo">Model Name:</label>
              <input type="text" id="nombre_modelo" name="nombre_modelo" required>
              <br>
            </div>

            <div class="grid-item">
              <label for="descripcion">Model Description:</label>
              <textarea id="descripcion" name="descripcion" rows="1" cols="25" required></textarea>
              <br>
            </div>

            <div class="grid-item">
              <label for="lista_opciones1">Training Table:</label>
              <select id="lista_opciones1" name="lista_opciones1" onchange="getTablaColumns()" required>
                <option value="" disabled selected>Select Table</option>
                <?php
                if ($result->num_rows > 0) {
                  echo "<ul class='lista-tablas'>";
                  while ($row = $result->fetch_row()) {
                    echo "<option value='" . $row[0] . "'>" . $row[0] . "</option>";
                  }
                  echo "</ul>";
                } else {
                  echo "No se encontraron tablas en la base de datos.";
                }
                ?>
              </select>
              <br>
            </div>
            <div class="grid-item">
              <label for="tabla_seleccionada">Table to Predict:</label>
              <select id="tabla_seleccionada" name="tabla_seleccionada" required>
                <option value="" disabled selected>Select Table</option>
                <?php
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

                // Consulta para obtener las tablas disponibles en la base de datos
                $sql = "SHOW TABLES";
                $result = $conn->query($sql);
                $conn->close();
                if ($result->num_rows > 0) {
                  while ($row = $result->fetch_row()) {
                    echo "<option value='" . $row[0] . "'>" . $row[0] . "</option>";
                  }
                } else {
                  echo "<option value=''>No se encontraron tablas en la base de datos</option>";
                }
                ?>
              </select>
              <br>
            </div>

            <div class="grid-item">
              <label>Columns to include in the model:</label>
              <div id="columnasTabla"></div>
              <br>
            </div>

            <div class="grid-item">
              <label for="lista_opciones2">Target Column:</label>
              <select id="lista_opciones2" name="lista_opciones2" required>
                <option value="" disabled selected>Select Column</option>
              </select>
              <br>
            </div>

            <div class="grid-item">
              <label for="lista_opciones3">Select Model:</label>
              <select id="lista_opciones3" name="lista_opciones3" required>
                <option value="" disabled selected>Select Model</option>
                <option value="Regresión Logística">Auto</option>
                <option value="Regresión Logística">Logistic Regression</option>
                <option value="Árboles de Decisión">Decision Trees</option>
                <option value="Random Forest">Random Forest</option>
                <option value="Support Vector Machines (SVM)">Support Vector Machines (SVM)</option>
                <option value="Redes Neuronales Artificiales">Artificial Neural Networks</option>
                <option value="K-Nearest Neighbors (KNN):">K-Nearest Neighbors (KNN)</option>
                <option value="XGBoost">XGBoost</option>
                <option value="Naive Bayes">Naive Bayes</option>
                <option value="Clustering (K-Means, DBSCAN)">Clustering (K-Means, DBSCAN)</option>
              </select>
              <br>
            </div>
          </div>



          <input type="submit" value="Crear">
        </form>
      </div>

    </div>
    <div class="contenedor_modelos_mostrar">
      <?php
      // Establecer la conexión a la base de datos
      $servername = "localhost";
      $username = "root";
      $password = "root";
      $dbname = "data_Analytics"; // Cambia "MiEmpresa" por el nombre de tu base de datos

      $conn = new mysqli($servername, $username, $password, $dbname);
      if ($conn->connect_error) {
        die("Error en la conexión: " . $conn->connect_error);
      }

      // Consulta para obtener los registros de la tabla Modelos
      $sql = "SELECT * FROM Modelos";
      $result = $conn->query($sql);


      if ($result->num_rows > 0) {
        echo "<div class='animate__animated animate__fadeIn animate__delay-1s'><h5>Created Models</h5></div>";

        // Iterar sobre los resultados y mostrar cada modelo como un div
        while ($row = $result->fetch_assoc()) {
          echo "<div class='modelo-div animate__animated animate__fadeIn animate__delay-2s'>";
          //echo "<h3>ModeloID: " . $row["ModeloID"] . "</h3>";
          echo "<p><strong>Model Name:</strong> " . $row["NombreModelo"] . "</p>";
          echo "<p><strong>Description:</strong> " . $row["Descripcion"] . "</p>";
          echo "<p><strong>Training Table:</strong> " . $row["Tabla"] . "</p>";
          echo "<p><strong>Table to Predict:</strong> " . $row["TablaSeleccionada"] . "</p>";
          echo "<p><strong>Considered Features:</strong> " . $row["Columnas"] . "</p>";
          echo "<p><strong>Target Column:</strong> " . $row["ColumnaObjetivo"] . "</p>";
          echo "<p><strong>Selected Model:</strong> " . $row["ModeloSeleccionado"] . "</p>";
          echo "<button class='btnCrearModelo btnEvaluar' data-modelo-id='" . $row["ModeloID"] . "'>EVALUATE</button>";
          echo "<button class='btnCrearModelo ' data-modelo-id='" . $row["ModeloID"] . "'>EDIT</button>";
          echo "<button class='btnCrearModelo ' data-modelo-id='" . $row["ModeloID"] . "'>DELETE</button>";
          echo "</div>";
        }
      } else {
        echo "<p class='texto_noModelos id='texto_noModelosId' animate__animated animate__fadeIn animate__delay-2s'>You have not created any models yet</p>";
      }


      $conn->close();
      ?>
    </div>
    <div id="contenedor_aviso_cierre" class="ocultar overlay">
      <div class="logout-warning">
        <h2>¡Atención!</h2>
        <p>Estás a punto de cerrar la sesión. ¿Estás seguro?</p>
        <button id="cancel-button">Cancelar</button>
        <button id="confirm-button">Confirmar</button>
      </div>
    </div>
  </section>

  <div class="overlay contenedor_cargar ocultar">
    <div class="loading-container animate__animated animate__slideInDown">
      Processing...
    </div>
  </div>














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