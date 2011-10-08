<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class developer extends Admin_Controller {

	//--------------------------------------------------------------------

	public function __construct() 
	{
		parent::__construct();

		$this->auth->restrict('RenderQueue.Developer.View');
		$this->load->model('renderqueue_model', null, true);
		$this->lang->load('renderqueue');
		
		
			Assets::add_css('flick/jquery-ui-1.8.13.custom.css');
			Assets::add_js('jquery-ui-1.8.8.min.js');
	}
	
	//--------------------------------------------------------------------

	/*
		Method: index()
		
		Displays a list of form data.
	*/
	public function index() 
	{
		$data = array();
		$data['records'] = $this->renderqueue_model->find_all();

		Assets::add_js($this->load->view('developer/js', null, true), 'inline');
		
		Template::set('data', $data);
		Template::set('toolbar_title', "Manage renderQueue");
		Template::render();
	}
	
	//--------------------------------------------------------------------

	/*
		Method: create()
		
		Creates a renderQueue object.
	*/
	public function create() 
	{
		$this->auth->restrict('RenderQueue.Developer.Create');

		if ($this->input->post('submit'))
		{
			if ($insert_id = $this->save_renderqueue())
			{
				// Log the activity
				$this->activity_model->log_activity($this->auth->user_id(), lang('renderqueue_act_create_record').': ' . $insert_id . ' : ' . $this->input->ip_address(), 'renderqueue');
					
				Template::set_message(lang("renderqueue_create_success"), 'success');
				Template::redirect(SITE_AREA .'/developer/renderqueue');
			}
			else 
			{
				Template::set_message(lang('renderqueue_create_failure') . $this->renderqueue_model->error, 'error');
			}
		}
	
		Template::set('toolbar_title', lang('renderqueue_create_new_button'));
		Template::set('toolbar_title', lang('renderqueue_create') . ' renderQueue');
		Template::render();
	}
	
	//--------------------------------------------------------------------

	/*
		Method: edit()
		
		Allows editing of renderQueue data.
	*/
	public function edit() 
	{
		$this->auth->restrict('RenderQueue.Developer.Edit');

		$id = (int)$this->uri->segment(5);
		
		if (empty($id))
		{
			Template::set_message(lang('renderqueue_invalid_id'), 'error');
			redirect(SITE_AREA .'/developer/renderqueue');
		}
	
		if ($this->input->post('submit'))
		{
			if ($this->save_renderqueue('update', $id))
			{
				// Log the activity
				$this->activity_model->log_activity($this->auth->user_id(), lang('renderqueue_act_edit_record').': ' . $id . ' : ' . $this->input->ip_address(), 'renderqueue');
					
				Template::set_message(lang('renderqueue_edit_success'), 'success');
			}
			else 
			{
				Template::set_message(lang('renderqueue_edit_failure') . $this->renderqueue_model->error, 'error');
			}
		}
		
		Template::set('renderqueue', $this->renderqueue_model->find($id));
	
		Template::set('toolbar_title', lang('renderqueue_edit_heading'));
		Template::set('toolbar_title', lang('renderqueue_edit') . ' renderQueue');
		Template::render();		
	}
	
	//--------------------------------------------------------------------

	/*
		Method: delete()
		
		Allows deleting of renderQueue data.
	*/
	public function delete() 
	{	
		$this->auth->restrict('RenderQueue.Developer.Delete');

		$id = $this->uri->segment(5);
	
		if (!empty($id))
		{	
			if ($this->renderqueue_model->delete($id))
			{
				// Log the activity
				$this->activity_model->log_activity($this->auth->user_id(), lang('renderqueue_act_delete_record').': ' . $id . ' : ' . $this->input->ip_address(), 'renderqueue');
					
				Template::set_message(lang('renderqueue_delete_success'), 'success');
			} else
			{
				Template::set_message(lang('renderqueue_delete_failure') . $this->renderqueue_model->error, 'error');
			}
		}
		
		redirect(SITE_AREA .'/developer/renderqueue');
	}
	
	//--------------------------------------------------------------------

	//--------------------------------------------------------------------
	// !PRIVATE METHODS
	//--------------------------------------------------------------------
	
	/*
		Method: save_renderqueue()
		
		Does the actual validation and saving of form data.
		
		Parameters:
			$type	- Either "insert" or "update"
			$id		- The ID of the record to update. Not needed for inserts.
		
		Returns:
			An INT id for successful inserts. If updating, returns TRUE on success.
			Otherwise, returns FALSE.
	*/
	private function save_renderqueue($type='insert', $id=0) 
	{	
					
	$this->form_validation->set_rules('renderqueue_statusId','Status','max_length[4]');			
	$this->form_validation->set_rules('renderqueue_statusDate','StatusDate','');			
	$this->form_validation->set_rules('renderqueue_rendererId','Renderer','max_length[4]');			
	$this->form_validation->set_rules('renderqueue_mapSpec','MapSpec','max_length[4]');			
	$this->form_validation->set_rules('renderqueue_logFile','LogFile','');			
	$this->form_validation->set_rules('renderqueue_spare','spare','max_length[4]');

		if ($this->form_validation->run() === FALSE)
		{
			return FALSE;
		}
		
		if ($type == 'insert')
		{
			$id = $this->renderqueue_model->insert($_POST);
			
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
			$return = $this->renderqueue_model->update($id, $_POST);
		}
		
		return $return;
	}

	//--------------------------------------------------------------------



}