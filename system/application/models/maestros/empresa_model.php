<?php
class Empresa_model extends Model{
    var $somevar;
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('date');
        $this->somevar ['compania'] = $this->session->userdata('compania');
        $this->somevar['hoy']       = mdate("%Y-%m-%d %h:%i:%s",time());
    }
	
    public function obtener_datosEmpresa($empresa){
        $query = $this->db->where('EMPR_Codigo',$empresa)->get('cji_empresa');
        if($query->num_rows>0){
            foreach($query->result() as $fila){
                    $data[] = $fila;
            }
            return $data;
        }
    }
	
	public function insertar_empresa($filter){
		$this->db->insert('cji_empresa',$filter);
		return $this->db->insert_id();
	}
	
	public function modificar_empresa($filter,$empresa){
		$where = array('EMPR_Codigo'=>$empresa);
		$this->db->where($where)->update('cji_empresa',$filter);
	}
	
	public function eliminar_empresa($empresa){
		$where = array('EMPR_Codigo'=>$empresa);
		$filter = new stdClass();
		$filter->EMPR_Estado = 0;
		$this->db->where($where)->update('cji_empresa',$filter);
	}
	
}
?>