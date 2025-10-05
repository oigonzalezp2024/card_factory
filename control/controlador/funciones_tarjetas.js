function agregardatos(id_registro, monto, codigo, aliado_id, tarjeta_estado){
    cadena = "id_registro=" + id_registro +
    "&monto=" + monto +
    "&codigo=" + codigo +
    "&aliado_id=" + aliado_id +
    "&tarjeta_estado=" + tarjeta_estado;

    accion = "insertar";
    mensaje_si = "Cliente agregado con exito";
    mensaje_no= "Error de registro";
    a_ajax(cadena, accion, mensaje_si, mensaje_no);
}
function agregaform(datos) {
    d = datos.split('||');
    $('#id_registrou').val(d[0]);
    $('#montou').val(d[1]);
    $('#codigou').val(d[2]);
    $('#aliado_idu').val(d[3]);
    $('#tarjeta_estadou').val(d[4]);
}

function modificarCliente(){
    id_registro = $('#id_registrou').val();
    monto = $('#montou').val();
    codigo = $('#codigou').val();
    aliado_id = $('#aliado_idu').val();
    tarjeta_estado = $('#tarjeta_estadou').val();
    cadena = "id_registro=" + id_registro +
    "&monto=" + monto +
    "&codigo=" + codigo +
    "&aliado_id=" + aliado_id +
    "&tarjeta_estado=" + tarjeta_estado;

    accion = "modificar";
    mensaje_si = "Cliente modificado con exito";
    mensaje_no= "Error de registro";
    a_ajax(cadena, accion, mensaje_si, mensaje_no);
}

function preguntarSiNo(id_registro) {
    var opcion = confirm("¿Esta seguro de eliminar el registro?");
    if (opcion == true) {
        alert("El registro será eliminado.");
        eliminarDatos(id_registro);
    } else {
        alert("El proceso de eliminación del registro ha sido cancelado.");
    }
}

function eliminarDatos(id_registro) {
    cadena = "id_registro=" + id_registro;

    accion = "borrar";
    mensaje_si = "Cliente borrado con exito";
    mensaje_no= "Error de registro";
    a_ajax(cadena, accion, mensaje_si, mensaje_no);
}

function a_ajax(cadena, accion, mensaje_si, mensaje_no){
    $.ajax({
        type: "POST",
        url: "../modelo/tarjetas_modelo.php?accion="+accion,
        data: cadena,
        success: function (r){
            if (r == 1) {
            $('#tabla').load('../vista/componentes/vista_tarjetas.php');
                alert(mensaje_si);
            } else {
                alert(mensaje_no);
            }
        }
    });
}
