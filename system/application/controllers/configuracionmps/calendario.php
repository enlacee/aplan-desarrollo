<?php

class Calendario extends Controller {

    var $somevar;

    public function __construct() {
        parent::__construct();
        $this->load->library('compartido');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->library('pagination');
        $this->load->library('html');
        $this->load->model('maestros/periodo_model');
        $this->load->model('configuracionmps/calendario_model');
        $this->load->model('configuracionmps/detallecalendario_model');
        $this->somevar['compania'] = $this->session->userdata('compania');
    }

    public function index() {
        $this->listar_calendario();
    }

    public function listar_calendario($j = "") {

        /* $compartido = $this->compartido->verificar_compartido();
          print_r($compartido);exit; */

        if (!$this->session->userdata('user')) {
            redirect('index/index');
        }
        $this->load->library('layout', 'layout');
        $data['titulo_busqueda'] = "BUSCAR CALENDARIO";
        $data['registros'] = count($this->calendario_model->listar_calendario());
        /*         * configurar paginacion* */
        $conf['base_url'] = site_url('configuracionmps/calendario/listar_calendario/');
        $conf['per_page'] = 20;
        $conf['num_links'] = 3;
        $conf['first_link'] = "&lt;&lt;";
        $conf['last_link'] = "&gt;&gt;";
        $conf['total_rows'] = $data['registros'];
        $conf['uri_segment'] = 4;
        $offset = (int) $this->uri->segment(4);
        /*         * configurar paginacion* */
        $listado_calendarios = $this->calendario_model->listar_calendario($conf['per_page'], $offset);
        $item = $j + 1;
        $lista = array();
        if (count($listado_calendarios) > 0) {
            foreach ($listado_calendarios as $valor) {
                $codigo = $valor->CALE_Codigo;
                $mes = $valor->CALE_Mes;
                $anio = $valor->CALE_Anio;
                $descripcion = $valor->CALE_Descripcion;
                $flag = $valor->CALE_Flag;
                $fecha_ini = substr($valor->CALE_FechaIni, 8, 2) . '/' . substr($valor->CALE_FechaIni, 5, 2) . '/' . substr($valor->CALE_FechaIni, 0, 4);
                ;
                $fecha_fin = substr($valor->CALE_FechaFin, 8, 2) . '/' . substr($valor->CALE_FechaFin, 5, 2) . '/' . substr($valor->CALE_FechaFin, 0, 4);
                $lista[] = array($item++, $codigo, $mes, $anio, $descripcion, $fecha_ini, $fecha_fin, $flag);
            }
        }
        $data['lista'] = $lista;
        $data['titulo_tabla'] = 'RELACI&Oacute;N de CALENDARIOS';
        $data['titulo'] = "NUEVO CALENDARIO";

        $this->pagination->initialize($conf);
        $data['paginacion'] = $this->pagination->create_links();
        $this->layout->view('configuracionmps/calendario_index', $data);
    }

    function nuevo_calendario() {
        if (!$this->session->userdata('user')) {
            redirect('index/index');
        }
        $this->load->library('layout', 'layout');
        $data['titulo'] = "NUEVO CALENDARIO";
        $data['modo'] = "insertar";
        $data['codigo'] = "";
        $data['fecha_ini'] = "";
        $data['fecha_fin'] = "";
        $data['codigo'] = "";

        $this->layout->view('configuracionmps/calendario_nuevo', $data);
    }

    public function editar_calendario($cod_calendario) {
        if (!$this->session->userdata('user'))
            redirect('index/index');

        $calendario = $this->calendario_model->obtener_calendario($cod_calendario);
        if (count($calendario) == 0)
            redirect('configuracionmps/calendario/listar_calendario');

        $cal_flag = $calendario[0]->CALE_Flag;

        $this->load->library('layout', 'layout');
        $data['titulo'] = "EDITAR CALENDARIO";
        $data['modo'] = "editar";
        $data['codigo'] = $calendario[0]->CALE_Codigo;
        $fecha_ini = substr($calendario[0]->CALE_FechaIni, 8, 2) . '/'
                . substr($calendario[0]->CALE_FechaIni, 5, 2) . '/'
                . substr($calendario[0]->CALE_FechaIni, 0, 4);
        $fecha_fin = substr($calendario[0]->CALE_FechaFin, 8, 2) . '/'
                . substr($calendario[0]->CALE_FechaFin, 5, 2) . '/'
                . substr($calendario[0]->CALE_FechaFin, 0, 4);
        $data['fecha_ini'] = $fecha_ini;
        $data['fecha_fin'] = $fecha_fin;
        $data['descripcion'] = $calendario[0]->CALE_Descripcion;
        $data['flag_codigo'] = $cal_flag;
        $data['calendario'] = $this->ver_calendario($fecha_ini, $fecha_fin, $cod_calendario);
        $this->layout->view('configuracionmps/calendario_nuevo', $data);
    }

