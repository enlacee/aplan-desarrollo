<?php

function convertir_meses($mes){
	switch($mes){
		case 1:
			return "ENERO";
			break;
		case 2:
			return "FEBRERO";
			break;
		case 3:
			return "MARZO";
			break;
		case 4:
			return "ABRIL";
			break;
		case 5:
			return "MAYO";
			break;
		case 6:
			return "JUNIO";
			break;
		case 7:
			return "JULIO";
			break;
		case 8:
			return "AGOSTO";
			break;
		case 9:
			return "SETIEMBRE";
			break;
		case 10:
			return "OCTUBRE";
			break;
		case 11:
			return "NOVIEMBRE";
			break;
		case 12:
			return "DICIEMBRE";
			break;
	}
}

?>
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
							<tr>
								<th colspan="13">
									<span style="font-size:14px;font-weight:bold;">PRODUCTO : <?php echo $producto['codigo']; ?> / <?php echo $producto['descripcion']; ?></span>
								</th>
							</tr>
							<tr>
								<th></th>
								<?php
								foreach($lista_meses as $value){
									foreach($value as $meses){
										echo "<th>".convertir_meses($meses->DDEM_Mes)."/".$meses->DDEM_Anio."</th>";
									}
								}
								?>
							</tr>
							<?php
							if(count($lista_periodos) > 0){
								foreach($lista_periodos as $value){
								?>
								<tr>
									<td><?php echo $value->PERI_Aux; ?></td>
									<?php
									foreach($lista_cantidad as $value){
										foreach($value as $cantidad){
											echo "<td align='center'>".$cantidad->DDEM_Cantidad."</td>";
										}
									}
									?>
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