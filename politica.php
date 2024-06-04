<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Política de Privacidad - L'Atelier Tocados y Pamelas</title>
    <link rel="stylesheet" href="style.css">

</head>
<header>
    <div class="top-bar">
        <button class="hamburger">&#9776;</button>
        <nav>
            <ul>
                <li><a href="inicio.php">Inicio</a></li>
                <li><a href="pamelas.php">Pamelas</a></li>
                <li><a href="tocados.php">Tocados</a></li>
                <li><a href="diademas.php">Diademas</a></li>
                <li><a href="contacto.php">Contacto</a></li>
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
<body>
<main >
    <h1 class="titulop">Política de Privacidad</h1>
    <div class="grid-container" style="margin-left: 40px; margin-right: 40px; margin-bottom: 50px; margin-top: 30px;">
        <div class="grid-item">
            <p class="parrafo"><strong>L'Atelier Tocados y Pamelas</strong> está comprometido con proteger su privacidad. Esta política de privacidad explica cómo recopilamos, usamos, divulgamos y protegemos su información personal. Al usar nuestro sitio web, usted acepta los términos de esta política.</p>
        </div>
        <div class="grid-item">
            <h2 class="titulop">1. Información que Recopilamos</h2>
            <p class="parrafo">Recopilamos información personal que usted nos proporciona voluntariamente, como su nombre, dirección de correo electrónico, dirección postal y número de teléfono, cuando realiza un pedido, se suscribe a nuestro boletín o nos contacta a través de nuestros formularios de contacto.</p>
        </div>
        <div class="grid-item">
            <h2 class="titulop">2. Uso de la Información</h2>
            <p class="parrafo">Usamos su información personal para:</p>
            <ul class="parrafo">
                <li>Procesar y gestionar sus pedidos.</li>
                <li>Responder a sus consultas y brindarle asistencia al cliente.</li>
                <li>Enviarle boletines informativos y promociones si ha optado por recibirlos.</li>
                <li>Mejorar nuestro sitio web y servicios.</li>
            </ul>
        </div>
        <div class="grid-item">
            <h2 class="titulop">3. Divulgación de la Información</h2>
            <p class="parrafo">No vendemos, comercializamos ni transferimos su información personal a terceros, excepto cuando sea necesario para proporcionar nuestros servicios (por ejemplo, a empresas de envío) o cuando lo exija la ley.</p>
        </div>
        <div class="grid-item">
            <h2 class="titulop">4. Seguridad de la Información</h2>
            <p class="parrafo">Implementamos medidas de seguridad para proteger su información personal contra accesos no autorizados, alteraciones, divulgaciones o destrucciones.</p>
        </div>
        <div class="grid-item">
            <h2 class="titulop">5. Cookies</h2>
            <p class="parrafo">Usamos cookies para mejorar su experiencia en nuestro sitio web. Las cookies son pequeños archivos de datos que se almacenan en su dispositivo. Puede optar por desactivar las cookies en su navegador, pero esto puede afectar la funcionalidad del sitio web.</p>
        </div>
        <div class="grid-item">
            <h2 class="titulop">6. Enlaces a Terceros</h2>
            <p class="parrafo">Nuestro sitio web puede contener enlaces a sitios web de terceros. No somos responsables de las prácticas de privacidad de estos sitios y le recomendamos leer sus políticas de privacidad.</p>
        </div>
        <div class="grid-item">
            <h2 class="titulop">7. Cambios en la Política de Privacidad</h2>
            <p class="parrafo">Nos reservamos el derecho de actualizar esta política de privacidad en cualquier momento. Publicaremos cualquier cambio en esta página y actualizaremos la fecha de la última modificación.</p>
        </div>
        <div class="grid-item">
            <h2 class="titulop">8. Contacto</h2>
            <p class="parrafo">Si tiene alguna pregunta sobre esta política de privacidad, puede contactarnos a través de nuestro correo electrónico: tocadoslatelier@gmail.com</p>
        </div>
    </div>
</main>

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
</body>
</html>
