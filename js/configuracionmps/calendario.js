var base_url;
var modo;
var codigo;
jQuery(document).ready(function(){
	base_url   = $("#base_url").val();
	modo   = $("#modo").val();
	codigo   = $("#codigo").val();
	
	$("#cargando").hide();
	$("#error").hide();
	$("#msg").hide();
	
	$("#nuevoCalendario").click(function(){
		url = base_url+"configuracionmps/calendario/nuevo_calendario";
		location.href = url;
	});
	$("#grabarCalendario").click(function(){
		$("#frmGrabarCalendario").submit();
	});
	$("#limpiar").click(function(){
        url = base_url+"configuracionmps/calendario/listar_calendario";
        location.href=url;
	});
	$("#cancelarCalendario").click(function(){
        url = base_url+"configuracionmps/calendario/listar_calendario";
        location.href = url;
	});
	$("#buscarCalendario").click(function(){
		$("#form_busquedaArea").submit();
	});
	
	$("#frmGrabarCalendario").validate({
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
			var modo 	= $("#modo").val();
			dataString = $("#frmGrabarCalendario").serialize();
			$.ajax({
				type : "POST",
				url : base_url+"configuracionmps/calendario/insertar_calendario",
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
						var url = '';
						if(modo == 'editar'){
							alert("SE MODIFICÓ CORRECTAMENTE EL CALENDARIO");
							url = base_url+"configuracionmps/calendario/listar_calendario/";
						}else if(modo == 'insertar'){
							alert("SE INSERTO CORRECTAMENTE EL CALENDARIO");
							url = base_url+"configuracionmps/calendario/editar_calendario/"+data;
						}
						location.href=url;
					}
				}
			})
		}
	});
	
	$(".marcar_fecha").live('click',function(){
		//el id esta compuesto por NOMBRE-DIA-MES
		var id = this.id;
		var id = id.split('-');
		var dia = id[1];
		var mes = id[2];
		var anio = id[3];
		var validar_seleccion = $("#validar_seleccion-"+dia+"-"+mes+"-"+anio).val();
		if(validar_seleccion == 0){
			$("#calendarionumeros-"+dia+"-"+mes+"-"+anio).removeClass('feriados').addClass("calendarionumerosseleccion");
			$("#validar_seleccion-"+dia+"-"+mes+"-"+anio).val("1");
		}else if(validar_seleccion == 1){
			$("#calendarionumeros-"+dia+"-"+mes+"-"+anio).removeClass('calendarionumerosseleccion').addClass('calendarionumeros');
			$("#validar_seleccion-"+dia+"-"+mes+"-"+anio).val("0");
		}
	});
	
	////FUCIONES PARA LA CONFIGURACION GENERAL, ACA NO VAN, LAS PUSE PARA PRUEBAS
	$("#aumentar").live('click',function(){
		var cantidad = 0;
		cantidad = $("#decimales").val();
		cantidad ++;
		$("#decimales").val(cantidad);
		if(cantidad >= 5){
			$("#decimales").val("5");
		}
    });
	
	$("#disminuir").live('click',function(){
		var cantidad = 0;
		cantidad = $("#decimales").val();
		cantidad--;
		$("#decimales").val(cantidad);
		if(cantidad <= 0){
			$("#decimales").val("0");
		}
    });
	////FUCIONES PARA LA CONFIGURACION GENERAL, ACA NO VAN, LAS PUSE PARA PRUEBAS
	
});

function editar_calendario(cod_calendario){
	url = base_url+"configuracionmps/calendario/editar_calendario/"+cod_calendario;
    location.href=url;
}
function eliminar_calendario(cod_calendario){
	if(window.confirm("Esta seguro que desea eliminar este calendario?")){
		$.ajax({
			type : "POST",
			url : base_url+"configuracionmps/calendario/eliminar_calendario",
			data: "codigo="+cod_calendario,
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
function checkTodos (id,pID) {
    $( "#" + pID + " :checkbox").attr('enable', $('#' + id).is(':checked')); 
}