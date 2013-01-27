<?php
class Plan extends Controller{
	var $somevar;
	public function __construct(){
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('pagination');
		$this->load->library('html');
		$this->load->model('configuracionmps/plan_model');
		$this->load->model('seguridad/rol_model');
		$this->somevar['compania'] 	= $this->session->userdata('compania');
		$this->somevar['user'] 		= $this->session->userdata('user');
	}
	
	public function index(){
		$this->listar_plan();
	}
	
	public function listar_plan($j=""){
		if(!$this->session->userdata('user')){
            redirect('index/index');
        }
		
		$this->load->library('layout','layout');
		$data['titulo_busqueda'] = "BUSCAR PLAN";
		$data['registros'] = count($this->plan_model->listar_plan());
		/**configurar paginacion**/
		$conf['base_url']   = site_url('configuracionmps/plan/listar_plan/');
		$conf['per_page']   = 10;
		$conf['num_links']  = 3;
		$conf['first_link'] = "&lt;&lt;";
		$conf['last_link']  = "&gt;&gt;";
		$conf['total_rows'] = $data['registros'];
		$conf['uri_segment'] = 4;
		$offset             = (int)$this->uri->segment(4);
		/**configurar paginacion**/
		$listado_plan = $this->plan_model->listar_plan($conf['per_page'],$offset);
		$item               = $j+1;
		$lista              = array();
		if(count($listado_plan)>0){
			foreach($listado_plan as $value){
				$codigo			= $value->COMP_Codigo;
				$codigo_interno	= $value->COMP_CodigoInterno;
				$nombre			= $value->COMP_Nombre;
				$principal		= $value->COMP_Flag;
				$lista[]		= array($item++,$codigo,$codigo_interno,$nombre,$principal);
			}
		}
		$data['lista'] = $lista;
		$data['titulo_tabla'] = 'RELACI&Oacute;N de PLANES';
		$data['titulo'] = "NUEVO PLAN";
		
		$this->pagination->initialize($conf);
		$data['paginacion'] = $this->pagination->create_links();
		$this->layout->view('configuracionmps/plan_index',$data);
	}
	
	public function nuevo_plan(){
		if(!$this->session->userdata('user')){
            redirect('index/index');
        }
		$this->load->library('layout','layout');
		$esprincipal 		= $this->plan_model->esprincipal();
		$data['titulo'] 	= "NUEVO PLAN";
		$data['modo'] 		= "insertar";
		$data['codigo'] 	= "";
		$data['esprincipal']= $esprincipal;
		
		$this->layout->view('configuracionmps/plan_nuevo',$data);
	}
	
	public function editar_plan($cod_plan){
		if(!$this->session->userdata('user')){
            redirect('index/index');
        }
		$plan = $this->plan_model->obtener_plan($cod_plan);
		// para validar si se quiere editar una COMPAÑIA PADRE
		if(count($plan) == 0){
			redirect('configuracionmps/plan/index');
		}
		$this->load->library('layout','layout');
		$data['titulo'] 	= "EDITAR PLAN";
		$data['modo'] 		= "editar";
		$data['codigo'] 	= $plan[0]->COMP_Codigo;
		$filter 			= new stdClass();
		$filter->codigo		= $plan[0]->COMP_CodigoInterno;
		$filter->nombre 	= $plan[0]->COMP_Nombre;
		$filter->esprincipal= $plan[0]->COMP_Flag;
		$data['plan'] 		= $filter;
		$this->layout->view('configuracionmps/plan_nuevo',$data);
	}
	
	public function insertar_plan(){
		if(!$this->session->userdata('user')){
            redirect('index/index');
        }
		if(!$_POST){
			redirect('configuracionmps/plan/index');
		}
		$cod_interno= $this->input->post('codigointerno',TRUE);
		$codigo		= $this->input->post('codigo',TRUE);
		$nombre		= $this->input->post('nombre',TRUE);
		$tipo		= $this->input->post('cboTipo',TRUE);
		$modo		= $this->input->post('modo',TRUE);
		
		$filter 					= new stdClass();
		$filter->COMP_CodigoInterno = strtoupper($cod_interno);
		$filter->COMP_Nombre		= strtoupper($nombre);
		$filter->COMP_Flag			= $tipo;
		$filterUC					= new stdClass();
		$filterUC->USUA_Codigo		= $this->somevar['user'];
		if($modo == 'insertar'){
			$codigo = $this->plan_model->insertar_plan($filter,$filterUC);
		}else if($modo == 'editar'){
			$this->plan_model->modificar_plan($filter,$codigo);
		}		
		echo $codigo;
	}	
}
?>