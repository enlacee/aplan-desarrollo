<?php
if(!defined('BASEPATH'))exit('No direct script access allowed');

 define("UTF_8", 1);
 define("ASCII", 2);
 define("ISO_8859_1", 3);
 function codificacion($texto)
 {
     $c = 0;
     $ascii = true;
     for ($i = 0;$i<strlen($texto);$i++) {
         $byte = ord($texto[$i]);
         if ($c>0) {
             if (($byte>>6) != 0x2) {
                 return ISO_8859_1;
             } else {
                 $c--;
             }
         } elseif ($byte&0x80) {
             $ascii = false;
             if (($byte>>5) == 0x6) {
                 $c = 1;
             } elseif (($byte>>4) == 0xE) {
                 $c = 2;
             } elseif (($byte>>3) == 0x14) {
                 $c = 3;
             } else {
                 return ISO_8859_1;
             }
         }
     }
     return ($ascii) ? ASCII : UTF_8;
 }
	function fullUpper($string){ 
	  return strtr(strtoupper($string), array( 
		  "à" => "À", 
		  "ñ" => "Ñ", 
		  "è" => "È", 
		  "ì" => "Ì", 
		  "ò" => "Ò", 
		  "ù" => "Ù", 
		  "á" => "Á", 
		  "é" => "É", 
		  "í" => "Í", 
		  "ó" => "Ó", 
		  "ú" => "Ú", 
		  "â" => "Â", 
		  "ê" => "Ê", 
		  "î" => "Î", 
		  "ô" => "Ô", 
		  "û" => "Û", 
		  "ç" => "Ç", 
		)); 
	}
 function utf8_decode_seguro($texto,$upper = false)
 {

     $texto = (codificacion($texto)==ISO_8859_1) ? $texto : utf8_decode($texto);
	 
	 if($upper == true)
	 $texto = fullUpper($texto);
	 
	 return $texto;
 } 
?>
