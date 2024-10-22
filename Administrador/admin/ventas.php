<?php
ini_set('memory_limit', '1024M'); // Ajusta el valor de la memoria para almacenar el pdf

// Conectar a la base de datos
$host = "localhost";
$dbname = "the_walkers_db";
$username = "root";
$password = "";

require 'dompdf/vendor/autoload.php'; // Asegúrate de que la ruta sea correcta

use Dompdf\Dompdf;
use Dompdf\Options;

try {
    $ventas = [];
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Consultar las ventas con unión de las tablas
    $query = "
    SELECT v.cod_venta, v.fecha, v.total_venta, v.estado_venta, 
           u.primer_nombre, u.primer_apellido, 
           dv.cantidad_producto, dv.cod_inventariof, 
           p.nombre_producto, dv.precio_unitario, p.descripcion 
    FROM venta v 
    JOIN usuario u ON v.cod_usuariof = u.cod_usuario
    JOIN detalle_venta dv ON v.cod_venta = dv.cod_ventaf
    INNER JOIN inventario i ON dv.cod_inventariof = i.cod_inventario
    INNER JOIN  producto p ON i.cod_productof = p.cod_producto
";

    $conditions = [];

    // Filtrar por fecha, estado y usuario si se envió el formulario
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (!empty($_POST['fecha'])) {
            $conditions[] = "v.fecha = :fecha";
        }
        if (!empty($_POST['estado_venta'])) {
            $conditions[] = "v.estado_venta = :estado_venta";
        }
        if (!empty($_POST['usuario'])) {
            $conditions[] = "u.cod_usuario = :usuario";
        }

        // Agregar condiciones a la consulta si existen
        if (count($conditions) > 0) {
            $query .= " WHERE " . implode(" AND ", $conditions);
        }
    }

    // Preparar y ejecutar la consulta
    $stmt = $pdo->prepare($query);
    
    // Vincular parámetros si se envió el formulario
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (!empty($_POST['fecha'])) {
            $stmt->bindParam(':fecha', $_POST['fecha']);
        }
        if (!empty($_POST['estado_venta'])) {
            $stmt->bindParam(':estado_venta', $_POST['estado_venta']);
        }
        if (!empty($_POST['usuario'])) {
            $stmt->bindParam(':usuario', $_POST['usuario']);
        }
    }

    $stmt->execute();
    $ventas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Obtener usuarios para el filtro
    $usuariosQuery = "SELECT cod_usuario, primer_nombre, primer_apellido FROM usuario";
    $usuariosStmt = $pdo->prepare($usuariosQuery);
    $usuariosStmt->execute();
    $usuarios = $usuariosStmt->fetchAll(PDO::FETCH_ASSOC);
    
} catch (PDOException $e) {
    echo "<div class='alert alert-danger mt-3'>Error: " . $e->getMessage() . "</div>";
}

