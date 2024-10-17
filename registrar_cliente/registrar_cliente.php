<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../bootstrap-5.3.3-dist/css/bootstrap.min.css" />
    <title>Regístrate</title>
    <style>
        body {
            background: linear-gradient(to right, #525252 , #717171); /* Degradado de fondo */
            height: 100vh;
            margin: 0;
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
        }

        .container {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
        }

        .card {
            width: 400px; /* Ajustar el tamaño de la tarjeta */
            border-radius: 1rem;
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.2);
            margin-left: 30px; /* Espacio entre la tarjeta y la imagen */
        }

        .card-header {
            background-color: #020304;
            color: white;
            border-top-left-radius: 2rem;
            border-top-right-radius: 2rem;
        }

        .alert {
            margin-top: 1rem;
        }

        .image-container {
            flex: 1;
            background: url('../imagenes/001-Index/fondos/zapaaa.gif') no-repeat center center;
            background-size: cover;
            border-top-left-radius: 1rem;
            border-bottom-left-radius: 1rem;
            height: 100%; /* Asegurarse de que la imagen ocupe toda la altura */
        }
    </style>
</head>

<body>
    <br><br>
    <div class="container">
        <div class="image-container"></div>

        <div class="card">
            <div class="card-header text-center">
                <h2>Regístrate</h2>
            </div>
            <div class="card-body">
                <form action="" method="POST">
                    <div class="mb-3">
                        <label class="form-label fw-bold" for="nombre">Escriba su primer nombre</label>
                        <input class="form-control" placeholder="primer nombre" type="text" name="nombre" id="nombre" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold" for="apellido">Escriba su primer apellido</label>
                        <input class="form-control" placeholder="primer apellido" type="text" name="apellido" id="apellido" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold" for="celular">Escriba su celular</label>
                        <input class="form-control" placeholder="celular" type="number" name="celular" id="celular" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold" for="email">Escriba su correo electrónico</label>
                        <input class="form-control" placeholder="correo electrónico" type="email" name="email" id="email" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold" for="usuario">Escriba su usuario</label>
                        <input class="form-control" placeholder="Ingrese su usuario" type="text" name="usuario" id="usuario" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold" for="contraseña">Escriba su contraseña</label>
                        <input class="form-control" placeholder="Ingrese su contraseña" type="password" maxlength="10" name="contraseña" id="contraseña" required>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-danger">
                            Registrar
                        </button>
                    </div>
                </form>

                <div class="mt-3 d-grid">
                    <a href="../login/login.php" class="btn btn-dark">
                        Volver al inicio
                    </a>
                </div>

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
            </div>
        </div>
    </div>

    <script src="../bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
