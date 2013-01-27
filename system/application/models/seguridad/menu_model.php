<?php
class Menu_model extends Model{
     var $somevar;
	function __construct(){
		parent::__construct();
		//$db1 = $this->load->database('bd_maestros',TRUE);
        $this->load->helper('date');
        $this->somevar['hoy']              = mdate("%Y-%m-%d %h:%i:%s",time());
	}
	function obtener_datosMenu($menu){
		//$query = $db1->where('MENU_Codigo',$menu)->get('cji_menu');
		$query = $this->db->where('MENU_Codigo',$menu)->get('cji_menu');
		if($query->num_rows>0){
			foreach($query->result() as $fila){
				$data[] = $fila;
			}
			return $data;		
		}			
	}
      

       





}
?>