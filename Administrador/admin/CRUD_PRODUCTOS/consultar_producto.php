<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../../bootstrap-5.3.3-dist/css/bootstrap.min.css">
  <link rel="icon" href="../../imagenes/Index/logo-icono.ico" type="image/x-icon">
  <link rel="icon" href="../../../imagenes/001-Index/Logos/walker.ico" type="image/x-icon">
  <!-- Bootstrap Icons -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <title>Administración de Productos</title>
</head>
<?php
session_start(); // Inicia la sesión
// Verifica si el usuario ha iniciado sesión y es administrador
if (!isset($_SESSION['cod_usuario']) || $_SESSION['tipo_usuario'] !== 'admin') {
    // Si no ha iniciado sesión o no es admin, redirigir al index.php
    header("Location: ../../../login/login.php");
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
  <p class="fs-5 text-center" style="margin-top: 0px; color: white; background-color: #6c6c6c; font-family: 'Franklin Gothic Medium', 'cursive';">Consulta de Productos</p>
  <!-- Formulario de búsqueda -->
  <form action="consultar_producto.php" method="post" class="d-flex justify-content-center align-items-center mt-5">
  <div style="width: 40%;">
    <div class="input-group">
      <input type="text" class="form-control" placeholder="Ingresa ID del producto" name="busqueda_producto" 
        style="border: 1px solid #ced4da; border-radius: 50px 0 0 50px; padding: 10px 20px; font-size: 18px;">
      <button class="btn btn-outline-secondary" type="submit" 
        style="border-radius: 0 50px 50px 0; border: 1px solid #ced4da; padding: 10px 20px; font-size: 18px; background-color: #f8f9fa;">
        Buscar
      </button>
    </div>
  </div>
</form>

  <div class="container mt-5">
    
    <?php

    error_reporting(E_ERROR | E_PARSE);
      include '../../conexionBD.php';
      $id_producto = $_POST['busqueda_producto'];

      // Consulta SQL
      $consulta = "SELECT * FROM producto WHERE cod_producto = '$id_producto'";
      $result = $conn->query($consulta);

      // Verificar si hay resultados
      if ($result->num_rows > 0) {
        echo '<table class="table table-striped table-bordered">';
        echo '<thead class="table-dark"><tr>
                <th>ID Producto</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Imagen</th>
                <th>Precio</th>
                <th>Marca</th>
                <th>Código de Categoría</th>
              </tr></thead>';
        echo '<tbody>';

        // Mostrar los datos
        while ($row = $result->fetch_assoc()) {
          echo '<tr>';
          echo '<td>' . $row['cod_producto'] . '</td>';
          echo '<td>' . $row['nombre_producto'] . '</td>';
          echo '<td>' . $row['descripcion'] . '</td>';
          echo '<td><img src="' . $row['imagen'] . '" width="100" height="100" alt="Imagen"></td>';
          echo '<td>' . $row['precio'] . '</td>';
          echo '<td>' . $row['marca'] . '</td>';
          echo '<td>' . $row['cod_categoriaf'] . '</td>';
          echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
      } else {
        echo '<div class="alert alert-warning text-center" role="alert">El producto no existe si no ingrese correctamente el id del producto</div>';
      }

      // Cerrar la conexión
      $conn->close();
    ?>
  </div>

  <!-- Scripts de Bootstrap -->
  <script src="../../bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>