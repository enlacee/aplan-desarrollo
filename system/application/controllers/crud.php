<?php
class Crud extends Controller{
  public function __construct(){
    parent::Controller();
	$this->load->scaffolding('cji_usuario');
  }
  public function index(){
		
  }
}
?>