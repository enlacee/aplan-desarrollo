<?php

    class Ocompra_Model extends Model {
        
        protected $tabla='cji_ocompra';
        
        function __construct() {
            parent :: __construct();
            $this->somevar['compania_hija'] = $this->session->userdata( 'compania_hija' );
        }
        
        public function insertar_ocompra( $data_oc ) {
            //$this->db->trans_begin();
            $data                           = new StdClass();
            $data->COMP_Codigo              = $this->somevar['compania_hija'];
            $data->ORDE_Codigo              = $data_oc->cod_orden;
            $data->PROV_Codigo              = $data_oc->cod_proveedor;
            $data->PROD_Codigo              = $data_oc->cod_producto;
            $data->OCOM_CantPlanificada     = $data_oc->cant_plani;
            $data->OCOM_CantPendiente       = $data_oc->cant_pendi;
            $data->OCOM_Estado              = $data_oc->estado;
            $data->OCOM_FechaPlanEmt        = $data_oc->fech_plani_ent;
            $data->OCOM_FechaColocacion     = $data_oc->fech_colocacion;
            $data->OCOM_FechaFinEntre       = $data_oc->fech_fin_entre;
            $this->db->insert( $this->tabla, $data );
        }
        
        public function actualizar_ocompra() {
            $where                          = array( 'OCOM_Flag'=>'0' );
            $data                           = array( 'OCOM_Flag'=>'1' );
            $this->db->where( $where )->update( $this->tabla, $data );
        }
        
        public function eliminar_ocompra() {
            $this->db->where( 'OCOM_Flag', '0' )->delete( $this->tabla );
        }
        
        public function limpiar_ocompra() {
            $this->db->empty_table( $this->tabla );
        }
        
    }
    
?>
