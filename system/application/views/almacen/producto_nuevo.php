<html>
	<head>
		<script type="text/javascript" src="<?php echo base_url();?>js/jquery.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>js/funciones.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>js/jquery.validate.js"></script>	
		<script type="text/javascript" src="<?php echo base_url();?>js/almacen/producto.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>js/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>js/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
		<script type="text/javascript">
			$(document).ready(function() {
				
				$("#seleccionar_familia").fancybox({
					'width'          : 300,
					'height'         : 300,
					'transitionIn'   : 'elastic',
					'transitionOut'  : 'elastic',
					'type'	     	 : 'iframe'
				});
				
            });
		</script>
	</head>
	<body>
	<div id="VentanaTransparente" style="display:none;">
	  <div class="overlay_absolute"></div>
	  <div id="cargador" style="z-index:2000">
		<table width="100%" height="100%" border="0" class="fuente8">
			<tr valign="middle">
				<td> Por Favor Espere    </td>
				<td><img src="<?php echo base_url();?>images/cargando.gif"  border="0" title="CARGANDO" /><a href="#" id="hider2"></a>	</td>
			</tr>
		</table>
	  </div>
	</div>
	<div id="pagina">
			<div id="zonaContenido">
				<div align="center">
				<div id="tituloForm" class="header"><?php echo $titulo;?></div>
				<div id="frmBusqueda">
				<form id="frmGrabarProducto" name="frmGrabarProducto" method="post" action="<?php echo base_url(); ?>almacen/producto/insertar_producto" >
					<div style="margin-top:20px;" >
						<div <?php echo($modo=='editar')?"id='".base_url()."configuracionmps/calendario/ver_ventana_editar_calendario/".$codigo."'":"";?> class="<?=($modo=='editar')?'ver_editar_calendario':''; ?>">
							<table class="fuente8" width="80%" cellspacing="0" cellpadding="4" border="0">
								<tr>
									<td>Familia :</td>
									<td>
										<input type="text" class="cajaMedia cajaSoloLectura" name="descripcion" id="descripcion" value="<?php echo($codigo!= "")?$descripcion:''; ?>" />
										<a id="seleccionar_familia" href="<?= base_url().'almacen/familia/seleccionar_familia'?>"><img src="<?= base_url(); ?>images/ver.png" /></a>
									</td>
									<td>C&oacute;digo :</td>
									<td><input type="text" class="cajaPequena" name="descripcion" id="descripcion" value="<?php echo($codigo!= "")?$descripcion:''; ?>" /></td>
								</tr>
								<tr>
									<td>Nombre :</td>
									<td>
										<input type="text" class="cajaMedia" name="fechainicio" id="fechainicio" value="<?php echo($codigo!= "")?$fecha_ini:''; ?>" />
									</td>
									<td>Tipo de Producto :</td>
									<td>
										<select class="comboMedio">
											<option value="0">.:Seleccione:.</option>
										</select>
									</td>
								</tr>
								<tr>
									<td>D&iacute;as para la zona 1 :</td>
									<td><input type="text" class="cajaPequena" /></td>
									<td>D&iacute;as para la zona 2 :</td>
									<td><input type="text" class="cajaPequena" /></td>
								</tr>
								<tr>
									<td>Tipo de Planificaci&oacute;n :</td>
									<td>
										<select class="comboMedio">
											<option value="0">.:Seleccione:.</option>
										</select>
									</td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Regla de Planificaci&oacute;n :</td>
									<td>
										<select class="comboMedio">
											<option value="0">.:Seleccione:.</option>
										</select>
									</td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Lote Econ&oacute;mico :</td>
									<td><input type="text" class="cajaPequena" /></td>
									<td>Punto de Reorden :</td>
									<td><input type="text" class="cajaPequena" /></td>
								</tr>
								<tr>
									<td>Stock de Seguridad :</td>
									<td><input type="text" class="cajaPequena" /></td>
									<td>Cantidad M&iacute;nima :</td>
									<td><input type="text" class="cajaPequena" /></td>
								</tr>
								<tr>
									<td>Cantidad M&aacute;xima :</td>
									<td><input type="text" class="cajaPequena" /></td>
									<td>Cantidad M&uacute;ltiplo :</td>
									<td><input type="text" class="cajaPequena" /></td>
								</tr>
								<tr>
									<td>Cantidad Fija :</td>
									<td><input type="text" class="cajaPequena" /></td>
									<td>Stock M&aacute;ximo :</td>
									<td><input type="text" class="cajaPequena" /></td>
								</tr>
								<tr>
									<td>Cantidad Producci&oacute;n diaria :</td>
									<td><input type="text" class="cajaPequena" /></td>
									<td>Stock Acutal :</td>
									<td><input type="text" class="cajaPequena" /></td>
								</tr>
								<tr>
									<td>Precio de Costo :</td>
									<td><input type="text" class="cajaPequena" /></td>
									<td>Precio de Venta :</td>
									<td><input type="text" class="cajaPequena" /></td>
								</tr>
							</table>
						</div>
					</div>
					<div style="margin-top:20px;margin-bottom:15px;text-align: center">
						<a href="javascript:;" id="grabarCalendario"><img src="<?php echo base_url();?>images/botonaceptar.jpg" width="85" height="22" class="imgBoton" ></a>
						<a href="javascript:;" id="cancelarCalendario"><img src="<?php echo base_url();?>images/botoncancelar.jpg" width="85" height="22" class="imgBoton"></a>
					</div>
					<table class="fuente8" width="100%" cellspacing="0" cellpadding="3" border="0" ID="Table1">
						<tr>
							<td>
								<div id="cargando" align="center"><img src="<?=base_url()?>images/cargando.gif" border='0' /></div>
								<div id="error" class="error" align="center"></div>
							</td>
						</tr>
					</table>
					<input type="hidden" name="base_url" id="base_url" value="<?php echo base_url();?>">
					<input type="hidden" name="modo" id="modo" value="<?php echo $modo; ?>">
					<input type="hidden" name="codigo" id="codigo" value="<?php echo $codigo; ?>">
				</form>
				</div>
				</div>
			</div>
	</div>
</body>
</html>