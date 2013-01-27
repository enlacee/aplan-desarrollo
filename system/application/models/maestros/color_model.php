<?php
class Color_model extends Model{
	protected $tabla = "cji_color";
	public function __construct(){
		parent::__construct();
		$this->load->database();
        $this->load->helper('date');
        $this->somevar ['compania'] = $this->session->userdata('compania');
        $this->somevar ['usuario']  = $this->session->userdata('usuario');
        $this->somevar['hoy']       = mdate("%Y-%m-%d %h:%i:%s",time());
	}
    public function insertar_color($filter){
		$this->db->insert($this->tabla,$filter);
    }
	
	public function obtener_color_interno($cod_interno){
		$query = $this->db->where('COLO_CodigoInterno',$cod_interno)->get($this->tabla,1);
		if($query->num_rows>0){
			foreach($query->result() as $fila){
				$data[] = $fila;
			}
			return $data;
		}
	}
}
?>