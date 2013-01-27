<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/mps/cabeceramps.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/funciones.js"></script>

<div id="pagina">
    <div id="zonaContenido">
        <div align="center">
            
            <div id="tituloForm" class="header"><?php echo $titulo_busqueda ?></div>
            
            <div id="frmBusqueda" >
                <form id="form_busquedaRol" name="form_busquedaRol" method="post" action="">
                    <table class="fuente8" width="98%" cellspacing=0 cellpadding="5" border=0>
                        <tr>
                            <td align='left' width="13%"> Nombre MPS : </td>
                            <td align='left'>
                                <input id="txtNombre" name="txtNombre" type="text" class="cajaMedia" 
                                       maxlength="100" value="" />
                            </td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                    </table>
                </form>
            </div>
            
            <div id="botonBusqueda">
                <ul id="generarPronostico" class="lista_botones"><li id="nuevo"> Generar Planificaci&oacute;n </li></ul>
                <ul id="limpiar" class="lista_botones"><li id="limpiar"> Limpiar </li></ul>
                <ul id="buscarCabecera" class="lista_botones"><li id="buscar"> Buscar </li></ul>
            </div>
            
            <div id="lineaResultado">
                <table class="fuente8" width="100%" cellspacing=0 cellpadding=3 border=0>
                    <tr>
                        <td width="50%" align="left">
                            N de tablas MPS encontrados:&nbsp;<?php echo $registros ?>
                        </td>
                        <td width="50%" align="right">&nbsp;</td>
                    </tr>
                </table>
            </div>
            
            <div id="cabeceraResultado" class="header"><?php echo $titulo_tabla ?></div>
            
            <div id="frmResultado">
                <table class="fuente8" width="100%" cellspacing="0" cellpadding="3" border="0" ID="Table1">
                    <tr class="cabeceraTabla">
                        <td width="5%">ITEM</td>
                        <td width="5%">IMAGEN</td>
                        <td width="35%">PRODUCTO</td>
                        <td width="15%">C&Oacute;DIGO INTERNO</td>
                        <td width="10%">PLANIFICACI&Oacute;N</td>
                        <td width="5%">&nbsp;</td>
                        <td width="5%">&nbsp;</td>
                    </tr>
                    <?php
                        if ( count($lista) > 0 ) {
                            foreach( $lista as $key=>$value ) {
                                $class = $key%2==0 ? 'itemParTabla' : 'itemImparTabla';
                    ?>
                                <tr class="<?php echo $class ?>">
                                    <td> <div align="center"><?=$value[0]?></div> </td>
                                    <td>
                                        <div align="left">
                                            <img src="<?= base_url() . 'images/img_db/' . $value[4] ?>"
                                                 width="50px" height="50px" title="<?=$value[3]?>" />
                                        </div>
                                    </td>
                                    <td> <div align="left"><?=$value[3]?></div> </td>
                                    <td> <div align="center"><?=$value[2]?></div> </td>
                                    <td>
                                        <div align="center">
                                            <a href="javascript:;" onclick="ver_ordenes(<?=$value[2]?>)">
                                                <img src="<?=base_url()?>images/otrabajo.png" width='16' 
                                                     height='16' border='0' title='ver ordenes planificadas' />
                                            </a>
                                            <a href="javascript:;" onclick="ver_pedidos(<?=$value[2]?>)">
                                                <img src="<?=base_url()?>images/pedidos.png" width='16' 
                                                     height='16' border='0' title='ver pedidos' />
                                            </a>
                                            <a href="javascript:;" onclick="ver_mensajes(<?=$value[2]?>)">
                                                <img src="<?=base_url()?>images/mensajes2.png" width='16' 
                                                     height='16' border='0' title='ver mensajes' />
                                            </a>
                                        </div>
                                    </td>
                                    <td>
                                        <div align="center">
                                            <a href="javascript:;" onclick="ver_cabecera(<?=$value[2]?>)">
                                                <img src="<?=base_url()?>images/ver.png" width='16' 
                                                     height='16' border='0' title='Ver calculo' />
                                            </a>
                                        </div>
                                    </td>
                                    <td>
                                        <div align="center">
                                            <a href="javascript:;" onclick="editar_cabecera(<?=$value[2]?>)">
                                                <img src="<?=base_url()?>images/modificar.png" width='16' 
                                                     height='16' border='0' title='Modificar' />
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                    <?php
                            }   // fin del foreach
                        } else {
                    ?>
                            <table width="100%" cellspacing="0" cellpadding="3" border="0" class="fuente8">
                                <tbody>
                                    <tr>
                                        <td width="100%" class="mensaje">
                                            No hay ning&uacute;n registro que cumpla con los criterios de b&uacute;squeda
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                    <?php
                        } // fin del else
                    ?>
                </table>
		<table class="fuente8" width="100%" cellspacing="0" cellpadding="3" border="0" ID="Table1">
                    <tr>
                        <td>
                            <div id="cargando" align="center">
                                Procesando ...
<!--                                <img src="<?=base_url()?>images/cargando.gif" border='0' />-->
                            </div>
                            <div id="error" class="error" align="center">
                                ¡ Ocurrio un error en el procesamiento !
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            
            <div style="margin-top: 15px;"><?php echo $paginacion ?></div>
            
            <input type="hidden" id="iniciopagina" name="iniciopagina" />
            <input type="hidden" id="cadena_busqueda" name="cadena_busqueda" />
            <input type="hidden" name="base_url" id="base_url" value="<?php echo base_url() ?>" />
        </div>
    </div>
</div>

<?php
//    echo '<pre>';
//    print_r( $lista );
//    echo '</pre>';
?>
