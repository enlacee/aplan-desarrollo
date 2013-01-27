<?php

    class Detallecalendario_Model extends Model {
        
        protected $tabla = "cji_detallecalendario";
        
        public function  __construct() {
            parent :: __construct();
            $this->load->database();
            $this->load->helper( 'date' );
            $this->somevar['compania']  = $this->session->userdata( 'compania' );
            $this->somevar['hoy']       = mdate( '%Y-%m-%d', time() );
        }
        
        public function insertar_detalle_calendario( $filter ) {
            $this->db->insert( $this->tabla, $filter );
        }
        
        public function obtener_detalle_calendario( $cod_calendario ) {
            $where= array( 'CALE_Codigo'=>$cod_calendario );
            $query = $this->db->where($where)->get($this->tabla);
            if ( $query->num_rows > 0 ) {
                foreach( $query->result() as $fila )
                    $data[] = $fila;
                return $data;
            }
        }
        
        public function obtener_dias_no_laborables( $cod_calendario, $mes, $anio ) {
            // DCAL_Flag=1 (dia no laborable)
            $where= array( 'DCAL_Flag'=>'1', 'CALE_Codigo'=>$cod_calendario, 
                           'DCAL_Mes'=>$mes, 'DCAL_Anio'=>$anio );
            $query = $this->db->where( $where )->get( $this->tabla );
            if ( $query->num_rows > 0 ) {
                foreach( $query->result() as $fila )
                    $data[] = $fila;
                return $data;
            }
        }
        
        public function eliminar_detalle_calendario( $cod_calendario ) {
            $where = array( 'CALE_Codigo'=>$cod_calendario );
            $this->db->where( $where )->delete( $this->tabla );
        }
        
        // funcion para listar los dias laborables
	public function listar_dias_laborables( $codigo_calendario ) {
            // DCAL_Flag=0 (dia laborable)
            $where= array( 'DCAL_Flag'=>'0', 'CALE_Codigo'=>$codigo_calendario, 
                           'DCAL_Fecha >='=>$this->somevar['hoy'] );
            $query = $this->db->where( $where )->get( $this->tabla );
            if ( $query->num_rows > 0 ) {
                foreach( $query->result() as $fila )
                    $data[] = $fila;
                return $data;
            }
            return array();
	}
        
        // funcion para listar todos los dias
        public function listar_dias( $cod_calendario ) {
            $where = array( 'CALE_Codigo'=>$cod_calendario, 'DCAL_Fecha >='=>$this->somevar['hoy'] );
            $query = $this->db->where( $where )->get( $this->tabla );
            if ( $query->num_rows > 0 ) {
                foreach( $query->result() as $fila )
                    $data[] = $fila;
                return $data;
            }
        }
        
    }
    
?>
