<?php
$datos_menu = $this->session->userdata('datos_menu');
$base_url   = base_url();
$CI = get_instance();
$this->load->model('seguridad/permiso_model');
$this->load->model('maestros/compania_model');
$menus_base=$CI->permiso_model->obtener_permisosMenu($this->session->userdata('rol'));
$cboCompania = $CI->compania_model->combo_compania($_SESSION['compania']);
?>
            <ul class="nav main">
                <li><a href="<?php echo site_url('index/inicio'); ?>">Inicio</a></li>
               <?php
               
                foreach($menus_base as $menu_base){
                    $text = ($menu_base->MENU_Url!='')?'<a href="'.site_url($menu_base->MENU_Url).'">'.$menu_base->MENU_Descripcion.'</a>' : '<a href="javascript:;">'.$menu_base->MENU_Descripcion.'</a>';

                    $enlaces = $menu_base->submenus;                   
                    ?>
                    <li><?php echo $text?>
                    <?php
                    if(count($enlaces)){
                        ?>
                        <ul>
                        <?php
                        foreach($enlaces as $enlace){
                            $subtext='';
                            if($enlace->MENU_FlagEstado==1){
                                if($enlace->MENU_Url!=''){
                                    $subtext = '<a href="'.site_url($enlace->MENU_Url).'">';
                                    $subtext.=$enlace->MENU_Descripcion.'</a>';
                                }
                                else
                                    $subtext='<a href="javascript:;">'.$enlace->MENU_Descripcion.'</a>';

                                echo '<li>'.$subtext.'</li>';
                            }
                        }?>
                        </ul>
                        <?php
                    }
                    ?>
                    </li>
                    
                    <?php
                }                
                ?>              
                <li><a href="<?php echo site_url('index/salir_sistema'); ?>">Salir</a></li>
                <div style="float:right"><?php echo $cboCompania; ?></div>
            </ul>
            