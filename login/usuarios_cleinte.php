<?php

include '../conexionBD.php';

$usuario = $_POST['usuario'];
$contraseña = $_POST['contraseña'];

// Verificar si los campos están vacíos
if (empty($usuario) || empty($contraseña)) {
    echo "<script>alert('Usuario o contraseña no pueden estar vacíos'); window.location.href = 'login.html';</script>";
    exit();
}

// Crear la conexión con la base de datos
$conn = mysqli_connect($servername, $username, $password, $dbname) or die("Error al conectar: " . mysqli_connect_error());

// Consulta SQL sin protección contra inyección SQL
$query = "SELECT * FROM cliente WHERE nick_name_cliente = '$usuario'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    // El usuario existe, ahora verificamos la contraseña
    $row = mysqli_fetch_assoc($result);
    
    if ($contraseña == $row['contraseña_cliente']) {
        // Contraseña correcta, redirigir al usuario
        echo "<script>alert('Bienvenido cliente, ".$usuario."'); window.location.href = '../index.html';</script>";
    exit();
        exit();
    } else {
        // Contraseña incorrecta
        echo "<script>alert('datos ingresados incorrectos'); window.location.href = 'login.html';</script>";
        exit();
        exit();
    }
} else {
    // El usuario no existe
    echo "<script>alert('Usuario no existe'); window.location.href = 'login.html';</script>";
    exit();
    exit();
}

// Cerrar la conexión
mysqli_close($conn);
?>