// Generar el PDF si se solicita
if (isset($_POST['generar_reporte'])) {
    $options = new Options();
    $options->set('defaultFont', 'Arial');
    $dompdf = new Dompdf($options);

    // Repetir la consulta para el PDF con los mismos filtros
    $pdfQuery = "
    SELECT v.cod_venta, v.fecha, v.total_venta, v.estado_venta, 
           u.primer_nombre, u.primer_apellido, 
           dv.cantidad_producto, dv.cod_inventariof, 
           p.nombre_producto, dv.precio_unitario, p.descripcion 
    FROM venta v 
    JOIN usuario u ON v.cod_usuariof = u.cod_usuario
    JOIN detalle_venta dv ON v.cod_venta = dv.cod_ventaf
    INNER JOIN inventario i ON dv.cod_inventariof = i.cod_inventario
    INNER JOIN  producto p ON i.cod_productof = p.cod_producto
    ";

    $pdfConditions = [];

    // Añadir las mismas condiciones que antes
    if (!empty($_POST['fecha'])) {
        $pdfConditions[] = "v.fecha = :fecha";
    }
    if (!empty($_POST['estado_venta'])) {
        $pdfConditions[] = "v.estado_venta = :estado_venta";
    }
    if (!empty($_POST['usuario'])) {
        $pdfConditions[] = "u.cod_usuario = :usuario";
    }

    // Agregar condiciones a la consulta PDF
    if (count($pdfConditions) > 0) {
        $pdfQuery .= " WHERE " . implode(" AND ", $pdfConditions);
    }

    // Preparar y ejecutar la consulta PDF
    $pdfStmt = $pdo->prepare($pdfQuery);
    
    // Vincular parámetros para PDF
    if (!empty($_POST['fecha'])) {
        $pdfStmt->bindParam(':fecha', $_POST['fecha']);
    }
    if (!empty($_POST['estado_venta'])) {
        $pdfStmt->bindParam(':estado_venta', $_POST['estado_venta']);
    }
    if (!empty($_POST['usuario'])) {
        $pdfStmt->bindParam(':usuario', $_POST['usuario']);
    }

    $pdfStmt->execute();
    $pdfVentas = $pdfStmt->fetchAll(PDO::FETCH_ASSOC);

    // Crear el HTML para el reporte
    $html = '<h2>Reporte de Ventas</h2>';
    $html .= '<table border="1" cellspacing="0" cellpadding="5">
                <thead>
                    <tr>
                        <th>Código Venta</th>
                        <th>Fecha</th>
                        <th>Total Venta</th>
                        <th>Estado Venta</th>
                        <th>Nombre Comprador</th>
                        <th>Cantidad Producto</th>
                        <th>Nombre Producto</th>
                        <th>Precio Producto</th>
                    </tr>
                </thead>
                <tbody>';

    foreach ($pdfVentas as $venta) {
        $html .= '<tr>
                    <td>' . htmlspecialchars($venta['cod_venta']) . '</td>
                    <td>' . htmlspecialchars($venta['fecha']) . '</td>
                    <td>' . htmlspecialchars($venta['total_venta']) . '</td>
                    <td>' . htmlspecialchars($venta['estado_venta']) . '</td>
                    <td>' . htmlspecialchars($venta['primer_nombre'] . ' ' . $venta['primer_apellido']) . '</td>
                    <td>' . htmlspecialchars($venta['cantidad_producto']) . '</td>
                    <td>' . htmlspecialchars($venta['nombre_producto']) . '</td>
                    <td>' . htmlspecialchars($venta['precio_unitario']) . '</td>
                </tr>';
    }

    $html .= '</tbody></table>';
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'landscape');
    $dompdf->render();
    $dompdf->stream("reporte_ventas.pdf", ["Attachment" => true]);
    exit; // Salir para evitar que el resto del HTML se muestre
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="icon" href="../imagenes/001-Index/Logos/walker.ico" type="image/x-icon">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <title>Consulta de Ventas</title>
</head>
<?php
session_start(); // Inicia la sesión
// Verifica si el usuario ha iniciado sesión y es administrador
if (!isset($_SESSION['cod_usuario']) || $_SESSION['tipo_usuario'] !== 'admin') {
    // Si no ha iniciado sesión o no es admin, redirigir al index.php
    header("Location: ../../login/login.php");
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
    <p class="fs-5 text-center" style="margin-top: 0px; color: white; background-color: #6c6c6c; font-family: 'Franklin Gothic Medium', 'cursive';">Registros de ventas</p>
    <div class="container mt-5">
 
        <form method="POST" class="mb-4">
            <div class="row">
                <div class="col-md-4">
                    <label for="fecha" class="form-label">Fecha:</label>
                    <input type="date" class="form-control" name="fecha" id="fecha" value="<?php echo isset($_POST['fecha']) ? htmlspecialchars($_POST['fecha']) : ''; ?>">
                </div>
                <div class="col-md-4">
                    <label for="estado_venta" class="form-label">Estado:</label>
                    <select class="form-select" name="estado_venta" id="estado_venta">
                        <option value="">Seleccione estado</option>
                        <option value="FINALIZADA" <?php if (isset($_POST['estado_venta']) && $_POST['estado_venta'] == 'FINALIZADA') echo 'selected'; ?>>FINALIZADA</option>
                        <option value="PENDIENTE" <?php if (isset($_POST['estado_venta']) && $_POST['estado_venta'] == 'PENDIENTE') echo 'selected'; ?>>PENDIENTE</option>
                        <option value="EN PROCESO" <?php if (isset($_POST['estado_venta']) && $_POST['estado_venta'] == 'EN PROCESO') echo 'selected'; ?>>EN PROCESO</option>
                        <option value="CANCELADA" <?php if (isset($_POST['estado_venta']) && $_POST['estado_venta'] == 'CANCELADA') echo 'selected'; ?>>CANCELADA</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="usuario" class="form-label">Usuario:</label>
                    <select class="form-select" name="usuario" id="usuario">
                        <option value="">Seleccione usuario</option>
                        <?php foreach ($usuarios as $usuario) : ?>
                            <option value="<?php echo $usuario['cod_usuario']; ?>" <?php if (isset($_POST['usuario']) && $_POST['usuario'] == $usuario['cod_usuario']) echo 'selected'; ?>>
                                <?php echo htmlspecialchars($usuario['primer_nombre'] . ' ' . $usuario['primer_apellido']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <br>
            <button type="submit" class="btn btn-dark">Filtrar</button>
            <button type="submit" name="generar_reporte" class="btn btn-success">Generar PDF</button>
        </form>

        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Código Venta</th>
                    <th>Fecha</th>
                    <th>Total Venta</th>
                    <th>Estado Venta</th>
                    <th>Nombre Comprador</th>
                    <th>Cantidad Producto</th>
                    <th>Nombre Producto</th>
                    <th>Precio Producto</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($ventas) > 0): ?>
                    <?php foreach ($ventas as $venta): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($venta['cod_venta']); ?></td>
                            <td><?php echo htmlspecialchars($venta['fecha']); ?></td>
                            <td><?php echo htmlspecialchars($venta['total_venta']); ?></td>
                            <td><?php echo htmlspecialchars($venta['estado_venta']); ?></td>
                            <td><?php echo htmlspecialchars($venta['primer_nombre'] . ' ' . $venta['primer_apellido']); ?></td>
                            <td><?php echo htmlspecialchars($venta['cantidad_producto']); ?></td>
                            <td><?php echo htmlspecialchars($venta['nombre_producto']); ?></td>
                            <td><?php echo htmlspecialchars($venta['precio_unitario']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="text-center">No hay ventas que mostrar.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script src="../bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