    public function insertar_calendario() {
        if (!$this->session->userdata('user')) {
            redirect('index/index');
        }
        if (!$_POST) {
            redirect('configuracionmps/configuracion/listar_calendario');
        }
        $retorno = '';
        $fechainicio = $this->input->post('fechainicio', TRUE);
        $fechafin = $this->input->post('fechafin', TRUE);
        $modo = $this->input->post('modo', TRUE);
        $descripcion = $this->input->post('descripcion', TRUE);
        $selecctionck = $this->input->post('checkedd', TRUE);

        $cantidad = $this->meses($fechainicio, $fechafin);

        $mes_inicio = substr($fechainicio, 3, 2);
        $mes_fin = substr($fechafin, 3, 2);

        $anio_inicio = substr($fechainicio, 6, 4);
        $anio_fin = substr($fechafin, 6, 4);

        if ($fechainicio != '')
            $fechainicio = substr($fechainicio, 6, 4) . '-' . substr($fechainicio, 3, 2) . '-' . substr($fechainicio, 0, 2);
        if ($fechafin != '')
            $fechafin = substr($fechafin, 6, 4) . '-' . substr($fechafin, 3, 2) . '-' . substr($fechafin, 0, 2);

        if ($modo == 'insertar') {
            $filter = new stdClass();
            $filter->CALE_FechaIni = $fechainicio;
            $filter->CALE_FechaFin = $fechafin;
            $filter->CALE_Descripcion = strtoupper($descripcion);

            $tipo = '';
            if (isset($selecctionck[0])) {
                $tipo = 'siete';
                $filter->CALE_Flag = 0;
            };
            if (isset($selecctionck[1])) {
                $tipo = 'seis';
                $filter->CALE_Flag = 1;
            };
            if (isset($selecctionck[2])) {
                $tipo = 'cinco';
                $filter->CALE_Flag = 2;
            }
            $retorno = $this->calendario_model->insertar_calendario($filter);

            // 2012-12-12
            // Carlos Gomez Morales
            // se corrige el retorno del mes=13 al mes=1 y el aumento de anho
            $anhoInsertar = $anio_inicio;
            for ($anioo = $anio_inicio; $anioo <= $anio_fin; $anioo++) {
                for ($mesi = 0; $mesi <= $cantidad['cantidad_meses']; $mesi++) {
                    $this->insertar_detalle_calendario($mes_inicio, $anhoInsertar, $fechainicio, $fechafin, $retorno, $tipo);
                    $mes_inicio++;
                    if ($mes_inicio == 13) {
                        $mes_inicio = 1;
                        $anhoInsertar++;
                    }
                }
            }
        } else if ($modo = 'editar') {
            $cod_calendario = $this->input->post('codigo', TRUE);
            $retorno = $cod_calendario;
            $this->detallecalendario_model->eliminar_detalle_calendario($cod_calendario);
            $seleccion = $this->input->post('validar_seleccion', TRUE);

            foreach ($seleccion as $key => $value) {
                $fecha_dma = explode('-', $key);
                $detalle = new stdClass();
                $detalle->DCAL_Mes = $fecha_dma[1];
                $detalle->DCAL_Dia = $fecha_dma[0];
                $detalle->DCAL_Anio = $fecha_dma[2];
                $detalle->DCAL_Fecha = $fecha_dma[2] . "-" . $fecha_dma[1] . "-" . $fecha_dma[0];
                $detalle->DCAL_Flag = $value;
                // $detalle->DCAL_NumHoras 	= $value
                $detalle->CALE_Codigo = $cod_calendario;
                $detalle->PERI_Codigo = 0; //$  //falta considerar periodo verificar

                $this->detallecalendario_model->insertar_detalle_calendario($detalle);
            }
        }
        echo $retorno;
    }

