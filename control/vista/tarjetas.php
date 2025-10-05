<!DOCTYPE html>
<html>
    <head>
	<meta charset="UTF-8">
	<title>Clientes</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<?php
	include('librerias.php');
	?>
	<script src="../controlador/funciones_tarjetas.js"></script>
    </head>
    <body id="body">
	<?php
	include 'header.php';
	?>
	<div class="container">
	    <div id="tabla"></div>
	</div>
	<!-- MODAL PARA INSERTAR REGISTROS -->
	<div class="modal fade" id="modalNuevo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	    <div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
		    <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			    <span aria-hidden="true">&times;</span>
			</button>
			<h4 class="modal-title" id="myModalLabel">Agregar cliente</h4>
		    </div>
		    <div class="modal-body">
			<label>id_registro</label>
			<input type="number" id="id_registro" class="form-control input-sm" required="">
			<label>monto</label>
			<input type="" id="monto" class="form-control input-sm" required="">
			<label>codigo</label>
			<textarea id="codigo" rows="4" cols="50"class="form-control input-sm" required=""></textarea>
			<label>aliado_id</label>
			<input type="number" id="aliado_id" class="form-control input-sm" required="">
			<label>tarjeta_estado</label>
			<input type="number" id="tarjeta_estado" class="form-control input-sm" required="">
			</div>
		    <div class="modal-footer">
			<button type="button" class="btn btn-primary" data-dismiss="modal" id="guardarnuevo">
			    Agregar
			</button>
		    </div>
		</div>
	    </div>
	</div>
	<!-- MODAL PARA EDICION DE DATOS-->
	<div class="modal fade" id="modalEdicion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	    <div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
		    <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			    <span aria-hidden="true">&times;</span>
			</button>
			<h4 class="modal-title" id="myModalLabel">Actualizar datos</h4>
		    </div>
		    <div class="modal-body">
			<input type="number" hidden="" id="id_registrou">
			<label>monto</label>
			<input type="" id="montou" class="form-control input-sm" required="">
			<label>codigo</label>
			<textarea id="codigou" rows="4" cols="50" class="form-control input-sm" required=""></textarea>
			<label>aliado_id</label>
			<input type="number" id="aliado_idu" class="form-control input-sm" required="">
			<label>tarjeta_estado</label>
			<input type="number" id="tarjeta_estadou" class="form-control input-sm" required="">
			</div>
		    <div class="modal-footer">
			<button type="button" class="btn btn-warning" data-dismiss="modal" id="actualizadatos">
			    Actualizar
			</button>
		    </div>
		</div>
	    </div>
	</div>
	<script type="text/javascript">
	    $(document).ready(function () {
		$('#tabla').load('componentes/vista_tarjetas.php');
	    });
	</script>
	<script type="text/javascript">
	    $(document).ready(function () {
		$('#guardarnuevo').click(function () {
		    id_registro = $('#id_registro').val();
		    monto = $('#monto').val();
		    codigo = $('#codigo').val();
		    aliado_id = $('#aliado_id').val();
		    tarjeta_estado = $('#tarjeta_estado').val();
		    agregardatos(id_registro, monto, codigo, aliado_id, tarjeta_estado);
		});
		$('#actualizadatos').click(function () {
		    modificarCliente();
		});
	    });
	</script>
	<?php
	include './footer.php';
	?>
    </body>
</html>
