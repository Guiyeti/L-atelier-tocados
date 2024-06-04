<?php
session_start();
include 'config.php';

function fetchProducts($conn, $tipo) {
    $stmt = $conn->prepare("SELECT id_producto, nombre, imagen, precio FROM producto WHERE tipo = ?");
    $stmt->bind_param("s", $tipo);
    $stmt->execute();
    return $stmt->get_result();
}

$diademas = fetchProducts($conn, 'diadema');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>L'Atelier Tocados - Diademas</title>
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
                    <li><a href="tocados.php">Tocados</a></li>
                    <li><a href="diademas.php" class="active">Diademas</a></li>
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
        <?php while ($producto = $diademas->fetch_assoc()): ?>
            <div class="producto">
                <a href="detalle_producto.php?id=<?php echo $producto['id_producto']; ?>"><img src="<?php echo $producto['imagen']; ?>" alt="<?php echo $producto['nombre']; ?>"></a>
                <p><?php echo $producto['nombre']; ?></p>
                <p>Precio: <?php echo $producto['precio']; ?>€</p>
                <button class="carro" data-precio="<?php echo $producto['precio']; ?>" data-product-id="<?php echo $producto['id_producto']; ?>">Añadir al carrito</button>
            </div>
        <?php endwhile; ?>
    </main>
    <div class="contenedor-consejos">
    <h2>Consejos para Usar Diademas</h2>
    <div class="cuadro-consejo">
        <h3 class="titulo-consejo">1. Combina con tu Peinado</h3>
        <p class="texto-consejo">Una diadema puede ser el complemento perfecto para cualquier peinado. Ya sea con el cabello suelto, una coleta o un moño, una diadema adecuada puede resaltar tu estilo.</p>
    </div>
    <div class="cuadro-consejo">
        <h3 class="titulo-consejo">2. Juega con los Colores</h3>
        <p class="texto-consejo">Elige diademas que contrasten o complementen los colores de tu atuendo. Un toque de color puede hacer que tu look destaque.</p>
    </div>
    <div class="cuadro-consejo">
        <h3 class="titulo-consejo">3. Diademas en Eventos Especiales</h3>
        <p class="texto-consejo">Las diademas no son solo para el día a día. Úsalas en bodas, fiestas o eventos formales para añadir un toque de elegancia y sofisticación.</p>
    </div>
    <div class="cuadro-consejo">
        <h3 class="titulo-consejo">4. Estilos Minimalistas</h3>
        <p class="texto-consejo">A veces, menos es más. Una diadema simple y elegante puede ser el accesorio perfecto para un look limpio y sofisticado.</p>
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

