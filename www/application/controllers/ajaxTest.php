<?php

class ajaxTest extends CI_Controller {

	public function __construct() {
		parent::__construct();
		// Your own constructor code
		$this -> load -> library('session');
		$this -> load -> library('form_validation', 'input');
		$this -> load -> helper('url');
		$this -> load -> helper('form');
		$this -> load -> database();
		$this -> load -> model('gpxfiles_model');
		$this -> load -> model('users_model');
	}

	function index() {
		$data = array('title' => 'AjaxTest', 'msg' => "ajaxTest");
		$viewdata = array('main_content' => 'ajaxTest', 'data' => $data);
		$this -> load -> view('include/site_template', $viewdata);

	}

}
?>