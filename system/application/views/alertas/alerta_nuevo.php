<script type="text/javascript" src="<?php echo base_url();?>js/jquery.metadata.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.validate.js"></script>	
<script type="text/javascript" src="<?php echo base_url();?>js/alertas/alerta.js"></script>	
<div id="pagina">
    <div id="zonaContenido">
        <div align="center">
			<div id="tituloForm" class="header"><?php echo $titulo;?></div>
            <div id="frmBusqueda">
                <?php echo validation_errors("<div class='error'>",'</div>');?>
                <form method="post" id="<?php echo $formulario;?>" action="<?php echo $base_url;?>"  >
						
				   <div id="datosGenerales">
                        <table class="fuente8" width="98%" cellspacing=0 cellpadding="6" border="0">
                            <?php
                            foreach($campos as $indice=>$valor){
                            ?>
                                <tr>
                                  <td width="16%"><?php echo $campos[$indice];?></td>
                                  <td colspan="3"><?php echo $valores[$indice]?></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </table>
                    </div>
                    <div style="margin-top:20px; text-align: center">
                        <a href="javascript:;" id="grabarAlerta"><img src="<?php echo base_url();?>images/botonaceptar.jpg" width="85" height="22" class="imgBoton" ></a>
                        <a href="javascript:;" id="cancelarAlerta"><img src="<?php echo base_url();?>images/botoncancelar.jpg" width="85" height="22" class="imgBoton"></a>
                    </div>
					<table class="fuente8" width="100%" cellspacing="0" cellpadding="3" border="0" ID="Table1">
						<tr>
							<td>
								<div id="cargando" align="center"><img src="<?=base_url()?>images/cargando.gif" border='0' /></div>
								<div id="error" class="error" align="center"></div>
							</td>
						</tr>
					</table>
					<input type="hidden" name="modo" id="modo" value="<?php echo $modo;?>">
					<input type="hidden" name="base_url" id="base_url" value="<?php echo $base_url;?>">
					<input type="hidden" name="id_codigo" id="id_codigo" value="<?php echo $codigo_id;?>">
				</form>
            </div>
        </div>
    </div>
</div>