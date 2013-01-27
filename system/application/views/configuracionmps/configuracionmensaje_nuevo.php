<html>
	<head>
		<script type="text/javascript" src="<?php echo base_url();?>js/funciones.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>js/jquery.validate.js"></script>	
		<script type="text/javascript" src="<?php echo base_url();?>js/configuracionmps/configuracionmensaje.js"></script>
		
	</head>
	<body>
	<div id="pagina">
		<div id="zonaContenido">
			<div align="center">
			<div id="tituloForm" class="header"><?php echo $titulo;?></div>
			<div id="frmBusqueda">
			<form id="frmGrabarConfiguracionmensaje" name="frmGrabarCalendario" method="post" >
				<div style="margin-top:20px;" >
					<table class="fuente8" width="40%" cellspacing="0" cellpadding="4" border="0">
						<tr>
							<td><?= form_label('Stock negativo : ','negativo');?></td>
							<td>
								<?php
								$chk = ($configuracionmensaje->stock_negativo == '1')?'checked':'';
								?>
								<input type="checkbox" name="stock_negativo" id="stock_negativo" <?=$chk;?> />
							</td>
						</tr>
						<tr>
							<td><?= form_label('Posible Rotura de Stock : ','posible_rotura');?></td>
							<td>
								<?= form_input(array('name'=>'posible_rotura','id'=>'posible_rotura','value'=>$configuracionmensaje->posible_rotura,'class'=>'cajaPequena')); ?>
								<span style="font-weight:bold;font-size:15px;">%</span>
							</td>
						</tr>
						<tr>
							<td><?= form_label('Inventario por debajo del Stock de Seguridad : ','inventa_debajo');?></td>
							<td>
								<?= form_input(array('name'=>'inventa_debajo','id'=>'inventa_debajo','value'=>$configuracionmensaje->inventa_debajo,'class'=>'cajaPequena')); ?>
								<span style="font-weight:bold;font-size:15px;">%</span>
							</td>
						</tr>
						<tr>
							<td><?= form_label('Dias para Lanzamiento tarde : ','lantarde');?></td>
							<td>
								<?= form_input(array('name'=>'lantarde','id'=>'lantarde','value'=>$configuracionmensaje->lantarde,'class'=>'cajaPequena')); ?>
								<span style="font-weight:bold;font-size:15px;">d&iacute;as</span>
							</td>
						</tr>
					</table>
				</div>
				<div style="margin-top:20px;margin-bottom:15px;text-align: center">
					<a href="javascript:;" id="grabarConfiguracionmensaje"><img src="<?php echo base_url();?>images/botonaceptar.jpg" width="85" height="22" class="imgBoton" ></a>
                    <a href="javascript:;" id="cancelarConfiguracionmensaje"><img src="<?php echo base_url();?>images/botoncancelar.jpg" width="85" height="22" class="imgBoton"></a>
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