var base_url;
var modo;
var codigo;
var tipo_orden;
jQuery(document).ready(function(){
	base_url   	= $("#base_url").val();
	modo   		= $("#modo").val();
	tipo_orden  = $("#tipo_orden").val();
	codigo   	= $("#codigo").val();
	
	$("#cargando").hide();
	$("#error").hide();
	
	$("#nuevoCabecera").click(function(){
		url = base_url+"mps/tablamps/nuevo_tablamps";
		location.href = url;
	});
	$("#grabarCabecera").click(function(){
		$("#frmGrabarCabeceraMps").submit();
	});
	$("#limpiar").click(function(){
        url = base_url+"mps/tablamps/listar_tablamps";
        location.href=url;
	});
	$("#cancelarCabecera").click(function(){
        url = base_url+"mps/tablamps/listar_tablamps";
        location.href = url;
	});
	$("#buscarCabecera").click(function(){
		//$("#form_busquedaArea").submit();
	});
	
	$("#frmGrabarCabeceraMps").validate({
		event    : "blur",
		rules: {
			txtCodigo: "required",
		},
		messages: {
			txtCodigo : "Ingrese codigo",
		},
		debug    : true,
		errorElement   : "label",
		errorContainer : $("#errores"),
		submitHandler  : function(form){
			dataString = $("#frmGrabarCabeceraMps").serialize();
			$.ajax({
				type : "POST",
				url : base_url+"mps/tablamps/insertar_tablamps",
				data: dataString,
				beforeSend: function(data) {
					$("#cargando").show();
				},
				error: function(data) {
					$("#error").html("OCURRIO UN ERROR");
					$("#error").show();
					$("#cargando").hide();
				},
				success: function(data){
					$("#cargando").hide();
					if(data != null){
						//url = base_url+"mps/tablamps/listar_tablamps";
						//location.href=url;
					}
				}
			})
		}
	});
	
});

function editar_orden(cod_orden){
	url = base_url+"compras/orden/editar_orden/"+tipo_orden+"/"+cod_orden;
	location.href = url;
}

function ver_orden(cod_orden){
	url = base_url+"compras/orden/ver_orden/"+tipo_orden+"/"+cod_orden;
	location.href = url;
}
