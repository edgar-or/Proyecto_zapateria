<?php
include '../../conexionBD.php';

error_reporting(E_ERROR | E_PARSE); // Mostrar solo errores fatales y parse errors

// Consulta para obtener todas las categorías
$sql = "SELECT cod_categoria, nombre_categoria FROM categoria";
$resultado = mysqli_query($conn, $sql);

// Verificar si hay resultados
if (mysqli_num_rows($resultado) > 0) {
    $categorias = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="icon" href="../../imagenes/Index/logo-icono.ico" type="image/x-icon">
    <link rel="icon" href="../../../imagenes/001-Index/Logos/walker.ico" type="image/x-icon">
    <!-- Bootstrap Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.css">
    <title>Administracion</title>
</head>
<?php
session_start(); // Inicia la sesión
// Verifica si el usuario ha iniciado sesión y es administrador
if (!isset($_SESSION['cod_usuario']) || $_SESSION['tipo_usuario'] !== 'admin') {
    
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
    <p class="fs-5 text-center text-content" style="color: white; background-color: #6c6c6c; font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;">
        Registrar Producto
    </p>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center">
                        <h5>Formulario de Registro de Producto</h5>
                    </div>
                    <div class="card-body">
                        <form action="registrar_producto.php" method="POST" class="formulario__login">

                            <div class="mb-3">
                                <label class="fw-bold" for="nombre">Digite el nombre de Zapato</label>
                                <input class="form-control" placeholder="Nombre del zapato" type="text" name="nombre" id="nombre" required />
                            </div>

                            <div class="mb-3">
                                <label class="fw-bold" for="descripcion">Escriba una breve descripcion</label>
                                <input class="form-control" placeholder="descripcion" type="text" name="descripcion" id="descripcion" required />
                            </div>

                            <div class="mb-3">
                                <label class="fw-bold" for="marca">Escriba la marca</label>
                                <input class="form-control" placeholder="Marca" type="text" maxlength="10" name="marca" id="marca" required />
                            </div>

                            <div class="mb-3">
                                <label class="fw-bold" for="categoria">Seleccione la categoría</label>
                                <select class="form-control" name="categoria" id="categoria" required>
                                    <?php foreach ($categorias as $categoria): ?>
                                        <option value="<?php echo $categoria['cod_categoria']; ?>">
                                            <?php echo htmlspecialchars(trim($categoria['nombre_categoria'])); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="fw-bold" for="link_imagen">Pegue el link de la imagen</label>
                                <input class="form-control" placeholder="Link de imagen" type="text" maxlength="255" name="link_imagen" id="link_imagen" required />
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-dark">
                                    Registrar
                                </button>
                            </div>
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
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Incluir la conexión a la base de datos
    include '../../conexionBD.php';

    // Obtener los valores del formulario
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $marca = $_POST['marca'];
    $categoria = $_POST['categoria'];
    $imagen_url = $_POST['link_imagen'];

    // Preparar la consulta SQL para insertar el producto
    $insertar = "INSERT INTO producto (nombre_producto, descripcion, imagen, marca, cod_categoriaf)
            VALUES ('$nombre', '$descripcion', '$imagen_url', '$marca', '$categoria')";

    // Ejecutar la consulta
    if (mysqli_query($conn, $insertar)) {
        // Obtener el ID del producto recién insertado
        $cod_producto = mysqli_insert_id($conn);
        echo "<script>alert('Producto registrado exitosamente, inserte a inventario'); window.location.href = 'registrar_inventario.php';</script>";
    } else {
        echo "<script>alert('error al registrar el producto'); window.location.href = 'registrar_producto.php';</script>";
    }

    // Cerrar la conexión
    mysqli_close($conn);
}
?>
