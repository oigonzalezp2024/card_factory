<?php
include 'conexion.php';
$conn = conexion();

$accion = $_GET['accion'];

if($accion == "insertar"){

    $id_aliado = $_POST['id_aliado'];
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $babull_url = $_POST['babull_url'];
    $logo_url = $_POST['logo_url'];

    $sql="INSERT INTO aliados(
          id_aliado, nombre, telefono, babull_url, logo_url
          )VALUE(
          '$id_aliado', '$nombre', '$telefono', '$babull_url', '$logo_url')";

    echo $consulta = mysqli_query($conn, $sql);
}

elseif($accion == "modificar"){

    $id_aliado = $_POST['id_aliado'];
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $babull_url = $_POST['babull_url'];
    $logo_url = $_POST['logo_url'];

    $sql="UPDATE aliados SET
          nombre = '$nombre', 
          telefono = '$telefono', 
          babull_url = '$babull_url', 
          logo_url = '$logo_url'
          WHERE id_aliado = '$id_aliado'";

    echo $consulta = mysqli_query($conn, $sql);
}

elseif($accion == "borrar"){

    $id_aliado = $_POST['id_aliado'];

    $sql = "DELETE FROM aliados
            WHERE id_aliado = '$id_aliado'";

    echo $consulta = mysqli_query($conn, $sql);
}


?>