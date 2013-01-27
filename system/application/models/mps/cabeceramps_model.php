<?php

    class Cabeceramps_Model extends Model {
        
        protected $_name = "cji_cabeceramps";
        
        public function  __construct(){
            parent :: __construct();
            $this->somevar['compania'] = $this->session->userdata( 'compania' );
        }
        
        public function insertar_cabeceramps( $filter ) {
            $this->db->trans_begin();
            
            $this->db->insert( $this->_name, $filter );
            $cod_cabecera = $this->db->insert_id();
            
            if ( $this->db->trans_status() === FALSE )
                $this->db->trans_rollback();
            else
                $this->db->trans_commit();
            
            return $cod_cabecera;
        }
        
        public function insertar_cabeceramps_detalle( $filter ) {
            $this->db->trans_begin();
            
            $this->db->insert( 'cji_detallecabeceramps', $filter );
            
            if ( $this->db->trans_status() === FALSE )
                $this->db->trans_rollback();
            else
                $this->db->trans_commit();
        }
        
        public function listar_cabeceramps( $number_items='', $offset='' ) {
            $where = array( 'CABE_Estado'=>'1' );
            $query = $this->db->where( $where )->order_by( 'CABE_FechaRegistro', 
                            'desc' )->get( $this->_name, $number_items, $offset );
            if ( $query->num_rows > 0 ) {
                foreach( $query->result() as $fila )
                    $data[] = $fila;
                return $data;
            } else
                return array();
        }
        
        public function eliminar_cabeceramps( $cod_cabecera ) {
            $where                  = array( 'CABE_Codigo'=>$cod_cabecera );
            $filter                 = new stdClass();
            $filter->CABE_Estado    = 0;
            $this->db->where( $where )->update( $this->_name, $filter );
        }
        
        public function limpiar_cabeceramps() {
            $this->db->empty_table( $this->_name );
        }
        
        public function obtener_cabeceramps( $cod_cabeceramps ) {
            $where= array('CABE_Codigo'=>$cod_cabeceramps);
            $query = $this->db->where($where)->get($this->_name,1);
            if ( $query->num_rows > 0 ) {
                foreach( $query->result() as $fila )
                    $data[] = $fila;
                return $data;
            }
        }
        
        public function actualizar_cabeceramps( $filter ) {
            $where = array( 'CABE_Codigo'=>$filter->CABE_Codigo );
            $this->db->where( $where )->update( $this->_name, $filter );
            $codigo = $this->db->insert_id();
            return $codigo;
        }
        
    }
    
?>
