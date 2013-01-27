<?php if ( ! defined('BASEPATH') ) exit('No direct script access allowed');

    class Books extends Controller {
	
	function __construct(){
            parent::__construct();
	}
	public function index(){
		// Cargar librería de 'table'
		$this->load->library('table');
		// Consulta a la base de datos, y obtener resultados
		$data['books'] = $this->db->get('books');
		
		// Crear cabezera personalizada
		$header = array('Book ID', 'Book Name', 'Book Description', 'Book Author');
		// Establecer los títulos
		$this->table->set_heading($header);
		// Cargar el view, y enviar los resultados
		$this->load->view('books_view', $data);
	}
}
?>