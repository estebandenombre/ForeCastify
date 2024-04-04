<!DOCTYPE html>
<html>
<head>
    <title>Guardar Tabla en la Base de Datos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .success-message {
            padding: 10px;
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
            margin-bottom: 10px;
        }

        .error-message {
            padding: 10px;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <?php
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
    

    // Nombre de la tabla que se creará
    $nombre_tabla = "Tabla_Con_Predicciones";

    // Ruta del archivo CSV a importar
    $ruta_csv = "predicciones.csv";

    // Leer el contenido del archivo CSV
    $data = array_map('str_getcsv', file($ruta_csv));

    // Obtener los nombres de las columnas del archivo CSV (la primera fila del archivo)
    $columnas = $data[0];

    // Crear la sentencia SQL para crear la tabla
    $sql_create_table = "CREATE TABLE $nombre_tabla (id INT AUTO_INCREMENT PRIMARY KEY, ";

    foreach ($columnas as $columna) {
        $sql_create_table .= "$columna VARCHAR(255), ";
    }

    $sql_create_table = rtrim($sql_create_table, ", ");
    $sql_create_table .= ")";

    // Ejecutar la sentencia SQL para crear la tabla
    if ($conn->query($sql_create_table) === TRUE) {
        echo '<div class="success-message">Tabla creada exitosamente</div>';
    } else {
        echo '<div class="error-message">Error al crear la tabla: ' . $conn->error . '</div>';
    }

    // Insertar los datos desde el archivo CSV en la tabla
    for ($i = 1; $i < count($data); $i++) {
        $valores = "'" . implode("','", $data[$i]) . "'";
        $sql_insert_data = "INSERT INTO $nombre_tabla (" . implode(",", $columnas) . ") VALUES ($valores)";

        if ($conn->query($sql_insert_data) === TRUE) {
            echo '<div class="success-message">Fila ' . $i . ' insertada correctamente</div>';
        } else {
            echo '<div class="error-message">Error al insertar la fila ' . $i . ': ' . $conn->error . '</div>';
        }
    }

    // Cerrar la conexión a la base de datos
    $conn->close();
    ?>
</body>
</html>
