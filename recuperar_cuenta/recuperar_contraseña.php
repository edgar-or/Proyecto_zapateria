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
    <style>
        body {
            background-color: #f0f2f5;
        }

        .recuperar-container {
            max-width: 400px;
            margin: auto;
            padding: 2rem;
            background-color: #ffffff;
            border-radius: 0.5rem;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            margin-top: 100px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="container d-flex align-items-center vh-100">
        <div class="recuperar-container">
            <h2 class="text-center mb-4" style="font-family: monospace;">Recuperar Contraseña</h2>

            <!-- FORMULARIO DE RECUPERACIÓN -->
            <form method="POST" action="recuperar_contraseña.php">
                <div class="mb-3">
                    <label for="correo_usuario" class="form-label">Introduce tu correo electrónico:</label>
                    <input type="email" name="correo_usuario" id="correo_usuario" class="form-control" placeholder="Ingresa tu correo" required>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Enviar</button>
                </div>
            </form>

            <?php if (isset($contraseña_actual)): ?>
                <div class="alert alert-info mt-3">
                    Tu contraseña actual es: <strong><?php echo $contraseña_actual; ?></strong>
                </div>
                </form>
            <?php elseif (isset($error)): ?>
                <div class="alert alert-danger mt-3"><?php echo $error; ?></div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Bootstrap Script -->
    <script src="../bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
