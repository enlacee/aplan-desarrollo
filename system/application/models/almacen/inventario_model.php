<?php
class Inventario_Model extends Model{
	protected $tabla = "cji_inventario";
	function __construct(){
		parent::__construct();
		$this->somevar['hoy']       = mdate("%Y-%m-%d",time());
	}
    public function insertar_inventario($filter){
		$this->db->trans_begin();
		$data 					= new StdClass();
		$data->PROD_Codigo		= $filter->cod_producto;
		$data->ESTA_Codigo		= $filter->cod_establecimiento;
		$data->INVE_StockActual	= $filter->stock_actual;
		$data->INVE_FechaStock	= $filter->fecha;
		$this->db->insert($this->tabla,$data);		
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
		}else{
			$this->db->trans_commit();
		}
	}
	
	public function actualizar_inventario(){
		$this->db->trans_begin();
		$where = array('INVE_Estado'=>'0');
		$data = array('INVE_Estado'=>'1');
		$this->db->where($where)->update($this->tabla,$data);
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
		}else{
			$this->db->trans_commit();
		}
	}
	
	public function eliminar_inventario(){
		$this->db->trans_begin();
		$where = array('INVE_Estado'=>'0');
		$this->db->where($where)->delete($this->tabla);
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
		}else{
			$this->db->trans_commit();
		}
	}
	
	//obtiene el inventario por codigo de producto y fecha actual, establecimiento , por ahora comentamos la fecha
	public function obtener_inventario_x_producto_fecha_establecimiento($inventario,$establecimiento){
		//$where = array('PROD_Codigo'=>$inventario,'INVE_FechaStock'=>$this->somevar['hoy'],'ESTA_Codigo'=>$establecimiento);
		$where = array('PROD_Codigo'=>$inventario,'ESTA_Codigo'=>$establecimiento);
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