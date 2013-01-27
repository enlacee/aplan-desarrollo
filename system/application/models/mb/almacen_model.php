<?php

class Almacen_model extends Model {

    //put your code here

    function __construct() {
        parent :: __construct();
        //$this->load->database();
    }

    public function add($post) {
        $this->db->insert('mb_almacen', (array) $post);
        return true;
    }

    public function edit($codigo, stdClass $post = null) {
        $this->db->where('codigo', $codigo);
        $this->db->update('mb_almacen', (array) $post);
        return true;
    }

    public function del($codigo) {
        $where = array('Codigo' => $codigo);
        $this->db->delete('mb_almacen', $where);
    }

    //-----------------------------------------------------------------------------------
    public function listar($descripcion='',$number_items='',$offset='') {
        //$query = $this->db->get('mb_almacen');
        //return $query->result();
        
            if ( $descripcion != '' )
                $this->db->like('nombre_almacen',$descripcion);
            
            $this->db->where( 'estado', 1 );
            $this->db->order_by( 'nombre_almacen', 'asc' );
            $query = $this->db->get( 'mb_almacen', $number_items,$offset );
            if ( $query->num_rows > 0 )
                return $query->result();        
        
    }

    public function obtener_almacen($id) {

        $where = array('codigo' => $id);
        $query = $this->db->where($where)->get('mb_almacen', 1);
        if ($query->num_rows > 0)
            return $query->result();
    }

    //------------------

    public function eliminar_almacen($cod) {
        $where = array('codigo' => $cod);
        $this->db->delete('mb_almacen', $where);
    }

    public function modificar_almacen($codigo, stdClass $filter = null) {
        $this->db->where('codigo', $codigo);
        $this->db->update('mb_almacen', (array) $filter);
    }

    public function insertar(stdClass $filter = null) {
        $this->db->insert('mb_almacen', (array) $filter);
    }

}

?>
