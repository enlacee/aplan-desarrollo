<?php
class Configuracionmensaje_Model extends Model{
    protected $_name = "cji_configuracionmensaje";
	var $somevar;
    public function  __construct(){
        parent::__construct();
        $this->load->database();
        $this->somevar['compania'] = $this->session->userdata('compania');
		$this->somevar['compania_hija']	= $this->session->userdata('compania_hija');
    }
	
	//POR AHORA ESTA SIN PARAMETROS, CONSIDERO QUE CADA COMPAÑIA TIENE UNA SOLA CONFIGURACION
	public function obtener_configuracionmensaje(){
		//echo $this->somevar['compania_hija'];exit;
		$where = array('m.CMEN_Estado '=>'1','cm.COMP_Codigo'=>$this->somevar['compania_hija']);
		$query = $this->db->select('*')
					  ->from('cji_configuracionmensaje m')
					  ->join('cji_companiaconfiguracionm cm', 'm.CMEN_Codigo  = cm.CMEN_Codigo')
					  ->where($where)->get();
        if($query->num_rows>0){
			foreach($query->result() as $fila){
				$data[] = $fila;
			}
			return $data;
        }
	}
	
	public function editar_configuracionmensaje($codigo_configuracionm,$filter){
		$where = array('CMEN_Codigo'=>$codigo_configuracionm);
		$retorno = $this->db->where($where)->update($this->_name,$filter);
		return $retorno;
	}
	
	public function insertar_configuracionmensaje($filter){
		$this->db->insert($this->_name,$filter);
	}
	
	
}
?>