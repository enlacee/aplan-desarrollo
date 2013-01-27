<?php
    
    if ( ! defined('BASEPATH') )
        exit('No direct script access allowed');
    
    if ( ! function_exists('diferencia_entre_fechas') ) {
        
        function dias_entre_fechas( $fecha1, $fecha2 ) {
            // defino fecha 1
            $fecha1 = explode( '-', $fecha1 );
            $ano1   = $fecha1[0];
            $mes1   = $fecha1[1];
            $dia1   = $fecha1[2];
            
            // defino fecha 2 
            $fecha2 = explode( '-', $fecha2 );
            $ano2   = $fecha2[0];
            $mes2   = $fecha2[1];
            $dia2   = $fecha2[2];
            
            // calculo timestam de las dos fechas 
            $timestamp1     = mktime( 0, 0, 0, $mes1, $dia1, $ano1 );
            $timestamp2     = mktime( 4, 12, 0, $mes2, $dia2, $ano2 );
            
            // resto a una fecha la otra
            $segundos_diferencia    = $timestamp1 - $timestamp2;
            //echo $segundos_diferencia; 
            
            // convierto segundos en días 
            $dias_diferencia        = $segundos_diferencia / (60 * 60 * 24);

            // obtengo el valor absoulto de los días (quito el posible signo negativo) 
            $dias_diferencia        = abs( $dias_diferencia );
            
            // quito los decimales a los días de diferencia 
            $dias_diferencia        = floor( $dias_diferencia );
            
            return $dias_diferencia;
	}
        
    }
    
?>
