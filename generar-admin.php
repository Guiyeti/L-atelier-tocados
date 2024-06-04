<?php
include 'config.php';

$username = 'admin';
$email = 'admin@example.com';
$password = password_hash('1234', PASSWORD_DEFAULT);
$is_admin = 1;

// Verificar si el usuario ya existe
$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "El usuario administrador ya existe.";
} else {
    // Insertar el usuario administrador
    $sql = "INSERT INTO users (username, email, password, is_admin) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $username, $email, $password, $is_admin);

    if ($stmt->execute()) {
        echo "Usuario administrador creado con éxito.";
    } else {
        echo "Error al crear el usuario administrador: " . $stmt->error;
    }
}

$stmt->close();
$conn->close();
?>

