<?php
include_once '../../modelo/conexion.php';
$conn = conexion();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>arreglos</title>
</head>
<div class="row"><br><br><br><br>
    <div>
<center>
<h2>aliados</h2>
</center>
<a class="btn" href="../../services/cargado/index.php"><span class="glyphicon glyphicon-plus"></a>
</div>
    <table class="table table-hover table-condensed table-bordered table-responsive">
    <thead>
        <tr>
            <th>id_aliado</th>
            <th>nombre</th>
            <th>telefono</th>
            <th>babull_url</th>
            <th>logo_url</th>
        </tr>
   </thead>
    <tbody>
    <?php
    $sql = 'SELECT * FROM aliados';
    $result = mysqli_query($conn, $sql);
    WHILE($fila = mysqli_fetch_assoc($result)){
        $datos = $fila['id_aliado'] . "||" .
                  $fila['nombre'] . "||" .
                  $fila['telefono'] . "||" .
                  $fila['babull_url'] . "||" .
                  $fila['logo_url'];
    ?>
        <tr>
            <td><?php echo $fila['id_aliado']; ?></td>
            <td><?php echo $fila['nombre']; ?></td>
            <td><?php echo $fila['telefono']; ?></td>
            <td><?php echo $fila['babull_url']; ?></td>
            <td><?php echo $fila['logo_url']; ?></td>
            <td>
                <button class="btn btn-warning glyphicon glyphicon-pencil"
                               data-toggle="modal"
                               data-target="#modalEdicion"
                               onclick="agregaform('<?php echo $datos; ?>')">
                </button></td>
            <td>
                <button class="btn btn-danger glyphicon glyphicon-remove"
                           onclick="preguntarSiNo('<?php echo $fila['id_aliado']; ?>')">
                </button>
            </td>
        </tr>
    <?php
    }
    ?>
    </tbody>
    </table>
</div>
</body>
</html>
<?php
mysqli_close($conn);
?>
