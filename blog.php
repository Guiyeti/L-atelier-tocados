<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>L'Atelier Tocados - Blog</title>
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
                    <li><a href="blog.php" class="active">Blog</a></li>
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

    <h2>Entradas</h2>

    <div class="blog-container" >
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

        // Consultar todas las entradas del blog
        $sql = "SELECT id, titulo, contenido, autor, fecha_publicacion, slug, imagen_url FROM blog ORDER BY fecha_publicacion DESC";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Salida de cada fila
            while($row = $result->fetch_assoc()) {
                $contenido = explode(' ', $row["contenido"]);
                $contenido_resumido = implode(' ', array_slice($contenido, 0, 20)) . '...';

                echo "<div class='blog-entry'>";
                echo "<a href='entrada.php?slug=" . htmlspecialchars($row["slug"]) . "'>";
                echo "<h3>" . htmlspecialchars($row["titulo"]) . "</h3>";
                if (!empty($row["imagen_url"])) {
                    echo "<img src='" . htmlspecialchars($row["imagen_url"]) . "' alt='" . htmlspecialchars($row["titulo"]) . "'>";
                }
                
                echo "<p>" . nl2br(htmlspecialchars($contenido_resumido)). "<br><br></p>";
                echo "<p><strong>Autor:</strong> " . htmlspecialchars($row["autor"]) . "</p>";
                echo "<p><strong>Fecha de Publicación:</strong> " . htmlspecialchars($row["fecha_publicacion"]) . "</p>";
                echo "</a>";
                echo "</div>";
            }
        } else {
            echo "<p>No hay entradas de blog disponibles.</p>";
        }
        $conn->close();
        ?>
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


