<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Productos_M extends My_Model{
    
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
     * Lee los productos registrados en el sistema.
     *
     * @return  array Lista de productos.
     */
    public function get_products(){
        
        // Selected notice table data
        $selected_columns = [
                'p_id',
                'username',
                'p_name',
                'p_equipments',
                'p_offer',
                'p_img',
        ];
        
        // Notices table query
        $response=$this->db->select($selected_columns)
                ->from('products')
                ->join('users','products.user_id=users.user_id')
                ->get();
        
        return $response;
    }
    // --------------------------------------------------------------
    
    /**
     * Crea un aviso.
     *
     * @return  array Respuesta de la petición de creación.
     */
    
    public function create_product($product_data){
        
        $query=$this->db->insert('products',$product_data);
        if(empty($query)){

            $error=$this->db->error();
            $response=['error'=>error_array($error)];
        }
        else{
            
            $response['message']='Producto Creado';
            $response['data']=$query;
        }
        
        return $response;
    }
    // --------------------------------------------------------------
    
    /**
     * Lee un producto determinado.
     *
     * @return  array Atributos del producto.
     */
    public function read_product($p_id){
        
        $query=$this->db->get_where('products',['p_id'=>$p_id]);
        if(empty($query)){

            $error=$this->db->error();
            $response['status']='error';
            $response['error']=error_array($error);
        }
        else{
            
            $response['status']='success';
            $response['message']='Producto Leido';
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
    public function update_product($update_data){
        
        $data=[
            'p_name'=>$update_data['p_name'],
            'p_equipments'=>$update_data['p_equipments'],
            'p_offer'=>$update_data['p_offer'],
            'p_img'=>$update_data['p_img']
        ];
        
        $this->db->where('p_id',$update_data['p_id']);
        $query=$this->db->update('products',$data);
        
        if(empty($query)){

            $error=$this->db->error();
            $response=['error'=>error_array($error)];
        }
        else{
            
            $response['message']='Producto Actualizado';
            $response['data']=$query;
        }
        
        return $response;
    }
    // --------------------------------------------------------------
    
    /**
     * Elimina un producto.
     *
     * @return  boolean .
     */
    public function delete_product($p_id){
        
        $query=$this->db->delete('products',['p_id'=>$p_id]);
        if(empty($query)){

            $error=$this->db->error();
            $response['status']='error';
            $response['error']=error_array($error);
        }
        else{
            $response['status']='success';
            $response['message']='Producto Eliminado';
            $response['data']=$query;
        }
        return $response;
    }
    // --------------------------------------------------------------
}