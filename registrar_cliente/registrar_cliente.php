<?php

include '../conexionBD.php';


$nombre= $_POST['nombre'];
$apellido= $_POST['apellido'];
$celular= $_POST['celular'];
$email= $_POST['email'];
$usuario= $_POST['usuario'];
$contraseña= $_POST['contraseña'];

$sql = "INSERT INTO cliente (nombre_cliente, apellido_cliente, celular_cliente, email_cliente, nick_name_cliente, contraseña_cliente) VALUES ('$nombre','$apellido','$celular',' $email','$usuario', '$contraseña')";

// Ejecutar la consulta
if (mysqli_query($conn, $sql)) {
    echo "Nuevo registro creado correctamente";
} else {
    echo "Error: " . mysqli_error($conn);
}



?>