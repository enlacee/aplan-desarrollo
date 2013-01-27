var base_url;
jQuery(document).ready(function(){
	base_url   = $("#base_url").val();
	$("#nuevoUsuario").click(function(){
		url = base_url+"seguridad/usuario/nuevo_usuario";
		location.href = url;
	});	
 	$("#grabarUsuario").click(function(){
            $("#frmUsuario").submit();
	}); 
	$("#limpiarUsuario").click(function(){
            url = base_url+"seguridad/usuario/usuarios";
            $("#txtNombres").val('');
            $("#txtUsuario").val('');
            $("#txtRol").val('');
            location.href=url;
	});
	$("#cancelarUsuario").click(function(){
            url = base_url+"seguridad/usuario/usuarios";
            location.href = url;
	});
	$("#buscarUsuario").click(function(){
		$("#form_busquedaUsuario").submit();
	});
	$("#frmUsuario").validate({
		event    : "blur",
		rules: {
			txtNombres: "required",
			txtPaterno: "required",
			cboRol: "required",
		},
		messages: {
			txtNombres: "Ingrese Nombre",
			txtPaterno: "Ingrese Apellido Paterno",
			cboRol: "Ingrese un Rol",
		},
		debug    : true,
		errorElement   : "label",
		errorContainer : $("#errores"),
		submitHandler  : function(form){
			txtNombres     = $("#txtNombres").val();
			txtPaterno     = $("#txtPaterno").val();
			txtMaterno     = $("#txtMaterno").val();
			txtUsuario     = $("#txtUsuario").val();
			txtClave       = $("#txtClave").val();
			cboRol         = $("#cboRol").val();
			modo           = $("#modo").val();
			codigo         = $("#codigo").val();
			cboCompaniaUsuario         = $("#cboCompaniaUsuario").val();
			cboEscenarios         = $("#cboEscenarios").val();
			dataString  = "txtNombres="+txtNombres+"&txtPaterno="+txtPaterno+"&txtMaterno="+txtMaterno+"&txtUsuario="+txtUsuario+"&txtClave="+txtClave+"&cboRol="+cboRol+"&modo="+modo+"&codigo="+codigo+"&cboCompaniaUsuario="+cboCompaniaUsuario+"&cboEscenarios="+cboEscenarios;
			if(modo=='insertar'){
				url = base_url+"seguridad/usuario/insertar_usuario";
				$.post(url,dataString,function(data){
					alert('Se ha insertado un nuevo usuario.');
					location.href = base_url+"seguridad/usuario/usuarios";
				});				
			}
			else if(modo=='modificar'){
				url = base_url+"seguridad/usuario/modificar_usuario";
				$.post(url,dataString,function(data){	
					location.href = base_url+"seguridad/usuario/usuarios";
				});				
			}
		}
	});
/*Cuenta*/
 	$("#grabarCuenta").click(function(){
		$("#frmCuenta").submit();	
	}); 
	$("#limpiarCuenta").click(function(){
		$("#frmCuenta").each(function(){
			this.reset();
		});
	});
	$("#cancelarCuenta").click(function(){
		url = base_url+"seguridad/usuario";
		location.href = url;		
	});	
	$("#frmCuenta").validate({
		event    : "blur",
		rules    : {'txtNombres' : "required"},
		debug    : true,
		errorElement   : "label",
		errorContainer : $("#errores"),
		submitHandler  : function(form){
			txtNombres     = $("#txtNombres").val();
			txtPaterno     = $("#txtPaterno").val();
			txtMaterno     = $("#txtMaterno").val();
			txtUsuario     = $("#txtUsuario").val();
			txtClave       = $("#txtClave").val();
			modo           = $("#modo").val();
			codigo         = $("#codigo").val();
			dataString  = "txtNombres="+txtNombres+"&txtPaterno="+txtPaterno+"&txtMaterno="+txtMaterno+"&txtUsuario="+txtUsuario+"&txtClave="+txtClave+"&modo="+modo+"&codigo="+codigo;
			if(modo=='modificar'){
				url = base_url+"seguridad/usuario/modificar_cuenta";
				$.post(url,dataString,function(data){	
					location.href = base_url+"seguridad/usuario";
				});				
			}
		}
	});
	
	$("#cboCompaniaUsuario").change(function(){
		var compania = $("#cboCompaniaUsuario").val();
		$.ajax({
			type : "POST",
			url : base_url+"seguridad/usuario/obtener_compania_hijas",
			data: "compania="+compania,
			beforeSend: function(data) {
				$("#cargando").show();
			},
			error: function(data) {
				$("#error").show();
				$("#cargando").hide();
			},
			success: function(data){
				$("#divCboEscenarios").html(data);
			}
		})
	});
	
});
function editar_usuario(usuario){
	location.href = base_url+"seguridad/usuario/editar_usuario/"+usuario;
}
function eliminar_usuario(usuario){
	if(confirm('¿Está seguro que desea eliminar este usuario?')){
		dataString        = "usuario="+usuario;
		$.post("eliminar_usuario",dataString,function(data){
			location.href = base_url+"seguridad/usuario/usuarios";		
		});			
	}
}
function ver_usuario(usuario){
	location.href = base_url+"seguridad/usuario/ver_usuario/"+usuario;
}
function atras_usuario(){
	location.href = base_url+"seguridad/usuario/usuarios";
}
function editar_cuenta(usuario){
	location.href = base_url+"seguridad/editar_cuenta/"+usuario;
}