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

		$fname = $config['upload_path']."/".$fileData['file_name'];
		//$fh = gzopen($fname,"rb");

		$handle = fopen($fname, "r");
		$contents = fread($handle, filesize($fname));
		fclose($handle);

		$ssdata = array();
		$ssdata['symbolsets_userid']=$this->auth->user_id();		
		$ssdata['symbolsets_description'] = $_POST['symbolsets_description'];
		$ssdata['symbolsets_symbolsetarch'] = $contents;

		$this->debug->showArr($ssdata);
		
		//$insert_id = $this->symbolsets_model->insert($ssdata);
		$insert_id = $this->save_symbolset($ssdata);
		echo "<p>insert ID = ".$insert_id."</p>";
		if ($insert_id)
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
	    }
	  Template::render();
	  
	}


	public function getSymbolSet($id)
	{
	  $data = $this->symbolsets_model->find($id);
	  if ($data) {
	    echo $data->symbolsets_symbolsetarch;
	  } 
	  else  {
	    echo "<h1>ERROR - Failed to get symbolset ${id}</h1>";
	  }

	}


	//--------------------------------------------------------------------


	/*
		Method: save_symbolsets()
		
		Does the actual validation and saving of form data.
		
		Parameters:
		Returns:
			An INT id for successful inserts. If updating, returns TRUE on success.
			Otherwise, returns FALSE.
	*/
	private function save_symbolset($data) 
	{	
	  $id = $this->symbolsets_model->insert($data);
	  if (is_numeric($id))
	    {
	      $return = $id;
	    } else
	    {
	      $return = FALSE;
	    }
	  return $return;
	}
	//--------------------------------------------------------------------




}