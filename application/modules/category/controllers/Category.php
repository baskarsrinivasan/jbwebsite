<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends MY_Controller {
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
		 if(!$this->session->userdata('logged_in'))
            {  
		redirect('login');
			}
			else{
				$this->load->view('register');
			}
		
	


	}
	public function welcome()
	{
		
		
		
	}
}
