<?php
session_start(); // Inicia la sesión
if (isset($_SESSION['cod_usuario'])) {
    // Si ya ha iniciado sesión, redirigir al index.php
    header("Location: ../index.php");
    exit();
}
// Conexión a la base de datos
$conn = new mysqli("localhost", "root", "", "the_walkers_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nick_name = $_POST['nick_name'];
    $password = $_POST['contraseña'];

    // Aquí deberías usar una consulta preparada para evitar inyecciones SQL
    $stmt = $conn->prepare("SELECT cod_usuario, nick_name, contraseña, tipo_usuario FROM usuario WHERE nick_name = ?");
    $stmt->bind_param("s", $nick_name);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verificamos la contraseña (asumiendo que está almacenada de forma segura usando password_hash)
        if ($password === $user['contraseña']) {
            // Autenticación correcta
            $_SESSION['cod_usuario'] = $user['cod_usuario'];
            $_SESSION['nick_name'] = $user['nick_name'];

            $_SESSION['tipo_usuario'] = $user['tipo_usuario'];

            if ($_SESSION['tipo_usuario'] == "admin"){
                header("Location: ../Administrador/admin/admin.php");
                exit();
            } else {
                header("Location: ../index.php");
                exit();
            }
             

        } else {
            // Contraseña incorrecta
            echo "<center><h4>===Contraseña Incorrecta===</h4></center>";
        }        
    } else {
        // Usuario no encontrado
        echo "<center><h4>===Usuario no Encontrado===</h4></center>";
    }
    $stmt->close();
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="icon" href="../imagenes/001-index/logos/walker.ico" type="image/x-icon">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <title>Login</title>
</head>

<body>
    <div class="d-flex align-items-center justify-content-center vh-100">
        <div class="card" style="width: 400px;">
            <div class="card-header text-center bg-dark text-white">
                <h3>Iniciar Sesión</h3>
            </div>
            <div class="card-body">
                <img src="../imagenes/001-Index/Logos/Logo.png" alt="logo" class="img-fluid mb-3" style="width: 150px; display: block; margin: auto;">
                
                <!-- Mostrar mensaje de error si existe -->
                <?php if (!empty($error_message)): ?>
                    <div class="alert alert-danger text-center">
                        <?= $error_message; ?>
                    </div>
                <?php endif; ?>
                
                <!-- FORMULARIO LOGIN -->
                <form action="login.php" method="POST">
                    <div class="mb-3">
                        <label class="form-label fw-bold" for="nick_name">Nick Name:</label>
                        <input class="form-control" placeholder="Ingrese su nick" type="text" name="nick_name" id="nick_name" required />
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold" for="contraseña">Contraseña:</label>
                        <input class="form-control" placeholder="Ingrese su contraseña" type="password" maxlength="10" name="contraseña" id="contraseña" required />
                    </div>
                    <div class="my-3 w-100 text-center">
                        <span><a target="_blank" href="../recuperar_cuenta/recuperar_contraseña.php">¿Olvidaste tu contraseña?</a></span>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">
                            Iniciar Sesión
                        </button>
                    </div>
                    <div class="mt-3 d-grid">
                <a href="../index.php" class="btn btn-dark">
                    Volver al inicio
                </a>
            </div>
                    <div class="my-3 w-100 text-center">
                        <span><a target="_blank" href="../registrar_cliente/registrar_cliente.php">¿No tienes una cuenta?</a></span>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Script de Bootstrap -->
    <script src="../bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
