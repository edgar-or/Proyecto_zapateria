<?php


include '../../conexionBD.php';

error_reporting(E_ERROR | E_PARSE); // Mostrar solo errores fatales y parse errors



// Consulta para obtener todas las categorías
$sql = "SELECT cod_categoria, nombre_categoria FROM categoria";
$resultado = mysqli_query($conn, $sql);

// Verificar si hay resultados
if (mysqli_num_rows($resultado) > 0) {
    $categorias = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
}

mysqli_close($conn);
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
                      <li><a class="dropdown-item" href="#">Modificar Producto</a></li>
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
              <a class="nav-link" href="../../../Administrador/creditos/creditos.html" style="color: white;">Creditos</a>
          </li>
          </ul>
      </div>
  </nav>
  <center>

  <form  action ="modificar_producto.php" method="post">


  <div class="mb-3 text-center">
      <div class="input-group" style="width: 50%; margin: 0 auto;">
        <input type="text" class="form-control" placeholder="ingrese id de producto" aria-label="Buscar" name="cod_producto"
          style="border-radius: 20px 0 0 20px; background-color: #020304; color: white; border: none;">
      </div>
    </div>




<section class="register-section">
    <!--REGISTRO-->


        <div class="mb-4" style="display: flex; align-items: center; justify-content: space-between;">
            <label class="fw-bold" for="nombre" style="width: 49%;">Digite el nombre de Zapato</label>
            <input class="form-control" style="width: 48%;" placeholder="Nombre del zapato" type="text" name="nombre" id="nombre" required />
        </div>

        <div class="mb-4" style="display: flex; align-items: center; justify-content: space-between;">
            <label class="fw-bold" for="apellido" style="width: 49%;">Digite la talla</label>
            <input class="form-control" style="width: 48%;" placeholder="Talla" type="number" name="talla" id="talla" required />
        </div>

        <div class="mb-4" style="display: flex; align-items: center; justify-content: space-between;">
            <label class="fw-bold" for="celular" style="width: 49%;">Escriba el color</label>
            <input class="form-control" style="width: 48%;" placeholder="Color del zapato" type="text" name="color" id="color" required />
        </div>

        <div class="mb-4" style="display: flex; align-items: center; justify-content: space-between;">
            <label class="fw-bold" for="email" style="width: 49%;">Escriba una breve descripcion</label>
            <input class="form-control" style="width: 48%;" placeholder="descripcion" type="text" name="descripcion" id="descripcion" required />
        </div>

        <div class="mb-4" style="display: flex; align-items: center; justify-content: space-between;">
            <label class="fw-bold" for="usuario" style="width: 49%;">Digite el precio</label>
            <input class="form-control" style="width: 48%;" placeholder="Precio" type="number" name="precio" id="precio" required />
        </div>

        <div class="mb-4" style="display: flex; align-items: center; justify-content: space-between;">
            <label class="fw-bold" for="contraseña" style="width: 49%;">Escriba la marca</label>
            <input class="form-control" style="width: 48%;" placeholder="Marca" type="text" maxlength="10" name="marca" id="marca" required />
        </div>

        <div class="mb-4" style="display: flex; align-items: center; justify-content: space-between;">
        <label class="fw-bold" for="categoria" style="width: 49%;">Seleccione la categoría</label>
<!-- Aquí irán las opciones generadas dinámicamente desde PHP -->
        <select class="form-control" style="width: 48%;" name="categoria" id="categoria" required>
        <?php foreach ($categorias as $categoria): ?>
        <option value="<?php echo $categoria['cod_categoria']; ?>">
    <?php echo htmlspecialchars(trim($categoria['nombre_categoria'])); ?>
        </option>
    <?php endforeach; ?>
    </select>
        </div>
        <div class="mb-4" style="display: flex; align-items: center; justify-content: space-between;">
            <label class="fw-bold" for="contraseña" style="width: 49%;">Pegue el link de la imagen</label>
            <input class="form-control" style="width: 48%;" placeholder="Link de imagen" type="text" maxlength="255" name="link_imagen" id="link_imagen" required />
        </div>
        <center>
        <div class="d-grid">
            <button type="submit" class="btn" style= "background-color: black; width: 10rem;">
                Modificar
            </button>
        </div>
        </center>
    </form>
</section>


</center>

 


 
    
  

  <!-- Script de Bootstrap -->
  <script src="../../bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>


<?php

echo "Código del producto: " . $cod_producto . "<br>";



include '../../conexionBD.php';


$cod_producto = $_POST['cod_producto'];
    $nombre_producto = $_POST['nombre'];
    $talla = $_POST['talla'];
    $color = $_POST['color'];
    $descripcion=  $_POST['descripcion'];
    $link_imagen=   $_POST['link_imagen'];
    $precio=  $_POST['precio'];
    $marca =  $_POST['marca'];
    $categoria=   $_POST['categoria'];


    // Preparar la consulta para actualizar el producto
    $actualizar = "UPDATE producto SET nombre_producto = '$nombre_producto', talla = '$talla', color = '$color', descripcion = '$descripcion', imagen = '$link_imagen', precio = '$precio', marca = '$marca', cod_categoriaf = '$categoria' WHERE cod_producto = '$cod_producto'";

    // Ejecutar la consulta
    if ($conn->query($actualizar) === TRUE) {
        echo "Producto modificado correctamente.";
    } else {
        echo "Error al modificar el producto: " . $conn->error;
    }

// Cerrar la conexión
$conn->close();

echo "Código del producto: " . $cod_producto . "<br>";





?>