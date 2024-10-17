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
            background-color: #f0f2f5;
        }

        .login-container {
            max-width: 400px;
            margin: auto;
            padding: 2rem;
            background-color: #ffffff;
            border-radius: 0.5rem;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .login-container img {
            display: block;
            margin: 0 auto 1rem;
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

            <?php

            session_start();
            // Database connection
            $conn = new mysqli("localhost", "root", "", "the_walkers_db");

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Handle form submission
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $nick_name = $_POST['nick_name'];
                $contraseña = $_POST['contraseña'];

                // Query to validate user credentials
                $sql = "SELECT tipo_usuario FROM usuario WHERE nick_name = ? AND contraseña = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ss", $nick_name, $contraseña);
                $_SESSION['usuario'] = $nick_name; // Almacena el nombre de usuario en la sesión
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    // User found, fetch the user type
                    $row = $result->fetch_assoc();
                    $tipo_usuario = $row['tipo_usuario'];

                    // Redirect based on user type
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

