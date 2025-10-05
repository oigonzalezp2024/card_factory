<?php
function conexion(){
    $host = 'localhost';
    $user = 'root';
    $password = '';
    $database = 'db_tarjetas_aliados';
    $conn = mysqli_connect($host, $user, $password, $database);
    return $conn;
}
?>
