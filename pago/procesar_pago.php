<?php
// Iniciar sesión si es necesario
session_start();

// Incluir la conexión a la base de datos
include '../conexionBD.php';

// Verificar si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $nombre_titular = mysqli_real_escape_string($conn, $_POST['name']);
    $numero_tarjeta = mysqli_real_escape_string($conn, $_POST['card-number']);
    $fecha_vencimiento = mysqli_real_escape_string($conn, $_POST['expiry-date']);
    $cvv = mysqli_real_escape_string($conn, $_POST['cvv']);

    // Datos adicionales, como el ID del usuario, si está registrado
    $id_usuario = isset($_SESSION['cod_usuario']) ? $_SESSION['cod_usuario'] : null;

    // Guardar la compra en la tabla 'compras'
    $sql = "INSERT INTO compras (email, nombre_titular, numero_tarjeta, fecha_vencimiento, cvv, id_usuario, fecha_compra) 
            VALUES (?, ?, ?, ?, ?, ?, NOW())";

    // Preparar la consulta
    if ($stmt = mysqli_prepare($conn, $sql)) {
        // Enmascarar parcialmente el número de tarjeta para evitar almacenar datos sensibles
        $numero_tarjeta_oculto = str_repeat('*', 12) . substr($numero_tarjeta, -4);

        // Vincular parámetros (sin almacenar el número de tarjeta completo por razones de seguridad)
        mysqli_stmt_bind_param($stmt, "sssssi", $email, $nombre_titular, $numero_tarjeta_oculto, $fecha_vencimiento, $cvv, $id_usuario);

        // Ejecutar la consulta
        if (mysqli_stmt_execute($stmt)) {
            echo "<div class='alert alert-success'>Compra procesada exitosamente.</div>";
        } else {
            echo "<div class='alert alert-danger'>Error al procesar la compra: " . mysqli_error($conn) . "</div>";
        }

        // Cerrar la declaración
        mysqli_stmt_close($stmt);
    } else {
        echo "<div class='alert alert-danger'>Error en la preparación de la consulta: " . mysqli_error($conn) . "</div>";
    }
}
header("Location: ../pago/metodo_pago.html");

// Cerrar la conexión
mysqli_close($conn);
?>
