<?php

// Incluir la conexión a la base de datos
include '../conexionBD.php';
include 'carrito.php';

// Obtener los métodos de pago del usuario
$metodos_de_pago = metodosPagos($conn, $_SESSION['cod_usuario']);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../bootstrap-5.3.3-dist/css/bootstrap.min.css" />
    <title>Seleccionar Método de Pago</title>
</head>

<body class="bg-light">
    <div class="container mt-5">
        <h2 class="mb-4">Selecciona un Método de Pago</h2>
        <form action="procesar_pago.php" method="POST">
            <div class="form-group">
                <label for="metodo_pago">Método de Pago:</label>
                <select class="form-control" id="metodo_pago" name="metodo_pago" required>
                    <?php foreach ($metodos_de_pago as $metodo) : ?>
                        <option value="<?php echo $metodo['cod_metodo']; ?>">
                            <?php echo $metodo['nombre_titular'] . ' - **** ' . substr($metodo['numero_tarjeta'], -4); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button name="finalizar_compra" type="submit" class="btn btn-primary mt-3">Usar este Método de Pago</button>
            <a name="" href="dama.php" class="btn btn-primary mt-3">Volver al Catálogo</a>
        </form>
    </div>

    <script src="../bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
