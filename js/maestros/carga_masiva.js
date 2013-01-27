var base_url;
jQuery(document).ready(function(){
	base_url   = $("#base_url").val();
	$("#cargarArchivos").click(function(){
		$("#frmCargarArchivos").submit();
	}); 
});