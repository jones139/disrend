<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class content extends Admin_Controller {

	//--------------------------------------------------------------------

	public function __construct() 
	{
		parent::__construct();

		$this->auth->restrict('JobQueue.Content.View');
		$this->load->model('jobqueue_model', null, true);
		$this->lang->load('jobqueue');
		
		
				Assets::add_css('flick/jquery-ui-1.8.13.custom.css');
				Assets::add_js('jquery-ui-1.8.8.min.js');
			Assets::add_css('jquery-ui-timepicker.css');
			Assets::add_js('jquery-ui-timepicker-addon.js');
	}
	
	//--------------------------------------------------------------------

	/*
		Method: index()
		
		Displays a list of form data.
	*/
	public function index() 
	{
		$data = array();
		$data['records'] = $this->jobqueue_model->find_all();

		Assets::add_js($this->load->view('content/js', null, true), 'inline');
		
		Template::set('data', $data);
		Template::set('toolbar_title', "Manage JobQueue");
		Template::render();
	}
	
	//--------------------------------------------------------------------

	/*
		Method: create()
		
		Creates a JobQueue object.
	*/
	public function create() 
	{
		$this->auth->restrict('JobQueue.Content.Create');

		if ($this->input->post('submit'))
		{
			if ($insert_id = $this->save_jobqueue())
			{
				// Log the activity
				$this->activity_model->log_activity($this->auth->user_id(), lang('jobqueue_act_create_record').': ' . $insert_id . ' : ' . $this->input->ip_address(), 'jobqueue');
					
				Template::set_message(lang("jobqueue_create_success"), 'success');
				Template::redirect(SITE_AREA .'/content/jobqueue');
			}
			else 
			{
				Template::set_message(lang('jobqueue_create_failure') . $this->jobqueue_model->error, 'error');
			}
		}
	
		Template::set('toolbar_title', lang('jobqueue_create_new_button'));
		Template::set('toolbar_title', lang('jobqueue_create') . ' JobQueue');
		Template::render();
	}
	
	//--------------------------------------------------------------------

	/*
		Method: edit()
		
		Allows editing of JobQueue data.
	*/
	public function edit() 
	{
		$this->auth->restrict('JobQueue.Content.Edit');

		$id = (int)$this->uri->segment(5);
		
		if (empty($id))
		{
			Template::set_message(lang('jobqueue_invalid_id'), 'error');
			redirect(SITE_AREA .'/content/jobqueue');
		}
	
		if ($this->input->post('submit'))
		{
			if ($this->save_jobqueue('update', $id))
			{
				// Log the activity
				$this->activity_model->log_activity($this->auth->user_id(), lang('jobqueue_act_edit_record').': ' . $id . ' : ' . $this->input->ip_address(), 'jobqueue');
					
				Template::set_message(lang('jobqueue_edit_success'), 'success');
			}
			else 
			{
				Template::set_message(lang('jobqueue_edit_failure') . $this->jobqueue_model->error, 'error');
			}
		}
		
		Template::set('jobqueue', $this->jobqueue_model->find($id));
	
		Template::set('toolbar_title', lang('jobqueue_edit_heading'));
		Template::set('toolbar_title', lang('jobqueue_edit') . ' JobQueue');
		Template::render();		
	}
	
	//--------------------------------------------------------------------

	/*
		Method: delete()
		
		Allows deleting of JobQueue data.
	*/
	public function delete() 
	{	
		$this->auth->restrict('JobQueue.Content.Delete');

		$id = $this->uri->segment(5);
	
		if (!empty($id))
		{	
			if ($this->jobqueue_model->delete($id))
			{
				// Log the activity
				$this->activity_model->log_activity($this->auth->user_id(), lang('jobqueue_act_delete_record').': ' . $id . ' : ' . $this->input->ip_address(), 'jobqueue');
					
				Template::set_message(lang('jobqueue_delete_success'), 'success');
			} else
			{
				Template::set_message(lang('jobqueue_delete_failure') . $this->jobqueue_model->error, 'error');
			}
		}
		
		redirect(SITE_AREA .'/content/jobqueue');
	}
	
	//--------------------------------------------------------------------

	//--------------------------------------------------------------------
	// !PRIVATE METHODS
	//--------------------------------------------------------------------
	
	/*
		Method: save_jobqueue()
		
		Does the actual validation and saving of form data.
		
		Parameters:
			$type	- Either "insert" or "update"
			$id		- The ID of the record to update. Not needed for inserts.
		
		Returns:
			An INT id for successful inserts. If updating, returns TRUE on success.
			Otherwise, returns FALSE.
	*/
	private function save_jobqueue($type='insert', $id=0) 
	{	
					
	$this->form_validation->set_rules('jobqueue_userId','User ID','max_length[3]');			
	$this->form_validation->set_rules('jobqueue_mapSpecId','MapSpec ID','max_length[3]');			
	$this->form_validation->set_rules('jobqueue_status','Status','max_length[3]');			
	$this->form_validation->set_rules('jobqueue_rendererId','Renderer ID','max_length[3]');			
	$this->form_validation->set_rules('jobqueue_submitTime','Submit Time','');			
	$this->form_validation->set_rules('jobqueue_renderStartTime','Render Start Time','');			
	$this->form_validation->set_rules('jobqueue_statusTime','Status Time','');

		if ($this->form_validation->run() === FALSE)
		{
			return FALSE;
		}
		
		if ($type == 'insert')
		{
			$id = $this->jobqueue_model->insert($_POST);
			
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
			$return = $this->jobqueue_model->update($id, $_POST);
		}
		
		return $return;
	}

	//--------------------------------------------------------------------



}