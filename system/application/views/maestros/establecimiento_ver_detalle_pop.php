<html>
	<head>
		<link rel="stylesheet" href="<?php echo base_url();?>css/estilos.css" type="text/css"/>
	</head>
	<body>
	<div id="paginaPopup">
		<div id="zonaContenidoPopup">
			<div align="center">
				<div id="tituloFormPopup" class="header"><?php echo $titulo;?></div>
					<div id="frmBusquedaPopup" style="height:150px;">
						<table class="Table_Class" width="100%" cellspacing="0" cellpadding="3" border="0" id="Table1">
							<tr>
								<td>Codigo</td>
								<td><?= $establecimiento->codigo_interno;?></td>
							</tr>
							<tr>
								<td>Telefono</td>
								<td><?= $establecimiento->telefono;?></td>
							</tr>
							<tr>
								<td>Descripcion</td>
								<td><?= $establecimiento->descripcion;?></td>
							</tr>
							<tr>
								<td>Direccion</td>
								<td><?= $establecimiento->direccion;?></td>
							</tr>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	</body>
</html>