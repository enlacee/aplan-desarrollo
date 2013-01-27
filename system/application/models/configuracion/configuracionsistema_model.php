<?php

    class Configuracionsistema_model extends Model {
    
        var $somevar;
        protected $_name = "cji_configuracionsistema";

        public function  __construct() {
            parent :: __construct();
            $this->somevar['compania']      = $this->session->userdata( 'compania' );
            $this->somevar['compania_hija'] = $this->session->userdata( 'compania_hija' );
            $this->somevar['empresa']       = $this->session->userdata( 'empresa' );
        }

        //POR AHORA ESTA SIN PARAMETROS, CONSIDERO QUE CADA COMPANIA TIENE UNA SOLA CONFIGURACION
        public function obtener_configuracion() {
            $where = array( 'c.CONS_Estado'=>'1', 'cs.COMP_Codigo'=>$this->somevar['compania_hija'] );
            $query = $this->db->select( '*' )
                              ->from( 'cji_configuracionsistema c' )
                              ->join( 'cji_companiaconfiguracions cs', 'cs.CONS_Codigo = c.CONS_Codigo' )
                              ->where( $where )->get();
            if ( $query->num_rows>0 ) {
                foreach( $query->result() as $fila )
                    $data[] = $fila;
                return $data;
            }
        }

        public function modificar_configuracion( $filter, $cod_configuracion ) {
            $where = array( 'CONS_Codigo'=>$cod_configuracion );
            $retorno = $this->db->where( $where )->update( $this->_name, $filter );
            return $retorno;
        }

        public function insertar_configuracion( $filter ) {
            $this->db->insert($this->_name,$filter);
        }

        // primer paramtero : busca por codigo interno
        // segundo paramtero: busca por estado
        public function buscar_configuracion( $codigo_interno=NULL, $estado=NULL ) {		
            $arr_ci = array();
            if ( $codigo_interno != NULL )
                $arr_ci = array( 'CONS_CodigoInterno'=>$codigo_interno );
            
            $arr_e = array();
            if ( $estado != NULL )
                $arr_e = array( 'CONS_Estado'=>$estado );
				
            $where = $arr_ci + $arr_e;
            $query = $this->db->select( '*' )
                              ->from( 'cji_configuracionsistema c' )
                              ->join( 'cji_companiaconfiguracions cs', 'cs.CONS_Codigo = c.CONS_Codigo' )
                              ->where( $where )->get();
            
            if ( $query->num_rows > 0 ) {
                foreach( $query->result() as $fila )
                    $data[] = $fila;
                return $data;
            }
        }
        
	// primer parametro : define que campo se va a filtrar( 1=CALENDARIO, 2=MENSAJES )
	// segundo parametro: parametro que se le pasa el flag( 1=busca compartidos, 0=no compartidos ) 
	// definido por el primer parametro
        public function buscar_compartidos( $tipo_busqueda, $calendario ) {
            $campo_busqueda = '';
            
            switch( $tipo_busqueda ) {
                case 1  :   $campo_busqueda = 'CONS_Calendario';    break;
                case 2  :   $campo_busqueda = 'CONS_Mensajes';      break;
                case 3  :   $campo_busqueda = 'CONS_Otrabajo';      break;
                case 4  :   $campo_busqueda = 'CONS_Ocompra';       break;
            }
            
            $where = array( $campo_busqueda=>$calendario,'COMP_Codigo !='=>$this->somevar['compania_hija'] );
            $query = $this->db->select( '*' )
                              ->from( 'cji_configuracionsistema c' )
                              ->join( 'cji_companiaconfiguracions cs', 'cs.CONS_Codigo = c.CONS_Codigo' )
                              ->where( $where )->get();
            
            if ( $query->num_rows > 0 ) {
                foreach( $query->result() as $fila )
                    $data[] = $fila;
                
                return $data;
            }
        }
        
    }
    
?>
