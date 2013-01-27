function numbersonly(myfield, e, dec)
{
	var key;
	var keychar;
	if (window.event)
		key = window.event.keyCode;
	else if (e)
		key = e.which;
	else
		return true;
	keychar = String.fromCharCode(key);
	// control keys
	//if ((key==13) )
			//alert("aaaaaaaa");

	if ((key==null) || (key==0) || (key==8) || (key==9) || (key==13) || (key==27) )
		return true;
	// numbers
	if (dec && (keychar == "." || keychar == "," || keychar == "-"))
	{
		var temp=""+myfield.value;
		if(temp.indexOf(keychar) > -1)
			return false;
	}
	else if ((("0123456789").indexOf(keychar) > -1))
		return true;
	// decimal point jump
	else
	return false;
}

function textoonly(myfield, e)
{
	var key;
	var keychar;
	if (window.event)
		key = window.event.keyCode;
	else if (e)
		key = e.which;
	else
		return true;
	keychar = String.fromCharCode(key);
	// control keys
	//if ((key==13) )
			//alert("aaaaaaaa");

	/*if ((key==null) || (key==0) || (key==8) || (key==9) || (key==13) || (key==27) )
		return true;
	// numbers
	if ((("ABCDEFGHIJKLMN?OPQRSTUVWXYZabcdefghijklmn?opqrstuvwxyz ").indexOf(keychar) > -1))
		return true;
	// decimal point jump
	else
	return false; */

	if ((key==null) || (key==0) || (key==8) || (key==9) || (key==13) || (key==27) ){
		return true;
	}
	else if (("1234567890".indexOf(keychar) == -1)){
		//alert("validando letras");
		return true;
	}
	else{
		return false;
	}
}
function ventana_producto_serie0(indice){
    producto = "prodcodigo["+indice+"]"
    prod = document.getElementById(producto).value;
    almacen_id = document.getElementById("almacen_id").value;
    url  = base_url+"index.php/almacen/producto/ventana_producto_serie0/"+prod+"/"+almacen_id;
    window.open(url,"_blank","width=600,height=400,scrollbars=yes,status=yes,resizable=yes,screenx=0,screeny=0'");
}
function ventana_producto_serie(indice){
    producto = "prodcodigo["+indice+"]"
    cantidad = "prodcantidad["+indice+"]";
    prod = document.getElementById(producto).value;
    cant = document.getElementById(cantidad).value;
    url  = base_url+"index.php/almacen/producto/ventana_producto_serie/"+prod+"/"+cant;
    window.open(url,"_blank","width=600,height=400,scrollbars=yes,status=yes,resizable=yes,screenx=0,screeny=0'");
}
function ventana_producto_serie2(indice){
    producto = "prodcodigo["+indice+"]"
    cantidad = "prodcantidad["+indice+"]";
    almacen  = document.getElementById("almacen").value;
    prod = document.getElementById(producto).value;
    cant = document.getElementById(cantidad).value;
    url  = base_url+"index.php/almacen/producto/ventana_producto_serie2/"+prod+"/"+cant+"/"+almacen;
    window.open(url,"_blank","width=600,height=400,scrollbars=yes,status=yes,resizable=yes,screenx=0,screeny=0'");
}
//Para dar formato a la moneda (2 decimales)
function money_format(amount) {
      /*var val = parseFloat(amount);
      if (isNaN(val)) { return "0.00"; }
      if (val <= 0) { return "0.00"; }
      val += "";
      // Next two lines remove anything beyond 2 decimal places
      if (val.indexOf('.') == -1) { return val+".00"; }
      else { val = val.substring(0,val.indexOf('.')+3); }
      val = (val == Math.floor(val)) ? val + '.00' : ((val*10 ==
      Math.floor(val*10)) ? val + '0' : val);
      return val;*/
      
      var original=parseFloat(amount);
      var result=Math.round(original*10000)/10000 ;
      return result;
      //return amount;
}
function limpiar_combobox(combobox){
    select   = document.getElementById(combobox);
    options = select.getElementsByTagName("option"); 
    var num_option=options.length;
    for(i=1;i<=num_option;i++){
        select.remove(0)
     }
    opt = document.createElement("option");
    texto = document.createTextNode(":: Seleccione ::");
    opt.appendChild(texto);
    opt.value = "";
    select.appendChild(opt);
}
function cambiar_sesion(){
    var compania = $("#cboCompania").val();
    var base_url   = $("#base_url").val();
    if(compania != ''){
		var dataString  = "compania="+compania;
		var url = base_url+"maestros/configuracion/cambiar_sesion";
		$.post(url,dataString,function(data){
			if(data != 0){
				window.location.reload();
			}else{
				alert('Error al cambiar la sesion');
			}
		});			
    }
}