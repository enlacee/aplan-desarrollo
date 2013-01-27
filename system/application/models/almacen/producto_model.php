<?php
class Producto_Model extends Model{
	protected $tabla = 'cji_producto';
	var $somevar;
	function __construct(){
		parent::__construct();
		$this->load->helper('date');
		$this->somevar['compania'] 	= $this->session->userdata('compania');
		$this->somevar['compania_hija'] 	= $this->session->userdata('compania_hija');
		$this->somevar['hoy']       = mdate("%Y-%m-%d",time());
	}
	
	public function insertar_producto($filter){
		$filter->COMP_Codigo = $this->somevar ['compania_hija'];
		$this->db->insert($this->tabla,$filter);
	}
	
	public function insertar_producto_c($filter){
		$this->db->insert($this->tabla,$filter);
	}
	
	
    public function obtener_producto($producto){
		$query = $this->db->where('PROD_Codigo',$producto)->get($this->tabla,1);
		if($query->num_rows>0){
			foreach($query->result() as $fila){
				$data[] = $fila;
			}
			return $data;
		}
	}
	
	public function obtener_producto_x_interno($producto){
		$query = $this->db->where('PROD_CodigoInterno',$producto)->get($this->tabla,1);
		if($query->num_rows>0){
			foreach($query->result() as $fila){
				$data[] = $fila;
			}
			return $data;
		}
	}
	
	public function listar_producto($number_items='',$offset=''){
		$where = array('PROD_Estado !='=>'');
		$query = $this->db->where($where)->order_by('PROD_Codigo','asc')->get($this->tabla,$number_items,$offset);
		// $query = $this->db->order_by('PROD_Codigo','asc')->get($this->tabla,$number_items,$offset);
        if($query->num_rows>0){
			foreach($query->result() as $fila){
				$data[] = $fila;
			}
			return $data;
        }
	}
	
	public function obtener_demandaMTS( $filter ) {
            // para el MES
            // echo date( "m", strtotime($this->somevar['hoy']) );
            // $where = array( 'p.PROD_Codigo'=>$filter->PROD_Codigo, 'd.ESTA_Codigo'=>$filter->ESTA_Codigo, 'd.DEMA_Tipo'=>$filter->DEMA_Tipo );
            // para solo un mes
            // EM DURO DEJADO POR SAILOR
//            $where = array( 'p.PROD_Codigo'=>$filter->PROD_Codigo, 'd.ESTA_Codigo'=>$filter->ESTA_Codigo,
//                            'd.DEMA_Tipo'=>$filter->DEMA_Tipo, 'dd.DDEM_Mes'=>'12' );
            $where = array( 'p.PROD_Codigo'=>$filter->PROD_Codigo, 'd.ESTA_Codigo'=>$filter->ESTA_Codigo,
                            'd.DEMA_Tipo'=>$filter->DEMA_Tipo );
            $this->db->select( '*' );
            $this->db->from( 'cji_producto p' );
            $this->db->join( 'cji_demanda d', 'p.PROD_Codigo=d.PROD_Codigo' );
            $this->db->join( 'cji_detalledemanda dd', 'd.DEMA_Codigo=dd.DEMA_Codigo' );
            $query = $this->db->where( $where )->get();
            if ( $query->num_rows > 0 ) {
                foreach( $query->result() as $fila )
                    $data[] = $fila;
                return $data;
            }
        }
        
        public function obtener_demandaMTO($filter){
            $where = array( 'p.PROD_Codigo'=>$filter->PROD_Codigo, 'd.ESTA_Codigo'=>$filter->ESTA_Codigo,
                            'd.DEMA_Tipo'=>$filter->DEMA_Tipo, 'd.DEMA_Fecha'=>$filter->DEMA_Fecha );
            $this->db->select( '*' );
            $this->db->from( 'cji_producto p' );
            $this->db->join( 'cji_demanda d', 'p.PROD_Codigo = d.PROD_Codigo' );
            $query = $this->db->where( $where )->get();
            if ( $query->num_rows > 0 ) {
                foreach( $query->result() as $fila )
                    $data[] = $fila;
                return $data;
            }
        }
        
        public function obtener_inventario($filter){
		$where = array('p.PROD_Codigo'=>$filter->PROD_Codigo,'i.ESTA_Codigo'=>$filter->ESTA_Codigo);
		$this->db->select('*');
		$this->db->from('cji_producto p');
		$this->db->join('cji_inventario i', 'p.PROD_Codigo = i.PROD_Codigo');
		$query = $this->db->where($where)->get();
        if($query->num_rows>0){
            foreach($query->result() as $fila){
                 $data[] = $fila;
            }
            return $data;
        }
	}
	
	public function obtener_orden($filter){
		$where = array('p.PROD_Codigo'=>$filter->PROD_Codigo);
		$this->db->select('*');
		$this->db->from('cji_orden o');
		$this->db->join('cji_ocompra oc', 'o.ORDE_Codigo = oc.ORDE_Codigo');
		$this->db->join('cji_producto p', 'p.PROD_Codigo = oc.PROD_Codigo');
		$query = $this->db->where($where)->get();
        if($query->num_rows>0){
            foreach($query->result() as $fila){
                 $data[] = $fila;
            }
            return $data;
        }
	}
	
	//obtener las ordenes por fecha
	public function obtener_orden_x_fecha($filter){
		$where = array('p.PROD_Codigo'=>$filter->PROD_Codigo,'OCOM_FechaPlanEmt'=>$filter->fecha);
		$this->db->select('*');
		$this->db->from('cji_orden o');
		$this->db->join('cji_ocompra oc', 'o.ORDE_Codigo = oc.ORDE_Codigo');
		$this->db->join('cji_producto p', 'p.PROD_Codigo = oc.PROD_Codigo');
		$query = $this->db->where($where)->get();
        if($query->num_rows>0){
            foreach($query->result() as $fila){
                 $data[] = $fila;
            }
            return $data;
        }
	}
	
	//listar todos los productos que tengan una tabla MPS
	public function listar_producto_cabeceramps($number_items='',$offset=''){
		$where = array('c.COMP_Codigo'=>$this->somevar ['compania_hija']);
		$this->db->select('*');
		$this->db->from('cji_producto p');
		$this->db->join('cji_cabeceramps c', 'p.PROD_Codigo = c.PROD_Codigo');
		$this->db->group_by('p.PROD_Codigo');
		$query = $this->db->where($where)->get('',$number_items,$offset);
        if($query->num_rows>0){
            foreach($query->result() as $fila){
                 $data[] = $fila;
            }
            return $data;
        }
	}
	
	
}
?>