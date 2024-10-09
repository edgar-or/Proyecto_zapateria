<?php
include '../../conexionBD.php';
error_reporting(E_ERROR | E_PARSE); 

$cod_producto = $_GET['cod_producto'];



// Obtener todos los usuarios
$query_productos = "SELECT cod_producto, nombre_producto FROM producto";
$result_productos = $conn->query($query_productos);

// Consulta para obtener todos los colores
$sql_colores = "SELECT cod_color, color FROM color";
$resultado_colores = mysqli_query($conn, $sql_colores);

// Verificar si hay resultados
if (mysqli_num_rows($resultado_colores) > 0) {
    $colores = mysqli_fetch_all($resultado_colores, MYSQLI_ASSOC);
}

// Consulta para obtener todas las tallas
$sql_tallas = "SELECT cod_talla, talla FROM talla";
$resultado_tallas = mysqli_query($conn, $sql_tallas);

// Verificar si hay resultados
if (mysqli_num_rows($resultado_tallas) > 0) {
    $tallas = mysqli_fetch_all($resultado_tallas, MYSQLI_ASSOC);
}

?>




<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../../bootstrap-5.3.3-dist/css/bootstrap.min.css">
  <link rel="icon" href="../../imagenes/Index/logo-icono.ico" type="image/x-icon">
  <!-- Bootstrap Icons -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.css" >
  <title>Administracion</title>
</head>

<body>

     <!-- Banner de la pagina -->
     <nav class="navbar bg-body-tertiary">
      <div class="container-fluid fixed-width-container"
          style="background-color: #020304; font-family: 'Franklin Gothic Medium';">
          <a class="navbar-brand" href="#" style="background-color: #020304; color: white; font-size: 50px;">
              <img src="../../../imagenes/001-Index/Logos/Logo.png" alt="Logo" width="90" height="90"
                  class="d-inline-block align-text-center" style="background-color: #CC9E61;">
              THE WALKERS
          </a>
          <ul class="nav nav-tabs" style="margin-top: 4rem; font-size: 20px;">
              <li class="nav-item">
                  <a class="nav-link active" aria-current="page" href="../../index.html">INICIO</a>
              </li>
              <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button"
                      aria-expanded="false" style="color: white;">Productos</a>
                  <ul class="dropdown-menu">
                      <li><a class="dropdown-item" href="registrar_producto.php">Registrar Producto</a></li>
                      <li><a class="dropdown-item" href="consultar_producto.php">Consultar Producto</a></li>
                      <li><a class="dropdown-item" href="modificar_producto.php">Modificar Producto</a></li>
                      
                      <li><a class="dropdown-item" href="eliminar_producto.php">Eliminar Producto</a></li>
                      <li><a class="dropdown-item" href="registrar_inventario.php">Registrar Inventario</a></li>
                  </ul>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button"
                    aria-expanded="false" style="color: white;">Usuarios</a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="../CRUD_USUARIOS/registrar_usuarios.php">Registrar Usuario</a></li>
                    <li><a class="dropdown-item" href="../CRUD_USUARIOS/consultar_usuarios.php">Consultar Usuario</a></li>
                    <li><a class="dropdown-item" href="../CRUD_USUARIOS/modificar_usuarios.php">Modificar Usuario</a></li>
                    <li><a class="dropdown-item" href="../CRUD_USUARIOS/eliminar_usuarios.php">Eliminar Usuario</a></li>
                    
                </ul>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../creditos/creditos.html" style="color: white;">Creditos</a>
          </li>
          </ul>
      </div>
  </nav>
  <div class="container mt-5">
        <div class="row">
            <!-- Tabla de usuarios a la izquierda -->
            <div class="col-md-4">
                <h4>Productos</h4>
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
                            <td><a name="cod_producto" href="?cod_producto=<?php echo $row['cod_producto']; ?>"><?php echo $row['cod_producto']; ?></a></td>
                            <td><?php echo $row['nombre_producto']; ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>


  <form action="registrar_inventario.php" method="POST">
        <center>
        <?php if ($query_productos) { ?>
            <div>
                <label for="talla">Seleccione la talla</label>
                <select name="talla" required>
                    <?php foreach ($tallas as $talla): ?>
                        <option value="<?php echo $talla['cod_talla']; ?>"><?php echo htmlspecialchars(trim($talla['talla'])); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label for="color">Seleccione el color</label>
                <select name="color" required>
                    <?php foreach ($colores as $color): ?>
                        <option value="<?php echo $color['cod_color']; ?>"><?php echo htmlspecialchars(trim($color['color'])); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label for="cantidad">Digite la cantidad</label>
                <input type="number" name="cantidad" required />
            </div>
            <label>Cod_producto: </label>
            <input type="text" name="cod_producto" value="<?php echo ($cod_producto)?>" />
            <div>
                <button type="submit">Registrar Inventario</button>
            </div>
            <?php } else { ?>
                    <p>Selecciona un usuario para modificar sus credenciales.</p>
                <?php } ?>
        </center>
    </form>
              


 


 
    
  

  <!-- Script de Bootstrap -->
  <script src="../../bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>


<?php
include '../../conexionBD.php';

error_reporting(E_ERROR | E_PARSE); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capturar los datos del formulario
    $cantidad = $_POST['cantidad'];
    $cod_producto = $_POST['cod_producto'];
    $color = $_POST['color']; 
    $talla = $_POST['talla']; 

    // Verificar si ya existe el registro con la misma combinación de cod_producto, cod_colorf y cod_tallaf
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

        $insertInventario = "INSERT INTO inventario (cantidad, cod_productof, cod_colorf, cod_tallaf) VALUES ('$cantidad', '$cod_producto', '$color', '$talla')";

        if (mysqli_query($conn, $insertInventario)) {
            echo "<script>alert('cantidad en inventario agregada exitosamente'); window.location.href = 'registrar_inventario.php';</script>";
        } else {
            echo "<script>alert('Error al registrar inventario: " . mysqli_error($conn) . "'); window.location.href = 'registrar_inventario.php';</script>";
        }
    }
}

// Cerrar la conexión
mysqli_close($conn);
?>

