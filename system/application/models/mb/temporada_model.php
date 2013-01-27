<?php

class Temporada_Model extends Model {
    
    private $tabla = 'mb_temporada';
    
        function __construct(){
            parent :: __construct();
            $this->load->database();
            //$this->load->helper( 'date');
            //$this->load->model( 'seguridad/permiso_model');
            //$this->load->model( 'seguridad/menu_model');
            //$this->somevar['compania']  = $this->session->userdata( 'compania' );
            //$this->somevar['usuario']   = $this->session->userdata( 'usuario' );
            //$this->somevar['hoy']       = mdate( '%Y-%m-%d %h:%i:%s', time() );
        }
        
        
        function listar($number_items='',$offset=''){

            $this->db->select('Codigo,Descripcion');  
            $this->db->where( 'Estado', 'A');
            //$this->db->order_by( 'NombreGrupo', 'asc' );
            $this->db->limit($number_items);
            
            $query = $this->db->get( $this->tabla);             
            if ( $query->num_rows > 0 )
                return $query->result();
            
        }
        
        
    
}

?>
