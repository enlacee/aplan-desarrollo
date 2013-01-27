<?php
    
    include( 'system/application/libraries/pchart/pData.php' );
    include( 'system/application/libraries/pchart/pChart.php' );
    
    // 8 dic del 2012
    // CABE_Horizonte => es un campo para hacer pruebas, este campo se utiliza en el metodo insertar_tablamps()
    // SAILOR FARFAN
    
    class Tablamps extends Controller {
        
        var $somevar;
        var $cantidad_disponible = 0;
        var $codigo_calendario = 0;
        
        public function __construct() {
            parent :: __construct();
            $this->load->helper( 'form' );
            $this->load->library( 'form_validation' );
            $this->load->library( 'pagination' );
            $this->load->library( 'html' );
            $this->load->helper( 'date' );
            $this->load->helper( 'MY_dias_fechas_helper' );
            $this->load->model( 'maestros/periodo_model' );
            $this->load->model( 'maestros/establecimiento_model' );
            $this->load->model( 'almacen/producto_model' );
            $this->load->model( 'almacen/inventario_model' );
            $this->load->model( 'configuracionmps/calendario_model' );
            $this->load->model( 'configuracionmps/detallecalendario_model' );
            $this->load->model( 'configuracionmps/configuracionmensaje_model' );
            $this->load->model( 'configuracionmps/configuracionmps_model' );
            $this->load->model( 'configuracion/configuracionsistema_model' );
            $this->load->model( 'mps/cabeceramps_model' );
            $this->load->model( 'mps/detallecabeceramps_model' );
            $this->load->model( 'alertas/tipoalerta_model' );
            $this->load->model( 'alertas/alerta_model' );
            $this->load->model( 'compras/orden_model' );
            $this->load->model( 'compras/ocompra_model' );
            $this->load->model( 'compras/ocompradetalle_model' );
            $this->load->model( 'compras/otrabajo_model' );
            $this->load->model( 'compras/otrabajodetalle_model' );
            $this->somevar['compania']      = $this->session->userdata( 'compania' );
            $this->somevar['compania_hija'] = $this->session->userdata( 'compania_hija' );
            $this->somevar['hoy']           = mdate( '%Y-%m-%d', time() );
        }
        
	public function index(){
		$this->listar_cabeceramps();
	}
        
	public function listar_tablamps( $j='' ) {
            if ( !$this->session->userdata('user') )
                redirect( 'index/index' );
                
            $this->load->library( 'layout','layout' );
            $data['titulo_busqueda'] = 'BUSCAR TABLA MPS';
            $data['registros'] = count( $this->producto_model->listar_producto_cabeceramps() );
            
            /* paginacion */
            $conf['base_url']       = site_url( 'mps/tablamps/listar_tablamps/' );
            $conf['per_page']       = 20;
            $conf['num_links']      = 3;
            $conf['first_link']     = '&lt;&lt;';
            $conf['last_link']      = '&gt;&gt;';
            $conf['total_rows']     = $data['registros'];
            $conf['uri_segment']    = 4;
            $offset                 = (int)$this->uri->segment( 4 );
            
            $listado_productos      = $this->producto_model->listar_producto_cabeceramps( $conf['per_page'],
                                                                                          $offset );
            $item                   = $j+1;
            $lista                  = array();
            
            if ( count($listado_productos) > 0 ) {
                foreach( $listado_productos as $valor ) {
                    $codigo_producto    = $valor->PROD_Codigo;
                    $codigo_cabecera    = $valor->CABE_Codigo;
                    $descripcion        = $valor->PROD_Descripcion;
                    $icono              = $valor->PROD_Icono;
                    $lista[]            = array( $item++, $codigo_producto, $codigo_cabecera, $descripcion,
                                                 $icono );
                }
            }
            
            $data['lista'] = $lista;
            $data['titulo_tabla'] = 'RELACI&Oacute;N de PRODUCTOS';
            
            $this->pagination->initialize( $conf );
            $data['paginacion'] = $this->pagination->create_links();
            $this->layout->view( 'mps/cabeceramps_index', $data );
        }
        
        public function nuevo_tablamps() {
            if( ! $this->session->userdata('user') )
                redirect('index/index');
            
            $this->load->library( 'layout','layout' );
            
            $lblCodigo          = form_label( 'C&Oacute;DIGO CABECERA', 'codigo' );
            $lblDescripcion     = form_label( 'DESCRIPCI&OacuteN', 'descripcion' );
            $lblHorizonte       = form_label( 'HORIZONTE EN D&Iacute;AS', 'horizonte' );
            
            $txtCodigo          = form_input( array('name'=>'txtCodigo','id'=>'txtCodigo','value'=>'',
                                                    'maxlength'=>'30','class'=>'cajaPequena') );
            $txtDescripcion     = form_input( array('name'=>'txtDescripcion','id'=>'txtDescripcion','value'=>'',
                                                    'maxlength'=>'30','class'=>'cajaGrande') );
            $txtHorizonte   	= form_input( array('name'=>'txtHorizonte','id'=>'txtHorizonte','value'=>'',
                                                    'maxlength'=>'30','class'=>'cajaPequena') );
            
            $data['campos']     = array( $lblCodigo, $lblDescripcion, $lblHorizonte );
            $data['valores']    = array( $txtCodigo, $txtDescripcion, $txtHorizonte );
            
            $cboCalendario = '';
            $lista = $this->calendario_model->listar_calendario();
            
            $cboCalendario .= "<select class='comboMedio' name='cboCalendario' id='cboCalendario'>";
            $cboCalendario .= '<option value="0"> Seleccione... </option>';
            foreach( $lista as $valor ) {
                $cboCalendario .= '<option value="' . $valor->CALE_Codigo . '">' . $valor->CALE_Descripcion . '</option>';
            }
            $cboCalendario .='</select>';
            
            $lista_prod_array = $this->producto_model->listar_producto( 4, 0 );
            $lista_prod = array();
            foreach( $lista_prod_array as $value ) {
                $codigo         = $value->PROD_Codigo;
                $descripcion    = $value->PROD_Descripcion;
                $lista_prod[]   = array( $codigo, $descripcion );
            }
            
            $lista_ubi_array = $this->establecimiento_model->listar_establecimiento( 4, 0 );
            $lista_ubic = array();
            foreach( $lista_ubi_array as $value ) {
                $codigo         = $value->ESTA_Codigo;
                $descripcion    = $value->ESTA_Descripcion;
                $lista_ubic[]   = array( $codigo, $descripcion );
            }
            
            $data['titulo']                 = 'NUEVA CABECERA MPS';
            $data['modo']                   = 'insertar';
            $data['codigo']                 = '';
            $data['cboCalendario']          = $cboCalendario;
            $data['lista_productos']        = $lista_prod;
            $data['lista_establecimientos'] = $lista_ubic;
            $this->layout->view( 'mps/cabeceramps_nuevo', $data );
        }
        
	public function editar_detalle_tablamps( $cod_cabeceramps ) {
            if ( ! $this->session->userdata('user') )
                redirect('index/index');
            
            $cabeceramps = $this->cabeceramps_model->obtener_cabeceramps( $cod_cabeceramps );
            $lista_detalle_cabecera = $this->detallecabeceramps_model->obtener_detalle_cabecera( $cabeceramps[0]->CABE_Codigo );
            $this->load->library( 'layout', 'layout' );
            $data['titulo']     = 'EDITAR TABLA MPS';
            $data['modo']       = 'editar';
            $data['codigo']     = $cabeceramps[0]->CABE_Codigo;
            $lblCodigo          = form_label( 'C&Oacute;DIGO CABECERA','codigo' );
            $lblDescripcion     = form_label( 'DESCRIPCI&OacuteN','descripcion' );
            $lblHorizonte       = form_label( 'HORIZONTE EN D&Iacute;AS','horizonte' );
            $txtCodigo          = form_input( array('name'=>'txtCodigo','id'=>'txtCodigo',
                                                    'value'=>$cabeceramps[0]->CABE_CodigoInterno,
                                                    'maxlength'=>'30','class'=>'cajaPequena') );
            $txtDescripcion     = form_input( array('name'=>'txtDescripcion','id'=>'txtDescripcion',
                                                    'value'=>$cabeceramps[0]->CABE_Descripcion,
                                                    'maxlength'=>'30','class'=>'cajaGrande') );
            $txtHorizonte       = form_input( array('name'=>'txtHorizonte','id'=>'txtHorizonte',
                                                    'value'=>$cabeceramps[0]->CABE_Horizonte,
                                                    'maxlength'=>'30','class'=>'cajaPequena') );
            $data['campos']     = array( $lblCodigo, $lblDescripcion, $lblHorizonte );
            $data['valores']    = array( $txtCodigo, $txtDescripcion, $txtHorizonte );
            
            $detalle_cabecera_array = array();
            foreach( $lista_detalle_cabecera AS $valor ) {
                $lbllabel                   = form_label( $valor->DETA_Dia . '/' . $valor->DETA_Mes . '/' .
                                                          $valor->DETA_Anio,'fecha' );
                $campos                     = form_input( array('name'=>$valor->DETA_Codigo,
                                                          'id'=>'txtHorizonte','value'=>$valor->DETA_Demanda,
                                                          'maxlength'=>'30','class'=>'cajaPequena') );
                $detalle_cabecera_array[]   = array( $lbllabel, $campos );
            }
            
            $lista_calendario = $this->calendario_model->obtener_calendario( $cabeceramps[0]->CALE_Codigo );
            $nombre = $lista_calendario[0]->CALE_Descripcion;
            $cboCalendario = '';
            $cboCalendario .= "<select class='comboMedio' name='cboCalendario' id='cboCalendario'>";
            foreach( $lista_calendario as $valor ) {
                $cboCalendario .= '<option value="' . $valor->CALE_Codigo . '">' . $valor->CALE_Descripcion . '</option>';
            }
		
            $lista_prod_array = $this->producto_model->obtener_producto( $cabeceramps[0]->PROD_Codigo );
            $lista_prod = array();
            foreach( $lista_prod_array as $value ) {
                $codigo         = $value->PROD_Codigo;
                $descripcion    = $value->PROD_Descripcion;
                $lista_prod[]   = array( $codigo, $descripcion );
            }
            
            $lista_ubi_array = $this->establecimiento_model->listar_establecimiento( 1, 0 );
            $lista_ubic = array();
            foreach( $lista_ubi_array as $value ) {
                $codigo         = $value->ESTA_Codigo;
                $descripcion    = $value->ESTA_Descripcion;
                $lista_ubic[]   = array( $codigo, $descripcion );
            }
            
            $cboCalendario .= '</select>';
            $data['lista_detalle']          = $detalle_cabecera_array; 
            $data['cboCalendario']          = $cboCalendario;
            $data['lista_productos']        = $lista_prod;
            $data['lista_establecimientos'] = $lista_ubic;
            $this->layout->view( 'mps/cabeceramps_nuevo', $data );
        }
        
	public function ver_tablamps( $cod_cabeceramps ) {
            $this->load->library( 'layout', 'layout' );
            
            $data['titulo']         = 'TABLA MPS';
            $cabeceramps            = $this->cabeceramps_model->obtener_cabeceramps( $cod_cabeceramps );
            $lista_detalle_cabecera = $this->detallecabeceramps_model->obtener_detalle_cabecera_2( $cod_cabeceramps );
            $detalle_cabecera_array = array();
            $array_cantidad         = array();
            $array_seguridad        = array();
            $array_dias             = array();
            
            foreach( $lista_detalle_cabecera as $valor ) {
                $fecha                      = $valor->DETA_Dia . '/' . $valor->DETA_Mes . '/' 
                                                        . $valor->DETA_Anio . ' ';
                $demanda                    = $valor->DETA_Demanda;
                $ven_pedi                   = $valor->DETA_VenPedi;
                $rp                         = $valor->DETA_RecProgramada;
                $rr                         = $valor->DETA_RecReal;
                $can_dispo                  = $valor->DETA_CanDisponible;
                $ss                         = $valor->DETA_StockSeguridad;
                $detalle_cabecera_array[]   = array( $fecha, $demanda, $ven_pedi, $rp, $rr, $can_dispo, $ss );
                
                $array_cantidad[]           = $valor->DETA_CanDisponible;
                $array_seguridad[]          = $ss;
                $dias                       = ' ' . $valor->DETA_Dia . '/' . $valor->DETA_Mes . '/' 
                                                            . $valor->DETA_Anio;
                $array_dias[]               = $dias;
            }
            
            $data['lista_detalle'] 	= $detalle_cabecera_array;
            $producto = $this->producto_model->obtener_producto( $lista_detalle_cabecera[0]->PROD_Codigo );
            $data['cod_producto'] 	= $producto[0]->PROD_CodigoInterno;
            $data['des_producto'] 	= $producto[0]->PROD_Descripcion;
            $data['can_minima'] 	= $producto[0]->PROD_CantidadMinima;
            
            $data['reporte']	 	= $this->ver_reporte( $array_cantidad, $array_seguridad, $array_dias );
            
            $inventario = $this->inventario_model->obtener_inventario_x_producto_fecha_establecimiento( $cabeceramps[0]->PROD_Codigo,
                                                                                                        $cabeceramps[0]->ESTA_Codigo );
            $data['stock_actual']	= ( count($inventario) > 0 )? $inventario[0]->INVE_StockActual : 0;
            
            $data['codigo_cabecera']= $cabeceramps[0]->CABE_Codigo;
            
            $establecimiento		= $this->establecimiento_model->obtener_establecimiento( $cabeceramps[0]->ESTA_Codigo );
            $data['ubicacion']		= $establecimiento[0]->ESTA_Descripcion . ' / ' . $establecimiento[0]->ESTA_Direccion;
            
            /* para la cantidad de mensajes */
            $data['cantidad_mensajes']  = $this->alerta_model->obtener_alertas_x_producto( $producto[0]->PROD_Codigo );
            
            $this->layout->view( 'mps/ver_tablamps', $data );
        }
        
        private function ver_reporte( $cantidad, $seguridad, $dias ) {
            $cantidad_maxima = max( $cantidad );
            $cantidad_minima = min( $cantidad );
            
            $cantidad_maxima = ( $cantidad_maxima <= 0 ) ? 0 : $cantidad_maxima;
            $cantidad_minima = ( $cantidad_minima >= 0 ) ? 0 : $cantidad_minima;
            
            // Definicion del Dataset
            $DataSet = new pData;
            $DataSet->AddPoint( $cantidad, 'Serie1' );
            $DataSet->AddPoint( $seguridad, 'Serie2' );
            $DataSet->AddPoint( $dias, 'Serie3' );
            $DataSet->AddSerie( 'Serie1' );
            $DataSet->AddSerie( 'Serie2' );
            $DataSet->SetAbsciseLabelSerie( 'Serie3' );
            $DataSet->SetSerieName( 'Cantidad Disponible', 'Serie1' );
            $DataSet->SetSerieName( 'Stock de Seguridad', 'Serie2' );
            $DataSet->SetYAxisName( 'Stock' );
            $DataSet->SetXAxisName( 'Dias' );
            
            // Inicializamos el grafico
            $Test = new pChart( 800, 370 );
            $Test->setFixedScale( $cantidad_minima, $cantidad_maxima );
            $Test->setFontProperties( 'system/application/libraries/pchart/Fonts/tahoma.ttf', 8 );
            $Test->setGraphArea( 65, 30, 750, 310 );
            $Test->drawFilledRoundedRectangle( 7, 7, 793, 350, 5, 240, 240, 240 );
            $Test->drawRoundedRectangle( 5, 5, 695, 225, 5, 230, 230, 230 );
            $Test->drawGraphArea( 255, 255, 255, TRUE );
            $Test->drawScale( $DataSet->GetData(), $DataSet->GetDataDescription(), SCALE_NORMAL, 150, 150, 150, TRUE, 0, 2 );
            $Test->drawGrid( 4, TRUE, 230, 230, 230, 50 );
            
            // Draw the 0 line
            $Test->setFontProperties( 'system/application/libraries/pchart/Fonts/tahoma.ttf', 6 );
            $Test->drawTreshold( 0, 143, 55, 72, TRUE, TRUE );
            
            // Draw the line graph
            $Test->drawLineGraph( $DataSet->GetData(), $DataSet->GetDataDescription() );
            $Test->drawPlotGraph( $DataSet->GetData(), $DataSet->GetDataDescription(), 3, 2, 255, 255, 255 );
            
            // Finish the graph
            $Test->setFontProperties( 'system/application/libraries/pchart/Fonts/tahoma.ttf', 8 );
            $Test->drawLegend( 90, 35, $DataSet->GetDataDescription(), 255, 255, 255 );
            $Test->setFontProperties( 'system/application/libraries/pchart/Fonts/tahoma.ttf', 10 );
            $Test->drawTitle( 60, 22, 'REPORTE DE STOCK POR SKU', 50, 50, 50, 695 );
            $Test->Render( 'images/img_dinamic/imagen3.png' );
            $reporte = '<img style="margin-top:5px; margin-bottom:20px;" src="' . base_url() . 
                            'images/img_dinamic/imagen3.png" alt="Imagen 3" />';
            return $reporte;
	}
	
	/*public function insertar_tablamps(){
		if(!$this->session->userdata('user')){
            redirect('index/index');
        }
		if(!$_POST){
			redirect('mps/tablamps/listar_tablamps');
		}
		$retorno = '';
		$codigointerno	 	= $this->input->post('txtCodigo',TRUE);
		$descripcion		= $this->input->post('txtDescripcion',TRUE);
		$horizonte 			= $this->input->post('txtHorizonte',TRUE);
		$codigo_calendario  = $this->input->post('cboCalendario',TRUE);
		$codigo_producto	= $this->input->post('cboProducto',TRUE);
		$codigo				= $this->input->post('codigo',TRUE);
		$establecimiento	= $this->input->post('cboUbicacion',TRUE);
		$modo 				= $this->input->post('modo',TRUE);
		$lista_dias_laborables = $this->detallecalendario_model->listar_dias_laborables($codigo_calendario);
		
		if($modo == 'insertar'){
			$filter 						= new stdClass();
			$filter->CABE_CodigoInterno		= $codigointerno;
			$filter->CABE_Descripcion		= $descripcion  ;
			$filter->CABE_Horizonte			= $horizonte    ;
			$filter->CALE_Codigo			= $codigo_calendario;
			$filter->PROD_Codigo			= $codigo_producto;
			$cod_cabeceramps = $this->cabeceramps_model->insertar_cabeceramps($filter);
			$contador = 0;
			foreach($lista_dias_laborables AS $key=>$valor){
				if($key <= $horizonte && $contador > 0){
					$rp = ($contador%3==0)?100:0;
					$filtr =new stdClass();
					$filtr->CABE_Codigo    		= $cod_cabeceramps;
					$filtr->DETA_Demanda   		= 0;
					$filtr->DETA_Fecha 	   		= $valor->DCAL_Anio.'-'.$valor->DCAL_Mes.'-'.$valor->DCAL_Dia;
					$filtr->DETA_Mes 	   		= $valor->DCAL_Mes;
					$filtr->DETA_Dia 	   		= $valor->DCAL_Dia;
					$filtr->DETA_Anio 	   		= $valor->DCAL_Anio;
					$filtr->DETA_RecProgramada	= $rp;
					$this->cabeceramps_model->insertar_cabeceramps_detalle($filtr);
				}
				$contador++;
			}
		}else if($modo == 'editar'){
			//para la cantidad de dias
			$contador 		= 0;
			$cantidad_dias	= 0;
			foreach($lista_dias_laborables AS $key=>$valor){
				if($key <= $horizonte && $contador > 0){
					$cantidad_dias ++;
				}
				$contador++;
			}
			
			//
			$contador2 = 0;
			foreach($lista_dias_laborables AS $key=>$valor){
				if($key <= $horizonte && $contador2 > 0){
					$fecha = $valor->DCAL_Anio.'-'.$valor->DCAL_Mes.'-'.$valor->DCAL_Dia;
					$cod_cabeceramps = $codigo;
					$this->calcular_tablamps($fecha,$cod_cabeceramps,$establecimiento,$cantidad_dias,$contador2);
				}
				$contador2++;
			}
		}
	}
	*/
	
	// genera la tabla con todos los productos (locales, etc.)
	public function insertar_tablamps2(){
            
            @set_time_limit(0); // sin limite de tiempo de ejecucion
            
            // 2012-12-19
            // Carlos Gomez
            // elimino los elementos del calculo anterior (calculos MTS, MTO, alertas y ordenes)
            
            // elimino las alertas existentes
            $this->alerta_model->limpiar_alertas();
            
            // elimino las ordenes existentes
            $this->otrabajodetalle_model->limpiar_otrabajodetalle();
            $this->otrabajo_model->limpiar_otrabajo();
            $this->ocompradetalle_model->limpiar_ocompradetalle();
            $this->ocompra_model->limpiar_ocompra();
            $this->orden_model->limpiar_orden();
            
            // elimino los MTS y los MTO
            $this->detallecabeceramps_model->limpiar_detallecabeceramps();
            $this->cabeceramps_model->limpiar_cabeceramps();
            
            
            
            // obtengo toda la lista de productos
            $productos          = $this->producto_model->listar_producto();
            $codigo_calendario  = 37; // calendario en duro
            
            // calculo del horizonte, fecha de inicio del horizonte (un dia despues de hoy)
            $fecha_actual = new DateTime( $this->somevar['hoy'] );
            $fecha_actual->modify( '+1 day' );
            $fecha_actual = $fecha_actual->format( 'Y-m-d' );
            //echo 'Fecha inicio horizonte: '.$fecha_actual.'<br>';
            
            // fecha de fin de horizonte
            $configuracion      = $this->configuracionmps_model->obtener_configuracionmps();
            $horizonte          = $configuracion[0]->CONM_Horizonte;
            $fecha_horizonte    = new DateTime($horizonte);
            $fecha_horizonte    = $fecha_horizonte->format( 'Y-m-d' );
            //echo 'Fecha fin horizonte: '.$fecha_horizonte.'<br>';
            
            //luego calculo la cantidad de dias, convirtiendo en mktime
            $cantidad_dias_h    = dias_entre_fechas( $fecha_actual, $fecha_horizonte );
            $horizonte          = $cantidad_dias_h;
            echo 'Numero de dias del horizonte: '.$fecha_horizonte.'<br>';
            
            // esto mas adelante debe recoder los PRODUCTOS_ESTABLECIMIENTOS,
            $establecimiento	= 1;
            
            //se almacena el codigo calendario en una variable global para usarlo en la creacion de OT
            $this->codigo_calendario = $codigo_calendario;
            
            // para cada producto hacemos el calculo del MPS
            foreach( $productos as $key_general=>$valor ) {
                
                // para MTS y MTO ambos se insertan en la tabla cabecera_mps
                
                $codigo_producto        = $valor->PROD_Codigo;
                // dias de la zona1, tablaProductos (en duro : 4)
                $dias_z1                = $valor->PROD_DiasZonaCongelada;
                // dias de la zona2, tablaProductos (en duro : 3)
                $dias_z2                = $valor->PROD_DiasZonaProgMaestra;
                $lista_dias             = $this->detallecalendario_model->listar_dias( $codigo_calendario );
                $lista_dias_laborables  = $this->detallecalendario_model->listar_dias_laborables( $codigo_calendario );
                
                // calculamos un arreglo con los dias laborables por cada mes
                foreach( $lista_dias AS $key=>$valor )
                    if ( $valor->DCAL_Flag == 0 )
                        $ANHO_MES[ $valor->DCAL_Anio . $valor->DCAL_Mes ] += 1;
                // $MES = array( '201212'=>31, '201301=>31', '201302'=>28, ... , '201311'=>30 );
                
                $posicion=0;
                foreach( $ANHO_MES as $indice=>$dias ) {
                    $anho = substr( $indice, 0, 4 );
                    $mes = substr( $indice, 4, 2 );
                    $ANHO_MES_ORDENADO[$anho][$mes] = array( 'posicion'=>$posicion, 'dias'=>$dias );
                    $posicion++;
                }
                // $ANHO_MES_ORDENADO['2012']['12'] = array( 'posicion'=>'0', 'dias'=>'31' );
                // ...
                
                // calculo de la cantidad de dias laborables para sacar el pronostico
//                $cantidad_dias	= 0;
//                $contador       = 0;
//                foreach( $lista_dias_laborables as $key=>$valor ) {
//                    $fechaLaborable = $valor->DCAL_Anio . '-' . $valor->DCAL_Mes . '-' . $valor->DCAL_Dia;
//                    if ( $key <= $horizonte && $contador > 0 )
//                        $cantidad_dias ++;
//                    $contador++;
//                }
                
                $filter                 = new stdClass();
                $filter->CABE_Horizonte = $horizonte    ;
                $filter->CALE_Codigo    = $codigo_calendario;
                $filter->PROD_Codigo    = $codigo_producto;
                $filter->ESTA_Codigo    = $establecimiento;
                $filter->COMP_Codigo    = $this->somevar['compania_hija'];
                
                // inserta la cabecera del MPS y devuelve el "id" insertado (se valida que sea transaccion)
                $cod_cabeceramps = $this->cabeceramps_model->insertar_cabeceramps( $filter );
                
                $contador = 0;
                $contadorRR = 0;
                foreach( $lista_dias AS $key=>$valor ) {
                    $fecha = $valor->DCAL_Anio . '-' . $valor->DCAL_Mes . '-' . $valor->DCAL_Dia;
                    
                    if ( $key<=$horizonte && $contador>0 ) {
                        // solo para carga demanda MTS (Make To Stock)
                        $filterD                = new stdClass();
                        $filterD->PROD_Codigo   = $codigo_producto;
                        $filterD->ESTA_Codigo   = $establecimiento;
                        $filterD->DEMA_Tipo     = 1;
                        $demanda_mts            = $this->producto_model->obtener_demandaMTS( $filterD );
                        
                        // el mes esta en duro (siempre toma el primer mes)
                        //$demanda_dia            = $demanda_mts[ 0 ]->DDEM_Cantidad / $cantidad_dias;
                        
                        $posicion = $ANHO_MES_ORDENADO[ $valor->DCAL_Anio ][ $valor->DCAL_Mes ][ 'posicion' ];
                        $dias = $ANHO_MES_ORDENADO[ $valor->DCAL_Anio ][ $valor->DCAL_Mes ][ 'dias' ];
                        $demanda_dia = $demanda_mts[ $posicion ]->DDEM_Cantidad / $dias;
                        
                        
                        $rp = 0;    // $rp = RECEPCION PROGRAMADA
                        $rr = 0;    // $rr = RECEPCION REAL
//                        if ( $valor->DCAL_Dia == '15' )
//                          $rr = 40;  
//                        else
//                            $rr = 0;
                        
                        
                        // $contador es el tiempo transcurrido.
                        
//                        $contadorRR++;
//                        if ( $contadorRR == 15 ) {
//                            $rr = 40;
//                            $contadorRR = 0;
//                        } else {
//                            $rr = 0;
//                        }
                        
                        
                        if ( $contador <= $dias_z1 ) {
                            // si estamos en la zona1, pone a las RP en cero, y a las RR normal.
                            $rp = 0;
                            
                            $filterO                = new stdClass();
                            $filterO->PROD_Codigo   = $codigo_producto;
                            $filterO->fecha         = $fecha;
                            $filterO->OTRA_Estado   = '1';
                            
                            // no importa el tipo(compra,trabajo) DE ORDEN, sumas las cantidades PENDIENTES
                            // no importa si vienen de distintos proveedores(solo en ordenes de compra), se suman todas
                            $orden                  = $this->producto_model->obtener_orden_x_fecha( $filterO );
                            if ( count($orden) > 0 ) {
                                foreach( $orden as $value )
                                    $rr += $value->OCOM_CantPendiente;
                            } else {
                                // no olvidar eliminar esto, es solo para test
                                
                                // 2012-12-13
                                // Ing. Wilson Tello y Carlos Gómez
                                // agregamos 50 unidades en la recepccion real el 15 de cada mes
                                // $rr = 50;
                                
                                //$rr = 20;
                            }
                        } elseif ( $contador <= $dias_z2 ) {
                            // si estamos en la zona2, pone a las RP normal, y a las RR en cero.
                            // aca debe jalar las ordenes planificadas confirmadas, por ahora esta en duro
                            $rp = 0;
                            $rr = 0;
                            
//                                $contadorRR++;
//                                if ( $contadorRR == 15 ) {
//                                    $rr = 40;
//                                    $contadorRR = 0;
//                                } else {
//                                    $rr = 0;
//                                }
                        }
                        
                        $filtr                      = new stdClass();
                        $filtr->CABE_Codigo         = $cod_cabeceramps;
                        if ( $valor->DCAL_Flag == 0 ) {
                            $filtr->DETA_Demanda        = $demanda_dia;
                            //$filtr->DETA_RecProgramada  = $rp;
			} elseif ( $valor->DCAL_Flag == 1 ) {
                            $filtr->DETA_Demanda        = 0;
                            //$filtr->DETA_RecProgramada  = 0;
                        }
                        $filtr->DETA_Fecha          = $fecha;
                        $filtr->DETA_Mes            = $valor->DCAL_Mes;
                        $filtr->DETA_Dia            = $valor->DCAL_Dia;
                        $filtr->DETA_Anio           = $valor->DCAL_Anio;
                        $filtr->DETA_RecProgramada  = $rp;
                        $filtr->DETA_RecReal        = $rr;
                        $this->cabeceramps_model->insertar_cabeceramps_detalle( $filtr );
                    } // fin del if
                    $contador++;
                } // fin del foreach
                
                $contador = 0;
                foreach( $lista_dias AS $key=>$valor ) {
                    if ( $key <= $horizonte && $contador > 0 ) {
                        $fecha = $valor->DCAL_Anio . '-' . $valor->DCAL_Mes . '-' . $valor->DCAL_Dia;
                        $flag = $valor->DCAL_Flag;
                        //calcula la tabla y graba por codigo_cabecera y por FECHA (para todos los dias)
                        $this->calcular_tablamps( $fecha, $cod_cabeceramps, $establecimiento, $contador, 
                                                  $dias_z1, $dias_z2 );
                    }
                    //$contador++;
                    if ( $valor->DCAL_Flag == 0 )
                        $contador++;
                } // fin del foreach
                
            } // fin del foreach
            
        } // fin de insertar_tabla_mps_2
        
        // no se esta usando este metodo, solo el anterior
        public function insertar_tablamps() {
            if ( ! $this->session->userdata('user') )
                redirect( 'index/index' );
            
            if ( ! $_POST )
                redirect( 'mps/tablamps/listar_tablamps' );
            
            $retorno = '';
            
            $codigointerno      = $this->input->post( 'txtCodigo', TRUE );
            $descripcion        = $this->input->post( 'txtDescripcion', TRUE );
            $horizonte          = $this->input->post( 'txtHorizonte', TRUE );
            $codigo_calendario  = $this->input->post( 'cboCalendario', TRUE );
            $codigo_producto    = $this->input->post( 'cboProducto', TRUE );
            $codigo             = $this->input->post( 'codigo', TRUE );
            $establecimiento    = $this->input->post( 'cboUbicacion', TRUE );
            $modo               = $this->input->post( 'modo', TRUE );
            
            $lista_dias             = $this->detallecalendario_model->listar_dias( $codigo_calendario );
            $lista_dias_laborables  = $this->detallecalendario_model->listar_dias_laborables( $codigo_calendario );
            
            if ( $modo == 'insertar' ) {
                
                // para la cantidad de dias LABORABLES, dividirlo y sacar el pronostrico
                $contador       = 0;
                $cantidad_dias  = 0;
                foreach( $lista_dias_laborables AS $key=>$valor ) {
                    if ( $key<=$horizonte && $contador>0 )
                        $cantidad_dias ++;
                    $contador++;
                }
			
                $filter                     = new stdClass();
                $filter->CABE_CodigoInterno = $codigointerno;
                $filter->CABE_Descripcion   = $descripcion  ;
                $filter->CABE_Horizonte     = $horizonte    ;
                $filter->CALE_Codigo        = $codigo_calendario;
                $filter->PROD_Codigo        = $codigo_producto;
                $filter->ESTA_Codigo        = $establecimiento;
                $cod_cabeceramps            = $this->cabeceramps_model->insertar_cabeceramps( $filter );
                $contador = 0;
                foreach( $lista_dias AS $key=>$valor ) {
                    if ( $key<=$horizonte && $contador>0 ) {
                        // carga demanda MTS
                        $filterD                = new stdClass();
                        $filterD->PROD_Codigo   = $codigo_producto;
                        $filterD->ESTA_Codigo   = $establecimiento;
                        $filterD->DEMA_Tipo     = 1;                    // este valor esta en duro
                        $demanda_mts            = $this->producto_model->obtener_demandaMTS( $filterD );
                        // $demanda_dia = $demanda_mts[0]->DDEM_Cantidad / $cantidad_dias;
                        $demanda_dia = 100;
                        
                        //jala de las ordenes planificadas confirmadas, por ahora esta con 100.
                        $rp = ( $contador%3 == 0 ) ? 100 : 0;
                        
                        $filtr = new stdClass();
                        $filtr->CABE_Codigo = $cod_cabeceramps;
                        if ( $valor->DCAL_Flag == 0 ) {
                            $filtr->DETA_Demanda = $demanda_dia;
                        } elseif ( $valor->DCAL_Flag == 1 ) {
                            $filtr->DETA_Demanda = 0;
                        }
                        $filtr->DETA_Fecha          = $valor->DCAL_Anio . '-' . $valor->DCAL_Mes . '-' . $valor->DCAL_Dia;
                        $filtr->DETA_Mes            = $valor->DCAL_Mes;
                        $filtr->DETA_Dia            = $valor->DCAL_Dia;
                        $filtr->DETA_Anio           = $valor->DCAL_Anio;
                        $filtr->DETA_RecProgramada  = $rp;
                        $this->cabeceramps_model->insertar_cabeceramps_detalle( $filtr );
                    } // fin del if
                    $contador++;
                } // fin del foreach
                
            } elseif ( $modo == 'editar' ) {
                $dias_z2 = 10;
                $dias_z1 = 4;
                $contador = 0;
                foreach( $lista_dias AS $key=>$valor ) {
                    if ( $key<=$horizonte && $contador>0 ) {
                        $fecha = $valor->DCAL_Anio . '-' . $valor->DCAL_Mes . '-' . $valor->DCAL_Dia;
                        $cod_cabeceramps = $codigo;
			//calcula la tabla y graba por codigo_cabecera y por FECHA (para todos los dias)
                        $this->calcular_tablamps( $fecha, $cod_cabeceramps, $establecimiento, $contador, $dias_z1, $dias_z2 );
                    }
                    $contador++;
                } // fin del foreach
            } // fin del if/elseif
	} // fin del insertar_editar_tabla_mps
	
	private function calcular_tablamps( $fecha, $cod_cabeceramps, $establecimiento, $contador,
                                            $dias_z1, $dias_z2 ) {
            
            $fecha = date( 'Y-m-d', strtotime($fecha) );
            
            // cabecera y detallecabecera
            $cabeceramps         = $this->cabeceramps_model->obtener_cabeceramps( $cod_cabeceramps );
            $detalle_cabeceramps = $this->detallecabeceramps_model->obtener_detalle_cabecera_3(
                                                            $cabeceramps[0]->CABE_Codigo, $fecha );
            
            // obtenemos el producto
            $producto = $this->producto_model->obtener_producto( $cabeceramps[0]->PROD_Codigo );
            
            // carga demanda MTS, ya jala de la tabla cji_detallecabeceramps, lo inserto cuando grabo
            $demanda_dia = $detalle_cabeceramps[0]->DETA_Demanda;
            
            // carga demanda MTO o PEDIDO
            $filterDO               = new stdClass();
            $filterDO->PROD_Codigo  = $cabeceramps[0]->PROD_Codigo;
            $filterDO->ESTA_Codigo  = $establecimiento;
            $filterDO->DEMA_Fecha   = $fecha;
            $filterDO->DEMA_Tipo    = 2;
            $demanda_mto            = $this->producto_model->obtener_demandaMTO( $filterDO );
            
            // carga inventario
            $filterI                = new stdClass();
            $filterI->PROD_Codigo   = $cabeceramps[0]->PROD_Codigo;
            $filterI->ESTA_Codigo   = $establecimiento;
            $inventario             = $this->producto_model->obtener_inventario( $filterI );
		
            // carga ordenes
            $filterO                = new stdClass();
            $filterO->PROD_Codigo   = $cabeceramps[0]->PROD_Codigo;
            
            //no importa el tipo(compra,trabajo) DE ORDEN, sumas las cantidades PENDIENTES, pueden ser diferentes proveedores
            $orden = $this->producto_model->obtener_orden( $filterO );
            
            // $cantidad_decimales = $this->.....ESTO DEBERIA JALAR DE LA CONFIGURACION GENERAL, POR AHORA ESTA EN DURO
            $configuracionSistema   = $this->configuracionsistema_model->obtener_configuracion();
            $cantidad_decimales     = $configuracionSistema[0]->CONS_Decimales;
            $permiteNegativos       = $configuracionSistema[0]->CONS_FlagStockNegativoPlanificacion;
            
            
            /********************************************************
            ************VARIABLES PARA USAR EN EL CALCULO************
            ********************************************************/
            $demanda_dia = round( $demanda_dia, $cantidad_decimales );
            
            $can_inventario = 0;
            if ( $contador == 1 )
                $can_inventario 	= ( count($inventario) > 0 ) ? $inventario[0]->INVE_StockActual : 0;
            else {
                //jala de la VARIABLE GLOBAL
                $can_inventario = $this->cantidad_disponible;
            }
            
            $stock_seguridad = $producto[0]->PROD_StockSeguridad;
            
            // jala de la tabla cabeceradetalle 
            $rp         = 0;
            $rp         = $this->detallecabeceramps_model->obtener_detalle_cabecera_3( $cabeceramps[0]->CABE_Codigo, $fecha );
            $rp         = $rp[0]->DETA_RecProgramada;
            $rp_inicial = $rp;
            
            $rr = 0;
            $rr = $this->detallecabeceramps_model->obtener_detalle_cabecera_3( $cabeceramps[0]->CABE_Codigo, $fecha );
            $rr = $rr[0]->DETA_RecReal;
            $rr = $rr;
            
            // variable para capturar los PEDIDOS/VENTAS
            $demanda_cantidad   = ( count($demanda_mto) > 0 ) ? $demanda_mto[0]->DEMA_Cantidad : 0;
            
            // variables para un calculo especial del RP que depende de tipo_planificacion y regla_planificacion
            // tipo_planificacion, esta variable se jala de la tabla de productos, sirve para los calculos del RP
            $tipo_planificacion	= $producto[0]->PROD_TipoPlanificacion;
            // REGLA DE PLANIFICACION, esta variable se jala de la tabla de productos, sirve para definir como trabajar(LOTE X LOTE,EOQ,CAN MIN,CAN FIJA,STOCK MAX)
            $regla_planificacion= $producto[0]->PROD_ReglaPlanificacion;
            // lote economico
            $eoq                    = $producto[0]->PROD_LoteEconomico;
            // cantidad minima
            $can_minima             = $producto[0]->PROD_CantidadMinima;
            // cantidad maxima
            $can_maxima             = $producto[0]->PROD_CantidadMaxima;
            // cantidad multiplo
            $can_multiplo           = $producto[0]->PROD_CantidadMultiplo;
            // cantidad fija
            $can_fija               = $producto[0]->PROD_CantidadFija;
            // stock maximo
            $stock_maximo           = $producto[0]->PROD_StockMaximo;
            // punto de reorden
            $pr                     = $producto[0]->PROD_PuntoReorden;
            
            /******************************************************
            ********************* CALCULOS ************************
            ******************************************************/
		
            // calcula la recepcion programa
            // echo 'antes del calculo : ' . $rp . " // ";
            $rp = max( $demanda_dia, $demanda_cantidad ) + $stock_seguridad - $can_inventario - $rr - $rp;
            // echo 'despues del calculo, a impre : ' . $rp . " // ";
            if ( $rp < 0 )
                $rp = 0;
            elseif ( $rp >= 0 )
                $rp += $rp_inicial;
            // echo 'despues del calculo, d impre : ' . $rp . " // ";
            
            // si el RP es mayor a CERO, recien entra para hacer calculos segun algunos parametros
            if ( $rp > 0 ) {
                // volvemos a calcular el RP, por el parametro tipo_planificacion
                // si es 1(PROGRAMACION MAESTRA), detro hay 5 tipos(regla_planificacion) que determinan el NUEVO RP.
		if ( $tipo_planificacion == '1' ) {
                    
                    if ( $regla_planificacion == '1' ) {    // si es LOTE X LOTE
                        // si mi RP(requerimiento) esta entre can_minima y can_maxima
                        if ( $rp>$can_minima && $rp<$can_maxima )
                            $rp = $rp;
                        // si mi RP es menor que la can_minima
                        elseif ( $rp < $can_minima )
                            $rp = $can_minima;
                        // si mi RP es mayor que la can_maxima
                        elseif ( $rp > $can_maxima ) {
                            // verifica el STOCK MAXIMO
                            if ( $rp < $stock_maximo ) {
                                $entero_mayor = ( $rp / $can_maxima );
                                $rp = $rp * $entero_mayor;
                            } else {
                                // EN ESTE CASO MI PRONOSTICO ES MAYOR QUE MI STOCK MAXIMO
				// ENTONCES ES UNA MALA PLANIFICACION, AQUI EMITE UN MENSAJE DE ERROR
                                $rp = $stock_maximo;
                            }
                        }
                    } elseif ( $regla_planificacion == '2' ) {    // si es LOTE ECONOMICO
                        // si mi RP(requerimiento) es mayor al EOQ
                        if ( $rp > $eoq ) {
                            $entero_mayor = $rp / $eoq;
                            // obtengo el entero mayor
                            $entero_mayor = ceil( $entero_mayor );
                            $rp = $entero_mayor * $eoq;
                        } else {
                            $rp = $eoq;
                        }
                    } elseif ( $regla_planificacion == '3' ) {    // si es CANTIDAD MINIMA
                        // si mi RP(requerimiento) es mayor al can_minima
                        if ( $rp > $can_minima ) {
                            $rp = $rp - $can_minima;
                            $entero_mayor = $rp / $can_multiplo;
                            // obtengo el entero mayor
                            $entero_mayor = ceil( $entero_mayor );
                            $rp = $can_minima + ( $rp * $can_multiplo );
                        } else {
                            $rp = $can_minima;
                        }
                    } elseif ( $regla_planificacion == '4' ) {   // si es CANTIDAD FIJA
                        // si mi RP(requerimiento) es mayor al can_fija
                        if ( $rp > $can_fija ){
                            $entero_mayor = $rp / $can_fija;
                            // obtengo el entero mayor
                            $entero_mayor = ceil($entero_mayor);
                            $rp = $entero_mayor * $can_fija;
                        } else {
                            $rp = $can_fija;
                        }
                    } elseif ( $regla_planificacion == '5' ) {   //si es STOCK MAXIMO
                        if ( $rp < $stock_maximo ) {
                            $rp = $stock_maximo - $rp;
                        }
                    }
                } elseif ( $tipo_planificacion == '2' ) {    //si es PTO REORDEN
                    if ( $can_inventario >= $pr ) {
                        $rp = $can_minima;
                    }
                } else { //si no es ninguno
                    //no afecta al RP
                    $rp = $rp;
                }
            } elseif( $rp == 0 ) {
                // si es cero no hace algun calculo adicional (el rp que llega aqui jamas es negativo, arriba se valida)
                $rp = 0;
            }
            
            // validar el tiempo de las zonas
            if ( $contador <= $dias_z1 ) {
                // si estamos en la zona1, pone a las RP en cero, y a las RR normal.
                $rp = 0;
                $rr = $rr;
            } elseif ( $contador <= $dias_z2 ) {
                // si estamos en la zona2, pone a las RR en cero, y a las RP normal.
                $rp = 0;
                $rr = 0;
            } else { // despues de la zona2
                // 2012-12-19
                // Ing. Alex Vidal y Carlos Gomez
                // la reposicion es al final de la zona2 (Modelo clasico MTS)
                // falta considerar que debe tomar solo dias laborables (no todo el calendario)
                $rp = $rp;
                $rr = 0;
            }
            
            // inventario disponible
            $can_inventario = $can_inventario + $rr + $rp - max( $demanda_dia, $demanda_cantidad );
            
            /******************* CONDICIONES SEGUN UNA CONFIGURACION *******************
            ************ PENDIENTE REVISAR CONFIGURACION DE STOCK NEGATIVO **********/
            
            
            /******************* CREACION DE OTS *******************/
            if ( $rp > 0 ) {
                //echo $fecha;
                $filter                 = new stdClass();
                $filter->numero         = 1055;//numero de orden;
                $filter->tipo           = 1;
                $filter->cod_producto   = $producto[0]->PROD_Codigo;
                $filter->cod_ubicacion  = 1;
                $filter->cant_plani     = $rp;
                $filter->cant_pendi     = 0;
                $filter->estado         = 2;
                $filter->fech_fin_entre = $fecha;
                $this->emitir_ot( $filter, $fecha );
            }
            
            /*******************MENSAJES*******************/
            // Tabla: cji_tipoalerta
            // A-01 =>lanzamiento de orden
            // A-02 =>lanzamiento tarde
            // A-03 =>rotura de stock
            // A-04 =>posible rotura de stock
            // A-06 =>inventario por debajo del stock de seguridad
            
            // VARIABLES
            $conf_mensake   = $this->configuracionmensaje_model->obtener_configuracionmensaje();
            $posible_rotura = $conf_mensake[0]->CMEN_PosibleRoturaStock;
            $stock_debajo   = $conf_mensake[0]->CMEN_InveDebajoSotck;
            $dias_lan_tarde = $conf_mensake[0]->CMEN_LanzaTarde;
		
            $filter                 = new stdClass();
            $filter->PROD_Codigo    = $cabeceramps[0]->PROD_Codigo;
            $filter->FAMI_Codigo    = 0;
            $filter->LINE_Codigo    = 0;
            $filter->ALER_Fecha     = $fecha;
            
            // mensaje rotura de stock
            if ( $can_inventario < 0 )
                $this->emitir_mensaje( 'A-03', $filter );
            
            // mensaje de posible rotura de stock
            if ( $stock_seguridad > 0 ) {
                $porcentaje = ( $posible_rotura * $stock_seguridad ) / 100;
                $porcentaje = $stock_seguridad - $porcentaje;
                if ( $can_inventario < $porcentaje ) {
                    $this->emitir_mensaje( 'A-04', $filter );
                }
            } elseif ( $can_minima > 0 ) {
                $porcentaje = ($posible_rotura * $can_minima) / 100;
                $porcentaje = $can_minima - $porcentaje;
                if ( $can_inventario < $porcentaje ) {
                    $this->emitir_mensaje( 'A-04', $filter );
                }
            } elseif ( $eoq > 0 ) {
                $porcentaje = ($posible_rotura * $eoq) / 100;
                $porcentaje = $eoq - $porcentaje;
                if ( $can_inventario < $porcentaje ) {
                    $this->emitir_mensaje( 'A-04', $filter );
                }
            }
		
            // mensaje de inventario por debajo del stock de seguridad
            if ( $stock_seguridad > 0 ) {
                $porcentaje = ($stock_debajo * $stock_seguridad) / 100;
                if ( $can_inventario <= $porcentaje ) {
                    $this->emitir_mensaje( 'A-06', $filter );
                }
            }
            
            // mensaje lanzamiento tarde
            // tengo que verificar el parametro de dias para lanzamiento tarde(jala de tabla condiguracionmensaje)
            // ese parametro es una cantidad de dias, tengo que avisar antes que llegue la fecha de la OT
            // y luego tiene que buscar si hay una OT confirmada, y segun eso va lanzando el mensaje
            $fecha_aumentada = new DateTime( $fecha );
            $fecha_aumentada->modify( '+' . $dias_lan_tarde . ' day' );
            $fecha_aumentada = $fecha_aumentada->format( 'Y-m-d' );
            // primer parametro => codigo producto
            // segundo parametro => fecha de la orden, esto depende del tipo de ORDEN(2=OTRA_FechaIniFabri)
            // tercer parametro => tipo de orden (1=OT, 2=OC)
            // cuarto parametro => estado de orden (1=En proceso, 2= Planificada, 3= Confirmada)
            $orden = $this->orden_model->buscar_orden( $producto[0]->PROD_Codigo, $fecha_aumentada, 1, 3 );
            if ( count($orden) > 0 ) {
                $this->emitir_mensaje( 'A-02', $filter );
            }
            
            // mensaje lanzamiento de orden
            $fecha_restada = new DateTime($fecha);
            $fecha_restada->modify( '-1 day' );
            $fecha_restada = $fecha_restada->format('Y-m-d');
            // primer parametro => codigo producto
            // segundo parametro => fecha de la orden, esto depende del tipo de ORDEN(2=OTRA_FechaIniFabri)
            // tercer parametro => tipo de orden (1=OT, 2=OC)
            // cuarto parametro => estado de orden (1=En proceso, 2= Planificada, 3= Confirmada)
            $orden = $this->orden_model->buscar_orden($producto[0]->PROD_Codigo,$fecha_restada,1,3);
            if ( count($orden) > 0 ) {
                $this->emitir_mensaje( 'A-01', $filter );
            }
            
            // crea el objeto para modificar el detallecabecera
            $filterDC                       = new stdClass();
            $filterDC->CABE_Codigo          = $cabeceramps[0]->CABE_Codigo;
            $filterDC->DETA_Demanda         = $demanda_dia;
            $filterDC->DETA_VenPedi         = $demanda_cantidad;
            $filterDC->DETA_RecProgramada   = $rp;
            $filterDC->DETA_RecReal         = $rr;
            
            // esto define si se consideran stocks negativos para la planificacion
            if ( $can_inventario < 0  &&  $permiteNegativos == 0 )
                $can_inventario = 0;
            
            $filterDC->DETA_CanDisponible   = $can_inventario;
            $filterDC->DETA_StockSeguridad  = $stock_seguridad;
            $filterDC->DETA_Fecha           = $fecha;
            $this->detallecabeceramps_model->modificar_detallecabeceramps( $filterDC );
            
            // almacena la cantidad disponivble(INVENTARIO) y lo almacena en una variable global
            $this->cantidad_disponible      = $can_inventario;
		
	} // fin del calcular_tabla_mps
	
	// NO OLVIDAR BORRAR ESTA FUNCION
        public function simulador(){
            $conf_mensake   = $this->configuracionmensaje_model->obtener_configuracionmensaje();
            $dias_lan_tarde = $conf_mensake[0]->CMEN_LanzaTarde;
            // para agregar fechas estilo orientado a objetos
            //echo '2012-01-26 <br />';
            $fecha = new DateTime( '2012-01-26' );
            $fecha->modify( '' . $dias_lan_tarde . ' day' );
            //echo $fecha->format( 'Y-m-d' ) . "\n";  exit;
		
            // primer parametro => codigo producto
            // segundo parametro => fecha de la orden, esto depende del tipo de ORDEN(2=OTRA_FechaIniFabri)
            // tercer parametro => tipo de orden (1=OT, 2=OC)
            // cuarto parametro => estado de orden (1=En proceso, 2= Planificada, 3= Confirmada)
            $orden = $this->orden_model->buscar_orden( 1, '2012-08-23', 1, 3 );
            //print_r($orden);
        }
        
        private function emitir_mensaje( $codigo_interno, $filter ) {
            $tipo_alerta            = $this->tipoalerta_model->obtener_alerta_interno( $codigo_interno );
            $filter->TALE_Codigo    = $tipo_alerta[0]->TALE_Codigo;
            $this->alerta_model->insertar_alerta( $filter );
        }
        
        private function emitir_ot( $filter, $fecha ) {
            // tiene que verificar la fecha en que se va a crear esta OT,
            // para que asi, pueda retroceder(segun el dia que se demora en hacer el producto)
            // $lista_dias = $this->detallecalendario_model->listar_dias($this->codigo_calendario);
            $lista_dias = $this->detallecalendario_model->listar_dias( 1 );
            
            // esto se jala de la tabla productos, por ahora esta en duro.
            // $producto = $this->producto_model->obtener_producto($filter->cod_producto);
            $t_fabricacion = 10;
            // variable para almacenar la FECHA DE fabricacion de la OT
            $f_fabricacion = '';
            
            $array_eliminado = array();
            // $fecha = '2012-09-30';
            $fecha = date( 'Y-m-d', strtotime($fecha) );
            // echo ' fecha entrante :' . $fecha;
            // para que solo tener el array desde el inicio del MPS, hasta el dia en que se va
            // a crear una OT, para asi despues invertir y recorrer el array y colocar esa fecha
            // para la FECHA DE fabricacion
            
            foreach( $lista_dias as $key=>$value ) {
                $array_eliminado[] = $value;
                $fecha_calendario = $value->DCAL_Fecha;
                $fecha_calendario = date("Y-m-d",strtotime($fecha_calendario));
                //echo $fecha_calendario.' -- '.$fecha.' ///// ';
                if ( $fecha_calendario == $fecha )
                    break;
            }
		
            $array_invertido = array_reverse( $array_eliminado );
            
            // ahora ya tengo mi array invertido y con limite hasta la fecha que se va
            // a crear la OT, y recorro
            $t_fabricacion = $t_fabricacion - 1;
            foreach( $array_invertido as $key=>$value ) {
                if ( $key == $t_fabricacion ) {
                    $f_fabricacion = $value->DCAL_Fecha;
                    $f_fabricacion = date( 'Y-m-d', strtotime($f_fabricacion) );
                    break;
                }
            }
            
            echo ' FECHA DE FABRICACION : ' . $f_fabricacion . '<br />';
            // $f_fabricacion = '2012-09-24';
            // echo $f_fabricacion."<br />";
            
            //OJO : como el dia que se va a crear la OT, puede caer no laborable,
            //entonces cuando retrocedo, tambien puede caer en un dia no laborable
            // y tengo que validar.
            $lista_dias_laborables = $this->detallecalendario_model->listar_dias_laborables( $this->codigo_calendario );
            $lista_dias_laborables = array_reverse( $lista_dias_laborables );
            $f_fabricacion = explode( '-', $f_fabricacion );
            $f_fabricacion = gmmktime( 0, 0, 0, $f_fabricacion[1], $f_fabricacion[2], $f_fabricacion[0] );
            foreach( $lista_dias_laborables as $key=>$value ) {
                $fecha_calendario = $value->DCAL_Fecha;
                $fecha_calendario = date( 'Y-m-d', strtotime($fecha_calendario) );
                $f_final = $fecha_calendario;
                $fecha_calendario = explode( '-', $fecha_calendario );
                //tengo que convertir la fecha en TIME, para poder avanzar
                $fecha_calendario = gmmktime( 0, 0, 0, $fecha_calendario[1], $fecha_calendario[2], $fecha_calendario[0] );
                if ( $fecha_calendario <= $f_fabricacion ) {
                    $f_fabricacion = $f_final;
                    break;
                }
            }
            //echo $f_fabricacion;
            //exit;
		
            $filter->fech_plani_ent	= '';
            $filter->fech_ini_fabri	= $f_fabricacion;
            // insertar ORDEN
            // 
            $this->orden_model->insertar_orden($filter);
            
		}
                
    }
    
?>
