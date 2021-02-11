<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Consumibles_M extends My_Model{
    
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
     * Lee los consumibles registrados en el sistema.
     *
     * @return  array Lista de productos.
     */
    public function get_consumables(){
        
        // Selected notice table data
        $selected_columns = [
                'c_id',
                'username',
                'c_name',
                'c_img',
        ];
        
        // Notices table query
        $response=$this->db->select($selected_columns)
                ->from('consumables')
                ->join('users','consumables.user_id=users.user_id')
                ->get();
        
        return $response;
    }
    // --------------------------------------------------------------
    
    /**
     * Crea un consumible.
     *
     * @return  array Respuesta de la petición de creación.
     */
    
    public function create_consumable($consumable_data){
        
        $query=$this->db->insert('consumables',$consumable_data);
        if(empty($query)){

            $error=$this->db->error();
            $response=['error'=>error_array($error)];
        }
        else{
            
            $response['message']='Consumible Creado';
            $response['data']=$query;
        }
        
        return $response;
    }
    // --------------------------------------------------------------
    
    /**
     * Lee un consumible determinado.
     *
     * @return  array Atributos del producto.
     */
    public function read_consumable($c_id){
        
        $query=$this->db->get_where('consumables',['c_id'=>$c_id]);
        if(empty($query)){

            $error=$this->db->error();
            $response['status']='error';
            $response['error']=error_array($error);
        }
        else{
            
            $response['status']='success';
            $response['message']='Consumible Leido';
            $response['data']=$query->result_array();
        }
        
        return $response;
    }
    // --------------------------------------------------------------
    
    /**
    * Actualiza un producto.
    *
    * @return bool
    */
    public function update_consumable($update_data){
        
        $data=[
            'c_name'=>$update_data['c_name'],
            'c_img'=>$update_data['c_img']
        ];
        
        $this->db->where('c_id',$update_data['c_id']);
        $query=$this->db->update('consumables',$data);
        
        if(empty($query)){

            $error=$this->db->error();
            $response=['error'=>error_array($error)];
        }
        else{
            
            $response['message']='Consumible Actualizado';
            $response['data']=$query;
        }
        
        return $response;
    }
    // --------------------------------------------------------------
    
    /**
     * Elimina un consumible.
     *
     * @return  boolean .
     */
    public function delete_consumable($c_id){
        
        $query=$this->db->delete('consumables',['c_id'=>$c_id]);
        if(empty($query)){

            $error=$this->db->error();
            $response['status']='error';
            $response['error']=error_array($error);
        }
        else{
            $response['status']='success';
            $response['message']='Consumible Eliminado';
            $response['data']=$query;
        }
        return $response;
    }
    // --------------------------------------------------------------
}