<?php
$nombre_empresa = $this->session->userdata('nombre_empresa');
$nombre_persona = $this->session->userdata('nombre_persona');
$persona = $this->session->userdata('persona');
$user = $this->session->userdata('user');
$url = base_url() . "index.php/index/salir_sistema";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <title> <?php echo $titulo; ?> </title>
        <meta http-equiv="content-type" content="text/html;charset=utf-8" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/calendario/calendar-win2k-2.css" type="text/css" media="all" title="win2k-cold-1" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/estilos.css" type="text/css"/>
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/nav.css" type="text/css"/>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/funciones.js"></script>
        <!-- Calendario -->
        <script type="text/javascript" src="<?php echo base_url(); ?>js/calendario/calendar.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/calendario/calendar-es.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/calendario/calendar-setup.js"></script>
        <link rel="icon" href="<?php echo base_url(); ?>favicon.ico" type="image/x-icon" />
        <!-- Calendario -->
        <script language="javascript">
            var cursor;
            if (document.all) {
                // Est� utilizando EXPLORER
                cursor='hand';
            } else {
                // Est� utilizando MOZILLA/NETSCAPE
                cursor='pointer';
            }
        </script>
        <script language="javascript">
            $(document).ready(function(){  
        
                $("ul.subnav").parent().append("<span></span>"); //Only shows drop down trigger when js is enabled (Adds empty span tag after ul.subnav*)  
                $("ul.topnav li span").click(function() { //When trigger is clicked...  
      
                    //Following events are applied to the subnav itself (moving subnav up and down)  
                    $(this).parent().find("ul.subnav").slideDown('fast').show(); //Drop down the subnav on click  
      
                    $(this).parent().hover(function() {  
                    }, function(){  
                        $(this).parent().find("ul.subnav").slideUp('slow'); //When the mouse hovers out of the subnav, move it back up  
                    });  
      
                    //Following events are applied to the trigger (Hover events for the trigger)  
                }).hover(function() {  
                    $(this).addClass("subhover"); //On hover over, add class "subhover"  
                }, function(){  //On Hover Out  
                    $(this).removeClass("subhover"); //On hover out, remove class "subhover"  
                });  
      
            });  
        </script>
        <style type="text/css">

        </style>
    </head>
    <body>
        <div id="pagewidth">
            <div align="center"><img src="<?php echo base_url(); ?>images/top_banner.jpg" height="81"></div>
            <div id="MenuAplicacion" ></div>
            <div style="width:934px;  margin-left: auto; margin-right: auto"><?php require_once "menu.php"; ?></div>
            <div class="fuente8" style="margin:0 auto; width:934px;text-align:right;">
                <b>EMPRESA:</b> <?php echo $nombre_empresa ?>
                <b style="margin-left:20px">USUARIO:</b> 
                <?php //echo anchor('seguridad/usuario/editar_cuenta/'.$user,$nombre_persona); ?>
            </div>

            <div id="wrapper" class="clearfix" >
                <!-- Inicio -->
                <div id="VentanaTransparente" style="display:none;">
                    <div class="overlay_absolute"></div>
                    <div id="cargador" style="z-index:2000">
                        <table width="100%" height="100%" border="0" class="fuente8">
                            <tr valign="middle">
                                <td> Por Favor Espere    </td>
                                <td><img src="<?php echo base_url(); ?>images/cargando.gif"  border="0" title="CARGANDO"/><a href="#" id="hider2"></a>	</td>
                            </tr>
                        </table>

                    </div>
                </div>
                <!-- Fin -->
                <div style="clear:both;"></div>
                <div id="twocols" class="clearfix"><?php echo $content_for_layout ?></div>
                <div style="clear:both;"></div>
            </div>
            <div id="footer" style="clear:both">
            </div>
        </div>
    </body>
</html>
