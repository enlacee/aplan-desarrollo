var base_url;
var modo;
var codigo;
jQuery(document).ready(function(){
	base_url   = $("#base_url").val();
	modo   = $("#modo").val();
	
	$("#cargando").hide();
	$("#error").hide();
	
	$("#nuevoAlerta").click(function(){
		url = base_url+"alertas/alerta/nuevo_alerta";
		location.href = url;
	});
	$("#grabarAlerta").click(function(){
		$("#frmAlerta").submit();
	});
	$("#limpiar").click(function(){
        url = base_url+"alertas/alerta/listar_alertas";
        location.href=url;
	});
	$("#cancelarAlerta").click(function(){
        url = base_url+"alertas/alerta/listar_alertas";
        location.href = url;
	});
	$("#buscarAlerta").click(function(){
		$("#form_busquedaArea").submit();
	});
	
	$("#frmAlerta").validate({
		event    : "blur",
		rules: {
			txtCodigo: "required",
			txtNombre: "required",
		},
		messages: {
			txtCodigo: "Ingrese Codigo",
			txtNombre: "Ingrese Nombre",
		},
		debug    : true,
		errorElement   : "label",
		errorContainer : $("#errores"),
		submitHandler  : function(form){
			dataString = $("#frmAlerta").serialize();
			$.ajax({
				type : "POST",
				url : base_url+"alertas/alerta/insertar_alerta/",
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
						url = base_url+"alertas/alerta/listar_alertas";
						location.href=url;
					}
				}
			})
		}
	});
	
});

function ver_alerta(codigo){
	url = base_url+"alertas/alerta/ver_alerta/"+codigo;
	location.href=url;
}

function editar_alerta(cod_alerta){
	url = base_url+"alertas/alerta/editar_alerta/"+cod_alerta;
	location.href=url;
}
function eliminar_alerta(cod_alerta){
	if(window.confirm("Esta seguro que desea eliminar?")){
		 // codigo   = $("#codigo").val();
		url = base_url+"alertas/alerta/eliminar_alerta/"+cod_alerta;
		location.href=url;
	}
}