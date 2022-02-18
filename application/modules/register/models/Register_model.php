<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model 
{
    public function login($email,$password){
        $this->db->select("*");
        $this->db->from("user");
        $this->db->where("email",$email);
        $this->db->where("password",$password);
        
        
        $query=$this->db->get();
        if ($query->num_rows() == 0){
            return false;
        }
       else{
        return $query; 
       }

        
    }
    
    public function add_user($data){
        $this->db->insert('user', $data);
        return true;
    }

    public function get_all_users(){
        $query = $this->db->get('user');
        return $result = $query->result_array();
    }

    public function get_user_by_id($id){
        $query = $this->db->get_where('user', array('id' => $id));
        return $result = $query->row_array();
    }

    public function edit_user($data, $id){
        $this->db->where('id', $id);
        $this->db->update('user', $data);
        return true;
    }

    public function get_user_login_data($user_email = "", $user_password = "")
	{
		try {
			if (!empty($user_email) && !empty($user_password)) {
				$user_password = md5($user_password);
				$query = $this->db->select('*')
					->from('user')
					->where('email', $user_email)
					->where('password', $user_password)
					->where('is_user_activated', 1)
					->where('is_deleted', 0)
					->where('is_email_blacklisted', 0)
					->get();

				if ($query->num_rows() > 0) {
					return $query->row_array();
				}
			}
		} catch (Exception $e) {
			log_message('error', $e->getMessage());
		}

		return false;
	}

    public function check_user_login_credentials($user_email = "", $user_password = "")
	{
		try {
           
			if (!empty($user_email) && !empty($user_password)) {
				$user_password = md5($user_password);
				$query = $this->db->select('email,password')
					->from('user')
					->where('email', $user_email)
					->where('password', $user_password)
                    ->where("(is_transaction_admin='1' OR is_super_admin='1' OR is_admin='1')", NULL, FALSE)
                    ->where('is_deleted', 0)
					->get();

				if ($query->num_rows() > 0) {
					return $query->row_array();
				}
			}
		} catch (Exception $e) {
			log_message('error', $e->getMessage());
		}

		return false;
	}
}
?>