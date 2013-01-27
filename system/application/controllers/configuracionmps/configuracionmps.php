<?php
class Configuracionmps extends Controller{
	var $somevar;
	public function __construct(){
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('pagination');
		$this->load->library('html');
		$this->load->model('maestros/compania_model');
		$this->load->model('configuracionmps/configuracionmps_model');
		$this->load->model('configuracionmps/companiaconfiguracionmps_model');
		$this->somevar['compania'] = $this->session->userdata('compania');
	}
	
	public function index(){
		$this->editar_configuracionmps();
	}
	
	public function editar_configuracionmps(){
		if(!$this->session->userdata('user')){
            redirect('index/index');
        }
		$configuracionmps = $this->configuracionmps_model->obtener_configuracionmps();
		$this->load->library('layout','layout');
		$data['titulo'] 	= "EDITAR CONFIGURACION DE PROGRAMACI&Oacute;N";
		$data['modo'] 		= "editar";
		$data['codigo'] 	= $configuracionmps[0]->CONM_Codigo;
		$data['array_seleccion'] = array('0'=>'Seleccione','1'=>'TODOS','2'=>'POR SKU','3'=>'POR FAMILIA','4'=>'POR RANGO');
		$filter 			= new stdClass();
		$filter->hora 		= $configuracionmps[0]->CONM_Hora;
		$filter->seleccion 	= $configuracionmps[0]->CONM_Seleccion;
		$filter->horizonte 	= substr($configuracionmps[0]->CONM_Horizonte, 8, 2) . '/' . substr($configuracionmps[0]->CONM_Horizonte, 5, 2) . '/' . substr($configuracionmps[0]->CONM_Horizonte, 0, 4);
		$filter->hora 		= $configuracionmps[0]->CONM_Hora;
		$comboEscenario 	= $this->compania_model->comboEscenarios($configuracionmps[0]->CONM_Escenario);
		$filter->escenario	= $comboEscenario;
		$data['configuracionmps'] = $filter;
		$this->layout->view('configuracionmps/configuracionmps_nuevo',$data);
	}
	
	public function insertar_configuracionmps(){
		if(!$this->session->userdata('user')){
            redirect('index/index');
        }
		if(!$_POST){
			redirect('index/inicio');
		}
		$retorno	= '';
		$codigo		= $this->input->post('codigo',TRUE);
		$modo		= $this->input->post('modo',TRUE);
		
		$hora		= $this->input->post('hora',TRUE);
		$seleccion	= $this->input->post('seleccion',TRUE);
		$horizonte	= $this->input->post('horizonte',TRUE);
		$escenario	= $this->input->post('cboEscenarios',TRUE);
		if($modo == 'editar'){
			$filter = new stdClass();
			$filter->CONM_Codigo  	= $codigo;
			$filter->CONM_Hora  	= $hora;
			$filter->CONM_Seleccion = $seleccion;
			$filter->CONM_Horizonte = substr($horizonte, 6, 4) . '-' . substr($horizonte, 3, 2) . '-' . substr($horizonte, 0, 2);
			$filter->CONM_Escenario = $escenario;
			$retorno = $this->configuracionmps_model->editar_configuracionmps($filter);
		}
		echo $retorno;
	}	
}
?>