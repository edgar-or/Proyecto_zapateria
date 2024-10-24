<!-- PHP -->
<?php
session_start();
//SCRIP PARA INCLUIR LA CONEXION A LA BASE DE DATOS THE_WALKERS_DB
include '../conexionBD.php';
//SCRIP PARA REALIXAR LASCONSULTAS PARA EL CATALOGO
$sql = "SELECT inventario.cod_inventario, inventario.precio_unitario, producto.nombre_producto, producto.cod_producto, producto.imagen, producto.descripcion, producto.marca, color.color, talla.talla,
GROUP_CONCAT(DISTINCT color.color SEPARATOR ',') as colores, 
GROUP_CONCAT(DISTINCT color.cod_color SEPARATOR ',') as cod_colores, 
GROUP_CONCAT(DISTINCT talla.talla SEPARATOR ',') as tallas,
GROUP_CONCAT(DISTINCT talla.cod_talla SEPARATOR ',') as cod_tallas
FROM inventario 
INNER JOIN producto on cod_productof = cod_producto
INNER JOIN color on cod_colorf = cod_color
INNER JOIN talla on cod_tallaf = cod_talla
where producto.cod_categoriaf = 2
GROUP BY producto.cod_producto"; 
$result = $conn->query($sql);

?>

<!-- HTML -->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../bootstrap-5.3.3-dist/css/bootstrap.min.css">
  <link rel="icon" href="../imagenes/001-Index/Logos/walker.ico" type="image/x-icon">
  <!-- Bootstrap Icons -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="../estilos/estilos-more.css">
  <title>Caballeros</title>
</head>

<body>
     <!-- Banner de la pagina -->
     <nav class="navbar bg-body-tertiary">
        <div class="container-fluid fixed-width-container"
            style="background-color: #020304; font-family: 'Franklin Gothic Medium';">
            <a class="navbar-brand" href="#" style="background-color: #020304; color: white; font-size: 50px;">
                <img src="../imagenes/001-Index/Logos/Logo.png" alt="Logo" width="90" height="90"
                    class="d-inline-block align-text-center" style="background-color: #CC9E61;">
                THE WALKERS
            </a>
            <ul class="nav nav-tabs" style="margin-top: 4rem; font-size: 20px;">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="../admin/admin.php">INICIO</a>
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
                    <a class="nav-link" href="../admin/ventas.php" style="color: white;">Ventas</a>
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
            <li><a class="dropdown-item" href="../../login/cerrar_sesion.php">Cerrar Sesión</a></li>
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

  <!-- Contenedor fijo -->
  <div class="fixed-width-container">
    <p class="fs-5 text-center text-content"
      style="color: white; background-color: #6c6c6c ; font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;">
      Sección de Caballeros
  </p>
    <br>
        <!-- Barra de búsqueda -->
        <div class="mb-3 text-center">
          <div class="input-group" style="width: 50%; margin: 0 auto;">
            <input type="text" class="form-control" placeholder="Busca aqui ..." aria-label="Buscar"
              style="border-radius: 20px 0 0 20px; background-color: #020304; color: white; border: none;">
            <button class="btn btn-dark" type="button"
              style="border-radius: 0 20px 20px 0; color: white;">Buscar</button>
          </div>
        </div>
  
    <div class="container mt-4">
      <div class="row">
      
  <div class="row">
    <?php while ($row = $result->fetch_assoc()): ?>
      <div class="col-12 col-sm-6 col-md-4 mb-4"> <!-- Responsivo: 1 tarjeta por fila en pantallas pequeñas, 2 en medianas, 3 en grandes -->
        <form method="POST" action="carrito.php">
          <input type="hidden" id="cod_producto" name="cod_producto" value="<?php echo $row['cod_producto']; ?>">
          <input type="hidden" name="nombre_producto" value="<?php echo $row['nombre_producto']; ?>">

          <div class="card h-100">
            <!-- Contenedor de imagen con tamaño fijo -->
            <div style="width: 100%; height: 250px; overflow: hidden;">
              <img src="<?php echo $row['imagen']; ?>" class="card-img-top" alt="Imagen de producto" style="width: 100%; height: 100%; object-fit: cover;">
            </div>

            <div class="card-body">
              <h5 class="card-title"><?php echo $row['nombre_producto']; ?></h5>
              <h6 class="card-subtitle mb-2 text-muted text-right"><?php echo $row['marca']; ?></h6>
              <p class="card-text"><?php echo ("$". $row['descripcion']); ?></p>

              <div class="row mb-2">
                <div class="col-4">
                  <label class="form-label">Cantidad</label>
                  <input type="number" class="form-control" value="1" min="1" name="cantidad" id="cantidad">
                </div>
                <div class="col-4">
                  <label class="form-label">Talla</label>
                  <select class="form-select" name="talla" id="talla">
                
                    <?php
                    $tallas = explode(',', $row['cod_tallas']);
                    $nombres_tallas = explode(',', $row['tallas']);
                    foreach ($tallas as $index => $cod_talla):
                    ?>
                      <option value="<?php echo trim($cod_talla); ?>"><?php echo trim($nombres_tallas[$index]); ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="col-4">
                  <label class="form-label">Color</label>
                  <select class="form-select" name="color" id="color">
                   
                    <?php
                    $colores = explode(',', $row['cod_colores']);
                    $nombres_colores = explode(',', $row['colores']);
                    foreach ($colores as $index => $cod_color):
                    ?>
                      <option value="<?php echo trim($cod_color); ?>"><?php echo trim($nombres_colores[$index]); ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>

              <button name="agregar_carrito" class="btn btn-warning w-100" style="color: white;">Agregar al Carrito</button>

              <input type="hidden" class="form-control" value="<?php echo $row['cod_inventario']; ?>" name="cod_inventario">
              <input type="hidden" class="form-control" value="<?php echo $row['precio_unitario']; ?>" name="precio_unitario">
            </div>
          </div>
        </form>
      </div>
    <?php endwhile; ?>
  </div>
