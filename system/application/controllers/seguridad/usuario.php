<?php

    class Usuario extends Controller {
        
        public function __construct(){
            parent::__construct();
            $this->load->helper( 'form' );
            $this->load->library( 'form_validation' );
            $this->load->library( 'pagination' );
            $this->load->library( 'html' );
            $this->load->model( 'maestros/persona_model' );
            $this->load->model( 'seguridad/usuario_model' );
            $this->load->model( 'maestros/compania_model' );
            $this->load->model( 'maestros/usuario_compania_model' );
            $this->load->model( 'seguridad/rol_model' );
            $this->somevar['compania']  = $this->session->userdata( 'compania' );
            $this->somevar['usuario']   = $this->session->userdata( 'usuario' );
        }
        
        public function index() {
            $this->usuarios();
        }
        
        public function usuarios( $j='0' ) {
            if ( ! $this->session->userdata('user') )
                redirect( 'index/index' );
            
            $this->load->library( 'layout', 'layout' );
            $data['txtNombres'] = "";
            $data['txtUsuario'] = "";
            $data['txtRol']     = "";
            $data['registros']  = count($this->usuario_model->listar_usuarios());
            $conf['base_url']   = site_url('seguridad/usuario/usuarios');
            $conf['per_page']   = 50;
            $conf['num_links']  = 3;
            $conf['first_link'] = "&lt;&lt;";
            $conf['last_link']  = "&gt;&gt;";
            $conf['total_rows'] = $data['registros'];
            $offset             = (int)$this->uri->segment(3);
            $listado_usuarios   = $this->usuario_model->listar_usuarios($conf['per_page'],$offset);
            
            $item               = $j+1;
            $lista              = array();
            if ( count($listado_usuarios) > 0 ) {
			foreach($listado_usuarios as $indice=>$valor)
			{
				$codigo         = $valor->USUA_Codigo;
				$persona        = $valor->PERSP_Codigo;
				$rol            = $valor->ROL_Codigo;
				$nombre_usuario = $valor->USUA_usuario;
				$datos_persona  = $this->persona_model->obtener_datosPersona($persona);
				$datos_rol      = $this->rol_model->obtener_rol($rol);
				$nombre_persona = $datos_persona[0]->PERSC_Nombre." ".$datos_persona[0]->PERSC_ApellidoPaterno." ".$datos_persona[0]->PERSC_ApellidoMaterno;
				$nombre_rol     = $datos_rol[0]->ROL_Descripcion;
				$editar         = "<a href='#' onclick='editar_usuario(".$codigo.")'><img src='".base_url()."images/modificar.png' width='16' height='16' border='0' title='Modificar'></a>";
				$ver            = "<a href='#' onclick='ver_usuario(".$codigo.")'><img src='".base_url()."images/ver.png' width='16' height='16' border='0' title='Modificar'></a>";
				$eliminar       = "<a href='#' onclick='eliminar_usuario(".$codigo.")'><img src='".base_url()."images/eliminar.png' width='16' height='16' border='0' title='Modificar'></a>";
				$lista[]        = array($item,$nombre_persona,$nombre_usuario,$nombre_rol,$editar,$ver,$eliminar);
				$item++;
			}
		}
		$data['action']          = base_url()."index.php/seguridad/usuario/buscar_usuarios";
		$data['titulo_busqueda'] = "BUSCAR USUARIO";
		$data['titulo_tabla']    = "RELACI&Oacute;N de USUARIOS";
		$data['lista']           = $lista;
		$data['oculto']          = form_hidden(array('base_url'=>base_url()));
		$this->pagination->initialize($conf);
		$data['paginacion']      = $this->pagination->create_links();
		$this->layout->view('seguridad/usuario_index',$data);
	}
	public function nuevo_usuario(){
		if(!$this->session->userdata('user')){
            redirect('index/index');
        }
		
		$this->load->library('layout','layout');
		$datos_roles = $this->rol_model->listar_roles();
		$arreglo = array(''=>'::Selecione::');
		foreach($datos_roles as $valor){
			$indice1   = $valor->ROL_Codigo;
			$valor1    = $valor->ROL_Descripcion;
			$arreglo[$indice1] = $valor1;
		}
		$lblNombres = form_label('NOMBRES','nombres');
		$lblPaterno = form_label('APELLIDO PATERNO','paterno');
		$lblMaterno = form_label('APELLIDO MATERNO','materno');
		$lblUsuario = form_label('USUARIO','usuario');
		$lblClave   = form_label('CLAVE','clave');
		$lblRol     = form_label('ROL','rol');
		$txtNombres = form_input(array('name'=>'txtNombres','id'=>'txtNombres','value'=>'','maxlength'=>'30','class'=>'cajaMedia'));
		$lblCompania     = form_label('EMPRESA','empresa');
		$txtPaterno = form_input(array('name'=>'txtPaterno','id'=>'txtPaterno','value'=>'','maxlength'=>'30','class'=>'cajaMedia'));
		$txtMaterno = form_input(array('name'=>'txtMaterno','id'=>'txtMaterno','value'=>'','maxlength'=>'30','class'=>'cajaMedia'));
		$txtUsuario = form_input(array('name'=>'txtUsuario','id'=>'txtUsuario','value'=>'','maxlength'=>'30','class'=>'cajaPequena'));
		$txtClave   = form_password(array('name'=>'txtClave','id'=>'txtClave','value'=>'','maxlength'=>'30','class'=>'cajaPequena'));
		$cboRol     = form_dropdown('cboRol',$arreglo,'large',"id='cboRol' class='fuente8'");
		$cboCompania  = $this->seleccionar_compania();
		$selectCompania = "<select name='cboCompaniaUsuario' id='cboCompaniaUsuario' class='comboMedio'>".$cboCompania."</select>";
		$oculto     = form_hidden(array('accion'=>"",'codigo'=>"",'modo'=>"insertar",'base_url'=>base_url()));	
		$data['titulo']     = "REGISTRAR USUARIO";		
		$data['formulario'] = "frmUsuario";	
		$data['campos']     = array($lblNombres,$lblPaterno,$lblMaterno,$lblUsuario,$lblClave,$lblRol,$lblCompania);
		$data['valores']    = array($txtNombres,$txtPaterno,$txtMaterno,$txtUsuario,$txtClave,$cboRol,$selectCompania);
		$data['oculto']     = $oculto;
		$data['modo']	= "insertar";
		$data['onload']	= "onload=\"$('#txtNombres').focus();\"";		
		$this->layout->view('seguridad/usuario_nuevo',$data);
	}
	
	public function editar_usuario($codigo){
		if(!$this->session->userdata('user')){
            redirect('index/index');
        }
		
		$this->load->library('layout','layout');
		$datos_roles = $this->rol_model->listar_roles();
		$arreglo = array(''=>'::Selecione::');
		foreach($datos_roles as $indice=>$valor){
			$indice1  = $valor->ROL_Codigo;
			$valor1   = $valor->ROL_Descripcion;
			$arreglo[$indice1] = $valor1;
		}		
		$datos_usuario = $this->usuario_model->obtener($codigo);
		$persona       = $datos_usuario->PERSP_Codigo;
		$rol           = $datos_usuario->ROL_Codigo;
		$usuario       = $datos_usuario->USUA_usuario;
		$clave         = $datos_usuario->USUA_Password;
		$datos_rol     = $this->rol_model->obtener_rol($rol);
		$nombres       = $datos_usuario->PERSC_Nombre;
		$paterno       = $datos_usuario->PERSC_ApellidoPaterno;
		$materno       = $datos_usuario->PERSC_ApellidoMaterno;
		$nombre_rol    = $datos_rol[0]->ROL_Descripcion;
		$lblNombres = form_label('NOMBRES','nombres');
		$lblPaterno = form_label('APELLIDO PATERNO','paterno');
		$lblMaterno = form_label('APELLIDO MATERNO','materno');
		$lblUsuario = form_label('USUARIO','usuario');
		$lblClave   = form_label('CLAVE','clave');
		$lblRol     = form_label('ROL','rol');
		$txtNombres = form_input(array('name'=>'txtNombres','id'=>'txtNombres','value'=>$nombres,'maxlength'=>'50','class'=>'cajaMedia'));
		$txtPaterno = form_input(array('name'=>'txtPaterno','id'=>'txtPaterno','value'=>$paterno,'maxlength'=>'50','class'=>'cajaMedia'));
		$txtMaterno = form_input(array('name'=>'txtMaterno','id'=>'txtMaterno','value'=>$materno,'maxlength'=>'50','class'=>'cajaMedia'));
		$txtUsuario = form_input(array('name'=>'txtUsuario','id'=>'txtUsuario','value'=>$usuario,'maxlength'=>'50','class'=>'cajaPequena'));
		$txtClave   = form_password(array('name'=>'txtClave','id'=>'txtClave','value'=>'','maxlength'=>'30','class'=>'cajaPequena'));
		$cboRol     = form_dropdown('cboRol',$arreglo,$rol,"id='cboRol' class='fuente8'");
		$oculto     = form_hidden(array('accion'=>"",'codigo'=>$codigo,'modo'=>"modificar",'base_url'=>base_url()));	
		
		$usuario = $this->compania_model->listar_companias_usuario();
		$compania = $usuario[0]->COMP_Codigo2;
		$cboCompania  = $this->seleccionar_compania($compania);
		$selectCompania = "<select name='cboCompaniaUsuario' id='cboCompaniaUsuario' class='comboMedio'>".$cboCompania."</select>";
		$data['empresa']	= $selectCompania;
		
		//listado de todas la compa�oas
		$companias_hijas = $this->compania_model->listar_companias_hijas();
		//listado de compa�ias seleccionadas
		$companias_hijas_usuario = $this->compania_model->listar_companias_hijas_usuario($compania,$codigo);
		//print_r($companias_hijas_usuario);exit;
		$selectEscenarios = '<select class="comboMedioMultiple" multiple="multiple" name="cboEscenarios[]" id="cboEscenarios">';
		foreach ($companias_hijas as $reg){
			$flag = false;
			if(count($companias_hijas_usuario) > 0){
				foreach($companias_hijas_usuario as $reg2){
					if($reg2->COMP_Codigo == $reg->COMP_Codigo){
						$selectEscenarios .= '<option selected="selected" value="'.$reg2->COMP_Codigo.'" >'.$reg2->COMP_Nombre.'</option>';
						$flag = true;
					}
				}
				if(!$flag){
					$selectEscenarios .= '<option value="'.$reg->COMP_Codigo.'" >'.$reg->COMP_Nombre.'</option>';
				}
			}else{
				$selectEscenarios .= '<option value="'.$reg->COMP_Codigo.'" >'.$reg->COMP_Nombre.'</option>';
			}
        }
		$selectEscenarios .="</select>";
		
		$data['escenarios']     = $selectEscenarios;
		
		$data['titulo']     = "EDITAR USUARIO";
		$data['formulario'] = "frmUsuario";	
		$data['campos']     = array($lblNombres,$lblPaterno,$lblMaterno,$lblUsuario,$lblClave,$lblRol);
		$data['valores']    = array($txtNombres,$txtPaterno,$txtMaterno,$txtUsuario,$txtClave,$cboRol);
		$data['oculto']     = $oculto;
		$data['modo']	= "modificar";
		$data['onload']		= "onload=\"$('#txtNombres').select();$('#txtNombres').focus();\"";		
		$this->layout->view('seguridad/usuario_nuevo',$data);
	}
	
	public function insertar_usuario(){
		if(!$this->session->userdata('user')){
            redirect('index/index');
        }
		
		if($_POST){
			$this->load->library('layout','layout');
			$this->form_validation->set_rules('txtNombres','Nombre','required');
			$this->form_validation->set_rules('txtPaterno','Apellido Paterno','required');
			$this->form_validation->set_rules('txtUsuario','Usuario','required');
			$this->form_validation->set_rules('cboRol','Rol','required');
			if($this->form_validation->run() == FALSE){
				$this->nuevo_usuario();
			}else{
				$txtNombres = $this->input->post('txtNombres',TRUE);
				$txtPaterno = $this->input->post('txtPaterno',TRUE);
				$txtMaterno = $this->input->post('txtMaterno',TRUE);
				$txtUsuario = $this->input->post('txtUsuario',TRUE);
				$txtClave   = $this->input->post('txtClave',TRUE);
				$cboRol     = $this->input->post('cboRol',TRUE);
				$cboCompania 	= $this->input->post('cboCompaniaUsuario',TRUE);
				$cboEscenarios 	= $this->input->post('cboEscenarios',TRUE);
				$cboEscenarios = explode(',',$cboEscenarios);
				$usuario = $this->usuario_model->insertar_datosUsuario($txtNombres,$txtPaterno,$txtMaterno,$txtUsuario,$txtClave,$cboRol);
				// tiene que insertar tambien la compania PADRE en usuario_compania
				$this->usuario_compania_model->insertar_usuario_compania($usuario,$cboCompania);
				foreach($cboEscenarios as $value){
					$this->usuario_compania_model->insertar_usuario_compania($usuario,$value);
				}
			}
		}else{
			redirect('seguridad/usuario/nuevo_usuario');
		}
	}
	
	public function modificar_usuario(){
		if(!$this->session->userdata('user')){
			redirect('index/index');
		}
		
		$this->load->library('layout','layout');
		$this->form_validation->set_rules('txtNombres','Nombre','required');
		$this->form_validation->set_rules('txtPaterno','Apellido Paterno','required');
		$this->form_validation->set_rules('txtUsuario','Usuario','required');
		$this->form_validation->set_rules('cboRol','Rol','required');
		if($this->form_validation->run() == FALSE){
				$this->nuevo_usuario();
		}else{
			$usuario = $this->input->post('codigo',true);
			$rol     = $this->input->post('cboRol',true);
			$nombre_usuario = $this->input->post('txtUsuario',true);
			$clave   = $this->input->post('txtClave',true);
			$nombres = $this->input->post('txtNombres',true);
			$paterno = $this->input->post('txtPaterno',true);
			$materno = $this->input->post('txtMaterno',true);
			$cboCompania     = $this->input->post('cboCompaniaUsuario',TRUE);
			$cboEscenarios = $this->input->post('cboEscenarios',TRUE);
			$cboEscenarios = explode(',',$cboEscenarios);
			//print_r($cboEscenarios);exit;
			
			if(!empty($clave)){
					$this->usuario_model->modificar_usuarioClave($usuario,$clave);
			}
			$this->usuario_model->modificar_datosUsuario($usuario,$rol,$nombre_usuario,$nombres,$paterno,$materno,$cboCompania);
			
			//elimina todo lo de usuario_compania
			$this->usuario_compania_model->eliminar_usuario_compania($usuario);
			//inserta una compa�ia padre
			$this->usuario_compania_model->insertar_usuario_compania($usuario,$cboCompania);
			foreach($cboEscenarios as $value){
				$this->usuario_compania_model->insertar_usuario_compania($usuario,$value);
			}
			
			$this->load->view('seguridad/usuario_index');
		}
	}
	public function eliminar_usuario(){
		if(!$this->session->userdata('user')){
            redirect('index/index');
        }
		
		$this->load->library('layout','layout');
		$usuario = $this->input->post('usuario',TRUE);
		$this->usuario_model->eliminar_usuario($usuario);
		$this->load->view('seguridad/usuario_index');
		//redirect('seguridad/usuario');
	}
	public function ver_usuario($codigo){
		if(!$this->session->userdata('user')){
            redirect('index/index');
        }
		
		$this->load->library('layout','layout');
		$datos_usuario         = $this->usuario_model->obtener($codigo);
		$persona               = $datos_usuario->PERSP_Codigo;
		$rol                   = $datos_usuario->ROL_Codigo;
		$datos_rol             = $this->rol_model->obtener_rol($rol);
		$data['datos_persona'] = $datos_usuario;
		$data['datos_rol']     = $datos_rol;
		$data['titulo']        = "VER USUARIO";
		$data['oculto']        = form_hidden(array('base_url'=>base_url()));
		$this->layout->view('seguridad/usuario_ver',$data);
	}
	public function buscar_usuarios($j='0'){
		if(!$this->session->userdata('user')){
            redirect('index/index');
        }
		
		$this->load->library('layout','layout');
		$nombres  = $this->input->post('txtNombres',TRUE);
		$usuario  = $this->input->post('txtUsuario',TRUE);
		$rol      = $this->input->post('txtRol',TRUE);
		$data['txtNombres']     = $nombres;
		$data['txtUsuario']     = $usuario;
		$data['txtRol']         = $rol;
		$filter   = new stdClass();
		$filter->nombres = $nombres;
		$filter->usuario = $usuario;
		$filter->rol     = $rol;
		$data['registros']   = count($this->usuario_model->buscar_usuarios($filter));
		$conf['base_url']    = site_url('seguridad/usuario/buscar_usuarios/');
		$conf['total_rows']  = $data['registros'];
		$conf['per_page']    = 10;
		$conf['num_links']   = 3;
		$conf['next_link']   = "&gt;";
		$conf['prev_link']   = "&lt;";
		$conf['first_link']  = "&lt;&lt;";
		$conf['last_link']   = "&gt;&gt;";
		$conf['uri_segment'] = 4;
		$this->pagination->initialize($conf);
		$data['paginacion'] = $this->pagination->create_links();
		$listado_usuarios   = $this->usuario_model->buscar_usuarios($filter,$conf['per_page'],$j);
		$item               = $j+1;
		$lista              = array();
		if(count($listado_usuarios)>0)
		{
			foreach($listado_usuarios as $indice=>$valor)
			{
				$codigo         = $valor->USUA_Codigo;
				$persona        = $valor->PERSP_Codigo;
				$rol            = $valor->ROL_Codigo;
				$usuario        = $valor->USUA_usuario;
				$datos_persona  = $this->persona_model->obtener_datosPersona($persona);
				$datos_rol      = $this->rol_model->obtener_rol($rol);
				$nombre_persona = $datos_persona[0]->PERSC_Nombre." ".$datos_persona[0]->PERSC_ApellidoPaterno." ".$datos_persona[0]->PERSC_ApellidoMaterno;
				$nombre_rol     = $datos_rol[0]->ROL_Descripcion;
				$editar         = "<a href='#' onclick='editar_establecimiento(".$codigo.")' target='_parent'><img src='".base_url()."images/modificar.png' width='16' height='16' border='0' title='Modificar'></a>";
				$ver            = "<a href='#' onclick='ver_establecimiento(".$codigo.")' target='_parent'><img src='".base_url()."images/ver.png' width='16' height='16' border='0' title='Modificar'></a>";
				$eliminar       = "<a href='#' onclick='eliminar_establecimiento(".$codigo.")' target='_parent'><img src='".base_url()."images/eliminar.png' width='16' height='16' border='0' title='Modificar'></a>";
				$lista[]        = array($item++, $nombre_persona,$usuario,$nombre_rol,$editar,$ver,$eliminar);
			}
		}
		$data['action']         = base_url()."index.php/seguridad/usuario/buscar_usuarios";
		$data['titulo_tabla']   = "RESULTADO DE BUSQUEDA de USUARIOS";
		$data['titulo_busqueda']= "BUSCAR USUARIOS";
		$data['lista']      = $lista;
		$data['oculto']     = form_hidden(array('base_url'=>base_url()));
		$this->layout->view('seguridad/usuario_index',$data);
        }
	public function editar_cuenta($codigo){
		if(!$this->session->userdata('user')){
            redirect('index/index');
        }
		$this->load->library('layout','layout');
		$datos_roles = $this->rol_model->listar_roles();
		$arreglo = array(''=>'::Selecione::');
		foreach($datos_roles as $indice=>$valor){
			$indice1   = $valor->ROL_Codigo;
			$valor1    = $valor->ROL_Descripcion;
			$arreglo[$indice1] = $valor1;
		}
		$datos_usuario = $this->usuario_model->obtener($codigo);
		$persona       = $datos_usuario->PERSP_Codigo;
		$rol           = $datos_usuario->ROL_Codigo;
		$usuario       = $datos_usuario->USUA_usuario;
		$clave         = $datos_usuario->USUA_Password;
		$datos_rol     = $this->rol_model->obtener_rol($rol);
		$nombres       = $datos_usuario->PERSC_Nombre;
		$paterno       = $datos_usuario->PERSC_ApellidoPaterno;
		$materno       = $datos_usuario->PERSC_ApellidoMaterno;
		$nombre_rol    = $datos_rol[0]->ROL_Descripcion;
		$lblNombres = form_label('NOMBRES','nombres');
		$lblPaterno = form_label('APELLIDO PATERNO','paterno');
		$lblMaterno = form_label('APELLIDO MATERNO','materno');
		$lblUsuario = form_label('USUARIO','usuario');
		$lblClave   = form_label('CLAVE','clave');
		$txtNombres = form_input(array('name'=>'txtNombres','id'=>'txtNombres','value'=>$nombres,'maxlength'=>'50','class'=>'cajaMedia'));
		$txtPaterno = form_input(array('name'=>'txtPaterno','id'=>'txtPaterno','value'=>$paterno,'maxlength'=>'50','class'=>'cajaMedia'));
		$txtMaterno = form_input(array('name'=>'txtMaterno','id'=>'txtMaterno','value'=>$materno,'maxlength'=>'50','class'=>'cajaMedia'));
		$txtUsuario = form_input(array('name'=>'txtUsuario','id'=>'txtUsuario','value'=>$usuario,'maxlength'=>'50','class'=>'cajaPequena'));
		$txtClave   = form_password(array('name'=>'txtClave','id'=>'txtClave','value'=>'','maxlength'=>'30','class'=>'cajaPequena'));
		$oculto     = form_hidden(array('accion'=>"",'codigo'=>$codigo,'modo'=>"modificar",'base_url'=>base_url()));
		
		$data['titulo']     = "MI CUENTA";
		$data['formulario'] = "frmCuenta";
		$data['campos']     = array($lblNombres,$lblPaterno,$lblMaterno,$lblUsuario,$lblClave);
		$data['valores']    = array($txtNombres,$txtPaterno,$txtMaterno,$txtUsuario,$txtClave);
		$data['oculto']     = $oculto;
		$data['onload']		= "onload=\"$('#txtNombres').select();$('#txtNombres').focus();\"";
		$this->layout->view('seguridad/cuenta_nuevo',$data);
	}	
	public function modificar_cuenta(){
		if(!$this->session->userdata('user')){
            redirect('index/index');
        }
		
		$this->load->library('layout','layout');
		$this->form_validation->set_rules('txtNombres','Nombre','required');
		$this->form_validation->set_rules('txtPaterno','Apellido Paterno','required');
		$this->form_validation->set_rules('txtMaterno','Apellido Materno','required');
		$this->form_validation->set_rules('txtUsuario','Usuario','required');
		if($this->form_validation->run() == FALSE){
			$this->nuevo_usuario();
		}
		else{
			$usuario        = $this->input->post('codigo',TRUE);
			$datos_usuario  = $this->comercial_model->obtener_datosUsuario2($usuario);
			$persona        = $datos_usuario[0]->PERSP_Codigo;				
			$nombre_usuario = $this->input->post('txtUsuario',TRUE);
			$clave          = $this->input->post('txtClave',TRUE);
			$nombres        = $this->input->post('txtNombres',TRUE);
			$paterno        = $this->input->post('txtPaterno',TRUE);
			$materno        = $this->input->post('txtMaterno',TRUE);
			if(!empty($clave)){
				$this->comercial_model->modificar_usuarioClave($usuario,$clave);
			}
			$this->usuario_model->modificar_usuario2($usuario,$nombre_usuario);
			$this->comercial_model->modificar_datosPersona_nombres($persona,$nombres,$paterno,$materno);
			$this->load->view('seguridad/inicio');		
		}	
	}	
	public function seleccionar_rol($indSel=''){
		if(!$this->session->userdata('user')){
            redirect('index/index');
        }
		
		$this->load->library('layout','layout');
		$array_rol = $this->rol_model->listar_roles();
		$arreglo = array();
		foreach($array_rol as $indice=>$valor){
			$indice1   = $valor->ROL_Codigo;
			$valor1    = $valor->ROL_Descripcion;
			$arreglo[$indice1] = $valor1;
		}
		$resultado = $this->html->optionHTML($arreglo,$indSel,array('','::Seleccione::'));
		return $resultado;
	}
      
    public function seleccionar_compania($indSel=''){
		$array_compania = $this->compania_model->listar_companias();
		$arreglo = array();
		foreach($array_compania as $valor){
			$compania   	= $valor->COMP_Codigo;
			$empresa        = $valor->EMPR_Codigo;
			$datos_empresa	= $this->empresa_model->obtener_datosEmpresa($empresa);
			$razon_social	= $datos_empresa[0]->EMPR_RazonSocial;
			$arreglo[$compania] = $razon_social;
		}
		$resultado = $this->html->optionHTML($arreglo,$indSel,array('','::Seleccione::'));
		return $resultado;
	}
	
	public function obtener_compania_hijas(){
		$compania = $this->input->post('compania',TRUE);
		$companias_hijas = $this->compania_model->obtener_compania_hijas($compania);
		//print_r($companias_hijas);exit;
		//echo $companias_hijas;
		$cbohijas = '';
		if(count($companias_hijas) > 0){
			$cbohijas = '<select name="cboEscenarios[]" id="cboEscenarios" class="comboMedioMultiple" multiple>';
			foreach($companias_hijas as $value){
				$cbohijas .= '<option value="'.$value->COMP_Codigo.'">'.$value->COMP_Nombre.'</option>';
			}
			$cbohijas .= '</select>';
		}else{
			$cbohijas  = "LA COMPA&Ntilde;IA SELECCIONADA NO TIENE ESCENARIOS";
		}
		
		echo $cbohijas;
	}
	
}
?>