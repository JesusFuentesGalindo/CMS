<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller{
    
    public function __construct() {
        parent::__construct();
        
        if($this->require_role('admin') ){
            $this->load->helper('url');
            $this->load->model('Pagina_principal_M');
        }
    }
    
    public function index(){
        
        $data=[
            'module'=>'dashboard',
            'num_avisos'=>$this->get_num_notices(),
            'num_marcas'=>$this->get_num_brands(),
            'num_productos'=>$this->get_num_products(),
            'num_aplicaciones'=>$this->get_num_aplications(),
            'num_consumibles'=>$this->get_num_consumables(),
            'num_services'=>$this->get_num_services()
        ];
        
        echo '<!DOCTYPE html>';
        echo '<html lang="es">';
        $this->load->view('templates/head',$data);
        $this->load->view('templates/body');
        $this->load->view('templates/scripts');
    }
    
    private function get_num_notices(){
        
        $num_notices=count($this->Pagina_principal_M->get_notices()->result_array());
        return $num_notices;
    }
    
    private function get_num_brands(){
        
        $num_brands=count($this->Pagina_principal_M->get_brands()->result_array());
        return $num_brands;
    }
    
    private function get_num_products(){
        
        $num_products=count($this->Pagina_principal_M->get_products()['data']);
        return $num_products;
    }
    
    private function get_num_aplications(){
        
        $num_aplications=count($this->Pagina_principal_M->get_aplications()['data']);
        return $num_aplications;
    }
    
    private function get_num_consumables(){
        
        $num_consumables=count($this->Pagina_principal_M->get_consumables()['data']);
        return $num_consumables;
    }
    
    private function get_num_services(){
        
        $num_services=count($this->Pagina_principal_M->get_services()['data']);
        return $num_services;
    }
}


