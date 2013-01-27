<script type="text/javascript" src="<?php echo base_url();?>js/jquery.metadata.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.validate.js"></script>		
<script type="text/javascript" src="<?php echo base_url();?>js/mb/grupo_temporadas.js"></script>



<div id="pagina">
    <div id="zonaContenido">
        <div align="center">
            <div id="tituloForm" class="header"><?php echo $titulo ?></div>
            <div id="frmBusqueda">
                <?php echo validation_errors( "<div class='error'>", '</div>' ) ?>
                <?php echo $form_open ?>
                    <table width="250" cellspacing="0" cellpadding="6" border="0">
                        <tr>
                            <td> Nombre Grupo: </td>
                            <td><?php echo $nombre ?></td>
                        </tr>
                        <tr>
                            <td>
                                <img id="guardar" src="<?php echo base_url() ?>images/botonaceptar.jpg" width="85" 
                                     height="22" border="1" />
                            </td>
                            <td>
                                <img id="cancelar" src="<?php echo base_url() ?>images/botoncancelar.jpg" width="85" 
                                     height="22" border="1">
                            </td>
                        </tr>
                    </table>
                    <?php echo $oculto  ?>
                    <input type="hidden" name="codigo" id="codigo" value="<?php echo $codigo ?>" >
                    
                    
                    
                    
    <!-- inicio detalle temporadas -->
    <table class="fuente8" width="100%" cellspacing="0" cellpadding="3" border="0" ID="Table1">
                   
                <tr class="cabeceraTabla">
                        <td width="5%">&nbsp;</td>
                        <td width="5%">ITEM</td>                        
                        <td width="10%">CODIGO</td>
                        <td width="20%">DESCRIPCION</td>
                        
                        <td width="10%%">  </td>                      
                       

              </tr>
                    <?php
                    if(count($lista_detalle)>0){
                        foreach($lista_detalle as $indice=>$valor)
                        {
                            $class = $indice%2==0?'itemParTabla':'itemImparTabla';
                            ?>
                            <tr class="<?php echo $class;?>">
                            <td><div align="center"><?php echo $valor[0];?></div></td>
                            <td><div align="center"><?php //echo $valor[1];?></div></td>
                            <td><div align="center"><?php echo $valor[2];?></div></td>
                            <td><div align="center"><?php echo $valor[3];?></div></td>
                            
                            <td><div align="center"><?php echo $valor[4];?></div></td>         
                               
                            
                            </tr>

                            <?php
                        }
                    }
                    else{
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
    <!-- inicio detalle temporadas -->                    
                    
                    
                    
                    
                    
                    
                    
                    
                <?php echo $form_close ?>
                <br/>
                
              
                
                
                
                
            </div>
        </div>
    </div>
</div>
