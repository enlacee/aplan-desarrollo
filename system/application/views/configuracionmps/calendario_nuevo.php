<html>
	<head>
		<script type="text/javascript" src="<?php echo base_url();?>js/funciones.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>js/jquery.validate.js"></script>	
		<script type="text/javascript" src="<?php echo base_url();?>js/configuracionmps/calendario.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>js/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>js/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
		<style type="text/css">
			.calendarionumerosseleccion {
				padding: 2px 0px 2px 0px;
				font-family: Arial, sans-serif, Helvetica;
				font-size: 11px;
				background-color:#868686;
				border: solid 1px #868686;
				text-align:center;
			}
			
			.feriados{color:#666666;background-color:#DDDCDC;}
		</style>
		<script type="text/javascript">
			$(document).ready(function() {
			
				$("div.ver_editar_calendario").click(function(){
					var href = this.id;
					$.fancybox({
						'width'          : 950,
						'height'         : 650,
						'transitionIn'   : 'elastic',
						'transitionOut'  : 'elastic',
						'type'	     	 : 'iframe',
						'href'			 : href
					});
				});
				
			});
			
			function actualiza_pagina(){
				window.location.reload();
			}
			
		</script>
		<?php
		function mostrar_mes_completo($mes){
			switch($mes){
				case '01': $nombre = 'Enero'; break;
				case '02': $nombre = 'Febrero'; break;
				case '03': $nombre = 'Marzo'; break;
				case '04': $nombre = 'Abril'; break;
				case '05': $nombre = 'Mayo'; break;
				case '06': $nombre = 'Junio'; break;
				case '07': $nombre = 'Julio'; break;
				case '08': $nombre = 'Agosto'; break;
				case '09': $nombre = 'Septiembre'; break;
				case '10': $nombre = 'Octubre'; break;
				case '11': $nombre = 'Noviembre'; break;
				case '12': $nombre = 'Diciembre'; break;
			}
			return strtoupper($nombre);
		}
		?>
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
				<form id="frmGrabarCalendario" name="frmGrabarCalendario" method="post" action="<?php echo base_url(); ?>configuracionmps/configuracion/insertar_calendario" >
					<div style="margin-top:20px;" >
						<div <?php echo($modo=='editar')?"id='".base_url()."configuracionmps/calendario/ver_ventana_editar_calendario/".$codigo."'":"";?> class="<?=($modo=='editar')?'ver_editar_calendario':''; ?>">
							<table class="fuente8" width="70%" cellspacing="0" cellpadding="4" border="0">
								<tr>
									<td>Descripcion :</td>
									<td colspan="3"><input type="text" class="cajaGrande" name="descripcion" id="descripcion" value="<?php echo($codigo!= "")?$descripcion:''; ?>" /></td>
								</tr>
								<tr>
									<td>Fecha de Inicio:</td>
									<td>
										<input type="text" class="cajaMedia" name="fechainicio" id="fechainicio" value="<?php echo($codigo!= "")?$fecha_ini:''; ?>" />
										<script type="text/javascript">
											Calendar.setup({
												inputField     :    "fechainicio",      // id del campo de texto
												ifFormat       :    "%d/%m/%Y",       // formato de la fecha, cuando se escriba en el campo de texto
												button         :    "fechainicio"   // el id del botón que lanzará el calendario
											});
										</script>
									</td>
									<td>Fecha de Fin:</td>
									<td>
										<input type="text" class="cajaMedia" name="fechafin" id="fechafin" value="<?php echo($codigo!= "")?$fecha_fin:''; ?>" />
										<script type="text/javascript">
											Calendar.setup({
												inputField     :    "fechafin",      // id del campo de texto
												ifFormat       :    "%d/%m/%Y",       // formato de la fecha, cuando se escriba en el campo de texto
												button         :    "fechafin"   // el id del botón que lanzará el calendario
											});
										</script>
									</td>
								</tr>
								<tr>
									<td><div align="center"><input id="id_editar_siete" <?php if($modo == 'editar') {if($flag_codigo == 0 ){echo 'checked = "TRUE"';}else{echo '';}}else{echo 'checked = "TRUE"';}?> type="checkbox"  name="checkedd[0]"></div></td>
									<td>siete d&iacute;as</td>
								</tr>
								<tr>
									<td><div align="center"><input id="id_editar_seis" <?php if($modo == 'editar') {if($flag_codigo == 1 ){echo 'checked = "TRUE"';}else{echo '';}}?> type="checkbox"  name="checkedd[1]"></div></td>
									<td>seis d&iacute;as</td>
								</tr>
								<tr>
									<td><div align="center"><input id="id_editar_cinco" <?php if($modo == 'editar') {if($flag_codigo == 2 ){echo 'checked = "TRUE"';}else{echo '';}}?> type="checkbox"  name="checkedd[2]"></div></td>
									<td>cinco d&iacute;as</td>
								</tr>
							</table>
						</div>
					</div>
					<div style="margin-top:20px;">
						<span style="color:red;"><?php echo($codigo != "")?'':'PARA CONFIGURAR EL(LOS) CALENDARIO(S), SELECCIONE ACEPTAR'; ?><span>
					</div>
					<div name="calendario" id="calendario" style="width: 800px;padding:10px 0 20px 30px;" >
						<?php
						if($modo == "editar"){
							echo $calendario;
						}
						?>
						<div style="clear:both;"></div>
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