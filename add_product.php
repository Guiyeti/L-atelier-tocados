<?php
session_start();
include 'config.php';

if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $tipo = $_POST['tipo'];
    $stock = $_POST['stock'];

    // Validar que el stock sea mayor a 0
    if ($stock <= 0) {
        $_SESSION['message'] = "El stock debe ser mayor a 0.";
        header("Location: admin.php");
        exit;
    }

    // Manejo de la carga de la imagen
    $target_dir = "imagenes/";
    $target_file = $target_dir . basename($_FILES["imagen"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Verificar si el archivo es una imagen real o falsa
    $check = getimagesize($_FILES["imagen"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        $uploadOk = 0;
        $_SESSION['message'] = "El archivo no es una imagen.";
    }

    // Verificar si el archivo ya existe
    if (file_exists($target_file)) {
        $_SESSION['message'] = "Lo siento, el archivo ya existe.";
        $uploadOk = 0;
    }

    // Verificar el tamaño del archivo
    if ($_FILES["imagen"]["size"] > 500000) {
        $_SESSION['message'] = "Lo siento, tu archivo es demasiado grande.";
        $uploadOk = 0;
    }

    // Permitir ciertos formatos de archivo
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        $_SESSION['message'] = "Lo siento, solo se permiten archivos JPG, JPEG, PNG y GIF.";
        $uploadOk = 0;
    }

    // Verificar si $uploadOk es 0 debido a un error
    if ($uploadOk == 0) {
        $_SESSION['message'] = "Lo siento, tu archivo no fue subido.";
        // Si todo está bien, intenta subir el archivo
    } else {
        if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $target_file)) {
            // Insertar el producto en la base de datos
            $imagen =  $target_file;
            $sql = "INSERT INTO producto (nombre, descripcion, precio, tipo, imagen, stock) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssdssi", $nombre, $descripcion, $precio, $tipo, $imagen, $stock);

            if ($stmt->execute() && $stmt->affected_rows > 0) {
                $_SESSION['message'] = "Producto añadido con éxito.";
            } else {
                $_SESSION['message'] = "Error al añadir el producto: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $_SESSION['message'] = "Lo siento, hubo un error al subir tu archivo.";
        }
    }
    header("Location: admin.php");
}
