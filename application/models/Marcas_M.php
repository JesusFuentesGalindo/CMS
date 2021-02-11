<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Marcas_M extends My_Model{
    
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
     * Registra una marca.
     *
     * @return  array Respuesta de la petición de creación.
     */
    public function create_brand($brand_data){
        
        $query=$this->db->insert('brands',$brand_data);
        if(empty($query)){

            $error=$this->db->error();
            $response=['error'=>error_array($error)];
        }
        else{
            
            $response['message']='Marca Registrada';
            $response['data']=$query;
        }
        
        return $response;
    }
    // --------------------------------------------------------------
    
    /**
     * Lee las marcas registrados en el sistema.
     *
     * @return  array Lista de marcas.
     */
    public function get_brands(){
        
        $selected_columns=[
            'b_id',
            'username',
            'b_name',
            'b_img',
            'b_description',
            'b_equipments',
            'b_aplication'
        ];
        
        // Consulta de marcas
        $response=$this->db->select($selected_columns)
                ->from('brands')
                ->join('users','brands.user_id=users.user_id')
                ->get();
        
        return $response;
    }
    // --------------------------------------------------------------
    
    /**
     * Lee una marca determinada.
     *
     * @return  array Atributos de la marca.
     */
    public function read_brand($b_id){
        
        $query=$this->db->get_where('brands',['b_id'=>$b_id]);
        if(empty($query)){

            $error=$this->db->error();
            $response['status']='error';
            $response['error']=error_array($error);
        }
        else{
            
            $response['status']='success';
            $response['message']='Marca Leida';
            $response['data']=$query->result_array();
        }
        
        return $response;
    }
    // --------------------------------------------------------------
    
    /**
    * Actualiza una marca.
    *
    * @return bool
    */
    public function update_brand($update_data){
        
        $data=[
            'b_name'=>$update_data['b_name'],
            'b_img'=>$update_data['b_img'],
            'b_description'=>$update_data['b_description'],
            'b_equipments'=>$update_data['b_equipments'],
            'b_aplication'=>$update_data['b_aplication'],
        ];
        
        $this->db->where('b_id',$update_data['b_id']);
        $query=$this->db->update('brands',$data);
        
        if(empty($query)){

            $error=$this->db->error();
            $response=['error'=>error_array($error)];
        }
        else{
            
            $response['message']='Marca Actualizada';
            $response['data']=$query;
        }
        
        return $response;
    }
    // --------------------------------------------------------------
    
    /**
     * Elimina una marca.
     *
     * @return  boolean .
     */
    public function delete_brand($b_id){
        
        $query=$this->db->delete('brands',['b_id'=>$b_id]);
        if(empty($query)){

            $error=$this->db->error();
            $response['status']='error';
            $response['error']=error_array($error);
        }
        else{
            $response['status']='success';
            $response['message']='Marca Eliminada';
            $response['data']=$query;
        }
        return $response;
    }
    // --------------------------------------------------------------
}