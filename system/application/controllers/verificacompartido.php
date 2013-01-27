<?php
class Verificacompartido extends Controller{
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
	
	public function verifica_compartido(){
		echo "ASD";
	}
	
}
?>