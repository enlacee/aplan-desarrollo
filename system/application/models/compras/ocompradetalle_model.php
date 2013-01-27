<?php

    class Ocompradetalle_Model extends Model {
        
        protected $_name='cji_ocompradetalle';
        
        function __construct(){
            parent :: __construct();		
        }
        
        public function obtener_ocompradetalle( $codigo_ocompra ) {
            $retorno = array();
            $where = array( 'OCOM_Codigo' => $codigo_ocompra );
            $query = $this->db->where( $where )->get( $this->_name, 1 );
            if ( $query->num_rows > 0 )
                $retorno = $query->result();
            return $retorno;
        }
        
        public function limpiar_ocompradetalle() {
            $this->db->empty_table( $this->_name );
        }
        
    }
    
?>
