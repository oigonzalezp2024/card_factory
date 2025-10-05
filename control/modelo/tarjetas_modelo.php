<?php
include 'conexion.php';
$conn = conexion();

$accion = $_GET['accion'];

if($accion == "insertar"){

    $id_registro = $_POST['id_registro'];
    $monto = $_POST['monto'];
    $codigo = $_POST['codigo'];
    $aliado_id = $_POST['aliado_id'];
    $tarjeta_estado = $_POST['tarjeta_estado'];

    $sql="INSERT INTO tarjetas(
          id_registro, monto, codigo, aliado_id, tarjeta_estado
          )VALUE(
          '$id_registro', '$monto', '$codigo', '$aliado_id', '$tarjeta_estado')";

    echo $consulta = mysqli_query($conn, $sql);
}

elseif($accion == "modificar"){

    $id_registro = $_POST['id_registro'];
    $monto = $_POST['monto'];
    $codigo = $_POST['codigo'];
    $aliado_id = $_POST['aliado_id'];
    $tarjeta_estado = $_POST['tarjeta_estado'];

    $sql="UPDATE tarjetas SET
          monto = '$monto', 
          codigo = '$codigo', 
          aliado_id = '$aliado_id', 
          tarjeta_estado = '$tarjeta_estado'
          WHERE id_registro = '$id_registro'";

    echo $consulta = mysqli_query($conn, $sql);
}

elseif($accion == "borrar"){

    $id_registro = $_POST['id_registro'];

    $sql = "DELETE FROM tarjetas
            WHERE id_registro = '$id_registro'";

    echo $consulta = mysqli_query($conn, $sql);
}


?>