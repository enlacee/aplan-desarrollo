<?php

    class Plan_Model extends Model{
        
        protected $_name = "cji_compania";
        
        public function  __construct(){
            parent::__construct();
            $this->load->model( 'configuracionmps/detallecalendario_model' );
            $this->load->model( 'configuracionmps/configuracionmps_model' );
            $this->load->model( 'configuracionmps/companiaconfiguracionmps_model' );
            $this->load->model( 'configuracionmps/configuracionmensaje_model' );
            $this->load->model( 'configuracionmps/companiaconfiguracionm_model' );
            $this->load->model( 'configuracion/configuracionsistema_model' );
            $this->load->model( 'configuracion/companiaconfiguracions_model' );
            $this->load->model( 'maestros/usuariocompania_model' );
            $this->somevar['compania']      = $this->session->userdata( 'compania' );
            $this->somevar['empresa']       = $this->session->userdata( 'empresa' );
            $this->somevar['compania_hija'] = $this->session->userdata( 'compania_hija' );
        }
        
        public function insertar_plan( $filter, $filterUC, $tipo_ingreso='', $empresa='', $compania='' ) {
            $this->db->trans_begin();
            if ( $tipo_ingreso == '' ) {
                $filter->EMPR_Codigo    = $this->somevar['empresa'];
                $filter->COMP_Codigo2   = $this->somevar['compania'];
            } elseif ( $tipo_ingreso == '1' ) {
                $filter->EMPR_Codigo    = $empresa;
                $filter->COMP_Codigo2   = $compania;
            }
            
            $this->db->insert( $this->_name, $filter );
            $cod_plan = $this->db->insert_id();
            
            // insertar en la tabla usuario_compania
            $filterUC->COMP_Codigo = $cod_plan;
            $this->usuariocompania_model->insertar_usuariocompania( $filterUC );
            
            // insertar una configuracionmps por default
            $filterCM                   = new stdClass();
            $filterCM->CONM_Deciamles   = 2;
            $filterCM->CONM_Hora        = '11:00:00';
            $filterCM->CONM_Horizonte   = '2012-07-31';
            $filterCM->CONM_Flag        = '1';
            $this->configuracionmps_model->insertar_configuracionmps( $filterCM );
            
            // insertar la companiaconfiguracionmps
            $cod_configuracion      = $this->db->insert_id();
            $filterDC               = new stdClass();
            $filterDC->COMP_Codigo  = $cod_plan;
            $filterDC->CONM_Codigo  = $cod_configuracion;
            $this->companiaconfiguracionmps_model->insertar_companiaconfiguracionmps( $filterDC );
            
            // insertar una configuracionsistema por default
            $filterCS                   = new stdClass();
            $filterCS->CONS_Decimales   = 2;
            $filterCS->CONS_Estado      = 1;
            $filterCS->CONS_Flag        = 1;
            $this->configuracionsistema_model->insertar_configuracion( $filterCS );
            
            // insertar una companiaconfiguracionmps por default
            $cod_configuracions = $this->db->insert_id();
            $filterCC                   = new stdClass();
            $filterCC->COMP_Codigo      = $cod_plan;
            $filterCC->CONS_Codigo      = $cod_configuracions;
            $this->companiaconfiguracions_model->insertar_companiaconfiguracions( $filterCC );
            
            // inserta una comfiguracionmensaje por default
            $filterCME                          = new stdClass();
            $filterCME->CMEN_StockNegativo      = 0;
            $filterCME->CMEN_PosibleRoturaStock = 10;
            $filterCME->CMEN_InveDebajoSotck    = 10;
            $filterCME->CMEN_LanzaTarde         = 5;
            $filterCME->CMEN_Flag               = 1;
            $filterCME->CMEN_Estado             = 1;
            $this->configuracionmensaje_model->insertar_configuracionmensaje( $filterCME );
            
            // inserta una companiacomfiguracionm por default
            $cod_configuracionm = $this->db->insert_id();
            $filterCCM                          = new stdClass();
            $filterCCM->CMEN_Codigo             = $cod_configuracionm;
            $filterCCM->COMP_Codigo             = $cod_plan;
            $this->companiaconfiguracionm_model->insertar_companiaconfiguracionm( $filterCCM );
            
            if ( $this->db->trans_status() === FALSE )
                $this->db->trans_rollback();
            else
                $this->db->trans_commit();
            
            return $cod_plan;
        }
        
        public function modificar_plan( $filter, $cod_plan ) {
            $this->db->trans_begin();
            //$filter->EMPR_Codigo = $this->somevar['empresa'];
            $where = array( 'COMP_Codigo'=>$cod_plan );
            $this->db->where( $where )->update( $this->_name, $filter );
            if ( $this->db->trans_status() === FALSE )
                $this->db->trans_rollback();
            else
                $this->db->trans_commit();
        }
        
        public function obtener_plan($cod_plan){
            $where = array( 'COMP_Codigo'=>$cod_plan, 'COMP_Codigo2 !='=>'0' );
            $query = $this->db->where( $where )->get( $this->_name, 1 );
            if ( $query->num_rows > 0 ) {
                foreach( $query->result() as $fila )
                    $data[] = $fila;
                return $data;
            }
        }
        
        public function listar_plan( $number_items='', $offset='' ) {
            $where = array( 'COMP_Estado'=>'1', 'COMP_Codigo2'=>$this->somevar['compania'] );
            //$query = $this->db->where($where)->order_by('COMP_Codigo','desc')->get($this->_name,$number_items,$offset);
            $query = $this->db->where( $where )->order_by( 'COMP_Codigo', 'desc' )
                                               ->get( $this->_name, $number_items, $offset );
            if ( $query->num_rows > 0 ) {
                foreach( $query->result() as $fila )
                    $data[] = $fila;
                return $data;
            }
        }
        
        public function eliminar_plan( $cod_plan ) {
            $where                  = array( 'COMP_Codigo'=>$cod_plan );
            $filter                 = new stdClass();
            $filter->COMP_Estado    = 0;
            $this->db->where( $where )->update( $this->_name, $filter );
        }
	
        public function esprincipal() {
            $retorno = false;
            $where = array( 'COMP_Estado'=>'1', 'COMP_Flag'=>'1', 'COMP_Codigo2'=>$this->somevar['compania'] );
            $query = $this->db->where( $where )->get( $this->_name );
            if ( $query->num_rows > 0 )
                $retorno = true;
            return $retorno;
        }
        
    }
    
?>
