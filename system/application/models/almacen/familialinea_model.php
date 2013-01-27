<?php
class Familialinea_model extends model{
    var $somevar;
	protected $tabla = 'cji_familialinea';
	function __construct(){
		parent::__construct();
		$this->load->database();
	}
	
	public function insertar_familia_linea($filter){
		$this->db->insert($this->tabla,$filter);
	}
}
?>