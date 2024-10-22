<?php
error_reporting(E_ERROR); 
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








function validarVentaProceso($conn, $cod_usuario){
    $sql = "SELECT count(*) FROM venta WHERE cod_usuariof = ? AND estado_venta = 'EN PROCESO'";
    if ($stmt = mysqli_prepare($conn, $sql)) {
        // Bindear el parámetro cod_usuario
        mysqli_stmt_bind_param($stmt, "i", $cod_usuario);
        
        
        // Ejecutar la consulta
        if (mysqli_stmt_execute($stmt)) {
            // Obtener el resultado
            mysqli_stmt_bind_result($stmt, $count);
            if (mysqli_stmt_fetch($stmt)) {
                mysqli_stmt_close($stmt);  // Cerrar la sentencia preparada
                return $count > 0;  // Retorna true si hay ventas en proceso
            }
        }
        mysqli_stmt_close($stmt);  // Cerrar la sentencia incluso si hubo un error
    }
    
    return false;  // Retorna false en caso de error
}

function codVentaMax($conn, $cod_usuario){
    $sql = "SELECT max(cod_venta) FROM venta WHERE cod_usuariof = ? and estado_venta = 'EN PROCESO'";
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $cod_usuario);
        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_bind_result($stmt, $max_cod_venta);
            mysqli_stmt_fetch($stmt);
            return $max_cod_venta;  
        } 
    }
    return false; // Retornar false en caso de error
}

// Verificar si el carrito está vacío y no existe una venta activa
/*if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito'])) {

    $cod_usuario = $_SESSION['cod_usuario'];
    $validar_venta_proceso = validarVentaProceso($conn,  $cod_usuario);

    if($validar_venta_proceso){
        insertarDetalleVenta($conn);
    }else{
        crearVenta($conn,  $cod_usuario);
        insertarDetalleVenta($conn);
    }

    mostrarTabla(obtenerProductosPedidos( $conn, $cod_usuario));
    exit;
}
*/
// Obtener el nombre de la talla usando el código
function obtenerNombreTalla($conn, $codigoTalla) {
    $sql = "SELECT talla FROM talla WHERE cod_talla = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $codigoTalla);
    $stmt->execute();
    $result = $stmt->get_result();
    $fila = $result->fetch_assoc();
    return $fila ? $fila['talla'] : 'Talla no encontrada';
}

// Obtener el nombre del color usando el código
function obtenerNombreColor($conn, $codigoColor) {
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
    // Asegúrate de que 'cod_inventario' está definido antes de usarlo
    if (!isset($_POST['cod_inventario'])) {
        echo "<div class='alert alert-danger'>Error: 'cod_inventario' no está definido.</div>";
        exit;
    }

    $cod_inventario=  $_POST['cod_inventario'];
    print ("eserere ". $cod_inventarioEliminar);
   
    $cod_usuario = $_SESSION['cod_usuario'];
    $codigo_venta = codVentaMax($conn, $cod_usuario);
    

    // Consulta para eliminar el detalle de venta correspondiente
    $sql = "DELETE FROM detalle_venta WHERE cod_inventariof = ? AND cod_ventaf = ?";
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "ii", $cod_inventario, $codigo_venta);
        if (mysqli_stmt_execute($stmt)) {
            echo "<div class='alert alert-success'>Producto eliminado del carrito.</div>";
            echo '<a href="Mis_compras.php">Volver</a>';
        } else {
            echo "<div class='alert alert-danger'>Error al eliminar el producto: " . mysqli_error($conn) . "</div>";
        }
    }
}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['agregar_carrito'])) {
    $cod_usuario = $_SESSION['cod_usuario'];
    $validar_venta_proceso = validarVentaProceso($conn,  $cod_usuario);

    if($validar_venta_proceso){
        insertarDetalleVenta($conn);
    }else{
        crearVenta($conn,  $cod_usuario);
        insertarDetalleVenta($conn);
    }

    mostrarTabla(obtenerProductosPedidos( $conn, $cod_usuario));
   
}



