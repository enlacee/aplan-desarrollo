<html>
	<head>
		<!-- PARA JQUERY UI -->
		<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
		<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
		<!-- PARA JQUERY UI -->
		<script type="text/javascript" src="<?php echo base_url();?>js/funciones.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>js/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>js/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
		
		<style>
			<?php
				foreach($lista as $key=>$value){
					echo '#draggable'.++$key.' { width: 80px; height: 80px; padding: 0.5em; }';
				}
			?>
			#draggable2 { width: 80px; height: 80px; padding: 0.5em; }
			#draggable3 { width: 80px; height: 80px; padding: 0.5em; }
			#draggable4 { width: 80px; height: 80px; padding: 0.5em; }
		</style>
		<script type="text/javascript">

            $(document).ready(function() {
				
				$(".ver_detalle_establecimiento").fancybox({
					'width'          : 300,
					'height'         : 200,
					'transitionIn'   : 'elastic',
					'transitionOut'  : 'elastic',
					'type'	     : 'iframe'
				});
				
            });
        </script>
		<script>
			$(function() {
				<?php
					foreach($lista as $key=>$value){
						echo '$( "#draggable'.++$key.'" ).draggable({ containment: "parent" });';
					}
				?>
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
			<form id="frmGrabarCompania" name="frmGrabarCompania" method="post" >
				<div style="margin-top:20px;height:550px;" >
					<?php
					foreach($lista as $key=>$value){
						?>
						<div id="draggable<?php echo ++$key; ?>" class="ui-widget-content">
							<a href="<?php echo base_url(); ?>maestros/establecimiento/ver_detalle_establecimiento/<?php echo $value->codigo; ?>" class="ver_detalle_establecimiento">
								<p><?php echo $value->descripcion;?></p>
							</a>
						</div>
						<?php
					}
					?>
				</div>
				<div style="margin-top:20px;margin-bottom:15px;text-align: center">
					<a href="javascript:;" id="grabarCompania"><img src="<?php echo base_url();?>images/botonaceptar.jpg" width="85" height="22" class="imgBoton" ></a>
                    <a href="javascript:;" id="cancelarCompania"><img src="<?php echo base_url();?>images/botoncancelar.jpg" width="85" height="22" class="imgBoton"></a>
				</div>
				<input type="hidden" name="base_url" id="base_url" value="<?php echo base_url();?>">
			</form>
			</div>
			</div>
		</div>
</div>
</body>
</html>