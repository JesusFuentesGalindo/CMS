<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Servicios extends MY_Controller{
    
    /**
    * Constructor del controlador.
    *
    */
    public function __construct() {
        parent::__construct();
        
        //Verificar el role del usuario
        if($this->require_role('admin') ){
            //Cargar recursos
            $this->load->helper(['url','form','file']);
            $this->load->library('form_validation');
            $this->load->model('Servicios_M');
        }
    }
    // --------------------------------------------------------------
    
    public function index(){
        
        $data['module']='servicios';
        $data['services']=$this->Servicios_M->read_services()->result_array();
        
        echo '<!DOCTYPE html>';
        echo '<html lang="es">';
        $this->load->view('templates/head',$data);
        $this->load->view('templates/body');
        $this->load->view('templates/scripts');
    }
    
    /**
    * Define las reglas de validación.
    *
    * @return  array Lista de reglas.
    */
    private function validation_rules($action){
        
        switch($action){
            
            case 'service.create':
                $rules=[
                    [
                        'field'=>'s_title',
                        'label'=>'Título del servicio',
                        'rules'=>['required','trim','min_length[1]','max_length[100]','alpha_numeric_spaces','is_unique[services.s_title]'],
                        'errors'=>[
                            'is_unique'=>'El {field} ya está en uso.'
                        ]
                    ],
                    [
                        'field'=>'s_description',
                        'label'=>'Descripción',
                        'rules'=>['required','trim','encode_php_tags','htmlspecialchars']
                    ],
                    [
                        'field'=>'s_img',
                        'label'=>'Imagen del Servicio',
                        'rules'=>['callback_file_exist[s_img]','callback_file_type[s_img]','callback_file_size[s_img]']
                    ]
                ];
                break;
            case 'service.update':
                $rules=[
                    [
                        'field'=>'s_id',
                        'label'=>'Identificador',
                        'rules'=>['required','numeric']
                    ],
                    [
                        'field'=>'s_title',
                        'label'=>'Título del Servicio',
                        'rules'=>['required','trim','min_length[1]','max_length[100]','alpha_numeric_spaces']
                    ],
                    [
                        'field'=>'s_description',
                        'label'=>'Descripción del Servicio',
                        'rules'=>['required','trim','min_length[1]','alpha_numeric_spaces']
                    ],
                ];
                break;
        }
        
        return $rules;
    }
    // --------------------------------------------------------------
    
    /**
    * Crea un servicio nuevo.
    *
    * @return  array Respuesta de la petición.
    */
    public function create_service(){
        
        $db=$this->Servicios_M;
        
        //Validar Datos y sanitizar.
        $rules=$this->validation_rules('service.create');
        
        $this->form_validation->set_rules($rules);
        
        if($this->form_validation->run()==TRUE){
            
            $imagen=set_value('s_title');
            
            $upload_data=$this->upload_img($imagen,'assets/img/servicios/','s_img');
            
            if($upload_data['status']=='success' OR $upload_data['status']=='warning'){
                
                $service_data=[
                    'user_id'=>$this->auth_user_id,
                    's_title'=>set_value('s_title'),
                    's_description'=>set_value('s_description'),
                    's_img'=>$upload_data['path']
                ];
                
                $response=$db->create_service($service_data);
                
                if($upload_data['status']=='warning'){
                    $response['warning']=$upload_data['warning'];
                }
            }
            else{
                $response=[
                'error'=>[
                    'code'=>'uf002',
                    'message'=>$upload_data['errors']
                ]
            ];
            }
        }
        else{
            
            $response=[
                'error'=>[
                    'code'=>'v005',
                    'message'=>validation_errors()
                ]
            ];
        }
        
        echo json_encode($response);
    }
    // --------------------------------------------------------------
    
    /**
    * Valida si existe la imagen.
    *
    * @return  bool true o false.
    */
    public function file_exist($str,$file){
        
        $validation=false;
        
        if(isset($_FILES[$file]['name']) && $_FILES[$file]['name']!=""){
            
            $validation=true;
        }
        else{
            $this->form_validation->set_message('file_exist', 'La imagen es obligatoria.');
            $validation=false;
        }
        
        return $validation;
    }
    // --------------------------------------------------------------
    
    /**
    * Valida el tipo de la imagen.
    *
    * @return  bool true o false.
    */
    public function file_type($str,$file){
        
        //Tipo de imagen permitida.
        $allowed_mime_type_arr=array('image/jpg','image/jpeg','image/pjpeg','image/png','image/x-png');
        $mime=get_mime_by_extension($_FILES[$file]['name']);

        if(in_array($mime, $allowed_mime_type_arr)){
            $validation=true;
        }
        else{
            $this->form_validation->set_message('file_type', 'Solo imagenes en formato jpg o png.');
            $validation=false;
        }
        
        return $validation;
    }
    // --------------------------------------------------------------
    
    /**
    * Valida el tamaño de la imagen.
    *
    * @return  bool true o false.
    */
    public function file_size($str,$file){

        $max_size=250000;
        
        if($_FILES[$file]['size']<=$max_size){
            $validation=true;
        }
        else{
            $this->form_validation->set_message('file_size', 'Solo imagenes menor o igual a 200 Kb.');
            $validation=false;
        }
        
        return $validation;
    }
    // --------------------------------------------------------------
    
    /**
    * Sube la imagen al servidor.
    *
    * @return  bool true o false.
    */
    private function upload_img($name,$path,$field){
        
        $img_name=$this->img_name_transform($name);
        $upload_path=FCPATH.$path;
        $response=[];
        
        //Guardar Imagen.
        $upload_config['file_name']=$img_name;
        $upload_config['upload_path']=$upload_path;
        $upload_config['allowed_types']=['jpg','png'];
        $upload_config['max_size']=300;
        $this->load->library('upload', $upload_config);
        
        if($this->upload->do_upload($field)){
            
            $uploadData=$this->upload->data();
            $uploadedImg=$uploadData['full_path'];
            $response['path']=$path.$uploadData['file_name'];
            
            //Redimensionar la imagen.
            $resize_config['image_library']='gd2';
            $resize_config['source_image']=$uploadedImg;
            $resize_config['maintain_ratio'] = TRUE;
            $resize_config['create_thumb'] = FALSE;
            $resize_config['width']=500;
            $resize_config['height']=500;
            $resize_config['x_axis']=500;
            $resize_config['y_axis']=500;
            $this->load->library('image_lib',$resize_config);
            $this->image_lib->resize();
            $this->image_lib->crop();
            
            if ( ! $this->image_lib->resize()){
                $response['status']='warning';
                $response['warning']=$this->image_lib->display_errors();
            }
            
            $response['status']='success';
            
        }
        else{
            
            $response['status']='error';
            $response['path']='';
            $response['errors']=$this->upload->display_errors();
        }
        
        return $response;
    }
    // --------------------------------------------------------------
    
    /**
    * Procesar nombre de imagen.
    *
    * @return  bool true o false.
    */
    private function img_name_transform($name){
        
        $name=strtolower($name);
        $name=str_replace(['á','é','í','ó','ú',' '],['a','e','i','o','u','_'], $name);
        
        return $name;
    }
    // --------------------------------------------------------------
    
    /**
    * Lee los servicios registrados en el sistema.
    *
    * @return  array Lista de servicios.
    */
    public function read_services(){
        
        $services=$this->Servicios_M->read_services()->result_array();
        echo json_encode($services);
    }
    // --------------------------------------------------------------
    
    /**
     * Actualiza un servicio del sistema.
     *
     * @return  .
     */
    public function update_service(){
        
        $db=$this->Servicios_M;
        
        //Validar Datos y sanitizar.
        $rules=$this->validation_rules('service.update');
        $this->form_validation->set_rules($rules);
        if($this->form_validation->run()==TRUE){
            
            $update_values['s_id']=set_value('s_id');
            
            //Leer el usuario que se desea actualizar.
            $read_service=$db->read_service($update_values['s_id']);
            if($read_service['status']=='success'){
                
                $update_values['s_title']=is_null(set_value('s_title'))?$read_service['data'][0]['s_title']:set_value('s_title');
                $update_values['s_description']=is_null(set_value('s_description'))?$read_service['data'][0]['s_description']:set_value('s_description');
                
                //Si subio nueva imagen.
                if($this->file_exist('s_img','s_img')){
                    //Eliminar imagen previa.
                    if(unlink($read_service['data'][0]['s_img'])){
                        
                        //Subir la nueva imagen.
                        $upload_img=$this->upload_img($update_values['s_title'],'assets/img/servicios/','s_img');
                        if($upload_img['status']=='success'){
                            $update_values['s_img']=$upload_img['path'];
                        }
                        else{
                            return $response['error']=$upload_img['errors'];
                        }
                    }
                    else{
                        return $response=[
                            'error'=>[
                                'code'=>'sa001',
                                'message'=>'Error al borrar la imagen'
                            ]
                        ];
                    }
                }
                else{
                    $update_values['s_img']=$read_service['data'][0]['s_img'];
                }
                
                $response=$db->update_service($update_values);
            }
            else{
                
                $response['error']=$read_aplication;
            }
        }
        else{
            
            $response=[
                'error'=>[
                    'code'=>'v002',
                    'message'=>validation_errors()
                ]
            ];
        }
        
        echo json_encode($response);
    }
    // --------------------------------------------------------------
    
    /**
     * Elimina un servicio del sistema.
     *
     * @return
     */
    public function delete_service(){
        
        $db=$this->Servicios_M;
        
        //Validar Datos y sanitizar.
        $rules=[
            [
                'field'=>'s_id',
                'label'=>'Identificador',
                'rules'=>['required','numeric'],
                'errors'=>[
                    'numeric'=>'{field} invalido.'
                ]
            ]
        ];
        
        $this->form_validation->set_rules($rules);
        
        
        if($this->form_validation->run()==TRUE){
            
            $s_id=set_value('s_id');
            
            $read_service=$db->read_service($s_id);
            if($read_service['status']=='success'){
                
                if(unlink($read_service['data'][0]['s_img'])){
                    $response=$db->delete_service(set_value('s_id'));
                }
            }
            else{
                $response=$read_service;
            }
        }
        else{
            
            $response=[
                'error'=>[
                    'code'=>'v006',
                    'message'=>validation_errors()
                ]
            ];
        }
        
        echo json_encode($response);
    }
    // --------------------------------------------------------------
    
}

