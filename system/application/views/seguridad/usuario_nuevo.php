<script type="text/javascript" src="<?php echo base_url();?>js/jquery.metadata.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.validate.js"></script>	
<script type="text/javascript" src="<?php echo base_url();?>js/seguridad/usuario.js"></script>	

<div id="pagina">
    <div id="zonaContenido">
        <div align="center">
            <div id="tituloForm" class="header"><?php echo $titulo;?></div>
            <div id="frmBusqueda">
                <?php echo validation_errors("<div class='error'>",'</div>');?>
                <form id="<?php echo $formulario;?>" method="post" action="<?php echo base_url();?>index.php/seguridad/usuario/insertar_usuario">
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
								<?php if($modo == "modificar"){ ?>
								<tr>
									<td width="16%">EMPRESA </td>
									<td colspan="3">
										<?php echo $empresa; ?>
									</td>
                                </tr>
								<?php } ?>
								<tr>
									<td width="16%">PLANES O ESCENARIOS </td>
									<td colspan="3">
										<div id="divCboEscenarios">
											<?php
												if( $modo == 'modificar'){ 
													echo $escenarios;
												}
											?>
										</div>
									</td>
                                </tr>
                        </table>
                    </div>
                    <div style="margin-top:20px; text-align: center">
                        <a href="#" id="grabarUsuario"><img src="<?php echo base_url();?>images/botonaceptar.jpg" width="85" height="22" class="imgBoton" ></a>
                        <a href="#" id="limpiarUsuario"><img src="<?php echo base_url();?>images/botonlimpiar.jpg" width="69" height="22" class="imgBoton" ></a>
                        <a href="#" id="cancelarUsuario"><img src="<?php echo base_url();?>images/botoncancelar.jpg" width="85" height="22" class="imgBoton"></a>
                        <?php echo $oculto?>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>