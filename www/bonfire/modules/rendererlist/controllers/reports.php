<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class reports extends Admin_Controller {

	//--------------------------------------------------------------------

	public function __construct() 
	{
		parent::__construct();

		$this->auth->restrict('RendererList.Reports.View');
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

		Assets::add_js($this->load->view('reports/js', null, true), 'inline');
		
		Template::set('data', $data);
		Template::set('toolbar_title', "Manage rendererList");
		Template::render();
	}
	
	//--------------------------------------------------------------------

	/*
		Method: create()
		
		Creates a rendererList object.
	*/
	public function create() 
	{
		$this->auth->restrict('RendererList.Reports.Create');

		if ($this->input->post('submit'))
		{
			if ($insert_id = $this->save_rendererlist())
			{
				// Log the activity
				$this->activity_model->log_activity($this->auth->user_id(), lang('rendererlist_act_create_record').': ' . $insert_id . ' : ' . $this->input->ip_address(), 'rendererlist');
					
				Template::set_message(lang("rendererlist_create_success"), 'success');
				Template::redirect(SITE_AREA .'/reports/rendererlist');
			}
			else 
			{
				Template::set_message(lang('rendererlist_create_failure') . $this->rendererlist_model->error, 'error');
			}
		}
	
		Template::set('toolbar_title', lang('rendererlist_create_new_button'));
		Template::set('toolbar_title', lang('rendererlist_create') . ' rendererList');
		Template::render();
	}
	
	//--------------------------------------------------------------------

	/*
		Method: edit()
		
		Allows editing of rendererList data.
	*/
	public function edit() 
	{
		$this->auth->restrict('RendererList.Reports.Edit');

		$id = (int)$this->uri->segment(5);
		
		if (empty($id))
		{
			Template::set_message(lang('rendererlist_invalid_id'), 'error');
			redirect(SITE_AREA .'/reports/rendererlist');
		}
	
		if ($this->input->post('submit'))
		{
			if ($this->save_rendererlist('update', $id))
			{
				// Log the activity
				$this->activity_model->log_activity($this->auth->user_id(), lang('rendererlist_act_edit_record').': ' . $id . ' : ' . $this->input->ip_address(), 'rendererlist');
					
				Template::set_message(lang('rendererlist_edit_success'), 'success');
			}
			else 
			{
				Template::set_message(lang('rendererlist_edit_failure') . $this->rendererlist_model->error, 'error');
			}
		}
		
		Template::set('rendererlist', $this->rendererlist_model->find($id));
	
		Template::set('toolbar_title', lang('rendererlist_edit_heading'));
		Template::set('toolbar_title', lang('rendererlist_edit') . ' rendererList');
		Template::render();		
	}
	
	//--------------------------------------------------------------------

	/*
		Method: delete()
		
		Allows deleting of rendererList data.
	*/
	public function delete() 
	{	
		$this->auth->restrict('RendererList.Reports.Delete');

		$id = $this->uri->segment(5);
	
		if (!empty($id))
		{	
			if ($this->rendererlist_model->delete($id))
			{
				// Log the activity
				$this->activity_model->log_activity($this->auth->user_id(), lang('rendererlist_act_delete_record').': ' . $id . ' : ' . $this->input->ip_address(), 'rendererlist');
					
				Template::set_message(lang('rendererlist_delete_success'), 'success');
			} else
			{
				Template::set_message(lang('rendererlist_delete_failure') . $this->rendererlist_model->error, 'error');
			}
		}
		
		redirect(SITE_AREA .'/reports/rendererlist');
	}
	
	//--------------------------------------------------------------------

	//--------------------------------------------------------------------
	// !PRIVATE METHODS
	//--------------------------------------------------------------------
	
	/*
		Method: save_rendererlist()
		
		Does the actual validation and saving of form data.
		
		Parameters:
			$type	- Either "insert" or "update"
			$id		- The ID of the record to update. Not needed for inserts.
		
		Returns:
			An INT id for successful inserts. If updating, returns TRUE on success.
			Otherwise, returns FALSE.
	*/
	private function save_rendererlist($type='insert', $id=0) 
	{	
					
	$this->form_validation->set_rules('rendererlist_bbox','Bbox','max_length[255]');			
	$this->form_validation->set_rules('rendererlist_name','Name','max_length[255]');			
	$this->form_validation->set_rules('rendererlist_url','URL','max_length[255]');			
	$this->form_validation->set_rules('rendererlist_status','Status','max_length[3]');

		if ($this->form_validation->run() === FALSE)
		{
			return FALSE;
		}
		
		if ($type == 'insert')
		{
			$id = $this->rendererlist_model->insert($_POST);
			
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
			$return = $this->rendererlist_model->update($id, $_POST);
		}
		
		return $return;
	}

	//--------------------------------------------------------------------



}