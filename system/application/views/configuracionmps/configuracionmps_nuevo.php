<html>
	<head>
		<!-- PARA JQUERY UI -->
		<link rel="stylesheet" href="<?php echo base_url();?>js/ui/include/jquery-ui-1.8.14.custom.css" type="text/css" />
		<link rel="stylesheet" href="<?php echo base_url();?>js/ui/jquery.ui.timepicker.css?v=0.3.1" type="text/css" />
		
		<script type="text/javascript" src="<?php echo base_url();?>js/ui/include/jquery-1.5.1.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>js/ui/include/jquery.ui.core.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>js/ui/include/jquery.ui.widget.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>js/ui/include/jquery.ui.tabs.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>js/ui/include/jquery.ui.position.min.js"></script>

		<script type="text/javascript" src="<?php echo base_url();?>js/ui/jquery.ui.timepicker.js?v=0.3.1"></script>
		<!-- PARA JQUERY UI -->
		<script type="text/javascript" src="<?php echo base_url();?>js/funciones.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>js/jquery.validate.js"></script>	
		<script type="text/javascript" src="<?php echo base_url();?>js/configuracionmps/configuracionmps.js"></script>
		
		<style type="text/css">
			/*ESTILO PARA QUE LOS NUMEROS DE LA HORA, NO SE MUESTREN GRANDES*/
			#ui-timepicker-div {
				font-size: 11px;
			}
		</style>
	</head>
	<body>
	<div id="pagina">
		<div id="zonaContenido">
			<div align="center">
			<div id="tituloForm" class="header"><?php echo $titulo;?></div>
			<div id="frmBusqueda">
			<form id="frmGrabarConfiguracionmps" name="frmGrabarCalendario" method="post" >
				<div style="margin-top:20px;" >
					<table class="fuente8" width="70%" cellspacing="0" cellpadding="4" border="0">
						<tr>
							<td><?= form_label('Hora del Proceso : ');?></td>
							<td>
								<?= form_input(array('name'=>'hora','id'=>'hora','value'=>$configuracionmps->hora,'maxlength'=>'8','class'=>'cajaMedia')); ?>
								<script type="text/javascript">
									$(document).ready(function() {
										$('#hora').timepicker({
											showLeadingZero: false
										});
									});
								</script>
							</td>
						</tr>
						<tr>
							<td><?= form_label('Selecci&oacute;n del SKU : ','seleccion');?></td>
							<td>
								<select name="seleccion" id="seleccion" class="comboMedio">
									<?php
									foreach($array_seleccion as $key=>$value){
										if($key == $configuracionmps->seleccion ){
											echo "<option value='".$key."' selected='selected'>".$value."</option>";
										}else{
											echo "<option value='".$key."'>".$value."</option>";
										}
									}
									?>
								</select>
							</td>
						</tr>
						<tr>
							<td><?= form_label('Fecha fin de Horizonte : ','horizonte');?></td>
							<td>
								<?= form_input(array('name'=>'horizonte','id'=>'horizonte','value'=>$configuracionmps->horizonte,'class'=>'cajaMedia')); ?>
								<script type="text/javascript">
									Calendar.setup({
										inputField     :    "horizonte",      // id del campo de texto
										ifFormat       :    "%d/%m/%Y",       // formato de la fecha, cuando se escriba en el campo de texto
										button         :    "horizonte"   // el id del botón que lanzará el calendario
									});
								</script>
							</td>
						</tr>
						<tr>
							<td><?= form_label('Escenario de Proceso : ','escenario');?></td>
							<td><?= $configuracionmps->escenario; ?></td>
						</tr>
					</table>
				</div>
				<div style="margin-top:20px;margin-bottom:15px;text-align: center">
					<a href="javascript:;" id="grabarConfiguracionmps"><img src="<?php echo base_url();?>images/botonaceptar.jpg" width="85" height="22" class="imgBoton" ></a>
                    <a href="javascript:;" id="cancelarConfiguracionmps"><img src="<?php echo base_url();?>images/botoncancelar.jpg" width="85" height="22" class="imgBoton"></a>
				</div>
				<table class="fuente8" width="100%" cellspacing="0" cellpadding="3" border="0" ID="Table1">
					<tr>
						<td>
							<div id="cargando" align="center"><img src="<?=base_url()?>images/cargando.gif" border='0' /></div>
							<div id="error" class="error" align="center"></div>
							<div id="success" class="mensaje_grabar" align="center"><img src="<?= base_url();?>images/icono_aprobar.png" width="18" height="15" border="0" title="OK" />Se modific&oacute; la configuraci&oacute;n de la programaci&oacute;n correctamente</div>
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