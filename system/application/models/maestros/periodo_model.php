<?php
class Periodo_model extends Model{
	protected $tabla='cji_periodo';
	public function __construct(){
		parent::__construct();
		$this->load->database();
        $this->load->helper('date');
        $this->somevar ['compania'] = $this->session->userdata('compania');
        $this->somevar ['usuario'] 	= $this->session->userdata('usuario');
        $this->somevar['hoy']       = mdate("%Y-%m-%d %h:%i:%s",time());
	}
	
	public function insertar_periodo($filter){
		$data 				= new StdClass();
		$data->PERI_Anio	= $filter->anio;
		$data->PERI_Mes		= $filter->mes;
		$this->db->insert($this->tabla,$data);
	}
	
	public function listar_anios_periodo(){
		$this->db->select('YEAR(PERI_Inicio) anio');
		$this->db->distinct();
		$query = $this->db->get($this->tabla);
		if($query->num_rows>0){
			foreach($query->result() as $key=>$fila){
				$data[] = $fila;
			}
			return $data;
		}
	}
	
	public function listar_meses_periodo(){
		$this->db->select('MONTH(PERI_Inicio) mes');
		$this->db->distinct();
		$query = $this->db->order_by('MONTH(PERI_Inicio)','asc')->get($this->tabla);
		if($query->num_rows>0){
			foreach($query->result() as $fila){
				$data[] = $fila;
			}
			return $data;
		}
	}
	
	public function obtener_periodo($periodo){
		$where = array("PERI_Aux"=>$periodo);
		$query = $this->db->like($where)->get($this->tabla,1);
		if ($query->num_rows > 0) {
            return $query->result();
        }else
            return array();
	}
	
	public function listar_periodos_con_detalles($producto){
		$where = array("d.PROD_Codigo"=>$producto);
		$this->db->select('p.PERI_Codigo,p.PERI_Aux,dd.DEMA_Codigo');
		$this->db->from('cji_periodo p');
		$this->db->join('cji_detalledemanda dd', 'p.PERI_Codigo = dd.PERI_Codigo');
		$this->db->join('cji_demanda d', 'd.DEMA_Codigo = dd.DEMA_Codigo');
		$query = $this->db->where($where)->group_by('p.PERI_Codigo')->get();
		if ($query->num_rows > 0) {
            return $query->result();
        }else
            return array();
	}
	
}
?>