// Función para crear la venta con total 0 y estado "EN PROCESO"
function crearVenta($conn, $cod_usuario) {
        date_default_timezone_set('America/Guatemala');
        $fecha = date("Y-m-d");    
        $estado_venta = "EN PROCESO";
        $total = 0;  // Inicialmente el total será 0

        $sql = "INSERT INTO venta (fecha, total_venta, estado_venta, cod_usuariof) VALUES (?, ?, ?, ?)";
        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "sdsi", $fecha, $total, $estado_venta, $cod_usuario);
            if (mysqli_stmt_execute($stmt)) {
                return mysqli_insert_id($conn);  // Devuelve el código de la venta recién creada
            } else {
                echo "<div class='alert alert-danger'>Error al crear la venta: " . mysqli_error($conn) . "</div>";
                return false;
            }
        }
}




function obtenerProductosPedidos($conn, $cod_usuarios) {
    // Obtener el código de la venta activa
    $cod_usuario = $_SESSION['cod_usuario'];
    $codigo_venta = codVentaMax($conn, $cod_usuario);
  
    
    $sql = "SELECT prod.nombre_producto, det.cantidad_producto, talla.talla, color.color, inv.cod_inventario,
                   inv.precio_unitario, inv.cod_tallaf, inv.cod_colorf, (inv.precio_unitario * det.cantidad_producto) AS total
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

// Insertar los productos en la tabla detalle_venta con el código de venta asociado
function insertarDetalleVenta($conn){

    $cod_producto = $_POST['cod_producto'];
    
    $cod_color = $_POST['color'];
    $cod_talla = $_POST['talla'];
    $cantidad_solicitada = $_POST['cantidad'];
    if ($cantidad_solicitada == NULL){
        $cantidad_solicitada = 1;
    }
    $cod_inventario = $_POST['cod_inventario'];
    $cod_usuario = $_SESSION['cod_usuario'];
    $precio_unitario = $_POST['precio_unitario'];
    $codigo_venta = codVentaMax($conn, $cod_usuario); // Usar el código de la venta almacenada en sesión
   
        if ($codigo_venta == NULL){
            crearVenta($conn, $cod_usuario);
            $codigo_venta = codVentaMax($conn, $cod_usuario); 
        }            
        $sql_detalle = "INSERT INTO detalle_venta (cantidad_producto, cod_ventaf, cod_inventariof, precio_unitario) VALUES (?, ?, ?, ?)";
        if ($stmt_detalle = mysqli_prepare($conn, $sql_detalle)) {
            mysqli_stmt_bind_param($stmt_detalle, "iiid", $cantidad_solicitada, $codigo_venta, $cod_inventario, $precio_unitario);
            if (mysqli_stmt_execute($stmt_detalle)) {
                echo "<div class='alert alert-success'>Producto agregado a la venta.</div>";
            } else {
                echo "<div class='alert alert-danger'>Error al agregar producto: " . mysqli_error($conn) . "</div>";
            }
        }
    

           
    }


//Funcion de Finalizar compra

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['finalizar_compra'])) {
   
    //Funcion de compra 
    finalizarCompra($conn, $_SESSION['cod_usuario'], codVentaMax($conn, $cod_usuario));

}

