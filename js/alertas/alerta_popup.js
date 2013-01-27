var base_url;
jQuery(document).ready(function(){
	base_url   = $("#base_url").val();
 	$("#grabarAlerta").click(function(){
		modo = $("#modo").val();
		if(modo == 'insertar'){
			$("#frmAlerta").submit();
			}else{
			$("#frmAlerta").submit();
			// url = base_url+"alertas/alerta/modificar_alerta";
			// $.post(url,dataString,function(data){	
				// location.href = base_url+"alertas/alerta/listar_alertas";
			// });				
		}
	}); 
	
	$("#limpiarAlerta").click(function(){
		url = base_url+"alertas/alerta/nuevo_alerta";
		$("#txtNombres").val('');
		$("#txtUsuario").val('');
		$("#txtRol").val('');
		location.href=url;
	});
	$("#cancelarAlerta").click(function(){
		url = base_url+"alertas/alerta/listar_alertas";
		location.href = url;
	});
	
});

function atras_alerta(){
	location.href = base_url+"alertas/alerta/listar_alertas";
}

//para el caso de las cabeceras sku
function grabarCabecerasku(){
	$("#frmnuevosku").submit();
}