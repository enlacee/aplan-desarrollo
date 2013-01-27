<?php

class Grupo_Temporadas extends Controller {

    public function __construct() {
        parent :: __construct();
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->library('pagination');
        $this->load->library('html');
        $this->load->model('mb/temporada_model');
        $this->load->model('mb/grupo_temporadas_model');
        $this->load->model('mb/grupo_temporada_detalle_model');
        $this->somevar['compania'] = $this->session->userdata('compania');
        $this->somevar['empresa'] = $this->session->userdata('empresa');
    }

    public function index() {
        $this->load->library('layout', 'layout');
        $this->layout->view('seguridad/inicio');
    }

    public function listar($j = '0') {
        $this->load->library('layout', 'layout');
        $data['registros'] = count($this->grupo_temporadas_model->listar());
        $conf['base_url'] = site_url('mb/grupo_temporadas/listar/');
        $conf['total_rows'] = $data['registros'];
        $conf['per_page'] = 5;
        $conf['num_links'] = 3;
        $conf['next_link'] = "&gt;";
        $conf['prev_link'] = "&lt;";
        $conf['first_link'] = "&lt;&lt;";
        $conf['last_link'] = "&gt;&gt;";
        $conf['uri_segment'] = 4;
        $offset = $this->uri->segment(4);

        $this->pagination->initialize($conf);
        $data['paginacion'] = $this->pagination->create_links();
        $listado = $this->grupo_temporadas_model->listar('', $conf['per_page'], $offset);
        $item = $j + 1;
        $lista = array();

        if (count($listado) > 0) {
            foreach ($listado as $indice => $valor) {
                $codigo = $valor->Codigo;
                $nombre = $valor->NombreGrupo;
                $fecha = $valor->FechaRegistro;
                $lista[] = array($item++, $codigo, $nombre, $fecha);
            }
        }

        $data['lista'] = $lista;
        $data['titulo_busqueda'] = 'BUSCAR GRUPOS DE TEMPORADAS';

        $data['filtro'] = form_input(array('name' => 'filtro',
            'id' => 'filtro',
            'class' => 'cajaMediana',
            'maxlength' => '20',
            'value' => ''));

        $data['form_open'] = form_open(base_url() . 'index.php/mb/grupo_temporadas/buscar', array('name' => 'form_busquedaGrupoTemporadas',
            'id' => 'form_busquedaGrupoTemporadas'));
        $data['form_close'] = form_close();
        $data['titulo_tabla'] = "RELACION DE GRUPOS DE TEMPORADAS";
        $data['oculto'] = form_hidden(array('base_url' => base_url()));
        $this->layout->view('mb/grupo_temporadas_index', $data);
    }

    public function buscar($j = 0) {
        $this->load->library('layout', 'layout');
        $filtro = $this->input->post('filtro');
        $data['registros'] = count($this->grupo_temporadas_model->listar($filtro));

        $conf['base_url'] = site_url('mb/grupo_temporadas/buscar/');
        $conf['per_page'] = 10;
        $conf['num_links'] = 3;
        $conf['first_link'] = "&lt;&lt;";
        $conf['last_link'] = "&gt;&gt;";
        $conf['total_rows'] = $data['registros'];
        $offset = (int) $this->uri->segment(4);
        $listado = $this->grupo_temporadas_model->listar($filtro, $conf['per_page'], $offset);
        $item = $j + 1;
        $lista = array();

        if (count($listado) > 0) {
            foreach ($listado as $indice => $valor) {
                $codigo = $valor->Codigo;
                $nombre = $valor->NombreGrupo;
                $fecha = $valor->FechaRegistro;
                $lista[] = array($item++, $codigo, $nombre, $fecha);
            }
        }
        $data['titulo_tabla'] = 'RESULTADO DE LA BUSQUEDA DE GRUPOS DE TEMPORADAS';
        $data['titulo_busqueda'] = 'BUSCAR GRUPOS DE TEMPORADAS';
        $data['filtro'] = form_input(array('name' => 'filtro',
            'id' => 'filtro',
            'class' => 'cajaMediana',
            'maxlength' => '20',
            'value' => $filtro));
        $data['form_open'] = form_open(base_url() . 'index.php/mb/grupo_temporadas/buscar', array('name' => 'form_busquedaGrupoTemporadas',
            'id' => 'form_busquedaGrupoTemporadas'));
        $data['form_close'] = form_close();
        $data['lista'] = $lista;
        $data['oculto'] = form_hidden(array('base_url' => base_url()));
        $this->pagination->initialize($conf);
        $data['paginacion'] = $this->pagination->create_links();
        $this->layout->view('mb/grupo_temporadas_index', $data);
    }

