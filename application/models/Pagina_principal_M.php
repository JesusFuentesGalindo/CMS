<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pagina_principal_M extends My_Model{
    
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
     * Lee los avisos registrados en el sistema.
     *
     * @return  array Lista de avisos.
     */
    public function get_notices(){
        
        // Selected notice table data
        $selected_columns = [
            'n_id',
            'username',
            'n_name',
            'n_text',
            'n_text_position',
            'n_img',
            'n_text_color',
            'n_product'
        ];
        
        // Notices table query
        $response=$this->db->select($selected_columns)
                ->from('notices')
                ->join('users','notices.user_id=users.user_id')
                ->get();
        
        return $response;
    }
    // --------------------------------------------------------------
    
    /**
     * Lee un aviso determinado.
     *
     * @return  array Atributos del aviso.
     */
    public function read_notice($n_id){
        
        $query=$this->db->get_where('notices',['n_id'=>$n_id]);
        if(empty($query)){

            $error=$this->db->error();
            $response['status']='error';
            $response['error']=error_array($error);
        }
        else{
            
            $response['status']='success';
            $response['message']='Aviso Leido';
            $response['data']=$query->result_array();
        }
        
        return $response;
    }
    // --------------------------------------------------------------
    
    /**
     * Elimina un aviso.
     *
     * @return  boolean .
     */
    public function delete_notice($n_id){
        
        $query=$this->db->delete('notices',['n_id'=>$n_id]);
        if(empty($query)){

            $error=$this->db->error();
            $response['status']='error';
            $response['error']=error_array($error);
        }
        else{
            $response['status']='success';
            $response['message']='Aviso Eliminado';
            $response['data']=$query;
        }
        return $response;
    }
    // --------------------------------------------------------------
    
    /**
     * Crea un aviso.
     *
     * @return  array Respuesta de la petición de creación.
     */
    
    public function create_notice($notice_data){
        
        $query=$this->db->insert('notices',$notice_data);
        if(empty($query)){

            $error=$this->db->error();
            $response=['error'=>error_array($error)];
        }
        else{
            
            $response['message']='Aviso Creado';
            $response['data']=$query;
        }
        
        return $response;
    }
    // --------------------------------------------------------------
    
    /**
    * Actualiza un aviso.
    *
    * @return bool
    */
    public function update_notice($update_data){
        
        $data=[
            'n_name'=>$update_data['n_name'],
            'n_text'=>$update_data['n_text'],
            'n_text_position'=>$update_data['n_text_position'],
            'n_img'=>$update_data['n_img'],
            'n_text_color'=>$update_data['n_text_color'],
            'n_product'=>$update_data['n_product']
        ];
        
        $this->db->where('n_id',$update_data['n_id']);
        $query=$this->db->update('notices',$data);
        
        if(empty($query)){

            $error=$this->db->error();
            $response=['error'=>error_array($error)];
        }
        else{
            
            $response['message']='Aviso Actualizado';
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
        
        $selected_columns = [
                'b_id',
                'username',
                'b_name',
                'b_img'
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
            'b_img'=>$update_data['b_img']
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
    
    /**
     * Leer los productos.
     *
     * @return  array Atributos del producto.
     */
    public function get_products(){
        
        $query=$this->db->get('products');
        if(empty($query)){

            $error=$this->db->error();
            $response['status']='error';
            $response['error']=error_array($error);
        }
        else{
            
            $response['status']='success';
            $response['message']='Productos Leido';
            $response['data']=$query->result_array();
        }
        
        return $response;
    }
    // --------------------------------------------------------------
    
    /**
     * Leer los aplicaciones.
     *
     * @return  array Atributos del producto.
     */
    public function get_aplications(){
        
        $query=$this->db->get('aplications');
        if(empty($query)){

            $error=$this->db->error();
            $response['status']='error';
            $response['error']=error_array($error);
        }
        else{
            
            $response['status']='success';
            $response['message']='Aplicaciones Leido';
            $response['data']=$query->result_array();
        }
        
        return $response;
    }
    // --------------------------------------------------------------
    
    /**
     * Leer los consumibles.
     *
     * @return  array Atributos del producto.
     */
    public function get_consumables(){
        
        $query=$this->db->get('consumables');
        if(empty($query)){

            $error=$this->db->error();
            $response['status']='error';
            $response['error']=error_array($error);
        }
        else{
            
            $response['status']='success';
            $response['message']='Consumibles Leido';
            $response['data']=$query->result_array();
        }
        
        return $response;
    }
    // --------------------------------------------------------------
    
    /**
     * Leer los servicios.
     *
     * @return  array Atributos de los servicios.
     */
    public function get_services(){
        
        $query=$this->db->get('services');
        if(empty($query)){

            $error=$this->db->error();
            $response['status']='error';
            $response['error']=error_array($error);
        }
        else{
            
            $response['status']='success';
            $response['message']='Servicios Leidos';
            $response['data']=$query->result_array();
        }
        
        return $response;
    }
    // --------------------------------------------------------------
}
