<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class symbolsets extends Front_Controller {

	//--------------------------------------------------------------------

	public function __construct() 
	{
		parent::__construct();

		$this->load->library('form_validation');
		$this->load->model('symbolsets_model', null, true);
		$this->lang->load('symbolsets');
		$this->load->library('debug');
		
		
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

		Template::set('data', $data);
		Template::render();
	}
	
	//--------------------------------------------------------------------


	/*
	  Method: create()
	  Create a new symbolset by displaying an upload form
	*/
	public function create()
	{
	  //$this->auth->restrict('SymbolSets.Content.Create');

	  if ($this->input->post('submit'))
	    {
	      $config['upload_path'] = '/home/OSM/code/disrendd/www/uploads/';
	      $config['allowed_types'] = '*';
	      $config['max_size']	= '0';
	      
	      $this->load->library('upload', $config);

	      $this->debug->showArr($_POST);

	      if ( ! $this->upload->do_upload()) {
		echo "<p>upload failed!!</p>";
		echo $this->upload->display_errors("<p>","</p>");
	      }
	      else {
		$fileData = $this->upload->data();
		echo "<p>Upload Successful - file = ".$fileData['file_name'],"</p>";

		$filename = $config['upload_path']."/".$fileData['file_name'];
		$this->load->library('archive');

		$this->debug->showClassMethods('archive');

		$arch = new $this->archive->gzip_file($fname);

		//$handle = fopen($filename, "r");
		//$contents = fread($handle, filesize($filename));
		//fclose($handle);
	      }
	      

		if ($insert_id = $this->save_symbolset())
		{
		  // Log the activity
		  $this->activity_model->log_activity($this->auth->user_id(), lang('symbolsets_act_create_record').': ' . $insert_id . ' : ' . $this->input->ip_address(), 'symbolsets');
					
		  Template::set_message(lang("symbolsets_create_success"), 'success');
		  Template::redirect('/symbolsets');
		}
	      else 
		{
		  Template::set_message(lang('symbolsets_create_failure') 
					. $this->symbolsets_model->error, 
					'error');
		}
	    }
	  
	  //Template::set('toolbar_title', lang('symbolsets_create_new_button'));
	  //Template::set('toolbar_title', lang('symbolsets_create') . ' SymbolSets');
	  Template::render();

	}


	/*
		Method: save_symbolsets()
		
		Does the actual validation and saving of form data.
		
		Parameters:
		Returns:
			An INT id for successful inserts. If updating, returns TRUE on success.
			Otherwise, returns FALSE.
	*/
	private function save_symbolset() 
	{	
	  $data = array();
	  $data['userid']=0;
	  $data['description']=$_POST['symbolsets_description'];
	  $id = $this->symbolsets_model->insert($_POST);
			
	  if (is_numeric($id))
	    {
	      $return = $id;
	    } else
	    {
	      $return = FALSE;
	    }
	}
	//--------------------------------------------------------------------




}