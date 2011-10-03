<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class mapspecs extends Front_Controller {

	//--------------------------------------------------------------------

	public function __construct() 
	{
		parent::__construct();

		$this->load->library('form_validation');
		$this->load->model('mapspecs_model', null, true);
		$this->lang->load('mapspecs');
		
		Assets::add_js($this->load->view('mapspecs/js', null, true), 'inline');
		
		
	}
	
	//--------------------------------------------------------------------

	/*
		Method: index()
		
		Displays a list of form data.
	*/
	public function index() 
	{
		$data = array();
		$data['records'] = $this->mapspecs_model->find_all();

		Template::set('data', $data);
		Template::set('toolbar_title', "Manage MapSpecs");
		Template::render();
	}
	
	//--------------------------------------------------------------------

	/*
		Method: create()
		
		Creates a MapSpecs object.
	*/
	public function create() 
	{
		$this->auth->restrict('MapSpecs.Mapspecs.Create');

		if ($this->input->post('submit'))
		{
			if ($insert_id = $this->save_mapspecs())
			{
				// Log the activity
				$this->activity_model->log_activity($this->auth->user_id(), lang('mapspecs_act_create_record').': ' . $insert_id . ' : ' . $this->input->ip_address(), 'mapspecs');
					
				Template::set_message(lang("mapspecs_create_success"), 'success');
				Template::redirect(SITE_AREA .'/mapspecs/mapspecs');
			}
			else 
			{
				Template::set_message(lang('mapspecs_create_failure') . $this->mapspecs_model->error, 'error');
			}
		}
	
		Template::set('toolbar_title', lang('mapspecs_create_new_button'));
		Template::set('toolbar_title', lang('mapspecs_create') . ' MapSpecs');
		Template::render();
	}
	
	//--------------------------------------------------------------------

	/*
		Method: edit()
		
		Allows editing of MapSpecs data.
	*/
	public function edit() 
	{
		$this->auth->restrict('MapSpecs.Mapspecs.Edit');

		$id = (int)$this->uri->segment(5);
		
		if (empty($id))
		{
			Template::set_message(lang('mapspecs_invalid_id'), 'error');
			redirect(SITE_AREA .'/mapspecs/mapspecs');
		}
	
		if ($this->input->post('submit'))
		{
			if ($this->save_mapspecs('update', $id))
			{
				// Log the activity
				$this->activity_model->log_activity($this->auth->user_id(), lang('mapspecs_act_edit_record').': ' . $id . ' : ' . $this->input->ip_address(), 'mapspecs');
					
				Template::set_message(lang('mapspecs_edit_success'), 'success');
			}
			else 
			{
				Template::set_message(lang('mapspecs_edit_failure') . $this->mapspecs_model->error, 'error');
			}
		}
		
		Template::set('mapspecs', $this->mapspecs_model->find($id));
	
		Template::set('toolbar_title', lang('mapspecs_edit_heading'));
		Template::set('toolbar_title', lang('mapspecs_edit') . ' MapSpecs');
		Template::render();		
	}
	
	//--------------------------------------------------------------------

	/*
		Method: delete()
		
		Allows deleting of MapSpecs data.
	*/
	public function delete() 
	{	
		$this->auth->restrict('MapSpecs.Mapspecs.Delete');

		$id = $this->uri->segment(5);
	
		if (!empty($id))
		{	
			if ($this->mapspecs_model->delete($id))
			{
				// Log the activity
				$this->activity_model->log_activity($this->auth->user_id(), lang('mapspecs_act_delete_record').': ' . $id . ' : ' . $this->input->ip_address(), 'mapspecs');
					
				Template::set_message(lang('mapspecs_delete_success'), 'success');
			} else
			{
				Template::set_message(lang('mapspecs_delete_failure') . $this->mapspecs_model->error, 'error');
			}
		}
		
		redirect(SITE_AREA .'/mapspecs/mapspecs');
	}
	
	//--------------------------------------------------------------------

	//--------------------------------------------------------------------
	// !PRIVATE METHODS
	//--------------------------------------------------------------------
	
	/*
		Method: save_mapspecs()
		
		Does the actual validation and saving of form data.
		
		Parameters:
			$type	- Either "insert" or "update"
			$id		- The ID of the record to update. Not needed for inserts.
		
		Returns:
			An INT id for successful inserts. If updating, returns TRUE on success.
			Otherwise, returns FALSE.
	*/
	private function save_mapspecs($type='insert', $id=0) 
	{	
					
$this->form_validation->set_rules('mapspecs_mapSpecJSON','MapSpecJSON','max_length[10000]');			
$this->form_validation->set_rules('mapspecs_styleId','style','max_length[3]');			
$this->form_validation->set_rules('mapspecs_symbolSetId','SymbolSet','max_length[3]');			
$this->form_validation->set_rules('mapspecs_Status','Status','max_length[3]');			
$this->form_validation->set_rules('mapspecs_Image','Image','');			
$this->form_validation->set_rules('mapspecs_thumbnail','Thumbnail','');

		if ($this->form_validation->run() === FALSE)
		{
			return FALSE;
		}
		
		if ($type == 'insert')
		{
			$id = $this->mapspecs_model->insert($_POST);
			
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
			$return = $this->mapspecs_model->update($id, $_POST);
		}
		
		return $return;
	}

	//--------------------------------------------------------------------



}