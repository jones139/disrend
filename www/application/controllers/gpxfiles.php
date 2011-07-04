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

	public function edit($id =null) {
		/**
		 * if $id is not null, we populate the form from the database
		 * and display it to the user.
		 * if $map_id is null, and POST data has been provided, we update the
		 *   gpxfile specified in the POST data with the supplied data.
		 * If $id is null and there is no POST data, we create a new gpxfile
		 * spec.
		 */
		#		$this -> load -> view('header_view');
		if (isset($id)) {
			$gpxfile = $this -> gpxfiles_model -> get_gpxfile($id);
			$file_user_id = $gpxfile['userId'];
			$file_uname = $this -> users_model -> get_username_by_id($file_user_id);
		} else
			$file_uname = null;

		if(!$this -> users_model -> isValidNamedUser($file_uname) && 
			!$this -> users_model -> isValidAdmin()) {
			$data = array('title' => 'Error', 'msg' => "You must be logged in as the owner of the file, or as an Administrator to edit a file.");
			$viewdata = array('main_content' => 'message_view', 'data' => $data);
			$this -> load -> view('include/site_template', $viewdata);

		} else {
			if($this -> input -> post('submit')) {
				foreach($_POST as $key => $value) {
					$post_data[$key] = $this -> input -> post($key);
				}
				$id = $this -> input -> post('id');
				$data = $post_data;
				$this -> gpxfiles_model -> update_gpxfile($data['id'], $data['userId'], $data['description'], $data['GPXFile']);
				$data['query'] = $this -> gpxfiles_model -> get_gpxfiles();
				$viewdata = array('data' => $data, 'main_content' => 'gpx_list_gpxfiles');
				$this -> load -> view('include/site_template', $viewdata);
			} else {
				if($id == null) {
					$data = $this -> gpxfiles_model -> get_default_gpxfile();
					$data['userId'] = $this -> session -> userdata('user_id');
					$data['uname'] = $this -> users_model -> get_uname_by_id($data['userId']);
				} else {
					$data = $this -> gpxfiles_model -> get_gpxfile($id);
					if(isset($data['userId'])) {
						$data['uname'] = $this -> users_model -> get_username_by_id($data['userId']);
						$viewdata = array('data' => $data, 'main_content' => 'gpx_edit_gpxfile');
						$this -> load -> view('include/site_template', $viewdata);
					} else {
						#echo "Error - userId does not exist....";
						$data = array('title' => 'Error', 'msg' => "Invalid GPX File ID");
						$viewdata = array('main_content' => 'message_view', 'data' => $data);
						$this -> load -> view('include/site_template', $viewdata);
					}
				}
				#var_dump($data);
			}
			#var_dump($data);
			#		$this -> load -> view('footer_view');
		}
	}

	public function list_gpxfiles() {
		$data['query'] = $this -> gpxfiles_model -> get_gpxfiles();
		$viewdata = array('main_content' => 'gpx_list_gpxfiles', 'data' => $data);
		$this -> load -> view('include/site_template', $viewdata);
	}

	public function get_gpxfile($id) {
		$query = $this -> gpxfiles_model -> get_gpxfile($id);
		echo $query['GPXFile'];
	}

	public function upload() {
		#$data['data']='data';

		if(!$this -> users_model -> isValidUser()) {
			#var_dump($this->session->userdata('uname'));
			$data = array('title' => 'Error', 'msg' => "Please log in to upload a file.");
			$viewdata = array('main_content' => 'message_view', 'data' => $data);
			$this -> load -> view('include/site_template', $viewdata);
		} else {
			#var_dump($_POST);
			if($this -> input -> post('submit')) {
				#echo "processing submit data.";
				foreach($_POST as $key => $value) {
					$post_data[$key] = $this -> input -> post($key);
				}

				$config['upload_path'] = './application/media/gpx';
				$config['allowed_types'] = '*';
				$config['max_size'] = 0;
				$this -> load -> library('upload');

				$this -> upload -> initialize($config);

				if(!$this -> upload -> do_upload()) {
					echo "error uploading file";
					echo $this -> upload -> display_errors();
					$error = array('error' => $this -> upload -> display_errors());
					$viewdata = array('main_content' => 'gpx_upload_form', 'data' => $error);
					$this -> load -> view('include/site_template', $viewdata);
				} else {
					#echo "file upload success";
					$data = array('upload_data' => $this -> upload -> data());
					$gpx = file_get_contents($data['upload_data']['full_path']);
					$data['gpx'] = $gpx;
					if($gpx != NULL) {
						if($this -> session -> userdata('logged_in') == 1) {
							$userId = $this -> session -> userdata('user_id');
						} else {
							$userId = 0;
						}
						$desc = $this -> input -> post('description');
						$this -> gpxfiles_model -> add_gpxfile($userId, $desc, $gpx);
						$viewdata = array('main_content' => 'gpx_upload_success', 'data' => $data);
						$this -> load -> view('include/site_template', $viewdata);
					} else {
						$error['error'] = "Failed to read file contents";
						$viewdata = array('main_content' => 'gpx_upload_form', 'data' => $error);
						$this -> load -> view('include/site_template', $viewdata);
					}
				}
				#$data['data']='data';
				#$this -> load -> view('gpx_upload_success', $data);
			} else {
				#echo "no submit data - showing form....";
				$data['error'] = 'no error';
				$viewdata = array('main_content' => 'gpx_upload_form', 'data', $data);
				$this -> load -> view('include/site_template', $viewdata);
			}
		}
	}

}?>