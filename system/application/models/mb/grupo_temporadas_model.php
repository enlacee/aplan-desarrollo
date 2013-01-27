<?php

    class Grupo_Temporadas_Model extends Model {
        
        private $tabla = 'mb_grupo_temporada';
        
        function __construct(){
            parent :: __construct();
            $this->load->database();
            $this->load->helper( 'date');
            $this->load->model( 'seguridad/permiso_model');
            $this->load->model( 'seguridad/menu_model');
            $this->somevar['compania']  = $this->session->userdata( 'compania' );
            $this->somevar['usuario']   = $this->session->userdata( 'usuario' );
            $this->somevar['hoy']       = mdate( '%Y-%m-%d %h:%i:%s', time() );
        }
        
        public function listar( $descripcion='',$number_items='',$offset='' ) {
            if ( $descripcion != '' )
                $this->db->like( 'NombreGrupo', $descripcion );
            
            $this->db->where( 'Estado', 1 );
            $this->db->order_by( 'NombreGrupo', 'asc' );
            $query = $this->db->get( $this->tabla, $number_items, $offset );
            if ( $query->num_rows > 0 )
                return $query->result();
        }
        
        public function obtener( $codigo ) {
            $where = array( 'Codigo'=>$codigo );
            $query = $this->db->where( $where )->get( $this->tabla, 1 );
            if ( $query->num_rows > 0 )
                return $query->result();
        }
        
        public function insertar( stdClass $filter=null ) {
            $query = $this->db->insert( $this->tabla, (array)$filter );
            return $this->db->insert_id();
        }
        
        public function eliminar( $codigo ) {
            $where = array( 'Codigo'=>$codigo );
            $this->db->delete( $this->tabla, $where );
        }
        
        public function modificar( $codigo, stdClass $filter=null ) {
            $this->db->where( 'Codigo', $codigo );
            $this->db->update( $this->tabla, (array)$filter );
        }
        
    }
    
?>
