<?php
if(!defined('BASEPATH'))
	exit('No direct script access allowed');

class Townguide extends CI_Controller {
<<<<<<< HEAD
  public function __construct()
  {
    parent::__construct();
    // Your own constructor code
    $this->load->library('session');
    $this->load->helper('url');
    $this->load->helper('form');
    $this->load->database();
    $this->load->model('JobQueue_model');
    $this->load->model('users_model');
    $this->load->model('mapspecs_model');
    //echo "base URL=".base_url().".";
  }


  private function write_header() {
    $data['session_id']=$this->session->userdata('session_id');
    $data['ip_address']="1.1.1.1";
      //$this->session->userdata('ip_address');
    $this->load->view('header_view',$data);

  }

  public function index()
  {
    $this->listqueue();
  }
  public function newmap()
  {
    $this->load->view('header_view');
    $this->load->view('editmap_view');
     $this->load->view('footer_view');
    $this->JobQueue_model->add_job(1,1);
  }
  public function editmap($mapno=-1)
  {
    /* If no map number is specified on the command line, and
     * no post data has been sent, we display a blank form to create a new map.
     * If a map number is specified on the command line, we display a form
     * populated with the data for the pre-existing map 'mapno'.
     * If post data is present, the user has submitted the form after editing
     * the map specification, so we add it to the edit queue.
     */
    $this->load->view('header_view');

 

    if (!$this->input->post('submit'))
      {
	if ($mapno==-1) {
	  // create new map
	  $data = $this->map_model->get_default_map();
	} else {
	  $data = $this->map_model->get_map($mapno);
	}
      }
    else
      {
	//$uname  = $this->input->post('uname');
	//$passwd = $this->input->post('passwd');
	//echo "validate_login: uname=".$uname." passwd=".$passwd.".";
	// update mapdata in database and add it to queue.
      }
    $this->load->view('footer_view');
 

    //echo 'editmap.  mapno='.$mapno;
  }

  public function deletemap($job_id)
  {
    $data['job_id']=$job_id;
    $this->JobQueue_model->delete_job($job_id);
    $this->load->view('header_view');
    $this->load->view('confirm_delete_view',$data);
    $this->load->view('footer_view');
  }

  public function retry_job($job_id)
  {
    $data['job_id']=$job_id;
    $this->JobQueue_model->retry_job($job_id);
    $this->load->view('header_view');
    $this->load->view('confirm_retry_job_view',$data);
    $this->load->view('footer_view');
  }

  public function get_next_job($renderer)
    /** Return the number of the next job that is suitable for
     *  the identified renderer.
     *  Updates the job to show it is being rendered by the renderer.
     */
  {

  }

  public function listqueue()
  {
    $data['query'] = $this->JobQueue_model->get_jobs();;

    $this->load->view('header_view',$data);
    $this->load->view('listqueue_view',$data);
    $this->load->view('footer_view');
    //echo 'listqueue';
  }


  public function admin()
  {
    $this->load->view('header_view');
    $this->load->view('admin_view');
    $this->load->view('footer_view');
  }

