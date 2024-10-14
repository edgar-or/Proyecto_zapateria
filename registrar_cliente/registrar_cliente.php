<!DOCTYPE html>
<html lang="es">

<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../estilos/estilos-registro-usuario.css">
    <link rel="stylesheet" href="../bootstrap-5.3.3-dist/css/bootstrap.min.css" />
    <title>Regístrate</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(to right, #207881, #0f6871); /* Degradado de fondo */
            margin: 0;
        }

        .container {
            display: flex;
            width: 80%;
            max-width: 1200px;
            background: white;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
        }

        .image-container {
            flex: 1;
            background: url('../imagenes/001-Index/fondos/zapaaa.gif') no-repeat center center;
            background-size: cover;
            border-top-left-radius: 10px;
            border-bottom-left-radius: 10px;
        }

        .form-container {
            flex: 1;
            padding: 1rem;
        }

        .btn {
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            font-size: 1rem;
            transition: background-color 0.3s, transform 0.3s; /* Animaciones para los botones */
        }

        .btn:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }

        .btn-back {
            background-color: #dc3545;
        }

        .btn-back:hover {
            background-color: #c82333;
        }

        .alert {
            margin-top: 1rem;
        }
    </style>
</head>

<body>

    <div class="container">
        <!-- Imagen en la izquierda -->
        <div class="image-container"></div>

        <!-- Formulario en la derecha -->
        <section class="form-container">
            <h2 class="text-center mb-4" style="font-family: monospace;">Regístrate</h2>
            <form action="" method="POST" class="formulario__login">
                <div class="mb-3">
                    <label class="fw-bold" for="nombre">Escriba su primer nombre</label>
                    <input class="form-control" placeholder="primer nombre" type="text" name="nombre" id="nombre" >
                </div>

                <div class="mb-3">
                    <label class="fw-bold" for="apellido">Escriba su primer apellido</label>
                    <input class="form-control" placeholder="primer apellido" type="text" name="apellido" id="apellido" >
                </div>

                <div class="mb-3">
                    <label class="fw-bold" for="celular">Escriba su celular</label>
                    <input class="form-control" placeholder="celular" type="number" name="celular" id="celular" >
                </div>

                <div class="mb-3">
                    <label class="fw-bold" for="email">Escriba su correo electrónico</label>
                    <input class="form-control" placeholder="correo electrónico" type="email" name="email" id="email" >
                </div>

                <div class="mb-3">
                    <label class="fw-bold" for="usuario">Escriba su usuario</label>
                    <input class="form-control" placeholder="Ingrese su usuario" type="text" name="usuario" id="usuario" >
                </div>

                <div class="mb-3">
                    <label class="fw-bold" for="contraseña">Escriba su contraseña</label>
                    <input class="form-control" placeholder="Ingrese su contraseña" type="password" maxlength="10" name="contraseña" id="contraseña">
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn">
                        Registrar
                    </button>
                </div>
            </form>

            <div class="back-button d-grid mt-3">
                <button class="btn btn-back">
                    <a href="../login/login.php" style="color: white; text-decoration: none;">Volver al inicio</a>
                </button>
            </div>
        </section>
    </div>

    <!-- Código PHP para procesar el registro -->
    <?php
    include '../conexionBD.php';

    // Verifica si se recibieron los datos del formulario
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Obtener los datos del formulario
        $nombre = mysqli_real_escape_string($conn, $_POST['nombre']);
        $apellido = mysqli_real_escape_string($conn, $_POST['apellido']);
        $celular = mysqli_real_escape_string($conn, $_POST['celular']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $usuario = mysqli_real_escape_string($conn, $_POST['usuario']);
        $contraseña = mysqli_real_escape_string($conn, $_POST['contraseña']);

        // Valor predeterminado para tipo_usuario
        $tipo_usuario = "cliente";

        // Consulta preparada para evitar inyecciones SQL
        $sql = "INSERT INTO usuario (primer_nombre, primer_apellido, telefono_usuario, correo_usuario, nick_name, contraseña, tipo_usuario) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";

        // Preparar la consulta
        if ($stmt = mysqli_prepare($conn, $sql)) {
            // Vincular parámetros
            mysqli_stmt_bind_param($stmt, "sssssss", $nombre, $apellido, $celular, $email, $usuario, $contraseña, $tipo_usuario);

            // Ejecutar la consulta
            if (mysqli_stmt_execute($stmt)) {
                echo "<div class='alert alert-success'>Nuevo registro creado correctamente</div>";
            } else {
                echo "<div class='alert alert-danger'>Error: " . mysqli_error($conn) . "</div>";
            }

            // Cerrar la declaración
            mysqli_stmt_close($stmt);
        } else {
            echo "<div class='alert alert-danger'>Error en la preparación de la consulta: " . mysqli_error($conn) . "</div>";
        }
    }

    // Cerrar la conexión
    mysqli_close($conn);
    ?>

    <!-- Optional JavaScript -->
    <script src="../js/bootstrap.bundle.min.js"></script>

</body>

</html>
