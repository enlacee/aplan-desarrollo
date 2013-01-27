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
	
	$("#grabarConfiguracionmensaje").click(function(){
		$("#frmGrabarConfiguracionmensaje").submit();
	});
	
	$("#cancelarConfiguracionmensaje").click(function(){
		//$("#frmGrabarCalendario").submit();
	});
	
	$("#frmGrabarConfiguracionmensaje").validate({
		event    : "blur",
		rules: {
			posible_rotura: "required",
			inventa_debajo: "required"
		},
		messages: {
			posible_rotura: "Ingrese un n&uacute;mero para calcular una posible rotura de stock",
			inventa_debajo: "Ingrese un n&uacute;mero para calcular si el inventario esta por debajo del stock de seguridad"
		},
		debug    : true,
		errorElement   : "label",
		errorContainer : $("#errores"),
		submitHandler  : function(form){
			dataString  = $('#frmGrabarConfiguracionmensaje').serialize();
			$.ajax({
				type : "POST",
				url : base_url+"configuracionmps/configuracionmensaje/insertar_configuracionmensaje",
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