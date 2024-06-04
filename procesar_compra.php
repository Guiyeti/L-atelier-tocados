<?php
session_start();
include 'config.php';
require __DIR__ . '/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$response = array('status' => 'error', 'message' => 'Error desconocido.');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_SESSION['user_id'])) {
        $response['message'] = "Error: No hay usuario logueado.";
        echo json_encode($response);
        exit;
    }

    $userId = $_SESSION['user_id'];
    $metodoPago = $_POST['metodo-pago'] ?? '';
    $direccion = $_POST['direccion'] ?? '';

    if (empty($metodoPago) || empty($direccion)) {
        $response['message'] = "Error: Todos los campos son obligatorios.";
        echo json_encode($response);
        exit;
    }

    // Obtener los productos del carrito
    $sql = "SELECT p.id_producto, p.nombre, p.precio, p.imagen, ci.cantidad 
            FROM carrito_items ci 
            JOIN producto p ON ci.id_producto = p.id_producto 
            WHERE ci.id_carrito = (SELECT id FROM carritos WHERE id_usuario = ?)";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        error_log("Error al preparar la consulta de carrito: " . $conn->error);
        $response['message'] = "Error interno del servidor.";
        echo json_encode($response);
        exit;
    }
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $carrito = $stmt->get_result();
    if (!$carrito) {
        error_log("Error al ejecutar la consulta de carrito: " . $stmt->error);
        $response['message'] = "Error interno del servidor.";
        echo json_encode($response);
        exit;
    }

    // Calcular el total
    $total = 0;
    $productos = [];
    while ($item = $carrito->fetch_assoc()) {
        $total += $item['precio'] * $item['cantidad'];
        $productos[] = $item;
    }
    error_log("Total del carrito calculado: $total");

    // Insertar en la tabla de pedidos
    $sqlPedido = "INSERT INTO pedidos (id_usuario, direccion_envio, metodo_pago, total, fecha) VALUES (?, ?, ?, ?, NOW())";
    $stmtPedido = $conn->prepare($sqlPedido);
    if (!$stmtPedido) {
        error_log("Error al preparar la consulta de pedido: " . $conn->error);
        $response['message'] = "Error interno del servidor.";
        echo json_encode($response);
        exit;
    }
    $stmtPedido->bind_param("issd", $userId, $direccion, $metodoPago, $total);
    $stmtPedido->execute();
    if ($stmtPedido->error) {
        error_log("Error al ejecutar la consulta de pedido: " . $stmtPedido->error);
        $response['message'] = "Error interno del servidor.";
        echo json_encode($response);
        exit;
    }
    $pedidoId = $stmtPedido->insert_id;
    error_log("Pedido insertado con ID: $pedidoId");

    // Insertar los items del pedido
    $carrito->data_seek(0); // Resetear el puntero del resultset
    $sqlPedidoItem = "INSERT INTO pedido_items (id_pedido, id_producto, cantidad, precio) VALUES (?, ?, ?, ?)";
    $stmtPedidoItem = $conn->prepare($sqlPedidoItem);
    if (!$stmtPedidoItem) {
        error_log("Error al preparar la consulta de items del pedido: " . $conn->error);
        $response['message'] = "Error interno del servidor.";
        echo json_encode($response);
        exit;
    }
    while ($item = $carrito->fetch_assoc()) {
        $stmtPedidoItem->bind_param("iiid", $pedidoId, $item['id_producto'], $item['cantidad'], $item['precio']);
        $stmtPedidoItem->execute();
        if ($stmtPedidoItem->error) {
            error_log("Error al ejecutar la consulta de items del pedido: " . $stmtPedidoItem->error);
            $response['message'] = "Error interno del servidor.";
            echo json_encode($response);
            exit;
        }
    }
    error_log("Items del pedido insertados correctamente.");

    // Enviar correo electrónico usando PHPMailer
    $sqlUser = "SELECT email FROM users WHERE id = ?";
    $stmtUser = $conn->prepare($sqlUser);
    if (!$stmtUser) {
        error_log("Error al preparar la consulta de usuario: " . $conn->error);
        $response['message'] = "Error interno del servidor.";
        echo json_encode($response);
        exit;
    }
    $stmtUser->bind_param("i", $userId);
    $stmtUser->execute();
    $resultUser = $stmtUser->get_result();
    if (!$resultUser) {
        error_log("Error al ejecutar la consulta de usuario: " . $stmtUser->error);
        $response['message'] = "Error interno del servidor.";
        echo json_encode($response);
        exit;
    }
    $user = $resultUser->fetch_assoc();
    error_log("Correo del usuario obtenido: " . $user['email']);

    // Crear el cuerpo del mensaje del correo electrónico
    $body = 'Gracias por tu compra. Tu pedido ha sido recibido y esta siendo procesado.

    Detalles del pedido:
';

    foreach ($productos as $producto) {
        $body .= "\n- " . $producto['nombre'] . " (Precio: " . $producto['precio'] . " euros, Cantidad: " . $producto['cantidad'] . ")";
    }

    $body .= '
    
    Plazos de envio:
    - Peninsula: 3 a 5 dias laborables.
    - Islas Baleares y Canarias: 6 dias laborables.

    Los plazos de entrega son aproximados y pueden variar dependiendo de las condiciones de transporte y
    la disponibilidad de los productos. Los envios se realizan de lunes a viernes, excluyendo dias festivos.
';

    $mail = new PHPMailer(true);

    try {
        // Configuración del servidor SMTP de Gmail
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'tocadoslatelier@gmail.com'; // Tu correo de Gmail
        $mail->Password = 'b e z j i n p j h r b h p l g p'; // Tu contraseña de aplicación generada
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Asegúrate de usar la constante correcta
        $mail->Port = 587;

        // Configuración del correo
        $mail->setFrom('tocadoslatelier@gmail.com', 'L\'Atelier Tocados');
        $mail->addAddress($user['email']); // Correo del usuario
        $mail->Subject = 'Confirmacion de pedido';
        $mail->Body = $body;

        // Enviar correo
        $mail->send();
        error_log("Correo de confirmación enviado.");
    } catch (Exception $e) {
        error_log("Error al enviar el correo: {$mail->ErrorInfo}");
        $response['message'] = "Error al enviar el correo.";
        echo json_encode($response);
        exit;
    }

    // Limpiar carrito
    $sqlClearCart = "DELETE FROM carrito_items WHERE id_carrito = (SELECT id FROM carritos WHERE id_usuario = ?)";
    $stmtClearCart = $conn->prepare($sqlClearCart);
    if (!$stmtClearCart) {
        error_log("Error al preparar la consulta de limpieza del carrito: " . $conn->error);
        $response['message'] = "Error interno del servidor.";
        echo json_encode($response);
        exit;
    }
    $stmtClearCart->bind_param("i", $userId);
    $stmtClearCart->execute();
    if ($stmtClearCart->error) {
        error_log("Error al ejecutar la consulta de limpieza del carrito: " . $stmtClearCart->error);
        $response['message'] = "Error interno del servidor.";
        echo json_encode($response);
        exit;
    }
    error_log("Carrito limpiado correctamente.");

    $response['status'] = 'success';
    $response['message'] = "Pedido realizado con éxito.";
    echo json_encode($response);
    exit;
}
