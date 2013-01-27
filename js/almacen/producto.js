var base_url;
var modo;
var codigo;
jQuery(document).ready(function(){
	base_url   = $("#base_url").val();
	modo   = $("#modo").val();
	
	$("#cargando").hide();
	$("#error").hide();
	
	$("#nuevoProducto").click(function(){
		url = base_url+"almacen/producto/nuevo_producto";
		location.href = url;
	});
	$("#grabarProducto").click(function(){
		$("#frmProducto").submit();
	});
	$("#limpiar").click(function(){
        url = base_url+"almacen/producto/listar_producto";
        location.href=url;
	});
	$("#cancelarProducto").click(function(){
        url = base_url+"almacen/producto/listar_producto";
        location.href = url;
	});
	$("#buscarProducto").click(function(){
		$("#form_busquedaProducto").submit();
	});
	
	$("#frmProducto").validate({
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
			dataString = $("#frmProducto").serialize();
			$.ajax({
				type : "POST",
				url : base_url+"almacen/producto/insertar_producto/",
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
						url = base_url+"almacen/producto/listar_producto";
						location.href=url;
					}
				}
			})
		}
	});
	
});

function ver_producto(cod_producto){
	url = base_url+"almacen/producto/ver_producto/"+cod_producto;
	location.href=url;
}

function editar_producto(cod_producto){
	url = base_url+"almacen/producto/editar_producto/"+cod_producto;
	location.href=url;
}
function eliminar_producto(cod_producto){
	if(window.confirm("Esta seguro que desea eliminar?")){
		url = base_url+"almacen/producto/eliminar_producto/"+cod_producto;
		location.href=url;
	}
}