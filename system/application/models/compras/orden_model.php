<?php

    class Orden_Model extends Model {
        
        protected $_name = 'cji_orden';
        
        function __construct() {
            parent :: __construct();
            $this->load->library( 'compartido' );
            $this->load->model( 'compras/otrabajo_model' );
            $this->load->model( 'compras/ocompra_model' );
            $this->somevar['compania_hija'] = $this->session->userdata( 'compania_hija' );
        }
        
        //1 = O. Trabajo, 2 = O. Compra
        public function listar_orden( $number_items='',$offset='',$tipo_orden ) {
            $retorno = array();
            switch($tipo_orden){
                case '1' :  $retorno = $this->listar_otrabajo( $number_items, $offset, $tipo_orden );
                            break;
                case '2' :  $retorno = $this->listar_ocompra( $number_items, $offset, $tipo_orden );
                            break;
                default  :  exit;
            }
            return $retorno;
        }
        
        private function listar_ocompra( $number_items='', $offset='' ) {
            //falta el metodo
        }
        
	private function listar_otrabajo( $number_items='', $offset='', $tipo_orden ) {
            $compartido     = $this->compartido->buscar_compartidos( 3 );   // en duro
            $where          = array( 'o.ORDE_Tipo'=>$tipo_orden );
            $this->db->select( '*' );
            $this->db->from( 'cji_orden o' );
            $this->db->join( 'cji_otrabajo ot', 'o.ORDE_Codigo = ot.ORDE_Codigo' );
            $query          = $this->db->where_in( 'COMP_Codigo',$compartido )
                                       ->where( $where )
                                       ->order_by( 'o.ORDE_Codigo', 'asc' )
                                       ->get( '', $number_items, $offset );
            if ( $query->num_rows > 0 ) {
                foreach( $query->result() as $fila )
                    $data[] = $fila;
                return $data;
            }
        }
        
        public function obtener_orden( $codigo_orden ) {
            $where = array( 'ORDE_Codigo'=>$codigo_orden );
            $this->where( $where )->get( $this->_name );
            return $retorno;
        }
        
        // primer parametro => codigo producto
	// segundo parametro => fecha de la orden, esto depende del tipo de ORDEN(2=OTRA_FechaIniFabri)
	// tercer parametro => tipo de orden (1=OT, 2=OC)
	// cuarto parametro => estado de orden (1=En proceso, 2= Planificada, 3= Confirmada)
	public function buscar_orden( $codigo_producto=NULL, $fecha=NULL, $tipo_orden, $estado=NULL ) {
            $retorno = array();
            switch ( $tipo_orden ) {
                case '1' :  $retorno = $this->buscar_otrabajo( $codigo_producto, $fecha, $tipo_orden, $estado );
                            break;
                case '2' :  $retorno = $this->buscar_ocompra( $codigo_producto, $fecha, $tipo_orden, $estado );
                            break;
                default  :  exit;
            }
            return $retorno;
        }
        
        private function buscar_ocompra( $codigo_producto=NULL, $fecha=NULL, $tipo_orden, $estado=NULL ) {
            //falta el metodo
        }
        
        private function buscar_otrabajo( $codigo_producto=NULL, $fecha=NULL, $tipo_orden, $estado=NULL ) {
            $arr_general = array( 'o.ORDE_Tipo'=>$tipo_orden );
            
            // array para la fecha de ORDEN
            $arr_f = array();
            if ( $fecha != NULL )
                $arr_f = array( 'ot.OTRA_FechaIniFabri'=>$fecha );
            
            // array para el codigo de PRODUCTO
            $arr_p = array();
            if ( $codigo_producto != NULL )
                $arr_p = array( 'ot.PROD_Codigo'=>$codigo_producto );
            
            // array para el estado de ORDEN
            $arr_e = array();
            if ( $estado != NULL )
                $arr_e = array( 'o.ORDE_Estado'=>$estado );
            
            $where = $arr_f + $arr_p + $arr_e + $arr_general;
            
            $this->db->select( '*' );
            $this->db->from( 'cji_orden o' );
            $this->db->join( 'cji_otrabajo ot', 'o.ORDE_Codigo = ot.ORDE_Codigo' );
            $query = $this->db->where( $where )->order_by( 'o.ORDE_Codigo', 'asc' )->get( '', 1 );
            if ( $query->num_rows > 0 ) {
                foreach( $query->result() as $fila )
                    $data[] = $fila;
                return $data;
            }
        }
        
        public function insertar_orden( $filter ) {
            $this->db->trans_begin();
            
            $data                           = new StdClass();
            $data->ORDE_Numero              = $filter->numero;
            $data->ORDE_Tipo                = $filter->tipo;
            $data->ORDE_Estado              = $filter->estado;
            // $data->COMP_Codigo           = $this->somevar['compania_hija'];
            $this->db->insert( $this->_name, $data );
            $cod_orden = $this->db->insert_id();
            if ( $filter->tipo == 1 ) {
                //insertamos orden de trabajo/fabricacion
                $data_ot                    = new StdClass();
                $data_ot->cod_orden         = $cod_orden;
                $data_ot->cod_producto      = $filter->cod_producto;
                $data_ot->cod_ubicacion     = $filter->cod_ubicacion;
                $data_ot->cant_plani        = $filter->cant_plani;
                $data_ot->cant_pendi        = $filter->cant_pendi;
                $data_ot->estado            = $filter->estado;
                $data_ot->fech_plani_ent    = $filter->fech_plani_ent;
                $data_ot->fech_ini_fabri    = $filter->fech_ini_fabri;
                $data_ot->fech_fin_entre    = $filter->fech_fin_entre;
                $this->otrabajo_model->insertar_otrabajo( $data_ot );
            } elseif ( $filter->tipo == 2 ) {
                //insertamos orden de compra
                $data_oc                    = new StdClass();
                $data_oc->cod_orden         = $cod_orden;
                $data_oc->cod_producto      = $filter->cod_producto;
                $data_oc->cod_proveedor     = $filter->cod_proveedor;
                $data_oc->cant_plani        = $filter->cant_plani;
                $data_oc->cant_pendi        = $filter->cant_pendi;
                $data_oc->estado            = $filter->estado;
                $data_oc->fech_plani_ent    = $filter->fech_plani_ent;
                $data_oc->fech_ini_fabri    = $filter->fech_colocacion;
                $data_oc->fech_fin_entre    = $filter->fech_fin_entre;
                $this->ocompra_model->insertar_ocompra( $data_oc );
            }
            
            if ( $this->db->trans_status() === FALSE )
                $this->db->trans_rollback();
            else
                $this->db->trans_commit();
        }
        
        public function actualizar_orden( $tipo ) {
            $this->db->trans_begin();
            
            $where = array( 'ORDE_Estado'=>'0' );
            $data = array( 'ORDE_Estado'=>'1' );
            $this->db->where( $where )->update( $this->_name, $data );
            if ( $tipo == 1 ) {
                //acutalizar orden de trabajo/fabricacion
                $this->otrabajo_model->actualizar_otrabajo();
            } elseif ( $tipo == 2 ) {
                //acutalizar orden de compra
                $this->ocompra_model->actualizar_ocompra();
            }
            
            if ( $this->db->trans_status() === FALSE )
                $this->db->trans_rollback();
            else
                $this->db->trans_commit();
	}
        
        public function eliminar_orden( $tipo ) {
            $this->db->trans_begin();
            
            //primero elimina las hijas
            if ( $tipo == 1 ) {
                //elimino orden de trabajo/fabricacion
                $this->otrabajo_model->eliminar_otrabajo();
            } elseif ( $tipo == 2 ) {
                //elimino orden de compra
                $this->ocompra_model->eliminar_ocompra();
            }
            
            $where = array( 'ORDE_Flag'=>'0', 'ORDE_Tipo'=>$tipo );
            $this->db->where( $where )->delete( $this->_name );
            if ( $this->db->trans_status() === FALSE )
                $this->db->trans_rollback();
            else
                $this->db->trans_commit();
        }
        
        public function limpiar_orden() {
            $this->db->empty_table( $this->_name );
        }
        
    }
    
?>
