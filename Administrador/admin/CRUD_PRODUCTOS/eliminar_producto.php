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
                      <li><a class="dropdown-item" href="#">Eliminar Producto</a></li>
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
              <a class="nav-link" href="../../../Administrador/creditos/creditos.html" style="color: white;">Creditos</a>
          </li>
          </ul>
      </div>
  </nav>

  <form action ="eliminar_producto.php" method="post">


<div class="mb-3 text-center">
    <div class="input-group" style="width: 50%; margin: 0 auto;">
      <input type="text" class="form-control" placeholder="Busca aqui ..." aria-label="Buscar" name="eliminar_producto"
        style="border-radius: 20px 0 0 20px; background-color: #020304; color: white; border: none;">
      <button class="btn btn-dark" type="submit" style="border-radius: 0 20px 20px 0; color: white;">Buscar</button>
    </div>
  </div>
</form>


 


 
    
  

  <!-- Script de Bootstrap -->
  <script src="../../bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>


<?php

error_reporting(E_ERROR | E_PARSE); // Mostrar solo errores fatales y parse errors



include '../../conexionBD.php';

$id_producto = $_POST['eliminar_producto'];

// Asegurarse de que el valor sea numérico si `cod_producto` es un número
$id_producto = intval($id_producto);

// Verificar si el producto existe
$verificar = "SELECT * FROM producto WHERE cod_producto = '$id_producto'";
$result = $conn->query($verificar);

if ($result->num_rows > 0) {
    // Eliminar el producto de la base de datos
    $eliminar = "DELETE FROM producto WHERE cod_producto = '$id_producto'";
    echo "Consulta: " . $eliminar . "<br>";  // Verificar la consulta generada

    if ($conn->query($eliminar) === TRUE) {
        echo "Producto eliminado correctamente.";
    } else {
        echo "Error al eliminar el producto: " . $conn->error;
    }
} else {
    echo "El producto con el código $id_producto no existe.";
}

// Cerrar la conexión
$conn->close();

?>