    public function ver_ventana_editar_calendario($cod_calendario) {

        if (!$this->session->userdata('user')) {
            redirect('index/index');
        }
        $calendario = $this->calendario_model->obtener_calendario($cod_calendario);
        $fecha_ini = substr($calendario[0]->CALE_FechaIni, 8, 2) . '/' . substr($calendario[0]->CALE_FechaIni, 5, 2) . '/' . substr($calendario[0]->CALE_FechaIni, 0, 4);
        $fecha_fin = substr($calendario[0]->CALE_FechaFin, 8, 2) . '/' . substr($calendario[0]->CALE_FechaFin, 5, 2) . '/' . substr($calendario[0]->CALE_FechaFin, 0, 4);
        $cal_flag = $calendario[0]->CALE_Flag;
        $data['titulo'] = "NUEVO CALENDARIO";
        $data['modo'] = "insertar";
        $data['codigo'] = "";
        $data['fecha_ini'] = $fecha_ini;
        $data['fecha_fin'] = $fecha_fin;
        $data['flag_codigo'] = $cal_flag;
        $data['codigo'] = $cod_calendario;
        $data['descripcion'] = $calendario[0]->CALE_Descripcion;

        $this->load->view('configuracionmps/editar_calendario', $data);
    }

    public function modificar_calendario() {
        $codigo_calendario = $this->input->post('codigo', TRUE);
        if (!$_POST) {
            redirect('configuracionmps/configuracion/listar_calendario');
        }
        $retorno = '';
        $fechainicio = $this->input->post('fechainicio', TRUE);
        $fechafin = $this->input->post('fechafin', TRUE);
        $modo = $this->input->post('modo', TRUE);
        $descripcion = $this->input->post('descripcion', TRUE);
        $selecctionck = $this->input->post('checkedd', TRUE);

        $cantidad = $this->meses($fechainicio, $fechafin);

        $mes_inicio = substr($fechainicio, 3, 2);
        $mes_fin = substr($fechafin, 3, 2);

        $anio_inicio = substr($fechainicio, 6, 4);
        $anio_fin = substr($fechafin, 6, 4);

        if ($fechainicio != '')
            $fechainicio = substr($fechainicio, 6, 4) . '-' . substr($fechainicio, 3, 2) . '-' . substr($fechainicio, 0, 2);
        if ($fechafin != '')
            $fechafin = substr($fechafin, 6, 4) . '-' . substr($fechafin, 3, 2) . '-' . substr($fechafin, 0, 2);

        if ($modo == 'insertar') {
            $filter = new stdClass();
            $filter->CALE_FechaIni = $fechainicio;
            $filter->CALE_FechaFin = $fechafin;
            $filter->CALE_Codigo = $codigo_calendario;
            $filter->CALE_Descripcion = strtoupper($descripcion);

            $tipo = '';
            if (isset($selecctionck[0])) {
                $tipo = 'siete';
                $filter->CALE_Flag = 0;
            };
            if (isset($selecctionck[1])) {
                $tipo = 'seis';
                $filter->CALE_Flag = 1;
            };
            if (isset($selecctionck[2])) {
                $tipo = 'cinco';
                $filter->CALE_Flag = 2;
            }

            $this->calendario_model->editar_calendario($filter);
            // echo $retorno;exit;
            $this->detallecalendario_model->eliminar_detalle_calendario($codigo_calendario);

            // 2012-12-12
            // Carlos Gomez Morales
            // se corrige el retorno del mes=13 al mes=1 y el aumento de anho
            $anhoInsertar = $anio_inicio;
            for ($anioo = $anio_inicio; $anioo <= $anio_fin; $anioo++) {
                for ($mesi = 0; $mesi <= $cantidad['cantidad_meses']; $mesi++) {
                    $this->insertar_detalle_calendario($mes_inicio, $anioo, $fechainicio, $fechafin, $codigo_calendario, $tipo);
                    $mes_inicio++;
                    if ($mes_inicio == 13) {
                        $mes_inicio = 1;
                        $anhoInsertar++;
                    }
                }
            }
        }
    }

