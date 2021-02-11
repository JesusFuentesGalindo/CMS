<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class GestorUsuarios_M extends My_Model{
    
    /**
     * Get an unused ID for user creation
     *
     * @return  int between 1200 and 4294967295
     */
    public function get_unused_id(){
        
        // Create a random user id between 1200 and 4294967295
        $random_unique_int = 2147483648 + mt_rand( -2147482448, 2147483647 );

        // Make sure the random user_id isn't already in use
        $query = $this->db->where( 'user_id', $random_unique_int )
            ->get_where( $this->db_table('user_table') );

        if( $query->num_rows() > 0 )
        {
            $query->free_result();

            // If the random user_id is already in use, try again
            return $this->get_unused_id();
        }

        return $random_unique_int;
    }

    // --------------------------------------------------------------
    
    /**
     * Lee los usuarios registrados en el sistema.
     *
     * @return  array Lista de usuarios.
     */
    public function get_users(){
        
        $response=false;
        
        // Selected user table data
        $selected_columns = [
                'username',
                'email',
                'auth_level',
                'passwd',
                'user_id',
                'banned'
        ];
        
        // User table query
        $query = $this->db->select( $selected_columns )
                ->from('users')
                ->get();
        
        if($query->num_rows()>0){
            foreach($query->result_array() as $user){
                $profile=$this->add_profile_data($user);
                $response[]= array_merge( $user, $profile );
            }
        }
        
        return $response;
    }
    
    public function add_profile_data($auth_data){
        if($auth_data['auth_level']=='9'){
        
            // Selected profile data
            $selected_columns = array(
                'first_name',
                'last_name',
                'photo'
            );
 
            $query = $this->db->select( $selected_columns )
              ->from('profile')
              ->where( 'user_id', $auth_data['user_id'] )
              ->limit(1)
              ->get();
 
            if($query->num_rows()==1){
                foreach($query->row_array() as $k=>$v){
                  $auth_data[$k]=$v;
                }
            } 
        }
 
        return $auth_data;
    }
    // --------------------------------------------------------------
    
    /**
     * Eliminar usuario.
     *
     * @return  boolean .
     */
    
    public function delete_user($user_id){
        
        $respose=$this->db->delete('users',['user_id'=>$user_id]);
        return $respose;
    }
    // --------------------------------------------------------------
    
    /**
     * Crea el perfil de usuario.
     *
     * @return  array Lista de usuarios.
     */
    
    public function create_profile($user_profile){
        
        $user_id=$user_profile['user_id'];
        $first_name=$user_profile['first_name'];
        $last_name=$user_profile['last_name'];
        $photo=$user_profile['photo'];
        
        $respose=$this->db->insert('profile',[
                'user_id'=>$user_id,
                'first_name'=>$first_name,
                'last_name'=>$last_name,
                'photo'=>$photo
            ]);
        return $respose;
    }
    // --------------------------------------------------------------
    
    /**
	 * Update a user record with data not from POST
	 *
	 * @param  int     the user ID to update
	 * @param  array   the data to update in the user table
	 * @return bool
	 */
	public function update_user_raw_data( $user ){
            
            $response=true;
            
            if($user['passwd']!=''){
                $this->db->where('user_id',$user['user_id'] )
                    ->update($this->db_table('user_table'),['passwd' => $this->authentication->hash_passwd($user['passwd'])]);
            }
            
            if(isset($user['photo'])){
                
                $profile_data=['photo'=>$user['photo']];
                $response=$this->db->where('user_id', $user['user_id'])
                    ->update( $this->db_table('profile_table'), $profile_data );
            }
            
            $user_data=[
                'username'=>$user['username'],
                'email'=>$user['email'],
            ];
            
            $response=$this->db->where('user_id', $user['user_id'])
                    ->update( $this->db_table('user_table'), $user_data );
            
            return $response;
	}
        // --------------------------------------------------------------
}
