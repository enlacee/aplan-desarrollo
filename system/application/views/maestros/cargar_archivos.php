<html>
    <head>
        <script type="text/javascript" src="<?php echo base_url() ?>js/jquery.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>js/maestros/carga_masiva.js"></script>		
        <script type="text/javascript" src="<?php echo base_url() ?>js/funciones.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>js/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>js/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
        <script type="text/javascript">
            $(document).ready( function() {
                $("a.log").fancybox( {
                    'width'          : 1000,
                    'height'         : 500,
                    'transitionIn'   : 'elastic',
                    'transitionOut'  : 'elastic',
                    'type'	     : 'iframe'
                } );
            } );
        </script>
    </head>
    <body>
        
        <div id="VentanaTransparente" style="display:none;">
            <div class="overlay_absolute"></div>
            <div id="cargador" style="z-index:2000">
                <table width="100%" height="100%" border="0" class="fuente8">
                    <tr valign="middle">
                        <td> Por Favor Espere    </td>
                        <td>
                            <img src="<?php echo base_url() ?>images/cargando.gif"  border="0" title="CARGANDO" />
                            <a href="#" id="hider2"></a>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        
        <div id="pagina">
            <div id="zonaContenido">
                <div align="center">
                    <div id="tituloForm" class="header"><?php echo $titulo ?></div>
                    <div id="frmBusqueda">
                        <form id="frmCargarArchivos" name="frmCargarArchivos" method="post" 
                              action="<?php echo base_url() ?>maestros/carga_masiva/subir_archivos" 
                              enctype="multipart/form-data">
                            
                            <div id="nuevoRegistro" style="display:none; float:right; width:150px; height:20px;
                                                            border:0px solid #000; margin-top:7px;">
                                <a href="#"> Nuevo <image src="<?php echo base_url() ?>images/add.png" 
                                                          name="agregarFila" id="agregarFila" border="0" 
                                                          title="Agregar" />
                                </a>
                            </div><br><br>
                            
                            <div style="margin-top:20px; text-align: center">
                                <table class="fuente8" width="98%" cellspacing="0" cellpadding="4" border="0">
                                    <tr>
                                        <td> Seleccione el archivo de Demanda : </td>
                                        <td> <input type="file" name="demanda[]" id="demanda" /> </td>
                                        <td>
                                            <?php
                                                if ( count($lista_log_demanda) > 0 ) {
                                            ?>
                                            <a class="log" style="color:red" 
                                               href="<?php echo base_url() ?>maestros/carga_masiva/ver_errores/0">
                                                HUBO ERRORES EN LA CARGA DE DEMANDA, CLICK AQUI PARA VISUALIZAR ERRORES
                                            </a>
                                            <?php
                                                } else {
                                                    echo 'ARCHIVO CARGADO SIN ERRORES';
                                                }
                                            ?>
                                        </td>
                                        <td>
                                            <a class="log" style="color:red;" 
                                               href="<?php echo base_url() ?>maestros/carga_masiva/ver_demanda">
                                                VER REGISTROS GRABADOS
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td> Seleccione el archivo de Inventario : </td>
                                        <td> <input type="file" name="demanda[]" id="demanda" /> </td>
                                        <td>
                                            <?php
                                                if ( count($lista_log_inventario) > 0 ) {
                                            ?>
                                            <a class="log" style="color:red" 
                                               href="<?php echo base_url() ?>maestros/carga_masiva/ver_errores/1">
                                                HUBO ERRORES EN LA CARGA DE INVENTARIO, CLICK AQUI PARA VISUALIZAR ERRORES
                                            </a>
                                            <?php
                                                } else {
                                                    echo 'ARCHIVO CARGADO SIN ERRORES';
                                                }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td> Seleccione el archivo de &Oacute;rdenes Planificadas : </td>
                                        <!-- OJO: demanda u ordenes planificadas -->
                                        <td> <input type="file" name="demanda[]" id="demanda" /> </td>
                                        <td>
                                            <?php
                                                if ( count($lista_log_ordenes) > 0 ) {
                                            ?>
                                                <a class="log" style="color:red" 
                                                   href="<?php echo base_url() ?>maestros/carga_masiva/ver_errores/1">
                                                    HUBO ERRORES EN LA CARGA DE ORDENES, CLICK AQUI PARA VISUALIZAR ERRORES
                                                </a>
                                            <?php
                                                } else {
                                                    echo 'ARCHIVO CARGADO SIN ERRORES';
                                                }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td> Seleccione el archivo de Productos SKU : </td>
                                        <td><input type="file" name="demanda[]" id="demanda" /></td>
                                        <td>
                                            <?php
                                                if ( count($lista_log_productos) > 0 ) {
                                            ?>
                                            <a class="log" style="color:red" 
                                               href="<?php echo base_url() ?>maestros/carga_masiva/ver_errores/1">
                                                HUBO ERRORES EN LA CARGA DE ORDENES, CLICK AQUI PARA VISUALIZAR ERRORES
                                            </a>
                                            <?php
                                                } else {
                                                    echo 'ARCHIVO CARGADO SIN ERRORES';
                                                }
                                            ?>
                                        </td>
                                    </tr>
                                </table>
                                <a href="#" id="cargarArchivos">
                                    <img src="<?php echo base_url() ?>images/botonaceptar.jpg" width="85" 
                                         height="22" class="imgBoton" onMouseOver="style.cursor=cursor" />
                                </a>
                                <input type="hidden" name="base_url" id="base_url" value="<?php echo base_url() ?>" />
                            </div>
                            
                            <div style="margin-top:20px; text-align: center"></div>
                            
                        </form>
                    </div>
                    
                    <?php
//                        echo '<pre>';
//                        print_r( $_SESSION );
//                        echo '</pre>';
                    ?>
                </div>
            </div>
        </div>
        
    </body>
</html>
