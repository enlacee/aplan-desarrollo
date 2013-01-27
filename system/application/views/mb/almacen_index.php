<script type="text/javascript" src="<?php echo base_url() ?>js/mb/almacen.js"></script>

<div id="pagina">
    <div id="zonaContenido">
        <div align="center">
            <div id="tituloForm" class="header"><?php echo $titulo_busqueda;?></div>
            <div id="frmBusqueda" >
                <?php echo $form_open ?>
                    <table class="fuente8" width="98%" cellspacing=0 cellpadding="5" border=0>
                        <tr>
                            <td align='left' width="13%"> Descripci&oacute;n </td>
                            <td align='left'><? echo $filtro ?>
                            <td> &nbsp; </td>
                            <td> &nbsp; </td>
                        </tr>
                    </table>
                <?php echo $form_close ?>
            </div>
            <div id="botonBusqueda">
                <ul id="nuevoGrupo" class="lista_botones"><li id="nuevo"> Nuevo Almacen </li></ul> 
                <ul id="limpiarGrupo" class="lista_botones"><li id="limpiar"> Limpiar </li></ul>
                <ul id="buscarGrupo" class="lista_botones"><li id="buscar"> Buscar Almacen </li></ul> 
            </div>
            <div id="lineaResultado">
                <table class="fuente8" width="100%" cellspacing=0 cellpadding=3 border=0>
                    <tr>
                        <td width="50%" align="left"> Número de almacen encontrados:&nbsp;<?php echo $registros ?> </td>
                        <td width="50%" align="right"> &nbsp; </td>
                    </tr>
                </table>
            </div>
            <div id="cabeceraResultado" class="header"><?php echo $titulo_tabla ?></div>
            
            
            <div id="frmResultado">
                <table class="fuente8" width="100%" cellspacing="0" cellpadding="3" border="0" ID="Table1">
                    <tr class="cabeceraTabla">
                        <td width="20"> ITEM</td>
                        <td width="120"> GRUPO DE ALMACEN </td>
                        <td width="120"> FECHA INGRESO </td>
                        <td width="5"> &nbsp; </td>
                        <td width="5"> &nbsp; </td>
                        <td width="5"> &nbsp; </td>
                    </tr>
                    <?php
                        if ( count($lista) > 0 ) {
                            foreach( $lista as $indice=>$valor ) {
                                $class = $indice%2==0 ? 'itemParTabla' : 'itemImparTabla';
                    ?>
                                <tr class="<?php echo $class ?>">
                                    <td> <div align="center"><?php echo $valor[0] ?></div> </td>
                                    <td> <div align="center"><?php echo $valor[2] ?></div> </td>
                                    <td> <div align="center"><?php echo $valor[3] ?></div> </td>
                                    <td>
                                        <div align="center">
                                            <a href="#" onclick="ver_grupo(<?php echo $valor[1] ?>)">
                                                <img src="<?php echo base_url()?>images/ver.png" width="16" 
                                                     height="16" border="0" title="Ver" />
                                            </a>
                                        </div>
                                    </td>
                                    <td> <div align="center"><a href="#" onclick="editar_grupo(<?php echo $valor[1]; ?>)"><img src="<?php echo base_url()?>images/modificar.png" width="16" height="16" border="0" title="Modificar"></a></div></td>
                                    <td> <div align="center"><a href="#" onclick="eliminar_grupo(<?php echo $valor[1]; ?>)"><img src="<?php echo base_url()?>images/eliminar.png" width="16" height="16" border="0" title="Eliminar"></a></div></td>
                                </tr>
                    <?php
                            } // fin del foreach
                        } else {
                    ?>
                            <table width="100%" cellspacing="0" cellpadding="3" border="0" class="fuente8">
                                <tbody>
                                    <tr>
                                        <td width="100%" class="mensaje">No hay ning&uacute;n registro que cumpla con los criterios de b&uacute;squeda</td>
                                    </tr>
                                </tbody>
                            </table>
                    <?php
                        }
                    ?>
                </table>
            </div> <!-- FIN DE GRID-->         
            
            <div style="margin-top: 15px;"><?php echo $paginacion;?></div>
            <?php echo $oculto?>
        </div>
    </div>			
</div>
