<?php
include("system/application/libraries/pchart/pData.php");
include("system/application/libraries/pchart/pChart.php");
class Orden extends Controller{
	var $somevar;
	var $cantidad_disponible 	= 0;
	public function __construct(){
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('pagination');
		$this->load->library('html');
		$this->load->helper('date');
		$this->load->model('compras/orden_model');
		$this->load->model('almacen/producto_model');
		$this->load->model('maestros/establecimiento_model');
		$this->somevar['compania'] 		= $this->session->userdata('compania');
		$this->somevar['hoy']      		= mdate("%Y-%m-%d",time());
	}
	
	public function index(){
		$this->listar_cabeceramps();
	}
	public function listar_orden($tipo_orden="",$j=""){
		if(!$this->session->userdata('user')){
            redirect('index/index');
        }
		$titulo_busqueda = $titulo_tabla = "";
		switch($tipo_orden){
			case '1' :
				$titulo_busqueda 	= "BUSCAR &Oacute;RDENES DE TRABAJO";
				$titulo_tabla 		= "RELACI&Oacute;N DE &Oacute;RDENES DE TRABAJO";
				break;
			case '2' :
				$titulo_busqueda 	= "BUSCAR &Oacute;RDENES DE COMPRA";
				$titulo_tabla 		= "RELACI&Oacute;N DE &Oacute;RDENES DE COMPRA";
				break;
			default :
				exit;
		}
		
		$this->load->library('layout','layout');
		$data['titulo_busqueda'] = $titulo_busqueda;
		$data['registros'] = count($this->orden_model->listar_orden('','',$tipo_orden));
		/**configurar paginacion**/
		$conf['base_url']   = site_url('mps/tablamps/listar_tablamps/'.$tipo_orden.'/');
		$conf['per_page']   = 20;
		$conf['num_links']  = 3;
		$conf['first_link'] = "&lt;&lt;";
		$conf['last_link']  = "&gt;&gt;";
		$conf['total_rows'] = $data['registros'];
		$conf['uri_segment'] = 5;
		$offset             = (int)$this->uri->segment(5);
		/**configurar paginacion**/
		
		$listado_ordenes = $this->orden_model->listar_orden($conf['per_page'],$offset,$tipo_orden);
		$item               = $j+1;
		$lista              = array();
		if(count($listado_ordenes)>0){
			foreach($listado_ordenes as $valor){
				$codigo_orden 	= $valor->ORDE_Codigo;
				$numero_orden 	= $valor->ORDE_Numero;
				$tipo_orden 	= $valor->ORDE_Tipo;
				$fecha_planea	= $valor->OTRA_FechaPlanEmt;
				$fecha_inicio	= $valor->OTRA_FechaIniFabri;
				$fecha_fin		= $valor->OTRA_FechaFinEntre;
				$can_plani		= $valor->OTRA_CantPlanificada;
				$can_pendi		= $valor->OTRA_CantPendiente;
				$producto		= $this->producto_model->obtener_producto($valor->PROD_Codigo);
				$producto		= $producto[0]->PROD_Descripcion;
				$destino		= $this->establecimiento_model->obtener_establecimiento($valor->ESTA_Codigo);
				$destino		= $destino[0]->ESTA_Descripcion;
				$lista[]		= array($item++,$codigo_orden,$numero_orden,$tipo_orden,$fecha_planea,$fecha_inicio,$fecha_fin,$can_plani,$can_pendi,$producto,$destino);
			}
		}
		
		$data['lista'] 			= $lista;
		$data['titulo_tabla'] 	= $titulo_tabla;
		$data['tipo_orden'] 	= $tipo_orden;
		
		$this->pagination->initialize($conf);
		$data['paginacion'] = $this->pagination->create_links();
		$this->layout->view('compras/orden_index',$data);
	}
	
	public function editar_orden($tipo_orden,$codigo_orden){
		$this->load->library('layout','layout');
		
		$data['titulo']	= 'EDITAR ORDEN DE TRABAJO';
		$data['codigo'] = $codigo_orden;
		$data['modo'] 	= 'editar';
		
		$this->layout->view('compras/orden_nuevo',$data);
	}
	
}
?>