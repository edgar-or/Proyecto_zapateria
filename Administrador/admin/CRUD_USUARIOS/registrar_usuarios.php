<?php
// Conexión a la base de datos
$conexion = new mysqli('localhost', 'root', '', 'the_walkers_db');

if ($conexion->connect_error) {
    die('Conexión fallida: ' . $conexion->connect_error);
}

// Procesar el formulario de registro
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitizar y validar entradas según sea necesario
    $primer_nombre = trim($_POST['primer_nombre']);
    $primer_apellido = trim($_POST['primer_apellido']);
    $tipo_usuario = trim($_POST['tipo_usuario']);
    $telefono_usuario = trim($_POST['telefono_usuario']);
    $correo_usuario = trim($_POST['correo_usuario']);
    $nick_name = trim($_POST['nick_name']);
    $contraseña = $_POST['contraseña'];

    // Validar campos obligatorios
    if ($primer_nombre && $primer_apellido && $tipo_usuario && $telefono_usuario && $correo_usuario && $nick_name && $contraseña) {
        // Almacenar la contraseña sin encriptar (no recomendado)
        $hashed_password = $contraseña; // Almacena la contraseña en texto plano

        // Preparar la consulta de inserción
        $insert_query = "INSERT INTO usuario (primer_nombre, primer_apellido, tipo_usuario, telefono_usuario, correo_usuario, nick_name, contraseña) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt_insert = $conexion->prepare($insert_query);
        if ($stmt_insert) {
            $stmt_insert->bind_param('sssssss', $primer_nombre, $primer_apellido, $tipo_usuario, $telefono_usuario, $correo_usuario, $nick_name, $hashed_password);
            if ($stmt_insert->execute()) {
                echo "<script>alert('Usuario registrado correctamente'); window.location.href='registrar_usuarios.php';</script>";
            } else {
                echo "<script>alert('Error al registrar el usuario. Intenta nuevamente.'); window.location.href='registrar_usuarios.php';</script>";
            }
            $stmt_insert->close();
        } else {
            echo "<script>alert('Error en la preparación de la consulta.'); window.location.href='registrar_usuarios.php';</script>";
        }
    } else {
        echo "<script>alert('Por favor, completa todos los campos.'); window.location.href='registrar_usuarios.php';</script>";
    }
}

// Obtener el total de usuarios
$count_query = "SELECT COUNT(*) AS total FROM usuario";
$result_count = $conexion->query($count_query);
$total_usuarios = 0;
if ($result_count) {
    $row_count = $result_count->fetch_assoc();
    $total_usuarios = $row_count['total'];
}

// Obtener los primeros 20 usuarios para mostrar en la tabla
$query_usuarios = "SELECT cod_usuario, primer_nombre, primer_apellido FROM usuario ORDER BY cod_usuario DESC LIMIT 20";
$result_usuarios = $conexion->query($query_usuarios);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<?php
session_start(); // Inicia la sesión
// Verifica si el usuario ha iniciado sesión y es administrador
if (!isset($_SESSION['cod_usuario']) || $_SESSION['tipo_usuario'] !== 'admin') {
    // Si no ha iniciado sesión o no es admin, redirigir al index.php
    header("Location: ../../../login/login.php");
    exit();
}
?>
<body style="font-family: 'Franklin Gothic Medium', 'cursive';">
    <!-- Banner de la pagina -->
    <nav class="navbar bg-body-tertiary">
        <div class="container-fluid fixed-width-container"
            style="background-color: #020304; font-family: 'Franklin Gothic Medium';">
            <a class="navbar-brand" href="#" style="background-color: #020304; color: white; font-size: 50px;">
            <img src="../../imagenes/001-Index/Logos/Logo.png" alt="Logo" width="90" height="90"
            class="d-inline-block align-text-center" style="background-color: #CC9E61;">
                THE WALKERS
            </a>
            <ul class="nav nav-tabs" style="margin-top: 4rem; font-size: 20px;">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="../../admin/admin.php">INICIO</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button"
                        aria-expanded="false" style="color: white;">Catálogo</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="../../catalogo/dama.php">Dama</a></li>
                        <li><a class="dropdown-item" href="../../catalogo/joven.php">Caballero</a></li>
                        <li><a class="dropdown-item" href="../../catalogo/niño.php">Niño</a></li>
                        <li><a class="dropdown-item" href="../../catalogo/niña.php">Niña</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../ventas.php" style="color: white;">Ventas</a>
                </li>

                <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false" style="color: white;">
                    Cuenta: 
                    <?php if (isset($_SESSION['nick_name'])): ?>
                    <?php echo $_SESSION['nick_name']; ?> <!-- Muestra el nick_name del usuario -->
                    <?php else: ?>
                    Invitado <!-- Texto a mostrar si no ha iniciado sesión -->
                    <?php endif; ?>
                </a>
            <ul class="dropdown-menu">
        <?php if (isset($_SESSION['cod_usuario'])): ?>
            <!-- Si ha iniciado sesión -->
            <li><a class="dropdown-item" href="../../../login/cerrar_sesion.php">Cerrar Sesión</a></li>
        <?php else: ?>
            <!-- Si no ha iniciado sesión -->
            <li><a class="dropdown-item" href="login/login.php">Login</a></li>
        <?php endif; ?>
    </ul>
