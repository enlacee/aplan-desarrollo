<?php
class Alerta extends Controller{
	var $somevar;
	public function __construct(){
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('pagination');
		$this->load->library('html');
		$this->load->model('maestros/periodo_model');
		$this->load->model('seguridad/rol_model');
		$this->load->model('configuracionmps/calendario_model');
		$this->load->model('alertas/tipoalerta_model');
		$this->load->model('alertas/alertarol_model');
		$this->load->model('configuracionmps/detallecalendario_model');
		$this->somevar['compania'] = $this->session->userdata('compania');
	}
	
	public function index(){
		$this->listar_alertas();
	}
	
	public function listar_alertas($j=""){
		if(!$this->session->userdata('user')){
            redirect('index/index');
        }
		$this->load->library('layout','layout');
		$data['titulo_busqueda'] = "MENSAJES DE ACCI&Oacute;N";
		$data['registros'] = count($this->tipoalerta_model->listar_alerta());
		/**configurar paginacion**/
		$conf['base_url']   = site_url('alertas/alerta/listar_alertas/');
		$conf['per_page']   = 20;
		$conf['num_links']  = 3;
		$conf['first_link'] = "&lt;&lt;";
		$conf['last_link']  = "&gt;&gt;";
		$conf['total_rows'] = $data['registros'];
		$conf['uri_segment'] = 4;
		$offset             = (int)$this->uri->segment(3);
		/**configurar paginacion**/
		$listado_alertas = $this->tipoalerta_model->listar_alerta($conf['per_page'],$offset);
		$lista              = array();
		$codigo_item 		= $j+1;
		if(count($listado_alertas)>0){
			foreach($listado_alertas as $indice=>$valor){
				$codigo			= $valor->TALE_Codigo;
				$docigo_interno = $valor->TALE_CodigoInterno;
				$nombre			= $valor->TALE_Nombre;
				$descripcion	= $valor->TALE_Obs;
				$lista[]		= array($codigo,$docigo_interno,$nombre,$descripcion,$codigo_item);
				$codigo_item++;
			}
		}
		$data['lista'] = $lista;
		$data['titulo_tabla'] = 'RELACI&Oacute;N de NENSAJES DE ACCI&Oacute;N';
		$data['titulo'] = "NUEVO ALERTA";
		
		$this->pagination->initialize($conf);
		$data['paginacion'] = $this->pagination->create_links();
		$this->layout->view('alertas/alerta_index',$data);
	}
	
	public function nuevo_alerta(){
		if(!$this->session->userdata('user')){
            redirect('index/index');
        }
		$this->load->library('layout','layout');
		$lblCodigo 			= form_label('C&Oacute;DIGO ALERTA','codigo');
		$lblNombre 			= form_label('NOMBRE','nombre');
		$lblDescripcion 	= form_label('DESCRIPCI&Oacute;N','desripcion');
		$txtCodigo 			= form_input(array('name'=>'txtCodigo','id'=>'txtCodigo','value'=>'','maxlength'=>'30','class'=>'cajaPequena'));
		$txtNombre 			= form_input(array('name'=>'txtNombre','id'=>'txtNombre','value'=>'','maxlength'=>'30','class'=>'cajaGrande'));
		$txtDescripcion 	= form_textarea(array('name'=>'txtDescripcion','id'=>'txtDescripcion','value'=>'','class'=>'cajaTextAreaGeneral'));
			
		$data['titulo']     	= "REGISTRAR NUEVO ALERTA";		
		$data['formulario'] 	= "frmAlerta";	
		$data['campos']     	= array($lblCodigo,$lblNombre,$lblDescripcion);
		$data['valores']    	= array($txtCodigo,$txtNombre,$txtDescripcion);
		$data['modo']     		= 'insertar';
		$data['base_url']		= base_url();
		$data['onload']			= "onload=\"$('#txtCodigo').focus();\"";
		$data['codigo_id']			= 0;
		$this->layout->view('alertas/alerta_nuevo',$data);
	}
	
	
	public function insertar_alerta(){
		if(!$this->session->userdata('user')){
            redirect('index/index');
        }
		if(!$_POST){
			 redirect('alertas/alerta/listar_alertas');
		}
		$retorno = '';
		$txtCodigo					 = $this->input->post('txtCodigo',TRUE);
		$txtNombre 					 = $this->input->post('txtNombre',TRUE);
		$txtDescripcion 			 = $this->input->post('txtDescripcion',TRUE);
		$modo						 = $this->input->post('modo',TRUE);
		$codigo						 =	$this->input->post('id_codigo',TRUE);
		$oAlerta = new stdClass();
		$oAlerta->TALE_CodigoInterno = strtoupper($txtCodigo);
		$oAlerta->TALE_Nombre        = strtoupper($txtNombre);
		$oAlerta->TALE_Obs           = strtoupper($txtDescripcion);
		$oAlerta->TALE_Estado        = 1;
		$oAlerta->TALE_Flag          = 1;
		
		if($codigo== 0){
			$retorno = $this->tipoalerta_model->insertar_alerta($oAlerta);
		}else{
			$retorno = $this->tipoalerta_model->actualizar_alerta($oAlerta,$codigo);
		}
		echo $retorno;
	}	
		
	public function eliminar_alerta($cod_alerta){
		if(!$this->session->userdata('user')){
            redirect('index/index');
        }
		$this->tipoalerta_model->eliminar_alerta($cod_alerta);
		$this->index();
	}
	
