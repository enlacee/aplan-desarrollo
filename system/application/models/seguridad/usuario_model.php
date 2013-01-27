<?php
class Usuario_model extends Model
{
	public function __construct()
	{
            parent::__construct();
            $this->load->database();
            $this->load->helper('date');
			$this->load->model('seguridad/usuario_compania_model');
            $this->somevar ['usuario']  = $this->session->userdata('usuario');
			$this->somevar ['compania'] = $this->session->userdata('compania');
            $this->somevar['hoy']       = mdate("%Y-%m-%d %h:%i:%s",time());
	}
	public function listar_usuarios($number_items='',$offset=''){		
		//$DB1 = $this->load->database('bd_transacciones',TRUE);
		/*$where = array("USUA_FlagEstado"=>"1","COMP_"=>"");
		//$query = $DB1->where($where)->get('cji_usuario',$number_items,$offset);
		$query = $this->db->where($where)->get('cji_usuario',$number_items,$offset);
		if($query->num_rows>0){
			foreach($query->result() as $fila){
				$data[] = $fila;
			}
			return $data;
		}*/
		$compania = $this->somevar ['compania'];
		$where = array("USUA_FlagEstado"=>"1","c.COMP_Codigo"=>$compania);
		$this->db->select('*');
		$this->db->from('cji_usuario u');
		$this->db->join('cji_usuario_compania uc', 'u.USUA_Codigo = uc.USUA_Codigo');
		$this->db->join('cji_compania c', 'c.COMP_Codigo = uc.COMP_Codigo', 'right');
		$query = $this->db->where($where)->get();
		if($query->num_rows>0){
			foreach($query->result() as $fila){
				$data[] = $fila;
			}
			return $data;
		}
	}
    public function obtener($usuario){
		$this->db->select('*');
		$this->db->from('cji_usuario');
		$this->db->join('cji_persona','cji_persona.PERSP_Codigo=cji_usuario.PERSP_Codigo');
		$this->db->where('cji_usuario.USUA_Codigo',$usuario);
		$query = $this->db->get();
		if($query->num_rows>0){
		   return $query->row();
		}
    }
	
	public function obtener_datosUsuario($user,$clave){
		$where = array('USUA_usuario'=>$user,'USUA_Password'=>$clave,'USUA_FlagEstado'=>'1');
		$query = $this->db->where($where)->get('cji_usuario');
		if($query->num_rows>0){
			foreach($query->result() as $fila){
					$data[] = $fila;
			}
			return $data;
		}
	}
  
	public function obtener_datosUsuarioLogin($user,$clave,$compania){
		$sql = "SELECT * FROM cji_usuario_compania uc 
		JOIN cji_compania c ON uc.COMP_Codigo = c.COMP_Codigo 
		JOIN cji_usuario u ON u.USUA_Codigo = uc.USUA_Codigo 
		WHERE u.USUA_usuario = '".$user."' AND u.USUA_Password='".$clave."' AND u.USUA_FlagEstado = 1 AND uc.COMP_Codigo ='".$compania."' ";
		$query_otra = $this->db->query($sql);        
		if($query_otra->num_rows > 0){
			$where = array('USUA_usuario'=>$user,'USUA_Password'=>$clave,'USUA_FlagEstado'=>'1');
			$query_nueva = $this->db->where($where)->get('cji_usuario');
			if($query_nueva->num_rows>0){
				foreach($query_nueva->result() as $fila){
						$data[] = $fila;
				}
				return $data;
			}
		}
	}
  
