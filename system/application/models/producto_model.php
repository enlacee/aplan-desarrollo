<?php

    class Producto_Model extends Model {
        
        protected $_tabla = "cji_calendario";
        
        public function  __construct(){
            parent :: __construct();
        }
        
        public function listar_productos() {
            $query = $this->db->get( $this->_tabla );
            if ( $query->num_rows > 0 ) {
                $output_string = '<table border=1>';
                foreach( $query->result() as $row ) {
                    $output_string .= '<tr>';
                    $output_string .= '<td>' . $row->CALE_Descripcion . '</td>';
                    $output_string .= '</tr>';
                }
                $output_string .= '</table>';
            } else
                $output_string = 'No hay resultados';
            return $output_string;
        }
        
    }
    
?>
