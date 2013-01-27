var base_url;
var modo;
var codigo;
jQuery(document).ready(function(){
	base_url   = $("#base_url").val();
	modo   = $("#modo").val();
	codigo   = $("#codigo").val();
	
	$("#cargando").hide();
	$("#error").hide();
	
	$("#nuevoCompania").click(function(){
		url = base_url+"maestros/compania/nuevo_compania";
		location.href = url;
	});
	$("#grabarCompania").click(function(){
		$("#frmGrabarCompania").submit();
	});
	$("#limpiar").click(function(){
        url = base_url+"maestros/compania/listar_compania";
        location.href=url;
	});
	$("#cancelarCompania").click(function(){
        url = base_url+"maestros/compania/listar_compania";
        location.href = url;
	});
	$("#buscarCompania").click(function(){
		//$("#form_busquedaArea").submit();
	});
	
	$("#frmGrabarCompania").validate({
		event    : "blur",
		rules: {
			ruc: "required",
			razon: "required",
		},
		messages: {
			ruc: "Ingrese su RUC",
			razon: "Ingrese su Raz&oacute; Social",
		},
		debug    : true,
		errorElement   : "label",
		errorContainer : $("#errores"),
		submitHandler  : function(form){
			dataString = $("#frmGrabarCompania").serialize();
			$.ajax({
				type : "POST",
				url : base_url+"maestros/compania/insertar_compania",
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
						url = base_url+"maestros/compania/listar_compania";
						location.href=url;
					}
				}
			})
		}
	});
	
});

function editar_compania(cod_compania){
	url = base_url+"maestros/compania/editar_compania/"+cod_compania;
    location.href=url;
}
function eliminar_compania(cod_compania){
	if(window.confirm("Esta seguro que desea eliminar esta compañia?")){
		$.ajax({
			type : "POST",
			url : base_url+"maestros/compania/eliminar_compania",
			data: "codigo="+cod_compania,
			beforeSend: function(data) {
				$("#cargando").show();
			},
			error: function(data) {
				$("#error").show();
				$("#cargando").hide();
			},
			success: function(data){
				//$("#limpiar").click();
			}
		})
	}
}