<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Form_validation extends CI_Form_validation{
    
    public function __construct($rules = array()){
        parent::__construct($rules);
    }
    
    /**
    * Alpha-numeric w/ spaces
    *
    * @param	string
    * @return	bool
    */
   public function alpha_numeric_spaces($str){
           return (bool) preg_match('/^[A-Z0-9 áéíóúÁÉÍÓÚÑñ.,()]+$/i', $str);
   }
}