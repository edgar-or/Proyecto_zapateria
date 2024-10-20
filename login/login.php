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

<body class="bg-secondary vh-100 d-flex align-items-center">
    <div class="container">
        <div class="card mx-auto" style="max-width: 400px;">
            <div class="card-header text-center bg-transparent">
                <img src="../imagenes/001-Index/Logos/Logo.png" alt="logo" class="logo mb-3" style="width: 150px;">
            </div>
            <div class="card-body text-center">
                <h2 class="text-dark mb-4">Iniciar Sesión</h2>

                <?php
                session_start();
                include '../conexionBD.php';

                // Handle form submission
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $nick_name = $_POST['nick_name'];
                    $contraseña = $_POST['contraseña'];

                    // Query to validate user credentials
                    $sql = "SELECT cod_usuario, nick_name, tipo_usuario FROM usuario WHERE nick_name = ? AND contraseña = ?";

                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("ss", $nick_name, $contraseña);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $tipo_usuario = $row['tipo_usuario'];

                        $_SESSION['cod_usuario'] = $row['cod_usuario'];
                        $_SESSION['nick_name'] = $row['nick_name'];

                        if ($tipo_usuario === 'admin') {
                            header("Location: ../Administrador/admin/admin.html");
                        } elseif ($tipo_usuario === 'cliente') {
                            header("Location: ../index.html");
                        }
                        exit();
                    } else {
                        echo '<div class="alert alert-danger mt-3" role="alert">Nick o contraseña incorrectos.</div>';
                    }
                }
                ?>

                <form action="" method="POST">
                    <div class="mb-3">
                        <label class="form-label" for="nick_name">Nick Name:</label>
                        <input class="form-control" placeholder="Ingrese su nick" type="text" name="nick_name" id="nick_name" required />
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="contraseña">Contraseña:</label>
                        <input class="form-control" placeholder="Ingrese su contraseña" type="password" maxlength="10" name="contraseña" id="contraseña" required />
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-danger">
                            Iniciar Sesión
                        </button>
                    </div>
                    <br>
                    <div class="d-grid">
                        <a href="../index.html" class="btn btn-dark">
                            Volver al inicio
                        </a>
                    </div>
                    <div class="my-3 text-center">
                        <span><a href="../registrar_cliente/registrar_cliente.php" class="text-primary">¿No tienes una cuenta?</a></span>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>

    <!-- Script de Bootstrap -->
    <script src="../bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
