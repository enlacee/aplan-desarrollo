<?php
class Talla_model extends Model{
	protected $tabla = "cji_talla";
	public function __construct(){
		parent::__construct();
		$this->load->database();
        $this->load->helper('date');
        $this->somevar ['compania'] = $this->session->userdata('compania');
        $this->somevar ['usuario']  = $this->session->userdata('usuario');
        $this->somevar['hoy']       = mdate("%Y-%m-%d %h:%i:%s",time());
	}
    public function insertar_talla($filter){
		$this->db->insert($this->tabla,$filter);
    }
	
	public function obtener_talla_interno($cod_interno){
		$query = $this->db->where('TALA_CodigoInterno',$cod_interno)->get($this->tabla,1);
		if($query->num_rows>0){
			foreach($query->result() as $fila){
				$data[] = $fila;
			}
			return $data;
		}
	}
}
?>