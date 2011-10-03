<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class styles extends Front_Controller {

	//--------------------------------------------------------------------

	public function __construct() 
	{
		parent::__construct();

		$this->load->library('form_validation');
		$this->load->model('styles_model', null, true);
		$this->lang->load('styles');
		
		Assets::add_js($this->load->view('styles/js', null, true), 'inline');
		
		
	}
	
	//--------------------------------------------------------------------

	/*
		Method: index()
		
		Displays a list of form data.
	*/
	public function index() 
	{
		$data = array();
		$data['records'] = $this->styles_model->find_all();

		Template::set('data', $data);
		Template::set('toolbar_title', "Manage Styles");
		Template::render();
	}
	
	//--------------------------------------------------------------------

	/*
		Method: create()
		
		Creates a Styles object.
	*/
	public function create() 
	{
		$this->auth->restrict('Styles.Styles.Create');

		if ($this->input->post('submit'))
		{
			if ($insert_id = $this->save_styles())
			{
				// Log the activity
				$this->activity_model->log_activity($this->auth->user_id(), lang('styles_act_create_record').': ' . $insert_id . ' : ' . $this->input->ip_address(), 'styles');
					
				Template::set_message(lang("styles_create_success"), 'success');
				Template::redirect(SITE_AREA .'/styles/styles');
			}
			else 
			{
				Template::set_message(lang('styles_create_failure') . $this->styles_model->error, 'error');
			}
		}
	
		Template::set('toolbar_title', lang('styles_create_new_button'));
		Template::set('toolbar_title', lang('styles_create') . ' Styles');
		Template::render();
	}
	
	//--------------------------------------------------------------------

	/*
		Method: edit()
		
		Allows editing of Styles data.
	*/
	public function edit() 
	{
		$this->auth->restrict('Styles.Styles.Edit');

		$id = (int)$this->uri->segment(5);
		
		if (empty($id))
		{
			Template::set_message(lang('styles_invalid_id'), 'error');
			redirect(SITE_AREA .'/styles/styles');
		}
	
		if ($this->input->post('submit'))
		{
			if ($this->save_styles('update', $id))
			{
				// Log the activity
				$this->activity_model->log_activity($this->auth->user_id(), lang('styles_act_edit_record').': ' . $id . ' : ' . $this->input->ip_address(), 'styles');
					
				Template::set_message(lang('styles_edit_success'), 'success');
			}
			else 
			{
				Template::set_message(lang('styles_edit_failure') . $this->styles_model->error, 'error');
			}
		}
		
		Template::set('styles', $this->styles_model->find($id));
	
		Template::set('toolbar_title', lang('styles_edit_heading'));
		Template::set('toolbar_title', lang('styles_edit') . ' Styles');
		Template::render();		
	}
	
	//--------------------------------------------------------------------

	/*
		Method: delete()
		
		Allows deleting of Styles data.
	*/
	public function delete() 
	{	
		$this->auth->restrict('Styles.Styles.Delete');

		$id = $this->uri->segment(5);
	
		if (!empty($id))
		{	
			if ($this->styles_model->delete($id))
			{
				// Log the activity
				$this->activity_model->log_activity($this->auth->user_id(), lang('styles_act_delete_record').': ' . $id . ' : ' . $this->input->ip_address(), 'styles');
					
				Template::set_message(lang('styles_delete_success'), 'success');
			} else
			{
				Template::set_message(lang('styles_delete_failure') . $this->styles_model->error, 'error');
			}
		}
		
		redirect(SITE_AREA .'/styles/styles');
	}
	
	//--------------------------------------------------------------------

	//--------------------------------------------------------------------
	// !PRIVATE METHODS
	//--------------------------------------------------------------------
	
	/*
		Method: save_styles()
		
		Does the actual validation and saving of form data.
		
		Parameters:
			$type	- Either "insert" or "update"
			$id		- The ID of the record to update. Not needed for inserts.
		
		Returns:
			An INT id for successful inserts. If updating, returns TRUE on success.
			Otherwise, returns FALSE.
	*/
	private function save_styles($type='insert', $id=0) 
	{	
					
$this->form_validation->set_rules('styles_styleFile','StyleFile','max_length[10000]');			
$this->form_validation->set_rules('styles_sampleImage','Sample Image','');			
$this->form_validation->set_rules('styles_thumbnail','Thumbnail','');

		if ($this->form_validation->run() === FALSE)
		{
			return FALSE;
		}
		
		if ($type == 'insert')
		{
			$id = $this->styles_model->insert($_POST);
			
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
			$return = $this->styles_model->update($id, $_POST);
		}
		
		return $return;
	}

	//--------------------------------------------------------------------



}