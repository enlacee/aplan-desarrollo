<?php
class Marca_model extends Model{
	protected $tabla = "cji_marca";
	public function __construct(){
		parent::__construct();
		$this->load->database();
        $this->load->helper('date');
        $this->somevar ['compania'] = $this->session->userdata('compania');
        $this->somevar ['usuario']  = $this->session->userdata('usuario');
        $this->somevar['hoy']       = mdate("%Y-%m-%d %h:%i:%s",time());
	}
    public function insertar_marca($filter){
        $this->db->insert($this->tabla,$filter);
    }
}
?>