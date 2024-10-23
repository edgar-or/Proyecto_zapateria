<?php
// Conexión a la base de datos
include '../../conexionBD.php';

// Obtener todos los productos
$query_productos = "SELECT cod_producto, nombre_producto, marca FROM producto";
$result_productos = $conn->query($query_productos);

// Obtener datos del producto seleccionado
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

// Procesar actualización del producto seleccionado
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
    <title>Modificar Producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="../../../imagenes/001-Index/Logos/walker.ico" type="image/x-icon">
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
            <a class="navbar-brand" href="../../admin/admin.html" style="background-color: #020304; color: white; font-size: 50px;">
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
                    <a class="nav-link" href="../creditos/creditos.html" style="color: white;">Creditos</a>
                </li>
            </ul>
        </div>
    </nav>
  <p class="fs-5 text-center text-content" style="color: white; background-color: #6c6c6c; font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;">
        Modificar Producto
    </p>

    <div class="container mt-5">
        <div class="row">
            <!-- Tabla de productos a la izquierda -->
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
                <h4>Modificar Producto</h4>
                <?php if ($producto) { ?>
                <form method="POST">
                    <input type="hidden" name="cod_producto" value="<?php echo $cod_producto; ?>">
                    <div class="mb-3">
                        <label for="nombre_producto" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre_producto" name="nombre_producto" value="<?php echo htmlspecialchars($producto['nombre_producto']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <input type="text" class="form-control" id="descripcion" name="descripcion" value="<?php echo htmlspecialchars($producto['descripcion']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="imagen" class="form-label">Imagen</label>
                        <input type="text" class="form-control" id="imagen" name="imagen" value="<?php echo htmlspecialchars($producto['imagen']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="marca" class="form-label">Marca</label>
                        <input type="text" class="form-control" id="marca" name="marca" value="<?php echo htmlspecialchars($producto['marca']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="categoria" class="form-label">Categoría</label>
                        <input type="text" class="form-control" id="categoria" name="categoria" value="<?php echo htmlspecialchars($producto['cod_categoriaf']); ?>" required>
                    </div>
                    <button type="submit" class="btn btn-dark">Actualizar</button>
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
