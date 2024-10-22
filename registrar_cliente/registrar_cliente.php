<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../bootstrap-5.3.3-dist/css/bootstrap.min.css" />
    <link rel="icon" href="../imagenes/001-index/logos/walker.ico" type="image/x-icon">
    <title>Regístrate</title>
</head>

<body class="vh-100 d-flex align-items-center justify-content-center">
    <div class="card" style="width: 400px;">
        <div class="card-header text-center bg-dark text-white">
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
                    <button type="submit" class="btn btn-primary">
                        Registrar
                    </button>
                </div>
            </form>

            <div class="mt-3 d-grid">
                <a href="../index.php" class="btn btn-dark">
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
                        echo "<div class='alert alert-success mt-3'>Nuevo registro creado correctamente</div>";
                    } else {
                        echo "<div class='alert alert-danger mt-3'>Error: " . mysqli_error($conn) . "</div>";
                    }

                    // Cerrar la declaración
                    mysqli_stmt_close($stmt);
                } else {
                    echo "<div class='alert alert-danger mt-3'>Error en la preparación de la consulta: " . mysqli_error($conn) . "</div>";
                }
            }

            // Cerrar la conexión
            mysqli_close($conn);
            ?>
        </div>
    </div>

    <script src="../bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
