<?php
class Compania_model extends Model{
	var $somevar;
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
        $this->load->helper('date');
        $this->load->model('maestros/empresa_model');
        $this->somevar ['compania'] = $this->session->userdata('compania');
        $this->somevar ['empresa'] 	= $this->session->userdata('empresa');
        $this->somevar ['user']  = $this->session->userdata('user');
        $this->somevar ['compania_hija']  = $this->session->userdata('compania_hija');
        $this->somevar['hoy']       = mdate("%Y-%m-%d %h:%i:%s",time());
	}
	
	public function insertar_compania($filter){
		$this->db->trans_begin();
		//primero inserta EMPRESA
		$cod_empresa = $this->empresa_model->insertar_empresa($filter);
		//luego inserta COMPAÑIA
		$filterC		 = new stdClass();
		$filterC->COMP_Nombre = 'PRINCIPAL';
		$filterC->COMP_Estado = '1';
		$filterC->COMP_Flag = '1';
		$filterC->EMPR_Codigo = $cod_empresa;
		$this->db->insert('cji_compania',$filterC);
		$cod_compania = $this->db->insert_id();
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
		}else{
			$this->db->trans_commit();
		}
		return array($cod_empresa,$cod_compania);
	}
	
	public function modificar_compania($filter,$compania){
		$this->db->trans_begin();
		$compania = $this->obtener_compania($compania);
		$empresa        	= $compania[0]->EMPR_Codigo;
		$datos_empresa  	= $this->empresa_model->obtener_datosEmpresa($empresa);
		$this->empresa_model->modificar_empresa($filter,$datos_empresa[0]->EMPR_Codigo);
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
		}else{
			$this->db->trans_commit();
		}
	}
	
	public function eliminar_compania($compania){
		$this->db->trans_begin();
		$compania = $this->obtener_compania($compania);
		$where = array('COMP_Codigo'=>$compania[0]->COMP_Codigo);
		$filter = new stdClass();
		$filter->COMP_Estado = 0;
		$this->db->where($where)->update('cji_compania',$filter);
		$this->empresa_model->eliminar_empresa($compania[0]->EMPR_Codigo);
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
		}else{
			$this->db->trans_commit();
		}
	}
	
	/*public function listar_companias(){
		$where = array('COMP_Estado'=>'1','COMP_Flag'=>'1');
		$query = $this->db->where($where)->get('cji_compania');
		if($query->num_rows>0){
			foreach($query->result() as $fila){
			  $data[] = $fila;
			}
			return $data;
		}
	}*/
	
	public function listar_companias($number_items='',$offset=''){
		$where = array('COMP_Estado'=>'1','COMP_Flag'=>'1','COMP_Codigo2'=>'0');
		$query = $this->db->where($where)->get('cji_compania',$number_items,$offset);
		if($query->num_rows>0){
			foreach($query->result() as $fila){
			  $data[] = $fila;
			}
			return $data;
		}
	}
	
	public function listar_companias_hijas_usuario($compania = NULL,$user){
		$where = array('c.COMP_Estado'=>'1','COMP_Codigo2'=>$compania,'uc.USUA_Codigo'=>$user);
		$this->db->from('cji_compania c');
		$this->db->join('cji_usuario_compania uc','c.COMP_Codigo = uc.COMP_Codigo');
		$query = $this->db->where($where)->get('');
		if($query->num_rows>0){
			foreach($query->result() as $fila){
			  $data[] = $fila;
			}
			return $data;
		}
	}
	
	public function listar_companias_hijas(){
		$where = array('COMP_Estado'=>'1','COMP_Codigo2'=>$this->somevar ['compania']);
		$query = $this->db->where($where)->get('cji_compania');
		if($query->num_rows>0){
			foreach($query->result() as $fila){
			  $data[] = $fila;
			}
			return $data;
		}
	}
  
	/*public function listar_companias_usuario(){
        $sql = "SELECT * FROM cji_usuario_compania uc INNER JOIN cji_compania c ON uc.COMP_Codigo = c.COMP_Codigo WHERE USUA_Codigo = '".$this->session->userdata('user')."' order by c.COMP_Codigo asc";
		$query = $this->db->query($sql);
        if($query->num_rows>0){
			foreach($query->result() as $fila){
					$data[] = $fila;
			}
			return $data;
        }        
        return array();
	}*/
	
	public function listar_companias_usuario(){
        $sql = "SELECT * FROM cji_usuario_compania uc INNER JOIN cji_compania c ON uc.COMP_Codigo = c.COMP_Codigo WHERE USUA_Codigo = '".$this->session->userdata('user')."' AND COMP_Codigo2 != 0 AND c.EMPR_Codigo='".$this->session->userdata('empresa')."' ORDER BY c.COMP_Codigo asc";
		$query = $this->db->query($sql);
        if($query->num_rows>0){
			foreach($query->result() as $fila){
					$data[] = $fila;
			}
			return $data;
        }        
        return array();
	}
	
    public function obtener_compania($compania)
	{
        $where = array('COMP_Codigo'=>$compania);
		$query = $this->db->where($where)->get('cji_compania');
		if($query->num_rows>0){
			foreach($query->result() as $fila){
				$data[] = $fila;
			}
			return $data;
		}
    }
	
	public function obtener_compania_hijas($compania){
		$where = array('COMP_Codigo2'=>$compania);
		$query = $this->db->where($where)->get('cji_compania');
		if($query->num_rows>0){
			foreach($query->result() as $fila){
				$data[] = $fila;
			}
			return $data;
		}
	}
	
	/*public function combo_compania($indSel=''){
      $array_compania = $this->compania_model->listar_companias_usuario();
      $arreglo = array();
      $resultado = '';
      if(count($array_compania)>0){
        foreach($array_compania as $indice=>$valor){
			$compania   		= $valor->COMP_Codigo;
			$empresa          	= $valor->EMPR_Codigo;
			$datos_empresa   	= $this->empresa_model->obtener_datosEmpresa($empresa);
			$razon_social       = $datos_empresa[0]->EMPR_RazonSocial;
			$arreglo[$compania] = $valor->COMP_Nombre;
        }
        $resultado = "<select onchange='cambiar_sesion();' name='cboCompania' id='cboCompania' class='comboMedio'>".$this->html->optionHTML($arreglo,$indSel,array('','::Seleccione::'))."</select>";
      }
      return $resultado;
    }*/
	
	public function combo_compania($indSel=''){
		$array_compania = $this->compania_model->listar_companias_usuario();
		//print_r($array_compania);exit;
		//$arreglo = array();
		$codigo_hija = $this->somevar ['compania_hija'];
		$resultado = "<select onchange='cambiar_sesion();' name='cboCompania' id='cboCompania' class='comboMedio'>";
		if(count($array_compania)>0){
			foreach($array_compania as $indice=>$valor){
				$compania   		= $valor->COMP_Codigo;
				$empresa          	= $valor->EMPR_Codigo;
				if($valor->COMP_Codigo == $codigo_hija){
					$resultado .= "<option value='".$compania."' selected='selected' >".$valor->COMP_Nombre."</option>";
				}else{
					$resultado .= "<option value='".$compania."' >".$valor->COMP_Nombre."</option>";
				}
			}
      }
	  $resultado .= "</select>";
      return $resultado;
    }
	
	public function comboEscenarios($escenario){
		$array_compania = $this->compania_model->listar_companias_usuario();
		$resultado = "<select name='cboEscenarios' id='cboEscenarios' class='comboMedio'>";
		if(count($array_compania)>0){
			foreach($array_compania as $indice=>$valor){
				$compania   		= $valor->COMP_Codigo;
				$empresa          	= $valor->EMPR_Codigo;
				if($valor->COMP_Codigo == $escenario){
					$resultado .= "<option value='".$compania."' selected='selected' >".$valor->COMP_Nombre."</option>";
				}else{
					$resultado .= "<option value='".$compania."' >".$valor->COMP_Nombre."</option>";
				}
			}
		}
		$resultado .= "</select>";
		return $resultado;
	}
	
}
?>