	public function ver_alerta($codigo){
		if(!$this->session->userdata('user')){
			redirect('index/index');
        }		
		$datos_alerta        = $this->tipoalerta_model->obtener_alerta($codigo);
		if(count($datos_alerta) == 0){
			redirect('alertas/alerta/listar_alertas');
		}
		$this->load->library('layout','layout');		
		$codigo_alerta       = $datos_alerta[0]->TALE_Codigo;
		$codigo_interno      = $datos_alerta[0]->TALE_CodigoInterno;
		$alerta_nombre		 = $datos_alerta[0]->TALE_Nombre;
		$alerta_observacion	 = $datos_alerta[0]->TALE_Obs;
		$alerta_registro	 = $datos_alerta[0]->TALE_FechaRegistro;
		$data['titulo']		 = 'DETALLES DE LA ALERTA';	
		$data['fecha_registro']		=	$alerta_registro;
		$data['codigo_id']			=	$codigo_alerta     ;  
		$data['codigo_interno']		=	$codigo_interno    ;  
		$data['nombre']				=	$alerta_nombre		; 
		$data['observacion']		=	$alerta_observacion;	 
		$data['oculto']        = form_hidden(array('base_url'=>base_url()));
		form_hidden(array('base_url'=>base_url()));
		$this->layout->view('alertas/alerta_ver',$data);
	}	
	
	public function editar_alerta($cod_alerta){
		if(!$this->session->userdata('user')){
			redirect('index/index');
        }
		
		$alerta = $this->tipoalerta_model->obtener_alerta($cod_alerta);
		if(count($alerta) == 0){
			redirect('alertas/alerta/listar_alertas');
		}
		$this->load->library('layout','layout');
		$lblCodigo 			= form_label('C&Oacute;DIGO ALERTA','codigo');
		$lblNombre 			= form_label('NOMBRE','nombre');
		$lblDescripcion 	= form_label('DESCRIPSI&Oacute;N','desripcion');
		$txtCodigo 			= form_input(array('name'=>'txtCodigo','id'=>'txtCodigo','value'=>$alerta[0]->TALE_CodigoInterno,'maxlength'=>'30','class'=>'cajaPequena'));
		$txtNombre 			= form_input(array('name'=>'txtNombre','id'=>'txtNombre','value'=>$alerta[0]->TALE_Nombre,'maxlength'=>'30','class'=>'cajaGrande'));
		$txtDescripcion 	= form_textarea(array('name'=>'txtDescripcion','id'=>'txtDescripcion','value'=>$alerta[0]->TALE_Obs,'class'=>'cajaTextAreaGeneral'));
		
		$data['titulo']     	= "EDITAR ALERTA";		
		$data['formulario'] 	= "frmAlerta";	
		$data['campos']     	= array($lblCodigo,$lblNombre,$lblDescripcion);
		$data['valores']    	= array($txtCodigo,$txtNombre,$txtDescripcion);
		$data['modo']     		= 'modificar';
		$data['base_url']		= base_url();
		$data['onload']			= "onload=\"$('#txtCodigo').focus();\"";
		$data['codigo_id']			= $alerta[0]->TALE_Codigo;
		
		$this->layout->view('alertas/alerta_nuevo',$data);
	}
	
	
	public function ver_alerta_rol_popup($codigo){
		if(!$this->session->userdata('user')){
            redirect('index/index');
        }
		$this->load->library('layout','layout');
		$tipo_aletar 		= $this->tipoalerta_model->obtener_alerta($codigo);
		$codigo_tipoalerta 	= $tipo_aletar[0]->TALE_Codigo;
		
		$habilitado = $this->buscar_alertarol($codigo_tipoalerta);	
		$roles_habilitados = array();
		if(count($habilitado)>0){
			foreach($habilitado AS $clave=>$valor){
				$roles_habilitados[] = array($valor->ROL_Codigo);
			}
		}
		$lista_rol = $this->rol_model->listar_roles();
		$lista_r = array();
		
		foreach($lista_rol AS $key=>$val){
			$lista_r[] = array($val->ROL_Codigo,$val->ROL_Descripcion);
		}
		
		$codigo_interno 			= $tipo_aletar['0']->TALE_CodigoInterno;
		$nombre						= $tipo_aletar['0']->TALE_Nombre;
		$data['titulo']     		= "HABILITAR ROLES";
		$data['formulario'] 		= "frmRol";
		$data['MENU_Codigo'] 		= "frmRol";
		$data['codigo_interno'] 	= $codigo_interno;
		$data['nombre']				= $nombre;
        $data['lista_rol'] 			= $lista_r;
		$data['lista_habilitados'] 	= $roles_habilitados;
 		$data['codigo_alerta']  	= $codigo;
		
		$this->load->view('alertas/alerta_rol_popup',$data);
	}	
	
	public function insertar_rol_activados(){
		$lista_rol 			= $this->rol_model->listar_roles();
		$codigo_tipoalerta 	= $this->input->post('codigo_rol',TRUE);
		
		$this->alertarol_model->borrar_alertarol($codigo_tipoalerta);
		foreach($lista_rol AS $clave=>$valor){
			$alerta_rol = new stdClass();
			$alerta_rol->TALE_Codigo = $codigo_tipoalerta;
			$alerta_rol->ROL_Codigo	 = $valor->ROL_Codigo;
			
			if(isset($_POST["check_".$valor->ROL_Codigo]) && $_POST["check_".$valor->ROL_Codigo] == 'on'){
				$this->alertarol_model->insertar_alertarol($alerta_rol);
			}
		}
		
		echo "
			<script type='text/javascript'>
				parent.$.fancybox.close();
			</script>
			";
		
	}

	private function buscar_alertarol($codigo_alerta){
		$habilitado = $this->alertarol_model->buscar_alertarol($codigo_alerta);
		return 	$habilitado;
	}
	
}
?>