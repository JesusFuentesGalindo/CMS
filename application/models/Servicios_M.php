<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Servicios_M extends My_Model{
    
    /**
    * Constructor del modelo.
    *
    */
    public function __construct() {
        parent::__construct();
        
        $this->load->helper('error');
        $this->db->db_debug = false;
    }
    // --------------------------------------------------------------
    
    /**
     * Lee los servicios registrados en el sistema.
     *
     * @return  array Lista de aplicaciones.
     */
    public function read_services(){
        
        // Selected aplication table data
        $selected_columns = [
                's_id',
                'username',
                's_title',
                's_description',
                's_img',
        ];
        
        // aplication table query
        $response=$this->db->select($selected_columns)
                ->from('services')
                ->join('users','services.user_id=users.user_id')
                ->get();
        
        return $response;
    }
    // --------------------------------------------------------------
    
    /**
     * Crea un servicio.
     *
     * @return  array Respuesta de la petición de creación.
     */
    
    public function create_service($service_data){
        
        $query=$this->db->insert('services',$service_data);
        if(empty($query)){

            $error=$this->db->error();
            $response=['error'=>error_array($error)];
        }
        else{
            
            $response['message']='Servicio Creado';
            $response['data']=$query;
        }
        
        return $response;
    }
    // --------------------------------------------------------------
    
    /**
     * Lee un servicio determinado.
     *
     * @return  array Atributos del servicio.
     */
    public function read_service($s_id){
        
        $query=$this->db->get_where('services',['s_id'=>$s_id]);
        if(empty($query)){

            $error=$this->db->error();
            $response['status']='error';
            $response['error']=error_array($error);
        }
        else{
            
            $response['status']='success';
            $response['message']='Servicio Leido';
            $response['data']=$query->result_array();
        }
        
        return $response;
    }
    // --------------------------------------------------------------
    
    /**
    * Actualiza un servicio.
    *
    * @return bool
    */
    public function update_service($update_data){
        
        $data=[
            's_title'=>$update_data['s_title'],
            's_description'=>$update_data['s_description'],
            's_img'=>$update_data['s_img']
        ];
        
        $this->db->where('s_id',$update_data['s_id']);
        $query=$this->db->update('services',$data);
        
        if(empty($query)){

            $error=$this->db->error();
            $response=['error'=>error_array($error)];
        }
        else{
            
            $response['message']='Servicio Actualizado';
            $response['data']=$query;
        }
        
        return $response;
    }
    // --------------------------------------------------------------
    
    /**
     * Elimina una aplicación.
     *
     * @return  boolean .
     */
    public function delete_service($s_id){
        
        $query=$this->db->delete('services',['s_id'=>$s_id]);
        if(empty($query)){

            $error=$this->db->error();
            $response['status']='error';
            $response['error']=error_array($error);
        }
        else{
            $response['status']='success';
            $response['message']='Servicio Eliminado';
            $response['data']=$query;
        }
        return $response;
    }
    // --------------------------------------------------------------
    
}