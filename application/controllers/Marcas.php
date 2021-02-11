<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Marcas extends MY_Controller{
    
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
            $this->load->model('Marcas_M');
        }
    }
    // --------------------------------------------------------------
    
    public function index(){
            
        $data=[
            'module'=>'marcas'
        ];
        
        echo '<!DOCTYPE html>';
        echo '<html lang="es">';
        $this->load->view('templates/head',$data);        
        $this->load->view('templates/body');
        $this->load->view('templates/scripts');
    }
    
    /**
    * Crea una marca nueva.
    *
    * @return  array Respuesta de la petición.
    */
    public function create_brand(){
        
        $db=$this->Marcas_M;
        
        //Validar Datos y sanitizar.
        $rules=$this->validation_rules('brand.create');
        
        $this->form_validation->set_rules($rules);
        
        if($this->form_validation->run()==TRUE){
            
            $imagen=set_value('b_name');
            
            $upload_data=$this->upload_img($imagen,'assets/img/marcas/','b_img');
            
            if($upload_data['status']=='success' OR $upload_data['status']=='warning'){
                
                $brand_data=[
                    'user_id'=>$this->auth_user_id,
                    'b_name'=>set_value('b_name'),
                    'b_description'=>set_value('b_description'),
                    'b_equipments'=>set_value('b_equipments'),
                    'b_aplication'=>set_value('b_aplication'),
                    'b_img'=>$upload_data['path']
                ];
                
                $response=$db->create_brand($brand_data);
                
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
                    'code'=>'v002',
                    'message'=>validation_errors()
                ]
            ];
        }
        
        echo json_encode($response);
    }
    // --------------------------------------------------------------
    
    /**
    * Define las reglas de validación.
    *
    * @return  array Lista de reglas.
    */
    private function validation_rules($action){
        
        switch($action){
            
            case 'brand.create':
                $rules=[
                    [
                        'field'=>'b_name',
                        'label'=>'Nombre de la Marca',
                        'rules'=>['required','trim','min_length[3]','max_length[100]','alpha_numeric_spaces','is_unique[brands.b_name]']
                    ],
                    [
                        'field'=>'b_img',
                        'label'=>'Imagen de la Marca',
                        'rules'=>['callback_file_exist[b_img]','callback_file_type[b_img]','callback_file_size[b_img]']
                    ],
                    [
                        'field'=>'b_description',
                        'label'=>'Descripción de la Marca',
                        'rules'=>['required','trim','min_length[3]','alpha_numeric_spaces']
                    ],
                    [
                        'field'=>'b_equipments',
                        'label'=>'Equipos de la Marca',
                        'rules'=>['required','trim','min_length[3]','alpha_numeric_spaces']
                    ],
                    [
                        'field'=>'b_aplication',
                        'label'=>'Aplicación de la Marca',
                        'rules'=>['required','trim','min_length[3]','alpha_numeric_spaces']
                    ],
                ];
                break;
            case 'brand.update':
                $rules=[
                    [
                        'field'=>'b_id',
                        'label'=>'Identificador',
                        'rules'=>['required','numeric']
                    ],
                    [
                        'field'=>'b_name',
                        'label'=>'Nombre de la Marca',
                        'rules'=>['trim','min_length[3]','max_length[100]','alpha_numeric_spaces']
                    ],
                    [
                        'field'=>'b_description',
                        'label'=>'Descripción de la Marca',
                        'rules'=>['trim','min_length[3]','alpha_numeric_spaces']
                    ],
                    [
                        'field'=>'b_equipments',
                        'label'=>'Equipos de la Marca',
                        'rules'=>['trim','min_length[3]','alpha_numeric_spaces']
                    ],
                    [
                        'field'=>'b_aplication',
                        'label'=>'Aplicación de la Marca',
                        'rules'=>['trim','min_length[3]','alpha_numeric_spaces']
                    ],
                ];
                break;
        }
        
        return $rules;
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
        $allowed_mime_type_arr=array('image/jpeg','image/pjpeg','image/png','image/x-png');
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
        $upload_config['allowed_types']='jpg|png';
        $upload_config['max_size']=250;
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
    * Lee las marcas registradas en el sistema.
    *
    * @return  array Lista de avisos.
    */
    public function read_brands(){
        
        $brands=$this->Marcas_M->get_brands()->result_array();
        echo json_encode($brands);
    }
    // --------------------------------------------------------------
    
    /**
     * Actualiza una marca del sistema.
     *
     * @return  .
     */
    public function update_brand(){
        
        $db=$this->Marcas_M;
        
        //Validar Datos y sanitizar.
        $rules=$this->validation_rules('brand.update');
        $this->form_validation->set_rules($rules);
        if($this->form_validation->run()==TRUE){
            
            $update_values['b_id']=set_value('b_id');
            
            //Leer la marca que se desea actualizar.
            $read_brand=$db->read_brand($update_values['b_id']);
            if($read_brand['status']=='success'){
                
                $update_values['b_name']=is_null(set_value('b_name'))?$read_brand['data'][0]['b_name']:set_value('b_name');
                $update_values['b_description']=is_null(set_value('b_description'))?$read_brand['data'][0]['b_description']:set_value('b_description');
                $update_values['b_equipments']=is_null(set_value('b_equipments'))?$read_brand['data'][0]['b_equipments']:set_value('b_equipments');
                $update_values['b_aplication']=is_null(set_value('b_aplication'))?$read_brand['data'][0]['b_aplication']:set_value('b_aplication');
                
                //Si subio nueva imagen.
                if($this->file_exist('b_img','b_img')){
                    //Eliminar imagen previa.
                    if(unlink($read_brand['data'][0]['b_img'])){
                        
                        //Subir la nueva imagen.
                        $upload_img=$this->upload_img($update_values['b_name'],'assets/img/marcas/','b_img');
                        if($upload_img['status']=='success'){
                            $update_values['b_img']=$upload_img['path'];
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
                    $update_values['b_img']=$read_brand['data'][0]['b_img'];
                }
                
                $response=$db->update_brand($update_values);
            }
            else{
                
                $response['error']=$read_notice;
            }
        }
        else{
            
            $response=[
                'error'=>[
                    'code'=>'v004',
                    'message'=>validation_errors()
                ]
            ];
        }
        
        echo json_encode($response);
    }
    // --------------------------------------------------------------
    
     /**
     * Elimina una marca del sistema.
     *
     * @return
     */
    public function delete_brand(){
        
        $db=$this->Marcas_M;
        
        //Validar Datos y sanitizar.
        $rules=[
            [
                'field'=>'b_id',
                'label'=>'Identificador',
                'rules'=>['required','numeric'],
                'errors'=>[
                    'numeric'=>'{field} invalido.'
                ]
            ]
        ];
        
        $this->form_validation->set_rules($rules);
        
        if($this->form_validation->run()==TRUE){
            
            $b_id=set_value('b_id');
            $read_brand=$db->read_brand($b_id);
            if($read_brand['status']=='success'){
                
                if(unlink($read_brand['data'][0]['b_img'])){
                    $response=$db->delete_brand(set_value('b_id'));
                }
            }
            else{
                $response=$read_brand;
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
}

