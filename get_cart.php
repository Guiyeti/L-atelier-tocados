<?php
session_start();
include 'config.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

ob_start(); // Inicia la captura de salida

if (!isset($_SESSION['username'])) {
    ob_end_clean(); // Limpia el buffer de salida
    echo json_encode(['success' => false, 'message' => 'Usuario no autenticado']);
    exit;
}

$id_usuario = $_SESSION['id_usuario'];
$sql = "SELECT p.id_producto, p.nombre, p.precio, ci.cantidad
        FROM carrito_items ci
        JOIN producto p ON ci.id_producto = p.id_producto
        WHERE ci.id_carrito = (SELECT id FROM carritos WHERE id_usuario = ?)";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    ob_end_clean(); // Limpia el buffer de salida
    echo json_encode(['success' => false, 'message' => $conn->error]);
    exit;
}
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$result = $stmt->get_result();
$items = $result->fetch_all(MYSQLI_ASSOC);

ob_end_clean(); // Limpia el buffer de salida
echo json_encode(['success' => true, 'items' => $items]);
?>


