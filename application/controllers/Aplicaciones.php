<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Aplicaciones extends MY_Controller{
    
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
            $this->load->model('Aplicaciones_M');
        }
    }
    // --------------------------------------------------------------
    
    public function index(){
        
        $data['module']='aplicaciones';
        $data['aplications']=$this->Aplicaciones_M->read_aplications()->result_array();
        
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
            
            case 'aplication.create':
                $rules=[
                    [
                        'field'=>'a_name',
                        'label'=>'Nombre de la Aplicación',
                        'rules'=>['required','trim','min_length[1]','max_length[100]','alpha_numeric_spaces','is_unique[aplications.a_name]'],
                        'errors'=>[
                            'is_unique'=>'El {field} ya está en uso.'
                        ]
                    ],
                    [
                        'field'=>'a_description',
                        'label'=>'Descripción',
                        'rules'=>['required','trim','encode_php_tags','htmlspecialchars']
                    ],
                    [
                        'field'=>'a_img',
                        'label'=>'Imagen del Aviso',
                        'rules'=>['callback_file_exist[a_img]','callback_file_type[a_img]','callback_file_size[a_img]']
                    ]
                ];
                break;
            case 'aplication.update':
                $rules=[
                    [
                        'field'=>'a_id',
                        'label'=>'Identificador',
                        'rules'=>['required','numeric']
                    ],
                    [
                        'field'=>'a_name',
                        'label'=>'Nombre de la Aplicación',
                        'rules'=>['trim','min_length[1]','max_length[100]','alpha_numeric_spaces']
                    ],
                    [
                        'field'=>'a_description',
                        'label'=>'Descripción',
                        'rules'=>['trim','encode_php_tags','htmlspecialchars']
                    ]
                ];
                break;
            case 'link.equipment':
                $rules=[
                    [
                        'field'=>'a_id',
                        'label'=>'Identificador',
                        'rules'=>['required','numeric']
                    ],
                    [
                        'field'=>'pa_name',
                        'label'=>'Nombre de la Aplicación',
                        'rules'=>['required','trim','min_length[1]','max_length[100]','alpha_numeric_spaces']
                    ],
                ];
                break;
            case 'equipment.update':
                $rules=[
                    [
                        'field'=>'a_id',
                        'label'=>'Identificador',
                        'rules'=>['required','numeric']
                    ],
                    [
                        'field'=>'pa_name',
                        'label'=>'Nombre de la Aplicación',
                        'rules'=>['required','trim','min_length[1]','max_length[100]','alpha_numeric_spaces']
                    ],
                ];
                break;
        }
        
        return $rules;
    }
    // --------------------------------------------------------------
    
    /**
    * Crea una aplicación nueva.
    *
    * @return  array Respuesta de la petición.
    */
    public function create_aplication(){
        
        $db=$this->Aplicaciones_M;
        
        //Validar Datos y sanitizar.
        $rules=$this->validation_rules('aplication.create');
        
        $this->form_validation->set_rules($rules);
        
        if($this->form_validation->run()==TRUE){
            
            $imagen=set_value('a_name');
            
            $upload_data=$this->upload_img($imagen,'assets/img/aplicaciones/','a_img');
            
            if($upload_data['status']=='success' OR $upload_data['status']=='warning'){
                
                $aplication_data=[
                    'user_id'=>$this->auth_user_id,
                    'a_name'=>set_value('a_name'),
                    'a_description'=>set_value('a_description'),
                    'a_img'=>$upload_data['path']
                ];
                
                $response=$db->create_aplication($aplication_data);
                
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
    * Lee las aplicaciones registradas en el sistema.
    *
    * @return  array Lista de aplicaciones.
    */
    public function read_aplications(){
        
        $aplications=$this->Aplicaciones_M->read_aplications()->result_array();
        echo json_encode($aplications);
    }
    // --------------------------------------------------------------
    
    /**
     * Actualiza una aplicación del sistema.
     *
     * @return  .
     */
    public function update_aplication(){
        
        $db=$this->Aplicaciones_M;
        
        //Validar Datos y sanitizar.
        $rules=$this->validation_rules('aplication.update');
        $this->form_validation->set_rules($rules);
        if($this->form_validation->run()==TRUE){
            
            $update_values['a_id']=set_value('a_id');
            
            //Leer el usuario que se desea actualizar.
            $read_aplication=$db->read_aplication($update_values['a_id']);
            if($read_aplication['status']=='success'){
                
                $update_values['a_name']=is_null(set_value('a_name'))?$read_aplication['data'][0]['a_name']:set_value('a_name');
                $update_values['a_description']=is_null(set_value('a_description'))?$read_product['data'][0]['a_description']:set_value('a_description');
                
                //Si subio nueva imagen.
                if($this->file_exist('a_img','a_img')){
                    //Eliminar imagen previa.
                    if(unlink($read_aplication['data'][0]['a_img'])){
                        
                        //Subir la nueva imagen.
                        $upload_img=$this->upload_img($update_values['a_name'],'assets/img/aplicaciones/','a_img');
                        if($upload_img['status']=='success'){
                            $update_values['a_img']=$upload_img['path'];
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
                    $update_values['a_img']=$read_aplication['data'][0]['a_img'];
                }
                
                $response=$db->update_aplication($update_values);
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
     * Elimina una aplicación del sistema.
     *
     * @return
     */
    public function delete_aplication(){
        
        $db=$this->Aplicaciones_M;
        
        //Validar Datos y sanitizar.
        $rules=[
            [
                'field'=>'a_id',
                'label'=>'Identificador',
                'rules'=>['required','numeric'],
                'errors'=>[
                    'numeric'=>'{field} invalido.'
                ]
            ]
        ];
        
        $this->form_validation->set_rules($rules);
        
        $a_id=$this->input->post('a_id');
        
        if($this->form_validation->run()==TRUE){
            
            $read_aplication=$db->read_aplication($a_id);
            if($read_aplication['status']=='success'){
                
                if(unlink($read_aplication['data'][0]['a_img'])){
                    $response=$db->delete_aplication(set_value('a_id'));
                }
            }
            else{
                $response=$read_aplication;
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
    
    /**
    * Lee los equipos de las aplicaciones.
    *
    * @return  array Lista de equipos.
    */
    public function read_equipments(){
        
        $equipments=$this->Aplicaciones_M->read_equipments()->result_array();
        echo json_encode($equipments);
    }
    // --------------------------------------------------------------
    
    /**
    * Ligar un equipo a una aplicación.
    *
    * @return  array Respuesta de la petición.
    */
    public function link_equipment(){
        
        $db=$this->Aplicaciones_M;
        
        //Validar Datos y sanitizar.
        $rules=$this->validation_rules('link.equipment');
        
        $this->form_validation->set_rules($rules);
        
        if($this->form_validation->run()==TRUE){
                
            $equipment_data=[
                'a_id'=>set_value('a_id'),
                'pa_name'=>set_value('pa_name')
            ];

            $response=$db->link_equipment($equipment_data);
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
     * Actualiza equipo de la aplicación.
     *
     * @return  .
     */
    public function update_equipment(){
        
        $db=$this->Aplicaciones_M;
        
        //Validar Datos y sanitizar.
        $rules=$this->validation_rules('equipment.update');
        $this->form_validation->set_rules($rules);
        if($this->form_validation->run()==TRUE){
            
            $update_values['pa_id']=set_value('pa_id');
            
            //Leer el usuario que se desea actualizar.
            $read_equipment=$db->read_equipment($update_values['pa_id']);
            if($read_equipment['status']=='success'){
                
                $update_values['a_id']=is_null(set_value('a_id'))?$read_equipment['data'][0]['a_id']:set_value('a_id');
                $update_values['pa_name']=is_null(set_value('pa_name'))?$read_equipment['data'][0]['pa_name']:set_value('pa_name');
                
                $response=$db->update_equipment($update_values);
            }
            else{
                
                $response['error']=$read_equipment;
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
     * Elimina una aplicación del sistema.
     *
     * @return
     */
    public function delete_equipment(){
        
        $db=$this->Aplicaciones_M;
        
        //Validar Datos y sanitizar.
        $rules=[
            [
                'field'=>'pa_id',
                'label'=>'Identificador',
                'rules'=>['required','numeric'],
                'errors'=>[
                    'numeric'=>'{field} invalido.'
                ]
            ]
        ];
        
        $this->form_validation->set_rules($rules);
        
        $pa_id=set_value('pa_id');
        
        if($this->form_validation->run()==TRUE){
            
            $read_aplication=$db->read_equipment($pa_id);
            if($read_aplication['status']=='success'){
                
                $response=$db->delete_equipment(set_value('pa_id'));
            }
            else{
                $response=$read_aplication;
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