	public function obtener_datosUsuario2($usuario)
	{
            $query = $this->db->where('USUA_Codigo',$usuario)->get('cji_usuario');
            if($query->num_rows>0){
                foreach($query->result() as $fila){
                    $data[] = $fila;
                }
                return $data;
            }
	}
	public function insertar_usuario($persona,$rol,$usuario,$clave){
		$data = array(
					"PERSP_Codigo"       => $persona,
					"ROL_Codigo"           => $rol,
					"USUA_usuario"      => $usuario,
					"USUA_Password" => md5($clave)
					 );
		$this->db->insert("cji_usuario",$data);
	}
	public function insertar_datosUsuario($txtNombres,$txtPaterno,$txtMaterno,$txtUsuario,$txtClave,$cboRol){
		$this->db->trans_begin();
		$this->persona_model->insertar_datosPersona($txtNombres,$txtPaterno,$txtMaterno);
		$persona = $this->db->insert_id();
		$this->insertar_usuario($persona,$cboRol,$txtUsuario,$txtClave);
		$usuario = $this->db->insert_id();
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
		}else{
			$this->db->trans_commit();
		}
		return $usuario;
	}
	public function modificar_datosUsuario($usuario,$rol,$nombre_usuario,$nombres,$paterno,$materno)
	{
            $datos_usuario = $this->obtener_datosUsuario2($usuario);
            $persona       = $datos_usuario[0]->PERSP_Codigo;
            $this->persona_model->modificar_datosPersona_nombres($persona,$nombres,$paterno,$materno);
            $this->modificar_usuario($usuario,$rol,$nombre_usuario);
	}
	public function modificar_usuario($usuario,$rol,$nombre_usuario)
	{
            $data = array("ROL_Codigo" => $rol,
                          "USUA_usuario" => $nombre_usuario);
            $this->db->where('USUA_Codigo',$usuario);
            $this->db->update("cji_usuario",$data);
	}
	public function modificar_usuario2($usuario,$nombre_usuario)
	{
            $data = array("USUA_usuario" => $nombre_usuario);
            $this->db->where('USUA_Codigo',$usuario);
            $this->db->update("cji_usuario",$data);
	}
	public function modificar_usuarioClave($usuario,$clave)
	{
            $data = array("USUA_Password" => md5($clave));
            $this->db->where('USUA_Codigo',$usuario);
            $this->db->update("cji_usuario",$data);
	}
	public function eliminar_usuario($usuario){
		$this->db->trans_begin();
		//elimina de la tabla cji_usuario_compania
		$elimina = $this->usuario_compania_model->eliminar_usuario_compania($usuario);
		//elimina TRUE OR FALSE
		if($elimina){
			$where = array("USUA_Codigo"=>$usuario);
			$this->db->delete('cji_usuario',$where);
			//elimina de la tabla usuario, pero ahora no va a
			//eliminar porque primero tiene que ver si no
			//tiene mas registros en la tabla cji_usuario_compania
			/*$where = array("USUA_Codigo"=>$usuario);
			$this->db->delete('cji_usuario',$where);*/
			//comentamos la linea de abajo porque, por ahora cuando elimine al usuario,
			//lo elimine de todas las companias
			//$cantidad_registros = count($this->usuario_compania_model->buscar_usuario_compania($usuario));
			//if($cantidad_registros == 0){
				//if aún tiene registros en la tabala cji_usuario_compania
				/*$where = array("USUA_Codigo"=>$usuario);
				$this->db->update('cji_usuario',$where);*/
			//}
		}
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
		}else{
			$this->db->trans_commit();
		}
	}
	
	public function buscar_usuarios($filter,$number_items='',$offset='')
	{
            $wherenombres ="";
            $whereusuario = "";
            $whererol     = "";
            if(isset($filter->nombres) && $filter->nombres!=""){$wherenombres="and concat(b.PERSC_Nombre,' ',b.PERSC_ApellidoPaterno,' ',b.PERSC_ApellidoMaterno) like '%".$filter->nombres."%'";}
            if(isset($filter->usuario) && $filter->usuario!=''){$whereusuario="and a.USUA_usuario like '".$filter->usuario."%'";}
            if(isset($filter->rol) && $filter->rol!=''){$whererol="and c.ROL_Descripcion like '".$filter->rol."%'";}
            $sql = "
                     select
                     a.USUA_Codigo,
                     a.PERSP_Codigo,
                     a.ROL_Codigo,
                     a.USUA_usuario
                     from cji_usuario as a
                     inner join cji_persona as b on a.PERSP_Codigo=b.PERSP_Codigo
                     inner join cji_rol as c on a.ROL_Codigo=c.ROL_Codigo
                     where a.USUA_FlagEstado='1'
                     ".$wherenombres."
                     ".$whereusuario."
                     ".$whererol."
                     ";
            $query = $this->db->query($sql);
            if($query->num_rows>0){
                foreach($query->result() as $fila){
                    $data[] = $fila;
                }
                return $data;
            }
	}
}
?>