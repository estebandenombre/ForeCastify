<?php
// Verificar si se ha recibido el ID del modelo en la URL
if (isset($_GET["modeloID"])) {
    // Obtener el ID del modelo desde la URL
    $modeloID = $_GET["modeloID"];

    // Aquí debes agregar el código para conectarte a la base de datos y consultar los detalles del modelo
    // Reemplaza los valores de $servername, $username, $password y $dbname con los de tu base de datos
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "data_analytics";

    // Crear la conexión a la base de datos
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Error en la conexión: " . $conn->connect_error);
    }

    // Consulta para obtener los detalles del modelo utilizando el ID del modelo
    $sql = "SELECT * FROM Modelos WHERE ModeloID = $modeloID";
    $result = $conn->query($sql);

    // Verificar si se encontró el modelo
    if ($result->num_rows > 0) {
        // Obtener los detalles del modelo
        $row = $result->fetch_assoc();
        // Ahora puedes imprimir los detalles del modelo en la página
        //echo "<h2>Detalles del Modelo</h2>";
        //echo "<p><strong>Nombre del Modelo:</strong> " . $row["NombreModelo"] . "</p>";
        //echo "<p><strong>Descripción:</strong> " . $row["Descripcion"] . "</p>";
        //echo "<p><strong>Tabla de Entrenamiento:</strong> " . $row["Tabla"] . "</p>";
        //echo "<p><strong>Tabla a Predecir:</strong> " . $row["TablaSeleccionada"] . "</p>";
        //echo "<p><strong>Características a tener en cuenta:</strong> " . $row["Columnas"] . "</p>";
        //echo "<p><strong>Columna Objetivo:</strong> " . $row["ColumnaObjetivo"] . "</p>";
        //echo "<p><strong>Modelo Seleccionado:</strong> " . $row["ModeloSeleccionado"] . "</p>";
        //echo "</div>";
    }
    $tabla = $row["Tabla"];
    $tablaPrediccion = $row["TablaSeleccionada"];
    $columnaObjetivo = $row["ColumnaObjetivo"];
    $caracteristicas = $row["Columnas"];


    // Cerrar la conexión a la base de datos
    $conn->close();
} else {
    echo "<p>No se ha proporcionado el ID del modelo</p>";
}
?>
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

/////////////////////////////////////////////////////////////////////////////
$txt = "SELECT " . $caracteristicas . ", " . $columnaObjetivo . " FROM " . $tabla;
// Consulta para obtener los datos de la tabla

$result = $conn->query($txt);

// Exportar los datos a un archivo CSV
$filename = "datos_entrenamiento.csv";
$fp = fopen($filename, 'w');
// Convertir las cadenas de caracteres en arrays
$arrayCaracteristicas = explode(', ', $caracteristicas);
$arrayColumnaObjetivo = [$columnaObjetivo];

// Combinar los arrays en uno solo que contenga todas las columnas
$arrayTotal = array_merge($arrayCaracteristicas, $arrayColumnaObjetivo);
fputcsv($fp, $arrayTotal);

while ($row = $result->fetch_assoc()) {
    fputcsv($fp, $row);
}

fclose($fp);
///////////////////////////////////////////////////////////////////

$sql = "SELECT " . $caracteristicas . ", " . $columnaObjetivo . " FROM " . $tablaPrediccion;
$result = $conn->query($sql);
// Exportar los datos a un archivo CSV
$filename = "datos_tablaPrediccion.csv";
$fp = fopen($filename, 'w');
// Convertir las cadenas de caracteres en arrays
$arrayCaracteristicas = explode(', ', $caracteristicas);
$arrayColumnaObjetivo = [$columnaObjetivo];

// Combinar los arrays en uno solo que contenga todas las columnas
$arrayTotal = array_merge($arrayCaracteristicas, $arrayColumnaObjetivo);
fputcsv($fp, $arrayTotal);

while ($row = $result->fetch_assoc()) {
    fputcsv($fp, $row);
}

fclose($fp);

