<?php

class Grupo_Temporada_Detalle_Model extends Model {

    //put your code here  grupo_temporada_detalle_model
    private $tabla = 'mb_grupo_temporada_detalle';

    function __construct() {
        parent :: __construct();
        $this->load->database();
        $this->load->helper('date');
        $this->load->model('seguridad/permiso_model');
        $this->load->model('seguridad/menu_model');
        $this->somevar['compania'] = $this->session->userdata('compania');
        $this->somevar['usuario'] = $this->session->userdata('usuario');
        $this->somevar['hoy'] = mdate('%Y-%m-%d %h:%i:%s', time());
    }



    public function listar($number_items='',$offset='') {
        $this->db->select('mb_grupo_temporada_detalle.Codigo AS id,
                           mb_temporada.Codigo,
                           mb_temporada.Descripcion                           
                          ');
        $this->db->from('mb_grupo_temporada_detalle');
        $this->db->join('mb_temporada', 'mb_grupo_temporada_detalle.CodigoTemporada = mb_temporada.Codigo');
        if($offset !='')
        $this->db->where('mb_grupo_temporada_detalle.CodigoGrupo', $offset);
        
        $this->db->limit($number_items);
        $query = $this->db->get();
        if ( $query->num_rows > 0 )
            return $query->result();

    }
    
        public function insertar( $post ) {
            $query = $this->db->insert($this->tabla, $post);
            return $this->db->insert_id();
        }
        
        
        public function eliminar($codigo){
            
            $where = array( 'Codigo'=>$codigo );
            $query = $this->db->delete( $this->tabla, $where );
            return true;            
        }

}

?>