    public function ver($cod) {
        $this->load->library('layout', 'layout');
        $listado = $this->grupo_temporadas_model->obtener($cod);
        $lista = array();
        $item = 1;
        if (count($listado) > 0) {
            foreach ($listado as $indice => $valor) {
                $codigo = $valor->Codigo;
                $descripcion = $valor->NombreGrupo;
                $fecha = $valor->FechaRegistro;
                $lista[] = array($item++, $codigo, $descripcion, $fecha);
            }
        }
        $data['lista'] = $lista;
        $data['titulo'] = 'VER GRUPO DE TEMPORADAS';
        $data['oculto'] = form_hidden(array('base_url' => base_url()));

        // new lista de grupo temporada            
        $listado_detalle = $this->grupo_temporada_detalle_model->listar('', $cod);
        $lista_detalle = array();
        if (count($listado_detalle) > 0) {
            foreach ($listado_detalle as $indice => $valor) {

                $codigo = $valor->Codigo;
                $checkTemporada = ''; //"<input type='checkbox' id='' name='checkTemporada[]' value='".$codigo."' />";
                $editar = ''; //"<a href='#' onclick='editar_garantia(".$codigo.")'><img src='".base_url()."images/modificar.png' width='16' height='16' border='0' title='Modificar'></a>";
                $ver = ''; //"<a href='#' onclick='ver_garantia(".$codigo.")'><img src='".base_url()."images/ver.png' width='16' height='16' border='0' title='Ver'></a>";
                $eliminar = ''; //"<a href='#' onclick='eliminar_garantia(".$codigo.")'><img src='".base_url()."images/eliminar.png' width='16' height='16' border='0' title='Eliminar'></a>";
                $lista_detalle[] = array($checkTemporada, $indice, $valor->Codigo, $valor->Descripcion, $editar, $ver, $eliminar);
            }
        }
        $data['lista_detalle'] = $lista_detalle;

        $this->layout->view('mb/grupo_temporadas_ver', $data);
    }

    public function nuevo() {
        $this->load->library('layout', 'layout');
        $data['titulo'] = 'REGISTRAR GRUPO DE TEMPORADAS';
        $data['form_open'] = form_open(base_url() . 'index.php/mb/grupo_temporadas/grabar', array('name' => 'frmGrupoTemporadas',
            'id' => 'frmGrupoTemporadas'));
        $data['form_close'] = form_close();
        $data['codigo'] = '';
        $data['nombre'] = form_input(array('name' => 'nombre',
            'id' => 'nombre',
            'value' => '',
            'maxlength' => '30',
            'class' => 'cajaMedia'));
        $data['oculto'] = form_hidden(array('base_url' => base_url()));

        // new lista de grupo temporada            
        $temporadas = $this->temporada_model->listar();
        //$listado_detalle = $this->grupo_temporada_detalle_model->listar(10,'');
        //var_dump($listado_detalle);
        $lista_detalle = array();
        if (count($temporadas) > 0) {
            foreach ($temporadas as $indice => $valor) {

                $codigo = $valor->Codigo;
                $checkTemporada = "<input type='checkbox' id='' name='checkTemporada[]' value='" . $codigo . "' />";
                $editar = ''; //"<a href='#' onclick='editar_garantia(".$codigo.")'><img src='".base_url()."images/modificar.png' width='16' height='16' border='0' title='Modificar'></a>";
                $ver = ''; //"<a href='#' onclick='ver_garantia(".$codigo.")'><img src='".base_url()."images/ver.png' width='16' height='16' border='0' title='Ver'></a>";
                $eliminar = ''; //"<a href='#' onclick='eliminar_garantia(".$codigo.")'><img src='".base_url()."images/eliminar.png' width='16' height='16' border='0' title='Eliminar'></a>";
                $lista_detalle[] = array($checkTemporada, $indice, $valor->Codigo, $valor->Descripcion, $editar, $ver, $eliminar);
            }
        }
        $data['lista_detalle'] = $lista_detalle;

        $this->layout->view('mb/grupo_temporadas_nuevo', $data);
    }

