var base_url;
var modo;
var codigo;
jQuery(document).ready(function(){
	base_url   = $("#base_url").val();
	modo   = $("#modo").val();
	codigo   = $("#codigo").val();
	
	$("#cargando").hide();
	$("#error").hide();
	
	$("#nuevoPlan").click(function(){
		url = base_url+"configuracionmps/plan/nuevo_plan";
		location.href = url;
	});
	$("#grabarPlan").click(function(){
		$("#frmGrabarPlan").submit();
	});
	$("#limpiar").click(function(){
        url = base_url+"configuracionmps/plan/listar_plan";
        location.href=url;
	});
	$("#cancelarPlan").click(function(){
        url = base_url+"configuracionmps/plan/listar_plan";
        location.href = url;
	});
	$("#buscarPlan").click(function(){
		//$("#form_busquedaArea").submit();
	});
	
	$("#frmGrabarPlan").validate({
		event    : "blur",
		rules: {
			codigointerno: "required",
		},
		messages: {
			codigointerno: "Ingrese c&oacute;digo",
		},
		debug    : true,
		errorElement   : "label",
		errorContainer : $("#errores"),
		submitHandler  : function(form){
			dataString = $("#frmGrabarPlan").serialize();
			$.ajax({
				type : "POST",
				url : base_url+"configuracionmps/plan/insertar_plan",
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
						url = base_url+"configuracionmps/plan/listar_plan";
						location.href=url;
					}
				}
			})
		}
	});
	
});

function editar_plan(cod_plan){
	url = base_url+"configuracionmps/plan/editar_plan/"+cod_plan;
    location.href=url;
}
function eliminar_plan(cod_plan){
	if(window.confirm("Esta seguro que desea eliminar este plan?")){
		$.ajax({
			type : "POST",
			url : base_url+"configuracionmps/plan/eliminar_plan",
			data: "codigo="+cod_plan,
			beforeSend: function(data) {
				$("#cargando").show();
			},
			error: function(data) {
				$("#error").show();
				$("#cargando").hide();
			},
			success: function(data){
				$("#limpiar").click();
			}
		})
	}
}