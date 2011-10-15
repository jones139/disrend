<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class content extends Admin_Controller {

	//--------------------------------------------------------------------

	public function __construct() 
	{
		parent::__construct();

		$this->auth->restrict('Status.Content.View');
		$this->load->model('status_model', null, true);
		$this->lang->load('status');
		
		
	}
	
	//--------------------------------------------------------------------

	/*
		Method: index()
		
		Displays a list of form data.
	*/
	public function index() 
	{
		$data = array();
		$data['records'] = $this->status_model->find_all();

		Assets::add_js($this->load->view('content/js', null, true), 'inline');
		
		Template::set('data', $data);
		Template::set('toolbar_title', "Manage Status");
		Template::render();
	}
	
	//--------------------------------------------------------------------

	/*
		Method: create()
		
		Creates a Status object.
	*/
	public function create() 
	{
		$this->auth->restrict('Status.Content.Create');

		if ($this->input->post('submit'))
		{
			if ($insert_id = $this->save_status())
			{
				// Log the activity
				$this->activity_model->log_activity($this->auth->user_id(), lang('status_act_create_record').': ' . $insert_id . ' : ' . $this->input->ip_address(), 'status');
					
				Template::set_message(lang("status_create_success"), 'success');
				Template::redirect(SITE_AREA .'/content/status');
			}
			else 
			{
				Template::set_message(lang('status_create_failure') . $this->status_model->error, 'error');
			}
		}
	
		Template::set('toolbar_title', lang('status_create_new_button'));
		Template::set('toolbar_title', lang('status_create') . ' Status');
		Template::render();
	}
	
	//--------------------------------------------------------------------

	/*
		Method: edit()
		
		Allows editing of Status data.
	*/
	public function edit() 
	{
		$this->auth->restrict('Status.Content.Edit');

		$id = (int)$this->uri->segment(5);
		
		if (empty($id))
		{
			Template::set_message(lang('status_invalid_id'), 'error');
			redirect(SITE_AREA .'/content/status');
		}
	
		if ($this->input->post('submit'))
		{
			if ($this->save_status('update', $id))
			{
				// Log the activity
				$this->activity_model->log_activity($this->auth->user_id(), lang('status_act_edit_record').': ' . $id . ' : ' . $this->input->ip_address(), 'status');
					
				Template::set_message(lang('status_edit_success'), 'success');
			}
			else 
			{
				Template::set_message(lang('status_edit_failure') . $this->status_model->error, 'error');
			}
		}
		
		Template::set('status', $this->status_model->find($id));
	
		Template::set('toolbar_title', lang('status_edit_heading'));
		Template::set('toolbar_title', lang('status_edit') . ' Status');
		Template::render();		
	}
	
	//--------------------------------------------------------------------

	/*
		Method: delete()
		
		Allows deleting of Status data.
	*/
	public function delete() 
	{	
		$this->auth->restrict('Status.Content.Delete');

		$id = $this->uri->segment(5);
	
		if (!empty($id))
		{	
			if ($this->status_model->delete($id))
			{
				// Log the activity
				$this->activity_model->log_activity($this->auth->user_id(), lang('status_act_delete_record').': ' . $id . ' : ' . $this->input->ip_address(), 'status');
					
				Template::set_message(lang('status_delete_success'), 'success');
			} else
			{
				Template::set_message(lang('status_delete_failure') . $this->status_model->error, 'error');
			}
		}
		
		redirect(SITE_AREA .'/content/status');
	}
	
	//--------------------------------------------------------------------

	//--------------------------------------------------------------------
	// !PRIVATE METHODS
	//--------------------------------------------------------------------
	
	/*
		Method: save_status()
		
		Does the actual validation and saving of form data.
		
		Parameters:
			$type	- Either "insert" or "update"
			$id		- The ID of the record to update. Not needed for inserts.
		
		Returns:
			An INT id for successful inserts. If updating, returns TRUE on success.
			Otherwise, returns FALSE.
	*/
	private function save_status($type='insert', $id=0) 
	{	
					
	$this->form_validation->set_rules('status_description','Description','max_length[255]');

		if ($this->form_validation->run() === FALSE)
		{
			return FALSE;
		}
		
		if ($type == 'insert')
		{
			$id = $this->status_model->insert($_POST);
			
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
			$return = $this->status_model->update($id, $_POST);
		}
		
		return $return;
	}

	//--------------------------------------------------------------------



}