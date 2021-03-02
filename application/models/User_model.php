<?php

class User_model extends CI_Model{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    
    public function register($enc_password){
        $data = array(
            'name' => $this->input->post('register_name'),
            'email' => $this->input->post('register_email'),
            'password' => $enc_password
        );

        $this->db->insert('users' , $data);
        return $this->db->insert_id();
    }

    public function login($email , $password){
        $this->db->select('id,name,password');
        $query = $this->db->get_where( 'users' , array('email'=>$email) );
        if (! empty( $query->row_array() ) ){
            $result = $query->row_array();
            if ( password_verify( $password , $result['password'] ) ){
                $data = array(
                    'user_id' => $result['id'],
                    'user_name' => $result['name'],
                    'user_email'=> $email
                );
                return $data;
            }
        }
     
        return false;
        
    }

    public function store_token($email,$token){
        $this->db->where('email',$email);
        $this->db->delete('password_resets');
        $data = [
            'email' => $email,
            'token' => $token
        ];
        return $this->db->insert('password_resets' , $data);
    }
    
    public function verify_token($email,$token){
        $this->db->select('token');
        $this->db->where('email',$email);
        $this->db->where('now()-expires <',900);
        $query = $this->db->get('password_resets');
        if (! empty($query->row_array()) ){
            $result = $query->row_array();
            if ( $result['token'] == $token ){
                return true;
            }   
        }
        return false;
    }

    public function update_password($email,$new_password){
        $data = array( 
            'password' => $new_password
        );
        $this->db->where('email', $email);
        return $this->db->update('users', $data);
    }

    public function check_email_exists($email)
    {
        $query = $this->db->get_where('users' , array('email'=>$email));
        if ( empty( $query->row_array() ) ){
            return true;
        }
        return false;
        
    }

    public function check_password_real($id,$password)
    {
        $this->db->select('password');
        $query = $this->db->get_where( 'users' , array('id'=>$id) );
        if (! empty( $query->row_array() ) ){
            $result = $query->row_array();
            if ( password_verify( $password , $result['password'] ) )
                return true;
        }
     
        return false;
    }

    public function delete_last()
    {
        $this->db->query('delete from users where id = ( select id from users order by id desc limit 1);');
    }

    public function get_user($id)
    {
        $query = $this->db->get_where('users' , array('id' => $id) );
        $result = $query->row_array();
        return $result;
    }

    public function update_user($id , $name,$email)
    {
        $data = array( 
            'name' => $name , 
            'email' => $email 
        );
        $this->db->where('id' , $id);
        $this->db->update('users' , $data);
    }

    public function insert_img($user_id , $img)
    {
        $this->db->where('id' , $user_id);
        $this->db->update('users' , array('user_img'=>$img));
    }

    public function get_user_img($id)
    {
        $this->db->select('user_img');
        $query = $this->db->get_where('users' , array('id'=>$id));
        $result = $query->row_array();
        return $result['user_img'];
    }
}
