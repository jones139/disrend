<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class gpxfiles extends Front_Controller {

	//--------------------------------------------------------------------

	public function __construct() 
	{
		parent::__construct();

		$this->load->library('form_validation');
		$this->load->model('gpxfiles_model', null, true);
		$this->lang->load('gpxfiles');
		
		
		$this->load->model('activities/Activity_model', 'activity_model', true);
		// Auth setup
		$this->load->model('users/User_model', 'user_model');
		$this->load->library('users/auth');
		$this->load->model('permissions/permission_model');
		$this->load->model('roles/role_permission_model');
		$this->load->model('roles/role_model');


		Assets::add_js($this->load->view('gpxfiles/js', null, true), 'inline');
		
		
	}
	
	//--------------------------------------------------------------------

	/*
		Method: index()
		
		Displays a list of form data.
	*/
	public function index() 
	{
	  Template::set_theme('maps3');
		$data = array();
		$data['records'] = $this->gpxfiles_model->find_all();

		Template::set('data', $data);
		Template::set('toolbar_title', "Manage gpxFiles");
		Template::render();
	}
	
	//--------------------------------------------------------------------

	/*
		Method: create()
		
		Creates a gpxFiles object.
	*/
	public function create() 
	{
		$this->auth->restrict();

		if ($this->input->post('submit'))
		{
			if ($insert_id = $this->save_gpxfiles())
			{
				// Log the activity
				$this->activity_model->log_activity($this->auth->user_id(), lang('gpxfiles_act_create_record').': ' . $insert_id . ' : ' . $this->input->ip_address(), 'gpxfiles');
					
				Template::set_message(lang("gpxfiles_create_success"), 'success');
				Template::redirect(SITE_AREA .'/gpxfiles/gpxfiles');
			}
			else 
			{
				Template::set_message(lang('gpxfiles_create_failure') . $this->gpxfiles_model->error, 'error');
			}
		}
	
		Template::set('toolbar_title', lang('gpxfiles_create_new_button'));
		Template::set('toolbar_title', lang('gpxfiles_create') . ' gpxFiles');
		Template::render();
	}
	
	//--------------------------------------------------------------------

	/*
		Method: edit()
		
		Allows editing of gpxFiles data.
	*/
	public function edit() 
	{
		$this->auth->restrict();

		$id = (int)$this->uri->segment(5);
		
		if (empty($id))
		{
			Template::set_message(lang('gpxfiles_invalid_id'), 'error');
			redirect(SITE_AREA .'/gpxfiles/gpxfiles');
		}
	
		if ($this->input->post('submit'))
		{
			if ($this->save_gpxfiles('update', $id))
			{
				// Log the activity
				$this->activity_model->log_activity($this->auth->user_id(), lang('gpxfiles_act_edit_record').': ' . $id . ' : ' . $this->input->ip_address(), 'gpxfiles');
					
				Template::set_message(lang('gpxfiles_edit_success'), 'success');
			}
			else 
			{
				Template::set_message(lang('gpxfiles_edit_failure') . $this->gpxfiles_model->error, 'error');
			}
		}
		
		Template::set('gpxfiles', $this->gpxfiles_model->find($id));
	
		Template::set('toolbar_title', lang('gpxfiles_edit_heading'));
		Template::set('toolbar_title', lang('gpxfiles_edit') . ' gpxFiles');
		Template::render();		
	}
	
	//--------------------------------------------------------------------

	/*
		Method: delete()
		
		Allows deleting of gpxFiles data.
	*/
	public function delete() 
	{	
	  $this->auth->restrict();

		$id = $this->uri->segment(5);
	
		if (!empty($id))
		{	
			if ($this->gpxfiles_model->delete($id))
			{
				// Log the activity
				$this->activity_model->log_activity($this->auth->user_id(), lang('gpxfiles_act_delete_record').': ' . $id . ' : ' . $this->input->ip_address(), 'gpxfiles');
					
				Template::set_message(lang('gpxfiles_delete_success'), 'success');
			} else
			{
				Template::set_message(lang('gpxfiles_delete_failure') . $this->gpxfiles_model->error, 'error');
			}
		}
		
		redirect(SITE_AREA .'/gpxfiles/gpxfiles');
	}
	
	//--------------------------------------------------------------------


	public function get_gpxfile($id) {
		/**
		 * returns the contents of GPX file id number $id.
		 * If ?ajax=TRUE is included on the URL, it will return the GPX file ID, description and contents
		 * as a JSON string.
		 */
		$query = $this -> gpxfiles_model -> get_gpxfile($id);
		if($this -> input -> get('ajax')) {
			echo json_encode($query);
		} else
			echo $query['GPXFile'];
	}

	public function get_gpxfile_desc($id) {
		$query = $this -> gpxfiles_model -> get_gpxfile($id);
		echo $query['description'];

	}

	public function upload() {
		#$data['data']='data';

		$this->auth->restrict();
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
		      #$viewdata = array('main_content' => 'gpx_upload_success', 'data' => $data);
		      #$this -> load -> view('include/site_template', $viewdata);
		      $data = array('title' => 'Success!', 'msg' => "File Upload Successful.");
		      $viewdata = array('main_content' => 'message_view', 'data' => $data);
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
	














	//--------------------------------------------------------------------
	// !PRIVATE METHODS
	//--------------------------------------------------------------------
	
	/*
		Method: save_gpxfiles()
		
		Does the actual validation and saving of form data.
		
		Parameters:
			$type	- Either "insert" or "update"
			$id		- The ID of the record to update. Not needed for inserts.
		
		Returns:
			An INT id for successful inserts. If updating, returns TRUE on success.
			Otherwise, returns FALSE.
	*/
	private function save_gpxfiles($type='insert', $id=0) 
	{	
					
$this->form_validation->set_rules('gpxfiles_userId','User ID','max_length[4]');			
$this->form_validation->set_rules('gpxfiles_description','Description','max_length[512]');			
$this->form_validation->set_rules('gpxfiles_gpxfile','GPXFile','');

		if ($this->form_validation->run() === FALSE)
		{
			return FALSE;
		}
		
		if ($type == 'insert')
		{
			$id = $this->gpxfiles_model->insert($_POST);
			
			if (is_numeric($id))
			{
				$return = $id;
			} else
			{
				$return = FALSE;
			}
		}
		else if ($type == 'update')
		{
			$return = $this->gpxfiles_model->update($id, $_POST);
		}
		
		return $return;
	}

	//--------------------------------------------------------------------



}