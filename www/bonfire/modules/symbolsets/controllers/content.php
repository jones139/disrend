<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class content extends Admin_Controller {

	//--------------------------------------------------------------------

	public function __construct() 
	{
		parent::__construct();

		$this->auth->restrict('SymbolSets.Content.View');
		$this->load->model('symbolsets_model', null, true);
		$this->lang->load('symbolsets');
		
		
	}
	
	//--------------------------------------------------------------------

	/*
		Method: index()
		
		Displays a list of form data.
	*/
	public function index() 
	{
		$data = array();
		$data['records'] = $this->symbolsets_model->find_all();

		Assets::add_js($this->load->view('content/js', null, true), 'inline');
		
		Template::set('data', $data);
		Template::set('toolbar_title', "Manage SymbolSets");
		Template::render();
	}
	
	//--------------------------------------------------------------------

	/*
		Method: create()
		
		Creates a SymbolSets object.
	*/
	public function create() 
	{
		$this->auth->restrict('SymbolSets.Content.Create');

		if ($this->input->post('submit'))
		{
			if ($insert_id = $this->save_symbolsets())
			{
				// Log the activity
				$this->activity_model->log_activity($this->auth->user_id(), lang('symbolsets_act_create_record').': ' . $insert_id . ' : ' . $this->input->ip_address(), 'symbolsets');
					
				Template::set_message(lang("symbolsets_create_success"), 'success');
				Template::redirect(SITE_AREA .'/content/symbolsets');
			}
			else 
			{
				Template::set_message(lang('symbolsets_create_failure') . $this->symbolsets_model->error, 'error');
			}
		}
	
		Template::set('toolbar_title', lang('symbolsets_create_new_button'));
		Template::set('toolbar_title', lang('symbolsets_create') . ' SymbolSets');
		Template::render();
	}
	
	//--------------------------------------------------------------------

	/*
		Method: edit()
		
		Allows editing of SymbolSets data.
	*/
	public function edit() 
	{
		$this->auth->restrict('SymbolSets.Content.Edit');

		$id = (int)$this->uri->segment(5);
		
		if (empty($id))
		{
			Template::set_message(lang('symbolsets_invalid_id'), 'error');
			redirect(SITE_AREA .'/content/symbolsets');
		}
	
		if ($this->input->post('submit'))
		{
			if ($this->save_symbolsets('update', $id))
			{
				// Log the activity
				$this->activity_model->log_activity($this->auth->user_id(), lang('symbolsets_act_edit_record').': ' . $id . ' : ' . $this->input->ip_address(), 'symbolsets');
					
				Template::set_message(lang('symbolsets_edit_success'), 'success');
			}
			else 
			{
				Template::set_message(lang('symbolsets_edit_failure') . $this->symbolsets_model->error, 'error');
			}
		}
		
		Template::set('symbolsets', $this->symbolsets_model->find($id));
	
		Template::set('toolbar_title', lang('symbolsets_edit_heading'));
		Template::set('toolbar_title', lang('symbolsets_edit') . ' SymbolSets');
		Template::render();		
	}
	
	//--------------------------------------------------------------------

	/*
		Method: delete()
		
		Allows deleting of SymbolSets data.
	*/
	public function delete() 
	{	
		$this->auth->restrict('SymbolSets.Content.Delete');

		$id = $this->uri->segment(5);
	
		if (!empty($id))
		{	
			if ($this->symbolsets_model->delete($id))
			{
				// Log the activity
				$this->activity_model->log_activity($this->auth->user_id(), lang('symbolsets_act_delete_record').': ' . $id . ' : ' . $this->input->ip_address(), 'symbolsets');
					
				Template::set_message(lang('symbolsets_delete_success'), 'success');
			} else
			{
				Template::set_message(lang('symbolsets_delete_failure') . $this->symbolsets_model->error, 'error');
			}
		}
		
		redirect(SITE_AREA .'/content/symbolsets');
	}
	
	//--------------------------------------------------------------------

	//--------------------------------------------------------------------
	// !PRIVATE METHODS
	//--------------------------------------------------------------------
	
	/*
		Method: save_symbolsets()
		
		Does the actual validation and saving of form data.
		
		Parameters:
			$type	- Either "insert" or "update"
			$id		- The ID of the record to update. Not needed for inserts.
		
		Returns:
			An INT id for successful inserts. If updating, returns TRUE on success.
			Otherwise, returns FALSE.
	*/
	private function save_symbolsets($type='insert', $id=0) 
	{	
					
	$this->form_validation->set_rules('symbolsets_userId','User ID','max_length[3]');			
	$this->form_validation->set_rules('symbolsets_description','Description','max_length[255]');			
	$this->form_validation->set_rules('symbolsets_symbolSetArch','SymbolSet','');

		if ($this->form_validation->run() === FALSE)
		{
			return FALSE;
		}
		
		if ($type == 'insert')
		{
			$id = $this->symbolsets_model->insert($_POST);
			
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
			$return = $this->symbolsets_model->update($id, $_POST);
		}
		
		return $return;
	}

	//--------------------------------------------------------------------



}