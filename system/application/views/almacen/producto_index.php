<script type="text/javascript" src="<?php echo base_url();?>js/jquery.metadata.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/almacen/producto.js"></script>
<div id="pagina">
<div id="zonaContenido">
    <div align="center">
    <div id="tituloForm" class="header"><?php echo $titulo_busqueda;?></div>
    <div id="frmBusqueda" >
        <form id="form_busquedaRol" name="form_busquedaRol" method="post" action="">
            <table class="fuente8" width="98%" cellspacing=0 cellpadding="5" border=0>
                <tr>
                    <td align='left' width="13%">Nombre Producto</td>
                    <td align='left'><input id="txtNombre" name="txtNombre" type="text" class="cajaMedia" maxlength="100" value=""></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
            </table>
        </form>
    </div>
    <div id="botonBusqueda">
        <ul id="nuevoProducto" class="lista_botones"><li id="nuevo">Nuevo Producto</li></ul>
        <ul id="limpiar" class="lista_botones"><li id="limpiar">Limpiar</li></ul>
        <ul id="buscarProducto" class="lista_botones"><li id="buscar">Buscar</li></ul>
    </div>
    <div id="lineaResultado">
      <table class="fuente8" width="100%" cellspacing=0 cellpadding=3 border=0>
            <tr>
                <td width="50%" align="left">N de productos encontrados:&nbsp;<?php echo $registros;?> </td>
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
                <td width="30%">DESCRIPCI&Oacute;N</td>
                <td width="15%">TIPO DE PROD.</td>
				<td width="10%">TIPO DE PLAN.</td>
				<td width="10%">D&Iacute;AS ZONA 1</td>
				<td width="10%">D&Iacute;AS ZONA 2</td>
				<td width="10%">REGLA DE PLANIFICACI&Oacute;N</td>
                <td width="5%">&nbsp;</td>
                <td width="5%">&nbsp;</td>
            </tr>
            <?php
            if(count($lista)>0){
                foreach($lista as $key=>$value){
                    $class = $key%2==0?'itemParTabla':'itemImparTabla';
					$tipo_producto = $value[3];
					switch($tipo_producto){
						case 1:
							$tipo_producto = 'FABRICADO';
							break;
						case 2:
							$tipo_producto = 'COMPRADO';
							break;
					}
					$tipo_planificacion = $value[4];
					switch($tipo_planificacion){
						case 1:
							$tipo_planificacion = 'PRO. MAESTRA';
							break;
						case 2:
							$tipo_planificacion = 'PTO. REORDEN';
							break;
					}
					$regla_planificacion = $value[7];
					switch($regla_planificacion){
						case 1:
							$regla_planificacion = 'LOTE X LOTE';
							break;
						case 2:
							$regla_planificacion = 'LOTE ECON&Oacute;.';
							break;
						case 3:
							$regla_planificacion = 'CANTIDAD M&Iacute;N.';
							break;
						case 4:
							$regla_planificacion = 'CANTIDAD FIJA';
							break;
						case 5:
							$regla_planificacion = 'STOCK M&Aacute;X.';
							break;
					}
                    ?>
                    <tr class="<?php echo $class;?>">
                        <td><div align="center"><?= $value[0]?></div></td>
                        <td><div align="center"><?= $value[8]?></div></td>
                        <td><div align="left"><?= $value[2]?></div></td>
                        <td><div align="center"><?= $tipo_producto?></div></td>
                        <td><div align="center"><?= $tipo_planificacion?></div></td>
						<td><div align="center"><?= $value[5]?></div></td>
						<td><div align="center"><?= $value[6]?></div></td>
						<td><div align="center"><?= $regla_planificacion?></div></td>
                        <td><div align="center"><a href="javascript:;" onclick="editar_producto(<?= $value[1] ?>)"><img src="<?=base_url()?>images/modificar.png" width='16' height='16' border='0' title='Modificar'></a></div></td>
                        <td><div align="center"><a href="javascript:;" onclick="eliminar_producto(<?= $value[1] ?>)"><img src="<?=base_url()?>images/eliminar.png" width='16' height='16' border='0' title='Modificar'></a></div></td>
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