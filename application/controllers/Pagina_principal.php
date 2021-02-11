<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pagina_principal extends MY_Controller{
    
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
            $this->load->model('Pagina_principal_M');
        }
    }
    // --------------------------------------------------------------
    
    
    public function index(){
        
        $db=$this->Pagina_principal_M;
        
        $data['module']='pagina_principal';
        $data['products']=$db->get_products();
        echo '<!DOCTYPE html>';
        echo '<html lang="es">';
        $this->load->view('templates/head',$data);
        $this->load->view('templates/body');
        $this->load->view('templates/scripts');
    }
    
    /**
    * Crea un aviso nuevo.
    *
    * @return  array Respuesta de la petición.
    */
    public function create_notice(){
        
        $db=$this->Pagina_principal_M;
        
        //Validar Datos y sanitizar.
        $rules=$this->validation_rules('notice.create');
        
        $this->form_validation->set_rules($rules);
        
        if($this->form_validation->run()==TRUE){
            
            $imagen=set_value('n_name');
            
            $upload_data=$this->upload_img($imagen,'assets/img/avisos/','n_img');
            
            if($upload_data['status']=='success' OR $upload_data['status']=='warning'){
                
                $notice_data=[
                    'user_id'=>$this->auth_user_id,
                    'n_name'=>set_value('n_name'),
                    'n_text'=>set_value('n_text'),
                    'n_text_position'=>set_value('n_text_position'),
                    'n_img'=>$upload_data['path'],
                    'n_text_color'=>set_value('n_text_color'),
                    'n_product'=>set_value('n_product')
                ];
                
                $response=$db->create_notice($notice_data);
                
                if($upload_data['status']=='warning'){
                    $response['warning']=$upload_data['warning'];
                }
            }
            else{
                $response=[
                'error'=>[
                    'code'=>'uf001',
                    'message'=>$upload_data['errors']
                ]
            ];
            }
        }
        else{
            
            $response=[
                'error'=>[
                    'code'=>'v001',
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
            
            case 'notice.create':
                $rules=[
                    [
                        'field'=>'n_name',
                        'label'=>'Nombre del Aviso',
                        'rules'=>['required','trim','min_length[3]','max_length[50]','alpha_numeric_spaces','is_unique[notices.n_name]'],
                        'errors'=>[
                            'is_unique'=>'El {field} ya está en uso.'
                        ]
                    ],
                    [
                        'field'=>'n_text',
                        'label'=>'Texto del Aviso',
                        'rules'=>['trim','encode_php_tags','htmlspecialchars']
                    ],
                    [
                        'field'=>'n_text_position',
                        'label'=>'Posición del Texto del Aviso',
                        'rules'=>['numeric','less_than[9]'],
                        'errors'=>[
                            'less_than'=>'La {field} seleccionada no es valida.'
                        ]
                    ],
                    [
                        'field'=>'n_img',
                        'label'=>'Imagen del Aviso',
                        'rules'=>['callback_file_exist[n_img]','callback_file_type[n_img]','callback_file_size[n_img]']
                    ]
                ];
                break;
            case 'notice.update':
                $rules=[
                    [
                        'field'=>'n_id',
                        'label'=>'Identificador',
                        'rules'=>['required','numeric']
                    ],
                    [
                        'field'=>'n_name',
                        'label'=>'Nombre del Aviso',
                        'rules'=>['trim','min_length[3]','max_length[50]','alpha_numeric_spaces']
                    ],
                    [
                        'field'=>'n_text',
                        'label'=>'Texto del Aviso',
                        'rules'=>['trim','encode_php_tags','htmlspecialchars']
                    ],
                    [
                        'field'=>'n_text_position',
                        'label'=>'Posición del Texto del Aviso',
                        'rules'=>['numeric','less_than_equal_to[9]'],
                        'errors'=>[
                            'less_than_equal_to'=>'La {field} seleccionada no es valida.'
                        ]
                    ]
                ];
                break;
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
                    ]
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
                    ]
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
            $resize_config['width']=1600;
            $resize_config['height']=900;
            $resize_config['x_axis']=1600;
            $resize_config['y_axis']=900;
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
    * Lee los avisos creados en el sistema.
    *
    * @return  array Lista de avisos.
    */
    public function leer_avisos(){
        
        $notices=$this->Pagina_principal_M->get_notices()->result_array();
        echo json_encode($notices);
    }
    // --------------------------------------------------------------
    
    /**
     * Actualiza un aviso del sistema.
     *
     * @return  .
     */
    public function update_notice(){
        
        $db=$this->Pagina_principal_M;
        
        //Validar Datos y sanitizar.
        $rules=$this->validation_rules('notice.update');
        $this->form_validation->set_rules($rules);
        if($this->form_validation->run()==TRUE){
            
            $update_values['n_id']=set_value('n_id');
            
            //Leer el usuario que se desea actualizar.
            $read_notice=$db->read_notice($update_values['n_id']);
            if($read_notice['status']=='success'){
                
                $update_values['n_name']=is_null(set_value('n_name'))?$read_notice['data'][0]['n_name']:set_value('n_name');
                $update_values['n_text']=is_null(set_value('n_text'))?$read_notice['data'][0]['n_text']:set_value('n_text');
                $update_values['n_text_position']=is_null(set_value('n_text_position'))?$read_notice['data'][0]['n_text_position']:set_value('n_text_position');
                $update_values['n_text_color']=is_null(set_value('n_text_color'))?$read_notice['data'][0]['n_text_color']:set_value('n_text_color');
                $update_values['n_product']=is_null(set_value('n_product'))?$read_notice['data'][0]['n_product']:set_value('n_product');
                
                //Si subio nueva imagen.
                if($this->file_exist('n_img','n_img')){
                    //Eliminar imagen previa.
                    if(unlink($read_notice['data'][0]['n_img'])){
                        
                        //Subir la nueva imagen.
                        $upload_img=$this->upload_img($update_values['n_name'],'assets/img/avisos/','n_img');
                        if($upload_img['status']=='success'){
                            $update_values['n_img']=$upload_img['path'];
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
                    $update_values['n_img']=$read_notice['data'][0]['n_img'];
                }
                
                $response=$db->update_notice($update_values);
            }
            else{
                
                $response['error']=$read_notice;
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
     * Elimina un aviso del sistema.
     *
     * @return
     */
    public function delete_notice(){
        
        $db=$this->Pagina_principal_M;
        
        //Validar Datos y sanitizar.
        $rules=[
            [
                'field'=>'n_id',
                'label'=>'Identificador',
                'rules'=>['required','numeric'],
                'errors'=>[
                    'numeric'=>'{field} invalido.'
                ]
            ]
        ];
        
        $this->form_validation->set_rules($rules);
        
        $n_id=$this->input->post('n_id');
        
        if($this->form_validation->run()==TRUE){
            
            $read_notice=$db->read_notice($n_id);
            if($read_notice['status']=='success'){
                
                if(unlink($read_notice['data'][0]['n_img'])){
                    $response=$db->delete_notice(set_value('n_id'));
                }
            }
            else{
                $response=$read_notice;
            }
        }
        else{
            
            $response=[
                'error'=>[
                    'code'=>'v001',
                    'message'=>validation_errors()
                ]
            ];
        }
        
        echo json_encode($response);
    }
    // --------------------------------------------------------------
    
    /*
     * ****************** *
     * ***** Marcas ***** *
     * ****************** *
     */
    
    /**
    * Lee las marcas registradas en el sistema.
    *
    * @return  array Lista de avisos.
    */
    public function read_brands(){
        
        $brands=$this->Pagina_principal_M->get_brands()->result_array();
        echo json_encode($brands);
    }
    // --------------------------------------------------------------
    
    /**
    * Crea una marca nueva.
    *
    * @return  array Respuesta de la petición.
    */
    public function create_brand(){
        
        $db=$this->Pagina_principal_M;
        
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
     * Actualiza una marca del sistema.
     *
     * @return  .
     */
    public function update_brand(){
        
        $db=$this->Pagina_principal_M;
        
        //Validar Datos y sanitizar.
        $rules=$this->validation_rules('brand.update');
        $this->form_validation->set_rules($rules);
        if($this->form_validation->run()==TRUE){
            
            $update_values['b_id']=set_value('b_id');
            
            //Leer la marca que se desea actualizar.
            $read_brand=$db->read_brand($update_values['b_id']);
            if($read_brand['status']=='success'){
                
                $update_values['b_name']=is_null(set_value('b_name'))?$read_brand['data'][0]['b_name']:set_value('b_name');
                
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
        
        $db=$this->Pagina_principal_M;
        
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


