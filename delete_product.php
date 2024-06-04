<?php
session_start();
include 'config.php';

if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_producto = $_POST['id_producto'];

    // Iniciar una transacción
    $conn->begin_transaction();

    try {
        // Eliminar los items relacionados en pedido_items
        $sql_pedido_items = "DELETE FROM pedido_items WHERE id_producto = ?";
        $stmt_pedido_items = $conn->prepare($sql_pedido_items);
        $stmt_pedido_items->bind_param("i", $id_producto);
        $stmt_pedido_items->execute();
        $stmt_pedido_items->close();

        // Eliminar el producto
        $sql_producto = "DELETE FROM producto WHERE id_producto = ?";
        $stmt_producto = $conn->prepare($sql_producto);
        $stmt_producto->bind_param("i", $id_producto);
        $stmt_producto->execute();
        $stmt_producto->close();

        // Confirmar la transacción
        $conn->commit();

        $_SESSION['message'] = "Producto eliminado con éxito";
    } catch (mysqli_sql_exception $exception) {
        // Revertir la transacción en caso de error
        $conn->rollback();

        $_SESSION['message'] = "Error al eliminar el producto: " . $exception->getMessage();
    }

    header("Location: admin.php");
    exit;
}
?>


