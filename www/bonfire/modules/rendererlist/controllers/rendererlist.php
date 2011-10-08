<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class rendererlist extends Front_Controller {

	//--------------------------------------------------------------------

	public function __construct() 
	{
		parent::__construct();

		$this->load->library('form_validation');
		$this->load->model('rendererlist_model', null, true);
		$this->lang->load('rendererlist');
		
		
	}
	
	//--------------------------------------------------------------------

	/*
		Method: index()
		
		Displays a list of form data.
	*/
	public function index() 
	{
		$data = array();
		$data['records'] = $this->rendererlist_model->find_all();

		Assets::add_js($this->load->view('rendererlist/js', null, true), 'inline');
		
		Template::set('data', $data);
		Template::set('toolbar_title', "Manage rendererList");
		Template::render();
	}
	
	//--------------------------------------------------------------------



}