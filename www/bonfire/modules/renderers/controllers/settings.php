<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class settings extends Admin_Controller {

	//--------------------------------------------------------------------

	public function __construct() 
	{
		parent::__construct();

		$this->auth->restrict('Renderers.Settings.View');
		$this->load->model('renderers_model', null, true);
		$this->lang->load('renderers');
		
		
	}
	
	//--------------------------------------------------------------------

	/*
		Method: index()
		
		Displays a list of form data.
	*/
	public function index() 
	{
		$data = array();
		$data['records'] = $this->renderers_model->find_all();

		Assets::add_js($this->load->view('settings/js', null, true), 'inline');
		
		Template::set('data', $data);
		Template::set('toolbar_title', "Manage Renderers");
		Template::render();
	}
	
	//--------------------------------------------------------------------

	/*
		Method: create()
		
		Creates a Renderers object.
	*/
	public function create() 
	{
		$this->auth->restrict('Renderers.Settings.Create');

		if ($this->input->post('submit'))
		{
			if ($insert_id = $this->save_renderers())
			{
				// Log the activity
				$this->activity_model->log_activity($this->auth->user_id(), lang('renderers_act_create_record').': ' . $insert_id . ' : ' . $this->input->ip_address(), 'renderers');
					
				Template::set_message(lang("renderers_create_success"), 'success');
				Template::redirect(SITE_AREA .'/settings/renderers');
			}
			else 
			{
				Template::set_message(lang('renderers_create_failure') . $this->renderers_model->error, 'error');
			}
		}
	
		Template::set('toolbar_title', lang('renderers_create_new_button'));
		Template::set('toolbar_title', lang('renderers_create') . ' Renderers');
		Template::render();
	}
	
	//--------------------------------------------------------------------

	/*
		Method: edit()
		
		Allows editing of Renderers data.
	*/
	public function edit() 
	{
		$this->auth->restrict('Renderers.Settings.Edit');

		$id = (int)$this->uri->segment(5);
		
		if (empty($id))
		{
			Template::set_message(lang('renderers_invalid_id'), 'error');
			redirect(SITE_AREA .'/settings/renderers');
		}
	
		if ($this->input->post('submit'))
		{
			if ($this->save_renderers('update', $id))
			{
				// Log the activity
				$this->activity_model->log_activity($this->auth->user_id(), lang('renderers_act_edit_record').': ' . $id . ' : ' . $this->input->ip_address(), 'renderers');
					
				Template::set_message(lang('renderers_edit_success'), 'success');
			}
			else 
			{
				Template::set_message(lang('renderers_edit_failure') . $this->renderers_model->error, 'error');
			}
		}
		
		Template::set('renderers', $this->renderers_model->find($id));
	
		Template::set('toolbar_title', lang('renderers_edit_heading'));
		Template::set('toolbar_title', lang('renderers_edit') . ' Renderers');
		Template::render();		
	}
	
	//--------------------------------------------------------------------

	/*
		Method: delete()
		
		Allows deleting of Renderers data.
	*/
	public function delete() 
	{	
		$this->auth->restrict('Renderers.Settings.Delete');

		$id = $this->uri->segment(5);
	
		if (!empty($id))
		{	
			if ($this->renderers_model->delete($id))
			{
				// Log the activity
				$this->activity_model->log_activity($this->auth->user_id(), lang('renderers_act_delete_record').': ' . $id . ' : ' . $this->input->ip_address(), 'renderers');
					
				Template::set_message(lang('renderers_delete_success'), 'success');
			} else
			{
				Template::set_message(lang('renderers_delete_failure') . $this->renderers_model->error, 'error');
			}
		}
		
		redirect(SITE_AREA .'/settings/renderers');
	}
	
	//--------------------------------------------------------------------

	//--------------------------------------------------------------------
	// !PRIVATE METHODS
	//--------------------------------------------------------------------
	
	/*
		Method: save_renderers()
		
		Does the actual validation and saving of form data.
		
		Parameters:
			$type	- Either "insert" or "update"
			$id		- The ID of the record to update. Not needed for inserts.
		
		Returns:
			An INT id for successful inserts. If updating, returns TRUE on success.
			Otherwise, returns FALSE.
	*/
	private function save_renderers($type='insert', $id=0) 
	{	
					
	$this->form_validation->set_rules('renderers_userId','User ID','max_length[3]');			
	$this->form_validation->set_rules('renderers_description','Description','max_length[255]');			
	$this->form_validation->set_rules('renderers_rendererSpec','Renderer Spec','');			
	$this->form_validation->set_rules('renderers_rendererStatus','Renderer Status','max_length[3]');

		if ($this->form_validation->run() === FALSE)
		{
			return FALSE;
		}
		
		if ($type == 'insert')
		{
			$id = $this->renderers_model->insert($_POST);
			
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
			$return = $this->renderers_model->update($id, $_POST);
		}
		
		return $return;
	}

	//--------------------------------------------------------------------



}