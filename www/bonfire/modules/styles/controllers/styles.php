<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class styles extends Front_Controller {

	//--------------------------------------------------------------------

	public function __construct() 
	{
		parent::__construct();

		$this->load->library('form_validation');
		$this->load->model('styles_model', null, true);
		$this->lang->load('styles');
		
		
	}
	
	//--------------------------------------------------------------------

	/*
		Method: index()
		
		Displays a list of form data.
	*/
	public function index() 
	{
		$data = array();
		$data['records'] = $this->styles_model->find_all();

		Template::set('data', $data);
		Template::render();
	}
	
	//--------------------------------------------------------------------



}