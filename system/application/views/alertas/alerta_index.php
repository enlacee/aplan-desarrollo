<html>
<head>	
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.validate.js"></script>	
<script type="text/javascript" src="<?php echo base_url();?>js/alertas/alerta.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/funciones.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>js/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
<script type="text/javascript">

	$(document).ready(function() {
		
		$("a#ver_roles").fancybox({
			'width'          : 600,
			'height'         : 400,
			'transitionIn'   : 'elastic',
			'transitionOut'  : 'elastic',
			'type'	     : 'iframe'
		});
		
	});
</script>
</head>
<body>
<div id="pagina">
<div id="zonaContenido">
    <div align="center">
    <div id="tituloForm" class="header"><?php echo $titulo_busqueda;?></div>
    <div id="frmBusqueda" >
        <form id="form_busquedaRol" name="form_busquedaRol" method="post" action="">
            <table class="fuente8" width="98%" cellspacing=0 cellpadding="5" border=0>
                <tr>
                    <td align='left' width="13%">Nombre Alerta</td>
                    <td align='left'><input id="txtNombre" name="txtNombre" type="text" class="cajaMedia" maxlength="100" value=""></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
            </table>
        </form>
    </div>
    <div id="botonBusqueda">
        <ul id="nuevoAlerta" class="lista_botones"><li id="nuevo">Nueva Alerta</li></ul>
        <ul id="limpiar" class="lista_botones"><li id="limpiar">Limpiar</li></ul>
        <ul id="buscarAlerta" class="lista_botones"><li id="buscar">Buscar</li></ul>
    </div>
    <div id="lineaResultado">
      <table class="fuente8" width="100%" cellspacing=0 cellpadding=3 border=0>
            <tr>
                <td width="50%" align="left">N de tipos de alertas encontrados:&nbsp;<?php echo $registros;?> </td>
                <td width="50%" align="right">&nbsp;</td>
            </tr>
      </table>
    </div>
    <div id="cabeceraResultado" class="header"><?php echo $titulo_tabla;;?></div>
    <div id="frmResultado">
        <table class="fuente8" width="100%" cellspacing="0" cellpadding="3" border="0" ID="Table1">
            <tr class="cabeceraTabla">
				<td width="5%">ITEM</td>
				<td width="10%">C&Oacute;DIGO</td>
				<td width="15%">NOMBRE</td>
                <td width="20%">DESCRIPCI&Oacute;N</td>
                <td width="3%">&nbsp;</td>
                <td width="3%">&nbsp;</td>
                <td width="3%">&nbsp;</td>
                <td width="3%">&nbsp;</td>
            </tr>
            <?php
            if(count($lista)>0){
                foreach($lista as $key=>$value){
                    $class = $key%2==0?'itemParTabla':'itemImparTabla';
                    ?>
                    <tr class="<?php echo $class;?>">
                        <td><div align="center"><?= $value[4]?></div></td>
						<td><div align="center"><?= $value[1]?></div></td>
                        <td><div align="left"><?= $value[2]?></div></td>
                        <td><div align="left"><?= $value[3]?></div></td>
                        <td><div align="center"><a id="ver_roles" name="ver_roles" class="ver_roles" href="<?= base_url(); ?>alertas/alerta/ver_alerta_rol_popup/<?= $value[0] ?>" ><img src="<?=base_url()?>images/cliente.png" width='16' height='16' border='0' title='Rol'></a></div></td>
						<td><div align="center"><a href="javascript:;" onclick="ver_alerta(<?= $value[0] ?>)"><img src="<?=base_url()?>images/ver.png" width='16' height='16' border='0' title='Ver'></a></div></td>
						<td><div align="center"><a href="javascript:;" onclick="editar_alerta(<?= $value[0]?>)"><img src="<?=base_url()?>images/modificar.png"  width='16' height='16' border='0' title='Modificar'></a></div></td>
                        <td><div align="center"><a href="javascript:;" onclick="eliminar_alerta(<?= $value[0] ?>)"><img src="<?=base_url()?>images/eliminar.png" width='16' height='16' border='0' title='Eliminar'></a></div></td>
                    </tr>
                    <?php
                }
            }else{
            ?>
            <table width="100%" cellspacing="0" cellpadding="3" border="0" class="fuente8">
                <tbody>
                    <tr>
                        <td width="100%" class="mensaje">No hay ning&uacute;n registro que cumpla con los criterios de b&uacute;squeda</td>
                    </tr>
                </tbody>
            </table>
            <?php
            }
            ?>
        </table>
		<table class="fuente8" width="100%" cellspacing="0" cellpadding="3" border="0" ID="Table1">
			<tr>
				<td><div align="center"><a href="<?= base_url(); ?>alertas/alerta/simulador_rol">SIMULADOR DE ALERTAS</a></div></td>
				<td>
					<div id="cargando" align="center"><img src="<?=base_url()?>images/cargando.gif" border='0' /></div>
					<div id="error" class="error" align="center">OCURRIO UN ERROR</div>
				</td>
			</tr>
		</table>
    </div>
    <div style="margin-top: 15px;"><?php echo $paginacion; ?></div>
    <input type="hidden" id="iniciopagina" name="iniciopagina">
    <input type="hidden" id="cadena_busqueda" name="cadena_busqueda">
    <input type="hidden" name="base_url" id="base_url" value="<?php echo base_url();?>">
</div>
</div>
</div>
</body>
</html>