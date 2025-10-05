function agregardatos(id_aliado, nombre, telefono, babull_url, logo_url){
    cadena = "id_aliado=" + id_aliado +
    "&nombre=" + nombre +
    "&telefono=" + telefono +
    "&babull_url=" + babull_url +
    "&logo_url=" + logo_url;

    accion = "insertar";
    mensaje_si = "Cliente agregado con exito";
    mensaje_no= "Error de registro";
    a_ajax(cadena, accion, mensaje_si, mensaje_no);
}
function agregaform(datos) {
    d = datos.split('||');
    $('#id_aliadou').val(d[0]);
    $('#nombreu').val(d[1]);
    $('#telefonou').val(d[2]);
    $('#babull_urlu').val(d[3]);
    $('#logo_urlu').val(d[4]);
}

function modificarCliente(){
    id_aliado = $('#id_aliadou').val();
    nombre = $('#nombreu').val();
    telefono = $('#telefonou').val();
    babull_url = $('#babull_urlu').val();
    logo_url = $('#logo_urlu').val();
    cadena = "id_aliado=" + id_aliado +
    "&nombre=" + nombre +
    "&telefono=" + telefono +
    "&babull_url=" + babull_url +
    "&logo_url=" + logo_url;

    accion = "modificar";
    mensaje_si = "Cliente modificado con exito";
    mensaje_no= "Error de registro";
    a_ajax(cadena, accion, mensaje_si, mensaje_no);
}

function preguntarSiNo(id_aliado) {
    var opcion = confirm("¿Esta seguro de eliminar el registro?");
    if (opcion == true) {
        alert("El registro será eliminado.");
        eliminarDatos(id_aliado);
    } else {
        alert("El proceso de eliminación del registro ha sido cancelado.");
    }
}

function eliminarDatos(id_aliado) {
    cadena = "id_aliado=" + id_aliado;

    accion = "borrar";
    mensaje_si = "Cliente borrado con exito";
    mensaje_no= "Error de registro";
    a_ajax(cadena, accion, mensaje_si, mensaje_no);
}

function a_ajax(cadena, accion, mensaje_si, mensaje_no){
    $.ajax({
        type: "POST",
        url: "../modelo/aliados_modelo.php?accion="+accion,
        data: cadena,
        success: function (r){
            if (r == 1) {
            $('#tabla').load('../vista/componentes/vista_aliados.php');
                alert(mensaje_si);
            } else {
                alert(mensaje_no);
            }
        }
    });
}
