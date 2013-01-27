<html>
	<head>
		<script type="text/javascript" src="<?php echo base_url();?>js/maestros/carga_masiva.js"></script>		
		<script type="text/javascript" src="<?php echo base_url();?>js/funciones.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>js/jquery.validate.js"></script>	
		<script type="text/javascript" src="<?php echo base_url();?>js/configuracionmps/plan.js"></script>
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
			<form id="frmGrabarPlan" name="frmGrabarPlan" method="post" action="<?php echo base_url(); ?>configuracionmps/configuracion/insertar_calendario" >
				<div style="margin-top:20px;" >
					<table class="fuente8" width="70%" cellspacing="0" cellpadding="4" border="0">
						<tr>
							<td><?= form_label('Codigo Interno : ');?></td>
							<td>
								<?= form_input(array('name'=>'codigointerno','id'=>'codigointerno','value'=>($modo == 'editar')?$plan->codigo:'','class'=>'cajaMedia')); ?>
							</td>
						</tr>
						<tr>
							<td><?= form_label('Nombre : ');?></td>
							<td>
								<?= form_input(array('name'=>'nombre','id'=>'nombre','value'=>($modo == 'editar')?$plan->nombre:'','class'=>'cajaGrande')); ?>
							</td>
						</tr>
						<tr>
							<?php
							if($modo == 'insertar'){
								if(!$esprincipal){
								?>
								<td><?= form_label('Tipo de Plan : ');?></td>
								<td>
									<select name="cboTipo" id="cboTipo" class="comboMedio">
										<option value="1">Principal</option>
										<option value="2">Secundario</option>
									</select>
								</td>
								<?php
								}else{
								?>
								<td><?= form_label('Tipo de Plan : ');?></td>
								<td>
									<select name="cboTipo" id="cboTipo" class="comboMedio">
										<option value="2">Secundario</option>
									</select>
								</td>
								<?php
								}
							}else if($modo == 'editar'){
								?>
								<td><?= form_label('Tipo de Plan : ');?></td>
								<td>
									<select name="cboTipo" id="cboTipo" class="comboMedio">
										<option value="1" <?= ($plan->esprincipal == '1')?'selected="selected"':''; ?> >Principal</option>
										<option value="2" <?= ($plan->esprincipal == '2')?'selected="selected"':''; ?> >Secundario</option>
									</select>
								</td>
								<?php
							}
							?>
						</tr>
					</table>
				</div>
				<div style="margin-top:20px;margin-bottom:15px;text-align: center">
					<a href="javascript:;" id="grabarPlan"><img src="<?php echo base_url();?>images/botonaceptar.jpg" width="85" height="22" class="imgBoton" ></a>
                    <a href="javascript:;" id="cancelarPlan"><img src="<?php echo base_url();?>images/botoncancelar.jpg" width="85" height="22" class="imgBoton"></a>
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