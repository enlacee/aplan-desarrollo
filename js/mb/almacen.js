var base_url;

jQuery(document).ready( function() {
    base_url = $("#base_url").val();
    $("#nuevoGrupo").click( function() {
        url = base_url + "index.php/mb/almacen/nuevo";
        location.href = url;
    } );
    $("#limpiarGrupo").click( function() {
        url = base_url + "index.php/mb/almacen/listar_almacenes";
        location.href=url;
    } );
    $("#cancelar").click( function() {
        url = base_url + "index.php/mb/almacen/listar_almacenes";
        location.href = url;
    } );
    $("#buscarGrupo").click( function() {
        //$("#form_busquedaGrupo").submit();
        $("#form_busquedaAlamcen").submit();
        
    } );
    $("#guardar").click( function() {
        console.log("CLICK");
        $("#frmAlmacen").submit();
    } );
} );

function ver_grupo(tp) {
    location.href = base_url + "index.php/mb/almacen/ver/" + tp;
}

function atras_grupo() {
    location.href = base_url + "index.php/mb/almacen/listar_almacenes";
}

function editar_grupo(tp) {
    location.href = base_url + "index.php/mb/almacen/editar_alamcen/" + tp;
}

function eliminar_grupo(cod) {
    if ( confirm('Esta seguro desea eliminar este almacen?') ) {
        dataString = "cod=" + cod;
        url = base_url + "index.php/mb/almacen/eliminar_almacen";
        $.post( url, dataString, function(data) {
            url = base_url+"index.php/mb/almacen/listar_almacenes";
            location.href = url;
        } );
    }
}
