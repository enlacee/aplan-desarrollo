<?php
class Permiso_model extends Model{
     var $somevar;
	function __construct(){
		parent::__construct();
		$this->load->database();
        $this->load->helper('date');
        $this->somevar['hoy']              = mdate("%Y-%m-%d %h:%i:%s",time());
	}
        function busca_permiso($rol, $menu){
		$query = $this->db->where('ROL_Codigo',$rol)->where('MENU_Codigo', $menu)->get('cji_permiso');
		if($query->num_rows>0){
			foreach($query->result() as $fila){
				$data[] = $fila;
			}
			return $data;
		}
                else
                    return array();
	}
        public function insertar(stdClass $filter = null)
        {
            $this->db->insert("cji_permiso",(array)$filter);
        }

        public function eliminar_varios($rol)
        {
            $this->db->delete('cji_permiso',array('ROL_Codigo' => $rol));
        }
	public function obtener_permisosMenu($perfil_id){
		$CI = get_instance();
                $qu = $CI->db->from('cji_menu')
                        ->join('cji_permiso','cji_permiso.MENU_Codigo  = cji_menu.MENU_Codigo ','inner')
                        ->where('cji_permiso.ROL_Codigo',$perfil_id)
                        ->where('MENU_Codigo_Padre',0)
                        ->where('cji_menu.MENU_FlagEstado',1)
                        ->get();
                $rows = $qu->result();
                
                foreach($rows as $row){
                    $qur = $CI->db->from('cji_menu')
                        ->join('cji_permiso','cji_permiso.MENU_Codigo  = cji_menu.MENU_Codigo ','inner')
                        ->where('cji_permiso.ROL_Codigo ',$perfil_id)
                        ->where('MENU_Codigo_Padre',$row->MENU_Codigo)
                        ->get();
                     $row->submenus = $qur->result();
                }
                return $rows;
	}
}
?>