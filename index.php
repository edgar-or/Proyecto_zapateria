<?php
// Iniciar sesión
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="icon" href="imagenes/001-Index/Logos/walker.ico" type="image/x-icon">
    <link rel="stylesheet " href="estilos/estilos-index.css">
    <title>Inicio</title>
</head>

<body>
    <!-- Banner de la pagina -->
    <nav class="navbar bg-body-tertiary">
        <div class="container-fluid fixed-width-container"
            style="background-color: #020304; font-family: 'Franklin Gothic Medium';">
            <a class="navbar-brand" href="#" style="background-color: #020304; color: white; font-size: 50px;">
                <img src="imagenes/001-Index/Logos/Logo.png" alt="Logo" width="90" height="90"
                    class="d-inline-block align-text-center" style="background-color: #CC9E61;">
                THE WALKERS
            </a>
            <ul class="nav nav-tabs" style="margin-top: 4rem; font-size: 20px;">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="index.php">INICIO</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button"
                        aria-expanded="false" style="color: white;">Catálogo</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="catalogo/dama.php">Dama</a></li>
                        <li><a class="dropdown-item" href="catalogo/joven.php">Caballero</a></li>
                        <li><a class="dropdown-item" href="catalogo/niño.php">Niño</a></li>
                        <li><a class="dropdown-item" href="catalogo/niña.php">Niña</a></li>
                        <!--<li><a class="dropdown-item" href="pago/metodo_pago.php">Registrar metodo de pago</a></li>-->

                        <li class="nav-item">
                    <?php if (isset($_SESSION['cod_usuario'])): ?>
                    <a class="dropdown-item" href="pago/metodo_pago.php" >Registrar Metodos de pago</a>
                    <?php else: ?>
                    <a class="dropdown-item" href="login/login.php" >Registrar Metodos de pago</a>
                    <?php endif; ?>
                </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <?php if (isset($_SESSION['cod_usuario'])): ?>
                    <a class="nav-link" href="catalogo/mis_compras.php" style="color: white;">Mis Compras</a>
                    <?php else: ?>
                    <a class="nav-link" href="login/login.php" style="color: white;">Mis Compras</a>
                    <?php endif; ?>
                </li>

               <!-- Modificación para "Mi cuenta" -->
                <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false" style="color: white;">
                    Cuenta: 
                    <?php if (isset($_SESSION['nick_name'])): ?>
                    <?php echo $_SESSION['nick_name']; ?> <!-- Muestra el nick_name del usuario -->
                    <?php else: ?>
                    Invitado <!-- Texto a mostrar si no ha iniciado sesión -->
                    <?php endif; ?>
                </a>
            <ul class="dropdown-menu">
        <?php if (isset($_SESSION['cod_usuario'])): ?>
            <!-- Si ha iniciado sesión -->
            <li><a class="dropdown-item" href="login/cerrar_sesion.php">Cerrar Sesión</a></li>
        <?php else: ?>
            <!-- Si no ha iniciado sesión -->
            <li><a class="dropdown-item" href="login/login.php">Login</a></li>
        <?php endif; ?>
    </ul>
