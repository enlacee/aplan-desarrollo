var base_url;
var modo;
var codigo;

jQuery(document).ready( function() {
    
    base_url    = $("#base_url").val();
    modo        = $("#modo").val();
    codigo      = $("#codigo").val();
    
    $("#cargando").hide();
    $("#error").hide();
    
    $("#nuevoCabecera").click( function() {
        url = base_url + "mps/tablamps/nuevo_tablamps";
        location.href = url;
    } );
    
    $("#grabarCabecera").click( function() {
        $("#frmGrabarCabeceraMps").submit();
    } );
    
    $("#limpiar").click( function() {
        url = base_url + "mps/tablamps/listar_tablamps";
        location.href = url;
    } );
    
    $("#cancelarCabecera").click( function() {
        url = base_url + "mps/tablamps/listar_tablamps";
        location.href = url;
    } );
    
    $("#buscarCabecera").click( function() {
        //$("#form_busquedaArea").submit();
    } );
    
    $("#frmGrabarCabeceraMps").validate( {
        event : "blur",
	rules : {
            txtCodigo : "required"
        },
        messages : {
            txtCodigo : "Ingrese codigo"
        },
        debug : true,
        errorElement : "label",
        errorContainer : $("#errores"),
        submitHandler : function(form) {
            dataString = $("#frmGrabarCabeceraMps").serialize();
            $.ajax( {
                type : "POST",
                url : base_url + "mps/tablamps/insertar_tablamps",
                data : dataString,
                beforeSend : function(data) {
                    $("#cargando").show();
                },
                error : function() {
                    $("#error").html( "OCURRIO UN ERROR" );
                    $("#error").show();
                    $("#cargando").hide();
                },
                success : function(data) {
                    $("#cargando").hide();
                    if ( data != null ) {
                        //url = base_url+"mps/tablamps/listar_tablamps";
                        //location.href=url;
                    }
                }
            } );
        }
    } );
    
    $("#generarPronostico").click( function() {
        $.ajax( {
            type : "POST",
            url : base_url + "mps/tablamps/insertar_tablamps2",
            beforeSend : function() {
                $("#cargando").html( 'Procesando ...' );
                $("#cargando").show();
            },
            error : function() {
                $("#error").html( '¡ Ocurrio un error !');
                $("#error").show();
                $("#cargando").hide();
            },
            success : function( data ) {
                $("#cargando").hide();
                $("#cargando").html( 'El proceso termino exitosamente' );
                $("#cargando").show();
                //$("#error").html( "EL PROCESO TERMINO EXITOSAMENTE" );
                if ( data != null ) {
                    //url = base_url + "mps/tablamps/listar_tablamps";
                    //location.href=url;
                }
            }
        } )
    } );
    
} );

function editar_cabecera( codigo, calendario ) {
    url = base_url + "mps/tablamps/editar_detalle_tablamps/" + codigo;
    location.href = url;
}

function ver_cabecera( cod_cabecera ) {
    url = base_url + "mps/tablamps/ver_tablamps/" + cod_cabecera;
    location.href = url;
}