    public function meses($fechaini, $fechafin) {
        $diferencia_anios = 0;
        $diferencia_meses = 0;
        $mes1 = substr($fechaini, 3, 2);
        $anio1 = substr($fechaini, 6, 4);

        $mes2 = substr($fechafin, 3, 2);
        $anio2 = substr($fechafin, 6, 4);

        if ($anio2 > $anio1) {
            $diferencia_anios = $anio2 - $anio1;
        }
        $diferencia_anios *=12;
        $diferencia_meses = ($mes2 - $mes1) + $diferencia_anios;
        return array('cantidad_meses' => $diferencia_meses, 'mes1' => $mes1, 'mes2' => $mes2,
            'anio1' => $anio1, 'anio2' => $anio2, 'f_ini' => $fechaini, 'f_fin' => $fechafin);
    }

    public function validar_calendario_periodo() {
        $retorno = true;
        $anio = $this->input->post('anio', TRUE);
        $mes = $this->input->post('mes', TRUE);
        $modo = $this->input->post('modo', TRUE);
        $periodo = $this->calendario_model->obtener_calendario_periodo($anio . '-' . $mes);
        if (count($periodo) > 0) {
            $retorno = false;
        }
        if ($modo == 'editar') {
            $retorno = true;
        }
        echo $retorno;
    }

    public function eliminar_calendario() {
        if (!$this->session->userdata('user')) {
            redirect('index/index');
        }
        if (!$_POST) {
            redirect('configuracionmps/configuracion/listar_calendario');
        }
        $cod_calendario = $this->input->post('codigo', TRUE);
        $this->calendario_model->eliminar_calendario($cod_calendario);
    }

    public function mostrar_mes_completo($mes) {
        switch ($mes) {
            case '01' : $nombre = 'Enero';
                break;
            case '02' : $nombre = 'Febrero';
                break;
            case '03' : $nombre = 'Marzo';
                break;
            case '04' : $nombre = 'Abril';
                break;
            case '05' : $nombre = 'Mayo';
                break;
            case '06' : $nombre = 'Junio';
                break;
            case '07' : $nombre = 'Julio';
                break;
            case '08' : $nombre = 'Agosto';
                break;
            case '09' : $nombre = 'Septiembre';
                break;
            case '10' : $nombre = 'Octubre';
                break;
            case '11' : $nombre = 'Noviembre';
                break;
            case '12' : $nombre = 'Diciembre';
                break;
            default : $nombre = '';
        }
        return strtoupper($nombre);
    }

