<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class mapspecs extends Front_Controller {

	//--------------------------------------------------------------------

	public function __construct() 
	{
		parent::__construct();

		$this->load->library('form_validation');
		$this->load->model('mapspecs_model', null, true);
		$this->lang->load('mapspecs');
		
		
	}
	
	//--------------------------------------------------------------------

	/*
		Method: index()
		
		Displays a list of form data.
	*/
	public function index() 
	{
		$data = array();
		$data['records'] = $this->mapspecs_model->find_all();

		Assets::add_js($this->load->view('mapspecs/js', null, true), 'inline');
		
		Template::set('data', $data);
		Template::set('toolbar_title', "Manage MapSpecs");
		Template::render();
	}
	
	//--------------------------------------------------------------------



}