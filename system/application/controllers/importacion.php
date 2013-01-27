<?php
include("system/application/libraries/Excel/reader.php"); 
class Importacion extends controller
{
    public function __construct()
    {
        parent::Controller();
        $this->load->helper('url');
        $this->load->library('html');
        $this->load->model('almacen/linea_model');
        $this->load->model('almacen/familia_model');
        $this->load->model('almacen/familialinea_model');
        $this->load->model('almacen/marca_model');
        $this->load->model('almacen/almacen_model');
        $this->load->model('almacen/producto_model');
        $this->load->model('maestros/establecimiento_model');
        $this->load->model('maestros/color_model');
        $this->load->model('maestros/talla_model');
        $this->somevar['compania'] = $this->session->userdata('compania');
    }
    public function index(){
        //$RutaArchivoCargado = 'productos.xls';
        $RutaArchivoCargado = 'productos_2.xls';
        $data = new Spreadsheet_Excel_Reader();

        $data->setUTFEncoder('mb');
        $data->setOutputEncoding('UTF-8');

        $data->read($RutaArchivoCargado);
        error_reporting(E_ALL ^ E_NOTICE);
		
		//inserta linea
		/*for($fil = 2; $fil <= $data->sheets[0]['numRows']; $fil++) {
            $valor = &$data->sheets[0]['cells'][$fil];
			$filter = new stdClass();
			$filter->FAMI_Codigo2 = 0;
			$filter->FAMI_CodigoInterno = $valor[1];
			$filter->FAMI_Descripcion = $valor[2];
			$this->familia_model->insertar_familia($filter);
		}*/
		
		//inserta familias
		/*for($fil = 2; $fil <= $data->sheets[0]['numRows']; $fil++) {
            $valor = &$data->sheets[0]['cells'][$fil];
			$cod_usuario_familia = $valor[2];
			$descripcion = $valor[3];
			$cod_linea = $this->familia_model->obtener_linea_codigo_interno($valor[1]);
			$cod_linea = $cod_linea[0]->FAMI_Codigo;
			//inserto familia
			$filter = new stdClass();
			$filter->FAMI_Codigo2 = $cod_linea;
			$filter->FAMI_CodigoInterno = $cod_usuario_familia;
			$filter->FAMI_Descripcion 	= $descripcion;
			//print_r($filter);exit;
			$this->familia_model->insertar_familia($filter);
		}*/
		
		//insertar subfamilias
		/*for($fil = 2; $fil <= $data->sheets[0]['numRows']; $fil++) {
            $valor = &$data->sheets[0]['cells'][$fil];
			$cod_linea = $this->familia_model->obtener_linea_codigo_interno($valor[1]);
			$cod_linea = $cod_linea[0]->FAMI_Codigo;
			$cod_familia = $this->familia_model->obtener_familia_padre($valor[2],$cod_linea);
			//inserto familia
			$filter = new stdClass();
			$filter->FAMI_Codigo2 = $cod_familia[0]->FAMI_Codigo;
			$filter->FAMI_CodigoInterno = $valor[3];
			$filter->FAMI_Descripcion 	= $valor[4];
			//print_r($filter);
			$this->familia_model->insertar_familia($filter);
		}*/
		
		//carga establecimientos
		/*for($fil = 2; $fil <= $data->sheets[1]['numRows']; $fil++) {
            $valor = &$data->sheets[1]['cells'][$fil];
			$filter = new stdClass();
			$filter->ESTA_CodigoInterno = $valor[1];
			$filter->ESTA_Descripcion = $valor[2];
			$filter->ESTA_Direccion = $valor[4];
			$filter->ESTA_Estado = $valor[5];
			$cod_almacen = $this->almacen_model->obtener_almacen_interno($valor[9]);
			$cod_almacen = $cod_almacen[0]->ALMA_Codigo;
			$filter->ALMA_Codigo = $cod_almacen;
			$filter->ESTA_Telefono = $valor[11];
			$filter->ESTA_CentroCosto = $valor[12];
			$filter->ESTA_Grupo = $valor[13];
			$filter->EMPR_Codigo = 1;
			$filter->TEST_Codigo = 1;
			$this->establecimiento_model->insertar_establecimiento($filter);
		}*/
		
		//carga color
		/*for($fil = 2; $fil <= $data->sheets[0]['numRows']; $fil++) {
            $valor = &$data->sheets[0]['cells'][$fil];
			$filter = new stdClass();
			$filter->COLO_CodigoInterno = $valor[1];
			$filter->COLO_Descripcion = $valor[2];
			$this->color_model->insertar_color($filter);
		}*/
		
		//carga tallas
		/*for($fil = 2; $fil <= $data->sheets[0]['numRows']; $fil++) {
            $valor = &$data->sheets[0]['cells'][$fil];
			$filter = new stdClass();
			$filter->TALA_CodigoInterno = $valor[1];
			$filter->TALA_Descripcion = $valor[2];
			$this->talla_model->insertar_talla($filter);
		}*/
		
		//carga productos
		for($fil = 2; $fil <= $data->sheets[0]['numRows']; $fil++) {
            $valor = &$data->sheets[0]['cells'][$fil];
			$filter = new stdClass();
			$filter->PROD_CodigoInterno = $valor[1];
			$filter->PROD_ItemPrecCo = $valor[3];
			$filter->PROD_ItemTipo = $valor[4];
			//buscar familia
			$cod_linea = $this->familia_model->obtener_linea_codigo_interno($valor[5]);
			$cod_linea = $cod_linea[0]->FAMI_Codigo;
			$cod_familia_p = $this->familia_model->obtener_familia_padre($valor[6],$cod_linea);
			$cod_familia_p = $cod_familia_p[0]->FAMI_Codigo;
			$cod_familia = $this->familia_model->obtener_familia_hijo($cod_familia_p,$valor[7]);
			$cod_familia = $cod_familia[0]->FAMI_Codigo;
			//echo $cod_linea." - ".$cod_familia_p." - ".$cod_familia;exit;
			$filter->FAMI_Codigo = $cod_familia;
			$filter->PROD_CaracValor = $valor[8];
			//marca
			if($valor[9] != ""){
				$marca = $this->marca_model->obtener_marca_interno($valor[9]);
				$marca = $marca[0]->MARC_Codigo;
			}else{
				$marca = 0;
			}
			$filter->MARC_Codigo = $marca;
			//color
			if($valor[10] != ""){
				$color = $this->color_model->obtener_color_interno($valor[10]);
				$color = $color[0]->COLO_Codigo;
			}else{
				$color = 0;
			}
			$filter->COLO_Codigo = $color;
			//talla
			if($valor[11] != ""){
				$talla = $this->talla_model->obtener_talla_interno($valor[11]);
				$talla = $talla[0]->TALA_Codigo;
			}else{
				$talla = 0;
			}
			$filter->TALA_Codigo = $talla;
			$filter->COMP_Codigo = 1;
			
			$filter->PROD_Descripcion = $valor[12];
			$filter->PROD_Especifiacion = $valor[13];
			$filter->PROD_Estado = $valor[14];
			//$this->producto_model->insertar_producto_c($filter);
		}
    }
}
?>