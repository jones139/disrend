<?php

class mapspecs extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    // Your own constructor code
    $this->load->library('session');
    $this->load->library('form_validation','input');
    $this->load->helper('url');
    $this->load->helper('form');
    $this->load->database();
    $this->load->model('mapspecs_model');
    $this->load->model('users_model');
  }

  function index() 
  {
    $this->list_mapspecs();
  }


  public function edit_mapspec($map_id = null)
  {
    /**
     * if $map_id is not null, we populate the form from the database
     * and display it to the user.
     * if $map_id is null, and POST data has been provided, we update the
     *   map specified in the POST data with the supplie data.
     * If $map_id is null and there is no POST data, we create a new map
     * spec.
     */
    $this->load->view('header_view');

    if ($map_id == null)
      {
	foreach($_POST as $key =>$value) 
	  {
	    $post_data[$key]=$this->input->post($key);
	  }
	$map_id = $this->input->post('user_id');
	$db_data = $this->mapspecs_model->get_mapspec_by_id($map_id);
      }
    else
      {
	$db_data = $this->mapspecs_model->get_default_mapspec();
      }
    

    if ($this->input->post('submit')) 
      {
	$data = $post_data;
      }
    else 
      {
	$data = $db_data;
      }

    if ($this->form_validation->run() == FALSE)
      {
	foreach($data as $key =>$value) 
	  {
	    echo "<p>".$key."->".$value."</p> ";
	  }
	$this->load->view('mapspecs_edit_map.php',$data);
      }
    else
      {
	$this->load->view('login_message.php',
			  array('title'=>'ERROR',
				'msg'=>'Only an administrator can change the configuration of a different user.'));
      }
    
    //    else
    //{
    //  $uname=$this->input->post('uname');
    //  $passwd=$this->input->post('password');
    //  $full_name=$this->input->post('full_name');
    //  $email=$this->input->post('email');
    //  $role=$this->input->post('role');
    //  // user name available - create username.
    //  $this->users_model->update_user(
    //				      $user_id,
    //				      $uname,
    //				      $passwd,
    //				      $full_name,
    //				      $email,
    //				      $role);
    //     redirect('/login/logout');
    //  }
    $this->load->view('footer_view');
  }

  public function list_mapspecs() {
    $data['query'] = $this->mapspecs_model->get_mapspecs();;
    $this->load->view('header_view',$data);
    $this->load->view('mapspecs_list_mapspecs',$data);

    $this->load->view('footer_view');

  }
}

?>