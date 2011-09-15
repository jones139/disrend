<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class gpxfiles extends Front_Controller {

	//--------------------------------------------------------------------

	public function __construct() 
	{
		parent::__construct();

		$this->load->library('form_validation');
		$this->load->model('gpxfiles_model', null, true);
		$this->lang->load('gpxfiles');
		
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
		$this->auth->restrict('GpxFiles.Gpxfiles.Create');

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
		$this->auth->restrict('GpxFiles.Gpxfiles.Edit');

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
		$this->auth->restrict('GpxFiles.Gpxfiles.Delete');

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