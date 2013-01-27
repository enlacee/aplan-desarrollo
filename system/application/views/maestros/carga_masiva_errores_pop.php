<html>
	<head>
		<link rel="stylesheet" href="<?php echo base_url();?>css/estilos.css" type="text/css"/>
	</head>
	<body>
	<div id="paginaPopup">
		<div id="zonaContenidoPopup">
			<div align="center">
				<div id="tituloFormPopup" class="header"><?php echo $titulo;?></div>
					<div id="frmBusquedaPopup">
						<table class="Table_Class" width="100%" cellspacing="0" cellpadding="3" border="0" id="Table1">
								<?php
								if(count($lista_log_demanda)){
									foreach($lista_log_demanda as $key=>$value){
									?>
								<tr>
									<td>
									<?php
										echo $value->TLOG_Detalle;
									?>
								</td>
									</tr>									
								<?php
									}
								}
								?>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	</body>
</html>