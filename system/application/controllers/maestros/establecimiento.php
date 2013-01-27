<?php
class Establecimiento extends Controller{
	public function __construct(){
		parent::Controller();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('pagination');
		$this->load->library('html');
		$this->load->library('layout','layout');
		$this->load->model('maestros/establecimiento_model');
	}
	public function index(){
		$this->ver_establecimientos();
	}
	
	public function ver_establecimientos(){
		if(!$this->session->userdata('user')){
            redirect('index/index');
        }
		$this->load->library('layout','layout');
		
		$data['titulo']		= 'ESTABLECIMIENTOS';
		
		$establecimientos 	= $this->establecimiento_model->listar_establecimiento('5','');
		$lista 				= array();
		
		if(count($establecimientos) > 0){
			foreach($establecimientos as $value){
				$obj		= new stdClass();
				$obj->codigo			= $value->ESTA_Codigo;
				$obj->codigo_interno	= $value->ESTA_CodigoInterno;
				$obj->descripcion		= $value->ESTA_Descripcion;
				$lista[]				= $obj;
			}
		}
		
		$data['lista'] = $lista;
		
		$this->layout->view('maestros/establecimiento_ver_grafico',$data);
	}
	
	public function ver_detalle_establecimiento($establecimiento){
		if(!$this->session->userdata('user')){
            redirect('index/index');
        }
		
		$data['titulo']			= 'DETALLE DE ESTABLECIMIENTO';
		
		$datos_establecimiento 	= $this->establecimiento_model->obtener_establecimiento($establecimiento);
		$obj 			= new stdClass();
		$obj->codigo	=$datos_establecimiento[0]->ESTA_Codigo;
		$obj->codigo_interno	=$datos_establecimiento[0]->ESTA_CodigoInterno;
		$obj->descripcion	=$datos_establecimiento[0]->ESTA_Descripcion;
		$obj->direccion	=$datos_establecimiento[0]->ESTA_Direccion;
		$obj->telefono	=$datos_establecimiento[0]->ESTA_Telefono 	;
		
		$data['establecimiento'] = $obj;
		
		$this->load->view('maestros/establecimiento_ver_detalle_pop',$data);
	}
	
}
?>