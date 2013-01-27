<script type="text/javascript" src="<?php echo base_url();?>js/jquery.metadata.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.validate.js"></script>	
<script type="text/javascript" src="<?php echo base_url();?>js/alertas/alerta.js"></script>		

<div id="pagina">
    <div id="zonaContenido">
        <div align="center">
            <div id="tituloForm" class="header"><?php echo $titulo;?></div>
            <div id="frmBusqueda">
                <table class="fuente8" width="98%" cellspacing="0" cellpadding="3" border="0">
                    <tr>
                        <td width="15%">CODIGO ALERTA</td>
                        <td width="85%" colspan="2"><?php echo $codigo_interno;?></td>
                    </tr>
                    <tr>
                        <td width="15%">NOMBRE ALERTA</td>
                        <td width="85%" colspan="2"><?php echo $nombre;?></td>
                        <?php echo $oculto;?>
                    </tr>
                    <tr>
                        <td width="15%">DESCRIPCION </td>
                        <td width="85%" colspan="2"><?php echo $observacion;?></td>
                        <?php echo $oculto;?>
                    </tr>
					<tr>
                        <td width="15%">FECHA REGISTRO</td>
                        <td width="85%" colspan="2"><?php echo $fecha_registro;?></td>
                    </tr>
                    
                </table>
            </div>
        <div id="botonBusqueda">
        <a href="#" id="cancelarAlerta"><img src="<?php echo base_url();?>images/botonaceptar.jpg" width="85" height="22" border="1"></a>
      </div>
    </div>
</div>
</div>