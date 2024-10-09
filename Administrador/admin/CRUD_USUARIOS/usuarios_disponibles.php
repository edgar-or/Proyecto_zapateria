<?php
// Conexión a la base de datos
$conexion = new mysqli('localhost', 'root', '', 'the_walkers_db');

if ($conexion->connect_error) {
    die('Conexión fallida: ' . $conexion->connect_error);
}

// Definir el número de resultados por página
$limit = 20;

// Obtener el número de página actual desde la URL, por defecto es 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
if ($page < 1) { $page = 1; }

// Calcular el desplazamiento (offset) para la consulta SQL
$offset = ($page - 1) * $limit;

// Obtener el total de usuarios
$count_query = "SELECT COUNT(*) AS total FROM usuario";
$result_count = $conexion->query($count_query);
$total_usuarios = 0;
if ($result_count) {
    $row_count = $result_count->fetch_assoc();
    $total_usuarios = $row_count['total'];
}

// Calcular el total de páginas necesarias
$total_pages = ceil($total_usuarios / $limit);

// Obtener los usuarios para la página actual
$query_usuarios = "SELECT cod_usuario, primer_nombre, primer_apellido, tipo_usuario, telefono_usuario, correo_usuario, nick_name FROM usuario ORDER BY cod_usuario DESC LIMIT ? OFFSET ?";
$stmt_usuarios = $conexion->prepare($query_usuarios);
$stmt_usuarios->bind_param('ii', $limit, $offset);
$stmt_usuarios->execute();
$result_usuarios = $stmt_usuarios->get_result();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todos los Usuarios Registrados</title>
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
                        <li><a class="dropdown-item" href="../admin/CRUD_PRODUCTOS/registrar_producto.php">Registrar Producto</a></li>
                        <li><a class="dropdown-item" href="../admin/CRUD_PRODUCTOS/consultar_producto.php">Consultar Producto</a></li>
                        <li><a class="dropdown-item" href="../admin/CRUD_PRODUCTOS/modificar_producto.php">Modificar Producto</a></li>
                        <li><a class="dropdown-item" href="../admin/CRUD_PRODUCTOS/eliminar_producto.php">Eliminar Producto</a></li>
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
    <p class="fs-5 text-center" style="margin-top: 0px; color: white; background-color: #16aef0; font-family: 'Franklin Gothic Medium', 'cursive';">
        Todos los Usuarios Registrados
    </p>

    <div class="container mt-5">
        <div class="row">
            <!-- Tabla de todos los usuarios -->
            <div class="col-md-12">
                <h4>Lista Completa de Usuarios</h4>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Tipo de Usuario</th>
                            <th>Teléfono</th>
                            <th>Correo Electrónico</th>
                            <th>Nickname</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result_usuarios->num_rows > 0) { ?>
                            <?php while ($row = $result_usuarios->fetch_assoc()) { ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['cod_usuario']); ?></td>
                                    <td><?php echo htmlspecialchars($row['primer_nombre']); ?></td>
                                    <td><?php echo htmlspecialchars($row['primer_apellido']); ?></td>
                                    <td><?php echo htmlspecialchars($row['tipo_usuario']); ?></td>
                                    <td><?php echo htmlspecialchars($row['telefono_usuario']); ?></td>
                                    <td><?php echo htmlspecialchars($row['correo_usuario']); ?></td>
                                    <td><?php echo htmlspecialchars($row['nick_name']); ?></td>
                                </tr>
                            <?php } ?>
                        <?php } else { ?>
                            <tr>
                                <td colspan="7" class="text-center">No hay usuarios registrados.</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

                <!-- Paginación -->
                <?php if ($total_pages > 1) { ?>
                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-center">
                            <!-- Botón de página anterior -->
                            <li class="page-item <?php if ($page <= 1) echo 'disabled'; ?>">
                                <a class="page-link" href="?page=<?php echo $page - 1; ?>" tabindex="-1">Anterior</a>
                            </li>

                            <!-- Botones de número de página -->
                            <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                                <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                                    <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                </li>
                            <?php } ?>

                            <!-- Botón de siguiente página -->
                            <li class="page-item <?php if ($page >= $total_pages) echo 'disabled'; ?>">
                                <a class="page-link" href="?page=<?php echo $page + 1; ?>">Siguiente</a>
                            </li>
                        </ul>
                    </nav>
                <?php } ?>

                <!-- Botón para regresar a la página de registro -->
                <div class="d-flex justify-content-end mt-3">
                    <a href="registrar_usuarios.php" class="btn btn-primary">Volver al Registro</a>
                </div>
            </div>
        </div>
    </div>
    <br><br><br>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
