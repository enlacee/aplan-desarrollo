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
	
	$("#grabarConfiguracionmps").click(function(){
		$("#frmGrabarConfiguracionmps").submit();
	});
	
	$("#cancelarConfiguracionmps").click(function(){
		//$("#frmGrabarCalendario").submit();
	});
	
	$("#frmGrabarConfiguracionmps").validate({
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
			dataString  = $('#frmGrabarConfiguracionmps').serialize();
			$.ajax({
				type : "POST",
				url : base_url+"configuracionmps/configuracionmps/insertar_configuracionmps",
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