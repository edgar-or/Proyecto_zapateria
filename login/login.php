<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="icon" href="../imagenes/Index/logo-icono.ico" type="image/x-icon">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <title>Login</title>
    <style>
        body {
            background: linear-gradient(to right, #525252 , #717171 );
            height: 100vh;
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
        }

        .card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.2);
        }

        .card-header {
            background-color: #020304;
            color: white;
            border-top-left-radius: 1rem;
            border-top-right-radius: 1rem;
        }

        .form-label {
            font-weight: bold;
        }

        .alert {
            margin-top: 1rem;
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
        <div class="login-container">
            <img src="../imagenes/001-Index/Logos/Logo.png" alt="logo" class="img-fluid" style="width: 150px;">
            <h2 class="text-center mb-4" style="font-family: monospace;">Iniciar Sesión</h2>

<<<<<<< HEAD
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
=======
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
                        echo '<div class="alert alert-danger" role="alert">Nick o contraseña incorrectos.</div>';
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
                    </div><br>
                    <div class="d-grid">
                        <a href="../index.html" class="btn btn-dark">
                            Volver al inicio
                        </a>
                    </div>
                    <div class="my-3 text-center">
                        <span><a href="../registrar_cliente/registrar_cliente.php">¿No tienes una cuenta?</a></span>
                    </div>
                </form>
            </div>
>>>>>>> 1f01e957eaa3f0d2095df844c321167dd05fa58b
        </div>
    </div>

    <!-- Script de Bootstrap -->
    <script src="../bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

