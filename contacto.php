<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>L'Atelier Tocados</title>
    <link rel="stylesheet" href="style.css">
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            <?php if (isset($_SESSION['message_sent'])) { ?>
                alert('<?php echo $_SESSION['message_sent'] ? 'Mensaje enviado con éxito' : 'Hubo un problema al enviar su consulta. Inténtelo de nuevo más tarde.'; ?>');
                <?php unset($_SESSION['message_sent']); ?>
            <?php } elseif (isset($_SESSION['error_message'])) { ?>
                alert('<?php echo $_SESSION['error_message']; ?>');
                <?php unset($_SESSION['error_message']); ?>
            <?php } ?>
        });
    </script>
</head>

<body >
    <header>
        <div class="top-bar">
            <button class="hamburger">&#9776;</button>
            <nav>
                <ul>
                    <li><a href="inicio.php">Inicio</a></li>
                    <li><a href="pamelas.php">Pamelas</a></li>
                    <li><a href="tocados.php">Tocados</a></li>
                    <li><a href="diademas.php">Diademas</a></li>
                    <li><a href="contacto.php" class="active">Contacto</a></li>
                    <li><a href="blog.php">Blog</a></li>
                    <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin']) : ?>
                        <li><a href="admin.php">Admin</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
            <div class="user">
                <a href="<?php echo isset($_SESSION['username']) ? 'perfil.php' : 'login.php'; ?>">
                    <img src="imagenes/usuario.png" alt="User Icon" class="user-icon">
                    <span><?php echo isset($_SESSION['username']) ? $_SESSION['username'] : 'Usuario'; ?></span>
                </a>
                <?php if (isset($_SESSION['username'])) : ?>
                    <a href="logout.php" class="logout-link">
                        <img src="imagenes/cerrar.png" alt="Logout Icon" class="logout-icon">
                        <span>Salir</span>
                    </a>
                <?php endif; ?>
            </div>
            <a href="perfil.php" class="carrito-enlace">
                <div id="carrito">
                    <span>🛒 Carrito:</span>
                    <span id="contadorCarrito">0</span>
                    <span> | Total:</span>
                    <span id="totalPrecio">0.00 </span>
                </div>
            </a>
        </div>
    </header>
    <div class="logo-bar">
        <div class="logo-container">
            <img src="imagenes/logo.jpg" alt="L'Atelier Logo" id="logo">
            <h1>L'atelier Tocados</h1>
        </div>
        <div class="buscador">
            <form action="buscar.php" method="get">
                <input type="text" id="buscador" name="q" placeholder="Buscar artículos...">
                <button type="submit" id="botonBuscador">Buscar</button>
            </form>
        </div>
    </div>
    <h1 class="contactar">Contactar</h1>
    <h3>Si quiere hacernos alguna pregunta, duda o sugerencia puede contactarnos a través de este formulario:</h3>
    <div class="caja">
        <div class="formulario">
            <form id="formularioConsulta" action="procesar_formulario.php" method="post">
                <label for="nombre">Nombre:</label><br>
                <input type="text" id="nombre" name="nombre" required><br>

                <label for="apellidos">Apellidos:</label><br>
                <input type="text" id="apellidos" name="apellidos"><br>

                <label for="ciudad">Ciudad:</label><br>
                <input type="text" id="ciudad" name="ciudad"><br>

                <label for="telefono">Teléfono:</label><br>
                <input type="text" id="telefono" name="telefono"><br>

                <label for="email">Email:</label><br>
                <input type="text" id="email" name="email"><br>

                <label for="consulta">Consulta:</label><br>
                <textarea id="consulta" name="consulta" rows="4" cols="50"></textarea><br>

                <div class="verificacion">
                    <input type="checkbox" id="acepto">
                    <label for="acepto">He leído y acepto el aviso legal, política de privacidad y protección de datos</label>
                </div>
                <input type="submit" value="Enviar">
            </form>
        </div>

        <div class="informacion">
            <div class="contacto">
                <p class="horario"><span class="subrayado">Horario de atención al cliente:</span><br>
                <h4>Lunes a Viernes: 09:00 a 18:00<br>Sábados: 09:00 a 15:00</h4>
                </p>
            </div>
            <div class="envio">
                <p class="horario"><span class="subrayado">Plazos de envío:</span><br>
                <h4>
                    - Península: 3 a 5 días laborables.<br>
                    - Islas Baleares y Canarias: 6 días laborables.<br>
                    <br>
                    Los plazos de entrega son aproximados y pueden variar dependiendo de las condiciones de transporte y la disponibilidad de los productos. Los envíos se realizan de lunes a viernes, excluyendo días festivos.
                </h4>
                </p>
            </div>
        </div>


    </div>
    
    
<h2>Preguntas Frecuentes</h2>
<div class="faq-container" style="margin-left: 20px; margin-right: 20px;">
    <div class="faq">
        <div class="faq-item">
            <h3>¿Cómo puedo realizar un pedido?</h3>
            <p>Puedes realizar un pedido a través de nuestra tienda online. Simplemente navega por nuestras categorías, selecciona los productos que deseas y sigue las instrucciones para completar tu compra.</p>
        </div>
        
        <div class="faq-item">
            <h3>¿Ofrecen personalización de productos?</h3>
            <p>Sí, ofrecemos personalización en la mayoría de nuestros productos. Puedes contactarnos para discutir tus requisitos específicos y nosotros nos encargaremos de hacer realidad tu visión.</p>
        </div>
        
        <div class="faq-item">
            <h3>¿Cuál es el tiempo de entrega?</h3>
            <p>El tiempo de entrega varía según el producto y la personalización requerida. Normalmente, los pedidos se envían dentro de 3-5 días hábiles. Te mantendremos informado durante todo el proceso.</p>
        </div>
        
        <div class="faq-item">
            <h3>¿Puedo devolver un producto?</h3>
            <p>Sí, aceptamos devoluciones en un plazo de 14 días desde la recepción del producto, siempre que esté en su estado original.</p>
        </div>
    </div>
</div>


    <footer>
        <p><a href="mailto:tocadoslatelier@gmail.com" class="correo-enlace">tocadoslatelier@gmail.com</a></p>
        <div class="redes-sociales">
            <a href="https://instagram.com"> <img src="imagenes/instagram.png"></a>
            <a href="https://facebook.com"><img src="imagenes/facebook.png"></a>
            <a href="https://www.tiktok.com/"><img src="imagenes/tik-tok.png"></a>
        </div>
        <div class="legal">
            <a href="politica.php">Política de privacidad</a><br>
            <a href="aviso.php">Aviso legal</a>
        </div>
    </footer>

    <script src="buscar.js"></script>
    <script>
        document.getElementById('formularioConsulta').addEventListener('submit', function(event) {
            // Obtener valores de los campos
            let consulta = document.getElementById('consulta').value;
            let acepto = document.getElementById('acepto').checked;

            // Verificar si la consulta tiene más de 2 palabras
            let consultaValida = consulta.trim().split(/\s+/).length > 2;

            if (!acepto || !consultaValida) {
                // Si no se cumplen las condiciones, prevenir el envío del formulario
                event.preventDefault();
                alert('Debe aceptar el aviso legal y escribir una consulta de más de dos palabras.');
            }
        });
    </script>

</body>

</html>