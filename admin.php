<?php
session_start();
$message = isset($_SESSION['message']) ? $_SESSION['message'] : '';
$message_type = isset($_SESSION['message_type']) ? $_SESSION['message_type'] : '';
// Limpiar las variables de sesión para evitar que el mensaje se muestre repetidamente
unset($_SESSION['message']);
unset($_SESSION['message_type']);

// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "latelier1";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener los pedidos que no están marcados como preparados
$sql = "SELECT * FROM pedidos WHERE estado != 'preparado'";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Panel de Administrador</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .pedido {
            border: 1px solid #ccc;
            padding: 20px;
            margin: 10px auto;
            width: 80%;
            text-align: center;
        }
        .pedido form {
            display: inline-block;
        }
        .admin-panel {
            text-align: center;
        }
        label {
            font-size: 1.2em;
            color: #333;
        }

        select {
            width: 20%;
            padding: 10px;
            margin-top: 10px;
            font-size: 1em;
            border-radius: 5px;
            border: 1px solid #ccc;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transition: border-color 0.3s ease;
        }

        select:focus {
            border-color: #007bff;
            outline: none;
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
                        <li><a href="admin.php" class="active">Admin</a></li>
                    <?php endif; ?>
                </ul>
            </nav>

            <div class="user">
                <a href="<?php echo isset($_SESSION['username']) ? 'perfil.php' : 'login.php'; ?>">
                    <img src="imagenes/usuario.png" alt="User Icon" class="user-icon">
                    <span><?php echo isset($_SESSION['username']) ? $_SESSION['username'] : 'Usuario'; ?></span>
                </a>
                <?php if (isset($_SESSION['username'])) : ?>
                    <a href="logout.php">
                        <img src="imagenes/cerrar.png" alt="Logout Icon" class="logout-icon"><span>Salir</span>
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

    <div class="popup" id="popup">
        <button class="close-btn" id="close-popup">X</button>
        <p class="popup-message <?php echo $message_type; ?>" id="popup-message"><?php echo $message; ?></p>
    </div>

    <main class="admin-panel">
        <h1>Panel de Administrador</h1>

        <h2>Añadir productos</h2>
        <form action="add_product.php" method="post" enctype="multipart/form-data">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required>

            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion" name="descripcion" required></textarea>

            <label for="precio">Precio:</label>
            <input type="number" id="precio" name="precio" step="0.01" required>

            <label for="tipo">Tipo:</label>
            <select id="tipo" name="tipo" required>
                <option value="pamela">Pamela</option>
                <option value="tocado">Tocado</option>
                <option value="diadema">Diadema</option>
            </select>

            <label for="imagen">Imagen:</label>
            <input type="file" id="imagen" name="imagen" accept="image/*" required>

            <label for="stock">Stock:</label>
            <input type="number" id="stock" name="stock" required>

            <button type="submit">Añadir Producto</button>
        </form>

        <h2>Eliminar productos</h2>
        <form action="delete_product.php" method="post">
            <label for="id_producto">ID del Producto a Eliminar:</label>
            <input type="number" id="id_producto" name="id_producto" required>

            <button type="submit">Eliminar Producto</button>
        </form>

        <h2>Pedidos Realizados</h2>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='pedido'>";
                echo "<p>ID Pedido: " . $row['id'] . "</p>";
                echo "<p>ID Usuario: " . $row['id_usuario'] . "</p>";
                echo "<p>Dirección de Envío: " . $row['direccion_envio'] . "</p>";
                echo "<p>Método de Pago: " . $row['metodo_pago'] . "</p>";
                echo "<p>Total: " . $row['total'] . "€</p>";
                echo "<p>Fecha: " . $row['fecha'] . "</p>";

                // Obtener los productos del pedido
                $id_pedido = $row['id'];
                $sql_items = "SELECT * FROM pedido_items WHERE id_pedido = $id_pedido";
                $result_items = $conn->query($sql_items);

                if ($result_items->num_rows > 0) {
                    echo "<h3>Productos:</h3>";
                    while ($item = $result_items->fetch_assoc()) {
                        $id_producto = $item['id_producto'];
                        // Asegúrate de que la columna 'id' es la columna correcta en la tabla producto
                        $sql_producto = "SELECT nombre FROM producto WHERE id_producto = $id_producto";
                        $result_producto = $conn->query($sql_producto);
                        $nombre_producto = '';
                        if ($result_producto->num_rows > 0) {
                            $row_producto = $result_producto->fetch_assoc();
                            $nombre_producto = $row_producto['nombre'];
                        }
                        echo "<li>Nombre: " . $nombre_producto . " - ID Producto: " . $item['id_producto'] . " - Cantidad: " . $item['cantidad'] . " - Precio: " . $item['precio'] . "€</li>";
                    }
                } else {
                    echo "<p>No hay productos para este pedido.</p>";
                }

                echo "<form action='mark_order_prepared.php' method='post'>";
                echo "<input type='hidden' name='id_pedido' value='" . $row['id'] . "'>";
                echo "<button type='submit'>Marcar como Preparado</button>";
                echo "</form>";
                echo "</div>";
            }
        } else {
            echo "<p>No hay pedidos.</p>";
        }
        ?>


<!-- Sección para añadir entradas de blog -->
<h2>Añadir Entradas de Blog</h2>
<form action="add_blog_entry.php" method="post" enctype="multipart/form-data">
    <label for="slug">Slug:</label>
    <input type="text" id="slug" name="slug" required>

    <label for="titulo">Título:</label>
    <input type="text" id="titulo" name="titulo" required>

    <label for="contenido">Contenido:</label>
    <textarea id="contenido" name="contenido" required></textarea>

    <label for="autor">Autor:</label>
    <input type="text" id="autor" name="autor" required>

    <label for="fecha_publicacion">Fecha de Publicación:</label>
    <input type="date" id="fecha_publicacion" name="fecha_publicacion" required>

    <label for="imagen">Imagen:</label>
    <input type="file" id="imagen" name="imagen" accept="image/*" required>

    <button type="submit">Añadir Entrada</button>
</form>


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

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var message = "<?php echo $message; ?>";
            if (message) {
                var popup = document.getElementById("popup");
                popup.classList.add("active");

                var closeBtn = document.getElementById("close-popup");
                closeBtn.addEventListener("click", function() {
                    popup.classList.remove("active");
                });
            }
        });
    </script>
</body>
</html>

<?php
$conn->close();
?>

