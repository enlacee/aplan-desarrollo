<?php

    class Detallecabeceramps_model extends Model {
        
        protected $_name = 'cji_detallecabeceramps';
	
        public function  __construct() {
            parent::__construct();
            $this->load->database();
            $this->somevar['compania']  = $this->session->userdata( 'compania' );
            $this->somevar['hoy']       = mdate( '%Y-%m-%d', time() );
        }
        
        //para el caso de  eliminacion del detalle cabecera sku
        public function eliminar_detallecabeceramps( $codigo_cabecera ) {
            $where = array( 'CABE_Codigo'=>$codigo_cabecera );
            $this->db->where( $where )->delete( $this->_name );
            return true;
        }
        
        // elimina todos los elementos de la tabla detallecabeceramps
        public function limpiar_detallecabeceramps() {
            $this->db->empty_table( $this->_name );
        }
        
        public function obtener_detalle_cabecera( $codigo_cabecera ) {
            $where = array( 'CABE_Codigo'=>$codigo_cabecera );
            $query = $this->db->where( $where )->get( $this->_name );
            if ( $query->num_rows() > 0 )
                return $query->result();
            else
                return array();
        }
        
        //funcion para obtener el detalle, segun la fecha actual
        public function obtener_detalle_cabecera_2( $codigo_cabecera ) {
            $fecha = $this->somevar['hoy'];
            $where = array( 'dc.CABE_Codigo'=>$codigo_cabecera, 'dc.DETA_Fecha >'=>$fecha );
            $this->db->select( '*' );
            $this->db->from( 'cji_cabeceramps c' );
            $this->db->join( 'cji_detallecabeceramps dc', 'c.CABE_Codigo = dc.CABE_Codigo' );
            $query = $this->db->where( $where )->get();
            if ( $query->num_rows > 0 ) {
                foreach( $query->result() as $fila )
                    $data[] = $fila;
                return $data;
            } else
                return array();
        }
        
        //funcion para obtener por el codigo de detalle
        public function obtener_detallecabecera( $cod_detalle ) {
            $where = array( 'DDEM_Codigo'=>$cod_detalle );
            $query = $this->db->where( $where )->get( $this->_name );
            if ( $query->num_rows() > 0 )
                return $query->result();
            else
                return array();
        }
        
        //funcion para obtener el detalle, por fecha
        public function obtener_detalle_cabecera_3( $codigo_cabecera, $fecha ) {
            $where = array( 'CABE_Codigo'=>$codigo_cabecera, 'DETA_Fecha'=>$fecha );
            $query = $this->db->where( $where )->get( $this->_name );
            if( $query->num_rows() > 0 )
                return $query->result();
            else
                return array();
        }
        
        public function modificar_detallecabeceramps( $filter ) {
            $where = array( 'CABE_Codigo'=>$filter->CABE_Codigo, 'DETA_Fecha'=>$filter->DETA_Fecha );
            $this->db->where( $where )->update( $this->_name, $filter );
        }
        
        public function obtener_detallecabeceramps_fecha( $filter ) {
            $where = array( 'CABE_Codigo'=>$filter->CABE_Codigo, 'DETA_Fecha'=>$filter->DETA_Fecha );
            $query = $this->db->where( $where )->get( $this->_name, 1 );
            if ( $query->num_rows() > 0 )
                return $query->result();
            else
                return array();
        }
        
    }
    
?>
