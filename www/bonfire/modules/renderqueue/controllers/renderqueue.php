<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class renderqueue extends Front_Controller {

	//--------------------------------------------------------------------

	public function __construct() 
	{
		parent::__construct();

		$this->load->library('form_validation');
		$this->load->model('renderqueue_model', null, true);
		$this->lang->load('renderqueue');
		
		
			Assets::add_css('flick/jquery-ui-1.8.13.custom.css');
			Assets::add_js('jquery-ui-1.8.8.min.js');
	}
	
	//--------------------------------------------------------------------

	/*
		Method: index()
		
		Displays a list of form data.
	*/
	public function index() 
	{
		$data = array();
		$data['records'] = $this->renderqueue_model->find_all();

		Assets::add_js($this->load->view('renderqueue/js', null, true), 'inline');
		
		Template::set('data', $data);
		Template::set('toolbar_title', "Manage renderQueue");
		Template::render();
	}
	
	//--------------------------------------------------------------------



}