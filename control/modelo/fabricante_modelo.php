<?php
include 'conexion.php';
$conn = conexion();

$accion = $_GET['accion'];

if($accion == "insertar"){

    $id_fabricante = $_POST['id_fabricante'];
    $logo_url = $_POST['logo_url'];

    $sql="INSERT INTO fabricante(
          id_fabricante, logo_url
          )VALUE(
          '$id_fabricante', '$logo_url')";

    echo $consulta = mysqli_query($conn, $sql);
}

elseif($accion == "modificar"){

    $id_fabricante = $_POST['id_fabricante'];
    $logo_url = $_POST['logo_url'];

    $sql="UPDATE fabricante SET
          logo_url = '$logo_url'
          WHERE id_fabricante = '$id_fabricante'";

    echo $consulta = mysqli_query($conn, $sql);
}

elseif($accion == "borrar"){

    $id_fabricante = $_POST['id_fabricante'];

    $sql = "DELETE FROM fabricante
            WHERE id_fabricante = '$id_fabricante'";

    echo $consulta = mysqli_query($conn, $sql);
}


?>