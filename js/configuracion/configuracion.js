var base_url;
var modo;
var codigo;
jQuery(document).ready(function(){
	base_url   = $("#base_url").val();
	modo   = $("#modo").val();
	codigo   = $("#codigo").val();
	
	$("#cargando").hide();
	$("#error").hide();
	$("#success").hide();
	
	$("#grabarConfiguracion").click(function(){
		$("#frmGrabarConfiguracion").submit();
	});
	
	$("#cancelarConfiguracion").click(function(){
		//$("#frmGrabarCalendario").submit();
	});
	
	$("#frmGrabarConfiguracion").validate({
		event    : "blur",
		rules: {
			hora: "required"
		},
		messages: {
			hora: "Ingrese Hora que se ejecutará el proceso"
		},
		debug    : true,
		errorElement   : "label",
		errorContainer : $("#errores"),
		submitHandler  : function(form){
			dataString  = $('#frmGrabarConfiguracion').serialize();
			$.ajax({
				type : "POST",
				url : base_url+"configuracion/configuracion/insertar_configuracion",
				data: dataString,
				beforeSend: function(data) {
					$("#cargando").show();
					$("#success").hide();
				},
				error: function(data) {
					$("#error").html("OCURRIO UN ERROR");
					$("#error").show();
					$("#cargando").hide();
				},
				success: function(data){
					$("#cargando").hide();
					if(data != null){
						$("#cargando").hide();
						$("#error").hide();
						$("#success").show();
					}
				}
			})
		}
	});
	
});