<html>
	<head>	
        <script type="text/javascript" src="<?php echo base_url();?>js/jquery.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>js/maestros/carga_masiva.js"></script>		
		<script type="text/javascript" src="<?php echo base_url();?>js/funciones.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>js/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>js/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
		<script type="text/javascript">

            $(document).ready(function() {
				
				$("a.log").fancybox({
					'width'          : 1000,
					'height'         : 500,
					'transitionIn'   : 'elastic',
					'transitionOut'  : 'elastic',
					'type'	     : 'iframe'
				});
				
            });
        </script>
	</head>
	<body>
<!-- Inicio -->
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
					<table class="fuente8" cellspacing="0" cellpadding="4" border="0">
						<tr>
							<td>SKU :</td>
							<td>10054</td>
						</tr>
						<tr>
							<td>DESCRIPCI&Oacute;N : </td>
							<td>Polo Manga Larga XXl/Negro</td>
						</tr>
						<tr>
							<td>STOCK INICIAL : </td>
							<td>800</td>
						</tr>
						<tr>
							<td>UBICACI&Oacute;N : </td>
							<td>TIENDA AV. JAVIER PRADO 148</td>
						</tr>
						<tr>
							<td colspan="2">TABLA :</td>
						</tr>
						<tr>
							<td colspan="2">
								<div align="center">
									<table class="Table_Class" cellspacing="0" cellpadding="4" border="1">
										<tr>
											<th></th>
											<th width="11%">SEM 1</th>
											<th width="11%">SEM 2</th>
											<th width="11%">SEM 3</th>
											<th width="11%">SEM 4</th>
											<th width="11%">SEM 5</th>
											<th width="11%">SEM 6</th>
										</tr>
										<tr>
											<td width="30%" style="background:none repeat scroll 0 0 #B9C9FE;"><div align="left">PRON&Oacute;STICO</div></td>
											<td>50</td>
											<td>40</td>
											<td>50</td>
											<td>80</td>
											<td>20</td>
											<td>40</td>
										</tr>
										<tr>
											<td style="background:none repeat scroll 0 0 #B9C9FE;"><div align="left">RECEPCI&Oacute;N PROGRAMADA</div></td>
											<td>20</td>
											<td>-</td>
											<td>20</td>
											<td>80</td>
											<td>20</td>
											<td>40</td>
										</tr>
										<tr>
											<td style="background:none repeat scroll 0 0 #B9C9FE;"><div align="left">CANTIDAD DISPONIBLE | <span style="font-weight:bold">110</span></div></td>
											<td>80</td>
											<td>40</td>
											<td>0</td>
											<td>0</td>
											<td>0</td>
											<td>0</td>
										</tr>
										<tr>
											<td style="background:none repeat scroll 0 0 #B9C9FE;"><div align="left">PLAN MAESTRO</div></td>
											<td></td>
											<td></td>
											<td>20</td>
											<td>80</td>
											<td>20</td>
											<td>40</td>
										</tr>
									</table>
								</div>
							</td>
						</tr>
						<tr>
							<td colspan="2">REPORTE GR&Aacute;FICO :</td>
						</tr>
						<tr>
							<td colspan="2"><div align="center"><?=$reporte; ?></div></td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
	</body>
</html>