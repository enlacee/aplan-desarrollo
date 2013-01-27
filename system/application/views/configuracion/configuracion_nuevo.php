<?php
//    echo '<pre>';
//    print_r( $_SESSION );
//    print_r( $_REQUEST );
//    echo '</pre>';
?>

<html>
    <head>
    <script type="text/javascript" src="<?php echo base_url();?>js/funciones.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>js/jquery.validate.js"></script>	
    <script type="text/javascript" src="<?php echo base_url();?>js/configuracion/configuracion.js"></script>
</head>
<body>
    <div id="pagina">
        <div id="zonaContenido">
            <div align="center">
                <div id="tituloForm" class="header"><?php echo $titulo;?></div>
                    <div id="frmBusqueda">
                        
                        <form id="frmGrabarConfiguracion" name="frmGrabarConfiguracion" method="post" >
                            <div style="margin-top:20px;" >
                                <table class="fuente8" width="40%" cellspacing="0" cellpadding="4" border="0">
                                    <tr>
                                        <td><?= form_label( 'Cantidad de decimales : ', 'decimales' ) ?></td>
                                        <td><?= form_input( array('name'=>'decimales','id'=>'decimales',
                                                                  'value'=>$configuracion->decimales,
                                                                  'class'=>'cajaPequena') ) ?></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <?= form_label( 'Desea compartir calendarios : ', 'calendario' ) ?></td>
                                        <td>
                                            <?php
                                                $chk = ($configuracion->calendario == '1')?'checked':'';
                                            ?>
                                            <input type="checkbox" name="calendario" id="calendario" <?=$chk?> />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><?= form_label('Desea compartir mensajes : ','mensajes') ?></td>
                                        <td>
                                            <?php $chk = ( $configuracion->mensajes == '1' ) ? 'checked' : '' ?>
                                            <input type="checkbox" name="mensajes" id="mensajes" <?=$chk;?> />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><?= form_label( 'Desea compartir MPS : ', 'programacion' ) ?></td>
                                        <td>
                                            <?php $chk = ( $configuracion->programacion == '1' ) ? 'checked' : '' ?>
                                            <input type="checkbox" name="programacion" id="programacion" <?=$chk;?> />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><?= form_label( 'Permitir stock negativo en la planificación : ', 'negativo' ) ?></td>
                                        <td>
                                            <?php $chk = ( $configuracion->negativo == '1' ) ? 'checked' : '' ?>
                                            <input type="checkbox" name="negativo" id="negativo" <?=$chk;?> />
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            
                            <div style="margin-top:20px;margin-bottom:15px;text-align: center">
                                <a href="javascript:;" id="grabarConfiguracion">
                                    <img src="<?php echo base_url() ?>images/botonaceptar.jpg" width="85" 
                                         height="22" class="imgBoton" />
                                </a>
                                <a href="javascript:;" id="cancelarConfiguracion">
                                    <img src="<?php echo base_url() ?>images/botoncancelar.jpg" width="85" 
                                         height="22" class="imgBoton" />
                                </a>
                            </div>
                            
                            <table class="fuente8" width="100%" cellspacing="0" cellpadding="3" border="0" 
                                   ID="Table1">
                                <tr>
                                    <td>
                                        <div id="cargando" align="center"><img src="<?=base_url()?>images/cargando.gif" border='0' /></div>
                                        <div id="error" class="error" align="center"></div>
                                        <div id="success" class="mensaje_grabar" align="center">
                                            <img src="<?= base_url()?>images/icono_aprobar.png" width="18" 
                                                 height="15" border="0" title="OK" />Se modific&oacute; la configuraci&oacute;n de la programaci&oacute;n correctamente
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            
                            <input type="hidden" name="base_url" id="base_url" value="<?php echo base_url() ?>" />
                            <input type="hidden" name="modo" id="modo" value="<?php echo $modo ?>" />
                            <input type="hidden" name="codigo" id="codigo" value="<?php echo $codigo ?>" />
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
