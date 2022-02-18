<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile_model extends CI_Model 
{
    
    
    
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