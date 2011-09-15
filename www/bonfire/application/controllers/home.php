<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home extends Front_Controller {

	//--------------------------------------------------------------------
	
	public function __construct() 
	{
	  // This is most of the intialisation code for Authenticated_Controller,
	  // but it does not require log in, just allows it.

	  parent::__construct();
		
	  $this->load->database();
	  $this->load->library('session');
	  
	  $this->load->model('activities/Activity_model', 'activity_model', true);
	  
	  // Auth setup
	  $this->load->model('users/User_model', 'user_model');
	  $this->load->library('users/auth');
	  $this->load->model('permissions/permission_model');
	  $this->load->model('roles/role_permission_model');
	  $this->load->model('roles/role_model');
		
	  
	  // Load additional libraries
	  $this->load->helper('form');
	  $this->load->library('form_validation');
	  $this->form_validation->CI =& $this;	// Hack to make it work properly with HMVC
	}

	public function index() 
	{	
	  Template::set_theme('active_theme', 'maps3');
	  Template::render();
	}
	
	//--------------------------------------------------------------------
	

}