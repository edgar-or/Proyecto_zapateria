<?php
// Conexión a la base de datos
$conexion = new mysqli('localhost', 'root', '', 'the_walkers_db');

if ($conexion->connect_error) {
    die('Conexión fallida: ' . $conexion->connect_error);
}

// Obtener todos los usuarios
$query_usuarios = "SELECT cod_usuario, primer_nombre, primer_apellido FROM usuario";
$result_usuarios = $conexion->query($query_usuarios);

// Obtener datos del usuario seleccionado
$usuario = null;
if (isset($_GET['cod_usuario'])) {
    $cod_usuario = $_GET['cod_usuario'];
    $query = "SELECT primer_nombre, primer_apellido, tipo_usuario, telefono_usuario, correo_usuario, nick_name, contraseña FROM usuario WHERE cod_usuario = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param('i', $cod_usuario);
    $stmt->execute();
    $result = $stmt->get_result();
    $usuario = $result->fetch_assoc();
}

// Procesar eliminación del usuario seleccionado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar_usuario'])) {
    $cod_usuario = $_POST['cod_usuario'];
    $delete_query = "DELETE FROM usuario WHERE cod_usuario = ?";
    $stmt_delete = $conexion->prepare($delete_query);
    $stmt_delete->bind_param('i', $cod_usuario);
    if ($stmt_delete->execute()) {
        echo "<script>alert('Usuario eliminado correctamente'); window.location.href='eliminar_usuarios.php';</script>";
    } else {
        echo "<script>alert('Error al eliminar el usuario. Intenta nuevamente.'); window.location.href='eliminar_usuarios.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Banner de la página -->
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
                        <li><a class="dropdown-item" href="modificar_usuarios.php">Modificar Usuario</a></li>
                        <li><a class="dropdown-item" href="eliminar_usuarios.php">Eliminar Usuario</a></li>
                    </ul>
                </li>
                <li class="nav-item"><a class="nav-link" href="../../../Administrador/creditos/creditos.html" style="color: white;">Créditos</a></li>
            </ul>
        </div>
    </nav>
    <p class="fs-5 text-center" style="margin-top: 0px; color: white; background-color: #f50000; font-family: 'Franklin Gothic Medium', 'cursive';">Eliminación de Usuarios</p>

    <div class="container mt-5">
        <div class="row">
            <!-- Tabla de usuarios a la izquierda -->
            <div class="col-md-4">
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

            <!-- Formulario de eliminación a la derecha -->
            <div class="col-md-5">
                <?php if ($usuario) { ?>
                <form method="POST">
                    <input type="hidden" name="cod_usuario" value="<?php echo $cod_usuario; ?>">
                    <div class="mb-3">
                        <label class="form-label">Primer Nombre</label>
                        <input type="text" class="form-control" value="<?php echo $usuario['primer_nombre']; ?>" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Primer Apellido</label>
                        <input type="text" class="form-control" value="<?php echo $usuario['primer_apellido']; ?>" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tipo de Usuario</label>
                        <input type="text" class="form-control" value="<?php echo $usuario['tipo_usuario']; ?>" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Teléfono</label>
                        <input type="text" class="form-control" value="<?php echo $usuario['telefono_usuario']; ?>" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Correo Electrónico</label>
                        <input type="email" class="form-control" value="<?php echo $usuario['correo_usuario']; ?>" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nickname</label>
                        <input type="text" class="form-control" value="<?php echo $usuario['nick_name']; ?>" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Contraseña</label>
                        <input type="password" class="form-control" value="<?php echo $usuario['contraseña']; ?>" disabled>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" name="eliminar_usuario" class="btn btn-danger me-2">Eliminar Usuario</button>
                        <button type="button" class="btn btn-dark me-2" onclick="window.location.reload();">Refrescar</button>
                        <a href="../Administrador/index.html" class="btn btn-danger">Salir</a>
                    </div>
                </form>
                <?php } else { ?>
                    <p>Selecciona un usuario para eliminar sus datos.</p>
                <?php } ?>
            </div>
        </div>
    </div>
    <br><br><br>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
