<?php
    
    class Productos extends Controller {
        
        function __construct() {
            parent :: __construct();
            $this->load->model( 'producto_model' );
        }
        
        public function listar_productos() {
            $output = $this->producto_model->listar_productos();
            echo $output;
        }
        
    }
    
?>
