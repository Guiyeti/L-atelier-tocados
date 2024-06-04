<?php
session_start();
include 'config.php';

if (isset($_GET['id'])) {
    $id_producto = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM producto WHERE id_producto = ?");
    $stmt->bind_param("i", $id_producto);
    $stmt->execute();
    $producto = $stmt->get_result()->fetch_assoc();
    if (!$producto) {
        header("Location: pamelas.php");
        exit();
    }
} else {
    header("Location: pamelas.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle de Producto - <?php echo htmlspecialchars($producto['nombre']); ?></title>
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
<h2>Detalle del producto</h2>
<main id="detalle-producto">
    <div class="producto-detalle">
    <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin']): ?>
            <p>ID del Producto: <?php echo htmlspecialchars($producto['id_producto']); ?></p>
        <?php endif; ?>
        <img src="<?php echo htmlspecialchars($producto['imagen']); ?>" alt="<?php echo htmlspecialchars($producto['nombre']); ?>">
        <h3><?php echo htmlspecialchars($producto['nombre']); ?></h3>
        <p>Precio: <?php echo htmlspecialchars($producto['precio']); ?>€</p>
        <p><?php echo htmlspecialchars($producto['descripcion']); ?></p>
        <p>Stock: <?php echo htmlspecialchars($producto['stock']); ?></p>

        <label for="cantidad">Cantidad:</label>
        <input type="number" id="cantidad" name="cantidad" value="1" min="1" max="<?php echo htmlspecialchars($producto['stock']); ?>">
        <button class="carro" data-precio="<?php echo htmlspecialchars($producto['precio']); ?>" data-product-id="<?php echo htmlspecialchars($producto['id_producto']); ?>">Añadir al carrito</button>
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
