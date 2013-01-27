<?php

    class Otrabajodetalle_Model extends Model {
        
        protected $_name='cji_otrabajodetalle';
        
        function __construct(){
            parent :: __construct();		
        }
        
        public function obtener_otrabajodetalle( $codigo_otrabajo ) {
            $retorno = array();
            $where = array( 'OTRA_Codigo' => $codigo_otrabajo);
            $query = $this->db->where( $where )->get( $this->_name, 1 );
            if ( $query->num_rows > 0 )
                $retorno = $query->result();
            return $retorno;
        }
        
        public function limpiar_otrabajodetalle() {
            $this->db->empty_table( $this->_name );
        }
        
    }
    
?>
