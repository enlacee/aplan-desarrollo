<?php

    include( 'system/application/libraries/Excel/reader.php' ); 
    
    class Carga_Masiva extends controller{
        
        public function __construct() {
            parent :: Controller();
            $this->load->helper( 'url' );
            $this->load->library( 'html' );
            $this->load->model( 'almacen/producto_model' );
            $this->load->model( 'almacen/inventario_model' );
            $this->load->model( 'almacen/familia_model' );
            $this->load->model( 'maestros/establecimiento_model' );
            $this->load->model( 'maestros/tablalog_model' );
            $this->load->model( 'maestros/periodo_model' );
            $this->load->model( 'maestros/demanda_model' );
            $this->load->model( 'maestros/detalledemanda_model' );
            $this->load->model( 'maestros/taller_model' );
            $this->load->model( 'compras/orden_model' );
            $this->somevar['compania'] = $this->session->userdata( 'compania' );
            $this->somevar['compania_hija'] = $this->session->userdata( 'compania_hija' );
        }
        
        public function index(){
            $this->cargar_archivos();
        }
        
        public function cargar_archivos() {
            if ( ! $this->session->userdata('user') )
                redirect( 'index/index' );
            
            $this->load->library('layout','layout');
            $data['lista_log_demanda']      = $this->tablalog_model->listar_log( 0 );
            $data['lista_log_inventario']   = $this->tablalog_model->listar_log( 1 );
            $data['lista_log_ordenes']      = $this->tablalog_model->listar_log( 2 );
            $data['lista_log_productos']    = $this->tablalog_model->listar_log( 3 );
            $data['titulo']                 = 'SELECCIONE LOS ARCHIVOS A CARGAR';
            $this->layout->view( 'maestros/cargar_archivos', $data );
        }
        
        public function ver_producto($producto){
            if ( ! $this->session->userdata('user') )
                redirect( 'index/index' );
            
            $data['titulo'] = 'TABLA DE PRODUCTO';
                $this->load->view( 'maestros/ver_producto', $data );
        }
        
        public function ver_errores(  $flag ) {
            if ( ! $this->session->userdata('user') )
                redirect( 'index/index' );
            
            $data['lista_log_demanda']  = $this->tablalog_model->listar_log( $flag );
            $data['titulo']             = 'LISTA DE ERRORES';
            $this->load->view( 'maestros/carga_masiva_errores_pop', $data );
        }
        
        public function ver_demanda() {
            $productos = $this->producto_model->listar_producto();
            $table = '<table class="Table_Class" width="100%" cellspacing="0" cellpadding="3" border="0" id="Table1">';
            foreach( $productos as $value )
                $table .= $this->ver_registros( $value->PROD_Codigo );
            $table .= '</table>';
            
            $data['titulo'] = 'LISTA DE DEMANDAS GRABADAS';
            $data['table']  = $table;
            $this->load->view( 'maestros/carga_masiva_grabados_pop_2', $data );
        }
        
        public function ver_registros( $producto ) {
            if ( ! $this->session->userdata('user') )
                redirect( 'index/index' );
            
            $periodo        = $this->periodo_model->listar_periodos_con_detalles($producto);
            $lista_periodos = $periodo;
            $meses          = array();
            $cantidad_mes   = array();
            foreach( $periodo as $value ) {
                $meses[] = $this->detalledemanda_model->obtener_detalle_demanda( $value->PERI_Codigo,
                                                                                 $value->DEMA_Codigo );
                $cantidad_mes[] = $this->detalledemanda_model->obtener_detalle_demanda( $value->PERI_Codigo,
                                                                                        $value->DEMA_Codigo );
            }
            $lista_meses    = $meses;
            $lista_cantidad = $cantidad_mes;
            
            $producto = $this->producto_model->obtener_producto($producto);
		
            $filas = '';
            $filas .='<tr>';
            $filas .= '<th colspan="13">';
            $filas .= '<span style="font-size:14px;font-weight:bold;">PRODUCTO : '.$producto[0]->PROD_CodigoInterno.'/ '.$producto[0]->PROD_Descripcion.'</span>';
            $filas .='</th>';
            $filas .='</tr>';
            $filas .= '</tr>';
            $filas .= '<th>&nbsp;</th>';
            foreach( $lista_meses as $value )
                foreach( $value as $meses )
                    $filas .= '<th>'.$this->convertir_meses( $meses->DDEM_Mes ) . '/'. $meses->DDEM_Anio . '</th>';
            $filas .= '</tr>';
            
            if ( count($lista_periodos) > 0 ) {
                foreach( $lista_periodos as $value ) {
                    $filas .= '<tr>';
                    $filas .= '<td>' . $value->PERI_Aux . '</td>';
                    foreach( $lista_cantidad as $value )
                        foreach($value as $cantidad)
                            $filas .= '<td align="center">'.$cantidad->DDEM_Cantidad.'</td>';
                    $filas .= '</tr>';
                }
            }
            
            return $filas;
        }
	
	/*public function ver_registros($producto){
		if(!$this->session->userdata('user')){
            redirect('index/index');
        }
		$periodo = $this->periodo_model->listar_periodos_con_detalles($producto);
		$data['lista_periodos'] = $periodo;
		//print_r($periodo);exit;
		$meses = array();
		$cantidad_mes = array();
		foreach($periodo as $value){
			$meses[] = $this->detalledemanda_model->obtener_detalle_demanda($value->PERI_Codigo,$value->DEMA_Codigo);
			$cantidad_mes[] = $this->detalledemanda_model->obtener_detalle_demanda($value->PERI_Codigo,$value->DEMA_Codigo);
		}
		//print_r($meses);exit;
		$data['lista_meses'] = $meses;
		$data['lista_cantidad'] = $cantidad_mes;
		$data['titulo'] = "LISTA DE DEMANDAS GRABADAS";
		$producto = $this->producto_model->obtener_producto($producto);
		$array_producto = array('codigo'=>$producto[0]->PROD_CodigoInterno,'descripcion'=>$producto[0]->PROD_Descripcion);
		$data['producto'] = $array_producto;
		$this->load->view('maestros/carga_masiva_grabados_pop',$data);
	}public function ver_registros($producto){
		if(!$this->session->userdata('user')){
            redirect('index/index');
        }
		$periodo = $this->periodo_model->listar_periodos_con_detalles($producto);
		$data['lista_periodos'] = $periodo;
		//print_r($periodo);exit;
		$meses = array();
		$cantidad_mes = array();
		foreach($periodo as $value){
			$meses[] = $this->detalledemanda_model->obtener_detalle_demanda($value->PERI_Codigo,$value->DEMA_Codigo);
			$cantidad_mes[] = $this->detalledemanda_model->obtener_detalle_demanda($value->PERI_Codigo,$value->DEMA_Codigo);
		}
		//print_r($meses);exit;
		$data['lista_meses'] = $meses;
		$data['lista_cantidad'] = $cantidad_mes;
		$data['titulo'] = "LISTA DE DEMANDAS GRABADAS";
		$producto = $this->producto_model->obtener_producto($producto);
		$array_producto = array('codigo'=>$producto[0]->PROD_CodigoInterno,'descripcion'=>$producto[0]->PROD_Descripcion);
		$data['producto'] = $array_producto;
		$this->load->view('maestros/carga_masiva_grabados_pop',$data);
	}public function ver_registros($producto){
		if(!$this->session->userdata('user')){
            redirect('index/index');
        }
		$periodo = $this->periodo_model->listar_periodos_con_detalles($producto);
		$data['lista_periodos'] = $periodo;
		//print_r($periodo);exit;
		$meses = array();
		$cantidad_mes = array();
		foreach($periodo as $value){
			$meses[] = $this->detalledemanda_model->obtener_detalle_demanda($value->PERI_Codigo,$value->DEMA_Codigo);
			$cantidad_mes[] = $this->detalledemanda_model->obtener_detalle_demanda($value->PERI_Codigo,$value->DEMA_Codigo);
		}
		//print_r($meses);exit;
		$data['lista_meses'] = $meses;
		$data['lista_cantidad'] = $cantidad_mes;
		$data['titulo'] = "LISTA DE DEMANDAS GRABADAS";
		$producto = $this->producto_model->obtener_producto($producto);
		$array_producto = array('codigo'=>$producto[0]->PROD_CodigoInterno,'descripcion'=>$producto[0]->PROD_Descripcion);
		$data['producto'] = $array_producto;
		$this->load->view('maestros/carga_masiva_grabados_pop',$data);
	}*/
	
        public function subir_archivos() {
            if ( ! $this->session->userdata('user') )
                redirect( 'index/index' );
            
            if ( $_POST ) {
                $nombre_archivo = $_FILES['demanda']['name'];
                $origen         = $_FILES['demanda']['tmp_name'];
                // $origen[0] => demanda
                // $origen[1] => inventario
                // $origen[2] => ordenes
                // $origen[3] => sku
                foreach( $origen as $key=>$value ) {
                    $flag = $key;
                    switch( $key ) {
                        case 0  :   if ( $value!=NULL && $nombre_archivo[$key]!=NULL )
                                        $this->cargar_demanda( $value, $nombre_archivo[$key], $flag);
                                    break;
                        case 1  :   if ( $value!=NULL && $nombre_archivo[$key]!=NULL )
                                        $this->cargar_inventario( $value, $nombre_archivo[$key], $flag );
                                    break;
                        case 2  :   if ( $value!=NULL && $nombre_archivo[$key]!=NULL )
                                        $this->cargar_ordenes( $value, $nombre_archivo[$key], $flag);
                                    break;
                        case 3  :   if ( $value!=NULL && $nombre_archivo[$key]!=NULL )
                                        $this->cargar_sku( $value, $nombre_archivo[$key], $flag );
                                    break;
                    }
                }
                echo "<script type='text/javascript'>
                        window.location = '" . base_url() . "maestros/carga_masiva/cargar_archivos'
                      </script>";
		}
	}
	
        
	/***********************************************************************
	************************* METODOS DE CARGA *****************************
	***********************************************************************/
        
        private function cargar_demanda( $origen, $nombre_archivo, $flag ) {
            if ( ! $this->session->userdata('user') )
                redirect( 'index/index' );
            
            $RutaArchivoCargado = $origen;
            $data               = new Spreadsheet_Excel_Reader();
            
            $data->setUTFEncoder( 'mb' );
            $data->setOutputEncoding( 'UTF-8' );
            
            $data->read( $RutaArchivoCargado );
            error_reporting( E_ALL ^ E_NOTICE );
            
            // variable para saber si en alguna fila del excel hubo algun error,
            // campos vacios, codigos no encontrados, etc
            $error                  = true;
            $ultimo_registro        = 0;
            $cod_producto           = 0;
            $cod_establecimiento    = 0;
            $cod_periodo            = 0;
            $periodo                = 0;
            $esdemanda              = true;
            $m1 = $m2 = $m3 = $m4 = $m5 = $m6 = $m7 = $m8 = $m9 = $m10 = $m11 = $m12 = 0;

		
            /******************************************************************/
            /********************** CARGA DEMANDA MTS *************************/
            /******************************************************************/
            
            // elimino los errores DE ESE DIA Y DE ESA CARGA
            $this->tablalog_model->eliminar_log( $flag );
            // elimino todas las demandas y sus detalles de estado CERO
            $this->demanda_model->eliminar_demanda( 1 );
            
            for ( $fil=2; $fil<=$data->sheets[0]['numRows']; $fil++ ) {
                $valor = &$data->sheets[0]['cells'][$fil];
                // $valor[1] = TIPO DE ARCHIVO
                // $valor[2] = CODIGO SKU
                // $valor[3] = CODIGO DEL LOCAL, QUE PARA NOSTROS ES ESTABLECIMIENTO
                // $valor[4] = PERIODO AL QUE PERTENECE LA DEMANDA
                // $valor[5] = MES 1
                // $valor[6] = MES 2
                // ...
                // SIEMPRE CORRE 12 MESES
                
                /******************** VALIDACION DE PRODUCTO ******************/
                $cod_producto = $this->validar_producto( $valor[2], $nombre_archivo, $flag, $fil );
                echo 'prod ' . $cod_producto;
                
                /******************** VALIDACION DE UBICACION *****************/
                $cod_establecimiento = $this->validar_establecimiento($valor[3],$nombre_archivo,$flag,$fil);
                echo 'esta ' . $cod_establecimiento;
                
                /******************** VALIDACION DE PERIODO *******************/
                $cod_periodo = $this->validar_periodo( $valor[4], $nombre_archivo, $flag, $fil );
                echo 'periodo :' . $cod_periodo;
                
                /******************** VALIDACION DEL MES **********************/
                $data_mes = array( 'm1'=>$valor[5], 'm2'=>$valor[6], 'm3'=>$valor[7], 'm4'=>$valor[8],
				   'm5'=>$valor[9], 'm6'=>$valor[10], 'm7'=>$valor[11], 'm8'=>$valor[12],
				   'm9'=>$valor[13], 'm10'=>$valor[14], 'm11'=>$valor[15], 'm12'=>$valor[16] );
                
                $data_mes_nuevo = $this->validar_mes( $data_mes, $nombre_archivo, $flag, $fil );
                
                /********************* INSERCION DE DATOS *********************/
                if ( $cod_producto=='0' || $cod_establecimiento==0 || $cod_periodo==0 )
                    $error = false;
		elseif ( $cod_producto!='0' && $cod_establecimiento!=0 && $cod_periodo!=0 ) {
                    // inserta la demanda y su detalle
                    $filter                         = new stdClass();
                    $filter->fecha                  = $valor[4];
                    $filter->cod_periodo            = $cod_periodo;
                    $filter->cod_producto           = $cod_producto;
                    $filter->cod_establecimiento    = $cod_establecimiento;
                    $filter->cant_demanda           = $data_mes_nuevo;
                    $filter->tipo                   = 1;
                    $this->demanda_model->insertar_demanda( $filter );
                }
            }
            
            /********************* ACTUALIZACION DE DATOS *********************/
            // actualiza los datos de la demanda y su detalle de estado CERO a UNO
            if ( $error ) {
                //actualiza datos de estado CERO a UNO
                $this->demanda_model->actualizar_demanda( 1 );
            }
            
            
            /******************************************************************/
            /********************** CARGA DEMANDA MTO *************************/
            /******************************************************************/
            
            // elimino los errores DE ESE DIA Y DE ESA CARGA
            $this->tablalog_model->eliminar_log( $flag );
            //elimino todas las demandas y sus detalles de estado CERO
            $this->demanda_model->eliminar_demanda( 2 );
            
            $error2     = true;
            $cantidad   = 0;
            $fecha      = 0;
            
            for( $fil=2; $fil<=$data->sheets[1]['numRows']; $fil++ ) {
                
                $valor = &$data->sheets[1]['cells'][$fil];
                // $valor[1] = TIPO DE ARCHIVO
                // $valor[2] = CODIGO SKU
                // $valor[3] = CODIGO DEL LOCAL, QUE PARA NOSTROS ES ESTABLECIMIENTO
                // $valor[4] = PERIODO AL QUE PERTENECE LA DEMANDA
                // $valor[5] = MES 1
                // $valor[6] = MES 2
                
                /******************** VALIDACION DE PRODUCTO ******************/
                $cod_producto = $this->validar_producto( $valor[2], $nombre_archivo, $flag, $fil );
                
                /******************** VALIDACION DE UBICACION *****************/
                $cod_establecimiento = $this->validar_establecimiento( $valor[3], $nombre_archivo, $flag, $fil );
                
                /******************** VALIDACION DE CANTIDAD *******************/
                $cantidad = $this->convertir_entero( $valor[4] );
                if ( $cantidad == -1 ) {
                    $filter             = new StdClass();
                    $filter->archivo    = $nombre_archivo;
                    $filter->tabla      = 'DEMANDA';
                    $filter->flag       = $flag;
                    $filter->detalle    = 'El campo Cantidad debe ser ENTERO de la l&iacute;nea ' . $fil 
                                            . ' columna 4 del archivo ' . $nombre_archivo;
                    $this->tablalog_model->insertar_log( $filter );
                    $cantidad           = 0;
                }
                
                /******************** VALIDACION DE FECHA **********************/
                if ( $valor[5] == NULL ) {
                    $filter             = new StdClass();
                    $filter->archivo    = $nombre_archivo;
                    $filter->tabla      = 'ORDEN';
                    $filter->flag       = $flag;
                    $filter->detalle    = 'El campo Fecha esta vacio de la l&iacute;nea ' . $fil 
                                            . ' columna 4, hoja 2 del archivo ' . $nombre_archivo;
                    $this->tablalog_model->insertar_log( $filter );
                    $fecha              = 0 ;
                } else {
                    $fecha = $this->validar_fecha( $valor[5] );
                    if ( $fecha )
                        $fecha = $this->formato_fecha( $valor[5] );
                    else {
                        $filter             = new StdClass();
                        $filter->archivo    = $nombre_archivo;
                        $filter->tabla      = 'ORDEN';
                        $filter->flag       = $flag;
                        $filter->detalle    = 'El campo Fecha no existe de la l&iacute;nea ' . $fil 
                                                . ' columna 4, hoja 2 del archivo ' . $nombre_archivo;
                        $this->tablalog_model->insertar_log( $filter );
                        $fecha              = 0 ;
                    }
                }
                
                /********************* INSERCION DE DATOS *********************/
                if ( $cod_producto==0 || $cod_establecimiento==0 || $fecha==0 )
                    $error2 = false;
		elseif ( $cod_producto!=0 && $cod_establecimiento!=0 && $fecha!=0 ) {
                    //inserta la demanda y su detalle
                    $filter 	= new stdClass();
                    $filter->fecha 					= $fecha;
                    $filter->cod_producto 			= $cod_producto;
                    $filter->cod_establecimiento 	= $cod_establecimiento;
                    $filter->tipo		 			= 2;
                    $filter->cantidad	 			= $cantidad;
                    $this->demanda_model->insertar_demanda($filter);
                }
                
            }
            
            /********************* ACTUALIZACION DE DATOS *********************/
            // actualiza los datos de la demanda y su detalle de estado CERO a UNO
            if ( $error2 ) {
                // actualzia datos de estado CERO a UNO
                $this->demanda_model->actualizar_demanda( 2 );
            }
            
	}
	
	private function cargar_inventario( $origen, $nombre_archivo, $flag ) {
            $RutaArchivoCargado = $origen;
            $data = new Spreadsheet_Excel_Reader();
            
            $data->setUTFEncoder( 'mb' );
            $data->setOutputEncoding( 'UTF-8' );
            
            $data->read( $RutaArchivoCargado );
            error_reporting( E_ALL ^ E_NOTICE );
            $error                  = true;
            $cod_producto           = 0;
            $cod_establecimiento    = 0;
            $stock                  = 0;
            $fecha                  = 0;
            
            $esinventario           = true;
            for( $fil=2; $fil<=$data->sheets[0]['numRows']; $fil++ ) {
                $valor = &$data->sheets[0]['cells'][$fil];
                if ( $valor[1] != 'INVENTARIO' )
                    $esinventario = false;
            }
            
            if ( $esinventario ) {
                /******************** ELIMINACION DE DATOS ********************/
                // elimino los errores DE ESE DIA Y DE ESA CARGA
                $this->tablalog_model->eliminar_log( $flag );
                //elimino todas las demandas y sus detalles de estado CERO
                $this->inventario_model->eliminar_inventario();
                
                for( $fil=2; $fil<=$data->sheets[0]['numRows']; $fil++ ) {
                    
                    $valor = &$data->sheets[0]['cells'][$fil];
                    
                    /******************* VALIDACION DE PRODUCTO ***************/
                    $cod_producto = $this->validar_producto( $valor[2], $nombre_archivo, $flag, $fil );
                    
                    /******************* VALIDACION DE UBICACION **************/
                    $cod_establecimiento = $this->validar_establecimiento( $valor[3], $nombre_archivo, $flag, $fil );
                    
                    /******************* VALIDACION DEL SOTCK *****************/
                    $stock = $this->validar_stock_actual( $valor[4], $nombre_archivo, $flag, $fil );
                    
                    /******************* VALIDACION DE FECHA ******************/
                    if ( $valor[5] == NULL ) {
                        $filter             = new StdClass();
                        $filter->archivo    = $nombre_archivo;
                        $filter->tabla      = 'ORDEN';
                        $filter->flag       = $flag;
                        $filter->detalle    = 'El campo Fecha planificada de entrega esta vacio de la l&iacute;nea ' 
                                                . $fil.' columna 5 del archivo ' . $nombre_archivo;
                        $this->tablalog_model->insertar_log( $filter );
                        $fecha              = 0 ;
                    } else {
                        $fecha = $this->validar_fecha( $valor[5] );
                        if ( $fecha )
                            $fecha = $this->formato_fecha( $valor[5] );
			else {
                            $filter             = new StdClass();
                            $filter->archivo    = $nombre_archivo;
                            $filter->tabla      = 'ORDEN';
                            $filter->flag       = $flag;
                            $filter->detalle    = 'El campo Fecha planificada de entrega no existe de la l&iacute;nea ' 
                                                    . $fil . ' columna 5 del archivo ' . $nombre_archivo;
                            $this->tablalog_model->insertar_log( $filter );
                            $fecha              = 0 ;
                        }
                    }
				
                    /********************* INSERCION DE DATOS *****************/
                    if ( $cod_producto==0 || $cod_establecimiento==0 || $stock=='' )
                        $error = false;
                    elseif ( $cod_producto!=0 && $cod_establecimiento!=0 && $stock!='' ) {
                        $filter                         = new stdClass();
                        $filter->cod_producto           = $cod_producto;
                        $filter->cod_establecimiento    = $cod_establecimiento;
                        $filter->stock_actual           = $stock;
                        $filter->fecha                  = $fecha;
                        $this->inventario_model->insertar_inventario( $filter );
                    }
                    
                }
                
                /**********************ACTUALIZACION DE DATOS**********************/
                // actualiza los datos del inventario CERO a UNO
                if ( $error ) {
                    //actualzia datos de estado CERO a UNO
                    $this->inventario_model->actualizar_inventario();
                }
                
            } else {
                echo "NO ES INVENTARIO";
            }
            
        }
        
        private function cargar_ordenes( $origen, $nombre_archivo, $flag ) {
            $RutaArchivoCargado = $origen;
            $data               = new Spreadsheet_Excel_Reader();
            
            $data->setUTFEncoder( 'mb' );
            $data->setOutputEncoding( 'UTF-8' );
            
            $data->read( $RutaArchivoCargado );
            error_reporting( E_ALL ^ E_NOTICE );
            $cod_orden              = 0;
            $cod_producto           = 0;
            $cod_ubicacion          = 0;
            $can_planificada        = 0;
            $can_pendiente          = 0;
            $estado                 = 0;
            $fecha_entrega          = 0;
            $fecha_ini_fabricacion  = 0;
            $fecha_fin_fabricacion  = 0;
            $error                  = true;
            
            /********************** ELIMINACION DE DATOS **********************/
            // elimino los errores DE ESE DIA Y DE ESA CARGA
            $this->tablalog_model->eliminar_log( $flag );
            //elimino las ordenes que tiene estado CERO
            $this->orden_model->eliminar_orden( 1 );
            
            /******************************************************************/
            /******************* CARGA ORDENES DE FABRICACION *****************/
            /******************************************************************/
            for ( $fil=2; $fil<=$data->sheets[0]['numRows']; $fil++ ) {
                $valor = &$data->sheets[0]['cells'][$fil];
                
                /****************** VALIDACION DE NUMERO DE ORDEN *************/
                if ( $valor[1] == NULL ) {
                    $filter             = new StdClass();
                    $filter->archivo    = $nombre_archivo;
                    $filter->tabla      = 'ORDEN';
                    $filter->flag       = $flag;
                    $filter->detalle    = 'El campo Numero de Orden esta vacio de la l&iacute;nea ' 
                                            . $fil . ' columna 1 del archivo ' . $nombre_archivo;
                    $this->tablalog_model->insertar_log( $filter );
                } else
                    $cod_orden = $valor[1];
                
                /******************** VALIDACION DE PRODUCTO ******************/
                $cod_producto = $this->validar_producto( $valor[2], $nombre_archivo, $flag, $fil );
                
                /******************** VALIDACION DE TALLER ********************/
                $cod_ubicacion = $this->validar_establecimiento( $valor[3], $nombre_archivo, $flag, $fil );
                
                /******************** VALIDACION DE CANT PLANIFICADA **********/
                if ( $valor[4] == NULL ) {
                    $filter             = new StdClass();
                    $filter->archivo    = $nombre_archivo;
                    $filter->tabla      = 'ORDEN';
                    $filter->flag       = $flag;
                    $filter->detalle    = 'El campo Cantidad Planificada esta vacio de la l&iacute;nea ' 
                                            . $fil . ' columna 4 del archivo ' . $nombre_archivo;
                    $this->tablalog_model->insertar_log( $filter );
                } else
                    $can_planificada = $valor[4];
                
                /******************* VALIDACION DE CANT PENDIENTE *************/
                if ( $valor[5] == NULL ) {
                    $filter             = new StdClass();
                    $filter->archivo    = $nombre_archivo;
                    $filter->tabla      = 'ORDEN';
                    $filter->flag       = $flag;
                    $filter->detalle    = 'El campo Cantidad Pendiente esta vacio de la l&iacute;nea ' 
                                            . $fil . ' columna 5 del archivo ' . $nombre_archivo;
                    $this->tablalog_model->insertar_log( $filter );
                } else
                    $can_pendiente = $valor[5];
		
                /******************** VALIDACION DEL ESTATUS ******************/
                // PENDIENTE VALIDAR ESTATUS
                if ( $valor[6] == NULL ) {
                    $filter             = new StdClass();
                    $filter->archivo    = $nombre_archivo;
                    $filter->tabla      = 'ORDEN';
                    $filter->flag       = $flag;
                    $filter->detalle    = 'El campo Estatus esta vacio de la l&iacute;nea '
                                            . $fil . ' columna 6 del archivo ' . $nombre_archivo;
                    $this->tablalog_model->insertar_log( $filter );
                    $estado             = 0;
                } else {
                    $estado = $this->convertir_entero( $valor[6] );
                    if ( $estado == -1 ) {
                        $filter             = new StdClass();
                        $filter->archivo    = $nombre_archivo;
                        $filter->tabla      = 'ORDEN';
                        $filter->flag       = $flag;
                        $filter->detalle    = 'El codigo del Estatus debe ser entero de la l&iacute;nea '
                                                . $fil . ' columna 6 del archivo ' . $nombre_archivo;
                        $this->tablalog_model->insertar_log( $filter );
                        $estado             = 0;
                    } else {
                        if ( $estado!=1 && $estado!=2 )
                            $estado = 0;
                    }
                }
                
                /************ VALIDACION DE FECHA PLANIFICADA DE ENTREGA ******/
                if ( $valor[7] == NULL ) {
                    $filter             = new StdClass();
                    $filter->archivo    = $nombre_archivo;
                    $filter->tabla      = 'ORDEN';
                    $filter->flag       = $flag;
                    $filter->detalle    = 'El campo Fecha planificada de entrega esta vacio de la l&iacute;nea '
                                            . $fil . ' columna 7 del archivo ' . $nombre_archivo;
                    $this->tablalog_model->insertar_log( $filter );
                    $fecha_entrega      = 0 ;
                } else {
                    $fecha_entrega = $this->validar_fecha( $valor[7] );
                    if ( $fecha_entrega )
                        $fecha_entrega = $this->formato_fecha( $valor[7] );
                    else {
                        $filter             = new StdClass();
                        $filter->archivo    = $nombre_archivo;
                        $filter->tabla      = 'ORDEN';
                        $filter->flag       = $flag;
                        $filter->detalle    = 'El campo Fecha planificada de entrega no existe de la l&iacute;nea '
                                                . $fil . ' columna 7 del archivo ' . $nombre_archivo;
                        $this->tablalog_model->insertar_log( $filter );
                        $fecha_entrega      = 0 ;
                    }
                }
                
                /********** VALIDACION DE FECHA DE INICIO DE FABRICACION ******/
                if ( $valor[8] == NULL ) {
                    $filter                 = new StdClass();
                    $filter->archivo        = $nombre_archivo;
                    $filter->tabla          = 'ORDEN';
                    $filter->flag           = $flag;
                    $filter->detalle        = 'El campo Fecha de inicio de fabricacion esta vacio de la l&iacute;nea '
                                                . $fil . ' columna 8 del archivo ' . $nombre_archivo;
                    $this->tablalog_model->insertar_log( $filter );
                    $fecha_ini_fabricacion  = 0 ;
                } else {
                    $fecha_ini_fabricacion = $this->validar_fecha( $valor[8] );
                    if ( $fecha_ini_fabricacion )
                        $fecha_ini_fabricacion = $this->formato_fecha( $valor[8] );
                    else {
                        $filter                 = new StdClass();
                        $filter->archivo        = $nombre_archivo;
                        $filter->tabla          = 'ORDEN';
                        $filter->flag           = $flag;
                        $filter->detalle        = 'El campo Fecha de inicio de fabricacion no existe de la l&iacute;nea '
                                                    . $fil . ' columna 8 del archivo ' . $nombre_archivo;
                        $this->tablalog_model->insertar_log( $filter );
                        $fecha_ini_fabricacion  = 0 ;
                    }
                }
                
                /************* VALIDACION DE FECHA FINAL DE ENTREGA ***********/
                if ( $valor[9] == NULL ) {
                    $filter                 = new StdClass();
                    $filter->archivo        = $nombre_archivo;
                    $filter->tabla          = 'ORDEN';
                    $filter->flag           = $flag;
                    $filter->detalle        = 'El campo Fecha final de entrega esta vacio de la l&iacute;nea '
                                                . $fil . ' columna 9 del archivo ' . $nombre_archivo;
                    $this->tablalog_model->insertar_log( $filter );
                    $fecha_fin_fabricacion  = 0 ;
                } else {
                    $fecha_fin_fabricacion = $this->validar_fecha( $valor[9] );
                    if ( $fecha_fin_fabricacion )
                        $fecha_fin_fabricacion = $this->formato_fecha( $valor[9] );
                    else {
                        $filter                 = new StdClass();
                        $filter->archivo        = $nombre_archivo;
                        $filter->tabla          = 'ORDEN';
                        $filter->flag           = $flag;
                        $filter->detalle        = 'El campo Fecha final de entrega no existe de la l&iacute;nea '
                                                    . $fil . ' columna 9 del archivo ' . $nombre_archivo;
                        $this->tablalog_model->insertar_log( $filter );
                        $fecha_fin_fabricacion  = 0 ;
                    }
                }
                
                /**********************INSERCION DE DATOS**********************/
                if ( $cod_orden==0 || $cod_producto==0 || $cod_ubicacion==0 || $estado==0 || $fecha_entrega==0 
                        || $fecha_ini_fabricacion==0 || $fecha_fin_fabricacion==0 )
                    $error = false;
		elseif ( $cod_orden!=0 && $cod_producto!=0 && $cod_ubicacion!=0 && $estado!=0 
                            && $fecha_entrega!=0 && $fecha_ini_fabricacion!=0 && $fecha_fin_fabricacion!=0 ) {
                    $filter                     = new stdClass();
                    $filter->numero             = $cod_orden;
                    $filter->tipo               = 1;
                    $filter->cod_producto       = $cod_producto;
                    $filter->cod_ubicacion      = $cod_ubicacion;
                    $filter->cant_plani         = $can_planificada;
                    $filter->cant_pendi         = $can_pendiente;
                    $filter->estado             = $estado;
                    $filter->fech_plani_ent     = $fecha_entrega;
                    $filter->fech_ini_fabri     = $fecha_ini_fabricacion;
                    $filter->fech_fin_entre     = $fecha_fin_fabricacion;
                    $this->orden_model->insertar_orden( $filter );
                }
                
            } // fin del for
            
            /********************* ACTUALIZACION DE DATOS *********************/
            //actualiza los datos de la ORDEN DE FABRICACION CERO a UNO
            if ( $error ) {
                //actualzia datos de estado CERO a UNO
                $this->orden_model->actualizar_orden( 1 );
            }
            
            /******************************************************************/
            /******************** CARGA ORDENES DE FABRICACION ****************/
            /******************************************************************/
            
            /******************************************************************/
            /********************* CARGA ORDENES DE COMPRA ********************/
            /******************************************************************/
            $cod_proveedor      = 0;
            $fech_colocacion    = 0;
            $error2             = true;
            
            /********************** ELIMINACION DE DATOS **********************/
            // elimino las ordenes que tiene estado CERO
            $this->orden_model->eliminar_orden( 2 );
            
            for( $fil=2; $fil<=$data->sheets[1]['numRows']; $fil++ ) {
                
                $valor = &$data->sheets[1]['cells'][$fil];
                
                /************* VALIDACION DE NUMERO DE ORDEN ******************/
                if ( $valor[1] == NULL ) {
                    $filter             = new StdClass();
                    $filter->archivo    = $nombre_archivo;
                    $filter->tabla      = 'ORDEN';
                    $filter->flag       = $flag;
                    $filter->detalle    = 'El campo NUmero de Orden esta vacio de la l&iacute;nea '
                                            . $fil . ' columna 1, hoja 2 del archivo ' . $nombre_archivo;
                    $this->tablalog_model->insertar_log( $filter );
                } else
                    $cod_orden = $valor[1];
                
                /**************** VALIDACION DE PRODUCTO **********************/
                $cod_producto = $this->validar_producto( $valor[2], $nombre_archivo, $flag, $fil );
			
                /***************** VALIDACION DE TALLER ***********************/
                // PENDIENTE VALIDACION DE PROVEEDOR
                $cod_proveedor = $this->validar_establecimiento( $valor[3], $nombre_archivo, $flag, $fil );
                
                /***************** VALIDACION DE CANT PLANIFICADA *************/
                if ( $valor[4] == NULL ) {
                    $filter             = new StdClass();
                    $filter->archivo    = $nombre_archivo;
                    $filter->tabla      = 'ORDEN';
                    $filter->flag       = $flag;
                    $filter->detalle	= 'El campo Cantidad Planificada esta vacio de la l&iacute;nea '
                                            . $fil . ' columna 4, hoja 2 del archivo ' . $nombre_archivo;
                    $this->tablalog_model->insertar_log( $filter );
                } else
                    $can_planificada = $valor[4];
                
                /****************** VALIDACION DE CANT PENDIENTE **************/
                if ( $valor[5] == NULL ) {
                    $filter             = new StdClass();
                    $filter->archivo    = $nombre_archivo;
                    $filter->tabla      = 'ORDEN';
                    $filter->flag       = $flag;
                    $filter->detalle    = 'El campo Cantidad Pendiente esta vacio de la l&iacute;nea '
                                            . $fil . ' columna 5, hoja 2 del archivo ' . $nombre_archivo;
                    $this->tablalog_model->insertar_log( $filter );
                } else
                    $can_pendiente = $valor[5];
                
                /******************* VALIDACION DE ESTATUS ********************/
                // PENDIENTE VALIDAR ESTATUS
                if ( $valor[6] == NULL ) {
                    $filter             = new StdClass();
                    $filter->archivo    = $nombre_archivo;
                    $filter->tabla      = 'ORDEN';
                    $filter->flag       = $flag;
                    $filter->detalle    = 'El campo Estatus esta vacio de la l&iacute;nea '
                                            . $fil . ' columna 6, hoja 2 del archivo ' . $nombre_archivo;
                    $this->tablalog_model->insertar_log( $filter );
                    $estado             = 0;
                } else {
                    $estado = $this->convertir_entero( $valor[6] );
                    if ( $estado == -1 ) {
                        $filter             = new StdClass();
                        $filter->archivo    = $nombre_archivo;
                        $filter->tabla      = 'ORDEN';
                        $filter->flag       = $flag;
                        $filter->detalle    = 'El codigo del Estatus debe ser entero de la l&iacute;nea '
                                                . $fil . ' columna 6, hoja 2 del archivo ' . $nombre_archivo;
                        $this->tablalog_model->insertar_log( $filter );
                        $estado             = 0;
                    } else {
                        if ( $estado!=1 && $estado!=2 )
                            $estado = 0;
                    }
                }
                
                /*********** VALIDACION DE FECHA PLANIFICADA DE ENTREGA *******/
                if ( $valor[7] == NULL ) {
                    $filter             = new StdClass();
                    $filter->archivo    = $nombre_archivo;
                    $filter->tabla      = 'ORDEN';
                    $filter->flag       = $flag;
                    $filter->detalle    = 'El campo Fecha planificada de entrega esta vacio de la l&iacute;nea '
                                            . $fil . ' columna 7, hoja 2 del archivo ' . $nombre_archivo;
                    $this->tablalog_model->insertar_log( $filter );
                    $fecha_entrega      = 0 ;
                } else {
                    $fecha_entrega = $this->validar_fecha( $valor[7] );
                    if ( $fecha_entrega )
                        $fecha_entrega = $this->formato_fecha( $valor[7] );
                    else {
                        $filter             = new StdClass();
                        $filter->archivo    = $nombre_archivo;
                        $filter->tabla      = 'ORDEN';
                        $filter->flag       = $flag;
                        $filter->detalle    = 'El campo Fecha planificada de entrega no existe de la l&iacute;nea '
                                                . $fil . ' columna 7, hoja 2 del archivo ' . $nombre_archivo;
                        $this->tablalog_model->insertar_log( $filter );
                        $fecha_entrega      = 0 ;
                    }
                }
			
                /*********** VALIDACION DE FECHA DE INICIO DE FABRICACION *****/
                if ( $valor[8] == NULL ) {
                    $filter             = new StdClass();
                    $filter->archivo    = $nombre_archivo;
                    $filter->tabla      = 'ORDEN';
                    $filter->flag       = $flag;
                    $filter->detalle    = 'El campo Fecha de inicio de fabricacion esta vacio de la l&iacute;nea '
                                            . $fil . ' columna 8, hoja 2 del archivo ' . $nombre_archivo;
                    $this->tablalog_model->insertar_log( $filter );
                    $fech_colocacion    = 0 ;
                } else {
                    $fech_colocacion = $this->validar_fecha( $valor[8] );
                    if ( $fech_colocacion )
                        $fech_colocacion = $this->formato_fecha( $valor[8] );
                    else {
                        $filter             = new StdClass();
                        $filter->archivo    = $nombre_archivo;
                        $filter->tabla      = 'ORDEN';
                        $filter->flag       = $flag;
                        $filter->detalle    = 'El campo Fecha de inicio de fabricacion no existe de la l&iacute;nea '
                                                . $fil . ' columna 8, hoja 2 del archivo ' . $nombre_archivo;
                        $this->tablalog_model->insertar_log( $filter );
                        $fech_colocacion    = 0 ;
                    }
                }
			
                /************** VALIDACION DE FECHA FINAL DE ENTREGA **********/
                if ( $valor[9] == NULL ) {
                    $filter                 = new StdClass();
                    $filter->archivo        = $nombre_archivo;
                    $filter->tabla          = 'ORDEN';
                    $filter->flag           = $flag;
                    $filter->detalle        = 'El campo Fecha final de entrega esta vacio de la l&iacute;nea '
                                                . $fil . ' columna 9, hoja 2 del archivo ' . $nombre_archivo;
                    $this->tablalog_model->insertar_log( $filter );
                    $fecha_fin_fabricacion  = 0 ;
                } else {
                    $fecha_fin_fabricacion = $this->validar_fecha( $valor[9] );
                    if ( $fecha_fin_fabricacion )
                        $fecha_fin_fabricacion = $this->formato_fecha( $valor[9] );
                    else {
                        $filter                 = new StdClass();
                        $filter->archivo        = $nombre_archivo;
                        $filter->tabla          = 'ORDEN';
                        $filter->flag           = $flag;
                        $filter->detalle        = 'El campo Fecha final de entrega no existe de la l&iacute;nea '
                                                    . $fil . ' columna 9, hoja 2 del archivo ' . $nombre_archivo;
                        $this->tablalog_model->insertar_log( $filter );
                        $fecha_fin_fabricacion  = 0 ;
                    }
                }
                
                /**********************INSERCION DE DATOS**********************/
                if( $cod_orden==0 || $cod_producto==0 || $cod_proveedor==0 || $estado==0 || $fecha_entrega==0 
                        || $fech_colocacion==0 || $fecha_fin_fabricacion==0 )
                    $error2 = false;
                elseif ( $cod_orden!=0 && $cod_producto!=0 && $cod_proveedor!=0 && $estado!=0 
                        && $fecha_entrega!=0 && $fech_colocacion!=0 && $fecha_fin_fabricacion!=0 ) {
                    $filter                     = new stdClass();
                    $filter->numero             = $cod_orden;
                    $filter->tipo               = 2;
                    $filter->cod_producto       = $cod_producto;
                    $filter->cod_proveedor      = $cod_proveedor;
                    $filter->cant_plani         = $can_planificada;
                    $filter->cant_pendi         = $can_pendiente;
                    $filter->estado             = $estado;
                    $filter->fech_plani_ent     = $fecha_entrega;
                    $filter->fech_colocacion    = $fech_colocacion;
                    $filter->fech_fin_entre	= $fecha_fin_fabricacion;
                    $this->orden_model->insertar_orden( $filter );
                }
                
            }
            
            /**********************ACTUALIZACION DE DATOS**********************/
            // actualiza los datos de la ORDEN DE COMPRA CERO a UNO
            if ( $error ) {
                //actualzia datos de estado CERO a UNO
                $this->orden_model->actualizar_orden( 2 );
            }
            
        }
        
        private function cargar_sku( $origen, $nombre_archivo, $flag ) {
            if ( ! $this->session->userdata('user') )
                redirect( 'index/index' );
            
            $RutaArchivoCargado     = $origen;
            $data                   = new Spreadsheet_Excel_Reader();
            
            $data->setUTFEncoder( 'mb' );
            $data->setOutputEncoding( 'UTF-8' );
            
            $data->read( $RutaArchivoCargado );
            error_reporting( E_ALL ^ E_NOTICE );
            
            $cod_proucto            = 0;
            $descripcion            = 0;
            $cod_familia            = 0;
            $tipo_producto          = 0;
            $tipo_planificacion     = 0;
            $dias_zona_congelada    = 0;
            $dias_zona_pm           = 0;
            $regla_panificacion     = 0;
            $lote_economico         = 0;
            $pto_reorden            = 0;
            $stock_seguridad        = 0;
            $cant_minima            = 0;
            $cant_maxima            = 0;
            $cant_multiplo          = 0;
            $cant_fija              = 0;
            $stock_maximo           = 0;
            $cant_prod_diaria       = 0;
            $stock_actual           = 0;
            $pcosto                 = 0;
            $pventa                 = 0;
            
            $error_sku = false;
            
            for( $fil=2; $fil<=$data->sheets[0]['numRows']; $fil++ ) {
                
                $valor = &$data->sheets[0]['cells'][$fil];
                
                /********************* VALIDACION DE PRODUCTO *****************/
                if ( $valor[1] == NULL ) {
                    $filter             = new StdClass();
                    $filter->archivo    = $nombre_archivo;
                    $filter->tabla      = 'PRODUCTOS';
                    $filter->flag       = $flag;
                    $filter->detalle    = 'El campo Codigo de Producto esta vacio de la l&iacute;nea '
                                            . $fil . ' columna 1 del archivo ' . $nombre_archivo;
                    $this->tablalog_model->insertar_log( $filter );
                    $cod_proucto        = 0 ;
                } else
                    $cod_proucto        = $valor[1];
                
                /******************** VALIDACION DE DESCRIPCION ***************/
                $descripcion = $valor[2];
                
                /******************** VALIDACION DE FAMILIA *******************/
                $cod_familia = $this->validar_familia( $valor[3], $nombre_archivo, $flag, $fil );
                
                /*************** VALIDACION DE TIPO DE PRODUCTO ***************/
                if ( $valor[4] == NULL ) {
                    $filter             = new StdClass();
                    $filter->archivo    = $nombre_archivo;
                    $filter->tabla      = 'PRODUCTOS';
                    $filter->flag       = $flag;
                    $filter->detalle    = 'El campo Tipo de Producto esta vacio de la l&iacute;nea '
                                            . $fil . ' columna 4 del archivo ' . $nombre_archivo;
                    $this->tablalog_model->insertar_log( $filter );
                    $tipo_producto      = 0 ;
                } else {
                    if ( $valor[4]!=1 && $valor[4]!=2 )
                        $tipo_producto = 0 ;
                    else
                        $tipo_producto = $valor[4];
                }
                
                /*************** VALIDACION DE TIPO DE PLANIFICAION ***********/
                if ( $valor[5] == NULL ) {
                    $filter             = new StdClass();
                    $filter->archivo    = $nombre_archivo;
                    $filter->tabla      = 'PRODUCTOS';
                    $filter->flag       = $flag;
                    $filter->detalle    = 'El campo Tipo de Planificacion esta vacio de la l&iacute;nea '
                                            . $fil . ' columna 5 del archivo ' . $nombre_archivo;
                    $this->tablalog_model->insertar_log( $filter );
                    $tipo_planificacion = 0 ;
                } else {
                    if ( $valor[5] != 1 && $valor[5] != 2 )
                        $tipo_planificacion = 0 ;
                    else
                        $tipo_planificacion = $valor[5];
                }
                
                /*********** VALIDACION DE DIAS PARA LA ZONA CONGELADA ********/
                if ( $valor[6] == NULL ) {
                    $filter                 = new StdClass();
                    $filter->archivo        = $nombre_archivo;
                    $filter->tabla          = 'PRODUCTOS';
                    $filter->flag           = $flag;
                    $filter->detalle        = 'El campo D&iacute;s para la zona congelada esta vacio de la l&iacute;nea '
                                                . $fil . ' columna 6 del archivo ' . $nombre_archivo;
                    $this->tablalog_model->insertar_log( $filter );
                    $dias_zona_congelada    = 0 ;
                } else {
                    $dias_zona_congelada = $this->convertir_entero( $valor[6] );
                    if ( $dias_zona_congelada == -1 ) {
                        $filter                 = new StdClass();
                        $filter->archivo        = $nombre_archivo;
                        $filter->tabla          = 'ORDEN';
                        $filter->flag           = $flag;
                        $filter->detalle        = 'El campo D&iacute;s para la zona congelada debe ser entero de la l&iacute;nea '
                                                    . $fil . ' columna 6 del archivo ' . $nombre_archivo;
                        $this->tablalog_model->insertar_log( $filter );
                        $dias_zona_congelada    = 0;
                    }
                }
                
                /***** VALIDACION DE DIAS PARA LA ZONA PROGRAMACION MAESTRA****/
                if ( $valor[7] == NULL ) {
                    $filter             = new StdClass();
                    $filter->archivo    = $nombre_archivo;
                    $filter->tabla      = 'PRODUCTOS';
                    $filter->flag       = $flag;
                    $filter->detalle    = 'El campo D&iacute;s para la zona de programacion maestra esta vacio de la l&iacute;nea '
                                            . $fil . ' columna 7 del archivo ' . $nombre_archivo;
                    $this->tablalog_model->insertar_log( $filter );
                    $dias_zona_pm       = 0 ;
                } else {
                    $dias_zona_pm = $this->convertir_entero( $valor[7] );
                    if ( $dias_zona_pm == -1 ) {
                        $filter             = new StdClass();
                        $filter->archivo    = $nombre_archivo;
                        $filter->tabla      = 'ORDEN';
                        $filter->flag       = $flag;
                        $filter->detalle    = 'El campo D&iacute;s para la zona programacion maestra debe ser entero de la l&iacute;nea '
                                                . $fil . ' columna 7 del archivo ' . $nombre_archivo;
                        $this->tablalog_model->insertar_log( $filter );
                        $dias_zona_pm       = 0;
                    }
                }
                
                /************* VALIDACION DE REGLA DE PLANIFICACION ***********/
                if ( $tipo_planificacion == '1' ) {
                    if ( $valor[8] == NULL ) {
                        $filter             = new StdClass();
                        $filter->archivo    = $nombre_archivo;
                        $filter->tabla      = 'PRODUCTOS';
                        $filter->flag       = $flag;
                        $filter->detalle    = 'El campo regla de planificacion esta vacio de la l&iacute;nea '
                                                . $fil . ' columna 8 del archivo ' . $nombre_archivo;
                        $this->tablalog_model->insertar_log( $filter );
                        $regla_panificacion = 0 ;
                    } else {
                        $regla_panificacion = $this->convertir_entero( $valor[8] );
                        if ( $regla_panificacion == -1 ) {
                            $filter             = new StdClass();
                            $filter->archivo    = $nombre_archivo;
                            $filter->tabla      = 'ORDEN';
                            $filter->flag       = $flag;
                            $filter->detalle    = 'El campo tipo de planificacion debe ser entero de la l&iacute;nea '
                                                    . $fil . ' columna 8 del archivo ' . $nombre_archivo;
                            $this->tablalog_model->insertar_log( $filter );
                            $regla_panificacion = 0;
                        }
                    }
                }
                
                /************* VALIDACION DE DIAS PARA LOTE ECONOMICO *********/
                if ( $valor[9] == NULL ) {
                    $filter             = new StdClass();
                    $filter->archivo    = $nombre_archivo;
                    $filter->tabla      = 'PRODUCTOS';
                    $filter->flag       = $flag;
                    $filter->detalle    = 'El campo lote econ&oacute;mico esta vacio de la l&iacute;nea '
                                            . $fil . ' columna 8 del archivo ' . $nombre_archivo;
                    $this->tablalog_model->insertar_log( $filter );
                    $lote_economico     = 0 ;
                } else {
                    $lote_economico = $this->convertir_entero( $valor[9] );
                    if ( $lote_economico == -1 ) {
                        $filter             = new StdClass();
                        $filter->archivo    = $nombre_archivo;
                        $filter->tabla      = 'ORDEN';
                        $filter->flag       = $flag;
                        $filter->detalle    = 'El campo lote econ&oacute;mico debe ser entero de la l&iacute;nea '
                                                . $fil . ' columna 8 del archivo ' . $nombre_archivo;
                        $this->tablalog_model->insertar_log( $filter );
                        $lote_economico     = 0;
                    }
                }
                
                /************ VALIDACION DE DIAS PARA PUNTO DE REORDEN ********/
                if ( $tipo_planificacion == '2' ) {
                    if ( $valor[10] == NULL ) {
                        $filter                 = new StdClass();
                        $filter->archivo	= $nombre_archivo;
                        $filter->tabla		= 'PRODUCTOS';
                        $filter->flag		= $flag;
                        $filter->detalle	= 'El campo punto de reorden esta vacio de la l&iacute;nea '
                                                    . $fil . ' columna 9 del archivo ' . $nombre_archivo;
                        $this->tablalog_model->insertar_log( $filter );
                        $pto_reorden = 0 ;
                    } else {
                        $pto_reorden = $this->convertir_entero( $valor[10] );
                        if ( $pto_reorden == -1 ) {
                            $filter             = new StdClass();
                            $filter->archivo    = $nombre_archivo;
                            $filter->tabla      = 'ORDEN';
                            $filter->flag       = $flag;
                            $filter->detalle    = 'El campo punto de reorden debe ser entero de la l&iacute;nea ' 
                                                    . $fil. ' columna 9 del archivo ' . $nombre_archivo;
                            $this->tablalog_model->insertar_log( $filter );
                            $pto_reorden        = 0;
                        }
                    }
                }
			
                /************* VALIDACION DE STOCK DE SEGURIDAD ***************/
                if ( $valor[11] == NULL ) {
                    $filter             = new StdClass();
                    $filter->archivo    = $nombre_archivo;
                    $filter->tabla      = 'PRODUCTOS';
                    $filter->flag       = $flag;
                    $filter->detalle    = 'El campo stock de seguridad esta vacio de la l&iacute;nea '
                                            . $fil . ' columna 10 del archivo ' . $nombre_archivo;
                    $this->tablalog_model->insertar_log( $filter );
                    $stock_seguridad    = 0 ;
                } else {
                    $stock_seguridad    = $this->convertir_entero( $valor[11] );
                    if ( $stock_seguridad == -1 ) {
                        $filter             = new StdClass();
                        $filter->archivo    = $nombre_archivo;
                        $filter->tabla      = 'ORDEN';
                        $filter->flag       = $flag;
                        $filter->detalle    = 'El campo stock de seguridad debe ser entero de la l&iacute;nea '
                                                . $fil . ' columna 10 del archivo ' . $nombre_archivo;
                        $this->tablalog_model->insertar_log( $filter );
                        $stock_seguridad    = 0;
                    }
                }
                
                /*************** VALIDACION DE CANTIDAD MINIMA ****************/
                if ( $regla_panificacion == '1' || $regla_panificacion == '3' ) {
                    if ( $valor[12] == NULL ) {
                        $filter             = new StdClass();
                        $filter->archivo    = $nombre_archivo;
                        $filter->tabla      = 'PRODUCTOS';
                        $filter->flag       = $flag;
                        $filter->detalle    = 'El campo cantidad m&iacute;nima esta vacio de la l&iacute;nea '
                                                . $fil . ' columna 11 del archivo ' . $nombre_archivo;
                        $this->tablalog_model->insertar_log( $filter );
                        $cant_minima        = 0 ;
                    } else {
                        // $cant_minima = $this->convertir_entero( $valor[12] );
                        // if( $cant_minima == -1 ) {
                            // $filter 			= new StdClass();
                            // $filter->archivo	= $nombre_archivo;
                            // $filter->tabla		= "ORDEN";
                            // $filter->flag		= $flag;
                            // $filter->detalle	= "El campo cantidad m&iacute;nima debe ser entero de la l&iacute;nea ".$fil." columna 11 del archivo ".$nombre_archivo;
                            // $this->tablalog_model->insertar_log($filter);
                            // $cant_minima = 0;
                        // }
                        $cant_minima = $valor[12];
                    }
                } else
                    $cant_minima = 0 ;
                
                /*************** VALIDACION DE CANTIDAD MAXIMA ****************/
                if ( $regla_panificacion == '1' || $regla_panificacion == '3' ) {
                    if ( $valor[13] == NULL ) {
                        $filter             = new StdClass();
                        $filter->archivo    = $nombre_archivo;
                        $filter->tabla      = "PRODUCTOS";
                        $filter->flag       = $flag;
                        $filter->detalle    = "El campo cantidad m&aacute;xima esta vacio de la l&iacute;nea ".$fil." columna 11 del archivo ".$nombre_archivo;
                        $this->tablalog_model->insertar_log( $filter );
                        $cant_maxima        = 0 ;
                    } else {
                        // $cant_maxima = $this->convertir_entero($valor[13]);
                        // if($cant_maxima == -1){
                            // $filter 			= new StdClass();
                            // $filter->archivo	= $nombre_archivo;
                            // $filter->tabla		= "ORDEN";
                            // $filter->flag		= $flag;
                            // $filter->detalle	= "El campo cantidad m&aacute;xima debe ser entero de la l&iacute;nea ".$fil." columna 11 del archivo ".$nombre_archivo;
                            // $this->tablalog_model->insertar_log($filter);
                            // $cant_maxima = 0;
                        // }
                        $cant_maxima = $valor[13];
                    }
                } else
                    $cant_maxima = 0;
                
                /************* VALIDACION DE CANTIDAD MULTIPLO ****************/
		if ( $regla_panificacion == '3' ) {
                    if ( $valor[14] == NULL ) {
                        $filter             = new StdClass();
                        $filter->archivo    = $nombre_archivo;
                        $filter->tabla      = 'PRODUCTOS';
                        $filter->flag       = $flag;
                        $filter->detalle    = 'El campo cantidad multiplo esta vacio de la l&iacute;nea '
                                                . $fil . ' columna 12 del archivo ' . $nombre_archivo;
                        $this->tablalog_model->insertar_log( $filter );
                        $cant_multiplo      = 0 ;
                    } else {
                        // $cant_multiplo = $this->convertir_entero($valor[14]);
                        // if($cant_multiplo == -1){
                            // $filter 			= new StdClass();
                            // $filter->archivo	= $nombre_archivo;
                            // $filter->tabla		= "ORDEN";
                            // $filter->flag		= $flag;
                            // $filter->detalle	= "El campo cantidad multiplo debe ser entero de la l&iacute;nea ".$fil." columna 12 del archivo ".$nombre_archivo;
                            // $this->tablalog_model->insertar_log($filter);
                            // $cant_multiplo = 0;
                        // }
                        $cant_multiplo = $valor[14];
                    }
                } else
                    $cant_multiplo = 0;
                
                /**************** VALIDACION DE CANTIDAD FIJA *****************/
                if ( $regla_panificacion == '4' ) {
                    if ( $valor[15] == NULL ) {
                        $filter             = new StdClass();
                        $filter->archivo    = $nombre_archivo;
                        $filter->tabla      = "PRODUCTOS";
                        $filter->flag       = $flag;
                        $filter->detalle    = "El campo cantidad fija esta vacio de la l&iacute;nea ".$fil." columna 13 del archivo ".$nombre_archivo;
                        $this->tablalog_model->insertar_log($filter);
                        $cant_fija          = 0 ;
                    } else {
                        // $cant_fija = $this->convertir_entero($valor[15]);
                        // if($cant_fija == -1){
                            // $filter 			= new StdClass();
                            // $filter->archivo	= $nombre_archivo;
                            // $filter->tabla		= "ORDEN";
                            // $filter->flag		= $flag;
                            // $filter->detalle	= "El campo cantidad fija debe ser entero de la l&iacute;nea ".$fil." columna 13 del archivo ".$nombre_archivo;
                            // $this->tablalog_model->insertar_log($filter);
                            // $cant_fija = 0;
                        // }
                        $cant_fija = $valor[15];
                    }
                } else
                    $cant_fija = 0;
			
                /****************** VALIDACION DE STOCK MAXIMO ****************/
                if ( $valor[16] == NULL ) {
                    $filter             = new StdClass();
                    $filter->archivo    = $nombre_archivo;
                    $filter->tabla      = 'PRODUCTOS';
                    $filter->flag       = $flag;
                    $filter->detalle    = 'El campo stock maximo esta vacio de la l&iacute;nea '
                                            . $fil . ' columna 16 del archivo ' . $nombre_archivo;
                    $this->tablalog_model->insertar_log( $filter );
                    $stock_maximo       = 0 ;
                } else {
                    // $stock_maximo = $this->convertir_entero($valor[16]);
                    // if($stock_maximo == -1){
                        // $filter 			= new StdClass();
                        // $filter->archivo	= $nombre_archivo;
                        // $filter->tabla		= "ORDEN";
                        // $filter->flag		= $flag;
                        // $filter->detalle	= "El campo stock maximo debe ser entero de la l&iacute;nea ".$fil." columna 16 del archivo ".$nombre_archivo;
                        // $this->tablalog_model->insertar_log($filter);
                        // $stock_maximo = 0;
                    // }
                    $stock_maximo = $valor[16];
                }
                
                /************** VALIDACION DE PRODUCCION DIARIA ***************/
                if ( $valor[17] == NULL ) {
                    $filter             = new StdClass();
                    $filter->archivo    = $nombre_archivo;
                    $filter->tabla      = 'PRODUCTOS';
                    $filter->flag       = $flag;
                    $filter->detalle    = 'El campo produccion diaria esta vacio de la l&iacute;nea '
                                            . $fil . ' columna 14 del archivo ' . $nombre_archivo;
                    $this->tablalog_model->insertar_log( $filter );
                    $cant_prod_diaria   = 0 ;
                } else {
                    // $cant_prod_diaria = $this->convertir_entero($valor[17]);
                    // if($cant_prod_diaria == -1){
                        // $filter 			= new StdClass();
                        // $filter->archivo	= $nombre_archivo;
                        // $filter->tabla		= "ORDEN";
                        // $filter->flag		= $flag;
                        // $filter->detalle	= "El campo produccion diaria debe ser entero de la l&iacute;nea ".$fil." columna 14 del archivo ".$nombre_archivo;
                        // $this->tablalog_model->insertar_log($filter);
                        // $cant_prod_diaria = 0;
                    // }
                    $cant_prod_diaria = $valor[17];
                }
                
                /**************** VALIDACION DE STOCK ACTUAL ******************/
                if ( $valor[18] == NULL ) {
                    $filter             = new StdClass();
                    $filter->archivo    = $nombre_archivo;
                    $filter->tabla      = 'PRODUCTOS';
                    $filter->flag       = $flag;
                    $filter->detalle    = 'El campo sotck actual esta vacio de la l&iacute;nea '
                                            . $fil . ' columna 15 del archivo ' . $nombre_archivo;
                    $this->tablalog_model->insertar_log( $filter );
                    $stock_actual       = 0 ;
                } else {
                    // $stock_actual = $this->convertir_entero($valor[18]);
                    // if($stock_actual == -1){
                        // $filter 			= new StdClass();
                        // $filter->archivo	= $nombre_archivo;
                        // $filter->tabla		= "ORDEN";
                        // $filter->flag		= $flag;
                        // $filter->detalle	= "El campo sotck actual debe ser entero de la l&iacute;nea ".$fil." columna 15 del archivo ".$nombre_archivo;
                        // $this->tablalog_model->insertar_log($filter);
                        // $stock_actual = 0;
                    // }
                    $stock_actual = $valor[18];
                }
                
                /**************** VALIDACION DE PRECIO DE COSTO ***************/
                if ( $valor[19] == NULL ) {
                    $filter             = new StdClass();
                    $filter->archivo    = $nombre_archivo;
                    $filter->tabla      = 'PRODUCTOS';
                    $filter->flag       = $flag;
                    $filter->detalle    = 'El campo precio de costo esta vacio de la l&iacute;nea '
                                            . $fil . ' columna 16 del archivo ' . $nombre_archivo;
                    $this->tablalog_model->insertar_log( $filter );
                    $pcosto             = 0 ;
                } else {
                    // $pcosto = $this->convertir_entero($valor[19]);
                    // if($pcosto == -1){
                        // $filter 			= new StdClass();
                        // $filter->archivo	= $nombre_archivo;
                        // $filter->tabla		= "ORDEN";
                        // $filter->flag		= $flag;
                        // $filter->detalle	= "El campo sotck actual debe ser entero de la l&iacute;nea ".$fil." columna 16 del archivo ".$nombre_archivo;
                        // $this->tablalog_model->insertar_log($filter);
                        // $pcosto = 0;
                    // }
                    $pcosto = $valor[19];
                }
                
                /*************** VALIDACION DE PRECIO DE VENTA ****************/
                if ( $valor[20] == NULL ) {
                    $filter             = new StdClass();
                    $filter->archivo    = $nombre_archivo;
                    $filter->tabla      = 'PRODUCTOS';
                    $filter->flag       = $flag;
                    $filter->detalle    = 'El campo precio de venta esta vacio de la l&iacute;nea '
                                            . $fil . ' columna 17 del archivo ' . $nombre_archivo;
                    $this->tablalog_model->insertar_log( $filter );
                    $pventa             = 0 ;
                } else {
                    // $pventa = $this->convertir_entero($valor[20]);
                    // if($pventa == -1){
                        // $filter 			= new StdClass();
                        // $filter->archivo	= $nombre_archivo;
                        // $filter->tabla		= "ORDEN";
                        // $filter->flag		= $flag;
                        // $filter->detalle	= "El campo sotck actual debe ser entero de la l&iacute;nea ".$fil." columna 17 del archivo ".$nombre_archivo;
                        // $this->tablalog_model->insertar_log($filter);
                        // $pventa = 0;
                    // }
                    $pventa = $valor[20];
                }
			
                /****************** VALIDACION CANTIDADES **********************/
                /* PENDIENTE PENDIENTE PENDIENTE PENDIENTE PENDIENTE PENDIENTE */
                /****************** VALIDACION CANTIDADES **********************/
                
                /*********************** INSERCION DE DATOS *******************/
                if ( $cod_proucto != '' && $cod_familia != '' && $tipo_producto != 0 
                        && $tipo_planificacion != 0 && $dias_zona_congelada != 0 && $dias_zona_pm != 0 ) {
                    $filter                         = new stdClass();
                    $filter->PROD_CodigoInterno         = $cod_proucto;
                    $filter->PROD_Descripcion           = $descripcion;
                    $filter->PROD_TipoProducto          = $tipo_producto;
                    $filter->PROD_TipoPlanificacion     = $tipo_planificacion;
                    $filter->PROD_LoteEconomico         = $lote_economico;
                    $filter->PROD_DiasZonaCongelada     = $dias_zona_congelada;
                    $filter->PROD_DiasZonaProgMaestra   = $dias_zona_pm;
                    $filter->PROD_ReglaPlanificacion    = $regla_panificacion;
                    $filter->PROD_StockSeguridad        = $stock_seguridad;
                    $filter->PROD_CantidadMinima        = $cant_minima;
                    $filter->PROD_CantidadMaxima        = $cant_maxima;
                    $filter->PROD_CantidadMultiplo      = $cant_multiplo;
                    $filter->PROD_CantidadFija          = $cant_fija;
                    $filter->PROD_StockMaximo           = $stock_maximo;
                    $filter->PROD_CantidadProduccion    = $cant_prod_diaria;
                    $filter->PROD_PuntoReorden          = $pto_reorden;
                    $filter->PROD_StockActual           = $stock_actual;
                    $filter->PROD_PrecioCostro          = $pcosto;
                    $filter->PROD_PrecioVenta           = $pventa;
                    $filter->FAMI_Codigo                = $cod_familia;
                    $this->producto_model->insertar_producto( $filter );
                } else
                    $error_sku = true;
                
                /******************* ACTUALIZACION DE DATOS *******************/
                // cuando inserta los inserta con un ESTADO = 0, y si NO encontro un error actualiza en 1
                // if ( ! $error_sku ) {
                // }
            }
        }
        
        
        /***********************************************************************
        ************************ METODOS DE VALIDACION *************************
        ***********************************************************************/
        
        //metodo para validar el mes, como son 12 meses cree un metodo para no repetir codigo
        private function validar_mes( $data, $nombre_archivo, $flag, $fil ) {
            $data_mes_nuevo = array();
            $columna        = 4;
            foreach( $data as $key=>$value ) {
                if ( $value == NULL ) {
                    $filter             = new StdClass();
                    $filter->archivo    = $nombre_archivo;
                    $filter->tabla      = 'MES';
                    $filter->flag       = $flag;
                    $filter->detalle    = 'El campo MES esta vacio de la l&iacute;nea ' . $fil
                                            . ' columna $columna del archivo ' . $nombre_archivo;
                    $this->tablalog_model->insertar_log( $filter );
                    $value              = 0;
                    $data_mes_nuevo[]   = $value;
                } else {
                    //metodo para convertir a enteros (si no es entero, devuelve -1)
                    $value = $this->convertir_entero( $value );
                    if ( $value == -1 ) {
                        $filter             = new StdClass();
                        $filter->archivo    = $nombre_archivo;
                        $filter->tabla      = 'MES';
                        $filter->flag       = $flag;
                        $filter->detalle    = 'El campo MES no es ENTERO de la l&iacute;nea ' . $fil
                                                . ' columna $columna del archivo ' . $nombre_archivo;
                        $this->tablalog_model->insertar_log( $filter );
                        //cuando un mes esta VACIO, le pone CERO por defecto
                        $value              = 0;
                        $data_mes_nuevo[]   = $value;
                    } else {
                        //almacena todo los datos en otro arreglo
                        $data_mes_nuevo[] = $value;
                    }
                }
                $columna++;
            }
            return $data_mes_nuevo;
        }
        
        /******************** VALIDACION DEL CAMPO CODIGO SKU *****************/
        private function validar_producto( $cod_producto, $nombre_archivo, $flag, $fil ) {
            //valida si el campo codigo esta vacio
            if ( $cod_producto == NULL ) {
                $filter             = new StdClass();
                $filter->archivo    = $nombre_archivo;
                $filter->tabla      = 'DEMANDA';
                $filter->flag       = $flag;
                $filter->detalle    = 'El campo codigo de SKU esta vacio de la l&iacute;nea '
                                        . $fil . ' columna 1 del archivo ' . $nombre_archivo;
                $this->tablalog_model->insertar_log( $filter );
                $cod_producto       = '';
            } else {
                //metodo para convertir a enteros
                //$cod_producto = $this->convertir_entero($cod_producto);
                //si no es entero, devuelve -1
                // if($cod_producto == -1){
                    // $filter 			= new StdClass();
                    // $filter->archivo	= $nombre_archivo;
                    // $filter->tabla		= "DEMANDA";
                    // $filter->flag		= $flag;
                    // $filter->detalle	= "El codigo del producto debe ser entero de la l&iacute;nea ".$fil." columna 2 del archivo ".$nombre_archivo;
                    // $this->tablalog_model->insertar_log($filter);
                    // $cod_producto = 0;
                // }else{
                    //validar si el producto existe en la bd
                    $producto = $this->producto_model->obtener_producto_x_interno( $cod_producto );
                    if ( $producto == NULL ) {
                        $filter             = new StdClass();
                        $filter->archivo    = $nombre_archivo;
                        $filter->tabla      = 'DEMANDA';
                        $filter->flag       = $flag;
                        $filter->detalle    = 'Producto de codigo ' . $cod_producto 
                                                . ' no existe, error en la l&iacute;nea ' . $fil
                                                . ' columna 2 del archivo ' . $nombre_archivo;
                        $this->tablalog_model->insertar_log( $filter );
                        $cod_producto       = '';
                    } else {
                        $cod_producto = $producto[0]->PROD_Codigo;
                    }
                    // }
            }
            return $cod_producto;
        }
        
        /******************** VALIDACION DE LA UBICACION **********************/
        private function validar_establecimiento( $cod_establecimiento, $nombre_archivo, $flag, $fil ) {
            if ( $cod_establecimiento == NULL ) {   //valida si el campo local esta vacio
                $filter                 = new StdClass();
                $filter->archivo        = $nombre_archivo;
                $filter->tabla          = 'DEMANDA';
                $filter->flag           = $flag;
                $filter->detalle        = 'El campo codigo de LOCAL esta vacio de la l&iacute;nea ' 
                                            . $fil . ' columna 3 del archivo ' . $nombre_archivo;
                $this->tablalog_model->insertar_log( $filter );
                $cod_establecimiento    = 0;
            } else {
                //metodo para convertir a enteros
                $cod_establecimiento = $this->convertir_entero( $cod_establecimiento );
                //si no es entero, devuelve -1
                if ( $cod_establecimiento == -1 ) {
                    $filter                 = new StdClass();
                    $filter->archivo        = $nombre_archivo;
                    $filter->tabla          = 'DEMANDA';
                    $filter->flag           = $flag;
                    $filter->detalle        = 'El codigo del local debe ser entero de la l&iacute;nea ' 
                                                . $fil . ' columna 3 del archivo ' . $nombre_archivo;
                    $this->tablalog_model->insertar_log( $filter );
                    $cod_establecimiento    = 0;
                } else {
                    //validar si el establecimiento no existe en la bd
                    $establecimiento = $this->establecimiento_model->obtener_establecimiento( $cod_establecimiento );
                    if ( $establecimiento == NULL ) {
                        $filter 			= new StdClass();
                        $filter->archivo	= $nombre_archivo;
                        $filter->tabla		= "LOCALES";
                        $filter->flag		= $flag;
                        $filter->detalle	= "Local de codigo ".$cod_establecimiento." no existe, error en la l&iacute;nea ".$fil." columna 3 del archivo ".$nombre_archivo;
                        $this->tablalog_model->insertar_log($filter);
                        $cod_establecimiento    = 0;
                    } else {
                        $cod_establecimiento = $establecimiento[0]->ESTA_Codigo;
                    }
                }
            }
            return $cod_establecimiento;
        }
        
        private function validar_periodo( $cod_periodo, $nombre_archivo, $flag, $fil ) {
            if ( $cod_periodo == NULL ) {
                $filter             = new StdClass();
                $filter->archivo    = $nombre_archivo;
                $filter->tabla      = 'DEMANDA';
                $filter->flag       = $flag;
                $filter->detalle    = 'El campo Periodo esta vacio de la l&iacute;nea '
                                        . $fil . ' columna 4 del archivo ' . $nombre_archivo;
                $this->tablalog_model->insertar_log( $filter );
                $cod_periodo        = 0;
            } else {
                $periodo = $this->periodo_model->obtener_periodo( $cod_periodo );
                if ( $periodo == NULL ) {
                    $filter             = new StdClass();
                    $filter->archivo    = $nombre_archivo;
                    $filter->tabla      = 'LOCALES';
                    $filter->flag       = $flag;
                    $filter->detalle    = 'Local de codigo ' . $cod_periodo 
                                            . ' no existe, error en la l&iacute;nea ' . $fil 
                                            . ' columna 3 del archivo ' . $nombre_archivo;
                    $this->tablalog_model->insertar_log( $filter );
                    $cod_periodo        = 0;
                } else {
                    $cod_periodo        = $periodo[0]->PERI_Codigo;
                }
            }
            return $cod_periodo;
	}
        
        private function validar_stock_actual( $stock, $nombre_archivo, $flag, $fil ) {
            if ( $stock == NULL ) {
                $filter             = new StdClass();
                $filter->archivo    = $nombre_archivo;
                $filter->tabla      = 'DEMANDA';
                $filter->flag       = $flag;
                $filter->detalle    = 'El campo Stock Actual esta vacio de la l&iacute;nea '
                                        . $fil . ' columna 4 del archivo ' . $nombre_archivo;
                $this->tablalog_model->insertar_log( $filter );
                $stock              = 0;
            } else {
                if ( $this->convertir_entero($stock) < 0 ) {
                    $filter             = new StdClass();
                    $filter->archivo    = $nombre_archivo;
                    $filter->tabla      = 'DEMANDA';
                    $filter->flag       = $flag;
                    $filter->detalle    = 'El campo Stock Actual debe ser mayor o igual a CERO de la l&iacute;nea '
                                            . $fil . ' columna 4 del archivo ' . $nombre_archivo;
                    $this->tablalog_model->insertar_log( $filter );
                    $stock              = 0;
                }
            }
            return $stock;
	}
        
        public function validar_taller( $cod_taller, $nombre_archivo, $flag, $fil ) {
            if ( $cod_taller == NULL ) {
                $filter                 = new StdClass();
                $filter->archivo        = $nombre_archivo;
                $filter->tabla          = 'DEMANDA';
                $filter->flag           = $flag;
                $filter->detalle        = 'El campo Ubicacion esta vacio de la l&iacute;nea '
                                            . $fil . ' columna 3 del archivo ' . $nombre_archivo;
                $this->tablalog_model->insertar_log( $filter );
                $cod_taller             = 0;
            } else {
                $taller = $this->taller_model->obtener_taller( $cod_taller );
                if ( $taller == NULL ) {
                    $filter             = new StdClass();
                    $filter->archivo    = $nombre_archivo;
                    $filter->tabla      = 'LOCALES';
                    $filter->flag       = $flag;
                    $filter->detalle    = 'Ubicacion de codigo ' . $cod_taller 
                                            . ' no existe, error en la l&iacute;nea ' . $fil
                                            . ' columna 3 del archivo ' . $nombre_archivo;
                    $this->tablalog_model->insertar_log( $filter );
                    $cod_taller         = 0;
                } else
                    $cod_taller = $taller[0]->PERI_Codigo;
            }
            return $cod_taller;
	}
        
        // esta funcion no esta siendo utilizada en ninguna parte
        private function validar_fecha_stock( $fecha, $nombre_archivo, $flag, $fil ) {
            if ( $fecha == NULL ) {
                $filter             = new StdClass();
                $filter->archivo    = $nombre_archivo;
                $filter->tabla      = 'DEMANDA';
                $filter->flag       = $flag;
                $filter->detalle    = 'El campo Fecha de Stock esta vacio de la l&iacute;nea '
                                        . $fil . ' columna 5 del archivo ' . $nombre_archivo;
                $this->tablalog_model->insertar_log( $filter );
                $fecha              = 0;
            } else {
                //convertir a formato fecha     $fecha = $this->convertir_formato_fecha($fecha);
                if ( $fecha == -1 ) {
                    $filter             = new StdClass();
                    $filter->archivo    = $nombre_archivo;
                    $filter->tabla      = 'DEMANDA';
                    $filter->flag       = $flag;
                    $filter->detalle    = 'El campo Fecha de Stock no tiene el formato adecuado de la l&iacute;nea '
                                            . $fil . ' columna 5 del archivo ' . $nombre_archivo;
                    $this->tablalog_model->insertar_log( $filter );
                    $fecha              = 0;
                }
            }
            return $fecha;
        }
        
        private function validar_familia( $familia, $nombre_archivo, $flag, $fil ) {
            if ( $familia == NULL ) {
                $filter             = new StdClass();
                $filter->archivo    = $nombre_archivo;
                $filter->tabla      = 'PRODUCTOS';
                $filter->flag       = $flag;
                $filter->detalle    = 'El campo Familia esta vacio de la l&iacute;nea '
                                        . $fil . ' columna 3 del archivo ' . $nombre_archivo;
                $this->tablalog_model->insertar_log( $filter );
                $familia            = '';
            } else {
                $familia = $this->familia_model->obtener_familia_codigo_interno($familia);
                if ( $familia == NULL ) {
                    $filter 			= new StdClass();
                    $filter->archivo    = $nombre_archivo;
                    $filter->tabla      = 'PRODUCTO';
                    $filter->flag       = $flag;
                    $filter->detalle    = 'La Familia no existe, en la l&iacute;nea '
                                            . $fil . ' columna 3 del archivo ' . $nombre_archivo;
                    $this->tablalog_model->insertar_log( $filter );
                    $familia            = '';
                } else
                    $familia = $familia[0]->FAMI_Codigo;
            }
            return $familia;
        }
        
        private function validar_fecha($fecha){
            // el formato es: mes, day, year
            $fecha = explode( '/', $fecha );
            $retorno = false;
            if ( checkdate($fecha[1],$fecha[0],$fecha[2]) )
                $retorno = true;
            return $retorno;
        }
        
        private function formato_fecha( $fecha ) {
            // paso al formato del sistema: anho-mes-dia
            $fecha = explode( '/', $fecha );
            return  $fecha[2] . '-' . $fecha[1] . '-' . $fecha[0];
        }
        
        private function convertir_entero($variable){
            $longitud = strlen($variable);
            settype( $variable, 'integer' );
            $retorno = $variable;
            if ( $longitud > strlen($variable) )
                $retorno = -1;
            return $retorno;
        }
        
        private function convertir_meses( $mes ) {
            switch ( $mes ) {
                case 1  :   return 'ENERO';     break;
                case 2  :   return 'FEBRERO';   break;
                case 3  :   return 'MARZO';     break;
                case 4  :   return 'ABRIL';     break;
                case 5  :   return 'MAYO';      break;
                case 6  :   return 'JUNIO';     break;
                case 7  :   return 'JULIO';     break;
                case 8  :   return 'AGOSTO';    break;
                case 9  :   return 'SETIEMBRE'; break;
                case 10 :   return 'OCTUBRE';   break;
                case 11 :   return 'NOVIEMBRE'; break;
                case 12 :   return 'DICIEMBRE'; break;
            }
        }
        
    }
    
?>
