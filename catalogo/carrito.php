<?php
session_start();
include '../conexionBD.php';  // Conexión a la base de datos

// Verificar si el usuario está logueado
if (!isset($_SESSION['cod_usuario'])) {
    header("Location: ../login/login.php");
    exit;
}

// Obtener el código de usuario de la sesión
$cod_usuario = $_SESSION['cod_usuario'];
$nick_name = $_SESSION['nick_name'];
date_default_timezone_set('America/Guatemala');
$fecha = date("Y-m-d");

// Función para crear la venta con total 0 y estado "EN PROCESO"
function crearVenta($cod_usuario, $fecha, $conn) {
    if (!validarVentaProceso($cod_usuario, $conn)){ 
    $estado_venta = "EN PROCESO";
    $total = 0;  // Inicialmente el total será 0

    $sql = "INSERT INTO venta (fecha, total_venta, estado_venta, cod_usuariof) VALUES (?, ?, ?, ?)";
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "sdss", $fecha, $total, $estado_venta, $cod_usuario);
        if (mysqli_stmt_execute($stmt)) {
            return mysqli_insert_id($conn);  // Devuelve el código de la venta recién creada
        } else {
            echo "<div class='alert alert-danger'>Error al crear la venta: " . mysqli_error($conn) . "</div>";
            return false;
        }
    }
    return false;
}
}

function validarVentaProceso($cod_usuario, $conn){
    $sql = "SELECT count(*) FROM venta where cod_usuariof = ? and estado_venta = 'EN PROCESO'";
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $cod_usuario);
        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_bind_result($stmt, $count);
            mysqli_stmt_fetch($stmt);
            return $count;
            return $count > 0;  
        } 
    }
}
function codVentaMax($cod_usuario, $conn){
    
    $sql = "SELECT max(cod_venta) FROM venta WHERE cod_usuariof = ? and estado_venta = 'EN PROCESO'";
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $cod_usuario);
        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_bind_result($stmt, $max_cod_venta);
            mysqli_stmt_fetch($stmt);
            return $max_cod_venta;  
        } 
    }
}
//


// Verificar si el carrito está vacío y no existe una venta activa
if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito'])) {
    // Crear una nueva venta si no existe una
    if (!isset($_SESSION['codigo_venta'])) {
        $codigo_venta = crearVenta($cod_usuario, $fecha, $conn);
        if ($codigo_venta) {
            $_SESSION['codigo_venta'] = $codigo_venta;
            echo "<p>Venta creada con código: $codigo_venta</p>";
        }
    } else {
        echo "<p>El carrito está vacío.</p>";
    }
    exit;
}

// Obtener el nombre de la talla usando el código
function obtenerNombreTalla($codigoTalla, $conn) {
    $sql = "SELECT talla FROM talla WHERE cod_talla = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $codigoTalla);
    $stmt->execute();
    $result = $stmt->get_result();
    $fila = $result->fetch_assoc();
    return $fila ? $fila['talla'] : 'Talla no encontrada';
}

// Obtener el nombre del color usando el código
function obtenerNombreColor($codigoColor, $conn) {
    $sql = "SELECT color FROM color WHERE cod_color = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $codigoColor);
    $stmt->execute();
    $result = $stmt->get_result();
    $fila = $result->fetch_assoc();
    return $fila ? $fila['color'] : 'Color no encontrado';
}

// Verificar si se ha enviado el formulario para eliminar un producto del carrito
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['eliminar'])) {
    $cod_inventario = $_POST['cod_inventario'];  // Obtener el código de inventario enviado por el formulario
    $codigo_venta = codVentaMax($cod_usuario, $conn);  // Obtener el código de la venta en proceso

    // Consulta para eliminar el detalle de venta correspondiente
    $sql = "DELETE FROM detalle_venta WHERE cod_inventariof = ? AND cod_ventaf = ?";
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "ii", $cod_inventario, $codigo_venta);
        if (mysqli_stmt_execute($stmt)) {
            echo "<div class='alert alert-success'>Producto eliminado del carrito.</div>";
        } else {
            echo "<div class='alert alert-danger'>Error al eliminar el producto: " . mysqli_error($conn) . "</div>";
        }
    }
}

// Verificar si el carrito tiene productos
if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito'])) {
    echo "<p>El carrito está vacío.</p>";
    exit;
}