</li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button"
                        aria-expanded="false" style="color: white;">Productos</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="../CRUD_PRODUCTOS/registrar_producto.php">Registrar
                                Producto</a></li>
                        <li><a class="dropdown-item" href="../CRUD_PRODUCTOS/consultar_producto.php">Consultar
                                Producto</a></li>
                        <li><a class="dropdown-item" href="../CRUD_PRODUCTOS/modificar_producto.php">Modificar
                                Producto</a></li>
                        <li><a class="dropdown-item" href="../CRUD_PRODUCTOS/eliminar_producto.php">Eliminar
                                Producto</a></li>
                        <li><a class="dropdown-item" href="../CRUD_PRODUCTOS/registrar_inventario.php">Registrar
                                Inventario</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button"
                        aria-expanded="false" style="color: white;">Usuarios</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="../CRUD_USUARIOS/registrar_usuarios.php">Registrar
                                Usuario</a></li>
                        <li><a class="dropdown-item" href="../CRUD_USUARIOS/consultar_usuarios.php">Consultar
                                Usuario</a></li>
                        <li><a class="dropdown-item" href="../CRUD_USUARIOS/modificar_usuarios.php">Modificar
                                Usuario</a></li>
                        <li><a class="dropdown-item" href="../CRUD_USUARIOS/eliminar_usuarios.php">Eliminar
                                Usuario</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../../creditos/creditos.html" style="color: white;">Creditos</a>
                </li>
            </ul>
        </div>
    </nav>
    <p class="fs-5 text-center" style="margin-top: 0px; color: white; background-color: #6c6c6c; font-family: 'Franklin Gothic Medium', 'cursive';">
        Registro de Nuevos Usuarios
    </p>

    <div class="container mt-5">
        <div class="row">
            <!-- Formulario de registro a la izquierda -->
            <div class="col-md-6">
                <h4>Registrar Nuevo Usuario</h4>
                <form method="POST">
                    <div class="mb-3">
                        <label for="primer_nombre" class="form-label">Primer Nombre</label>
                        <input type="text" class="form-control" id="primer_nombre" name="primer_nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="primer_apellido" class="form-label">Primer Apellido</label>
                        <input type="text" class="form-control" id="primer_apellido" name="primer_apellido" required>
                    </div>
                    <div class="mb-3">
                        <label for="tipo_usuario" class="form-label">Tipo de Usuario</label>
                        <select class="form-select" id="tipo_usuario" name="tipo_usuario" required>
                            <option value="">Seleccione el tipo</option>
                            <option value="admin">Administrador</option>
                            <option value="cliente">Cliente</option>
                            <!-- Agrega más tipos según sea necesario -->
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="telefono_usuario" class="form-label">Teléfono</label>
                        <input type="text" class="form-control" id="telefono_usuario" name="telefono_usuario" required>
                    </div>
                    <div class="mb-3">
                        <label for="correo_usuario" class="form-label">Correo Electrónico</label>
                        <input type="email" class="form-control" id="correo_usuario" name="correo_usuario" required>
                    </div>
                    <div class="mb-3">
                        <label for="nick_name" class="form-label">Nickname</label>
                        <input type="text" class="form-control" id="nick_name" name="nick_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="contraseña" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="contraseña" name="contraseña" required>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-dark me-2">Registrar Usuario</button>
                        <button type="reset" class="btn btn-dark me-2">Limpiar</button>
                        <a href="../../admin/admin.html" class="btn btn-danger">Salir</a>
                    </div>
                </form>
            </div>

            <!-- Tabla de usuarios registrados a la derecha -->
            <div class="col-md-6">
                <h4>Usuarios Registrados</h4>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result_usuarios->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['cod_usuario']); ?></td>
                            <td><?php echo htmlspecialchars($row['primer_nombre']); ?></td>
                            <td><?php echo htmlspecialchars($row['primer_apellido']); ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <?php if ($total_usuarios > 20) { ?>
                    <div class="d-flex justify-content-end">
                        <a href="usuarios_disponibles.php" class="btn btn-primary">Ver Todos los Usuarios</a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <br><br><br>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
