<!DOCTYPE html>
<html lang="es">

<head>
	<!--Required meta tags-->
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="stylesheet" href="../estilos/estilos-registro-usuario.css">
	<link rel="stylesheet" href="../../bootstrap-5.3.3-dist/css/bootstrap.min.css" />
	<title>Registrate</title>

    <!-- Bootstrap Icons -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.css" >

</head>

<body>
     <!-- Banner de la pagina -->
     <nav class="navbar bg-body-tertiary">
      <div class="container-fluid fixed-width-container"
          style="background-color: #020304; font-family: 'Franklin Gothic Medium';">
          <a class="navbar-brand" href="#" style="background-color: #020304; color: white; font-size: 50px;">
              <img src="imagenes/001-Index/Logos/Logo.png" alt="Logo" width="90" height="90"
                  class="d-inline-block align-text-center" style="background-color: #CC9E61;">
              THE WALKERS
          </a>
          <ul class="nav nav-tabs" style="margin-top: 4rem; font-size: 20px;">
              <li class="nav-item">
                  <a class="nav-link active" aria-current="page" href="../index.html">INICIO</a>
              </li>
              <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button"
                      aria-expanded="false" style="color: white;">Productos</a>
                  <ul class="dropdown-menu">
                      <li><a class="dropdown-item" href="../CRUD_PRODUCTOS/registrar_producto.php">Registrar Producto</a></li>
                      <li><a class="dropdown-item" href="../CRUD_PRODUCTOS/consultar_producto.php">Consultar Producto</a></li>
                      <li><a class="dropdown-item" href="../CRUD_PRODUCTOS/modificar_producto.php">Modificar Producto</a></li>
                      <li><a class="dropdown-item" href="../CRUD_PRODUCTOS/eliminar_producto.php">Eliminar Producto</a></li>
                  </ul>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button"
                    aria-expanded="false" style="color: white;">Usuarios</a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="registrar_usuarios.php">Registrar Usuario</a></li>
                    <li><a class="dropdown-item" href="consultar_usuarios.php">Consultar Usuario</a></li>
                    <li><a class="dropdown-item" href="modificar_usuarios.php">Modificar Usuario</a></li>
                    <li><a class="dropdown-item" href="eliminar_usuarios.php">Eliminar Usuario</a></li>
                </ul>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../creditos/creditos.html" style="color: white;">Creditos</a>
          </li>
          </ul>
      </div>
  </nav>
	<center>

		<section class="register-section">
			

			<h1><p style="font-family: 'Franklin Gothic Medium', 'Arial Narrow',
                     Arial, sans-serif; width: 300px;">Registrar Usuario</p></h1><br>
			<!--REGISTRO-->
			<form action="registrar_usuarios.php" method="POST" class="formulario__login" style="width: 25rem; height: 28rem;">

				<div class="mb-4" style="display: flex; align-items: center; justify-content: space-between;">
					<label class="fw-bold" for="nombre" style="width: 49%;">Escriba el nombre del usuario</label>
					<input class="form-control" style="width: 48%;" placeholder="Ingrese el nombre" type="text" name="nombre" id="nombre" required />
				</div>

				<div class="mb-4" style="display: flex; align-items: center; justify-content: space-between;">
					<label class="fw-bold" for="apellido" style="width: 49%;">Escriba el apellido del usuario</label>
					<input class="form-control" style="width: 48%;" placeholder="Ingrese el apellido" type="text" name="apellido" id="apellido" required />
				</div>

				<div class="mb-4" style="display: flex; align-items: center; justify-content: space-between;">
					<label class="fw-bold" for="tipo" style="width: 49%;">Tipo de Usuario</label>
                    <select id="tipo" name="tipo" class="form-control" style="width: 48%;">
                        <option value="1">Administrador</option>
                        <option value="2">Cliente</option>
                    </select>
				</div>
                <div class="mb-4" style="display: flex; align-items: center; justify-content: space-between;">
					<label class="fw-bold" for="telefono" style="width: 49%;">Escriba el Telefono del Usuario</label>
					<input class="form-control" style="width: 48%;" placeholder="Ingrese el telefono" type="number" name="telefono" id="telefono" required />
				</div>

				<div class="mb-4" style="display: flex; align-items: center; justify-content: space-between;">
					<label class="fw-bold" for="correo" style="width: 49%;">Escriba su correo electronico</label>
					<input class="form-control" style="width: 48%;" placeholder="Ingrese el correo electronico" type="email" name="correo" id="correo" required />
				</div>

				<div class="mb-4" style="display: flex; align-items: center; justify-content: space-between;">
					<label class="fw-bold" for="nick" style="width: 49%;">Escriba el Apodo del Usuario</label>
					<input class="form-control" style="width: 48%;" placeholder="Ingrese el Apodo" type="text" name="nick" id="nick" required />
				</div>

				<div class="mb-4" style="display: flex; align-items: center; justify-content: space-between;">
					<label class="fw-bold" for="contraseña" style="width: 49%;">Escriba la contraseña del Usuario</label>
					<input class="form-control" style="width: 48%;" placeholder="Ingrese su contraseña" type="password" maxlength="10" name="contraseña" id="contraseña" required />
</div> <br>
		<div class="btn">
					<button type="submit" class="btn" style="background-color: black; 
                    color: white; font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif; width: 300px;">
						Registrar
					</button>
				</div>
			</form>
            <br><br><br><br><br>
            <li class="btn">
                    <a class="btn" href="../../index.html" style="background-color: black; 
                    color: white; width: 150px; font-family: 'Franklin Gothic Medium', 'Arial Narrow',
                     Arial, sans-serif; width: 300px;">Volver al Inicio</a>
            </li>
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


error_reporting(E_ERROR | E_PARSE);

include '../../conexionBD.php';

$nombre= $_POST['nombre'];
$apellido= $_POST['apellido'];
$tipo= $_POST['tipo'];
$telefono= $_POST['telefono'];
$correo= $_POST['correo'];
$nickname= $_POST['nick'];
$contraseña= $_POST['contraseña'];

$sql = "INSERT INTO usuario (primer_nombre, primer_apellido, tipo_usuario, telefono_usuario, correo_usuario, nick_name, contraseña) VALUES ('$nombre','$apellido','$tipo',' $telefono','$correo', '$nickname','$contraseña')";

// Ejecutar la consulta
if (mysqli_query($conn, $sql)) {
    echo "";
} else {
    echo "Error: " . mysqli_error($conn);
}

?>
