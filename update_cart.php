<?php
session_start();
include 'config.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

// Inicia la captura de salida
ob_start();

try {
    if (!isset($_SESSION['username'])) {
        throw new Exception('Usuario no autenticado');
    }

    $id_usuario = $_SESSION['id_usuario'];
    $data = json_decode(file_get_contents('php://input'), true);
    if (!$data) {
        throw new Exception('Datos JSON inválidos');
    }

    $productId = $data['productId'];
    $action = $data['action'];
    $cantidad = isset($data['cantidad']) ? intval($data['cantidad']) : 1;

    // Verificar si el producto existe en la base de datos
    $stmt = $conn->prepare("SELECT 1 FROM producto WHERE id_producto = ?");
    if (!$stmt) {
        throw new Exception($conn->error);
    }
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();
    if (!$result->fetch_assoc()) {
        throw new Exception('Producto no encontrado en la base de datos.');
    }

    $id_carrito = null;
    $sql = "SELECT id FROM carritos WHERE id_usuario = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception($conn->error);
    }
    $stmt->bind_param("i", $id_usuario);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $id_carrito = $row['id'];
    } else {
        $sql = "INSERT INTO carritos (id_usuario) VALUES (?)";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            throw new Exception($conn->error);
        }
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        $id_carrito = $stmt->insert_id;
    }

    if ($action === 'add') {
        $sql = "INSERT INTO carrito_items (id_carrito, id_producto, cantidad) VALUES (?, ?, ?)
                ON DUPLICATE KEY UPDATE cantidad = cantidad + VALUES(cantidad)";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            throw new Exception($conn->error);
        }
        $stmt->bind_param("iii", $id_carrito, $productId, $cantidad);
        $stmt->execute();
    } else if ($action === 'remove') {
        $sql = "DELETE FROM carrito_items WHERE id_carrito = ? AND id_producto = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            throw new Exception($conn->error);
        }
        $stmt->bind_param("ii", $id_carrito, $productId);
        $stmt->execute();
    }

    $sql = "SELECT p.id_producto, p.nombre, p.precio, ci.cantidad
            FROM carrito_items ci
            JOIN producto p ON ci.id_producto = p.id_producto
            WHERE ci.id_carrito = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception($conn->error);
    }
    $stmt->bind_param("i", $id_carrito);
    $stmt->execute();
    $result = $stmt->get_result();
    $items = $result->fetch_all(MYSQLI_ASSOC);

    ob_end_clean(); // Limpia el buffer de salida
    echo json_encode(['success' => true, 'items' => $items]);
} catch (Exception $e) {
    ob_end_clean(); // Limpia el buffer de salida en caso de error
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>






