<?php

class gpxfiles extends CI_Controller {

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
		$this -> list_gpxfiles();
	}

	public function edit_gpxfile($id =null) {
		/**
		 * if $id is not null, we populate the form from the database
		 * and display it to the user.
		 * if $map_id is null, and POST data has been provided, we update the
		 *   gpxfile specified in the POST data with the supplied data.
		 * If $id is null and there is no POST data, we create a new gpxfile
		 * spec.
		 */
		$this -> load -> view('header_view');

		if($this -> input -> post('submit')) {
			foreach($_POST as $key => $value) {
				$post_data[$key] = $this -> input -> post($key);
			}
			$id = $this -> input -> post('id');
			$data = $post_data;
		} else {
			if($id == null) {
				$data = $this -> gpxfiles_model -> get_default_gpxfile();
			} else {
				$data = $this -> gpxfiles_model -> get_gpxfile_by_id($id);

			}
		}
		var_dump($data);
		$this -> load -> view('gpx_edit_gpxfile.php', $data);
		$this -> load -> view('footer_view');
	}

	public function list_gpxfiles() {
		$data['query'] = $this -> gpxfiles_model -> get_gpxfiles(); ;
		$this -> load -> view('header_view', $data);
		$this -> load -> view('gpx_list_gpxfiles', $data);

		$this -> load -> view('footer_view');

	}

}?>