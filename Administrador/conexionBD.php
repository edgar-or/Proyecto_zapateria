<?php
// Datos de conexión
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "zapateriabd";

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