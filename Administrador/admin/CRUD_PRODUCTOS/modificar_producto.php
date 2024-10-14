<?php
// Conexión a la base de datos
include '../../conexionBD.php';

// Obtener todos los usuarios
$query_productos = "SELECT cod_producto, nombre_producto, marca FROM producto";
$result_productos = $conn->query($query_productos);

// Obtener datos del usuario seleccionado
$producto = null;
$cod_producto = null; 

if (isset($_GET['cod_producto'])) {
    $cod_producto = $_GET['cod_producto'];
    $query = "SELECT nombre_producto, descripcion, imagen, marca, cod_categoriaf FROM producto WHERE cod_producto = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $cod_producto);
    $stmt->execute();
    $result = $stmt->get_result();
    $producto = $result->fetch_assoc();
}

// Procesar actualización del usuario seleccionado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cod_producto = $_POST['cod_producto'];
    $nombre_producto = $_POST['nombre_producto'];
    $descripcion = $_POST['descripcion'];
    $imagen = $_POST['imagen'];
    $marca = $_POST['marca'];
    $cod_categoria = $_POST['categoria'];

    $update_query = "UPDATE producto SET nombre_producto = ?, descripcion = ?, imagen = ?, marca = ?, cod_categoriaf = ? WHERE cod_producto= ?";
    $stmt_update = $conn->prepare($update_query);
    $stmt_update->bind_param('ssssii', $nombre_producto, $descripcion, $imagen, $marca, $cod_categoria, $cod_producto);

    if ($stmt_update->execute()) {
        echo "<script>alert('Se modificó correctamente');window.location.href='modificar_producto.php';</script>";
    } else {
        echo "<script>alert('Ocurrió un error, intenta nuevamente');window.location.href='modificar_producto.php';</script>";
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
                        <li><a class="dropdown-item" href="registrar_producto.php">Registrar Producto</a></li>
                        <li><a class="dropdown-item" href="consultar_producto.php">Consultar Producto</a></li>
                        <li><a class="dropdown-item" href="#">Modificar Producto</a></li>
                        <li><a class="dropdown-item" href="eliminar_producto.php">Eliminar Producto</a></li>
                        <li><a class="dropdown-item" href="registrar_inventario.php">Registrar Inventario</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false" style="color: white;">Usuarios</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="../CRUD_USUARIOS/registrar_usuarios.php">Registrar Usuario</a></li>
                        <li><a class="dropdown-item" href="../CRUD_USUARIOS/consultar_usuarios.php">Consultar Usuario</a></li>
                        <li><a class="dropdown-item" href="../CRUD_USUARIOS/modificar_usuarios.php">Modificar Usuario</a></li>
                        <li><a class="dropdown-item" href="../CRUD_USUARIOS/eliminar_usuarios.php">Eliminar Usuario</a></li>
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
                <h4>Productos</h4>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Cod</th>
                            <th>Nombre</th>
                            <th>Marca</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result_productos->fetch_assoc()) { ?>
                        <tr>
                            <td><a href="?cod_producto=<?php echo $row['cod_producto']; ?>"><?php echo $row['cod_producto']; ?></a></td>
                            <td><?php echo $row['nombre_producto']; ?></td>
                            <td><?php echo $row['marca']; ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <!-- Formulario de edición a la derecha -->
            <div class="col-md-8 mb-4">
                <?php if ($producto) { ?>
                <form method="POST">
                    <input type="hidden" name="cod_producto" value="<?php echo $cod_producto; ?>">
                    <div class="row mb-3">
                        <label for="primer_nombre" class="col-sm-4 col-form-label">Nombre</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="primer_nombre" name="nombre_producto" value="<?php echo $producto['nombre_producto']; ?>" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="primer_apellido" class="col-sm-4 col-form-label">Descripción</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="primer_apellido" name="descripcion" value="<?php echo $producto['descripcion']; ?>" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="tipo_usuario" class="col-sm-4 col-form-label">Imagen</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="tipo_usuario" name="imagen" value="<?php echo $producto['imagen']; ?>" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="telefono_usuario" class="col-sm-4 col-form-label">Marca</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="telefono_usuario" name="marca" value="<?php echo $producto['marca']; ?>" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="correo_usuario" class="col-sm-4 col-form-label">Categoría</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="correo_usuario" name="categoria" value="<?php echo $producto['cod_categoriaf']; ?>" required>
                        </div>
                    
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                </form>
                <?php } else { ?>
                <p class="text-danger">Por favor selecciona un producto para modificar.</p>
                <?php } ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