    public function insertar_detalle_calendario($m, $a, $f_ini, $f_fin, $retorno, $tipo) {
        $tipo_semana = 1;
        $tipo_mes = 1;

        //almaceno dias de inicio y de fin, para poner un limite
        $dia_inicio = substr($f_ini, 0, 2);
        $dia_fin = substr($f_fin, 0, 2);
        $mes_inicio = substr($f_ini, 3, 2);
        $mes_fin = substr($f_fin, 3, 2);
        $anio_inicio = substr($f_ini, 6, 4);
        $anio_fin = substr($f_fin, 6, 4);
        $dia = '';
        if (!$dia)
            $dia = date('d');
        $mes = $m;
        $ano = $a;
        $TotalDiasMes = date('t', mktime(0, 0, 0, $mes, $dia, $ano));
        $DiaSemanaEmpiezaMes = date('w', mktime(0, 0, 0, $mes, 1, $ano));
        $DiaSemanaTerminaMes = date('w', mktime(0, 0, 0, $mes, $TotalDiasMes, $ano));
        $EmpiezaMesCalOffset = $DiaSemanaEmpiezaMes;
        $TerminaMesCalOffset = 6 - $DiaSemanaTerminaMes;
        $TotalDeCeldas = $TotalDiasMes + $DiaSemanaEmpiezaMes + $TerminaMesCalOffset;

        if ($m == 12) {
            $_ms = 1;
            $_ma = $m - 1;
            $a_s = $ano + 1;
            $a_a = $ano;
        } elseif ($m == 1) {
            $_ms = $m + 1;
            $_ma = 12;
            $a_a = $ano - 1;
            $a_s = $ano;
        } else {
            $_ms = $m + 1;
            $_ma = $m - 1;
            $a_a = $ano;
            $a_s = $ano;
        }
        $b = '';
        $c = '';
        if ($a == $anio_inicio) {
            $flag = 1;
        } elseif ($a == $anio_fin) {
            $flag = 2;
        }
        for ($a = 1; $a <= $TotalDeCeldas; $a++) {
            if (!$b)
                $b = 0;
            if ($b == 7)
                $b = 0;
            if ($b == 0)
                if (!$c)
                    $c = 1;
            if ($a > $EmpiezaMesCalOffset and $c <= $TotalDiasMes) {
                //if($f_ini >= $ano."-".$m."-".$c && $f_fin <= $ano."-".$m."-".$c){
                $filter->CALE_Codigo = $retorno;
                $filter->DCAL_Fecha = $ano . "-" . $m . "-" . $c;
                $filter->DCAL_Anio = $ano;
                $filter->DCAL_Mes = $m;
                $filter->DCAL_Dia = $c;
                $filter->DCAL_Flag = 0;
                $ds = str_pad($c, 2, 0, STR_PAD_LEFT);
                $ms = str_pad($mes, 2, 0, STR_PAD_LEFT);
                $as = $ano;
                switch ($tipo) {
                    case 'siete':
                        if ($b == 0) {
                            $filter->DCAL_Flag = 0;
                        }
                        break;
                    case 'seis':
                        if ($b == 0) {
                            $filter->DCAL_Flag = 1;
                        }
                        break;
                    case 'cinco':
                        if ($b == 6 || $b == 0) {
                            $filter->DCAL_Flag = 1;
                        }
                }
                $c++;

                $this->detallecalendario_model->insertar_detalle_calendario($filter);
                //}
            }
            $b++;
        }
    }

    public function ver_calendario($fecha_ini, $fecha_fin, $cod_calendario) {
        $meses = $this->meses($fecha_ini, $fecha_fin);
//            echo '<pre>';
//            print_r( $meses );
//            echo '</pre>';
        $mes_inicio = $meses['mes1'];
        $mes_fin = $meses['mes2'];
        $anio_inicio = $meses['anio1'];
        $anio_fin = $meses['anio2'];
        $calendario = '';
        for ($i = 0; $i <= $meses['cantidad_meses']; $i++) {
            if ($anio_inicio == $anio_fin) {
                if ($mes_inicio <= $mes_fin)
                    $calendario .= $this->mostrar_calendario($mes_inicio, $anio_inicio, $meses['f_ini'], $meses['f_fin'], $cod_calendario);
                $mes_inicio++;
            } elseif ($anio_inicio < $anio_fin) {
                $calendario .= $this->mostrar_calendario($mes_inicio, $anio_inicio, $meses['f_ini'], $meses['f_fin'], $cod_calendario);
                $mes_inicio++;
                //$dif = $anio_fin - $anio_inicio;
                if ($anio_inicio != $anio_fin) {
                    if ($mes_inicio == 13) {
                        $anio_inicio++;
                        $mes_inicio = 1;
                    }
                }
            }
        }
        return $calendario;
    }

