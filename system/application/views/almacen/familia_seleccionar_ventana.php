<html>
	<head>
		<link rel="stylesheet" href="<?php echo base_url();?>css/estilos.css" type="text/css"/>
	</head>
	<body>
	<div id="paginaPopup">
		<div id="zonaContenidoPopup">
			<div align="center" >
				<div id="tituloFormPopup" class="header"><?php echo $titulo;?></div>
					<div id="frmBusquedaPopup" style="height: 200px; overflow: auto; background-color: #f5f5f5">
						<form name="frmSeleccionarFamilia" id="frmSeleccionarFamilia" action="" method="post">
							<tr>
								<td>
									<select name="cboFamilia" id="cboFamilia" class="comboMedio">
										<?php foreach($familias as $value){ ?>
											<option value="<?= $value[0]; ?>"><?= $value[1]; ?></option>
										<?php } ?>
									</select>
								</td>
							</tr>
						</form>
						<div style="margin-top:20px;margin-bottom:15px;text-align: center">
							<a href="javascript:;" id="grabarCalendario"><img src="<?php echo base_url();?>images/botonaceptar.jpg" width="85" height="22" class="imgBoton" ></a>
							<a href="javascript:;" id="cancelarCalendario"><img src="<?php echo base_url();?>images/botoncancelar.jpg" width="85" height="22" class="imgBoton"></a>
						</div>
					</div>
			</div>
		</div>
	</div>
	</body>
</html>