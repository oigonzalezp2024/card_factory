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
<h2>tarjetas</h2>
</center>
<button class="btn btn-primary navbar-left"
               data-toggle="modal"
               data-target="#modalNuevo">
    Agregar tarjetas
    <span class="glyphicon glyphicon-plus"></span>
</button></div>
    <table class="table table-hover table-condensed table-bordered table-responsive">
    <thead>
        <tr>
            <th>id_registro</th>
            <th>monto</th>
            <th>codigo</th>
            <th>aliado_id</th>
            <th>tarjeta_estado</th>
        </tr>
   </thead>
    <tbody>
    <?php
    $sql = 'SELECT * FROM tarjetas';
    $result = mysqli_query($conn, $sql);
    WHILE($fila = mysqli_fetch_assoc($result)){
        $datos = $fila['id_registro'] . "||" .
                  $fila['monto'] . "||" .
                  $fila['codigo'] . "||" .
                  $fila['aliado_id'] . "||" .
                  $fila['tarjeta_estado'];
    ?>
        <tr>
            <td><?php echo $fila['id_registro']; ?></td>
            <td><?php echo $fila['monto']; ?></td>
            <td><?php echo $fila['codigo']; ?></td>
            <td><?php echo $fila['aliado_id']; ?></td>
            <td><?php echo $fila['tarjeta_estado']; ?></td>
            <td>
                <button class="btn btn-warning glyphicon glyphicon-pencil"
                               data-toggle="modal"
                               data-target="#modalEdicion"
                               onclick="agregaform('<?php echo $datos; ?>')">
                </button></td>
            <td>
                <button class="btn btn-danger glyphicon glyphicon-remove"
                           onclick="preguntarSiNo('<?php echo $fila['id_registro']; ?>')">
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