  public function queueMap()
  {
	$data=$_POST;
	$retStr = "queueMap() - ";
	$n=0;
    #foreach ($data as $k=>$v) {
   # 	$n=$n+1;
   #    $retStr = $retStr . $n . $k . "=>" . $v;	
	#}
	
	$json = json_decode($data["json"]);
	foreach ($json as $k=>$v) {
		$retStr = $retStr . $k . "=>" . $v;
	}
 	echo $retStr;
  }
 
 
  public function initialise_db()
  {
    echo 'initialise_db';
    // Initialise the queue table
    $sql = $this->JobQueue_model->get_initialise_sql();
    echo $sql;
    mysql_query($sql) or die(mysql_error());

    // Initialise the users table
    $sql = $this->users_model->get_initialise_sql();
    echo $sql;
    mysql_query($sql) or die(mysql_error());

    $sql = $this->mapspecs_model->get_initialise_sql();
    echo $sql;
    mysql_query($sql) or die(mysql_error());

    // Initialise the session data table
    $sql = "CREATE TABLE IF NOT EXISTS  `ci_sessions` (
=======
	public function __construct() {
		parent::__construct();
		// Your own constructor code
		$this -> load -> library('session');
		$this -> load -> helper('url');
		$this -> load -> helper('form');
		$this -> load -> database();
		$this -> load -> model('queue_model');
		$this -> load -> model('users_model');
		$this -> load -> model('mapspecs_model');
		//echo "base URL=".base_url().".";
	}

	private function write_header() {
		$data['session_id'] = $this -> session -> userdata('session_id');
		$data['ip_address'] = "1.1.1.1";
		//$this->session->userdata('ip_address');
		$this -> load -> view('header_view', $data);

	}

	public function index() {
		$this -> listqueue();
	}

	public function newmap() {
		$this -> load -> view('header_view');
		$this -> load -> view('editmap_view');
		$this -> load -> view('footer_view');
		$this -> queue_model -> add_job(1, 1);
	}

	public function editmap($mapno=-1) {
		/* If no map number is specified on the command line, and
		 * no post data has been sent, we display a blank form to create a new map.
		 * If a map number is specified on the command line, we display a form
		 * populated with the data for the pre-existing map 'mapno'.
		 * If post data is present, the user has submitted the form after editing
		 * the map specification, so we add it to the edit queue.
		 */
		$this -> load -> view('header_view');

		if(!$this -> input -> post('submit')) {
			if($mapno == -1) {
				// create new map
				$data = $this -> map_model -> get_default_map();
			} else {
				$data = $this -> map_model -> get_map($mapno);
			}
		} else {
			//$uname  = $this->input->post('uname');
			//$passwd = $this->input->post('passwd');
			//echo "validate_login: uname=".$uname." passwd=".$passwd.".";
			// update mapdata in database and add it to queue.
		}
		$this -> load -> view('footer_view');

		//echo 'editmap.  mapno='.$mapno;
	}

	public function deletemap($job_id) {
		$data['job_id'] = $job_id;
		$this -> queue_model -> delete_job($job_id);
		$this -> load -> view('header_view');
		$this -> load -> view('confirm_delete_view', $data);
		$this -> load -> view('footer_view');
	}

	public function retry_job($job_id) {
		$data['job_id'] = $job_id;
		$this -> queue_model -> retry_job($job_id);
		$this -> load -> view('header_view');
		$this -> load -> view('confirm_retry_job_view', $data);
		$this -> load -> view('footer_view');
	}

	public function get_next_job($renderer)
	/** Return the number of the next job that is suitable for
	 *  the identified renderer.
	 *  Updates the job to show it is being rendered by the renderer.
	 */
	{

	}

	public function listqueue() {
		$data['query'] = $this -> queue_model -> get_jobs();
		;

		$this -> load -> view('header_view', $data);
		$this -> load -> view('listqueue_view', $data);
		$this -> load -> view('footer_view');
		//echo 'listqueue';
	}

	public function admin() {
		$this -> load -> view('header_view');
		$this -> load -> view('admin_view');
		$this -> load -> view('footer_view');
	}

	public function queueMap() {
		$data = $_POST;
		$retStr = "queueMap() - ";
		$n = 0;

		$json = json_decode($data["json"]);
		$title = $json->title;
		$bbox_bounds = $json->bounds;
		$bbox_sw = $bbox_bounds->_southWest;
		$bbox_ne = $bbox_bounds->_northEast;
		$bbox_sw_lat = $bbox_sw->lat;
		$bbox_sw_lng = $bbox_sw->lng;
		$bbox_ne_lat = $bbox_ne->lat;
		$bbox_ne_lng = $bbox_ne->lng;
		#foreach ($json as $k=>$v) {
		#	$retStr = $retStr . $k . "=>" . $v;
		#}
		$retStr = $retStr . "-" . $title . $bbox_sw_lat .$bbox_sw_lng;
		echo $retStr;
	}

	public function initialise_db() {
		echo 'initialise_db';
		// Initialise the queue table
		$sql = $this -> queue_model -> get_initialise_sql();
		echo $sql;
		mysql_query($sql) or die(mysql_error());

		// Initialise the users table
		$sql = $this -> users_model -> get_initialise_sql();
		echo $sql;
		mysql_query($sql) or die(mysql_error());

		$sql = $this -> mapspecs_model -> get_initialise_sql();
		echo $sql;
		mysql_query($sql) or die(mysql_error());

		// Initialise the session data table
		$sql = "CREATE TABLE IF NOT EXISTS  `ci_sessions` (
>>>>>>> 59ddc81ffe2fcb22c8f5c3454d07e01607c4313e
session_id varchar(40) DEFAULT '0' NOT NULL,
ip_address varchar(16) DEFAULT '0' NOT NULL,
user_agent varchar(50) NOT NULL,
last_activity int(10) unsigned DEFAULT 0 NOT NULL,
user_data text DEFAULT '' NOT NULL,
PRIMARY KEY (session_id)
);";
		mysql_query($sql) or die(mysql_error());

	}

}