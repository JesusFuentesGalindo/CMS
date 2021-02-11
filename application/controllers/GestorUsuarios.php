<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class GestorUsuarios extends MY_Controller{
    
    public function __construct() {
        parent::__construct();
        
        if($this->require_role('admin') ){
            $this->load->helper('url');
            $this->load->helper('auth');
            $this->load->model('GestorUsuarios_M');
        }
    }
    
    public function index(){
        
        $data=[
            'module'=>'gestor_usuarios',
            'usuarios'=>$this->leer_usuarios()
        ];
        echo '<!DOCTYPE html>';
        echo '<html lang="es">';
        $this->load->view('templates/head',$data);
        $this->load->view('templates/body');
        $this->load->view('templates/scripts');
    }
    
    public function crear_usuario(){
        
        // User
        $user_data = [
                'username'   => $this->input->post('username'),
                'passwd'     => $this->input->post('passwd'),
                'email'      => $this->input->post('email'),
                'auth_level' => '9'
        ];
        
        $user_data['passwd']     = $this->authentication->hash_passwd($user_data['passwd']);
        $user_data['user_id']    = $this->GestorUsuarios_M->get_unused_id();
        $user_data['created_at'] = date('Y-m-d H:i:s');
        
        //Profile
        $user_profile=[
            'user_id'=>$user_data['user_id'],
            'first_name'=>null,
            'last_name'=>null,
            'photo'=>'assets/img/user/defaultMan.png'
        ];
        
        $this->db->set($user_data)->insert(db_table('user_table'));
        $response=$this->GestorUsuarios_M->create_profile($user_profile);
        
        if( $response == 1 ){
            echo json_encode($user_data['username']);
        }
        else{
            echo json_encode(validation_errors());
        }
        
    }
    
    /**
    * Log out
    */
    public function logout(){
        
        $this->authentication->logout();

        // Set redirect protocol
        $redirect_protocol = USE_SSL ? 'https' : NULL;

        redirect( site_url( LOGIN_PAGE . '?' . AUTH_LOGOUT_PARAM . '=1', $redirect_protocol ) );
    }
    
    // --------------------------------------------------------------
    
    /**
     * Lee los usuarios registrados en el sistema.
     *
     * @return  array Lista de usuarios.
     */
    private function leer_usuarios(){
        
        $usuarios=$this->GestorUsuarios_M->get_users();
        return $usuarios;
    }
    // --------------------------------------------------------------
    
    /**
     * Elimina un usuario del sistema.
     *
     * @return  array Lista de usuarios.
     */
    public function eliminar_usuario(){
        
        $user_id=$this->input->post('user_id');
        $response=$this->GestorUsuarios_M->delete_user($user_id);
        echo json_encode(['response'=>$response]);
    }
    // --------------------------------------------------------------
    
    /**
     * Actualizar usuario del sistema.
     *
     * @return  array Lista de usuarios.
     */
    public function actualizar_usuario(){
        
        $user=[
            'user_id'=>$this->auth_user_id,
            'username'=>$this->input->post('username'),
            'email'=>$this->input->post('email'),
            'passwd'=>$this->input->post('passwd'),
        ];
        $upload_photo=isset($_FILES['photo']['tmp_name']) &&  $_FILES['photo']['tmp_name']!='undefined';
        if(
            $upload_photo || 
            strcmp($user['username'],$this->auth_username) || 
            strcmp($user['email'],$this->auth_email) || 
            $user['passwd']!=''){
            
            if($upload_photo){

                $user['photo']=$this->upload_img();
            }
            
            $response=$this->GestorUsuarios_M->update_user_raw_data($user);
        }
        
        
        echo json_encode($response);
    }
    // --------------------------------------------------------------
    
    private function upload_img(){
        
        $photo=$_FILES['photo'];
        $respose='';
        list($ancho,$alto)=getimagesize($photo['tmp_name']);
        $nuevoAncho=500;
        $nuevoAlto=500;
        
        $directorio=FCPATH.'assets/img/user/';
        
        if($photo['type']=='image/jpeg'){
            $origen= imagecreatefromjpeg($photo['tmp_name']);
            $destino= imagecreatetruecolor($nuevoAncho,$nuevoAlto);
            imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
            imagejpeg($destino,$directorio.$this->auth_user_id.'.jpeg');
            $respose='assets/img/user/'.$this->auth_user_id.'.jpeg';
        }
        
        if($photo['type']=='image/png'){
            $origen= imagecreatefrompng($photo['tmp_name']);
            $destino= imagecreatetruecolor($nuevoAncho,$nuevoAlto);
            imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
            imagepng($destino,$directorio.$this->auth_user_id.'.png');
            $respose='assets/img/user/'.$this->auth_user_id.'.png';
        }
        
//        $config['upload_path']          = $directorio;
//        $config['allowed_types']        = 'gif|jpg|png';
//        $config['max_size']             = 200;
//        $config['max_width']            = 500;
//        $config['max_height']           = 500;
//        $config['file_name']            = $this->auth_user_id;
//        
//        $this->load->library('upload', $config);
//        
//        if ( ! $this->upload->do_upload('photo')){
//                $error = array('error' => $this->upload->display_errors());
//
//                $respose=$error;
//        }
//        else{
//                $data = array('upload_data' => $this->upload->data());
//
//                $respose=$data;
//        }
        return $respose;
    }
}