</div>
  <!-- Footer -->
  <footer class="text-white mt-5 p-4 text-center fixed-width-container" style="background-color: #020304;">
    <p>© 2024 The Walkers. Todos los derechos reservados.</p>
  </footer>
  <!-- Contenedor de botones flotantes -->
  <div class="btn-flotante-container">

    <!-- Botón de Volver Arriba -->
    <button class="scroll-to-top" onclick="scrollToTop()">
      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-arrow-up"
        viewBox="0 0 16 16">
        <path d="M8 0l3 3H5l3-3zM8 16l-3-3h6l-3 3z" />
      </svg>
    </button>
  </div>
  <!--Script para dar comportamieno al boton flotante -->
  <script>
    function scrollToTop() {
      window.scrollTo({ top: 0, behavior: 'smooth' });
    }
  </script>

  <!-- Script de Bootstrap -->
  <script src="../bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>


<?php



if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['agregar_carrito'])) {
  $cod_producto = $_POST['cod_producto'];
  $cod_color = $_POST['color'];
  $cod_talla = $_POST['talla'];
  $cantidad_solicitada = $_POST['cantidad'];

  // Consulta para obtener la cantidad y precio según la combinación seleccionada
  $sql = "SELECT cod_inventario, cantidad, precio_unitario FROM inventario 
          WHERE cod_productof = ? AND cod_colorf = ? AND cod_tallaf = ?";
  
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("iii", $cod_producto, $cod_color, $cod_talla);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
      $inventario = $result->fetch_assoc();
      $cantidad_disponible = $inventario['cantidad'];
      $precio_unitario = $inventario['precio_unitario'];
      $cod_inventario= $inventario['cod_inventario'];

      // Verifica si hay suficiente stock
      if ($cantidad_solicitada <= $cantidad_disponible) {
          // Agrega el producto al carrito
          $producto = [
              'cod_producto' => $cod_producto,
              'nombre_producto' => $_POST['nombre_producto'],
              'cantidad' => $cantidad_solicitada,
              'talla' => $cod_talla,
              'color' => $_POST['color'],
              'precio' => $precio_unitario, 
              'cod_inventario'  => $cod_inventario
          ];

          $_SESSION['carrito'][] = $producto;
          echo "<script>alert('Producto agregado al carrito!');</script>";
      } else {
          echo "<script>alert('No hay suficiente stock disponible.');</script>";
      }
  } else {
      echo "<script>alert('Producto con combinacion de color y talla seleccionado no existe.');</script>";
  }
}


?>
