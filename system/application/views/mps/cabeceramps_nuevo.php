<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.metadata.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/mps/cabeceramps.js"></script>

<div id="pagina">
    <div id="zonaContenido">
        <div align="center">
            
            <div id="tituloForm" class="header"><?php echo $titulo;?></div>
            
            <div id="frmBusqueda">
                
                <?php echo validation_errors("<div class='error'>",'</div>') ?>
                
                <form method="post" id="frmGrabarCabeceraMps" name="frmGrabarCabeceraMps" 
                      action="<?= base_url() ?>mps/tablamps/insertar_tablamps" >
						
                    <div id="datosGenerales">
                        <table class="fuente8" width="98%" cellspacing=0 cellpadding="6" border="0">
                            <?php
                                foreach( $campos as $indice=>$valor ) {
                            ?>
                                    <tr>
                                        <td width="16%"><?php echo $campos[$indice] ?></td>
                                        <td colspan="3"><?php echo $valores[$indice] ?></td>
                                    </tr>
                            <?php
                                }
                            ?>
                            <tr>
                                <td> CALENDARIO : </td>
                                <td>
                                    <?php echo $cboCalendario ?>
				</td>
                            </tr>
                            <tr>
                                <td> SKU : </td>
                                <td>
                                    <select name="cboProducto" id="cboProducto" class="comboGrande">
                                    <?php
                                        if ( count($lista_productos) > 0 ) {
                                            foreach( $lista_productos as $value ) {
                                    ?>
                                                <option value="<?=$value[0]?>"><?=$value[1]?></option>
                                    <?php
                                            } // fin del foreach
                                        } // fin del if
                                    ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td> UBICACI&Oacute;N : </td>
                                <td>
                                    <select name="cboUbicacion" id="cboUbicacion" class="comboGrande">
                                    <?php
                                        if ( count($lista_establecimientos) > 0 ) {
                                            foreach( $lista_establecimientos as $value ) {
                                    ?>
                                                <option value="<?=$value[0]?>"><?=$value[1];?></option>
                                    <?php
                                            } // fin del foreach
                                        } // fin del if
                                    ?>
                                    </select>
                                </td>
                            </tr>
                        </table>
                    </div>
                    
                    <?php
                        if ( $modo == 'editar') {
                    ?>
                            <table class="fuente8" width="98%" cellspacing=0 cellpadding="6" border="0">      
                                <tr>
                                    <td colspan="2"> DETALLE DE LA TABLA MPS </td>
                                </tr>
                                <tr>
                                    <td width="16%"> D&Iacute;AS </td>
                                    <td colspan="3"> PRON&Oacute;STICO </td>
                                </tr>
                    <?php
                            foreach ( $lista_detalle as $indice=>$valor ) {
                    ?>
                                <tr>
                                    <td width="16%"><?php echo $valor[0] ?></td>
                                    <td colspan="3"><?php echo $valor[1] ?></td>
                                </tr>
                    <?php
                            }
                    ?>
                            </table>
                    <?php 
                        }
                    ?>
					
                    <div style="margin-top:20px; text-align: center">
                        <a href="javascript:;" id="grabarCabecera">
                            <img src="<?php echo base_url() ?>images/botonaceptar.jpg" width="85" 
                                 height="22" class="imgBoton" />
                        </a>
                        <a href="javascript:;" id="limpiar">
                            <img src="<?php echo base_url() ?>images/botonlimpiar.jpg" width="69" 
                                 height="22" class="imgBoton" />
                        </a>
                        <a href="javascript:;" id="cancelarCabecera">
                            <img src="<?php echo base_url() ?>images/botoncancelar.jpg" width="85" 
                                 height="22" class="imgBoton" />
                        </a>
                    </div>
                    
                    <input type="hidden" name="codigo" id="codigo" value="<?php echo $codigo ?>">
                    <input type="hidden" name="modo" id="modo" value="<?php echo $modo ?>">
                    <input type="hidden" name="base_url" id="base_url" value="<?php echo base_url() ?>">
                    
                </form>
                
            </div>
            
        </div>
    </div>
</div>
