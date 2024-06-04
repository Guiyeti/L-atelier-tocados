<?php
session_start();
include 'config.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$username = $_SESSION['username'];

// Obtener información del usuario
$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user) {
    // Guardar el ID del usuario en la sesión
    $_SESSION['user_id'] = $user['id'];
}

// Obtener información del carrito
$sql = "SELECT p.id_producto, p.nombre, p.precio, p.imagen, ci.cantidad 
        FROM carrito_items ci 
        JOIN producto p ON ci.id_producto = p.id_producto 
        WHERE ci.id_carrito = (SELECT id FROM carritos WHERE id_usuario = ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user['id']);
$stmt->execute();
$carrito = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Perfil de Usuario</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        #finalizar-compra {
            background-color: #008000;
            color: white;
            border: none;
            border-radius: 20px;
            padding: 8px 13px;
            font-size: 1.1em;
            cursor: pointer;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }

        #finalizar-compra:hover {
            background-color: #006400;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        #finalizar-compra:focus {
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
                    <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin']): ?>
                        <li><a href="admin.php">Admin</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
            <div class="user">
                <a href="perfil.php">
                    <img src="imagenes/usuario.png" alt="User Icon" class="user-icon">
                    <span><?php echo $_SESSION['username']; ?></span>
                </a>
            </div>
            <a href="perfil.php" class="carrito-enlace">
                <div id="carrito">
                    <span>🛒 Carrito:</span>
                    <span id="contadorCarrito">0</span>
                    <span> | Total:</span>
                    <span id="totalPrecio">0.00 </span>
                </div>
            </a>
            <div class="logout-container">
                <?php if (isset($_SESSION['username'])): ?>
                    <a href="logout.php" class="logout-link">
                        <img src="imagenes/cerrar.png" alt="Logout Icon" class="logout-icon">
                        <span>Salir</span>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <main class="perfil-panel">
        <h1>Perfil de Usuario</h1><br><br>
        <div class="perfil-info">
            <p>Nombre de usuario: <?php echo htmlspecialchars($user['username'], ENT_QUOTES, 'UTF-8'); ?></p>
            <p>Email: <?php echo htmlspecialchars($user['email'], ENT_QUOTES, 'UTF-8'); ?></p>
        </div>
        <div class="carrito-info">
            <h2>Carrito de Compras</h2>
            <?php if ($carrito->num_rows > 0): ?>
                <ul id="carrito-lista">
                    <?php
                    $total = 0;
                    while($item = $carrito->fetch_assoc()): 
                        $total += $item['precio'] * $item['cantidad'];
                    ?>
                        <li>
                            <a href="detalle_producto.php?id=<?php echo $item['id_producto']; ?>">
                                <img src="<?php echo htmlspecialchars($item['imagen'], ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($item['nombre'], ENT_QUOTES, 'UTF-8'); ?>">
                                <?php echo htmlspecialchars($item['nombre'], ENT_QUOTES, 'UTF-8'); ?> 
                                - <?php echo number_format($item['precio'], 2); ?>€
                                <span>x <?php echo $item['cantidad']; ?></span>
                            </a>
                        </li>
                    <?php endwhile; ?>
                </ul>
                <div id="total-finalizar">
                    <span id="total">Total: <span id="total-amount"><?php echo number_format($total, 2); ?></span>€  </span>
                    <br>
                    <button id="finalizar-compra">Finalizar compra</button>
                </div>
            <?php else: ?>
                <p>Tu carrito está vacío.</p>
            <?php endif; ?>
        </div>
        <div id="form-finalizar-compra" style="display: none;">
            <h3>Datos de Pago</h3>
            <form id="pago-form" action="procesar_compra.php" method="post">
                <label for="metodo-pago">Forma de Pago:</label>
                <select id="metodo-pago" name="metodo-pago" required>
                    <option value="tarjeta">Tarjeta de Crédito/Débito</option>
                    <option value="paypal">PayPal</option>
                </select>
                <br>
                <label for="direccion">Dirección de Envío:</label>
                <input type="text" id="direccion" name="direccion" required>
                <br>
                <input type="submit" value="Confirmar Compra">
            </form>
        </div>
    </main>

    <footer>
        <p><a href="mailto:tocadoslatelier@gmail.com" class="correo-enlace">tocadoslatelier@gmail.com</a></p>
        <div class="redes-sociales">
            <a href="https://instagram.com"><img src="imagenes/instagram.png"></a>
            <a href="https://facebook.com"><img src="imagenes/facebook.png"></a>
            <a href="https://www.tiktok.com/"><img src="imagenes/tik-tok.png"></a>
        </div>
        <div class="legal">
            <a href="politica.php">Política de privacidad</a><br>
            <a href="aviso.php">Aviso legal</a>
        </div>
    </footer>
    <script src="buscar.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Calcular el total del carrito
        const totalAmount = <?php echo $total; ?>;
        document.getElementById('total-amount').innerText = totalAmount.toFixed(2);

        // Mostrar el formulario de finalizar compra al hacer clic en el botón
        document.getElementById('finalizar-compra').addEventListener('click', function() {
            document.getElementById('form-finalizar-compra').style.display = 'block';
        });

        // Manejar el envío del formulario con AJAX
        document.getElementById('pago-form').addEventListener('submit', function(event) {
            event.preventDefault();
            var formData = new FormData(this);
            
            fetch('procesar_compra.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                if (data.status === 'success') {
                    document.getElementById('carrito-lista').innerHTML = '';
                    document.getElementById('total-finalizar').style.display = 'none';
                    document.getElementById('form-finalizar-compra').style.display = 'none';
                    document.getElementById('contadorCarrito').innerText = '0';
                    document.getElementById('totalPrecio').innerText = '0.00 €';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Ocurrió un error al procesar la compra.');
            });
        });
    });
    </script>
</body>
</html>