    public function mostrar_calendario($m, $a, $f_ini, $f_fin, $cod_calendario) {
        $tipo_semana = 1;
        $tipo_mes = 1;

        //almaceno dias de inicio y de fin, para poner un limite
        $dia_inicio = substr($f_ini, 0, 2);
        $dia_fin = substr($f_fin, 0, 2);
        $mes_inicio = substr($f_ini, 3, 2);
        $mes_fin = substr($f_fin, 3, 2);
        $anio_inicio = substr($f_ini, 6, 4);
        $anio_fin = substr($f_fin, 6, 4);

        $MESCOMPLETO[1] = 'Enero';
        $MESCOMPLETO[2] = 'Febrero';
        $MESCOMPLETO[3] = 'Marzo';
        $MESCOMPLETO[4] = 'Abril';
        $MESCOMPLETO[5] = 'Mayo';
        $MESCOMPLETO[6] = 'Junio';
        $MESCOMPLETO[7] = 'Julio';
        $MESCOMPLETO[8] = 'Agosto';
        $MESCOMPLETO[9] = 'Septiembre';
        $MESCOMPLETO[10] = 'Octubre';
        $MESCOMPLETO[11] = 'Noviembre';
        $MESCOMPLETO[12] = 'Diciembre';

        $MESABREVIADO[1] = 'Ene';
        $MESABREVIADO[2] = 'Feb';
        $MESABREVIADO[3] = 'Mar';
        $MESABREVIADO[4] = 'Abr';
        $MESABREVIADO[5] = 'May';
        $MESABREVIADO[6] = 'Jun';
        $MESABREVIADO[7] = 'Jul';
        $MESABREVIADO[8] = 'Ago';
        $MESABREVIADO[9] = 'Sep';
        $MESABREVIADO[10] = 'Oct';
        $MESABREVIADO[11] = 'Nov';
        $MESABREVIADO[12] = 'Dic';

        $SEMANACOMPLETA[0] = 'Domingo';
        $SEMANACOMPLETA[1] = 'Lunes';
        $SEMANACOMPLETA[2] = 'Martes';
        $SEMANACOMPLETA[3] = 'Mi&eacute;rcoles';
        $SEMANACOMPLETA[4] = 'Jueves';
        $SEMANACOMPLETA[5] = 'Viernes';
        $SEMANACOMPLETA[6] = 'S&aacute;bado';

        $SEMANAABREVIADA[0] = 'D';
        $SEMANAABREVIADA[1] = 'L';
        $SEMANAABREVIADA[2] = 'M';
        $SEMANAABREVIADA[3] = 'M';
        $SEMANAABREVIADA[4] = 'J';
        $SEMANAABREVIADA[5] = 'V';
        $SEMANAABREVIADA[6] = 'S';

        ////////////////////////////////////
        if ($tipo_semana == 0) {
            $ARRDIASSEMANA = $SEMANACOMPLETA;
        } elseif ($tipo_semana == 1) {
            $ARRDIASSEMANA = $SEMANAABREVIADA;
        }
        if ($tipo_mes == 0) {
            $ARRMES = $MESCOMPLETO;
        } elseif ($tipo_mes == 1) {
            $ARRMES = $MESABREVIADO;
        }
        $dia = '';
        if (!$dia)
            $dia = date('d');
        $mes = $m;
        $ano = $a;
        $TotalDiasMes = date('t', mktime(0, 0, 0, $mes, $dia, $ano));
        $DiaSemanaEmpiezaMes = date('w', mktime(0, 0, 0, $mes, 1, $ano));
        $DiaSemanaTerminaMes = date('w', mktime(0, 0, 0, $mes, $TotalDiasMes, $ano));
        $EmpiezaMesCalOffset = $DiaSemanaEmpiezaMes;
        $TerminaMesCalOffset = 6 - $DiaSemanaTerminaMes;
        $TotalDeCeldas = $TotalDiasMes + $DiaSemanaEmpiezaMes + $TerminaMesCalOffset;

        if ($m == 12) {
            $_ms = 1;
            $_ma = $m - 1;
            $a_s = $ano + 1;
            $a_a = $ano;
        } else if ($m == 1) {
            $_ms = $m + 1;
            $_ma = 12;
            $a_a = $ano - 1;
            $a_s = $ano;
        } else {
            $_ms = $m + 1;
            $_ma = $m - 1;
            $a_a = $ano;
            $a_s = $ano;
        }
        $clase = "";
        //$clase = "calendarionumerosseleccion";
        $calendario = "";
        $calendario .= '
			<div class="left table-calendar" style="float:left;">
			<table border="0" cellpadding="0" cellspacing="2" class="calendariotabla">
			<tr>
			<td colspan="7" class="month-underline calendariomes">
			<p>
			' . $this->mostrar_mes_completo($mes) . '
			' . $ano . '
			</p>
			</td>
			</tr>
			<tr></tr>
			';
        $calendario .= '<tr class="dias_cale">';
        $calendario .= '<td class="calendariodia">D</td>';
        $calendario .= '<td class="calendariodia">L</td>';
        $calendario .= '<td class="calendariodia">M</td>';
        $calendario .= '<td class="calendariodia">M</td>';
        $calendario .= '<td class="calendariodia">J</td>';
        $calendario .= '<td class="calendariodia">V</td>';
        $calendario .= '<td class="calendariodia">S</td>';
        $calendario .= '</tr>';
        $b = '';
        $c = '';
        $flag = 0;
        $value_hidden = '0';
        if ($a == $anio_inicio) {
            $flag = 1;
        } else if ($a == $anio_fin) {
            $flag = 2;
        }
        //obtener los dias no laborables
        $no_laborables = $this->detallecalendario_model->obtener_dias_no_laborables($cod_calendario, $m, $a);
        $clase = 'calendarionumeros';
        $anio = $a;
        for ($a = 1; $a <= $TotalDeCeldas; $a++) {
            if (!$b)
                $b = 0;
            if ($b == 7)
                $b = 0;
            if ($b == 0)
                echo '<tr height="18">';
            if (!$c)
                $c = 1;
            if ($a > $EmpiezaMesCalOffset and $c <= $TotalDiasMes) {
                $ds = str_pad($c, 2, 0, STR_PAD_LEFT);
                $ms = str_pad($mes, 2, 0, STR_PAD_LEFT);
                $as = $ano;
                if (count($no_laborables) > 0) {
                    foreach ($no_laborables as $value) {
                        if ($c == $value->DCAL_Dia) {
                            $clase = 'calendarionumerosseleccion';
                            $value_hidden = '1';
                            break;
                        } else {
                            $clase = 'calendarionumeros';
                            $value_hidden = '0';
                        }
                    }
                } else {
                    $clase = 'calendarionumeros';
                    $value_hidden = '0';
                }
                $calendario .= '<td class="' . $clase . '" id="calendarionumeros-' . $c . '-' . $m . '-' . $anio . '">';
                if ($anio_inicio == $a || $mes_inicio == $m) {
                    if ($c <= ($dia_inicio - 1)) {
                        $calendario .= $c;
                        //$calendario .= '<a href="javascript:;">'.$c.'</a>';
                        //$calendario .= '<input type="hidden" name="validar_seleccion['.$c.']" id="validar_seleccion-'.$c.'-'.$m.'" value="'.$value_hidden.'" />';
                    } else {
                        $calendario .= '<a href="javascript:;" class="marcar_fecha" name="fecha-' . $c . '" id="fecha-' . $c . '-' . $m . '-' . $anio . '" >' . $c . '</a>';
                        $calendario .= '<input type="hidden" name="validar_seleccion[' . $c . '-' . $m . '-' . $anio . ']" id="validar_seleccion-' . $c . '-' . $m . '-' . $anio . '" value="' . $value_hidden . '" />';
                    }
                } else if ($anio_inicio == $a || $mes_fin == $m) {
                    if ($c >= ($dia_fin + 1)) {
                        $calendario .= $c;
                        //$calendario .= '<a href="javascript:;">'.$c.'</a>';
                        //$calendario .= '<input type="hidden" name="validar_seleccion['.$c.']" id="validar_seleccion-'.$c.'-'.$m.'" value="'.$value_hidden.'" />';
                    } else {
                        $calendario .= '<a href="javascript:;" class="marcar_fecha" name="fecha-' . $c . '" id="fecha-' . $c . '-' . $m . '-' . $anio . '" >' . $c . '</a>';
                        $calendario .= '<input type="hidden" name="validar_seleccion[' . $c . '-' . $m . '-' . $anio . ']" id="validar_seleccion-' . $c . '-' . $m . '-' . $anio . '" value="' . $value_hidden . '" />';
                    }
                } else {
                    $calendario .= '<a href="javascript:;" class="marcar_fecha" name="fecha-' . $c . '" id="fecha-' . $c . '-' . $m . '-' . $anio . '" >' . $c . '</a>';
                    $calendario .= '<input type="hidden" name="validar_seleccion[' . $c . '-' . $m . '-' . $anio . ']" id="validar_seleccion-' . $c . '-' . $m . '-' . $anio . '" value="' . $value_hidden . '" />';
                }
                $calendario .= '</td>';
                $c++;
            } else {
                $calendario .= "<td class='calendariolibres'>&nbsp;</td>";
            }
            if ($b == 6)
                $calendario .= '</tr>';
            $b++;
        }
        $calendario .= '
		</table>
		</div>';
        return $calendario;
    }

}

?>