<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>L'Atelier Tocados - Entrada del Blog</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .entrada-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .entrada-container h2 {
            text-align: center;
            font-size: 2em;
            margin-bottom: 20px;
        }

        .entrada-container img {
            display: block;
            width: 100%;
            max-width: 1200px; /* Ajusta el valor según tus necesidades */
            height: auto;
            margin: 20px auto;
        }

        .entrada-container p {
            font-size: 1.2em;
            line-height: 1.6;
            margin: 20px 0;
        }

        .entrada-container .meta-info {
            font-size: 0.9em;
            color: #555;
            text-align: center;
            margin-top: 30px;
        }
    </style>
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

    <?php
    // Configuración de la conexión a la base de datos
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "latelier1";

    // Crear conexión
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Obtener el slug de la URL
    $slug = isset($_GET['slug']) ? $_GET['slug'] : '';

    // Verificar que el slug no esté vacío
    if (!empty($slug)) {
        // Consultar la entrada del blog por el slug
        $sql = "SELECT titulo, contenido, autor, fecha_publicacion, imagen_url FROM blog WHERE slug = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $slug);
        $stmt->execute();
        $stmt->bind_result($titulo, $contenido, $autor, $fecha_publicacion, $imagen_url);
        $stmt->fetch();
        $stmt->close();
    }

    // Cerrar conexión
    $conn->close();
    ?>

    <?php if (!empty($titulo) && !empty($contenido)): ?>
    <div class="entrada-container">
        <h2><?php echo htmlspecialchars($titulo); ?></h2>
        <?php if (!empty($imagen_url)): ?>
            <img src="<?php echo htmlspecialchars($imagen_url); ?>" alt="<?php echo htmlspecialchars($titulo); ?>" class="imagen-blog">
        <?php endif; ?>
        <p><?php echo nl2br(htmlspecialchars($contenido)); ?></p>
        <div class="meta-info">
            <p><strong>Autor:</strong> <?php echo htmlspecialchars($autor); ?></p>
            <p><strong>Fecha de Publicación:</strong> <?php echo htmlspecialchars($fecha_publicacion); ?></p>
        </div>
    </div>
    <?php else: ?>
    <div class="entrada-container">
        <p>No se encontró la entrada del blog.</p>
    </div>
    <?php endif; ?>

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

    <div id="cookieConsentContainer">
        <p>Esta web utiliza cookies para mejorar la experiencia del usuario.
            <button id="acceptButton" onclick="acceptCookies()">Aceptar</button>
            <button id="rejectButton" onclick="rejectCookies()">Rechazar</button>
        </p>
    </div>
    <!-- Incluir el archivo de cookies -->
    <script src="cookies.js"></script>
    <script src="buscar.js"></script>

</body>

</html>
