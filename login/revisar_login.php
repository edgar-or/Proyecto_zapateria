<?php
session_start();

// Cambia 'nickname' al nombre de la variable que estás utilizando para almacenar el nickname en la sesión.
$response = array('logged_in' => false, 'nick_name' => '');

if (isset($_SESSION['nick_name'])) {
    $response['logged_in'] = true;
    $response['nick_name'] = $_SESSION['nick_name'];
}

header('Content-Type: application/json');
echo json_encode($response);
?>
