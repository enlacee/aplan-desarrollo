var base_url;
var modo;
var codigo;
var calendario;
jQuery(document).ready(function(){
	base_url   = $("#base_url").val();
	modo   = $("#modo").val();
	codigo   = $("#codigo").val();
	calendario   = $("#calendario").val();
	$("#cargando").hide();
	$("#error").hide();
	
	$("#grabarCalendario_popup").click(function(){
		$("#frmGrabarCalendario_popup").submit();
	});
	$("#limpiar").click(function(){
        url = base_url+"configuracionmps/calendario/listar_calendario";
        location.href=url;
	});
	$("#cancelarCalendario").click(function(){
        url = base_url+"configuracionmps/calendario/editar_calendario/"+codigo;
		location.href = url;
	});

	$("#frmGrabarCalendario_popup").validate({
		event    : "blur",
		rules: {
			fechainicio: "required",
			fechafin: "required",
		},
		messages: {
			fechainicio: "Ingrese Fecha de Inicio",
			fechafin: "Ingrese Fecha de Fin",
		},
		debug    : true,
		errorElement   : "label",
		errorContainer : $("#errores"),
		submitHandler  : function(form){
			fechainicio	= $("#fechainicio").val();
			fechafin	= $("#fechafin").val();
			descripcion	= $("#descripcion").val();
			dataString = $("#frmGrabarCalendario_popup").serialize();
			$.ajax({
				type : "POST",
				url : base_url+"configuracionmps/calendario/modificar_calendario",
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
						parent.$.fancybox.close();
						parent.actualiza_pagina();
					}
				}
			})
		}
	});
	
});
