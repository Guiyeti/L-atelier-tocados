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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_pedido = $_POST['id_pedido'];

    // Actualizar el estado del pedido a 'preparado'
    $sql = "UPDATE pedidos SET estado = 'preparado' WHERE id = $id_pedido";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] = "Pedido marcado como preparado.";
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['message'] = "Error al marcar el pedido: " . $conn->error;
        $_SESSION['message_type'] = "error";
    }
}

$conn->close();

header("Location: admin.php");
exit();
?>
