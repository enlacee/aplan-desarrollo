<?php
class Linea_model extends Model{
	var $somevar;
	protected $tabla = 'cji_linea';
    public function __construct(){
        parent::__construct();
        $this->somevar['compania'] = $this->session->userdata('compania');
    }
	
	public function insertar_linea($filter){
		$this->db->insert($this->tabla,$filter);
	}
	
	public function obtener_linea_cod_usuario($cod_usuario){
		$where = array('LINE_CodigoUsuario'=>$cod_usuario);
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