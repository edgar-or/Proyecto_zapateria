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
    <div class="d-flex align-items-center justify-content-center vh-100">
        <div class="card" style="width: 400px;">
            <div class="card-header text-center">
                <h3>Iniciar Sesión</h3>
            </div>
            <div class="card-body">
                <img src="../imagenes/001-Index/Logos/Logo.png" alt="logo" class="img-fluid mb-3" style="width: 150px; display: block; margin: auto;">
                
                <?php
                // Database connection
                $conn = new mysqli("localhost", "root", "", "the_walkers_db");

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
