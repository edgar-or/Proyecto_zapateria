<?php
// Datos de conexión
$servername = "localhost";
$username = "root";
$password = "";
$database_zapateria = "the_walkers_db";

// Crear conexión
$conn = mysqli_connect($servername, $username, $password, $database_zapateria);

// Verificar conexión
if (!$conn) {
  die("Connection  
 failed: " . mysqli_connect_error());
}
else
    print("conexion exitosa")

?>