    public function grabar() {
        $this->form_validation->set_rules('nombre', 'Nombre del grupo de temporadas', 'required');
        $filter = new stdClass();

        if ($this->form_validation->run() == false)
            $this->nuevo();
        else {
            $nombre = $this->input->post('nombre');
            $filter->NombreGrupo = $nombre;
            $id_grupo = $this->grupo_temporadas_model->insertar($filter);

            // new registrar nuevos temporadas detalle
            $checkbox = $this->input->post('checkTemporada');

            if (is_array($checkbox)) {
                foreach ($checkbox as $key => $value) {

                    $post = array(
                        'CodigoTemporada' => $checkbox[$key],
                        'CodigoGrupo' => $id_grupo
                    );
                    $this->grupo_temporada_detalle_model->insertar($post);
                }
            }

            $this->listar();
        }
    }

    public function eliminar() {
        $cod = $this->input->post('cod');
        $this->grupo_temporadas_model->eliminar($cod);
    }

    public function eliminar_detalle() {
        $cod = $this->input->post('cod');
        $this->grupo_temporada_detalle_model->eliminar($cod);
    }

    public function editar($cod) {
        $this->load->library('layout', 'layout');
        $datos = $this->grupo_temporadas_model->obtener($cod);
        $codigo = $datos[0]->Codigo;
        $nombre = $datos[0]->NombreGrupo;
        $data['modo'] = 'modificar';
        $data['form_open'] = form_open(base_url() . 'index.php/mb/grupo_temporadas/modificar', array('name' => 'frmGrupoTemporadas',
            'id' => 'frmGrupoTemporadas'));
        $data['form_close'] = form_close();
        $data['nombre'] = form_input(array('name' => 'nombre',
            'id' => 'nombre',
            'value' => $nombre,
            'maxlength' => '30',
            'class' => 'cajaMedia'));
        $data['oculto'] = form_hidden(array('base_url' => base_url()));
        $data['codigo'] = $codigo;
        $data['titulo'] = 'EDITAR GRUPO DE TEMPORADAS';

        
        // new lista de grupo temporada            
        $temporadas = $this->temporada_model->listar();
        
        $listado_detalle = $this->grupo_temporada_detalle_model->listar('', $codigo);

        //var_dump($listado_detalle);
        $lista_detalle = array();
        if (count($temporadas) > 0) {            
            foreach ($temporadas as $indice => $valor) {
                $bandera = false;
                $id = '';
                if($listado_detalle){
                foreach ($listado_detalle as $key => $value) {
                    if($valor->Codigo == $value->Codigo){
                        $id = $value->id;
                        $checkTemporada = "OK";
                        $bandera = true;
                        break;
                    }
                }
                }
                
                $checkImg = "<img border='0' src='".  base_url()."/images/icono_aprobar.png'>";
                    
                $eliminar='';
                if($bandera){                    
                    $eliminar = "<a href='#' onclick='eliminar_grupo_temporada_detalle(" . $codigo . "," . $id . ")'><img src='" . base_url() . "images/eliminar.png' width='16' height='16' border='0' title='Eliminar'></a>";
                    $checkTemporada = "<input type='hidden' checked ='checked' id='' name='checkTemporada[]' value='" . $valor->Codigo . "' />";
                    $checkTemporada .= $checkImg;
                }else{
                    $checkTemporada = "<input type='checkbox' id='' name='checkTemporada[]' value='" . $valor->Codigo . "' />";
                }                
                $lista_detalle[] = array($checkTemporada, $indice, $valor->Codigo, $valor->Descripcion, $eliminar);
            }

        }
        $data['lista_detalle'] = $lista_detalle;


        $this->layout->view('mb/grupo_temporadas_nuevo', $data);
    }

    public function modificar() {
        $this->form_validation->set_rules('nombre', 'Nombre de grupo de temporadas', 'required');
        $codigo = $this->input->post('codigo');
        $nombre = $this->input->post('nombre');
        $filter = new stdClass();
        if ($this->form_validation->run() == false)
            $this->editar_grupo($codigo);
        else {
            // UPDATE
            $filter->NombreGrupo = $nombre;
            $this->grupo_temporadas_model->modificar($codigo, $filter);
            //var_dump($codigo);
            //INSERT
            $this->grupo_temporada_detalle_model->eliminar($codigo);

            //new modificar temporadas detalle            
            $checkbox = $this->input->post('checkTemporada');

            if (is_array($checkbox)) {
                foreach ($checkbox as $key => $value) {

                    $post = array(
                        'CodigoTemporada' => $checkbox[$key],
                        'CodigoGrupo' => $codigo
                    );
                    $this->grupo_temporada_detalle_model->insertar($post);
                }
            }            
            
            $this->listar();
        }
    }

}

?>