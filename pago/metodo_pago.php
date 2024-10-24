<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../bootstrap-5.3.3-dist/css/bootstrap.min.css" />
    <link rel="icon" href="../imagenes/001-index/logos/walker.ico" type="image/x-icon">
    <title>Formulario de Pago</title>
</head>

<body>
    <div class="d-flex align-items-center justify-content-center vh-100 bg-light">
        <!-- Formulario de pago -->
        <div class="card payment-form" style="width: 450px;">
            <div class="card-header text-center bg-dark text-white">
                <h2 class="mb-0">Formulario de Pago</h2>
            </div>
            <div class="card-body">
                <!-- Aquí es donde las alertas aparecerán -->
                <?php
                // Iniciar sesión si es necesario
                session_start();

                // Incluir la conexión a la base de datos
                include '../conexionBD.php';

                // Verificar si el formulario fue enviado
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    // Obtener los datos del formulario
                    $nombre_titular = mysqli_real_escape_string($conn, $_POST['name']);
                    $numero_tarjeta = mysqli_real_escape_string($conn, $_POST['numero_tarjeta']);
                    $fecha_vencimiento = mysqli_real_escape_string($conn, $_POST['fecha_vencimiento']);
                    $cvv = mysqli_real_escape_string($conn, $_POST['cvv']);

                    // Datos adicionales, como el ID del usuario, si está registrado
                    $id_usuario = isset($_SESSION['cod_usuario']) ? $_SESSION['cod_usuario'] : null;

                    // Guardar la compra en la tabla 'metodo_pago'
                    $sql = "INSERT INTO metodo_pago (nombre_titular, numero_tarjeta, fecha_vencimiento, cvv, cod_usuariof) 
                            VALUES (?, ?, ?, ?, ?)";

                    // Preparar la consulta
                    if ($stmt = mysqli_prepare($conn, $sql)) {
                        // Enmascarar parcialmente el número de tarjeta para evitar almacenar datos sensibles
                        $numero_tarjeta_oculto = str_repeat('*', 12) . substr($numero_tarjeta, -4);

                        // Vincular parámetros (sin almacenar el número de tarjeta completo por razones de seguridad)
                        mysqli_stmt_bind_param($stmt, "ssssi", $nombre_titular, $numero_tarjeta_oculto, $fecha_vencimiento, $cvv, $id_usuario);

                        // Ejecutar la consulta
                        if (mysqli_stmt_execute($stmt)) {
                            echo "<div class='alert alert-success'>Método de pago registrado correctamente.</div>";
                        } else {
                            echo "<div class='alert alert-danger'>Error al insertar el método de pago: " . mysqli_error($conn) . "</div>";
                        }

                        // Cerrar la declaración
                        mysqli_stmt_close($stmt);
                    } else {
                        echo "<div class='alert alert-danger'>Error en la preparación de la consulta: " . mysqli_error($conn) . "</div>";
                    }

                    // Cerrar la conexión
                    mysqli_close($conn);
                }
                ?>

                <form action="" method="POST">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nombre del titular</label>
                        <input type="text" id="name" name="name" class="form-control" placeholder="Ingrese el nombre del titular" required>
                    </div>
                    <div class="mb-3">
                        <label for="card-number" class="form-label">Número de tarjeta</label>
                        <input type="text" id="card-number" name="numero_tarjeta" class="form-control" maxlength="16" placeholder="Ingrese el número de tarjeta" required>
                    </div>
                    <div class="mb-3">
                        <label for="expiry-date" class="form-label">Fecha de vencimiento</label>
                        <input type="date" id="expiry-date" name="fecha_vencimiento" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="cvv" class="form-label">CVV</label>
                        <input type="text" id="cvv" name="cvv" class="form-control" maxlength="3" placeholder="Ingrese el CVV" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Registrar</button>
                    </div>
                    <!-- Botón para volver al menú -->
                    <div class="mt-3 d-grid">
                        <a href="../catalogo/dama.php" class="btn btn-dark">Volver al Catálogo</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="../bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
