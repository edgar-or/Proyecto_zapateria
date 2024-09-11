<?php

include '../conexionBD.php';



$usuario= $_POST['usuario'];
$contraseña= $_POST['contraseña'];


print("el usuario es: ".$usuario);
print("el usuario es: ".$contraseña);

$sql = "INSERT INTO usuarios_admin (nick_name, contraseña) VALUES ('$usuario', '$contraseña')";

// Ejecutar la consulta
if (mysqli_query($conn, $sql)) {
    echo "Nuevo registro creado correctamente";
} else {
    echo "Error: " . mysqli_error($conn);
}



?>