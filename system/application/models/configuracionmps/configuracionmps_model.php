<?php

    class Configuracionmps_Model extends Model {
        
        protected $_name = "cji_configuracionmps";
        
        var $somevar;
        
        public function  __construct(){
            parent :: __construct();
            $this->load->database();
            $this->somevar['compania']      = $this->session->userdata( 'compania' );
            $this->somevar['compania_hija'] = $this->session->userdata( 'compania_hija' );
        }
        
	//POR AHORA ESTA SIN PARAMETROS, CONSIDERO QUE CADA COMPANIA TIENE UNA SOLA CONFIGURACION
        public function obtener_configuracionmps() {
            $where = array( 'c.CONM_Estado'=>'1', 'cc.COMP_Codigo'=>$this->somevar['compania_hija'] );
            $query = $this->db->select( '*' )
                              ->from( 'cji_configuracionmps c' )
                              ->join( 'cji_companiaconfiguracionmps cc', 'cc.CONM_Codigo=c.CONM_Codigo' )
                              ->where( $where )->get();
            if ( $query->num_rows > 0 ) {
                foreach( $query->result() as $fila )
                    $data[] = $fila;
                return $data;
            }
        }
        
        public function editar_configuracionmps( $filter ) {
            $where = array( 'CONM_Codigo'=>$filter->CONM_Codigo );
            $retorno = $this->db->where( $where )->update( $this->_name, $filter );
            return $retorno;
        }
	
        public function insertar_configuracionmps( $filter ) {
            $this->db->insert( $this->_name, $filter );
        }
	
    }
    
?>
