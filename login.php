<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
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
                </ul>
            </nav>
    
            <div class="user">
                <a href="login.php">
                    <img src="imagenes/usuario.png" alt="User Icon" class="user-icon">
                    <span>Usuario</span>
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
        </div>
    </header>
    
    <div class="logo-bar">
        <div class="logo-container">
            <img src="imagenes/logo.jpg" alt="L'Atelier Logo" id="logo">
            <h1>L'atier Tocados</h1>
        </div>
        <div class="buscador">
            <form action="buscar.php" method="get">
                <input type="text" id="buscador" name="q" placeholder="Buscar artículos...">
                <button type="submit" id="botonBuscador">Buscar</button>
            </form>
        </div>
    </div>
    <main>
        <h2>Iniciar Sesión</h2>
        <?php
        session_start();
        if (isset($_SESSION['error'])) {
            echo "<p style='color:red;'>" . $_SESSION['error'] . "</p>";
            unset($_SESSION['error']);
        }
        ?>
<form action="process-login.php" method="post" style="display: flex; flex-direction: column; align-items: center; margin: 40px auto; padding: 20px; border: 1px solid #ccc; border-radius: 10px; max-width: 400px; background-color: #f9f9f9;">
    <label for="username" style="width: 100%; margin-bottom: 15px;">Nombre de usuario:</label>
    <input type="text" id="username" name="username" required style="width: 100%; margin-bottom: 15px;">
    
    <label for="password" style="width: 100%; margin-bottom: 15px;">Contraseña:</label>
    <input type="password" id="password" name="password" required style="width: 100%; margin-bottom: 15px;">
    
    <button type="submit" style="width: 100%; padding: 10px; background-color: #1b641b; color: white; border: none; border-radius: 5px; cursor: pointer;">Iniciar Sesión</button>
</form>
<p style="text-align: center; margin-top: 20px; margin-bottom: 20px;">¿No tienes una cuenta? <a href="register.html" style="color: blue; text-decoration: none;">Regístrate aquí</a></p>


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
