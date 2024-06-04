<?php
session_start();
include 'config.php';

function fetchProducts($conn, $tipo) {
    $stmt = $conn->prepare("SELECT id_producto, nombre, imagen, precio FROM producto WHERE tipo = ?");
    $stmt->bind_param("s", $tipo);
    $stmt->execute();
    return $stmt->get_result();
}

$tocados = fetchProducts($conn, 'tocado');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>L'Atelier Tocados - Tocados</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="<?php echo isset($_SESSION['username']) ? 'logged-in' : ''; ?>">
    <header>
        <div class="top-bar">
            <button class="hamburger">&#9776;</button>
            <nav>
                <ul>
                    <li><a href="inicio.php">Inicio</a></li>
                    <li><a href="pamelas.php">Pamelas</a></li>
                    <li><a href="tocados.php" class="active">Tocados</a></li>
                    <li><a href="diademas.php">Diademas</a></li>
                    <li><a href="contacto.php">Contacto</a></li>
                    <li><a href="blog.php">Blog</a></li>
                    <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin']): ?>
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
    <h2>Tu tienda online de pamelas y tocados para bodas</h2>
    <main id="imagenes">
        <?php while ($producto = $tocados->fetch_assoc()): ?>
            <div class="producto">
                <a href="detalle_producto.php?id=<?php echo $producto['id_producto']; ?>"><img src="<?php echo $producto['imagen']; ?>" alt="<?php echo $producto['nombre']; ?>"></a>
                <p><?php echo $producto['nombre']; ?></p>
                <p>Precio: <?php echo $producto['precio']; ?>€</p>
                <button class="carro" data-precio="<?php echo $producto['precio']; ?>" data-product-id="<?php echo $producto['id_producto']; ?>">Añadir al carrito</button>
            </div>
        <?php endwhile; ?>
    </main>
    <br><br>
    <h2 style="font-size: 2.2em;">Recomendaciones para Utilizar Tocados</h2><br>
    <div class="contenedor-tocados">
        <div class="cuadro-tocado1">
            <h2 class="titulo-tocados">La Elegancia de los Tocados</h2>
            <p class="texto-tocados">Elegir el tocado perfecto es un arte que puede realzar cualquier conjunto y añadir un toque de elegancia y distinción a tu apariencia. Ya sea para una boda, un evento formal o una ocasión especial, los tocados son accesorios versátiles y estilizados que pueden transformar tu look.</p>
        </div>
        <div class="cuadro-tocado1">
            <h2 class="subtitulo-tocados">¿Cuándo llevar un tocado?</h2>
            <p class="texto-tocados">Los tocados son ideales para bodas de mañana y eventos que se celebran antes de las 18:00 horas. Son el complemento perfecto para cualquier atuendo, aportando sofisticación y estilo.</p>
        </div>
        <div class="cuadro-tocado1">
            <h2 class="subtitulo-tocados">Elegir el tamaño adecuado</h2>
            <p class="texto-tocados">El tamaño del tocado debe complementar tu fisionomía. Un tocado demasiado grande puede resultar desproporcionado, mientras que uno demasiado pequeño puede pasar desapercibido. La clave es encontrar el equilibrio adecuado para realzar tus rasgos sin sobrecargarlos.</p>
        </div>
        <div class="cuadro-tocado1">
            <h2 class="subtitulo-tocados">Posicionamiento del tocado</h2>
            <p class="texto-tocados">La colocación del tocado es crucial para conseguir el efecto deseado. Generalmente, se sitúa de manera que el ala caiga hacia el lado derecho, aunque lo más importante es que te sientas cómoda y segura. El peinado también juega un papel importante, ya que debe complementar el estilo y la posición del tocado.</p>
        </div>
        <div class="cuadro-tocado1">
            <h2 class="subtitulo-tocados">Estilo y decoración</h2>
            <p class="texto-tocados">El estilo del tocado debe armonizar con tu vestimenta. Si tu traje es llamativo o voluminoso, opta por un tocado más sencillo y discreto. En cambio, si tu atuendo es más neutro, puedes atreverte con un tocado de alas anchas y adornos vistosos. Los detalles como flores, plumas y lazos pueden añadir un toque único y personalizado a tu look.</p>
        </div>
        <div class="cuadro-tocado1">
            <h2 class="subtitulo-tocados">El color perfecto</h2>
            <p class="texto-tocados">El color del tocado debe complementar tu vestido y el tono de tu piel. Los tonos neutros son versátiles y elegantes, mientras que los colores vibrantes pueden aportar un toque de alegría y frescura a tu apariencia.</p>
        </div>
        <div class="cuadro-tocado1" sytle="margin-bottom:30px;">
            <h2 class="subtitulo-tocados">Conclusión</h2>
            <p class="texto-tocados">En definitiva, los tocados son una excelente manera de destacar y añadir un toque de elegancia a tu atuendo. Al elegir el tocado perfecto, considera la ocasión, tu fisionomía, el peinado y el estilo de tu vestimenta. Con la elección adecuada, un tocado puede ser el complemento perfecto que te hará lucir espectacular.</p>
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
</body>
</html>
