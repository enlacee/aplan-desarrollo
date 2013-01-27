<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/mps/cabeceramps.js"></script>
<link rel="stylesheet" href="<?php echo base_url() ?>css/estilos.css" type="text/css"/>

<style type="text/css">
    /* estilos para el tooltip */
    .tooltip{ display:inline; position:relative; }
    .tooltip:hover{ text-decoration:none }
    .medida:hover:after {
        width : 300px;
        white-space : pre-wrap !important;
    }
    .tooltip:hover:after {
        background : #111;   
        color : #003399;
        font-size : 11px;
        font-weight : normal;
        background : rgba( 0, 0, 0, .8 );
        border-radius : 5px;
        bottom : 18px;
        color : #fff;
        content : attr( title );
        display : block;
        left : 50%;
        padding : 5px 5px;
        position : absolute;
        white-space : nowrap;
        z-index : 98
    }
    .tooltip:hover:before {
        border : solid;
        border-color : #111 transparent;
        border-width : 6px 6px 0 6px;
        bottom : 12px;
        content : "";
        display : block;
        left : 75%;
        position : absolute;
        z-index : 99
    }
    #Table1 a {
        color : #003399 !important;
        font-size : 11px;
        font-weight : normal;
    }
    #Table1 a:hover {
        color : #003399;
        font-size : 11px;
        font-weight : normal;
    }
    
    /* estilos para el inbox */
    .content_div {
        width : 450px;
        font-family : Verdana, Geneva, sans-serif;
        font-size : 11px !important;
    }
    .content_div td {
        color : #333;
        text-align : center;
        padding : 0 5px;
        font-size : 11px !important;
    }
    .content_div td a {
        color : #00618F;
        font-size : 11px !important;
    }
    .margin-right {
        margin-right : 20px;
    }
    .left {
        float : left;
    }
    .clear {
        clear:both;
    }
    .cabecera_table {
        background : #9B9488;
        height : 16px;
    }
    .css_cabectabla {
        border-right : 1px solid #FFFFFF;
        color : #FFFFFF !important;
        font-weight : normal;
        padding : 1px;
        text-align : center;
    }
    .table_par {
        background:#F4F2EA;
    }
    .table_impar {
        background:#E5E3D9;
    }
</style>

