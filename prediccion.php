<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "petalos";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Error en la conexión: " . $conn->connect_error);
}

// Consulta para obtener los datos de la tabla
$sql = "SELECT longitud_sepalo, ancho_sepalo, longitud_petalo, ancho_petalo, especie FROM datos_flores";
$result = $conn->query($sql);

// Exportar los datos a un archivo CSV
$filename = "datos_flores.csv";
$fp = fopen($filename, 'w');
fputcsv($fp, array('longitud_sepalo', 'ancho_sepalo', 'longitud_petalo', 'ancho_petalo', 'especie'));

while ($row = $result->fetch_assoc()) {
    fputcsv($fp, $row);
}

fclose($fp);
$conn->close();

echo "Datos exportados correctamente a datos_flores.csv";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Predicción de Flores</title>
</head>
<body>
    <h1>Modelo de Predicción de Flores</h1>

    <?php
    // Llamar al script Python desde PHP
    $python_script = 'prediccion_flores.py';
    $output = shell_exec('python ' . $python_script);
    ?>

    <h2>Predicción:</h2>
    <p><?php echo $output; ?></p>

    <?php
    // Obtener la ruta completa del archivo CSV generado
    $csv_file = 'datos_flores.csv';

    // Verificar si el archivo existe y eliminarlo
    if (file_exists($csv_file)) {
        unlink($csv_file);
        echo "El archivo CSV ha sido eliminado.";
    } else {
        echo "El archivo CSV no existe.";
    }
    ?>
</body>
</html>
