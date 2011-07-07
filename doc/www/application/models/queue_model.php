<?php class Queue_model extends CI_Model {

    var $job_id   = '';
    var $user_id = '';
    var $map_id     = '';
    var $renderer_id    = '';
    var $status = '';
    var $submit_time = '';
    var $render_start_time = '';
    var $render_complete_time = '';

    function __construct()
    {
      // Call the Model constructor
      //echo '******* queue_model __construct()********';
      parent::__construct();
    }
    
    function get_jobs($limit=-1)
      /** 
       * List jobs
       */
    {
      if ($limit==-1) {
	$query = $this->db->get('queue');
      } else {
	$query = $this->db->get('queue',$limit);
      }
      return $query;
    }

    function delete_job($job_id)
    {
      $this->db->where('job_id',$job_id);
      $this->db->delete('queue');
    }

    function set_job_status($job_id,$status)
    {
      $data=array('status'=>$status,
		  'submit_time'=>date(DATE_ATOM)
		  );
      $this->db->where('job_id',$job_id);
      $this->db->update('queue',$data);
    }

    function retry_job($job_id)
    {
      $this->set_job_status($job_id,0);
    }

    function add_job($user_id,$map_id)
    {
      $this->user_id = $user_id;
      $this->map_id = $map_id;
      $this->renderer_id = -1;
      $this->status = 0;
      $this->submit_time = date(DATE_ATOM);
      $this->render_start_time = -1;
      $this->render_complete_time = -1;

      echo "submit_time=".$this->submit_time;

      $this->db->insert('queue', $this);
    }


    function get_initialise_sql()
    {
      $sql = "create table if not exists `queue`"
	. " ( `job_id` int(11) not null auto_increment primary key,"
	. "`user_id` int(11) default 0,"
	. "`map_id` int(11) default 0,"
	. "`renderer_id` int(11),"
	. "`status` int(11) default 0,"
	. "`submit_time` datetime,"
	. "`render_start_time` datetime,"
	. "`render_complete_time` datetime);";
      return $sql;
    }
    

}


