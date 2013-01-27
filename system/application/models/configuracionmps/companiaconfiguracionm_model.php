<?php
class Companiaconfiguracionm_Model extends Model{
    protected $_name = "cji_companiaconfiguracionm";
	var $somevar;
    public function  __construct(){
        parent::__construct();
        $this->load->database();
        $this->somevar['compania'] = $this->session->userdata('compania');
		$this->somevar['compania_hija']	= $this->session->userdata('compania_hija');
	}
	
	public function insertar_companiaconfiguracionm($filter){
		$this->db->insert($this->_name,$filter);
	}
	
	public function obtener_companiaconfiguracionm(){
		$where = array('COMP_Codigo'=>$this->somevar['compania_hija']);
		$query = $this->db->where($where)->get($this->_name,1);
        if($query->num_rows>0){
			foreach($query->result() as $fila){
				$data[] = $fila;
			}
			return $data;
        }
	}
	
	
}
?>