<?php
class Calendario_Model extends Model{
    protected $tabla = "cji_calendario";
    public function  __construct(){
        parent::__construct();
		$this->load->library('compartido');
        $this->load->model('configuracionmps/detallecalendario_model');
        $this->somevar['compania'] = $this->session->userdata('compania');
        $this->somevar['compania_hija'] = $this->session->userdata('compania_hija');
    }
	
	public function insertar_calendario($filter){
		$this->db->trans_begin();
		$filter->COMP_Codigo = $this->somevar['compania_hija'];
		$this->db->insert($this->tabla,$filter);
		$cod_calendario = $this->db->insert_id();
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
		}else{
			$this->db->trans_commit();
		}
		return $cod_calendario;
	}
	
	public function editar_calendario($filter){
		$where = array('CALE_Codigo'=>$filter->CALE_Codigo,'COMP_Codigo'=>$this->somevar['compania_hija']);
		$this->db->where($where)->update($this->tabla,$filter);
	}
	
	public function modificar_calendario($filter){
		$this->db->trans_begin();
		$where = array('CALE_Codigo'=>$filter->CALE_Codigo);
		$this->db->where($where)->update($this->tabla,$filter);
		//eliminamos el detalle calendario
		$this->detallecalendario_model->eliminar_detalle_calendario($filter->CALE_Codigo);
		//insertar detalle calendario
		foreach($filter->dias as $key=>$value){
			if($value == 1){
				$filter2	= new stdClass();
				$filter2->CALE_Codigo 	= $filter->CALE_Codigo;
				$filter2->DCAL_Dia 		= $key;
				$this->detallecalendario_model->insertar_detalle_calendario($filter2);
			}
		}
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
		}else{
			$this->db->trans_commit();
		}
	}
	
	public function obtener_calendario($cod_calendario){
		$compartido = $this->compartido->buscar_compartidos(1);
		$where= array('CALE_Codigo'=>$cod_calendario);
		$query = $this->db->where_in('COMP_Codigo',$compartido)->where($where)->get($this->tabla,1);
        if($query->num_rows>0){
			foreach($query->result() as $fila){
				$data[] = $fila;
			}
			return $data;
        }
	}
	
	public function obtener_calendario_periodo($periodo){
		$where= array('p.PERI_Aux'=>$periodo);
		$this->db->select('*');
		$this->db->from('cji_calendario c');
		$this->db->join('cji_periodo p', 'c.PERI_Codigo = p.PERI_Codigo');
		$query = $this->db->where($where)->get();
        if($query->num_rows>0){
			foreach($query->result() as $fila){
				$data[] = $fila;
			}
			return $data;
        }
	}
	
	public function listar_calendario($number_items='',$offset=''){
		$compartido = $this->compartido->buscar_compartidos(1);
		$where = array('CALE_Estado'=>'1');
		$query = $this->db->where_in('COMP_Codigo',$compartido)->where($where)->order_by('CALE_Codigo','desc')->get($this->tabla,$number_items,$offset);
        if($query->num_rows>0){
			foreach($query->result() as $fila){
				$data[] = $fila;
			}
			return $data;
        }
	}
	
	public function eliminar_calendario($cod_calendario){
		$where = array('CALE_Codigo'=>$cod_calendario);
		$filter 	= new stdClass();
		$filter->CALE_Estado = 0;
		$this->db->where($where)->update($this->tabla,$filter);
	}
	
}
?>