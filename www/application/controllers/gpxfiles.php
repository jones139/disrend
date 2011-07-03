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
		$this -> load -> view('header_view');

		if($this -> input -> post('submit')) {
			foreach($_POST as $key => $value) {
				$post_data[$key] = $this -> input -> post($key);
			}
			$id = $this -> input -> post('id');
			$data = $post_data;
			$this-> gpxfiles_model -> update_gpxfile(
				$data['id'],
				$data['userId'],
				$data['description'],
				$data['GPXFile']);
				$data['query'] = $this -> gpxfiles_model -> get_gpxfiles();
				$this -> load -> view('gpx_list_gpxfiles.php', $data);
		} else {
			if($id == null) {
				$data = $this -> gpxfiles_model -> get_default_gpxfile();
       			$data['userId'] = $this->session->userdata('user_id');
				$data['uname']= $this->users_model -> get_uname_by_id($data['userId']);
			} else {
				$data = $this -> gpxfiles_model -> get_gpxfile($id);
				if (isset($data['userId'])) {
					$data['uname']= $this->users_model -> get_username_by_id($data['userId']);
					$this->load->view('gpx_edit_gpxfile',$data);
				}
				else {
					echo "Error - userId does not exist....";
					redirect($this->list_gpxfiles());
				}
			}
			#var_dump($data);
		}
		#var_dump($data);
		$this -> load -> view('footer_view');
	}

	public function list_gpxfiles() {
		$data['query'] = $this -> gpxfiles_model -> get_gpxfiles();
		$this -> load -> view('header_view', $data);
		$this -> load -> view('gpx_list_gpxfiles', $data);

		$this -> load -> view('footer_view');

	}
	
	public function get_gpxfile($id) {
		$query = $this -> gpxfiles_model -> get_gpxfile($id);
		echo $query['GPXFile'];
	}
	
	public function upload() {
	    $data['data']='data';
		var_dump($_POST);
		$this -> load -> view('header_view', $data);
		if($this -> input -> post('submit')) {
			echo "processing submit data.";
			foreach($_POST as $key => $value) {
				$post_data[$key] = $this -> input -> post($key);
			}

			$config['upload_path'] = './application/media/gpx';
			$config['allowed_types'] = '*';
			$config['max_size']	= 0;
			$this->load->library('upload');
			
			$this->upload->initialize($config);

			if ( ! $this->upload->do_upload())
			{
				echo "error uploading file";
				echo $this->upload->display_errors();
				$error = array('error' => $this->upload->display_errors());
				$this->load->view('gpx_upload_form', $error);
			}
			else
			{
				echo "file upload success";
				$data = array('upload_data' => $this->upload->data());
				$gpx = file_get_contents($data['upload_data']['full_path']);
				$data['gpx'] = $gpx;
				if ($gpx != NULL) {
					if ($this->session->userdata('logged_in')==1) {
			  			$userId=$this->session->userdata('user_id');
					} else {
						$userId = 0;
					}
					$desc=$this -> input -> post('description');
					$this->gpxfiles_model->add_gpxfile($userId,$desc,$gpx);
				    $this->load->view('gpx_upload_success', $data);
				}
				else {
					$error['error']="Failed to read file contents";
					$this->load->view('gpx_upload_form',$error);
				}
			}
			#$data['data']='data';
			#$this -> load -> view('gpx_upload_success', $data);
		}
		else {
			echo "no submit data - showing form....";
			$data['error']='no error';
			$this -> load -> view('gpx_upload_form', $data);
		}

		$this -> load -> view('footer_view');
	}

}?>