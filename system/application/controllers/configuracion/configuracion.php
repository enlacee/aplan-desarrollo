<?php

    class Configuracion extends Controller {
        
        var $somevar;
        
        public function __construct() {
            parent :: __construct();
            $this->load->helper( 'form' );
            $this->load->library( 'form_validation' );
            $this->load->library( 'pagination' );
            $this->load->library( 'html' );
            $this->load->model( 'configuracion/configuracionsistema_model' );
            $this->load->model( 'configuracion/companiaconfiguracions_model' );
            $this->somevar['compania'] = $this->session->userdata( 'compania' );
        }
        
        public function index() {
            $this->editar_configuracion();
        }
        
        public function editar_configuracion() {
            if ( ! $this->session->userdata('user') )
                redirect( 'index/index' );
        
            $this->load->library( 'layout', 'layout' );
            $configuracion          = $this->configuracionsistema_model->obtener_configuracion();
            $data['titulo']         = 'EDITAR CONFIGURACION DEL SISTEMA';
            $data['modo']           = 'editar';
            $data['codigo']         = $configuracion[0]->CONS_Codigo;
            
            $filter                 = new stdClass();
            $filter->negativo       = $configuracion[0]->CONS_FlagStockNegativoPlanificacion;
            $filter->decimales      = $configuracion[0]->CONS_Decimales;
            $filter->calendario     = $configuracion[0]->CONS_Calendario;
            $filter->mensajes       = $configuracion[0]->CONS_Mensajes;
            $filter->programacion   = 0;
            
            $data['configuracion']  = $filter;
            $this->layout->view( 'configuracion/configuracion_nuevo', $data );
        }
        
        public function insertar_configuracion() {
            if ( ! $this->session->userdata('user') )
                redirect( 'index/index' );
            
            if ( ! $_POST )
                redirect( 'index/index' );
            
            $retorno    = '';
            $codigo     = $this->input->post( 'codigo', TRUE );
            $modo       = $this->input->post( 'modo', TRUE );
            
            $decimales	= $this->input->post( 'decimales', TRUE );
            
            $calendario = $this->input->post( 'calendario', TRUE );
            $mensajes   = $this->input->post( 'mensajes', TRUE );
            $progra     = $this->input->post( 'programacion', TRUE );
            $negativo   = $this->input->post( 'negativo', TRUE );
            
            $calendario = $calendario ? '1' : '0';
            $mensajes   = $mensajes ? '1' : '0';
            $progra     = $progra ? '1' : '0';
            $negativo   = $negativo ? '1' : '0';
            
            if ( $modo == 'editar' ) {
                $filter                                      = new stdClass();
                $filter->CONS_FlagStockNegativoPlanificacion = $negativo;
                $filter->CONS_Decimales                      = $decimales;
                $filter->CONS_Calendario                     = $calendario;
                $filter->CONS_Mensajes                       = $mensajes;
                $retorno    = $this->configuracionsistema_model->modificar_configuracion( $filter, $codigo );
            }
            echo $retorno;
        }
        
    }

?>
