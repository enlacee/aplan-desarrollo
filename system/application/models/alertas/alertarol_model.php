<?php
class Alertarol_Model extends Model{
    protected $tabla = "cji_alertarol";
    public function  __construct(){
        parent::__construct();
        $this->somevar['compania'] = $this->session->userdata('compania');
    }

	public function buscar_alertarol($codigo_alerta){
		$where = array('TALE_Codigo'=>$codigo_alerta);
		$query = $this->db->where($where)->get($this->tabla);
		if($query->num_rows()>0){
			return $query->result();
		}else{
			return array();
		}
	}
	
	public function borrar_alertarol($codigo){
		$where	= array('TALE_Codigo'=>$codigo);
		$this->db->where($where)->delete($this->tabla);
	}
	
	public function insertar_alertarol($obejto){
		$this->db->insert($this->tabla,$obejto);
	}
	
}
?>