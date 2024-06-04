<?php
include 'config.php'; // Asegúrate de tener un archivo config.php para la conexión a la base de datos

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (username, email, password, is_admin) VALUES (?, ?, ?, FALSE)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $username, $email, $password);

    if ($stmt->execute()) {
        session_start();
        $_SESSION['username'] = $username;
        $_SESSION['is_admin'] = false;
        $_SESSION['success_message'] = "Usuario creado con éxito.";
        header("Location: inicio.php");
    } else {
        echo "Error en el registro: " . $stmt->error;
    }
    
}
?>

