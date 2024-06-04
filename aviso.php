<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aviso Legal - L'Atelier Tocados y Pamelas</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
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

    <main>
        <h1 class="titulo">Aviso Legal</h1>
        <div class="grid-container" style="margin-left: 40px; margin-right: 40px; margin-bottom: 50px; margin-top: 30px;">
            <div class="grid-item">
                <p class="parrafo">Este Aviso Legal regula el uso del sitio web <strong>L'Atelier Tocados y Pamelas</strong>. Al acceder y utilizar nuestro sitio web, usted acepta los términos y condiciones establecidos en este Aviso Legal.</p>
            </div>
            <div class="grid-item">
                <h2 class="titulo">1. Identificación del Responsable</h2>
                <p class="parrafo"><strong>Titular:</strong> L'Atelier Tocados y Pamelas<br>
                <strong>Dirección:</strong> Calle Benito Camelo<br>
                <strong>Correo Electrónico:</strong> tocadoslatelier@gmail.com</p>
            </div>
            <div class="grid-item">
                <h2 class="titulo">2. Propiedad Intelectual</h2>
                <p class="parrafo">Todos los contenidos, incluyendo textos, imágenes, gráficos, logotipos y diseños, son propiedad de L'Atelier Tocados y Pamelas o de sus respectivos propietarios. Está prohibida la reproducción, distribución y comunicación pública de estos contenidos sin autorización expresa.</p>
            </div>
            <div class="grid-item">
                <h2 class="titulo">3. Uso del Sitio Web</h2>
                <p class="parrafo">El usuario se compromete a utilizar el sitio web de manera lícita y respetuosa. No se permite el uso del sitio web para actividades ilegales o que infrinjan los derechos de terceros.</p>
            </div>
            <div class="grid-item">
                <h2 class="titulo">4. Limitación de Responsabilidad</h2>
                <p class="parrafo">L'Atelier Tocados y Pamelas no se hace responsable de los daños y perjuicios que puedan derivarse del uso incorrecto del sitio web o de la falta de disponibilidad temporal del mismo. Tampoco se responsabiliza de los contenidos de los enlaces a terceros que puedan encontrarse en el sitio web.</p>
            </div>
            <div class="grid-item">
                <h2 class="titulo">5. Protección de Datos</h2>
                <p class="parrafo">El tratamiento de datos personales se rige por nuestra Política de Privacidad, que puede consultarse en la página correspondiente de este sitio web.</p>
            </div>
            <div class="grid-item">
                <h2 class="titulo">6. Legislación y Jurisdicción</h2>
                <p class="parrafo">Este Aviso Legal se rige por la legislación española. Para la resolución de cualquier conflicto que pueda surgir del uso del sitio web, las partes se someten a la jurisdicción de los tribunales de [Ciudad/Provincia].</p>
            </div>
            <div class="grid-item">
                <h2 class="titulo">7. Modificaciones del Aviso Legal</h2>
                <p class="parrafo">Nos reservamos el derecho de modificar este Aviso Legal en cualquier momento. Las modificaciones serán publicadas en esta misma página.</p>
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
