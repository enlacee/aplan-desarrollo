<?php
class Configuracionmensaje extends Controller{
	var $somevar;
	public function __construct(){
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('pagination');
		$this->load->library('html');
		$this->load->model('configuracionmps/configuracionmensaje_model');
		$this->load->model('configuracionmps/companiaconfiguracionm_model');
		$this->somevar['compania'] = $this->session->userdata('compania');
	}
	
	public function index(){
		$this->editar_configuracionmps();
	}
	
	public function editar_configuracionmensaje(){
		if(!$this->session->userdata('user')){
            redirect('index/index');
        }
		$configuracionmensaje = $this->configuracionmensaje_model->obtener_configuracionmensaje();
		$this->load->library('layout','layout');
		$data['titulo'] 	= "EDITAR CONFIGURACI&Oacute;N DE MENSAJES";
		$data['modo'] 		= "editar";
		$data['codigo'] 	= $configuracionmensaje[0]->CMEN_Codigo;
		$filter 			= new stdClass();
		$filter->stock_negativo = $configuracionmensaje[0]->CMEN_StockNegativo;
		$filter->posible_rotura = $configuracionmensaje[0]->CMEN_PosibleRoturaStock;
		$filter->inventa_debajo = $configuracionmensaje[0]->CMEN_InveDebajoSotck;
		$filter->lantarde	 	= $configuracionmensaje[0]->CMEN_LanzaTarde;
		$data['configuracionmensaje'] = $filter;
		$this->layout->view('configuracionmps/configuracionmensaje_nuevo',$data);
	}
	
	public function insertar_configuracionmensaje(){
		if(!$this->session->userdata('user')){
            redirect('index/index');
        }
		if(!$_POST){
			redirect('index/inicio');
		}
		$retorno	= '';
		$codigo		= $this->input->post('codigo',TRUE);
		$modo		= $this->input->post('modo',TRUE);
		
		$stock_negativo = $this->input->post('stock_negativo',TRUE);
		$posible_rotura = $this->input->post('posible_rotura',TRUE);
		$inventa_debajo = $this->input->post('inventa_debajo',TRUE);
		$stock_negativo = ($stock_negativo)?'1':'0';
		$lantarde	 	= $this->input->post('lantarde',TRUE);
		if($modo == 'editar'){
			$filter = new stdClass();
			$filter->CMEN_StockNegativo 	= $stock_negativo;
			$filter->CMEN_PosibleRoturaStock= $posible_rotura;
			$filter->CMEN_InveDebajoSotck 	= $inventa_debajo;			
			$filter->CMEN_LanzaTarde		= $lantarde;			
			$retorno = $this->configuracionmensaje_model->editar_configuracionmensaje($codigo,$filter);
		}
		echo $retorno;
	}	
}
?>