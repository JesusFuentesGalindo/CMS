<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Aplicaciones_M extends My_Model{
    
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
     * Lee las aplicaciones registradas en el sistema.
     *
     * @return  array Lista de aplicaciones.
     */
    public function read_aplications(){
        
        // Selected aplication table data
        $selected_columns = [
                'a_id',
                'username',
                'a_name',
                'a_description',
                'a_img',
        ];
        
        // aplication table query
        $response=$this->db->select($selected_columns)
                ->from('aplications')
                ->join('users','aplications.user_id=users.user_id')
                ->get();
        
        return $response;
    }
    // --------------------------------------------------------------
    
    /**
     * Crea una aplicación.
     *
     * @return  array Respuesta de la petición de creación.
     */
    
    public function create_aplication($aplication_data){
        
        $query=$this->db->insert('aplications',$aplication_data);
        if(empty($query)){

            $error=$this->db->error();
            $response=['error'=>error_array($error)];
        }
        else{
            
            $response['message']='Aplicación Creada';
            $response['data']=$query;
        }
        
        return $response;
    }
    // --------------------------------------------------------------
    
    /**
     * Lee una aplicación determinada.
     *
     * @return  array Atributos de la aplicación.
     */
    public function read_aplication($a_id){
        
        $query=$this->db->get_where('aplications',['a_id'=>$a_id]);
        if(empty($query)){

            $error=$this->db->error();
            $response['status']='error';
            $response['error']=error_array($error);
        }
        else{
            
            $response['status']='success';
            $response['message']='Aplicación Leida';
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
    public function update_aplication($update_data){
        
        $data=[
            'a_name'=>$update_data['a_name'],
            'a_description'=>$update_data['a_description'],
            'a_img'=>$update_data['a_img']
        ];
        
        $this->db->where('a_id',$update_data['a_id']);
        $query=$this->db->update('aplications',$data);
        
        if(empty($query)){

            $error=$this->db->error();
            $response=['error'=>error_array($error)];
        }
        else{
            
            $response['message']='Aplicación Actualizada';
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
    public function delete_aplication($a_id){
        
        $query=$this->db->delete('aplications',['a_id'=>$a_id]);
        if(empty($query)){

            $error=$this->db->error();
            $response['status']='error';
            $response['error']=error_array($error);
        }
        else{
            $response['status']='success';
            $response['message']='Aplicación Eliminada';
            $response['data']=$query;
        }
        return $response;
    }
    // --------------------------------------------------------------
    
    /**
     * Lee las aplicaciones registradas en el sistema.
     *
     * @return  array Lista de aplicaciones.
     */
    public function read_equipments(){
        
        // Selected aplication table data
        $selected_columns=[
                'pa_id',
                'a_name',
                'aplications.a_id',
                'pa_name'
        ];
        
        // aplication table query
        $response=$this->db->select($selected_columns)
                ->from('product_aplication')
                ->join('aplications','aplications.a_id=product_aplication.a_id')
                ->get();
        
        return $response;
    }
    // --------------------------------------------------------------
    
    /**
     * Ligar un equipo.
     *
     * @return  array Respuesta de la petición de creación.
     */
    
    public function link_equipment($equipment_data){
        
        $query=$this->db->insert('product_aplication',$equipment_data);
        if(empty($query)){

            $error=$this->db->error();
            $response=['error'=>error_array($error)];
        }
        else{
            
            $response['message']='Equipo ligado';
            $response['data']=$query;
        }
        
        return $response;
    }
    // --------------------------------------------------------------
    
    /**
     * Lee un equipo determinado.
     *
     * @return  array Atributos del equipo.
     */
    public function read_equipment($pa_id){
        
        $query=$this->db->get_where('product_aplication',['pa_id'=>$pa_id]);
        if(empty($query)){

            $error=$this->db->error();
            $response['status']='error';
            $response['error']=error_array($error);
        }
        else{
            
            $response['status']='success';
            $response['message']='Equipo Leido';
            $response['data']=$query->result_array();
        }
        
        return $response;
    }
    // --------------------------------------------------------------
    
    /**
    * Actualiza un equipo.
    *
    * @return bool
    */
    public function update_equipment($update_data){
        
        $data=[
            'a_id'=>$update_data['a_id'],
            'pa_name'=>$update_data['pa_name'],
        ];
        
        $this->db->where('pa_id',$update_data['pa_id']);
        $query=$this->db->update('product_aplication',$data);
        
        if(empty($query)){

            $error=$this->db->error();
            $response=['error'=>error_array($error)];
        }
        else{
            
            $response['message']='Equipo Actualizado';
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
    public function delete_equipment($pa_id){
        
        $query=$this->db->delete('product_aplication',['pa_id'=>$pa_id]);
        if(empty($query)){

            $error=$this->db->error();
            $response['status']='error';
            $response['error']=error_array($error);
        }
        else{
            $response['status']='success';
            $response['message']='Equipo Eliminado';
            $response['data']=$query;
        }
        return $response;
    }
    // --------------------------------------------------------------
}