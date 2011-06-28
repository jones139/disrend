<?php class JobQueue_model extends CI_Model {

    var $id   = '';
    var $userId = '';
    var $mapSpecId     = '';
    var $rendererId    = '';
    var $status = '';
    var $submitTime = '';
    var $renderStartTime = '';
    var $statusTime = '';

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
	$query = $this->db->get('JobQueue');
      } else {
	$query = $this->db->get('JobQueue',$limit);
      }
      return $query;
    }

    function delete_job($job_id)
    {
      $this->db->where('id',$job_id);
      $this->db->delete('JobQueue');
    }

    function set_job_status($job_id,$status)
    {
      $data=array('status'=>$status,
		  'submit_time'=>date(DATE_ATOM)
		  );
      $this->db->where('id',$job_id);
      $this->db->update('JobQueue',$data);
    }

    function retry_job($job_id)
    {
      $this->set_job_status($job_id,0);
    }

    function add_job($user_id,$map_id)
    {
      $this->userId = $user_id;
      $this->mapSpecId = $map_id;
      $this->rendererId = -1;
      $this->status = 0;
      $this->submitTime = date(DATE_ATOM);
      $this->renderStartTime = -1;
      $this->statusTime = -1;

      echo "submit_time=".$this->submit_time;

      $this->db->insert('queue', $this);
    }


    function get_initialise_sql()
    {
    	$sql = "create table if not exists `JobQueue` (
		`id` int(11) not null auto_increment primary key,
		`userId` int(11) default 0,
		`mapSpecId` int(11) default 0,
		`rendererId` int(11),
		`status` int(11) default 0,
		`submitTime` datetime,
		`renderStartTime` datetime,
		`statusTime` datetime
		);";
		
      return $sql;
    }
}


