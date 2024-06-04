<?php
session_start();

// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "latelier1";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar que se han enviado los datos del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $slug = $_POST['slug'];
    $titulo = $_POST['titulo'];
    $contenido = $_POST['contenido'];
    $autor = $_POST['autor'];
    $fecha_publicacion = $_POST['fecha_publicacion'];

    // Manejo de la carga de la imagen
    $target_dir = "imagenes/";
    $target_file = $target_dir . basename($_FILES["imagen"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Verificar si el archivo es una imagen real
    $check = getimagesize($_FILES["imagen"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        $uploadOk = 0;
        $_SESSION['message'] = "El archivo no es una imagen.";
        $_SESSION['message_type'] = "error";
    }

    // Verificar si el archivo ya existe
    if (file_exists($target_file)) {
        $uploadOk = 0;
        $_SESSION['message'] = "Lo sentimos, el archivo ya existe.";
        $_SESSION['message_type'] = "error";
    }

    // Verificar el tamaño del archivo
    if ($_FILES["imagen"]["size"] > 5000000) { // 5MB máximo
        $uploadOk = 0;
        $_SESSION['message'] = "Lo sentimos, el archivo es demasiado grande.";
        $_SESSION['message_type'] = "error";
    }

    // Permitir solo ciertos formatos de archivo
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
        $uploadOk = 0;
        $_SESSION['message'] = "Lo sentimos, solo se permiten archivos JPG, JPEG, PNG y GIF.";
        $_SESSION['message_type'] = "error";
    }

    // Verificar si $uploadOk está configurado a 0 por un error
    if ($uploadOk == 0) {
        // Si hay un error, redirigir de vuelta al panel de administración
        header("Location: admin.php");
        exit();
    // Si todo está bien, intentar subir el archivo
    } else {
        if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $target_file)) {
            $imagen_url = $target_file;
            // Insertar la nueva entrada en la base de datos
            $sql = "INSERT INTO blog (slug, titulo, contenido, autor, fecha_publicacion, imagen_url) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssss", $slug, $titulo, $contenido, $autor, $fecha_publicacion, $imagen_url);

            if ($stmt->execute()) {
                $_SESSION['message'] = "Entrada de blog añadida exitosamente";
                $_SESSION['message_type'] = "success";
            } else {
                $_SESSION['message'] = "Error al añadir la entrada: " . $stmt->error;
                $_SESSION['message_type'] = "error";
            }

            $stmt->close();
        } else {
            $_SESSION['message'] = "Lo sentimos, hubo un error al subir tu archivo.";
            $_SESSION['message_type'] = "error";
        }
    }

    $conn->close();

    // Redirigir de vuelta al panel de administración
    header("Location: admin.php");
    exit();
}
?>
