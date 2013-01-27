<?php
class Tablalog_model extends Model{
	
	public function __construct(){
		parent::__construct();
		$this->load->database();
        $this->load->helper('date');
        $this->somevar ['compania'] = $this->session->userdata('compania');
        $this->somevar ['usuario']	= $this->session->userdata('usuario');
        $this->somevar['hoy']		= mdate("%Y-%m-%d");
	}
	
	public function listar_log($flag){
		$where = array('TLOG_Flag'=>$flag,'TLOG_Fecha'=>$this->somevar['hoy']);
		$query = $this->db->where($where)->get('cji_tablalog');
		if($query->num_rows>0){
			foreach($query->result() as $fila){
				$data[] = $fila;
			}
			return $data;
		}
	}
	
	public function insertar_log($filter){
		$data 						= new StdClass();
		$data->TLOG_NombreArchivo	= $filter->archivo;
		$data->TLOG_Tabla			= $filter->tabla;
		$data->TLOG_Flag			= $filter->flag;
		$data->TLOG_Detalle			= $filter->detalle;
		$data->TLOG_Fecha			= $this->somevar['hoy'];
		$this->db->insert("cji_tablalog",$data);
	}
	
	public function eliminar_log($flag){
		$where = array("TLOG_Flag"=>$flag,"TLOG_Fecha"=>$this->somevar['hoy']);
		$this->db->where($where);
		$this->db->delete('cji_tablalog');
	}
}
?>