<?php
class Demanda_model extends Model{
	protected $tabla = "cji_demanda";
	public function __construct(){
		parent::__construct();
		$this->load->database();
        $this->load->helper('date');
		$this->load->model('maestros/detalledemanda_model');
        $this->somevar ['compania'] = $this->session->userdata('compania');
         $this->somevar ['usuario']    = $this->session->userdata('usuario');
        $this->somevar['hoy']              = mdate("%Y-%m-%d %h:%i:%s",time());
	}
	public function insertar_demanda($filter){
		$this->db->trans_begin();
		$data 				= new StdClass();
		$data->DEMA_Fecha	= $filter->fecha;
		$data->DEMA_Tipo	= $filter->tipo;
		if($filter->tipo == 1){
			$data->PERI_Codigo	= $filter->cod_periodo;
		}else if($filter->tipo == 2){
			$data->PERI_Codigo	= 0;
			$data->DEMA_Cantidad= $filter->cantidad;
		}
		$data->PROD_Codigo	= $filter->cod_producto;
		$data->ESTA_Codigo	= $filter->cod_establecimiento;
		$this->db->insert($this->tabla,$data);
		//capturando el ultimo id ingresado
		$cod_demanda = $this->db->insert_id();
		//insertando detalle de demanda
		$empieza_mes = substr($filter->fecha, 5, 2);
		$anio = substr($filter->fecha, 0, 4);
		$mes = 0;
		$flag = true;
		if($filter->tipo == 1){
			foreach($filter->cant_demanda as $key=>$value){
				if($mes == 12){
					$mes = 0;
					$flag = false;
					$anio++;
				}
				if($flag){
					$mes = $empieza_mes + $key;
				}else{
					$mes++;
				}
				$data2 			= new StdClass();
				if($filter->tipo == 1){
					$data2->cod_periodo	= $filter->cod_periodo;
				}else if($filter->tipo == 2){
					$data2->cod_periodo	= 0;
				}
				$data2->cod_demanda	= $cod_demanda;
				$data2->cantidad	= $value;
				$data2->mes			= $mes;
				$data2->anio		= $anio;
				$data2->tipo		= $filter->tipo;
				$this->detalledemanda_model->insertar_detalle_demanda($data2);
			}
		}
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
		}else{
			$this->db->trans_commit();
		}
	}
	
	public function eliminar_demanda($tipo){
		//elimina las demandas y DETALLES con estados CERO
		$this->db->trans_begin();
		//elimina los detalles que sean de estado CERO
		$this->detalledemanda_model->eliminar_detalle_demanda($tipo);
		//elimina las cabeceras que sean de estado CERO
		$where = array('DEMA_Estado'=>'0','DEMA_Tipo'=>$tipo);
		$this->db->where($where)->delete($this->tabla);
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
		}else{
			$this->db->trans_commit();
		}
	}
	
	public function actualizar_demanda($tipo){
		$this->db->trans_begin();
		//elimina los detalles que sean de estado CERO
		$this->detalledemanda_model->acualizar_detalle_demanda($tipo);
		$where = array('DEMA_Estado'=>'0','DEMA_TIPO'=>$tipo);
		$data = array('DEMA_Estado'=>'1');
		$this->db->where($where)->update($this->tabla,$data);
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
		}else{
			$this->db->trans_commit();
		}
	}
	
}
?>