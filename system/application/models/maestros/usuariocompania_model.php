<?php
class Usuariocompania_model extends Model{
	var $_name = "cji_usuario_compania";
	public function __construct(){
		parent::__construct();
		$this->load->database();
	}
	public function insertar_usuariocompania($filter){
		$this->db->insert($this->_name,$filter);
	}
}
?>