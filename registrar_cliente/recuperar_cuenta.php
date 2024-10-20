<?php
// iniciar la sesión
session_start();

// Verificar si el usuario está autenticado
// (Ajusta esta parte según tu sistema de autenticación)
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

// Configuración de la base de datos
$servername = "localhost"; // Cambia si tu servidor es diferente
$db_username = "root"; // Tu usuario de la base de datos
$db_password = ""; // Tu contraseña de la base de datos
$dbname = "bd_za_2.0."; // El nombre de tu base de datos

// Crear conexión
$conn = new mysqli($servername, $db_username, $db_password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Inicializar variables
$mensaje = "";
$usuarioData = [
    'nombre' => '',
    'apellido' => '',
    'celular' => '',
    'correo' => '',
    'usuario' => ''
];

// Verificar si se ha enviado el formulario (método POST)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener y sanitizar los datos del formulario
    $nombre = trim($_POST['nombre']);
    $apellido = trim($_POST['apellido']);
    $celular = trim($_POST['celular']);
    $correo = trim($_POST['correo']);
    $contrasena = trim($_POST['contrasena']);
    $usuario_original = trim($_POST['usuario_original']);

    // Validaciones básicas
    if (empty($nombre) || empty($apellido) || empty($celular) || empty($correo) || empty($usuario_original)) {
        $mensaje = '<div class="alert alert-danger">Todos los campos excepto la contraseña son obligatorios.</div>';
    } elseif (!preg_match("/^[0-9]{10}$/", $celular)) {
        $mensaje = '<div class="alert alert-danger">El número de celular debe tener 10 dígitos.</div>';
    } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $mensaje = '<div class="alert alert-danger">Formato de correo electrónico inválido.</div>';
    } else {
        // Comenzar una transacción
        $conn->begin_transaction();

        try {
            // Actualizar los campos (excepto contraseña)
            $sql = "UPDATE usuarios SET nombre = ?, apellido = ?, celular = ?, correo = ? WHERE usuario = ?";
            $stmt = $conn->prepare($sql);
            if (!$stmt) {
                throw new Exception("Error en la preparación de la consulta: " . $conn->error);
            }
            $stmt->bind_param("sssss", $nombre, $apellido, $celular, $correo, $usuario_original);
            if (!$stmt->execute()) {
                throw new Exception("Error al ejecutar la consulta: " . $stmt->error);
            }

            // Si se ingresó una nueva contraseña, actualizarla
            if (!empty($contrasena)) {
                // Hashear la nueva contraseña
                $contrasena_hashed = password_hash($contrasena, PASSWORD_DEFAULT);

                $sql_contra = "UPDATE usuarios SET contrasena = ? WHERE usuario = ?";
                $stmt_contra = $conn->prepare($sql_contra);
                if (!$stmt_contra) {
                    throw new Exception("Error en la preparación de la consulta de contraseña: " . $conn->error);
                }
                $stmt_contra->bind_param("ss", $contrasena_hashed, $usuario_original);
                if (!$stmt_contra->execute()) {
                    throw new Exception("Error al ejecutar la consulta de contraseña: " . $stmt_contra->error);
                }
                $stmt_contra->close();
            }

            // Confirmar la transacción
            $conn->commit();

            $mensaje = '<div class="alert alert-success">Credenciales actualizadas exitosamente.</div>';
        } catch (Exception $e) {
            // Revertir la transacción en caso de error
            $conn->rollback();
            $mensaje = '<div class="alert alert-danger">Error al actualizar las credenciales: ' . htmlspecialchars($e->getMessage()) . '</div>';
        }

        // Cerrar la declaración
        $stmt->close();
    }

    // Recuperar los datos actualizados para mostrar en el formulario
    $sql = "SELECT * FROM usuarios WHERE usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $usuario_original);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        $mensaje .= '<div class="alert alert-danger">Usuario no encontrado.</div>';
    } else {
        $usuarioData = $result->fetch_assoc();
    }

    $stmt->close();
} else {
    // Si la solicitud es GET, obtener el usuario a modificar
    if (isset($_GET['usuario'])) {
        $usuario = $_GET['usuario'];

        // Recuperar datos del usuario desde la base de datos
        $sql = "SELECT * FROM usuarios WHERE usuario = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            $mensaje = '<div class="alert alert-danger">Usuario no encontrado.</div>';
        } else {
            $usuarioData = $result->fetch_assoc();
        }

        $stmt->close();
    } else {
        $mensaje = '<div class="alert alert-danger">No se especificó un usuario.</div>';
    }
}

// Cerrar la conexión
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="imagenes/001-Index/Logos/walker.ico" type="image/x-icon">

    <title>Modificar Credenciales de Usuario</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Modificar Credenciales de Usuario</h2>
    
    <!-- Mostrar mensaje de feedback -->
    <?php
    if (!empty($mensaje)) {
        echo $mensaje;
    }
    ?>

    <?php if (!empty($usuarioData['usuario'])): ?>
    <form action="modificar_usuario.php" method="POST">
        <!-- Campo Nombre -->
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" 
                   value="<?php echo htmlspecialchars($usuarioData['nombre']); ?>" required>
        </div>

        <!-- Campo Apellido -->
        <div class="mb-3">
            <label for="apellido" class="form-label">Apellido</label>
            <input type="text" class="form-control" id="apellido" name="apellido" 
                   value="<?php echo htmlspecialchars($usuarioData['apellido']); ?>" required>
        </div>

        <!-- Campo Celular -->
        <div class="mb-3">
            <label for="celular" class="form-label">Celular</label>
            <input type="tel" class="form-control" id="celular" name="celular" 
                   pattern="[0-9]{10}" value="<?php echo htmlspecialchars($usuarioData['celular']); ?>" required>
            <div class="form-text">Ingrese un número de celular válido de 10 dígitos.</div>
        </div>

        <!-- Campo Correo -->
        <div class="mb-3">
            <label for="correo" class="form-label">Correo Electrónico</label>
            <input type="email" class="form-control" id="correo" name="correo" 
                   value="<?php echo htmlspecialchars($usuarioData['correo']); ?>" required>
        </div>

        <!-- Campo Usuario (No editable) -->
        <div class="mb-3">
            <label for="usuario" class="form-label">Usuario</label>
            <input type="text" class="form-control" id="usuario" name="usuario" 
                   value="<?php echo htmlspecialchars($usuarioData['usuario']); ?>" readonly>
        </div>

        <!-- Campo Contraseña -->
        <div class="mb-3">
            <label for="contrasena" class="form-label">Contraseña</label>
            <input type="password" class="form-control" id="contrasena" name="contrasena" minlength="6">
            <div class="form-text">Deja este campo vacío si no deseas cambiar la contraseña.</div>
        </div>

        <!-- Campo Oculto para Identificar al Usuario -->
        <input type="hidden" name="usuario_original" value="<?php echo htmlspecialchars($usuarioData['usuario']); ?>">

        <!-- Botón de Envío -->
        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
    </form>
    <?php endif; ?>
</div>

<!-- Bootstrap JS y dependencias (opcional, para componentes interactivos) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
