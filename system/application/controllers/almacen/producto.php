<?php
include("system/application/libraries/pchart/pData.php");
include("system/application/libraries/pchart/pChart.php");
class Producto extends Controller{
	
    public function __construct(){
		parent::Controller();
		$this->load->helper('form');
		$this->load->helper('date');
		$this->load->library('html');
		$this->load->library('pagination');
		$this->load->library('layout','layout');
		$this->load->model('almacen/producto_model');
		$this->somevar ['compania'] = $this->session->userdata('compania');
		$this->somevar['hoy']       = mdate("%Y-%m-%d %h:%i:%s",time());
    }
	
	public function index(){
		$this->listar_producto();
	}
	
	public function listar_producto($j=""){
		if(!$this->session->userdata('user')){
            redirect('index/index');
        }
		$this->load->library('layout','layout');
		$data['titulo_busqueda'] = "BUSCAR PRODUCTOS";
		$data['registros'] 	= count($this->producto_model->listar_producto());
		/**configurar paginacion**/
		$conf['base_url']   = site_url('almacen/producto/listar_calendario/');
		$conf['per_page']   = 20;
		$conf['num_links']  = 3;
		$conf['first_link'] = "&lt;&lt;";
		$conf['last_link']  = "&gt;&gt;";
		$conf['total_rows'] = $data['registros'];
		$conf['uri_segment']= 4;
		$offset             = (int)$this->uri->segment(4);
		/**configurar paginacion**/
		$listado_productos = $this->producto_model->listar_producto($conf['per_page'],$offset);
		$item               = $j+1;
		$lista              = array();
		if(count($listado_productos)>0){
			foreach($listado_productos as $valor){
				$codigo			= $valor->PROD_Codigo;
				$descripcion	= $valor->PROD_Descripcion;
				$tipo_producto	= $valor->PROD_TipoProducto;
				$tipo_plani		= $valor->PROD_TipoPlanificacion;
				$zona1			= $valor->PROD_DiasZonaCongelada;
				$sona2			= $valor->PROD_DiasZonaProgMaestra;
				$regla_plani	= $valor->PROD_ReglaPlanificacion;
				$codigo_interno = $valor->PROD_CodigoInterno;
				$lista[]		= array($item++,$codigo,$descripcion,$tipo_producto,$tipo_plani,$zona1,$sona2,$regla_plani,$codigo_interno);
			}
		}
		$data['lista'] = $lista;
		$data['titulo_tabla'] = 'RELACI&Oacute;N de PRODUCTOS';
		$data['titulo'] = "NUEVO PRODUCTO";
		
		$this->pagination->initialize($conf);
		$data['paginacion'] = $this->pagination->create_links();
		$this->layout->view('almacen/producto_index',$data);
	}
	
	public function nuevo_producto(){
		
		if(!$this->session->userdata('user')){
            redirect('index/index');
        }
		$this->load->library('layout','layout');
		$data['titulo'] 	= "NUEVO PRODUCTO";
		$data['modo'] 		= "insertar";
		$data['codigo'] 	= "";
		
		$this->layout->view('almacen/producto_nuevo',$data);
	}
	
	public function reporte(){
		if(!$this->session->userdata('user')){
            redirect('index/index');
        }
		$this->load->library('layout','layout');
		$data['titulo'] = "REPORTE POR PRODUCTO";
		/*Imagen 3*/          
		$DataSet = new pData;  
        $DataSet->AddPoint(array(800,700,650,620,640,700,700,700,500,550,490,900),"Serie1");
        $DataSet->AddPoint(array("Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Set","Oct","Nov","Dic"),"Serie2");  
		$DataSet->AddAllSeries();  
		$DataSet->RemoveSerie("Serie2");  
		$DataSet->SetAbsciseLabelSerie("Serie2");  
		$DataSet->SetYAxisName("STOCK"); 
		$DataSet->SetXAxisName("MESES");
		
		// Initialise the graph  
		$Test = new pChart(600,230);  
		$Test->drawGraphAreaGradient(132,153,172,50,TARGET_BACKGROUND);  
		$Test->setFontProperties("system/application/libraries/pchart/Fonts/tahoma.ttf",8);  
		$Test->setGraphArea(60,20,585,180);  
		$Test->drawGraphArea(213,217,221,FALSE);  
		$Test->drawScale($DataSet->GetData(),$DataSet->GetDataDescription(),SCALE_NORMAL,213,217,221,TRUE,0,2);  
		$Test->drawGraphAreaGradient(162,183,202,50);  
		$Test->drawGrid(4,TRUE,230,230,230,20);  
		
		// Draw the line chart  
		$Test->drawLineGraph($DataSet->GetData(),$DataSet->GetDataDescription());  
		$Test->drawPlotGraph($DataSet->GetData(),$DataSet->GetDataDescription(),2);  

		// Draw the legend  
		$Test->setFontProperties("Fonts/tahoma.ttf",8);  

		// Render the picture  
		$Test->Render("images/img_dinamic/imagen3.png");  
		$reporte = 	'<img style="margin-top:5px; margin-bottom:20px;" src="'.base_url().'images/img_dinamic/imagen3.png" alt="Imagen 3" />';
		$data['reporte'] = $reporte;
		$this->layout->view('almacen/ver_reporte',$data);
	}
	
}       
?>