<?php
class Compania extends Controller{
	var $somevar;
	public function __construct(){
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('pagination');
		$this->load->library('html');
		$this->load->model('maestros/compania_model');
		$this->load->model('maestros/empresa_model');
		$this->load->model('configuracionmps/plan_model');
		$this->somevar['compania'] 	= $this->session->userdata('compania');
		$this->somevar['user'] 		= $this->session->userdata('user');
	}
	
	public function index(){
		$this->listar_compania();
	}
	
	public function listar_compania($j=""){
		if(!$this->session->userdata('user')){
            redirect('index/index');
        }
		
		$this->load->library('layout','layout');
		$data['titulo_busqueda'] = "BUSCAR COMPA&ntilde;A";
		$data['registros'] = count($this->compania_model->listar_companias());
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
		$listado_companias = $this->compania_model->listar_companias($conf['per_page'],$offset);
		//print_r($listado_companias);exit;
		$item               = $j+1;
		$lista              = array();
		if(count($listado_companias)>0){
			foreach($listado_companias as $value){
				$codigo			= $value->COMP_Codigo;
				$nombre			= $value->COMP_Nombre;
				$empresa        = $value->EMPR_Codigo;
				$datos_empresa  = $this->empresa_model->obtener_datosEmpresa($empresa);
				$razon_social   = $datos_empresa[0]->EMPR_RazonSocial;
				$codigo_interno	= $datos_empresa[0]->EMPR_CodigoInterno;
				$lista[]		= array($item++,$codigo,$codigo_interno,$razon_social);
			}
		}
		$data['lista'] = $lista;
		$data['titulo_tabla'] = 'RELACI&Oacute;N de COMPA&Ntilde;IAS';
		$data['titulo'] = "NUEVO PLAN";
		
		$this->pagination->initialize($conf);
		$data['paginacion'] = $this->pagination->create_links();
		$this->layout->view('maestros/compania_index',$data);
	}
	
	public function nuevo_compania(){
		if(!$this->session->userdata('user')){
            redirect('index/index');
        }
		$this->load->library('layout','layout');
		$data['titulo'] 	= "NUEVA COMPA&Ntilde;IA";
		$data['modo'] 		= "insertar";
		$data['codigo'] 	= "";
		
		$this->layout->view('maestros/compania_nuevo',$data);
	}
	
	public function editar_compania($cod_compania){
		if(!$this->session->userdata('user')){
            redirect('index/index');
        }
		$compania = $this->compania_model->obtener_compania($cod_compania);
		// para validar si se quiere editar una COMPAÑIA PADRE
		if(count($compania) == 0){
			redirect('maestros/compania/listar_compania');
		}
		$this->load->library('layout','layout');
		$data['titulo'] 	= "EDITAR PLAN";
		$data['modo'] 		= "editar";
		$data['codigo'] 	= $compania[0]->COMP_Codigo;
		$empresa        	= $compania[0]->EMPR_Codigo;
		$datos_empresa  	= $this->empresa_model->obtener_datosEmpresa($empresa);
		$filter 			= new stdClass();
		$filter->interno	= $datos_empresa[0]->EMPR_CodigoInterno;
		$filter->ruc 		= $datos_empresa[0]->EMPR_Ruc;
		$filter->razon		= $datos_empresa[0]->EMPR_RazonSocial;
		$data['compania']	= $filter;
		$this->layout->view('maestros/compania_nuevo',$data);
	}
	
	public function insertar_compania(){		
		if(!$this->session->userdata('user')){
            redirect('index/index');
        }
		if(!$_POST){
			redirect('maestros/compania/listar_compania');
		}
		
		$codigo = $this->input->post('codigo',TRUE);
		
		//$ruc		= $this->input->post('ruc',TRUE);
		$razon		= $this->input->post('razon',TRUE);
		$interno	= $this->input->post('interno',TRUE);
		$modo		= $this->input->post('modo',TRUE);
		
		$filter 					=new stdClass();
		$filter->EMPR_RazonSocial	= strtoupper($razon);
		$filter->EMPR_CodigoInterno	= strtoupper($interno);
		
		if($modo == 'insertar'){
			// inserta su compañia
			$array = $this->compania_model->insertar_compania($filter);
			
			// inserta su plan 
			$filter 					= new stdClass();
			//$filter->COMP_CodigoInterno = strtoupper($cod_interno);
			$filter->COMP_Nombre		= strtoupper('ESCENARIO PRINCIPAL');
			$filter->COMP_Flag			= '1';
			$filterUC					= new stdClass();
			$filterUC->USUA_Codigo		= $this->somevar['user'];
			$codigo = $this->plan_model->insertar_plan($filter,$filterUC,'1',$array[0],$array[1]);
		}else if($modo == 'editar'){
			$this->compania_model->modificar_compania($filter,$codigo);
		}		
		echo $codigo;
	}
	
	public function eliminar_compania(){
		if(!$this->session->userdata('user')){
            redirect('index/index');
        }
		if(!$_POST){
			redirect('maestros/compania/listar_compania');
		}
		
		$codigo = $this->input->post('codigo',TRUE);
		$this->compania_model->eliminar_compania($codigo);
		
	}
	
}
?>