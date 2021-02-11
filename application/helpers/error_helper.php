<?php
defined('BASEPATH') OR exit('No direct script access allowed');

define('UNDEFINED_TABLE',1146);
define('DUPLICATE_ENTRY',1062);

if ( ! function_exists('error_array')){
    
    function error_array($error){
        
        $error_array=[];
        $code=$error['code'];
        if($code==UNDEFINED_TABLE){
            $error_array['message']='Tabla inexistente';
            $error_array['code']=UNDEFINED_TABLE;
        }
        else if($code==DUPLICATE_ENTRY){
            $error_array['message']='Elemento Duplicado';
            $error_array['code']=DUPLICATE_ENTRY;
        }
        else{
            $error_array['message']='Error: Reporte el código con el administrador';
            $error_array['code']='#';
        }
        
        return $error_array;
    }
}

