<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends MY_Controller {
	 public function __construct(){
            parent::__construct();
            $user_id=$this->session->userdata('user_id');
            $this->load->model('common_model','mcommon');
           $this->load->library('session');
           
        }

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$data["get_user_details"]= $this->mcommon->specific_row("user", array("user_id"=>$this->session->userdata('user_id')));
		$this->load->view('profile',$data);
	}
	public function index()
	{
		$name=$this->input->post('first_name');
          $mobile_number=$this->input->post('mobile_number');
          $email=$this->input->post('email');
		  $password=$this->input->post('password');
          $get_email= $this->mcommon->specific_record_counts("user", array("email"=>$email));
          $get_mobile_number= $this->mcommon->specific_record_counts("user", array("mobile_number"=>$mobile_number));
          
          if($get_email=='1')
           {
		 $this->session->set_flashdata('email-error','Already used this email id'); 
		  
           }
           if($get_mobile_number=='1')
           {
       $this->session->set_flashdata('mobile-error','Already used this mobile number');
           }
           else
           {
           	$data=array(
           "first_name" => $name,
           "email" => $email,
           "password" => $password, 
           "mobile_number" => $mobile_number,
           "username" => $name,
           
          	
            );
		  $update_profile=$this->mcommon->common_edit('user', $data, array("user_id"=>$user_id));
           }
		$data["get_user_details"]= $this->mcommon->specific_row("user", array("user_id"=>$this->session->userdata('user_id')));

		$this->load->view('update_profile',$data);
	}
	
}
