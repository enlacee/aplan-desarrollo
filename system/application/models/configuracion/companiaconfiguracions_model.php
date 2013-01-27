<?php
class Companiaconfiguracions_model extends Model{
	var $somevar;
	protected $_name = "cji_companiaconfiguracions";
	public function __construct(){
		parent::__construct();
		$this->somevar['compania'] = $this->session->userdata('compania');
	}
	
	public function insertar_companiaconfiguracions($filter){
		$this->db->insert($this->_name,$filter);
	}
	
}
?>