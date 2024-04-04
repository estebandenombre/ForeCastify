<?php
if(isset($_POST["submit"])) {
    $targetDir = "uploads/";
    $targetFile = $targetDir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($targetFile,PATHINFO_EXTENSION));

    // Verificar si el archivo es un archivo CSV
    if($fileType != "csv") {
        echo "Solo se permiten archivos CSV.";
        $uploadOk = 0;
    }

    // Verificar si hubo errores en la carga
    if ($uploadOk == 0) {
        echo "El archivo no se ha cargado.";
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile)) {
            echo "El archivo ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " ha sido cargado.";
            header("Location: panel_CSV.php");
            exit();
        } else {
            echo "Hubo un error al cargar el archivo.";
        }
    }
}
?>
