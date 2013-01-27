<?php

class Almacen extends Controller {

    public function __construct() {
        parent :: __construct();
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->library('pagination');
        $this->load->library('html');
        $this->load->model('mb/almacen_model');
        $this->somevar['compania'] = $this->session->userdata('compania');
        $this->somevar['empresa'] = $this->session->userdata('empresa');
    }

    public function index() {
        $this->load->library('layout', 'layout');
        $this->layout->view('seguridad/inicio');
    }

    /*
      public function listar_almacenes() {
      echo 'almacenes';
      $this->load->library( 'layout', 'layout' );

      $data['registros']      = count( $this->almacen_model->listar() );
      $data['paginacion']     = $this->pagination->create_links();

      $listado                = $this->almacen_model->listar();
      $data['obj'] = $listado;
      //var_dump($listado);
      $item                   = '';//$j+1;
      $lista                  = array();


      foreach( $listado as $indice=>$valor ) {

      $codigo     = $valor->codigo;
      $nombre     = $valor->nombre_almacen;
      $fecha      = $valor->fecha_registro;
      $fecha_modificacion = $valor->fecha_modificacion;
      //$lista[]    = array( $item++, $codigo, $nombre, $fecha );
      }


      $data['lista']              = $lista;
      $data['titulo_busqueda']    = 'BUSCAR GRUPOS DE TEMPORADAS';

      $data['filtro']             = form_input( array( 'name'=>'filtro',
      'id'=>'filtro',
      'class'=>'cajaMediana',
      'maxlength'=>'20',
      'value'=>'' ) );

      $data['form_open']          = form_open( base_url().'index.php/mb/grupo_temporada/buscar',
      array( 'name'=>'form_busquedaGrupo',
      'id'=>'form_busquedaGrupo' ) );
      $data['form_close']         = form_close();
      $data['titulo_tabla']       = "RELACION DE GRUPOS DE TEMPORADAS";
      $data['oculto']             = form_hidden( array( 'base_url'=>base_url() ) );

      //$this->layout->view( 'mb/grupos_temporadas_index', $data );
      $this->load->view('mb/view_almacen.php',$data);


      }
     */

    public function listar_almacenes($j = '0') {
        $this->load->library('layout', 'layout');

        //$this->load->library( 'layout', 'layout' );
        $data['registros'] = count($this->almacen_model->listar());
        $conf['base_url'] = site_url('mb/grupo_temporada/listar_grupos/');
        $conf['total_rows'] = $data['registros'];
        $conf['per_page'] = 10;
        $conf['num_links'] = 3;
        $conf['next_link'] = "&gt;";
        $conf['prev_link'] = "&lt;";
        $conf['first_link'] = "&lt;&lt;";
        $conf['last_link'] = "&gt;&gt;";
        $conf['uri_segment'] = 4;
        $offset = (int) $this->uri->segment(4);
        $this->pagination->initialize($conf);
        $data['paginacion'] = $this->pagination->create_links();
        $listado = $this->almacen_model->listar('', $conf['per_page'], $offset);
        $item = $j + 1;
        $lista = array();

        if (count($listado) > 0) {
            foreach ($listado as $indice => $valor) {
                $codigo = $valor->codigo;
                $nombre = $valor->nombre_almacen;
                $fecha = $valor->fecha_registro;
                $lista[] = array($item++, $codigo, $nombre, $fecha);
            }
        }

        $data['lista'] = $lista;
        $data['titulo_busqueda'] = 'BUSCAR ALMACENES';

        $data['filtro'] = form_input(array('name' => 'filtro',
            'id' => 'filtro',
            'class' => 'cajaMediana',
            'maxlength' => '20',
            'value' => ''));

        $data['form_open'] = form_open(base_url() . 'index.php/mb/almacen/buscar', array('name' => 'form_busquedaAlmacen',
            'id' => 'form_busquedaAlamcen'));
        $data['form_close'] = form_close();
        $data['titulo_tabla'] = "RELACION DE ALMACENES";
        $data['oculto'] = form_hidden(array('base_url' => base_url()));


        $this->layout->view('mb/almacen_index.php', $data);
        //$this->layout->view( 'mb/grupos_temporadas_index', $data );
    }

    public function ver($cod) {
        $this->load->library('layout', 'layout');
        $listado = $this->almacen_model->obtener_almacen($cod);
        $lista = array();
        $item = 1;
        if (count($listado) > 0) {
            foreach ($listado as $indice => $valor) {
                $codigo = $valor->codigo;
                $descripcion = $valor->nombre_almacen;
                $fecha = $valor->fecha_registro;
                $lista[] = array($item++, $codigo, $descripcion, $fecha);
            }
        }
        $data['lista'] = $lista;
        $data['titulo'] = 'VER ALMACEN';
        $data['oculto'] = form_hidden(array('base_url' => base_url()));



        $this->layout->view('mb/grupo_temporada_ver', $data);
    }

