<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>L'Atelier Tocados</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <div class="top-bar">
            <button class="hamburger">&#9776;</button>
            <nav>
                <ul>
                    <li><a href="inicio.php" class="active">Inicio</a></li>
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
    <?php if (isset($_SESSION['success_message'])) : ?>
        <div class="popup active">
            <p class="popup-message"><?php echo $_SESSION['success_message']; ?></p>
            <button class="close-btn" onclick="document.querySelector('.popup').style.display='none';">Cerrar</button>
        </div>
        <?php unset($_SESSION['success_message']); // Elimina el mensaje de la sesión después de mostrarlo 
        ?>
    <?php endif; ?>

    <h2 style="margin-left: 40px; margin-right: 40px;">Tu tienda online de pamelas y tocados para bodas</h2>
    <p id="intro" style="margin-left: 40px; margin-right: 40px;">L'Atelier Tocados se especializa en la creación artesanal de pamelas y tocados,
        ofreciendo piezas únicas y personalizadas para ocasiones especiales como bodas y
        eventos sociales. Cada tocado y pamela es meticulosamente diseñado y confeccionado
        a mano por artesanos expertos, quienes seleccionan cuidadosamente materiales de alta
        calidad para garantizar la exclusividad y elegancia de cada creación. El proceso
        artesanal permite adaptar cada pieza a las preferencias y características del cliente,
        asegurando que cada diseño no solo complemente el atuendo sino que también refleje la
        personalidad y estilo de quien lo lleva. En L'Atelier Tocados, el arte de adornar se
        encuentra con la pasión por el detalle.</p>
    <div class="contenedor">
        <div class="pamela">
            <a href="pamelas.php">
                <img src="imagenes/pamelas.jpg" class="fotosPamela">
            </a>
            <p class="textoPamelas">Pamelas</p>
        </div>

        <div class="tocado">
            <a href="tocados.php">
                <img src="imagenes/tocados.jpg" class="fotosTocado">
            </a>
            <p class="textoTocados">Tocados</p>
        </div>

        <div class="accesorios">
            <a href="diademas.php">
                <img src="imagenes/diadema.jpg" class="fotosAccesorios">
            </a>
            <p class="textoAccesorios">Diademas</p>
        </div>

    </div>

    <hr>
    <br>
    <h2>Historia</h2>

    <div id="descripcion1" class="descripcion-container" >
        <div class="descripcion-flex">
            <div class="descripcion-texto" style="margin-left: 40px; margin-right: 40px;">
                <p>
                    Nuestra empresa comenzó su andadura en 1980 en un pequeño rincón de una tienda de regalos,
                    donde se dispusieron seis canastillas de mimbre repletas de broches para collares y ganchos
                    para pendientes. La idea inicial, motivada por la necesidad de reparar complementos dañados
                    para su posterior uso, no solo fue acogida con entusiasmo, sino que también marcó el inicio
                    de una exitosa trayectoria. La colección inicial creció rápidamente con la incorporación
                    de piezas en cristal y bolas de madera, ampliando su oferta y especialización.
                </p>
                <p>
                    Casi tres décadas después, hemos evolucionado hacia un taller artesanal familiar que se ha
                    ganado un nombre por la calidad y originalidad de sus creaciones. Ahora, nuestro taller no
                    solo repara, sino que también diseña y monta una amplia gama de objetos ornamentales y complementos.
                    Si hay algo que no encuentras en nuestras tiendas, nos encargamos de buscarlo y proporcionarlo,
                    siempre con el objetivo de satisfacer plenamente las necesidades de nuestros clientes.Además
                    de nuestra dedicación al montaje y diseño, somos especialistas en materiales para tocados,
                    incluyendo bases para pamelas y tocados, plumas, y expositores de sombreros. Nuestro catálogo
                    es uno de los más completos del mercado, y ofrece pamelas y tocados elaborados con los precios
                    más competitivos.
                </p>
            </div>
            <img src="imagenes/imagen-inicio.webp" alt="Detalle Artístico" class="descripcion-imagen">
        </div>
        <p class="descripcion-continuacion" style="margin-left: 40px; margin-right: 40px;">
            Además, nos hemos enfocado en expandir nuestra presencia online, permitiendo a clientes
            de todo el mundo acceder y personalizar nuestros exclusivos productos artesanales.
        </p>
        <p class="descripcion-continuacion" style="margin-left: 40px; margin-right: 40px;">
            Este emprendimiento familiar ha crecido gracias a la pasión y el compromiso de cada
            miembro del equipo, cada uno aportando su granito de arena para ofrecer productos excepcionales.
            Estamos orgullosos de nuestro enfoque personalizado, trabajando codo a codo con los clientes
            para garantizar que cada pieza no solo complemente su atuendo, sino que también refleje su
            personalidad y estilo único. En L'Atelier Tocados, combinamos la tradición artesanal con
            innovación constante, buscando siempre superar las expectativas de nuestros clientes y
            mantenernos a la vanguardia en el diseño de complementos.
        </p>
    </div>
    <br><br><br><br>
    <div class="image-row">
        <a href="contacto.php" class="image-container">
            <div>
                <img src="imagenes/contacto.png" alt="Descripción de la imagen 1">
                <p>contacto</p>
            </div>
        </a>
        <a href="perfil.php" class="image-container">
            <div>
                <img src="imagenes/pedido.png" alt="Descripción de la imagen 1">
                <p>pedido</p>
            </div>
        </a>
        <a href="contacto.php" class="image-container">
            <div>
                <img src="imagenes/entrega.png" alt="Descripción de la imagen 3">
                <p>entrega</p>
            </div>
        </a>
    </div>
    <br><br><br>

    <h2>Testimonios de Clientes</h2>
    <div class="main-container" style="margin-left: 40px; margin-right: 40px;">
        <div class="testimonios-container">
            <button class="prev" onclick="prevTestimonio()">&#10094;</button>
            <div class="testimonios-wrapper">
                <div class="testimonios">
                    <div class="testimonio">
                        <img src="imagenes/persona1.jpg" alt="Foto de María López">
                        <p>"Las pamelas de L'Atelier Tocados son simplemente excepcionales. La atención al detalle y la calidad de los materiales son insuperables."</p>
                        <div>- María López</div>
                    </div>
                    <div class="testimonio">
                        <img src="imagenes/persona2.jpg" alt="Foto de Ana García">
                        <p>"Compré un tocado para mi boda y no podría estar más feliz. El diseño era perfecto y se adaptaba maravillosamente a mi vestido."</p>
                        <div>- Ana García</div>
                    </div>
                    <div class="testimonio">
                        <img src="imagenes/persona3.jpg" alt="Foto de Laura Fernández">
                        <p>"El servicio al cliente es fantástico. Me ayudaron a personalizar una diadema para un evento especial y quedó preciosa."</p>
                        <div>- Laura Fernández</div>
                    </div>
                    <div class="testimonio">
                        <img src="imagenes/persona4.jpg" alt="Foto de Carmen Rodríguez">
                        <p>"La variedad de diseños y la creatividad de L'Atelier Tocados me sorprendieron gratamente. Encontré el tocado perfecto para mi evento."</p>
                        <div>- Carmen Rodríguez</div>
                    </div>
                    <div class="testimonio">
                        <img src="imagenes/persona5.jpg" alt="Foto de Claudia Martín">
                        <p>"La calidad y elegancia de estos tocados es inigualable. Los recomiendo totalmente."</p>
                        <div>- Claudia Martín</div>
                    </div>
                    <div class="testimonio">
                        <img src="imagenes/persona6.jpg" alt="Foto de Elena Pérez">
                        <p>"Increíble servicio y productos. Definitivamente volveré para futuras compras."</p>
                        <div>- Elena Pérez</div>
                    </div>
                    <div class="testimonio">
                        <img src="imagenes/persona7.jpg" alt="Foto de David Romero">
                        <p>"Cada tocado es una obra de arte. La atención al cliente fue excepcional y estoy encantado con mi compra."</p>
                        <div>- David Romero</div>
                    </div>
                    <div class="testimonio">
                        <img src="imagenes/persona8.jpg" alt="Foto de Sofía Hernández">
                        <p>"Me sorprendió gratamente la variedad y calidad de los productos. Sin duda, volveré a comprar aquí."</p>
                        <div>- Sofía Hernández</div>
                    </div>
                </div>
            </div>
            <button class="next" onclick="nextTestimonio()">&#10095;</button>
        </div>
    </div>
    <script src="script.js"></script>
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