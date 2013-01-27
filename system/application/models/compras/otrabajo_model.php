<?php

    class Otrabajo_Model extends Model {
        
        protected $_name='cji_otrabajo';
        
        function __construct(){
            parent :: __construct();
            $this->somevar['compania_hija'] = $this->session->userdata( 'compania_hija' );
        }
        
        public function insertar_otrabajo( $data_ot ) {
            //$this->db->trans_begin();
            $data                           = new StdClass();
            $data->COMP_Codigo              = $this->somevar['compania_hija'];
            $data->ORDE_Codigo              = $data_ot->cod_orden;
            $data->ESTA_Codigo              = $data_ot->cod_ubicacion;
            $data->PROD_Codigo              = $data_ot->cod_producto;
            $data->OTRA_CantPlanificada     = $data_ot->cant_plani;
            $data->OTRA_CantPendiente       = $data_ot->cant_pendi;
            $data->OTRA_Estado              = $data_ot->estado;
            $data->OTRA_FechaPlanEmt        = $data_ot->fech_plani_ent;
            $data->OTRA_FechaIniFabri       = $data_ot->fech_ini_fabri;
            $data->OTRA_FechaFinEntre       = $data_ot->fech_fin_entre;
            $this->db->insert( $this->_name, $data );
        }
        
        public function actualizar_otrabajo() {
            $where                          = array( 'OTRA_Flag'=>'0' );
            $data                           = array( 'OTRA_Flag'=>'1' );
            $this->db->where( $where )->update( $this->_name, $data );
        }
        
        public function eliminar_otrabajo() {
            $this->db->where( 'OTRA_Flag', '0' )->delete( $this->_name );
        }
        
        public function obtener_otrabajo( $codigo_orden ) {
            $retorno = array();
            $where = array( 'ORDE_Codigo' => $codigo_orden );
            $query = $this->db->where( $where )->get( $this->_name, 1 );
            if ( $query->num_rows > 0 )
                $retorno = $query->result();
            return $retorno;
        }
	
        public function limpiar_otrabajo() {
            $this->db->empty_table( $this->_name );
        }
        
    }
    
?>
