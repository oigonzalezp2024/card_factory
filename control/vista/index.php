<!DOCTYPE html>
<html>
    <head>
	<meta charset="UTF-8">
	<title>Clientes</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<?php
	include('librerias.php');
	?>
	<script src="../controlador/funciones_aliados.js"></script>
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
			<label>id_aliado</label>
			<input type="number" id="id_aliado" class="form-control input-sm" required="">
			<label>nombre</label>
			<textarea id="nombre" rows="4" cols="50"class="form-control input-sm" required=""></textarea>
			<label>telefono</label>
			<textarea id="telefono" rows="4" cols="50"class="form-control input-sm" required=""></textarea>
			<label>babull_url</label>
			<textarea id="babull_url" rows="4" cols="50"class="form-control input-sm" required=""></textarea>
			<label>logo_url</label>
			<textarea id="logo_url" rows="4" cols="50"class="form-control input-sm" required=""></textarea>
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
			<input type="number" hidden="" id="id_aliadou">
			<label>nombre</label>
			<textarea id="nombreu" rows="4" cols="50" class="form-control input-sm" required=""></textarea>
			<label>telefono</label>
			<textarea id="telefonou" rows="4" cols="50" class="form-control input-sm" required=""></textarea>
			<label>babull_url</label>
			<textarea id="babull_urlu" rows="4" cols="50" class="form-control input-sm" required=""></textarea>
			<label>logo_url</label>
			<textarea id="logo_urlu" rows="4" cols="50" class="form-control input-sm" required=""></textarea>
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
		$('#tabla').load('componentes/vista_aliados.php');
	    });
	</script>
	<script type="text/javascript">
	    $(document).ready(function () {
		$('#guardarnuevo').click(function () {
		    id_aliado = $('#id_aliado').val();
		    nombre = $('#nombre').val();
		    telefono = $('#telefono').val();
		    babull_url = $('#babull_url').val();
		    logo_url = $('#logo_url').val();
		    agregardatos(id_aliado, nombre, telefono, babull_url, logo_url);
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
