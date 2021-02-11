<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Community Auth - MY Controller
 *
 * Community Auth is an open source authentication application for CodeIgniter 3
 *
 * @package     Community Auth
 * @author      Robert B Gottier
 * @copyright   Copyright (c) 2011 - 2018, Robert B Gottier. (http://brianswebdesign.com/)
 * @license     BSD - http://www.opensource.org/licenses/BSD-3-Clause
 * @link        http://community-auth.com
 */

require_once APPPATH . 'third_party/community_auth/core/Auth_Controller.php';

class MY_Controller extends Auth_Controller{
    
    public $profile_data = NULL;
    
    /**
     * Class constructor
     */
    public function __construct(){
        parent::__construct();
    }
        
    /**
    * User recovery form
    */
    protected function _set_user_variables(){
        
        parent::_set_user_variables();

        // For controllers
        $this->profile_data = array(
            'auth_first_name'=>$this->auth_data->first_name,
            'auth_last_name'=>$this->auth_data->last_name,
            'auth_photo'=>$this->auth_data->photo
        );

        // For CI config
        $this->config->set_item( 'profile', $this->profile_data );

        // For views
        $this->load->vars( $this->profile_data );
    }
    // --------------------------------------------------------------
}

/* End of file MY_Controller.php */
/* Location: /community_auth/core/MY_Controller.php */