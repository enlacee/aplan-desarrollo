<?php

    class Alerta_Model extends Model {
        
        protected $_name = 'cji_alerta';
        
        public function  __construct() {
            parent :: __construct();
            $this->somevar['compania']      = $this->session->userdata( 'compania' );
            $this->somevar['compania_hija'] = $this->session->userdata( 'compania_hija' );
            $this->somevar['hoy']           = mdate( '%Y-%m-%d', time() );
        }
        
        public function insertar_alerta( $filter ) {
            $filter->COMP_Codigo            = $this->somevar['compania_hija'];
            $this->db->insert( $this->_name, $filter );
        }
        
        public function listar_alerta() {
            $where = array( 'a.COMP_Codigo'=>$this->somevar['compania_hija'], 
                            'ALER_Fecha >='=>$this->somevar['hoy'] );
            $this->db->select( '*' );
            $this->db->from( 'cji_alerta a' );
            $this->db->join( 'cji_tipoalerta ta', 'a.TALE_Codigo = ta.TALE_Codigo' );
            $query = $this->db->where( $where )->get();
            if ( $query->num_rows() > 0 )
                return $query->result();
            else
                return array();
        }
        
        public function obtener_alertas_x_producto( $codigo_producto ) {
            $where = array( 'COMP_Codigo'=>$this->somevar['compania_hija'],
                            'PROD_Codigo'=>$codigo_producto );
            $query = $this->db->where( $where )->get( $this->_name );
            if ( $query->num_rows() > 0 )
                return $query->result();
            else
                return array();
        }
        
        public function limpiar_alertas() {
            $this->db->empty_table( $this->_name );
        }
        
    }
    
?>