////////////////////////////////////////////////////////////////////
$conn->close();
?>
<!DOCTYPE html>
<html>

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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js"></script>
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
    <div id="dashboard">


        <?php
        // Llamar al script Python desde PHP
        $python_script = 'prediccion_flores.py';
        $output = shell_exec('python ' . $python_script);

        // Escapar las variables PHP para evitar problemas con la línea de comandos
        $escaped_variable1 = escapeshellarg($caracteristicas);
        $escaped_variable2 = escapeshellarg($columnaObjetivo);

        // Llamar al script Python desde PHP y pasar las variables como argumentos en la línea de comandos
        $python_script = 'prediccion_flores.py ' . $escaped_variable1 . ' ' . $escaped_variable2;

        ?>
        <?php
        // Obtener la ruta completa del archivo CSV generado
        $csv_file = 'datos_entrenamiento.csv';
        $output = shell_exec('python ' . $python_script);

        // Leer los resultados de la predicción desde el archivo CSV generado
        $predicciones = array_map('str_getcsv', file('predicciones.csv'));

        // Mostrar los resultados en una tabla HTML
        if (count($predicciones) > 0) {
            echo '<div class="tabla_Prediccion_Hecha widget animate__animated animate__fadeIn">';
            echo '<h2>Predicción</h2>';
            echo '<table border="1">';
            echo '<tr>';
            foreach ($predicciones[0] as $column) {
                echo '<th>' . $column . '</th>';
            }
            echo '</tr>';
            for ($i = 1; $i < count($predicciones); $i++) {
                echo '<tr>';
                foreach ($predicciones[$i] as $j => $value) {
                    if ($predicciones[0][$j] === $columnaObjetivo) {
                        echo '<td style="color: red;">' . $value . '</td>';
                    } else {
                        echo '<td>' . $value . '</td>';
                    }
                }
                echo '</tr>';
            }
            echo '</table>';
            echo '<button class="contenedor_Añadir_TablaPrediccion" id="btn-add-Table"></button>';
            echo '</div>';
        } else {
            echo '<p>No se encontraron resultados de predicción.</p>';
        }
        ?>


        <div class="widget animate__animated animate__fadeIn">
            <canvas id="coeficientesChart"></canvas>
            <script>
                // Leer el archivo CSV
                fetch('resultados.csv')
                    .then(response => response.text())
                    .then(csv => {
                        // Parsear los datos del CSV
                        const lines = csv.trim().split('\n');
                        const data = lines.slice(1).map(line => {
                            const [caracteristica, coeficiente] = line.split(',');
                            return {
                                Característica: caracteristica,
                                Coeficiente: parseFloat(coeficiente)
                            };
                        });

                        // Obtener las características y coeficientes como arreglos separados
                        const caracteristicas = data.map(item => item.Característica);
                        const coeficientes = data.map(item => item.Coeficiente);
                        // Generar una paleta de colores
                        const palette = Chart.helpers.color;
                        const baseColor = palette('rgba(75, 192, 192, 1)');
                        const backgroundColors = coeficientes.map((item, index) => baseColor.alpha(index * 0.2).rgbString());
                        const borderColors = coeficientes.map((item, index) => baseColor.alpha(1).rgbString());


                        // Configuración del gráfico
                        const config = {
                            type: 'bar',
                            data: {
                                labels: caracteristicas,
                                datasets: [{
                                    label: 'Coeficientes',
                                    data: coeficientes,
                                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                    borderColor: 'rgba(75, 192, 192, 1)',
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        };

                        // Crear el gráfico
                        const ctx = document.getElementById('coeficientesChart').getContext('2d');
                        new Chart(ctx, config);
                    });
            </script>
        </div>
        <div class="widget animate__animated animate__fadeIn">
            <canvas id="metricasBarChart"></canvas>
            <script>
                // Leer el archivo CSV
                fetch('metricasModelo.csv')
                    .then(response => response.text())
                    .then(csv => {
                        // Parsear los datos del CSV
                        const lines = csv.trim().split('\n');
                        const data = lines.slice(1).map(line => {
                            const [metrica, valor] = line.split(',');
                            return {
                                Métrica: metrica,
                                Valor: parseFloat(valor)
                            };
                        });

                        // Obtener las métricas y valores como arreglos separados
                        const metricas = data.map(item => item.Métrica);
                        const valores = data.map(item => item.Valor);

                        // Colores predefinidos para cada métrica
                        const colores = ['rgba(75, 192, 192, 0.8)', 'rgba(255, 99, 132, 0.8)', 'rgba(255, 205, 86, 0.8)', 'rgba(54, 162, 235, 0.8)'];

                        // Configuración del gráfico de barras verticales
                        const config = {
                            type: 'bar',
                            data: {
                                labels: metricas,
                                datasets: [{
                                    label: 'Valor',
                                    data: valores,
                                    backgroundColor: colores,
                                    borderColor: colores,
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        };

                        // Crear el gráfico de barras verticales
                        const ctx = document.getElementById('metricasBarChart').getContext('2d');
                        new Chart(ctx, config);
                    });
            </script>
        </div>
        <div class="explicacion_modelo widget animate__animated animate__fadeIn">
            <?php
            // Imprimir la explicación en la página

            $output = utf8_encode($output);

            echo '<h2>Explanation of the Model</h2>';
            echo '<p>' . nl2br($output) . '</p>'; // El uso de nl2br para mantener los saltos de línea en el texto explicativo

            ?>

        </div>


    </div>
    <div class="contenedor_mas_graficas" id="contenedor_mas_graficas">
        <div class="graf_mas">
            <div class="image-background"></div>
            <p class="ocultar animate__animated animate__fadeIn" id="info1">Esta gráfica muestra la relación entre la Tasa de Falsos Positivos (FPR) y la Tasa de Verdaderos Positivos (TPR) en diferentes umbrales de clasificación. El área bajo la curva (AUC) es una medida de la capacidad del modelo para distinguir entre clases. Cuanto mayor sea el AUC, mejor es el rendimiento del modelo. Una curva que se acerque al rincón superior izquierdo es indicativa de un mejor rendimiento.</p>
            <div class="btn-info_grafica" id="btn1">ℹ️</div>
        </div>
        <div class="graf_mas">
            <div class="image-background3"></div>
            <p class="ocultar animate__animated animate__fadeIn" id="info2">Esta gráfica ilustra la relación entre la precisión y el recall del modelo en diferentes umbrales de clasificación. La precisión mide la proporción de predicciones positivas correctas, mientras que el recall mide la proporción de casos positivos que se identificaron correctamente. El equilibrio entre precisión y recall es importante y puede variar según el problema. Un área más grande bajo la curva representa un mejor rendimiento.</p>
            <div class="btn-info_grafica" id="btn2">ℹ️</div>
        </div>
        <div class="graf_mas">
            <div class="image-background2"></div>
            <p class="ocultar animate__animated animate__fadeIn" id="info3">Esta visualización representa la matriz de confusión del modelo como un mapa de calor. La matriz de confusión muestra la relación entre las predicciones del modelo y las etiquetas reales. Los valores en la diagonal principal (esquina superior izquierda a esquina inferior derecha) representan las clasificaciones correctas. Un mapa de calor ayuda a identificar patrones y desempeño del modelo en diferentes clases.</p>
            <div class="btn-info_grafica" id="btn3">ℹ️</div>
        </div>
        <div class="graf_mas">
            <div class="image-background4"></div>
            <p class="ocultar animate__animated animate__fadeIn" id="info4">En esta gráfica de histograma, se compara la distribución de las etiquetas reales con las predicciones del modelo. Esto permite observar cómo las predicciones del modelo se alinean con las etiquetas reales. Si las barras del histograma coinciden en altura, significa que el modelo está realizando predicciones precisas y equilibradas.</p>
            <div class="btn-info_grafica" id="btn4">ℹ️</div>
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
    <div id="contenedor_aviso_añadirTablaPrediccion" class="overlay ocultar">
        <div class="logout-warning">
            <h2>¡Atención!</h2>
            <p>¿Estás seguro que quieres añadir esta tabla a la visualización de tablas?</p>
            <button id="cancel-buttonTabla">Cancelar</button>
            <button id="confirm-buttonTabla">Añadir</button>
        </div>
    </div>


    <script>
        // Inicializar el sortable en la lista con el ID "sortable-list"
        new Sortable(document.getElementById('dashboard'));
        new Sortable(document.getElementById('contenedor_mas_graficas'));
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/hammerjs"></script>

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