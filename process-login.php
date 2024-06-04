<?php
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Verifica la contraseña ingresada con la contraseña almacenada en la base de datos
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['username'] = $username;
        $_SESSION['is_admin'] = $user['is_admin'];
        $_SESSION['id_usuario'] = $user['id'];  // Guarda el ID del usuario en la sesión

        if ($_SESSION['is_admin']) {
            header("Location: admin.php");
        } else {
            header("Location: inicio.php");
        }
    } else {
        $_SESSION['error'] = "Nombre de usuario o contraseña incorrectos.";
        header("Location: login.php");
    }
}
?>


