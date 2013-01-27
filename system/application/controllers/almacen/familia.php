<?php
class Familia extends Controller{
	
    public function __construct(){
		parent::Controller();
		$this->load->helper('form');
		$this->load->helper('date');
		$this->load->library('html');
		$this->load->library('pagination');
		$this->load->library('layout','layout');
		$this->load->model('almacen/familia_model');
		$this->somevar ['compania'] = $this->session->userdata('compania');
		$this->somevar['hoy']       = mdate("%Y-%m-%d %h:%i:%s",time());
    }
	
	public function index(){
		$this->listar_producto();
	}
	
	public function seleccionar_familia(){
		
		if(!$this->session->userdata('user')){
            redirect('index/index');
        }
		$this->load->library('layout','layout');
		$data['titulo'] 	= "SELECCIONAR FAMILIA";
		$data['modo'] 		= "seleccionar";
		$data['codigo'] 	= "";
		
		$familias = $this->familia_model->listar_familia_x_padre(0);
		$array_familias = array();
		foreach($familias as $value){
			$codigo 	 = $value->FAMI_Codigo;
			$descripcion = $value->FAMI_Descripcion;
			$array_familias[] = array($codigo,$descripcion);
		}
		$data['familias'] 	= $array_familias;
		
		$this->load->view('almacen/familia_seleccionar_ventana',$data);
	}
	
	public function buscar_familias_hijas($cod_padre){
		if(!$this->session->userdata('user')){
            redirect('index/index');
        }
		$familias = $this->familia_model->listar_familia_x_padre($cod_padre);
		$array_familias = array();
		foreach($familias as $value){
			$codigo 	 = $value->FAMI_Codigo;
			$descripcion = $value->FAMI_Descripcion;
			$array_familias[] = array($codigo,$descripcion);
		}
	}
	
}       
?>