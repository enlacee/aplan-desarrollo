<?php
class Detalledemanda_model extends Model{
	protected $tabla = "cji_detalledemanda";
	public function __construct(){
		parent::__construct();
		$this->load->database();
        $this->load->helper('date');
        $this->somevar ['compania']	= $this->session->userdata('compania');
        $this->somevar ['usuario']	= $this->session->userdata('usuario');
        $this->somevar['hoy']       = mdate("%Y-%m-%d %h:%i:%s",time());
	}
	public function insertar_detalle_demanda($filter){
		$data 					= new StdClass();
		$data->PERI_Codigo		= $filter->cod_periodo;
		$data->DEMA_Codigo		= $filter->cod_demanda;
		$data->DDEM_Cantidad	= $filter->cantidad;
		$data->DDEM_Mes			= $filter->mes;
		$data->DDEM_Anio		= $filter->anio;
		$data->DDEM_Tipo		= $filter->tipo;
		$this->db->insert($this->tabla,$data);
	}
	
	public function obtener_detalle_demanda($periodo,$demanda){
		$where = array("PERI_Codigo"=>$periodo,"DEMA_Codigo"=>$demanda);
		$query = $this->db->where($where)->get($this->tabla);
		if ($query->num_rows > 0) {
            return $query->result();
        }else
            return array();
	}
	
	public function eliminar_detalle_demanda($tipo){
		$where = array('DDEM_Estado'=>'0','DDEM_Tipo'=>$tipo);
		$this->db->where($where)->delete($this->tabla);
	}
	
	public function acualizar_detalle_demanda($tipo){
		$where = array('DDEM_Estado'=>'0','DDEM_Tipo'=>$tipo);
		$data = array('DDEM_Estado'=>'1');
		$this->db->where($where)->update($this->tabla,$data);
	}
	
}
?>