<div id="pagina">
    <div id="zonaContenido">
        <div align="center">
            
            <div id="tituloForm" class="header"><?= $titulo ?></div>
            
            <div id="frmBusqueda">
                <table class="fuente8" cellspacing="0" cellpadding="3" border="0" width="70%" >
                    <tr>
                        <td colspan="5">
                            <div align="center">
                                <img src="<?php echo base_url() ?>images/img_db/producto_1.jpg" width="160px" 
                                     height="160px" border="0" />
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="font-weight:bold;" width="20%"> UBICACI&Oacute;N : </td>
                        <td width="40%" colspan="3"><?=$ubicacion?></td>
                    </tr>
                    <tr>
                        <td style="font-weight:bold;" width="20%"> C&Oacute;DIGO : </td>
                        <td width="40%"><?=$cod_producto?></td>
                        <td width="10%">&nbsp;</td>
                        <td width="10%">
                            <div align="right">
                                <a href="javascript:;" id="" onclick="ver_pedidos(<?=$codigo_cabecera?>)">
                                    <img src="<?php echo base_url();?>images/btnverpedidos.png" width="85" 
                                         height="22" class="imgBoton" />
                                </a>
                            </div>
                        </td>
                        <td> <span class="cantidad">(5)</span> </td>
                    </tr>
                    <tr>
                        <td style="font-weight:bold;"> DESCRIPCI&Oacute;N : </td>
                        <td><?=$des_producto?></td>
                        <td>&nbsp;</td>
                        <td width="40%">
                            <div align="right">
                                <a href="javascript:;" id="" onclick="ver_ordenesc(<?=$codigo_cabecera?>)">
                                    <img src="<?php echo base_url();?>images/btnveroc.png" width="85" 
                                         height="22" class="imgBoton" />
                                </a>
                            </div>
                        </td>
                        <td> <span class="cantidad">(8)</span> </td>
                    </tr>
                    <tr>
                        <td style="font-weight:bold;"> CANTIDAD M&Iacute;NIMA : </td>
                        <td><?=$can_minima?></td>
                        <td>&nbsp;</td>
                        <td width="40%">
                            <div align="right">
                                <a href="javascript:;" id="" onclick="ver_ordenesp(<?=$codigo_cabecera?>)">
                                    <img src="<?php echo base_url();?>images/btnverop.png" width="85" 
                                         height="22" class="imgBoton" />
                                </a>
                            </div>
                        </td>
                        <td> <span class="cantidad">(10)</span> </td>
                    </tr>
                    <tr>
                        <td style="font-weight:bold;"> STOCK ACTUAL : </td>
                        <td style="color:red;font-weight:bold;font-size:13px;"><?=$stock_actual;?></td>
                        <td>&nbsp;</td>
                        <td width="40%">
                            <div align="right">
                                <a href="javascript:;" id="" onclick="ver_mensajes(<?=$codigo_cabecera?>)">
                                    <img src="<?php echo base_url() ?>images/btnvermensajes.png" width="85" 
                                         height="22" class="imgBoton" />
                                </a>
                            </div>
                        </td>
                        <td> <span class="cantidad">(<?= count($cantidad_mensajes) ?>)</span> </td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                </table>
                
                <table class="fuente8" cellspacing="0" cellpadding="3" border="0" >
                    <tr>
                        <td>
                            <span style="border:1px solid red;background:red;">&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                &nbsp;Rotura de Stock
                            <span style="border:1px solid silver;background:silver;">&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                &nbsp;Creaci&oacute;n de OT
                            <span style="border:1px solid #000000;background:#000000;">&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                &nbsp;Stock por debajo del Stock de seguridad
                        </td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                </table>
                
                <table class="Table_Class" cellspacing="0" cellpadding="3" border="0" id="Table1">
                    <tr>
                        <th width="20%">&nbsp;</th>
                        <?php
                            $fin_temporada = count($lista_detalle)-1;
                            foreach( $lista_detalle as $key=>$value ) {
                        ?>
                        <th>
                            <?php
                                if ( $key == $fin_temporada )
                                    echo "<a href='#' title='Fin de la temporada' class='tooltip'>".$value[0].'<a/>';
                                else
                                    echo $value[0];
                            ?>
                        </th>
                        <?php
                            } // fin del foreach
                        ?>
                    </tr>
                    <tr>
                        <th width="20%">
                            <div align="center">
                                <a href="#" title="El pronostico es lo que........" class="tooltip medida">
                                    Pron&oacute;stico
                                </a>
                            </div>
                        </th>
                        <?php
                            foreach( $lista_detalle as $value ) {
                        ?>
                                <td style="background:#FFFFFF;"><?=$value[1]?></td>
                        <?php
                            } // fin del foreach
                        ?>
                    </tr>
                    <tr>
                        <th>
                            <div align="center">
                                <a href="#" title="Ventas o Pedidos son lo que........" class="tooltip medida">
                                    Venta / Pedidos
                                </a>
                            </div>
                        </th>
                        <?php
                            foreach( $lista_detalle as $value ) {
                        ?>
                                <td style="background:#FFFFFF;"><?=$value[2]?></td>
                        <?php
                            } // fin del foreach
                        ?>
                    </tr>
                    <tr>
                        <th>
                            <div align="center">
                                <a href="#" title="La recepcion programada es lo que........" class="tooltip medida">
                                    Recepci&oacute;n Programada
                                </a>
                            </div>
                        </th>
                        <?php
                            foreach( $lista_detalle as $value ) {
                                if ( $value[3] > 0 ) {
                        ?>
                                    <td style="background:#FFFFFF;">
                                        <a href="#" title="Se creo una orden de produccion" class="tooltip"><?=$value[3]?></a>
                                    </td>
                        <?php
                                } else {
                        ?>
                                    <td style="background:#FFFFFF;"><?=$value[3]?></td>
                        <?php
                                } // fin del if/else
                            } // fin del foreach
                        ?>
                    </tr>
                    <tr>
                        <th>
                            <div align="center">
                                <a href="#" title="La recepcion real es lo que........" class="tooltip medida">
                                    Recepci&oacute;n Real
                                </a>
                            </div>
                        </th>
                        <?php
                            foreach( $lista_detalle as $value ) {
                        ?>
                                <td style="background:#FFFFFF;"><?=$value[4]?></td>
                        <?php
                            }
                        ?>
                    </tr>
                    <tr>
                        <th>
                            <div align="center">
                                <a href="#" title="La cantidad disponible es lo que........" class="tooltip medida">
                                    Cantidad Disponible
                                </a>
                            </div>
                        </th>
                        <?php
                            foreach( $lista_detalle as $value ) {
                                $back_color = ($value[5]<0) ? 'red' : '#FFFFFF';
                                $font_color = ($value[5]<0) ? 'white' : '';
                                $negrita    = ($value[5]<0) ? 'bold' : '';
                        ?>
                                <td style="background:<?=$back_color?>;color:<?=$font_color?>;font-weight:<?=$negrita?>">
                                    <?=$value[5]?>
                                </td>
                        <?php
                            }
                        ?>
                    </tr>
                    <tr>
                        <th>
                            <div align="center">
                                <a href="#" title="El stock de seguridad es lo que........" class="tooltip medida">
                                    Stock de Seguridad
                                </a>
                            </div>
                        </th>
			<?php
                            foreach( $lista_detalle as $value ) {
                        ?>
                                <td style="background:#FFFFFF;"><?=$value[6]?></td>
                        <?php
                            }
                        ?>
                    </tr>
                </table>
                
                <table class="fuente8" cellspacing="0" cellpadding="3" border="0" >
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td><?=$reporte?></td>
                    </tr>
                </table>
                
                <div style="width:934px;margin-top:12px;">
                    <div class="content_div left margin-right">
                        <table class="fuente8" cellspacing="0" cellpadding="3" border="0" >
                            <tr class="cabecera_table">
                                <th style="color:#FFFFFF;background-color:#0055D7;" colspan="5">
                                    &Uacute;LTIMOS PEDIDOS
                                </th>
                            </tr>
                            <tr class="cabecera_table">
                                <td class="css_cabectabla"> FECHA </td>
                                <td class="css_cabectabla"> N&Uacute;MERO </td>
                                <td class="css_cabectabla"> ART&Iacute;CULO </td>
                                <td class="css_cabectabla"> CANTIDAD </td>
                            </tr>
                            <tr class="table_par">
                                <td> 12/08/2012 </td>
                                <td> 157 </td>
                                <td> ABRIGO ES ML CRUZADA </td>
                                <td> 500 </td>
                            </tr>
                            <tr class="table_impar">
                                <td> 12/08/2012 </td>
                                <td> 157 </td>
                                <td> ABRIGO ES ML CRUZADA </td>
                                <td> 350 </td>
                            </tr>
                            <tr class="table_impar">
                                <td colspan="5"><div align="right"><a href="#"> Ver mas... </a></div></td>
                            </tr>
                        </table>
                        
                        <table class="fuente8" cellspacing="0" cellpadding="3" border="0" >
                            <tr class="cabecera_table">
                                <th style="color:#FFFFFF;background-color:#0055D7;" colspan="6">
                                    &Uacute;LTIMAS &Oacute;RDENES DE COMPRA
                                </th>
                            </tr>
                            <tr class="cabecera_table">
                                <td class="css_cabectabla"> FECHA </td>
                                <td class="css_cabectabla"> N&Uacute;MERO </td>
                                <td class="css_cabectabla"> ART&Iacute;CULO </td>
                                <td class="css_cabectabla"> PROVEEDOR</td>
                                <td class="css_cabectabla"> CANTIDAD </td>
                                <td class="css_cabectabla"> TOTAL </td>
                            </tr>
                            <tr class="table_par">
                                <td> 12/08/2012 </td>
                                <td> 4455 </td>
                                <td> ABRIGO ES ML CRUZADA </td>
                                <td> TEXTIL UNION </td>
                                <td> 850 </td>
                                <td> 2,291.11 </td>
                            </tr>
                            <tr class="table_impar">
                                <td> 12/08/2012 </td>
                                <td> 7885 </td>
                                <td> ABRIGO ES ML CRUZADA </td>
                                <td> GRUPOESHOP </td>
                                <td> 350 </td>
                                <td> 5620 </td>
                            </tr>
                            <tr class="table_impar">
                                <td colspan="6"><div align="right"><a href="#"> Ver mas... </a></div></td>
                            </tr>
                        </table>
                    </div>
                    
                    <div class="content_div left">
                        <table class="fuente8" cellspacing="0" cellpadding="3" border="0" >
                            <tr class="cabecera_table">
                                <th style="color:#FFFFFF;background-color:#0055D7;" colspan="6">&Uacute;LTIMAS &Oacute;RDENES DE PRODUCCI&Oacute;N</th>
                            </tr>
                            <tr class="cabecera_table">
                                <td class="css_cabectabla"> FECHA </td>
                                <td class="css_cabectabla"> N&Uacute;MERO </td>
                                <td class="css_cabectabla"> ESTADO </td>
                                <td class="css_cabectabla"> ART&Iacute;CULO </td>
                                <td class="css_cabectabla">CAN. TOTAL</td>
                                <td class="css_cabectabla">CAN. PENDIENTE</td>
                            </tr>
                            <tr class="table_par">
                                <td> 12/08/2012 </td>
                                <td> 157 </td>
                                <td> PROCESO </td>
                                <td> ABRIGO ES ML CRUZADA </td>
                                <td> 4000 </td>
                                <td> 1500 </td>
                            </tr>
                            <tr class="table_impar">
                                <td> 12/08/2012 </td>
                                <td> 157 </td>
                                <td> POR CONFIRMAR </td>
                                <td> ABRIGO ES ML CRUZADA </td>
                                <td> 2000 </td>
                                <td> 2000 </td>
                            </tr>
                            <tr class="table_impar">
                                <td colspan="6"><div align="right"><a href="#"> Ver mas... </a></div></td>
                            </tr>
                        </table>
                        
                        <table class="fuente8" cellspacing="0" cellpadding="3" border="0" >
                            <tr class="cabecera_table">
                                <th style="color:#FFFFFF;background-color:#0055D7;" colspan="6">&Uacute;LTIMOS MENSAJES</th>
                            </tr>
                            <tr class="cabecera_table">
                                <td class="css_cabectabla"> FECHA </td>
                                <td class="css_cabectabla"> N&Uacute;MERO </td>
                                <td class="css_cabectabla"> ESTADO </td>
                                <td class="css_cabectabla" width="70%"> DESCRIPCION </td>
                                <td class="css_cabectabla"> ART&Iacute;CULO </td>
                                <td class="css_cabectabla"> MONTO </td>
                            </tr>
                            <tr class="table_par">
                                <td> 12/08/2012</td>
                                <td> 157</td>
                                <td> CR&Iacute;TICO</td>
                                <td>
                                    <img src="<?=base_url()?>images/error.png" width="16px" border="0" />&nbsp;ROTURA DE STOCK
                                </td>
                                <td> ABRIGO ES ML CRUZADA </td>
                                <td> 5620 </td>
                            </tr>
                            <tr class="table_impar">
                                <td> 12/08/2012 </td>
                                <td> 157 </td>
                                <td> ADVERTENTICA </td>
                                <td>
                                    <img src="<?=base_url();?>images/warning.png" width="16px" border="0" />&nbsp;PELIGRO DE ROTURA DE STOCK
                                </td>
                                <td> ABRIGO ES ML CRUZADA </td>
                                <td> 5620 </td>
                            </tr>
                            <tr class="table_impar">
                                <td colspan="6"><div align="right"><a href="#">Ver mas...</a></div></td>
                            </tr>
                        </table>
                    </div>
                </div>
                
                <div style="margin-top:20px; text-align: center">
                    <a href="javascript:;" id="cancelarCabecera">
                        <img src="<?php echo base_url() ?>images/botonaceptar.jpg" width="85" height="22" class="imgBoton" />
                    </a>
                </div>
                
		<input type="hidden" name="base_url" id="base_url" value="<?= base_url() ?>" />
            
            </div>
            
        </div>
    </div>
</div>

<a href="#pagina" id="open" class="defaultDOMWindow"></a>
<a href="#pagina" id="close" class="defaultCloseDOMWindow"></a>
