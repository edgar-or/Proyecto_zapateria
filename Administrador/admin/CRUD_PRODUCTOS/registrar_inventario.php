<?php
include '../../conexionBD.php';
error_reporting(E_ERROR | E_PARSE); 

$cod_producto = $_GET['cod_producto'];

// Obtener todos los productos
$query_productos = "SELECT cod_producto, nombre_producto FROM producto";
$result_productos = $conn->query($query_productos);

// Consulta para obtener todos los colores
$sql_colores = "SELECT cod_color, color FROM color";
$resultado_colores = mysqli_query($conn, $sql_colores);
$colores = mysqli_num_rows($resultado_colores) > 0 ? mysqli_fetch_all($resultado_colores, MYSQLI_ASSOC) : [];

// Consulta para obtener todas las tallas
$sql_tallas = "SELECT cod_talla, talla FROM talla";
$resultado_tallas = mysqli_query($conn, $sql_tallas);
$tallas = mysqli_num_rows($resultado_tallas) > 0 ? mysqli_fetch_all($resultado_tallas, MYSQLI_ASSOC) : [];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="icon" href="../../imagenes/Index/logo-icono.ico" type="image/x-icon">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.css">
    <title>Administración</title>
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
                        <li><a class="dropdown-item" href="../catalogo/dama.php">Dama</a></li>
                        <li><a class="dropdown-item" href="../catalogo/joven.php">Caballero</a></li>
                        <li><a class="dropdown-item" href="../catalogo/niño.php">Niño</a></li>
                        <li><a class="dropdown-item" href="../catalogo/niña.php">Niña</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../mis_compras.html" style="color: white;">Mis compras</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button"
                        aria-expanded="false" style="color: white;">Cuenta</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="../../login/login.php">Login</a></li>
                        <li><a class="dropdown-item" href="../../login/login.php">Cerrar Sesion</a></li>
                        <li><a class="dropdown-item" href="#">Mi cuenta</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button"
                        aria-expanded="false" style="color: white;">Productos</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="../admin/CRUD_PRODUCTOS/registrar_producto.php">Registrar
                                Producto</a></li>
                        <li><a class="dropdown-item" href="../admin/CRUD_PRODUCTOS/consultar_producto.php">Consultar
                                Producto</a></li>
                        <li><a class="dropdown-item" href="../admin/CRUD_PRODUCTOS/modificar_producto.php">Modificar
                                Producto</a></li>
                        <li><a class="dropdown-item" href="../admin/CRUD_PRODUCTOS/eliminar_producto.php">Eliminar
                                Producto</a></li>
                        <li><a class="dropdown-item" href="../admin/CRUD_PRODUCTOS/registrar_inventario.php">Registrar
                                Inventario</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button"
                        aria-expanded="false" style="color: white;">Usuarios</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="../admin/CRUD_USUARIOS/registrar_usuarios.php">Registrar
                                Usuario</a></li>
                        <li><a class="dropdown-item" href="../admin/CRUD_USUARIOS/consultar_usuarios.php">Consultar
                                Usuario</a></li>
                        <li><a class="dropdown-item" href="../admin/CRUD_USUARIOS/modificar_usuarios.php">Modificar
                                Usuario</a></li>
                        <li><a class="dropdown-item" href="../admin/CRUD_USUARIOS/eliminar_usuarios.php">Eliminar
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
            <div class="col-md-4">
                <h4>Productos</h4>
                <div class="card">
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Código</th>
                                    <th>Nombre</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $result_productos->fetch_assoc()) { ?>
                                <tr>
                                    <td><a href="?cod_producto=<?php echo $row['cod_producto']; ?>"><?php echo $row['cod_producto']; ?></a></td>
                                    <td><?php echo $row['nombre_producto']; ?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Formulario de registro de inventario a la derecha -->
            <div class="col-md-8">
                <h4>Registrar Inventario</h4>
                <div class="card">
                    <div class="card-body">
                        <form action="registrar_inventario.php" method="POST">
                            <?php if ($cod_producto) { ?>
                                <div class="mb-3">
                                    <label for="talla" class="form-label">Seleccione la talla</label>
                                    <select name="talla" class="form-select" required>
                                        <?php foreach ($tallas as $talla): ?>
                                            <option value="<?php echo $talla['cod_talla']; ?>"><?php echo htmlspecialchars(trim($talla['talla'])); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="color" class="form-label">Seleccione el color</label>
                                    <select name="color" class="form-select" required>
                                        <?php foreach ($colores as $color): ?>
                                            <option value="<?php echo $color['cod_color']; ?>"><?php echo htmlspecialchars(trim($color['color'])); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="cantidad" class="form-label">Digite la cantidad</label>
                                    <input type="number" name="cantidad" class="form-control" required />
                                </div>
                                <div class="mb-3">
                                    <label for="precio" class="form-label">Digite el precio unitario</label>
                                    <input type="text" name="precio" class="form-control" required />
                                </div>
                                <input type="hidden" name="cod_producto" value="<?php echo ($cod_producto)?>" />
                                <button type="submit" class="btn btn-primary">Registrar Inventario</button>
                            <?php } else { ?>
                                <p class="text-danger">Selecciona un Producto para insertar inventario</p>
                            <?php } ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script de Bootstrap -->
    <script src="../../bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php
include '../../conexionBD.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capturar los datos del formulario
    $cantidad = $_POST['cantidad'];
    $cod_producto = $_POST['cod_producto'];
    $color = $_POST['color']; 
    $talla = $_POST['talla']; 
    $precio = $_POST['precio'];

    // Verificar si ya existe el registro con la misma combinación de cod_producto, cod_color y cod_talla
    $checkInventario = "SELECT cantidad FROM inventario WHERE cod_productof = '$cod_producto' AND cod_colorf = '$color' AND cod_tallaf = '$talla'";
    $result = mysqli_query($conn, $checkInventario);

    if (mysqli_num_rows($result) > 0) {
        // Si ya existe, actualizar la cantidad sumando la nueva cantidad
        $row = mysqli_fetch_assoc($result);
        $nuevaCantidad = $row['cantidad'] + $cantidad;

        $updateInventario = "UPDATE inventario SET cantidad = '$nuevaCantidad' WHERE cod_productof = '$cod_producto' AND cod_colorf = '$color' AND cod_tallaf = '$talla'";

        if (mysqli_query($conn, $updateInventario)) {
            echo "<script>alert('Cantidad actualizada exitosamente'); window.location.href = 'registrar_inventario.php';</script>";
        } else {
            echo "<script>alert('Error al actualizar cantidad: " . mysqli_error($conn) . "'); window.location.href = 'registrar_inventario.php';</script>";
        }
    } else {
        // Si no existe, realizar el inserto
        $insertInventario = "INSERT INTO inventario (cantidad, precio_unitario, cod_productof, cod_colorf, cod_tallaf) VALUES ('$cantidad', '$precio', '$cod_producto', '$color', '$talla')";

        if (mysqli_query($conn, $insertInventario)) {
            echo "<script>alert('Cantidad en inventario agregada exitosamente'); window.location.href = 'registrar_inventario.php';</script>";
        } else {
            echo "<script>alert('Error al registrar inventario: " . mysqli_error($conn) . "'); window.location.href = 'registrar_inventario.php';</script>";
        }
    }
}

// Cerrar la conexión
mysqli_close($conn);
?>
