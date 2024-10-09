<?php
// Datos de conexión
$servername = "localhost";
$username = "root";
$password = "";
<<<<<<< HEAD
$dbname = "the_walkers_db";
=======
$dbname = "db_za_2.0.";
>>>>>>> 2854d922eaef62ffda2fb5e114f948c6e0aa9c32

// Crear conexión
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Verificar conexión
if (!$conn) {
  die("Connection  
 failed: " . mysqli_connect_error());
}
else
    print("conexion exitosa")

?>