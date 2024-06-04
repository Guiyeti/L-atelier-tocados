<?php
session_start();
include 'config.php';

function buscarProductos($conn, $query) {
    $sql = "SELECT id_producto, nombre, imagen, precio FROM producto WHERE LOWER(nombre) LIKE ?";
    $stmt = $conn->prepare($sql);
    $likeQuery = '%' . strtolower($query) . '%';
    $stmt->bind_param('s', $likeQuery);
    $stmt->execute();
    return $stmt->get_result();
}

$query = isset($_GET['q']) ? $_GET['q'] : '';
$productos = buscarProductos($conn, $query);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultados de búsqueda</title>
    <link rel="stylesheet" href="buscar-estilos.css">
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
            <div id="carrito">
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
                <input type="text" id="buscador" name="q" placeholder="Buscar artículos..." value="<?php echo htmlspecialchars($query); ?>">
                <button type="submit" id="botonBuscador">Buscar</button>
            </form>
        </div>
    </div>
    <br><br><br>
    <main>
    <h1 style="margin-left: 20px;" >Resultados de Búsqueda</h1>
    <div id="resultados">
    <?php if ($productos->num_rows > 0): ?>
        <?php while ($producto = $productos->fetch_assoc()): ?>
            <div class="producto">
                <a href="detalle_producto.php?id=<?php echo $producto['id_producto']; ?>">
                    <img src="<?php echo $producto['imagen']; ?>" alt="<?php echo $producto['nombre']; ?>">
                </a>
                <p><?php echo $producto['nombre']; ?></p>
                <p>Precio: <?php echo $producto['precio']; ?>€</p>
                <button class="carro" data-precio="<?php echo $producto['precio']; ?>" data-product-id="<?php echo $producto['id_producto']; ?>">Añadir al carrito</button>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No se encontraron productos que coincidan con la búsqueda.</p>
    <?php endif; ?>
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


