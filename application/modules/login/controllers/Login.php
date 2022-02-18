<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MY_Controller {
	 public function __construct(){
            parent::__construct();
            $user_id=$this->session->userdata('user_id');
            $this->load->model('common_model','mcommon');
            $this->load->helper(array('url'));
		    $this->load->helper(array('form'));
		    $this->load->library('session');
		    $this->load->library('form_validation');
           
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
		if($this->session->userdata('logged_in'))
            {  
		redirect('dashboard');
			}
			else {
		if(isset($_POST['save']))
		{
          $email=$this->input->post('email');

		  $password=$this->input->post('password');
		  $query=$this->db->query("select * from user where email='$email' and password='$password'");
		 
		if($query->num_rows()==1)
		{
			$row=$query->row();
			
				$data = array( 
				'user_id'=>$row->user_id,
				'first_name'=>$row->first_name,
				'last_name'=>$row->last_name,
                'username'  => $row->username,
                'email'  => $row->email,
                'password'  => $row->password,
                'is_deleted'  => $row->is_deleted,
                'is_admin'  => $row->is_admin,
                'is_user_activated'  => $row->is_user_activated,
                'logged_in' => TRUE
                  );  

			$this->session->set_userdata($data);
			redirect('dashboard',$data);
		}
		  
		}
	
$this->load->view('login');
}
	}
	public function welcome()
	{
		
		
		
	}
}
