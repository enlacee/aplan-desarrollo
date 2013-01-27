<?php
class Usuario_compania_model extends Model{
	
	public function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->helper('date');
		$this->somevar ['usuario']  = $this->session->userdata('usuario');
		$this->somevar['compania'] = $this->session->userdata('compania');
		$this->somevar['hoy']       = mdate("%Y-%m-%d %h:%i:%s",time());
	}
	
	public function insertar_usuario_compania($usuario,$compania){
		$data = array(
			"USUA_Codigo"	=> $usuario,
			"COMP_Codigo"	=> $compania
		);
		$this->db->insert("cji_usuario_compania",$data);
		return $this->db->insert_id();
	}
	
	public function eliminar_usuario_compania($usuario){
		//la variable $usuario se usa para eliminar el registro 
		//de la tabla cji_usuario_compania, porque el usuario puede
		//pertenecer a varias companias, y solo la tengo que elimianr
		//de la compania que se selecciono
		//$compania = $this->somevar['compania'];
		//$where = array("USUA_Codigo"=>$usuario,"COMP_Codigo"=>$compania);
		$where = array("USUA_Codigo"=>$usuario);
		$query = $this->db->delete('cji_usuario_compania',$where);
		return $query;
	}
	
	public function buscar_usuario_compania($usuario){
		//esta funcion es para saber si el usuario esta en otra companias,
		//y si el resultado es mayor a cero, entonces NO elimino al usuario
		//si no(igual a cero) lo elimina, porque ya no pertenece a mas companias
		$where = array("USUA_Codigo"=>$usuario);
		$query = $this->db->where($where)->get('cji_usuario_compania');
		if($query->num_rows>0){
			foreach($query->result() as $fila){
				$data[] = $fila;
			}
			return $data;
		}
	}
}
?>