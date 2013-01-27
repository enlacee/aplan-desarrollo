<?php
class Index extends Controller{
	var $somevar;
	public function __construct(){
		parent::Controller();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('maestros/empresa_model');
		$this->load->model('maestros/compania_model');
		$this->load->model('maestros/persona_model');
		$this->load->model('seguridad/permiso_model');
		$this->load->model('seguridad/menu_model');
		$this->load->model('seguridad/usuario_model');
		$this->load->model('seguridad/rol_model');
		$this->load->model('alertas/alerta_model');
		$this->load->model('almacen/producto_model');
		$this->load->library('html');
	}
	public function index(){
		if(!$this->session->userdata('user')){
			$lblLogin            = form_label('USUARIO','usuario');
			$lblClave           = form_label('CONTRASENA','clave');
			$lblCompania = form_label('EMPRESA','empresa');
			$txtLogin  = form_input(array('name'=>'txtUsuario','id'=>'txtUsuario','value'=>'','maxlength'=>'20','class'=>'cajaMedia'));
			$txtClave  = form_password(array('name'=>'txtClave','id'=>'txtClave','value'=>'','maxlength'=>'15','class'=>'cajaMedia'));
			$cboCompania  = $this->seleccionar_compania('1');
			$selectCompania = "<select name='cboCompania' id='cboCompania' class='comboMedio'>".$cboCompania."</select>";
			$data['titulo']     = 'index';
                        $data['campos']     = array($lblLogin,$lblClave,$lblCompania);
			$data['valores']    = array($txtLogin,$txtClave,$selectCompania);
			$data['onload']		= "onload=\"$('#nombre').focus();\"";
			$this->load->view("index",$data);
		}else{
			redirect('index/inicio');
		}
	}
	public function ingresar_sistema(){
		$this->form_validation->set_rules('txtUsuario','Nombre Usuario','required|max_length[20]');
		$this->form_validation->set_rules('txtClave','Clave de Usuario','required|max_length[15]|md5');
		$this->form_validation->set_rules('cboCompania','Empresa','required');
		if($this->form_validation->run() == FALSE){
		  $this->index();
		}else{
			$txtUsuario          = $this->input->post('txtUsuario',TRUE);
			$txtClave            = $this->input->post('txtClave',TRUE);
			$compania            = $this->input->post('cboCompania',TRUE);
			$datos_compania      = $this->compania_model->obtener_compania($compania);
			$datos_empresa       = $this->empresa_model->obtener_datosEmpresa($datos_compania[0]->EMPR_Codigo);
			$datos_usuario       = $this->usuario_model->obtener_datosUsuarioLogin($txtUsuario,$txtClave,$compania);
			if(count($datos_usuario)>0){
				$usuario         = $datos_usuario[0]->USUA_Codigo;
				$persona         = $datos_usuario[0]->PERSP_Codigo;
				$rol             = $datos_usuario[0]->ROL_Codigo;
				$datos_persona   = $this->persona_model->obtener_datosPersona($persona);
				$datos_rol       = $this->rol_model->obtener_rol($rol);
				$nombre_rol      = $datos_rol[0]->ROL_Descripcion;
				$nombre_persona  = $datos_persona[0]->PERSC_Nombre." ".$datos_persona[0]->PERSC_ApellidoPaterno;
				$datos_permisos  = $this->permiso_model->obtener_permisosMenu($rol);
				$data2           = array();
				foreach($datos_permisos as $valor){
				  $menu 		 = $valor->MENU_Codigo;
				  $datos_menu  = $this->menu_model->obtener_datosMenu($menu);
				  $nombre_menu = $datos_menu[0]->MENU_Descripcion;
				  $url         = $datos_menu[0]->MENU_Url;
				  $data2[]     = array($menu,$nombre_menu,$url);
				}
				
				// variable para almacenar el codigo de la compa�ia hija
				// ahora TODO FILTRA POR compania_hija
				$codigo_hija = '';
				
				$data = array(
					'user'           => $usuario,
					'persona'        => $persona,
					'nombre_persona' => $nombre_persona,
					'rol'            => $rol,
					'nombre_rol'     => $nombre_rol,
					'compania'       => $compania,
					'compania_hija'	 => $codigo_hija,
					'empresa'        => $datos_empresa[0]->EMPR_Codigo,
					'nombre_empresa' => $datos_empresa[0]->EMPR_RazonSocial
				);
				
				$this->session->set_userdata($data);
				$this->session->set_userdata('datos_menu',$data2);
				
				// metodo para poner en session la compa�ia hija que esta como pricipal
				$companias_hijas = $this->compania_model->listar_companias_usuario();
				
				$codigo_hija = '';
				if(count($companias_hijas)>0){
					foreach($companias_hijas as $indice=>$valor){
						if($valor->COMP_Flag == 1){
							$codigo_hija = $valor->COMP_Codigo;
							break;
						}
					}
				}
				$data_hija = array('compania_hija'=>$codigo_hija);
				$this->session->set_userdata($data_hija);
				//
				
				redirect('index/inicio');
			}else{
				$msgError = "<br><div align='center' class='error'>Usuario y/o contrasena no valido para esta empresa.</div>";
				echo $msgError;
				$this->index();
			}
		}
	}
	public function inicio(){
		if(!$this->session->userdata('user')){
			redirect('index/index');
		}
		$this->load->library('layout');
		//$this->layout->layout('layout/menu');
		$alertas = $this->mostrar_alerta();
		$array_alertas = array();
		foreach($alertas as $key=>$value){
			$producto = $this->producto_model->obtener_producto($value->PROD_Codigo);
			$fecha = $value->ALER_Fecha;
			$fecha = substr($fecha, 8, 2) . '/' . substr($fecha, 5, 2) . '/' . substr($fecha, 0, 4);
			$array_alertas[] = array($key+1,$value->TALE_Codigo,$value->TALE_CodigoInterno,$value->TALE_Nombre,$value->ALER_FechaRegistro,$value->PROD_Codigo,$producto[0]->PROD_Descripcion,$fecha);
		}
                $data['titulo']='Inicio';
		$data['oculto']=form_hidden(array('base_url'=>base_url()));	
		$data['lista'] = $array_alertas;
		$this->layout->view("seguridad/inicio", $data);
	}
	public function mostrar_alerta(){
		$alerta = $this->alerta_model->listar_alerta();
		return $alerta;
	}
	
	public function salir_sistema(){
		$this->session->unset_userdata('user'); 
		$this->session->unset_userdata('nombre_persona'); 
		$this->session->unset_userdata('rol'); 
		$this->session->unset_userdata('nombre_rol');
		$this->session->unset_userdata('compania');
		$this->session->unset_userdata('compania_hija');
		$this->session->unset_userdata('empresa');
		$this->session->unset_userdata('nombre_empresa');
		$this->index();
	}
	
	//Listado de las compa�ias
	public function seleccionar_compania($indSel=''){
		$array_compania = $this->compania_model->listar_companias();
		$arreglo = array();
		foreach($array_compania as $valor){
			$compania   		= $valor->COMP_Codigo;
			$empresa         	= $valor->EMPR_Codigo;
			$datos_empresa   	= $this->empresa_model->obtener_datosEmpresa($empresa);
			$razon_social       = $datos_empresa[0]->EMPR_RazonSocial;
			$arreglo[$compania]	= $razon_social;
		}
		$resultado = $this->html->optionHTML($arreglo,$indSel,array('','::Seleccione::'));
		return $resultado;
	}
}
?>