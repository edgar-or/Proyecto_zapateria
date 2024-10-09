<?php
// Conexión a la base de datos
include '../../conexionBD.php';
<<<<<<< HEAD
=======
$conexion = new mysqli('localhost', 'root', '', 'the_walkers_db');

if ($conexion->connect_error) {
    die('Conexión fallida: ' . $conexion->connect_error);
}

>>>>>>> 4e06fa9f67fc47a827eb8301265e4f22019e86bc

// Obtener todos los usuarios
$query_usuarios = "SELECT cod_usuario, primer_nombre, primer_apellido FROM usuario";
$result_usuarios = $conn->query($query_usuarios);

// Obtener datos del usuario seleccionado
$usuario = null;
$cod_usuario = null; // Initialize the variable

if (isset($_GET['cod_usuario'])) {
    $cod_usuario = $_GET['cod_usuario'];
    $query = "SELECT primer_nombre, primer_apellido, tipo_usuario, telefono_usuario, correo_usuario, nick_name, contraseña FROM usuario WHERE cod_usuario = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $cod_usuario);
    $stmt->execute();
    $result = $stmt->get_result();
    $usuario = $result->fetch_assoc();
}

// Procesar actualización del usuario seleccionado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cod_usuario = $_POST['cod_usuario'];
    $primer_nombre = $_POST['primer_nombre'];
    $primer_apellido = $_POST['primer_apellido'];
    $tipo_usuario = $_POST['tipo_usuario'];
    $telefono_usuario = $_POST['telefono_usuario'];
    $correo_usuario = $_POST['correo_usuario'];
    $nick_name = $_POST['nick_name'];
    $contraseña = $_POST['contraseña'];

    $update_query = "UPDATE usuario SET primer_nombre = ?, primer_apellido = ?, tipo_usuario = ?, telefono_usuario = ?, correo_usuario = ?, nick_name = ?, contraseña = ? WHERE cod_usuario = ?";
    $stmt_update = $conn->prepare($update_query);
    $stmt_update->bind_param('sssssssi', $primer_nombre, $primer_apellido, $tipo_usuario, $telefono_usuario, $correo_usuario, $nick_name, $contraseña, $cod_usuario);

    if ($stmt_update->execute()) {
        echo "<script>alert('Se modificó correctamente');window.location.href='modificar_usuarios.php';</script>";
    } else {
        echo "<script>alert('Ocurrió un error, intenta nuevamente');window.location.href='modificar_usuarios.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Credenciales</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Banner de la pagina -->
    <nav class="navbar bg-body-tertiary">
        <div class="container-fluid fixed-width-container" style="background-color: #020304; font-family: 'Franklin Gothic Medium';">
            <a class="navbar-brand" href="#" style="background-color: #020304; color: white; font-size: 50px;">
                <img src="../../imagenes/001-Index/Logos/Logo.png" alt="Logo" width="90" height="90" class="d-inline-block align-text-center" style="background-color: #CC9E61;">
                THE WALKERS
            </a>
            <ul class="nav nav-tabs" style="margin-top: 4rem; font-size: 20px;">
                <li class="nav-item"><a class="nav-link active" aria-current="page" href="../../index.html">INICIO</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false" style="color: white;">Productos</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="../CRUD_PRODUCTOS/registrar_producto.php">Registrar Producto</a></li>
                        <li><a class="dropdown-item" href="../CRUD_PRODUCTOS/consultar_producto.php">Consultar Producto</a></li>
                        <li><a class="dropdown-item" href="../CRUD_PRODUCTOS/modificar_producto.php">Modificar Producto</a></li>
                        <li><a class="dropdown-item" href="../CRUD_PRODUCTOS/eliminar_producto.php">Eliminar Producto</a></li>
                        <li><a class="dropdown-item" href="../CRUD_PRODUCTOS/registrar_inventario.php">Registrar Inventario</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false" style="color: white;">Usuarios</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="registrar_usuarios.php">Registrar Usuario</a></li>
                        <li><a class="dropdown-item" href="consultar_usuarios.php">Consultar Usuario</a></li>
                        <li><a class="dropdown-item" href="#">Modificar Usuario</a></li>
                        <li><a class="dropdown-item" href="eliminar_usuarios.php">Eliminar Usuario</a></li>
                    </ul>
                </li>
                <li class="nav-item"><a class="nav-link" href="../../../Administrador/creditos/creditos.html" style="color: white;">Créditos</a></li>
            </ul>
        </div>
    </nav>

    <p class="fs-5 text-center" style="margin-top: 0px; color: white; background-color: #55e553; font-family: 'Franklin Gothic Medium', 'cursive';">Modificación de credenciales de usuarios</p>

    <div class="container mt-5">
        <div class="row">
            <!-- Tabla de usuarios a la izquierda -->
            <div class="col-md-4 mb-4">
                <h4>Usuarios</h4>
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
                            <td><a href="?cod_usuario=<?php echo $row['cod_usuario']; ?>"><?php echo $row['cod_usuario']; ?></a></td>
                            <td><?php echo $row['primer_nombre']; ?></td>
                            <td><?php echo $row['primer_apellido']; ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <!-- Formulario de edición a la derecha -->
            <div class="col-md-8 mb-4">
                <?php if ($usuario) { ?>
                <form method="POST">
                    <input type="hidden" name="cod_usuario" value="<?php echo $cod_usuario; ?>">
                    <div class="row mb-3">
                        <label for="primer_nombre" class="col-sm-4 col-form-label">Primer Nombre</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="primer_nombre" name="primer_nombre" value="<?php echo $usuario['primer_nombre']; ?>" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="primer_apellido" class="col-sm-4 col-form-label">Primer Apellido</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="primer_apellido" name="primer_apellido" value="<?php echo $usuario['primer_apellido']; ?>" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="tipo_usuario" class="col-sm-4 col-form-label">Tipo de Usuario</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="tipo_usuario" name="tipo_usuario" value="<?php echo $usuario['tipo_usuario']; ?>" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="telefono_usuario" class="col-sm-4 col-form-label">Teléfono</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="telefono_usuario" name="telefono_usuario" value="<?php echo $usuario['telefono_usuario']; ?>" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="correo_usuario" class="col-sm-4 col-form-label">Correo Electrónico</label>
                        <div class="col-sm-8">
                            <input type="email" class="form-control" id="correo_usuario" name="correo_usuario" value="<?php echo $usuario['correo_usuario']; ?>" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="nick_name" class="col-sm-4 col-form-label">Nickname</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="nick_name" name="nick_name" value="<?php echo $usuario['nick_name']; ?>" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="contraseña" class="col-sm-4 col-form-label">Contraseña</label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" id="contraseña" name="contraseña" value="<?php echo $usuario['contraseña']; ?>" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                </form>
                <?php } else { ?>
                <p class="text-danger">Por favor selecciona un usuario para modificar.</p>
                <?php } ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
