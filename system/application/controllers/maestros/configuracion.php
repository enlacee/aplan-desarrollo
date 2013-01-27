<?php
class Configuracion extends Controller{
	var $somevar;
    public function __construct(){
        parent::Controller();
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->library('pagination');
        $this->load->library('html');
        $this->load->model('maestros/empresa_model');
        $this->load->model('maestros/compania_model');
        $this->load->library('layout','layout');
		$this->somevar ['compania'] = $this->session->userdata('compania');
        $this->somevar ['empresa'] 	= $this->session->userdata('empresa');
        $this->somevar ['nombre_empresa']  = $this->session->userdata('nombre_empresa');
        $this->somevar ['compania_hija']  = $this->session->userdata('compania_hija');
    }
    public function index(){
        $this->layout->view('seguridad/inicio');
    }
	
	public function cambiar_sesion(){
		$_SESSION['compania_hija'] = $_POST['compania'];
		$compania = $this->compania_model->obtener_compania($_POST['compania']);
		$empresa = $this->empresa_model->obtener_datosEmpresa($compania[0]->EMPR_Codigo);
		$_SESSION['empresa'] = $compania[0]->EMPR_Codigo;
		$_SESSION['nombre_empresa'] = $empresa[0]->EMPR_RazonSocial;
		$this->somevar['empresa'] = $compania[0]->EMPR_Codigo;
		$this->somevar['nombre_empresa'] = $empresa[0]->EMPR_RazonSocial;
		$this->somevar['compania_hija'] = $_POST['compania'];
		
		echo "Ok";
	}
	
	/*public function simulador(){
		echo $_SESSION['empresa'].' // ';
		echo $_SESSION['nombre_empresa'].' // ';
		echo $_SESSION['compania'].' // ';
		echo $_SESSION['compania_hija'];
	}*/
}
?>