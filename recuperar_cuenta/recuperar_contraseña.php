<?php
// Conectar a la base de datos
include('../conexionBD.php'); // Asegúrate de tener tu archivo de conexión aquí

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo_usuario = $_POST['correo_usuario'];

    // Consulta para verificar si el correo existe en la base de datos
    $sql = "SELECT contraseña FROM usuario WHERE correo_usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $correo_usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Si el correo existe, obtener la contraseña
        $row = $result->fetch_assoc();
        $contraseña_actual = $row['contraseña'];
    } else {
        $error = "No se encontró una cuenta con ese correo.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="icon" href="../imagenes/Index/logo-icono.ico" type="image/x-icon">
    <title>Recuperar Contraseña</title>
</head>

<body>
    <div class="d-flex align-items-center justify-content-center vh-100">
        <div class="card" style="width: 400px;">
            <div class="card-header text-center bg-dark text-white">
                <h3>Recuperar Contraseña</h3>
            </div>
            <div class="card-body">
                <!-- FORMULARIO DE RECUPERACIÓN -->
                <form method="POST" action="recuperar_contraseña.php">
                    <div class="mb-3">
                        <label for="correo_usuario" class="form-label fw-bold">Introduce tu correo electrónico:</label>
                        <input type="email" name="correo_usuario" id="correo_usuario" class="form-control" placeholder="Ingresa tu correo" required>
                    </div>
                    <?php if (isset($contraseña_actual)): ?>
                    <div class="alert alert-info mt-3">
                        Tu contraseña actual es: <strong><?php echo $contraseña_actual; ?></strong>
                    </div>
                <?php elseif (isset($error)): ?>
                    <div class="alert alert-danger mt-3"><?php echo $error; ?></div>
                <?php endif; ?>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Enviar</button>
                    </div>
                </form>
                <div class="mt-3 d-grid">
                    <a href="../index.php" class="btn btn-dark">Volver al inicio</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Script -->
    <script src="../bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
