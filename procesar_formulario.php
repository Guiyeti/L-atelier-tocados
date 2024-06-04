<?php
// Incluir el autoload de Composer
require __DIR__ . '/vendor/autoload.php';
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Verificar si el usuario está logueado
if (!isset($_SESSION['username'])) {
    $_SESSION['error_message'] = 'Debe estar logueado para enviar una consulta.';
    header('Location: contacto.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = htmlspecialchars($_POST['nombre']);
    $apellidos = htmlspecialchars($_POST['apellidos']);
    $ciudad = htmlspecialchars($_POST['ciudad']);
    $telefono = htmlspecialchars($_POST['telefono']);
    $email = htmlspecialchars($_POST['email']);
    $consulta = htmlspecialchars($_POST['consulta']);

    $mail = new PHPMailer(true);
    try {
        // Configuración del servidor SMTP de Gmail
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'tocadoslatelier@gmail.com'; // Tu correo de Gmail
        $mail->Password = 'b e z j i n p j h r b h p l g p'; // Tu contraseña de aplicación generada
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Configurar remitente y destinatario
        $mail->setFrom($email, $nombre); // Correo y nombre del usuario que envía el formulario
        $mail->addAddress('tocadoslatelier@gmail.com'); // Tu correo donde recibes las consultas

        // Contenido del correo
        $mail->isHTML(false);
        $mail->Subject = 'Nueva Consulta desde L\'Atelier Tocados';
        $mail->Body    = "Nombre: $nombre\nApellidos: $apellidos\nCiudad: $ciudad\nTeléfono: $telefono\nEmail: $email\n\nConsulta:\n$consulta";

        $mail->send();
        $_SESSION['message_sent'] = true;
    } catch (Exception $e) {
        $_SESSION['message_sent'] = false;
    }

    header('Location: contacto.php');
    exit();
}
?>




