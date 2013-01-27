<?php
class Establecimiento_model extends Model{
	protected $tabla = 'cji_establecimiento';
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper('date');
        $this->somevar ['compania'] = $this->session->userdata('compania');
        $this->somevar ['usuario'] 	= $this->session->userdata('usuario');
        $this->somevar ['empresa'] 	= $this->session->userdata('empresa');
        $this->somevar['hoy'] 		= mdate("%Y-%m-%d %h:%i:%s",time());
    }
    public function obtener_establecimiento($establecimiento){
		$where = array(
					"ESTA_Codigo"=>$establecimiento,
					"ESTA_Flag"=>"1",
					"ESTA_Estado"=>"A"
				);
        $query = $this->db->where($where)->get('cji_establecimiento');
        if($query->num_rows>0){
                foreach($query->result() as $fila){
                        $data[] = $fila;
                }
                return $data;
        }
    }
	
	public function insertar_establecimiento($filter){
		$this->db->insert($this->tabla,$filter);
	}
	
	public function listar_establecimiento($number_items='',$offset=''){
		$where = array('ESTA_Estado !='=>'');
		$query = $this->db->where($where)->order_by('ESTA_Codigo','asc')->get($this->tabla,$number_items,$offset);
        if($query->num_rows>0){
			foreach($query->result() as $fila){
				$data[] = $fila;
			}
			return $data;
        }
	}
 
}
?>