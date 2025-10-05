function agregardatos(id_fabricante, logo_url){
    cadena = "id_fabricante=" + id_fabricante +
    "&logo_url=" + logo_url;

    accion = "insertar";
    mensaje_si = "Cliente agregado con exito";
    mensaje_no= "Error de registro";
    a_ajax(cadena, accion, mensaje_si, mensaje_no);
}
function agregaform(datos) {
    d = datos.split('||');
    $('#id_fabricanteu').val(d[0]);
    $('#logo_urlu').val(d[1]);
}

function modificarCliente(){
    id_fabricante = $('#id_fabricanteu').val();
    logo_url = $('#logo_urlu').val();
    cadena = "id_fabricante=" + id_fabricante +
    "&logo_url=" + logo_url;

    accion = "modificar";
    mensaje_si = "Cliente modificado con exito";
    mensaje_no= "Error de registro";
    a_ajax(cadena, accion, mensaje_si, mensaje_no);
}

function preguntarSiNo(id_fabricante) {
    var opcion = confirm("¿Esta seguro de eliminar el registro?");
    if (opcion == true) {
        alert("El registro será eliminado.");
        eliminarDatos(id_fabricante);
    } else {
        alert("El proceso de eliminación del registro ha sido cancelado.");
    }
}

function eliminarDatos(id_fabricante) {
    cadena = "id_fabricante=" + id_fabricante;

    accion = "borrar";
    mensaje_si = "Cliente borrado con exito";
    mensaje_no= "Error de registro";
    a_ajax(cadena, accion, mensaje_si, mensaje_no);
}

function a_ajax(cadena, accion, mensaje_si, mensaje_no){
    $.ajax({
        type: "POST",
        url: "../modelo/fabricante_modelo.php?accion="+accion,
        data: cadena,
        success: function (r){
            if (r == 1) {
            $('#tabla').load('../vista/componentes/vista_fabricante.php');
                alert(mensaje_si);
            } else {
                alert(mensaje_no);
            }
        }
    });
}
