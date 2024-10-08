<?php

include '../conexionBD.php';


$nombre= $_POST['nombre'];
$apellido= $_POST['apellido'];
$celular= $_POST['celular'];
$email= $_POST['email'];
$usuario= $_POST['usuario'];
$contraseña= $_POST['contraseña'];

$sql = "INSERT INTO cliente (primer_nombre, primer_apellido, telefono_usuario, correo_usuario, nick_name, contraseña) VALUES ('$nombre','$apellido','$celular',' $email','$usuario', '$contraseña')";

// Ejecutar la consulta
if (mysqli_query($conn, $sql)) {
    echo "Nuevo registro creado correctamente";
} else {
    echo "Error: " . mysqli_error($conn);
}



?>