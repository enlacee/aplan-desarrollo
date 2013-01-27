<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo TITULO;?></title>
<link rel="stylesheet" href="<?php echo base_url();?>css/estilos.css" type="text/css">
<link rel="stylesheet" href="<?php echo base_url();?>css/theme.css" type="text/css">		
<script language="javaScript" src="<?php echo base_url();?>js/menu/JSCookMenu.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.validate.min.js"></script>
<link rel="icon" href="<?php echo base_url();?>favicon.ico" type="image/x-icon" />
<style type="text/css">
<!--
.texto {
	font-family: "Century Gothic";
	font-size: 11px;
	font-style: normal;
	font-weight: normal;
	color: #333;
	text-decoration: none;
}
a {
	font-family: "Century Gothic";
	font-size: 11px;
	color: #FFF;
	text-decoration: none;
}
a:hover {
	color: #000;
	text-decoration: none;
}
-->
</style>
</head>

<body onLoad="document.getElementById('txtUsuario').focus();">
<table width="943" border="0" align="center" cellpadding="0" cellspacing="0" background="<?php echo base_url();?>images/fondo_login.jpg">
  <!--DWLayoutTable-->
  <tr>
    <td width="1000" height="800"><table width="925" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="154">&nbsp;</td>
      </tr>
      <tr>
        <td height="193">
		<form id="frmLogin" method="post" action="<?php echo base_url().'index.php/index/ingresar_sistema';?>">
		<table width="429" height="204" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td width="36" height="35">&nbsp;</td>
            <td width="147">&nbsp;</td>
            <td width="168">&nbsp;</td>
            <td width="78">&nbsp;</td>
          </tr>
          <tr>
            <td height="33">&nbsp;</td>
            <td>&nbsp;</td>
            <td><label>
              <input name="txtUsuario" type="text" class="texto" id="txtUsuario" size="32" />
            </label></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><label>
              <input name="txtClave" type="password" class="texto" id="txtClave" size="32" />
            </label></td>
            <td>&nbsp;</td>
          </tr>
		  <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>
				<label><?php echo $valores[2];?></label>
			</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td height="19">&nbsp;</td>
            <td colspan="3" rowspan="2"><table width="393" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="111" height="10"></td>
                <td width="101" height="10"></td>
                <td width="9" height="10"></td>
                <td width="91" height="10"></td>
                <td width="81" height="10"></td>
              </tr>
              <tr>
                <td height="25"></td>
                <td height="25" align="right" valign="middle"><input name="ingresar" type="submit" class="texto" id="ingresar" value="Ingresar" /></td>
                <td height="25"></td>
                <td height="25" align="left" valign="middle"><input name="cancelar" type="reset" class="texto" id="cancelar" value="Limpiar" /></td>
                <td height="25"></td>
              </tr>
              <tr>
                <td height="10"></td>
                <td height="10"></td>
                <td height="10"></td>
                <td height="10"></td>
                <td height="10"></td>
              </tr>
            </table></td>
            </tr>
          <tr>
            <td height="35">&nbsp;</td>
            </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="3" valign="top"><table width="393" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="111">&nbsp;</td>
                <td width="202" align="right" valign="top"><a href="#">Olvido su contraseña? click Aquí</a></td>
                <td width="80">&nbsp;</td>
              </tr>
            </table></td>
            </tr>
        </table>
		</form>
		</td>
      </tr>
      <tr>
        <td height="246">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table></body>
</html>