    //editar_grupo
    public function editar_alamcen($cod) {
        $this->load->library('layout', 'layout');
        $datos = $this->almacen_model->obtener_almacen($cod);
        $codigo = $datos[0]->codigo;
        $nombre = $datos[0]->nombre_almacen;
        $data['modo'] = 'modificar';
        $data['form_open'] = form_open(base_url() . 'index.php/mb/almacen/modificar_alamcen', array('name' => 'frmAlmacen',
            'id' => 'frmAlmacen'));
        $data['form_close'] = form_close();
        $data['nombre'] = form_input(array('name' => 'nombre',
            'id' => 'nombre',
            'value' => $nombre,
            'maxlength' => '30',
            'class' => 'cajaMedia'));
        $data['oculto'] = form_hidden(array('base_url' => base_url()));
        $data['codigo'] = $codigo;
        $data['titulo'] = 'EDITAR ALMACEN';
        $this->layout->view('mb/alamcen_nuevo', $data);
    }

    public function modificar_alamcen() {
        $this->form_validation->set_rules('nombre', 'Nombre de Almacen', 'required');
        $codigo = $this->input->post('codigo');
        $nombre = $this->input->post('nombre');
        $filter = new stdClass();
        if ($this->form_validation->run() == false)
            $this->editar_grupo($codigo);
        else {
            $filter->nombre_almacen = $nombre;
            $this->almacen_model->modificar_almacen($codigo, $filter);
            $this->listar_almacenes();
        }
    }

    public function eliminar_almacen() {
        /* echo "<pre>RESQUEST";
          print_r($_RESQUEST);
          echo "</pre>";


          echo "<pre>RESQUEST";
          print_r($this->input->post('cod'));
          echo "</pre>";
         */

        $cod = $this->input->post('cod');
        $this->almacen_model->eliminar_almacen($cod);
    }

    public function nuevo() {
        $this->load->library('layout', 'layout');
        $data['titulo'] = 'REGISTRAR ALAMCEN';
        $data['form_open'] = form_open(base_url() . 'index.php/mb/almacen/grabar', array('name' => 'frmAlmacen',
            'id' => 'frmAlmacen'));
        $data['form_close'] = form_close();
        $data['codigo'] = '';
        $data['nombre'] = form_input(array('name' => 'nombre',
            'id' => 'nombre',
            'value' => '',
            'maxlength' => '30',
            'class' => 'cajaMedia'));
        $data['oculto'] = form_hidden(array('base_url' => base_url()));
        $this->layout->view('mb/alamcen_nuevo', $data);
    }

    public function grabar() {
        $this->form_validation->set_rules('nombre', 'Nombre de almacen', 'required');
        $filter = new stdClass();
        if ($this->form_validation->run() == false)
            $this->nuevo();
        else {
            $nombre = $this->input->post('nombre');
            $filter->nombre_almacen = $nombre;
            $this->almacen_model->insertar($filter);
            $this->listar_almacenes();
        }
    }
    
    
    
        public function buscar( $j=0 ) {
            //echO($this->input->post( 'filtro' ));
            $this->load->library( 'layout', 'layout' );
            $filtro                 = $this->input->post( 'filtro' );
            $data['registros']      = count( $this->almacen_model->listar($filtro) );
            
            $conf['base_url']       = site_url( 'mb/alamcen/buscar/' );
            $conf['per_page']       = 10;
            $conf['num_links']      = 3;
            $conf['first_link']     = "&lt;&lt;";
            $conf['last_link']      = "&gt;&gt;";
            $conf['total_rows']     = $data['registros'];
            $offset                 = (int)$this->uri->segment( 4 );
            $listado                = $this->almacen_model->listar( $filtro, $conf['per_page'], $offset );
            $item                   = $j+1;
            $lista                  = array();
            
            if ( count($listado) > 0 ) {
                foreach( $listado as $indice=>$valor ) {   
                    $codigo     = $valor->codigo;
                    $nombre     = $valor->nombre_almacen;
                    $fecha      = $valor->fecha_registro;
                    $lista[]    = array( $item++, $codigo, $nombre, $fecha );
                }
            }
            $data['titulo_tabla']       = 'RESULTADO DE LA BUSQUEDA DE ALMACEN';
            $data['titulo_busqueda']    = 'BUSCAR ALMACENES';
            $data['filtro']             = form_input( array( 'name'=>'filtro',
                                                             'id'=>'filtro',
                                                             'class'=>'cajaMediana',
                                                             'maxlength'=>'20',
                                                             'value'=>$filtro ) );
            $data['form_open']          = form_open( base_url() . 'index.php/mb/almacen/buscar',
                                                     array( 'name'=>'form_busquedaAlamcen',
                                                            'id'=>'form_busquedaAlamcen' ) );
            $data['form_close']         = form_close();
            $data['lista']              = $lista;
            $data['oculto']             = form_hidden( array( 'base_url'=>base_url() ) );
            $this->pagination->initialize( $conf );
            $data['paginacion']         = $this->pagination->create_links();
            $this->layout->view( 'mb/almacen_index', $data );
        }
            
    

}

?>