

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="icon" href="../imagenes/001-Index/Logos/walker.ico" type="image/x-icon">
    <link rel="stylesheet" href="../estilos/estilos-index.css">
    <title>Inicio</title>
    <style>
        @keyframes rainbow {
            0% {
                background: red;
            }

            14% {
                background: orange;
            }

            28% {
                background: yellow;
            }

            42% {
                background: green;
            }

            57% {
                background: blue;
            }

            71% {
                background: indigo;
            }

            85% {
                background: violet;
            }

            100% {
                background: red;
            }
        }

        .rainbow-background {
            animation: rainbow 5s linear infinite;
            color: white;
            font-family: 'Franklin Gothic Medium', 'cursive';
            margin-top: 0px;
            text-align: center;
        }
    </style>
</head>

<body>
<?php
session_start(); // Inicia la sesión
// Verifica si el usuario ha iniciado sesión y es administrador
if (!isset($_SESSION['cod_usuario']) || $_SESSION['tipo_usuario'] !== 'admin') {
    // Si no ha iniciado sesión o no es admin, redirigir al index.php
    header("Location: ../../login/login.php");
    exit();
}
?>
    <!-- Banner de la pagina -->
    <nav class="navbar bg-body-tertiary">
        <div class="container-fluid fixed-width-container"
            style="background-color: #020304; font-family: 'Franklin Gothic Medium';">
            <a class="navbar-brand" href="#" style="background-color: #020304; color: white; font-size: 50px;">
                <img src="../imagenes/001-Index/Logos/Logo.png" alt="Logo" width="90" height="90"
                    class="d-inline-block align-text-center" style="background-color: #CC9E61;">
                THE WALKERS
            </a>
            <ul class="nav nav-tabs" style="margin-top: 4rem; font-size: 20px;">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="index.html">INICIO</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button"
                        aria-expanded="false" style="color: white;">Catálogo</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="../catalogo/dama.php">Dama</a></li>
                        <li><a class="dropdown-item" href="../catalogo/joven.php">Caballero</a></li>
                        <li><a class="dropdown-item" href="../catalogo/niño.php">Niño</a></li>
                        <li><a class="dropdown-item" href="../catalogo/niña.php">Niña</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../ventas.php" style="color: white;">Ventas</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button"
                        aria-expanded="false" style="color: white;">Cuenta</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="../../login/login.php">Login</a></li>
                        <li><a class="dropdown-item" href="../../login/login.php">Cerrar Sesion</a></li>
                        <li><a class="dropdown-item" href="#">Mi cuenta</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button"
                        aria-expanded="false" style="color: white;">Productos</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="../admin/CRUD_PRODUCTOS/registrar_producto.php">Registrar
                                Producto</a></li>
                        <li><a class="dropdown-item" href="../admin/CRUD_PRODUCTOS/consultar_producto.php">Consultar
                                Producto</a></li>
                        <li><a class="dropdown-item" href="../admin/CRUD_PRODUCTOS/modificar_producto.php">Modificar
                                Producto</a></li>
                        <li><a class="dropdown-item" href="../admin/CRUD_PRODUCTOS/eliminar_producto.php">Eliminar
                                Producto</a></li>
                        <li><a class="dropdown-item" href="../admin/CRUD_PRODUCTOS/registrar_inventario.php">Registrar
                                Inventario</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button"
                        aria-expanded="false" style="color: white;">Usuarios</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="../admin/CRUD_USUARIOS/registrar_usuarios.php">Registrar
                                Usuario</a></li>
                        <li><a class="dropdown-item" href="../admin/CRUD_USUARIOS/consultar_usuarios.php">Consultar
                                Usuario</a></li>
                        <li><a class="dropdown-item" href="../admin/CRUD_USUARIOS/modificar_usuarios.php">Modificar
                                Usuario</a></li>
                        <li><a class="dropdown-item" href="../admin/CRUD_USUARIOS/eliminar_usuarios.php">Eliminar
                                Usuario</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../creditos/creditos.html" style="color: white;">Creditos</a>
                </li>
            </ul>
        </div>
    </nav>
    <!-- Contenedor fijo -->
    <p class="fs-5 rainbow-background">
        Modo privilegiado, Bienvenido Administrador
    </p>

    <!-- Contenido Principal -->
    <div class="container my-5">
        <!-- Instrucciones de Uso -->
        <div class="my-5">
            <h2 class="text-center">Instrucciones de Uso</h2>
            <p class="text-center">Este sitio está dedicado a los administradores. A continuación, se detallan las
                instrucciones para gestionar los CRUD de usuarios y productos:</p>
            <div class="accordion" id="instructionsAccordion">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            CRUD de Productos
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                        data-bs-parent="#instructionsAccordion">
                        <div class="accordion-body">
                            <ul>
                                <li><strong>Registrar Producto:</strong>
                                    <p>Para agregar un nuevo producto al sistema, dirígete a la sección "Registrar
                                        Producto". En esta página, encontrarás un formulario que debes completar con la
                                        información esencial del nuevo producto. Asegúrate de ingresar el nombre del
                                        producto, una descripción detallada que incluya características, materiales y
                                        beneficios, el precio de venta y seleccionar la categoría adecuada (por ejemplo,
                                        Dama, Caballero, Niño, etc.). También tendrás la opción de subir una imagen que
                                        represente el producto. Es fundamental que verifiques que todos los campos
                                        obligatorios estén completos y que la información sea precisa antes de hacer
                                        clic en "Guardar". Si el registro es exitoso, recibirás una notificación
                                        confirmando que el producto se ha añadido a la base de datos.</p>
                                </li>
                                <li><strong>Consultar Producto:</strong>
                                    <p>En la sección "Consultar Producto", podrás visualizar una lista de todos los
                                        productos registrados en el sistema. Esta lista incluye columnas con información
                                        básica como el nombre del producto, precio y disponibilidad. Puedes utilizar
                                        filtros para buscar productos específicos basados en su nombre, categoría o
                                        precio. Al seleccionar un producto de la lista, se abrirá una página que
                                        mostrará todos los detalles, incluyendo la descripción completa, precio,
                                        cantidad en stock y cualquier otra información relevante. Esto te permitirá
                                        tener un panorama claro de lo que está disponible en el inventario.</p>
                                </li>
                                <li><strong>Modificar Producto:</strong>
                                    <p>Si necesitas actualizar la información de un producto existente, dirígete a la
                                        sección "Modificar Producto". Allí, puedes buscar el producto que deseas editar
                                        utilizando los filtros disponibles. Una vez que hayas localizado el producto,
                                        haz clic en el botón de editar. Podrás actualizar cualquier campo necesario,
                                        como el precio, la descripción o la imagen del producto. Después de realizar los
                                        cambios, asegúrate de guardar la información para que se reflejen en la base de
                                        datos. Es recomendable revisar nuevamente los datos ingresados para evitar
                                        errores antes de confirmar la modificación.</p>
                                </li>
                                <li><strong>Eliminar Producto:</strong>
                                    <p>Para eliminar un producto que ya no se necesita, ve a la sección "Eliminar
                                        Producto". Aquí, podrás buscar el producto que deseas eliminar utilizando los
                                        filtros. Una vez que lo hayas encontrado, selecciona el producto y se te
                                        presentará la opción de eliminarlo. Recuerda que esta acción es irreversible;
                                        asegúrate de que deseas eliminar el producto de forma permanente antes de
                                        proceder.</p>
                                </li>
                                <li><strong>Registrar Inventario:</strong>
                                    <p>La sección "Registrar Inventario" te permite añadir o ajustar la cantidad de
                                        productos disponibles en stock. Es importante mantener actualizada la cantidad
                                        de inventario para gestionar las ventas y reposiciones de manera efectiva.
                                        Selecciona el producto al que deseas modificar el inventario y especifica la
                                        nueva cantidad que deseas registrar. También puedes optar por incrementar o
                                        reducir la cantidad en función de las ventas recientes o las nuevas
                                        adquisiciones. Después de ingresar la nueva cantidad, guarda los cambios para
                                        que se reflejen en el sistema.</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            CRUD de Usuarios
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                        data-bs-parent="#instructionsAccordion">
                        <div class="accordion-body">
                            <ul>
                                <li><strong>Registrar Usuario:</strong>
                                    <p>Para añadir un nuevo usuario al sistema, accede a la sección "Registrar Usuario".
                                        Aquí encontrarás un formulario que debes completar con información detallada del
                                        nuevo usuario, incluyendo su nombre completo, dirección de correo electrónico,
                                        una contraseña segura y el rol que tendrá (administrador o usuario regular). Es
                                        crucial que el correo electrónico ingresado sea único y válido, ya que se
                                        utilizará para la comunicación y la recuperación de contraseñas. Una vez que
                                        hayas llenado todos los campos requeridos, haz clic en "Registrar". Si la
                                        operación es exitosa, recibirás una notificación que confirmará que el usuario
                                        ha sido añadido al sistema.</p>
                                </li>
                                <li><strong>Consultar Usuario:</strong>
                                    <p>En la sección "Consultar Usuario", podrás acceder a una lista completa de todos
                                        los usuarios registrados en el sistema. Esta lista proporciona información
                                        básica como nombre, correo electrónico y rol del usuario. Puedes aplicar filtros
                                        para buscar usuarios específicos por nombre o correo electrónico. Al seleccionar
                                        un usuario de la lista, se abrirá una página que mostrará información detallada,
                                        incluyendo su historial de actividad en el sitio, lo cual es útil para
                                        monitorear el uso del sistema y el comportamiento de los usuarios.</p>
                                </li>
                                <li><strong>Modificar Usuario:</strong>
                                    <p>Si es necesario realizar cambios en la información de un usuario existente, ve a
                                        la sección "Modificar Usuario". Aquí, podrás buscar el usuario que deseas editar
                                        utilizando los filtros disponibles. Al seleccionar el usuario, haz clic en el
                                        botón de editar. Podrás actualizar campos como el nombre, correo electrónico,
                                        contraseña y rol. Asegúrate de que cualquier cambio que realices sea necesario y
                                        que los datos sean correctos. Después de modificar la información, guarda los
                                        cambios para que se apliquen en la base de datos. Mantener la información
                                        actualizada es vital para la seguridad y el buen funcionamiento del sistema.</p>
                                </li>
                                <li><strong>Eliminar Usuario:</strong>
                                    <p>Para eliminar un usuario que ya no debe tener acceso al sistema, dirígete a la
                                        sección "Eliminar Usuario". Busca al usuario que deseas eliminar. Una vez que lo
                                        hayas encontrado, selecciona el usuario.</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer -->
    <footer class="text-white mt-5 p-4 text-center fixed-width-container" style="background-color: #020304;">
        <p style="font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;">© 2024 The Walkers. Todos
            los derechos reservados.</p>
    </footer>

    <!-- Botón de Volver Arriba -->
    <button class="scroll-to-top" onclick="scrollToTop()">
        <svg xmlns="" width="24" height="24" fill="currentColor" class="bi bi-arrow-up" viewBox="0 0 16 16">
            <path d="M8 0l3 3H5l3-3zM8 16l-3-3h6l-3 3z" />
        </svg>
    </button>

    <!-- Script de comportamiento del boton -->
    <script src="../bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function scrollToTop() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    </script>
</body>

</html>