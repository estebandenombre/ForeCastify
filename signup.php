<?php
// Configuración de la conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "mi_base_de_datos";

// Obtener los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $usernameInput = $_POST['username'];
  $passwordInput = $_POST['password'];

  // Crear la conexión a la base de datos
  $conn = new mysqli($servername, $username, $password, $dbname);

  // Verificar si la conexión fue exitosa
  if ($conn->connect_error) {
    die("Error en la conexión: " . $conn->connect_error);
  }

  // Verificar si el nombre de usuario ya está registrado
  $sql = "SELECT * FROM usuarios WHERE username = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $usernameInput);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $error = "El nombre de usuario ya está registrado.";
  } else {
    // Insertar el nuevo usuario en la base de datos
    $hashedPassword = password_hash($passwordInput, PASSWORD_DEFAULT);
    $sql = "INSERT INTO usuarios (username, password) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $usernameInput, $hashedPassword);
    $stmt->execute();

    // Redireccionar al panel de control después del registro exitoso
    header("Location: panel.php");
    exit;
  }

  // Cerrar la conexión a la base de datos
  $stmt->close();
  $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adaptat</title>
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
    
    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
    />
</head>
<body>
  <div class="container">
    <h2>Registrarse</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
      <div class="form-group">
        <label for="username">Nombre de usuario:</label>
        <input type="text" id="username" name="username" required>
      </div>
      <div class="form-group">
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required>
      </div>
      <div class="form-group">
        <button type="submit">Registrarse</button>
      </div>
      <div class="form-group">
        <?php if (isset($error)) { echo $error; } ?>
      </div>
    </form>
    <p>¿Ya tienes una cuenta? <a href="index.php">Inicia sesión aquí</a></p>
  </div>
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
    <script type="text/javascript" src="vanilla-tilt.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://hammerjs.github.io/dist/hammer.min.js"></script>
    <script src="build/js/bundle.min.js"></script>
</html>
