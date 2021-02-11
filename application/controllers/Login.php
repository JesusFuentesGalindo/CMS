<?php

class Login extends MY_Controller{
    
    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
    }
    
    
    public function login(){
        
        // Method should not be directly accessible
        if( $this->uri->uri_string() == 'login/login'){
            show_404();
        }

        if(strtolower($_SERVER['REQUEST_METHOD'])=='post'){
            $this->require_min_level(1);
        }
        
        $this->setup_login_form();
        return $this->load->view('login');
    }
}