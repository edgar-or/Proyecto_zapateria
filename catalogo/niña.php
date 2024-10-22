<?php
include '../conexionBD.php';

$sql = "SELECT inventario.cod_inventario, inventario.precio_unitario, producto.nombre_producto, producto.imagen, producto.descripcion, producto.marca, color.color, talla.talla,
GROUP_CONCAT(DISTINCT color.color SEPARATOR ',') as colores, 
GROUP_CONCAT(DISTINCT color.cod_color SEPARATOR ',') as cod_colores, 
GROUP_CONCAT(DISTINCT talla.talla SEPARATOR ',') as tallas,
GROUP_CONCAT(DISTINCT talla.cod_talla SEPARATOR ',') as cod_tallas
FROM inventario 
INNER JOIN producto on cod_productof = cod_producto
INNER JOIN color on cod_colorf = cod_color
INNER JOIN talla on cod_tallaf = cod_talla
where producto.cod_categoriaf = 4
GROUP BY producto.cod_producto"; 
$result = $conn->query($sql);


?>




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
  <title>Niñas</title>
</head>

<body>
    <!-- Banner de la pagina -->
    <nav class="navbar bg-body-tertiary">
        <div class="container-fluid fixed-width-container"
            style="background-color: #020304; font-family: 'Franklin Gothic Medium';">
            <a class="navbar-brand" href="../index.html" style="background-color: #020304; color: white; font-size: 50px;">
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
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="mis_compras.html" style="color: white;">Mis compras</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button"
                        aria-expanded="false" style="color: white;">Cuenta</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="../login/login.php">Login</a></li>
                        <li><a class="dropdown-item" href="../login/login.php">Cerrar Sesion</a></li>
                        <li><a class="dropdown-item" href="#">Mi cuenta</a></li>
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
      Sección de Niñas
  </p>
    <br>
        <!-- Barra de búsqueda con botón -->
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
        <!-- Producto 1 -->
        <div class="container mt-4">
    <div class="row">
        <?php while ($row = $result->fetch_assoc()): ?>
          <form method="POST" action="carrito.php">
        <div class="col-md-4">
            <div class="card mb-4">
                <img src=" <?php echo $row['imagen']; ?> " class="card-img-top">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $row['nombre_producto']; ?></h5>
                    <h6 class="card-subtitle mb-2 text-muted text-right"><?php echo $row['marca']; ?></h6>
                    <p class="card-text"><?php echo $row['descripcion']; ?></p>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="input-group" style="width: 100px;">
                            <span class="input-group-text">Cantidad</span>
                            <input type="number" class="form-control" value="1" min="1" name="cantidad">
                        </div>
                        <select class="form-select mx-2" style="width: 100px;" name="talla" id="talla">
                            <option selected>Selecciona una talla</option>
                            <?php $tallas = explode(',', $row['cod_tallas']);
                      $nombres_tallas = explode(',', $row['tallas']);
                      foreach ($tallas as $index => $cod_talla): ?> 
                            <option value="<?php echo trim($cod_talla) ?>"><?php echo trim($nombres_tallas[$index]); ?></option>
                        <?php endforeach; ?>
                        </select>
                        
                        <button name="agregar_carrito" class="btn btn-warning" style="color: white;">Agregar al Carrito</button>
                        
                    </div>
                    <select class="form-select" style="width: 110px;" name="color" id="color">
                      <option selected>Selecciona un color</option>
                      <?php 
                      $colores = explode(',', $row['cod_colores']);
                      $nombres_colores = explode(',', $row['colores']);
                      foreach ($colores as $index => $cod_color): ?> 
                          <option value="<?php echo trim($cod_color); ?>"><?php echo trim($nombres_colores[$index]); ?></option>
                      <?php endforeach; ?>
                  </select>
                  <input type="hidden" class="form-control" value="<?php echo $row['cod_inventario'] ?>"  min="1" name="cod_inventario">
                  <input type="hidden" class="form-control" value="<?php  echo $row['precio_unitario']; ?>"  min="1" name="precio_unitario">
                </div>
            </div>
        </div>
        </form>
        <?php endwhile; ?>
    </div>
</div>
</div>
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



