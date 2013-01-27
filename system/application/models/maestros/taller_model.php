<?php
class Taller_model extends Model{
	protected $tabla = "cji_taller";
	public function __construct(){
		parent::__construct();
		$this->load->database();
        $this->load->helper('date');
        $this->somevar ['compania'] = $this->session->userdata('compania');
        $this->somevar ['usuario']  = $this->session->userdata('usuario');
        $this->somevar['hoy']       = mdate("%Y-%m-%d %h:%i:%s",time());
	}
    public function obtener_taller($taller){
         $where = array('TALL_Codigo'=>$taller);
		$query = $this->db->where($where)->get($this->tabla,1);
		if($query->num_rows>0){
			foreach($query->result() as $fila){
				$data[] = $fila;
			}
			return $data;
		}
    }
}
?>