</li>



                <li class="nav-item">
                    <a class="nav-link" href="creditos/creditos.html" style="color: white;">Creditos</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Contenedor fijo -->
    <div class="fixed-width-container">
        <p class="fs-5 text-center"
            style="margin-top: 0px; color: white ;background-color: #6c6c6c; font-family: 'Franklin Gothic Medium', 'cursive';">
            Bienvenido al Inicio</p>

        <!-- Sección de Imagen y Carrusel con Descripción -->
        <div class="container mt-4">
            <div class="row">
                <!-- Columna de la imagen -->
                <div class="col-md-6">
                    <img src="imagenes/001-Index/fondos/fondo-01.jpg" class="img-fluid" alt="Imagen a la izquierda">
                </div>

                <!-- Columna del carrusel -->
                <div class="col-md-6">
                    <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-indicators">
                            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0"
                                class="active" aria-current="true" aria-label="Slide 1"></button>
                            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"
                                aria-label="Slide 2"></button>
                            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2"
                                aria-label="Slide 3"></button>
                        </div>
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="imagenes/001-Index/carrusel/zapas-03.jpg" class="d-block w-100" alt="...">

                                <div class="carousel-caption d-none d-md-block">
                                    <h5 style="color: white; background-color: #020304;">Only in The Walkers</h5>
                                    <p style="color: #020304; background-color: white;">Lleva estilo en Todo Momento.
                                    </p>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <img src="imagenes/001-Index/carrusel/zapas-04.jpg" class="d-block w-100" alt="...">
                                <div class="carousel-caption d-none d-md-block">
                                    <h5 style="color: white; background-color: #020304;">Only in The Walkers</h5>
                                    <p style="color: #020304; background-color: white;">Estilos Elegantes y Atrevidos.
                                    </p>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <img src="imagenes/001-Index/carrusel/zapas-05.jpg" class="d-block w-100" alt="...">
                                <div class="carousel-caption d-none d-md-block">
                                    <h5 style="color: white; background-color: #020304;">Only in The Walkers</h5>
                                    <p style="color: #020304; background-color: white;">Variedades de color, tamaño y
                                        marcas.</p>
                                </div>
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Anterior</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Siguiente</span>
                        </button>
                    </div>
                </div>
            </div>
            <br>
            <hr>
            <!-- Acordion -->
            <div class="container mt-5">
                <div class="accordion" id="accordionExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button bg-dark text-light" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Variedad de Calzados
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <p style="text-align: justify;">
                                <h3 class="text-formal">Zapatos Formales:</h3> Para esos momentos que requieren un toque
                                de elegancia, nuestros zapatos
                                formales son la elección perfecta. Desde clásicos oxford hasta sofisticados mocasines,
                                cada par
                                está diseñado para ofrecer no solo un aspecto impecable, sino también una comodidad
                                excepcional,
                                permitiéndote lucir bien y sentirte genial en cualquier evento o jornada laboral.
                                <br><br>
                                <h3 class="text-sport">Zapatillas Deportivas:</h3> Si eres una persona activa, nuestras
                                zapatillas deportivas están
                                diseñadas para acompañarte en cada paso. Con tecnologías avanzadas en soporte y
                                amortiguación,
                                estas zapatillas son ideales tanto para el gimnasio como para actividades al aire libre.
                                Disponemos de modelos que combinan estilo y funcionalidad, asegurando que siempre
                                llegues a tu
                                destino con confianza y comodidad.
                                <br><br>
                                <h3 class="text-casual">Calzado Casual:</h3> La vida cotidiana merece ser vivida con
                                estilo. En nuestra selección de calzado
                                casual, encontrarás desde cómodas sandalias para los días soleados hasta zapatillas
                                urbanas que
                                se adaptan a cualquier outfit. Cada diseño está pensado para brindarte versatilidad y
                                confort,
                                para que puedas disfrutar al máximo de cada momento.
                                <br><br>
                                <h3 class="text-boots">Botas Para Damas:</h3> Nuestras botas son una explosión de moda y
                                resistencia. Disponemos de modelos que van
                                desde botas de trabajo, ideales para tareas exigentes, hasta botas de moda que
                                complementan
                                cualquier look de temporada. Cada par está fabricado con materiales de alta calidad,
                                garantizando durabilidad sin comprometer el estilo.
                                <br><br>
                                <h3 class="text-kids">Calzado Infantil:</h3> En The Walkers, también pensamos en los más
                                pequeños. Nuestra línea de calzado
                                infantil ofrece modelos divertidos y cómodos, diseñados para acompañar a tus hijos en
                                sus
                                aventuras diarias. Con un enfoque en la seguridad y el confort, cada par asegura que tus
                                niños
                                den pasos firmes y seguros mientras juegan y exploran.
                               </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Galería de imágenes -->
            <div class="container mt-5">
                <div class="row">
                    <!-- Primera fila de 4 imágenes -->
                    <div class="col-md-3 mb-4">
                        <div class="card">
                            <img src="imagenes/001-Index/Galeria/galeria-01.jpg" class="card-img-top gallery-img"
                                alt="Imagen 1">
                            <div class="card-body">
                                <h5 class="card-title">Tenis</h5>
                                <a href="#" class="btn btn-light btn-sm text-white"
                                    style="background-color: #020304;">Ver más</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 mb-4">
                        <div class="card">
                            <img src="imagenes/001-Index/Galeria/galeria-02.jpg" class="card-img-top gallery-img"
                                alt="Imagen 1">
                            <div class="card-body">
                                <h5 class="card-title">Tacones</h5>
                                <a href="#" class="btn btn-light btn-sm text-white"
                                    style="background-color: #020304;">Ver más</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 mb-4">
                        <div class="card">
                            <img src="imagenes/001-Index/Galeria/galeria-03.jpg" class="card-img-top gallery-img"
                                alt="Imagen 1">
                            <div class="card-body">
                                <h5 class="card-title">Converse</h5>
                                <a href="#" class="btn btn-light btn-sm text-white"
                                    style="background-color: #020304;">Ver más</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 mb-4">
                        <div class="card">
                            <img src="imagenes/001-Index/Galeria/galeria-04.jpg" class="card-img-top gallery-img"
                                alt="Imagen 1">
                            <div class="card-body">
                                <h5 class="card-title">Tacones de Colores</h5>
                                <a href="#" class="btn btn-light btn-sm text-white"
                                    style="background-color: #020304;">Ver más</a>
                            </div>
                        </div>
                    </div>

                    <!-- Segunda fila de 4 imágenes -->
                    <div class="col-md-3 mb-4">
                        <div class="card">
                            <img src="imagenes/001-Index/Galeria/galeria-05.jpg" class="card-img-top gallery-img"
                                alt="Imagen 1">
                            <div class="card-body">
                                <h5 class="card-title">Botas</h5>
                                <a href="#" class="btn btn-light btn-sm text-white"
                                    style="background-color: #020304;">Ver más</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 mb-4">
                        <div class="card">
                            <img src="imagenes/001-Index/Galeria/galeria-06.jpg" class="card-img-top gallery-img"
                                alt="Imagen 1">
                            <div class="card-body">
                                <h5 class="card-title">Tenis Deportivos</h5>
                                <a href="#" class="btn btn-light btn-sm text-white"
                                    style="background-color: #020304;">Ver más</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 mb-4">
                        <div class="card">
                            <img src="imagenes/001-Index/Galeria/galeria-07.jpg" class="card-img-top gallery-img"
                                alt="Imagen 1">
                            <div class="card-body">
                                <h5 class="card-title">Converse a Colores</h5>
                                <a href="#" class="btn btn-light btn-sm text-white"
                                    style="background-color: #020304;">Ver más</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 mb-4">
                        <div class="card">
                            <img src="imagenes/001-Index/Galeria/galeria-08.jpg" class="card-img-top gallery-img"
                                alt="Imagen 1">
                            <div class="card-body">
                                <h5 class="card-title">Tenis a Colores</h5>
                                <a href="#" class="btn btn-light btn-sm text-white"
                                    style="background-color: #020304;">Ver más</a>
                            </div>
                        </div>
                    </div>

                    <!-- Descripción al lado del carrusel -->
                    <div class="row mt-3">
                        <div class="col-md-12" style="color: #020304;">
                            <p style="font-family: 'Franklin Gothic Medium', Arial, sans-serif; text-align: justify;">
                                <hr>
                                <center>
                                    <h1>Descubre más Estilos</h1>
                                </center>
                                En The Walkers, creemos que cada paso cuenta. Nuestra pasión por el calzado se refleja
                                en cada par que ofrecemos, fusionando estilo, comodidad y calidad. Desde elegantes
                                zapatos de oficina hasta zapatillas deportivas versátiles, tenemos el calzado perfecto
                                para cada ocasión.
                                <br><br>
                                Nuestro compromiso es brindar a nuestros clientes una experiencia de compra excepcional,
                                con una cuidada selección de marcas y diseños que se adaptan a las últimas tendencias.
                                Ya sea que busques un look casual o algo más formal, en The Walkers encontrarás opciones
                                que se ajustan a tu estilo personal.
                                <br><br>
                                Explora nuestra colección y descubre la comodidad y el diseño que te acompañará en cada
                                paso que des. ¡Tus pies merecen lo mejor!
                            </p>
                        </div>
                    </div>
                    <!-- Api de Google maps -->
                    <div class="container mt-5">
                        <h1 class="text-center">Ubicación de nuestra tienda</h1>
                        <div class="ratio ratio-16x9">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3877.2556017132297!2d-88.79239058971336!3d13.642209786682985!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8f635602561efd9f%3A0xed06dd369e58a638!2sInstituto%20Nacional%20%E2%80%9CDoctor%20Sarbelio%20Navarrete%E2%80%9D!5e0!3m2!1ses-419!2ssv!4v1726507310568!5m2!1ses-419!2ssv"
                                width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer -->
    <footer class="text-white mt-5 p-4 text-center fixed-width-container" style="background-color: #020304;">
        <p style="font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;">© 2024 The Walkers. Todos los derechos reservados.</p>
    </footer>
    <!-- Botón de Volver Arriba -->
    <button class="scroll-to-top" onclick="scrollToTop()">
        <!-- Imagen svg estraida -->
        <svg xmlns="" width="24" height="24" fill="currentColor" class="bi bi-arrow-up"
            viewBox="0 0 16 16">
            <path d="M8 0l3 3H5l3-3zM8 16l-3-3h6l-3 3z" />
        </svg>
    </button>
    <!-- Script de comportamiento del boton -->
    <script src="bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function scrollToTop() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    </script>

</body>

</html>