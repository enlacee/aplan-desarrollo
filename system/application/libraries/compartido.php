<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Compartido{
	
	function buscar_compartidos($tipo_busqueda){
		$ci = &get_instance();
		$ci->load->model("configuracion/configuracionsistema_model");
		$compania_hija	= $ci->session->userdata('compania_hija');
		$array_compartidos = array();
		$configuracions = '';
		switch($tipo_busqueda){
			case 1:
				// para calendarios
				$configuracions = $ci->configuracionsistema_model->buscar_compartidos(1,1);
				break;
			case 2:
				// para mensajes
				$configuracions = $ci->configuracionsistema_model->buscar_compartidos(2,1);
				break;
			case 3:
				// para OT
				$configuracions = $ci->configuracionsistema_model->buscar_compartidos(3,1);
				break;
			case 4:
				// para OC
				$configuracions = $ci->configuracionsistema_model->buscar_compartidos(4,1);
				break;
		}
		
		if(count($configuracions) > 0){
			foreach($configuracions as $value){
				$array_compartidos[] = $value->COMP_Codigo;
			}
		}
		array_push($array_compartidos,$compania_hija);
		return $array_compartidos;
	}
	
}
?>