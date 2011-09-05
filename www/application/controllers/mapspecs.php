<?php

class mapspecs extends CI_Controller {

  public function __construct() {
    parent::__construct();
    // Your own constructor code
    $this -> load -> library('session');
    $this -> load -> library('form_validation', 'input');
    $this -> load -> helper('url');
    $this -> load -> helper('form');
    $this -> load -> database();
    $this -> load -> model('mapspecs_model');
    $this -> load -> model('gpxfiles_model');
    $this -> load -> model('users_model');
  }
  
  function index() {
    $this -> list_mapspecs();
  }
  
  public function create() {
    /** 
     *	Create a new mapspec
     *
     */
    if (!$this -> users_model -> isValidUser()) {
      $data = array('title' => 'Error', 
		    'msg' => "You must be logged in to create a mapspec.");
      $viewdata = array('main_content' => 'message_view', 
			'data' => $data);
      $this -> load -> view('include/site_template', $viewdata);
    } 
    else {
      $id = $this -> mapspecs_model -> create_mapspec();
      $this -> edit($id);
    }
  } 
    
  public function edit($id =null) {
    /**
     * if $id is not null, we populate the form from the database
     * and display it to the user.
     * if $map_id is null, and POST data has been provided, we update the
     * mapspec specified in the POST data with the supplied data.
     * If $id is null and there is no POST data, we create a new 
     * mapspec.
     */
    if(isset($id)) {
      $mapspec = $this -> mapspecs_model -> get_mapspec($id);
      if(isset($mapspec)) {
	var_dump($mapspec);
	$mapspec_user_id = $mapspec['userId'];
	$mapspec_uname = $this 
	  -> users_model
	  -> get_username_by_id($mapspec_user_id);
      } else
	$mapspec_uname = NULL;
    } else
      $mapspec_uname = null;
	  
    if ($mapspec_uname == NULL) {
      $data = array('title' => 'Error', 
		    'msg' => "You must specify a valid MapSpec ID to edit it! - id=" . $id);
      $viewdata = array('main_content' => 'message_view', 'data' => $data);
      $this -> load -> view('include/site_template', $viewdata);
    } 
    elseif (!$this -> users_model -> isValidNamedUser($mapspec_uname) 
	    && !$this -> users_model -> isValidAdmin()) {
      $data = array('title' => 'Error', 'msg' => "You must be logged in as the owner of the mapspec, or as an Administrator to edit a mapspec.");
      $viewdata = array('main_content' => 'message_view', 
			'data' => $data);
      $this -> load -> view('include/site_template', $viewdata);
    } 
    else {
      if($this -> input -> post('submit')) {
	foreach($_POST as $key => $value) {
	  $post_data[$key] = $this -> input -> post($key);
	}
	$id = $this -> input -> post('id');
	$data = $post_data;
	$this -> mapspecs_model -> update_mapspec($data['id'], 
						  $data['userId'], 
						  $data['description'], 
						  $data['GPXFile']);
	$data['query'] = $this -> mapspecs_model -> get_mapspecs();
	$viewdata = array('data' => $data, 
			  'main_content' => 'mapspecs_list_mapspecs');
	$this -> load -> view('include/site_template', $viewdata);
      } 
      else {
	if($id == null) {
	  $data = $this -> mapspecs_model -> get_default_mapspec();
	  $data['userId'] = $this -> session -> userdata('user_id');
	  $data['uname'] = $this -> users_model -> 
	    get_uname_by_id($data['userId']);
	} 
	else {
	  $data = $this -> mapspecs_model -> get_mapspec($id);
	  if(isset($data['userId'])) {
	    $data['uname'] = $this -> users_model -> 
	      get_username_by_id($data['userId']);
	    $viewdata = array('data' => $data, 
			      'main_content' => 'mapspecs_edit_mapspec');
	    $this -> load -> view('include/site_template', $viewdata);
	  } 
	  else {
	    #echo "Error - userId does not exist....";
	    $data = array('title' => 'Error', 
			  'msg' => "Invalid Mapspec ID");
	    $viewdata = array('main_content' => 'message_view', 
			      'data' => $data);
	    $this -> load -> view('include/site_template', $viewdata);
	  }
	}
      }
    }
  }
  
  public function delete($id=NULL) {
    /**
     * Delete mapspec number $id.
     * Must be logged in as the owner of the file or an 
     * administrator to do this.
     */
    if(isset($id)) {
      $mapspec = $this -> mapspecs_model -> get_mapspec($id);
      if(isset($mapspec)) {
	$mapspec_user_id = $mapspec['userId'];
	$mapspec_uname = $this -> 
	  users_model -> 
	  get_username_by_id($mapspec_user_id);
      } else
	$mapspec_uname = NULL;
    } else
      $mapspec_uname = NULL;
    if($mapspec_uname == NULL) {
      $data = array('title' => 'Error', 
		    'msg' => "You must specify a valid mapspec ID to delete it!");
      $viewdata = array('main_content' => 'message_view', 
			'data' => $data);
      $this -> load -> view('include/site_template', $viewdata);
    } 
    elseif (!$this -> users_model -> isValidNamedUser($file_uname) 
	    && !$this -> users_model -> isValidAdmin()) {
      $data = array('title' => 'Error', 
		    'msg' => "You must be logged in as the owner".
		    " of the mapspec, " . 
		    "or as an Administrator to delete a file.");
      $viewdata = array('main_content' => 'message_view', 
			'data' => $data);
      $this -> load -> view('include/site_template', $viewdata);
    } 
    else {
      $this -> mapspecs_model -> delete($id);
      $data = array('title' => 'Success!', 
		    'msg' => "Deleted file number" . $id . ".");
      $viewdata = array('main_content' => 'message_view', 
			'data' => $data);
      $this -> load -> view('include/site_template', $viewdata);
    }
  }
  
  public function list_mapspecs($errmsg=NULL) {
    /**
     * lists all of the mapspecs in the database as an html table
     * with edit and delete links.
     * If ?ajax=true is included on the command line, 
     * it returns all of the IDs and descriptions as
     * in json format to be used by other code.
     *
     * @param : ?ajax on the command line to return json rather than html.
     * @param errmsg: If returning html, errmsg will be printed
     * at the top of hte page.
     */
    $data['query'] = $this -> mapspecs_model -> get_mapspecs();
    $query = $data['query'];
    if($this -> input -> get('ajax')) 
      {
      foreach($data['query']->result() as $row) :
	$res[$row -> id] = $row -> id . " - " . $row -> description;
	endforeach;
	echo json_encode($res);
      } 
    else {
      $data['errmsg'] = $errmsg;
      $viewdata = array('main_content' => 'mapspecs_list_mapspecs', 
			'data' => $data);
      $this -> load -> view('include/site_template', $viewdata);
    }
  }
  
  public function get_mapspec($id) {
    /**
     * returns the contents of mapspec id number $id.
     * If ?ajax=TRUE is included on the URL, 
     * it will return the GPX file ID, description and contents
     * as a JSON string.
     */
    $query = $this -> mapspecs_model -> get_mapspec($id);
    if($this -> input -> get('ajax')) {
      echo json_encode($query);
    } else
      echo $query['mapspec'];
  }
  
  public function get_mapspec_desc($id) {
    $query = $this -> mapspecs_model -> get_mapspec($id);
    echo $query['description'];
  } 
}
?>