// Insertar los productos en la tabla detalle_venta con el código de venta asociado
foreach ($_SESSION['carrito'] as $producto) {
    $cantidad = $producto['cantidad'];
    $cod_inventario = $producto['cod_inventario'];
    $precio_unitario = $producto['precio'];
    $codigo_venta = codVentaMax($cod_usuario, $conn);  // Usar el código de la venta almacenada en sesión

    $sql_detalle = "INSERT INTO detalle_venta (cantidad_producto, cod_ventaf, cod_inventariof, precio_unitario) VALUES (?, ?, ?, ?)";
    if ($stmt_detalle = mysqli_prepare($conn, $sql_detalle)) {
        mysqli_stmt_bind_param($stmt_detalle, "iiid", $cantidad, $codigo_venta, $cod_inventario, $precio_unitario);
        if (mysqli_stmt_execute($stmt_detalle)) {
            echo "<div class='alert alert-success'>Producto agregado a la venta.</div>";
        } else {
            echo "<div class='alert alert-danger'>Error al agregar producto: " . mysqli_error($conn) . "</div>";
        }
    }
}




function obtenerProductosPedidos($cod_usuario, $conn) {
    // Obtener el código de la venta activa
    $codigo_venta = codVentaMax($cod_usuario, $conn);
    print("este es el codigo de venta ". $codigo_venta);
    
    $sql = "SELECT prod.nombre_producto, det.cantidad_producto, talla.talla, color.color, inv.cod_inventario,
                   inv.precio_unitario,(inv.precio_unitario * det.cantidad_producto) AS total
            FROM detalle_venta AS det
            INNER JOIN inventario AS inv ON det.cod_inventariof = inv.cod_inventario
            INNER JOIN producto AS prod ON prod.cod_producto = inv.cod_productof
            INNER JOIN talla ON talla.cod_talla = inv.cod_tallaf
            INNER JOIN color ON color.cod_color = inv.cod_colorf
            WHERE det.cod_ventaf = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $codigo_venta);  // Usa el valor de $codigo_venta
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Inicializar un array para guardar todos los productos
    $productos = [];
    while ($fila = $result->fetch_assoc()) {
        $productos[] = $fila;
    }

    return $productos;
}

?>
<?php
$productos_pedidos = obtenerProductosPedidos($cod_usuario, $conn);

// Verificar si hay productos
if ($productos_pedidos === false || empty($productos_pedidos)) {
    echo '<p>No hay productos en el pedido.</p>';
} else {
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
</head>
<body>
    <h2>Carrito de Compras</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Talla</th>
                <th>Color</th>
                <th>Precio Unitario</th>
                <th>Costo Total</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $total = 0; // Inicializar el total

            foreach ($productos_pedidos as $producto) {
                $total = $producto['total']; // Acumular el total
            ?>
            <tr>
                <td><?php echo htmlspecialchars($producto['nombre_producto']); ?></td>
                <td><?php echo htmlspecialchars($producto['cantidad_producto']); ?></td>
                <td><?php echo htmlspecialchars($producto['talla']); ?></td>
                <td><?php echo htmlspecialchars($producto['color']); ?></td>
                <td><?php echo number_format($producto['precio_unitario'], 2); ?> USD</td>
                <td><?php echo number_format($producto['total'], 2); ?> USD</td>
                <td>
                    <form method="POST" action="">
                    <input type="hidden" name="cod_inventario" value="<?php echo $producto['cod_inventario']; ?>">
                        <button type="submit" name="eliminar">Eliminar</button>
                    </form>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

    <h3>Total: <?php echo number_format($total, 2); ?> USD</h3>
    <a href="dama.php">Volver al Catálogo</a>
    <form method="POST" action="">
        <button type="submit" name="finalizar_compra">Finalizar Compra</button>
    </form>
</body>
</html>

<?php
}
?>






<?php

// Al finalizar la compra, actualizar el total y estado de la venta
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['finalizar_compra'])) {
    $total = number_format($total, 2);
    $estado_venta = "FINALIZADA";
    $codigo_venta = codVentaMax($cod_usuario, $conn);

    $sql = "UPDATE venta SET total_venta = ?, estado_venta = ? WHERE cod_venta = ?";
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "dsi", $total, $estado_venta, $codigo_venta);
        if (mysqli_stmt_execute($stmt)) {

            echo "<div class='alert alert-success'>Compra finalizada.</div>";
        } else {
            echo "<div class='alert alert-danger'>Error: " . mysqli_error($conn) . "</div>";
        }
    }
}
?>
