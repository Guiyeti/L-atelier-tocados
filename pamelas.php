<?php
session_start();
include 'config.php';

function fetchProducts($conn, $tipo)
{
    $stmt = $conn->prepare("SELECT id_producto, nombre, imagen, precio FROM producto WHERE tipo = ?");
    $stmt->bind_param("s", $tipo);
    $stmt->execute();
    return $stmt->get_result();
}

$pamelas = fetchProducts($conn, 'pamela');
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>L'Atelier Tocados - Pamelas</title>
    <link rel="stylesheet" href="style.css">
</head>

<body class="<?php echo isset($_SESSION['username']) ? 'logged-in' : ''; ?>">
    <header>
        <div class="top-bar">
            <button class="hamburger">&#9776;</button>
            <nav>
                <ul>
                    <li><a href="inicio.php">Inicio</a></li>
                    <li><a href="pamelas.php" class="active">Pamelas</a></li>
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
    <h2>Tu tienda online de pamelas y tocados para bodas</h2>
    <main id="imagenes">
        <?php while ($producto = $pamelas->fetch_assoc()) : ?>
            <div class="producto">
                <a href="detalle_producto.php?id=<?php echo $producto['id_producto']; ?>"><img src="<?php echo $producto['imagen']; ?>" alt="<?php echo $producto['nombre']; ?>"></a>
                <p><?php echo $producto['nombre']; ?></p>
                <p>Precio: <?php echo $producto['precio']; ?>€</p>
                <button class="carro" data-precio="<?php echo $producto['precio']; ?>" data-product-id="<?php echo $producto['id_producto']; ?>">Añadir al carrito</button>
            </div>
        <?php endwhile; ?>
    </main>
    <p>
    <h2 class="titulo-pamela" style="margin-left: 40px; margin-right: 40px;">Tips para comprar la pamela perfecta</h2>
    <ul class="estilo-pamela" style="margin-left: 40px; margin-right: 40px;">
        <li><strong>1. ¿Cuándo optar por lucir una pamela para boda?</strong> Siempre en bodas de mañana, no más tarde de las 18:00 horas.</li>
        <li><strong>2. ¿Qué tamaño de pamela elegir?</strong> El tamaño de la copa se escoge según tu fisionomía, sin exceder el ancho de tus hombros.</li>
        <li><strong>3. ¿Dónde colocarla?</strong> Según el lado donde vayas a recogerte el pelo, por lo general, la pamela suele colocarse de modo que el ala caiga en el lado derecho. A fin de cuentas, donde te sientas más cómoda y espectacular.</li>
        <li><strong>4. ¿Qué estilo elegir?</strong> Si tu traje es muy llamativo o voluminoso te recomendamos evitar las pamelas o sombreros muy grandes o con muchos adornos. Por otro lado, si tu vestimenta es más neutral, las alas anchas y los adornos vistosos y variados serán tu mejor aliado.</li>
    </ul>
    <br><br>
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