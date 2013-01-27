var base_url;

jQuery(document).ready( function() {
    base_url = $("#base_url").val();
    $("#nuevoGrupo").click( function() {
        url = base_url + "index.php/mb/grupo_temporadas/nuevo";
        location.href = url;
    } );
    $("#limpiarGrupo").click( function() {
        url = base_url + "index.php/mb/grupo_temporadas/listar";
        location.href=url;
    } );
    $("#cancelar").click( function() {
        url = base_url + "index.php/mb/grupo_temporadas/listar";
        location.href = url;
    } );
    $("#buscarGrupo").click( function() {
        $("#form_busquedaGrupoTemporadas").submit();
    } );
    $("#guardar").click( function() {
        $("#frmGrupoTemporadas").submit();
    } );
} );

function ver( codigo ) {
    location.href = base_url + "index.php/mb/grupo_temporadas/ver/" + codigo;
}

function atras() {
    location.href = base_url + "index.php/mb/grupo_temporadas/listar";
}

function editar( codigo ) {
    location.href = base_url + "index.php/mb/grupo_temporadas/editar/" + codigo;
}

function eliminar( codigo ) {
    if ( confirm('Esta seguro desea eliminar este grupo de temporadas?') ) {
        dataString = "cod=" + codigo;
        url = base_url + "index.php/mb/grupo_temporadas/eliminar";
        $.post( url, dataString, function(data) {
            url = base_url + "index.php/mb/grupo_temporadas/listar";
            location.href = url;
        } );
    }
}

//new grupo temporada detalle
function eliminar_grupo_temporada_detalle(codigo_padre, codigo_hijo){
    if ( confirm('Esta seguro desea eliminar esta temporada del grupo?') ) {
        dataString = "cod=" + codigo_hijo;
        url = base_url + "index.php/mb/grupo_temporadas/eliminar_detalle";
        $.post( url, dataString, function(data) {
            url = base_url + "index.php/mb/grupo_temporadas/editar/"+codigo_padre;
            location.href = url;
        } );
    }
}
