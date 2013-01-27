<script type="text/javascript" src="<?php echo base_url();?>js/jquery.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>css/estilos.css" type="text/css"/>
<script type="text/javascript" src="<?php echo base_url();?>js/seguridad/rol.js"></script>
<div id="paginaPopup">
    <div id="zonaContenidoPopup">
        <div align="center">
            <div id="tituloFormPopup" style="width:80%;"class="header"><?php echo $titulo." :: ".$codigo_interno." - ".$nombre;?></div>
			<div id="frmBusquedaPopup" style="width:80%;background:#FFF;">
                <form id="<?php echo $formulario;?>" method="post" action="<?php echo base_url();?>index.php/alertas/alerta/insertar_rol_activados">
					<table>
						<tr>
							<td><span class="fuente8" style="color:red;">Debe seleccionar alg&uacute;n rol para asignarlo a las alertas</span></td>
						<tr>
					</table>
					<table class="Table_Class" width="100%" cellspacing="0" cellpadding="3" border="0" id="Table1">
							<tr>
								<th width="50%">
									LISTADO DE ROLES
								</th>
								<th>
									ACCI&Oacute;N
								</th>
							</tr>
							<?php
							$check = "";	
							foreach($lista_rol as $indice=>$valor){
								foreach($lista_habilitados AS $clave=>$val){
									if($valor[0] ==$val[0] ){
										$check = "checked ='true'";
										break;
									}else{
										$check = "";	
									}
								}
							?>
							   <tr>
								  <td width="50%"><div align="center"><?php echo $valor[1];?>&nbsp;&nbsp;</div></td>
								  <td><div align="center"><input type="checkbox" <?=$check; ?> name="check_<?php echo $valor[0];?>"></div></td>
								</tr>
							<?php }?>
					</table>
                    <div style="margin-top:20px; text-align: center">
                        <a href="javascript:;" id="grabarRol"><img src="<?php echo base_url();?>images/botonaceptar.jpg" width="85" height="22" class="imgBoton" ></a>
                        <a href="javascript:;" onclick="javascript:parent.$.fancybox.close();"><img src="<?php echo base_url();?>images/botoncancelar.jpg" width="69" height="22" class="imgBoton" ></a>
						<!--<a href="javascript:;" onclick="cancelarRol_alerta()"><img src="<?php echo base_url();?>images/botoncancelar.jpg" width="85" height="22" class="imgBoton"></a>-->
                      <!--  <?php echo $oculto?>-->
                    </div>
					<input type="hidden" name="base_url" id="base_url" value="<?php echo base_url();?>">
					<input type="hidden" name="codigo_rol" id="codigo_rol" value="<?php echo $codigo_alerta;?>">
				</form>
            </div>
        </div>
    </div>
</div>