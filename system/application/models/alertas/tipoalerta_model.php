<?php
class Tipoalerta_Model extends Model{
    protected $tabla = "cji_tipoalerta";
    public function  __construct(){
        parent::__construct();
		$this->load->library('compartido');
        $this->somevar['compania'] = $this->session->userdata('compania');
        $this->somevar['compania_hija'] = $this->session->userdata('compania_hija');
    }

	
	public function listar_alerta($number_items='',$offset=''){
		$compartido = $this->compartido->buscar_compartidos(2);
		$where = array('TALE_Estado'=>'1');
		$query = $this->db->where_in('COMP_Codigo',$compartido)->where($where)->order_by('TALE_Codigo','desc')->get($this->tabla,$number_items,$offset);
        if($query->num_rows>0){
			foreach($query->result() as $fila){
				$data[] = $fila;
			}
			return $data;
        }else{
			return array();
		}
	}
	
	public function insertar_alerta($filter){
		$filter->COMP_Codigo = $this->somevar['compania_hija'];
		$this->db->insert($this->tabla,$filter);
		return $this->db->insert_id();
	}
	
	public function actualizar_alerta($filter,$cod_alerta){
		$where = array('TALE_Codigo'=>$cod_alerta);
		$this->db->where($where)->update($this->tabla,$filter);
		return $cod_alerta;
	}
	
	public function eliminar_alerta($cod_alerta){
		$where = array('TALE_Codigo'=>$cod_alerta);
		$filter 	= new stdClass();
		$filter->TALE_Estado = 0;
		$this->db->where($where)->update($this->tabla,$filter);
	}
	
	public function obtener_alerta($cod_alerta){
		$compartido = $this->compartido->buscar_compartidos(2);
		$where= array('TALE_Codigo'=>$cod_alerta);
		$query = $this->db->where_in('COMP_Codigo',$compartido)->where($where)->get($this->tabla,1);
        if($query->num_rows>0){
			foreach($query->result() as $fila){
				$data[] = $fila;
			}
			return $data;
        }else{
			return array();
		}
	}
	
	//obtener el tipo de alerta por codigo interno
	public function obtener_alerta_interno($cod_interno){
		$where= array('TALE_CodigoInterno'=>$cod_interno);
		$query = $this->db->where($where)->get($this->tabla,1);
        if($query->num_rows>0){
			foreach($query->result() as $fila){
				$data[] = $fila;
			}
			return $data;
        }else{
			return array();
		}
	}
	
}
?>