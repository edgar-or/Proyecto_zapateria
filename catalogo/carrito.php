<?php
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



session_start();
include '../conexionBD.php';  // Asegúrate de incluir la conexión

if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito'])) {
    echo "<p>El carrito está vacío.</p>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['eliminar'])) {
    // Eliminar un producto del carrito
    $indice = $_POST['indice'];
    unset($_SESSION['carrito'][$indice]);
    $_SESSION['carrito'] = array_values($_SESSION['carrito']); // Reindexar el carrito
}

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
                <th>Costo Total</th> <!-- Nueva columna para el costo total -->
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $total = 0; // Inicializa la variable para la suma total
            foreach ($_SESSION['carrito'] as $indice => $producto): 
                // Obtener nombres de talla y color desde los códigos almacenados en el carrito
                $nombre_talla = obtenerNombreTalla($producto['talla'], $conn);
                $nombre_color = obtenerNombreColor($producto['color'], $conn);
                
                // Calcular el costo total del producto en esta fila
                $costo_total = $producto['precio'] * $producto['cantidad'];
                $total += $costo_total; // Sumar el costo total al total general
            ?>
            <tr>
                <td><?php echo $producto['nombre_producto']; ?></td>
                <td><?php echo $producto['cantidad']; ?></td>
                <td><?php echo $nombre_talla; ?></td> <!-- Mostrar el nombre de la talla -->
                <td><?php echo $nombre_color; ?></td>
                <td><?php echo number_format($producto['precio'], 2); ?> USD</td> <!-- Mostrar precio unitario -->
                <td><?php echo number_format($costo_total, 2); ?> USD</td> <!-- Mostrar costo total -->
                <td>
                    <form method="POST" action="">
                        <input type="hidden" name="indice" value="<?php echo $indice; ?>">
                        <button type="submit" name="eliminar">Eliminar</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h3>Total: <?php echo number_format($total, 2); ?> USD</h3> <!-- Mostrar el total formateado -->

    <a href="dama.php">Volver al Catálogo</a>
</body>
</html>
