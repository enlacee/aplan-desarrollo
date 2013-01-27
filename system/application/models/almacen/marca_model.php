<?php
class Marca_Model extends Model{
    protected $tabla = "cji_marca";
    public function  __construct(){
        parent::__construct();
        $this->load->database();
    }
	
	public function insertar_marca($filter){
		$this->db->insert($this->tabla,$filter);
	}
	
	public function obtener_marca_interno($cod_interno){
		$query = $this->db->where('MARC_CodigoInterno',$cod_interno)->get($this->tabla,1);
		if($query->num_rows>0){
			foreach($query->result() as $fila){
				$data[] = $fila;
			}
			return $data;
		}
	}
    
}
?>