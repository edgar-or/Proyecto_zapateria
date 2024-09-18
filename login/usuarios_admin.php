<?php

include '../conexionBD.php';

$usuario = $_POST['usuario'];
$contraseña = $_POST['contraseña'];

// Verificar si los campos están vacíos
if (empty($usuario) || empty($contraseña)) {
    header("location: ../index.html");
    exit();
}

// Crear la conexión con la base de datos
$conn = mysqli_connect($servername, $username, $password, $dbname) or die("Error al Conectar: " . mysqli_connect_error());


if ($result->num_rows > 0) {
    // El usuario existe, ahora verificamos la contraseña
    $row = $result->fetch_assoc();
    
    if (password_verify($contraseña, $row['password'])) {
        // Contraseña correcta, redirigir al usuario
        header("location: ../catalogo/dama.html");
        exit();
    } else {
        // Contraseña incorrecta
        header("location: ../index.html?error=incorrect_password");
        exit();
    }
} else {
    // El usuario no existe
    header("location: ../index.html?error=user_not_found");
    exit();
}

// Cerrar la conexión
$conn->close();
?>
