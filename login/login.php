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
                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }
                ?>
            <!-- LOGIN FORM -->
            <form action="" method="POST">
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
                <div class="my-3 w-100 text-center">
                    <span><a target="_blank" href="../registrar_cliente/registrar_cliente.php">¿No tienes una cuenta?</a></span>
                </div>
            </form>
        </div>
    </div>

    <!-- Script de Bootstrap -->
    <script src="../bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
