<?php
class Familia_model extends model{
    var $somevar;
	protected $tabla = 'cji_familia';
	function __construct(){
		parent::__construct();
		$this->load->database();
	}
	
	public function listar_familia_x_padre($cod_padre){
		$where = array('FAMI_Estado !='=>'0','FAMI_Codigo2'=>$cod_padre);
		$query = $this->db->where($where)->get($this->tabla);
		if($query->num_rows>0){
			foreach($query->result() as $fila){
				$data[] = $fila;
			}
			return $data;
		}
	}
	
	public function obtener_familia_codigo_interno($cod_interno){
		$query = $this->db->where('FAMI_CodigoInterno',$cod_interno)->get($this->tabla,1);
		if($query->num_rows>0){
			foreach($query->result() as $fila){
				$data[] = $fila;
			}
			return $data;
		}
	}
	
	public function obtener_linea_codigo_interno($cod_interno){
		$where = array('FAMI_CodigoInterno'=>$cod_interno,'FAMI_Codigo2'=>'0');
		$query = $this->db->where($where)->get($this->tabla,1);
		if($query->num_rows>0){
			foreach($query->result() as $fila){
				$data[] = $fila;
			}
			return $data;
		}
	}
	
	public function obtener_familia_padre($cod_interno,$linea){
		$where = array('FAMI_CodigoInterno'=>$cod_interno,'FAMI_Codigo2'=>$linea);
		$query = $this->db->where($where)->get($this->tabla,1);
		if($query->num_rows>0){
			foreach($query->result() as $fila){
				$data[] = $fila;
			}
			return $data;
		}
	}
	
	public function obtener_familia_hijo($familia,$cod_interno){
		$where = array('FAMI_CodigoInterno'=>$cod_interno,'FAMI_Codigo2'=>$familia);
		$query = $this->db->where($where)->get($this->tabla,1);
		if($query->num_rows>0){
			foreach($query->result() as $fila){
				$data[] = $fila;
			}
			return $data;
		}
	}
	
	public function insertar_familia($filter){
		$this->db->insert($this->tabla,$filter);
	}
}
?>