// Función para finalizar la compra
function finalizarCompra($conn, $cod_usuario, $codigo_venta) {
    
    // Preparar la consulta para actualizar la venta a 'Finalizado'
    $sql_detalle = "UPDATE venta SET estado_venta = 'Finalizado', total_venta = ? WHERE cod_venta = ?";
    if ($stmt_detalle = mysqli_prepare($conn, $sql_detalle)) {
        // Obtener el total de la venta con una función
        $total_venta = traerTotalVenta($conn, $codigo_venta);
        // Asociar los parámetros (total de la venta y código de venta)
        mysqli_stmt_bind_param($stmt_detalle, "di", $total_venta, $codigo_venta);
        // Ejecutar la consulta
        if (mysqli_stmt_execute($stmt_detalle)) {
            echo "<div class='alert alert-success'>Venta finalizada con éxito.</div>";
            $productos = [];
        } else {
            echo "<div class='alert alert-danger'>Error al finalizar la venta: " . mysqli_error($conn) . "</div>";
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['comprar'])) {
    // Si existen métodos de pago, redirigir a la página de selección de método
if (!empty(metodosPagos($conn, $cod_usuario))) {
    // Redirigir a la página del formulario para seleccionar un método de pago
    header("Location: procesar_pago.php");
    exit();
} else {
    // Si no hay métodos de pago, redirigir al formulario para agregar un nuevo método
    header("Location: ../pago/metodo_pago.php");
    exit();
}

}

// Función para consultar los métodos de pago
function metodosPagos($conn, $cod_usuario) {
    $cod_usuario = $_SESSION['cod_usuario'];
    // Preparar la consulta para devolver los métodos de pago
    $sql_detalle = "SELECT usuario.nick_name, metodo_pago.numero_tarjeta, metodo_pago.cod_metodo, metodo_pago.nombre_titular  FROM usuario
     INNER JOIN metodo_pago on usuario.cod_usuario = metodo_pago.cod_usuariof where cod_usuariof = ?; ";
    if ($stmt_detalle = mysqli_prepare($conn, $sql_detalle)) {
        // Asociar los parámetros
        mysqli_stmt_bind_param($stmt_detalle, "i", $cod_usuario);
        // Ejecutar la consulta
        mysqli_stmt_execute($stmt_detalle);
        $result = mysqli_stmt_get_result($stmt_detalle);
        
        $metodos = [];
        while ($fila = mysqli_fetch_assoc($result)) {
            $metodos[] = $fila;
        }
        return $metodos;
    } else {
        return [];
    }
}




// Función para traer el total de la venta
function traerTotalVenta($conn, $codigo_venta) {
    // Suponiendo que tienes una tabla detalle_venta para obtener el total
    $sql = "SELECT SUM(cantidad_producto * precio_unitario) AS total_venta FROM detalle_venta WHERE cod_ventaf = ?";
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $codigo_venta);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $total_venta);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
        return $total_venta;
    }
    return 0;  // En caso de error, devolver 0
}





function mostrarTabla($productos){
    $productos_pedidos = $productos;
    if ($productos_pedidos === false || empty($productos_pedidos)) {
        echo "<p>No hay productos en el carrito.</p>";
        echo '<a href="dama.php">Volver</a>';
    } else {
        ?>
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <title>Carrito de Compras</title>
        </head>
        <body>
            <h1>Carrito de Compras</h1>
            <form method="POST"> 
            <table border="1">
                <thead>
                    <tr>
                        <th>Nombre Producto</th>
                        <th>Cantidad</th>
                        <th>Talla</th>
                        <th>Color</th>
                        <th>Precio Unitario</th>
                        <th>Total</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($productos_pedidos as $producto) : 
                        $total_compra += $producto['total'];?>
                    <tr>
                        <td><?php echo htmlspecialchars($producto['nombre_producto']); ?></td>
                        <td><?php echo $producto['cantidad_producto']; ?></td>
                        <td><?php echo ($producto['talla']); ?></td>
                        <td><?php echo ($producto['color']); ?></td>
                        <td><?php echo number_format($producto['precio_unitario'], 2); ?></td>
                        <td><?php echo number_format($producto['total'], 2); ?></td>
                        <td>
                          
                                <input type="hidden" name="cod_inventarioEliminar" value="<?php echo $producto['cod_inventario']; ?>">
                                <input type="hidden" name="cod_talla" value="<?php echo $producto['cod_tallaf']; ?>">
                                <input type="hidden" name="cod_color" value="<?php echo $producto['cod_colorf']; ?>">
                                <input type="submit" name="eliminar" value="Eliminar">
                            
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="5" style="text-align: right;"><strong>Total de la compra:</strong></td>
                        <td colspan="2"><?php echo number_format($total_compra, 2); ?></td>
                    </tr>
                </tbody>
            </table>
            <input type="submit" name="comprar" value="Comprar">
            </form>
            <a href="dama.php">Volver a catálogo</a>
    
        </body>
        </html>
        <?php
    }
}

// Verificar si hay productos

//mysqli_close($conn);  // Cerrar la conexión a la base de datos
?>
