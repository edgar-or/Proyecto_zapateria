<?php

session_start();  
include '../conexionBD.php';

// Capturar el término de búsqueda si existe
$busqueda = "";
if (isset($_GET['busqueda'])) {
    $busqueda = $_GET['busqueda'];
}

// Modificar la consulta SQL para filtrar por nombre de producto
$sql = "SELECT inventario.cod_inventario, inventario.precio_unitario, producto.cod_producto, producto.nombre_producto, producto.imagen, producto.descripcion, producto.marca, 
color.color, talla.talla,
GROUP_CONCAT(DISTINCT color.color SEPARATOR ',') as colores, 
GROUP_CONCAT(DISTINCT color.cod_color SEPARATOR ',') as cod_colores, 
GROUP_CONCAT(DISTINCT talla.talla SEPARATOR ',') as tallas,
GROUP_CONCAT(DISTINCT talla.cod_talla SEPARATOR ',') as cod_tallas
FROM inventario 
INNER JOIN producto on cod_productof = cod_producto
INNER JOIN color on cod_colorf = cod_color
INNER JOIN talla on cod_tallaf = cod_talla
WHERE producto.cod_categoriaf = 3";

// Si hay una búsqueda, agregamos una condición SQL adicional
if (!empty($busqueda)) {
    $sql .= " AND producto.nombre_producto LIKE '%" . $conn->real_escape_string($busqueda) . "%'";
}

$sql .= " GROUP BY producto.cod_producto"; 

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
  <title>Niños</title>
</head>

<body>
    <!-- Banner de la pagina -->
    <nav class="navbar bg-body-tertiary">
        <div class="container-fluid fixed-width-container"
            style="background-color: #020304; font-family: 'Franklin Gothic Medium';">
            <a class="navbar-brand" href="/admin/admin.html" style="background-color: #020304; color: white; font-size: 50px;">
                <img src="../imagenes/001-Index/Logos/Logo.png" alt="Logo" width="90" height="90"
                    class="d-inline-block align-text-center" style="background-color: #CC9E61;">
                THE WALKERS
            </a>
            <ul class="nav nav-tabs" style="margin-top: 4rem; font-size: 20px;">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="../index.php">INICIO</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button"
                        aria-expanded="false" style="color: white;">Catálogo</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="dama.php">Dama</a></li>
                        <li><a class="dropdown-item" href="joven.php">Caballero</a></li>
                        <li><a class="dropdown-item" href="niño.php">Niño</a></li>
                        <li><a class="dropdown-item" href="niña.php">Niña</a></li>
                        <li><a class="dropdown-item" href="../pago/metodo_pago.php">Registrar metodo de pago</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <?php if (isset($_SESSION['cod_usuario'])): ?>
                    <a class="nav-link" href="mis_compras.php" style="color: white;">Mis Compras</a>
                    <?php else: ?>
                    <a class="nav-link" href="../login/login.php" style="color: white;">Mis Compras</a>
                    <?php endif; ?>
                </li>
                <!-- Modificación para "Mi cuenta" -->
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
            <li><a class="dropdown-item" href="../login/cerrar_sesion.php">Cerrar Sesión</a></li>
        <?php else: ?>
            <!-- Si no ha iniciado sesión -->
            <li><a class="dropdown-item" href="../login/login.php">Login</a></li>
        <?php endif; ?>
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
      Sección de Niños
  </p>
  <br>
        <!-- Barra de búsqueda -->
        <div class="mb-3 text-center">
          <div class="input-group" style="width: 50%; margin: 0 auto;">
            <form action="niño.php" method="GET" style="display: flex; width: 100%;">
                <input type="text" class="form-control" placeholder="Busca aqui ..." aria-label="Buscar"
                  name="busqueda" value="<?php echo htmlspecialchars($busqueda); ?>" 
                  style="border-radius: 20px 0 0 20px; background-color: #020304; color: white; border: none;">
                <button class="btn btn-dark" type="submit"
                  style="border-radius: 0 20px 20px 0; color: white;">Buscar</button>
            </form>
          </div>
        </div>
  
<!--productos-->
<div class="container mt-4">
  <div class="row">
    <!-- Si no hay resultados, mostrar un mensaje de error -->
    <?php if ($result->num_rows == 0): ?>
      <div class="col-12 text-center">
        <p class="text-danger">Producto no encontrado.</p>
      </div>
    <?php else: ?>
      <!-- Inicio del loop PHP -->
      <?php while ($row = $result->fetch_assoc()): ?>
      <div class="col-12 col-sm-6 col-md-4 mb-4"> <!-- 1 tarjeta por fila en pantallas pequeñas, 2 en medianas, 3 en grandes -->
        <form action="carrito.php" method="POST">
          <input type="hidden" id="cod_producto" name="cod_producto" value="<?php echo $row['cod_producto']; ?>">
          <input type="hidden" name="nombre_producto" value="<?php echo $row['nombre_producto']; ?>">

          <div class="card h-100">
            <div style="width: 100%; height: 250px; overflow: hidden;">
              <img src="<?php echo $row['imagen']; ?>" class="card-img-top" alt="Imagen de producto" style="width: 100%; height: 100%; object-fit: cover;">
            </div>
            
            <div class="card-body">
              <h5 class="card-title"><?php echo $row['nombre_producto']; ?></h5>
              <h6 class="card-subtitle mb-2 text-muted"><?php echo $row['marca']; ?></h6>
              <p class="card-text"><?php echo ("$" .$row['precio_unitario']); ?></p>

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
                      <option value="<?php echo trim($nombres_colores[$index]); ?>"><?php echo trim($nombres_colores[$index]); ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>

              <button name="agregar_carrito" class="btn btn-warning w-100" style="color: white;" value="1">Agregar a carrito</button>

              <input type="hidden" class="form-control" value="<?php echo $row['cod_inventario']; ?>" name="cod_inventario">
              <input type="hidden" class="form-control" value="<?php echo $row['precio_unitario']; ?>" name="precio_unitario">
            </div>
          </div>
        </form>
      </div> <!-- Fin de la columna de la tarjeta -->
      <?php endwhile; ?>
      <!-- Fin del loop PHP -->
    <?php endif; ?>
  </div> <!-- Fin de la fila -->
</div>
  <!-- Footer -->
  <footer class="text-white mt-5 p-4 text-center fixed-width-container" style="background-color: #020304;">
    <p>© 2024 The Walkers. Todos los derechos reservados.</p>
  </footer>
  <!-- Contenedor de botones flotantes -->
  <div class="btn-flotante-container">
    <!-- Botón flotante con icono de carrito -->
    <a href="mis_compras.php" class="btn-flotante">
      <i class="bi bi-cart-fill"></i>
    </a>
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



