<?php
class Almacen_Model extends Model{
    protected $tabla = "cji_almacen";
    public function  __construct(){
        parent::__construct();
        $this->load->database();
        $this->somevar['compania'] = $this->session->userdata('compania');
    }
	public function insertar_almacen($filter){
		$this->db->insert($this->tabla,$filter);
	}
	
	public function obtener_almacen_interno($codigo_interno){
		$query = $this->db->where('ALMA_CodigoInterno',$codigo_interno)->get($this->tabla,1);
		if($query->num_rows>0){
			foreach($query->result() as $fila){
				$data[] = $fila;
			}
			return $data;
		}
	}
	
}
?>