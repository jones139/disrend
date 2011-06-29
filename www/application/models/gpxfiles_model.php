<?php 
class GPXFiles_model extends CI_Model {

    var $id   = '';
	var $userId = '';
    var $description='';
    var $GPXFile = '';

    function __construct()
    {
      // Call the Model constructor
      parent::__construct();
    }
    
    function get_gpxfiles()
      /** 
       * List all gpxfiles
       */
    {
      $query = $this->db->get('GPXFiles');
      return $query;
    }

    function get_gpxfile_by_id($id)
      /** 
       * retrieve gpxfile number $id - returned as an array;
       */
    {
      $this->db->where('id',$id);
      $query = $this->db->get('GPXFiles');
      return $query->first_row('array');
	}

	function get_default_gpxfile()
	{
		$data['userId']='-1';
		$data['description']='default gpx file';
		$data['GPXFile']='<gpx></gpx>';
		return $data;
	}

	function add_gpxfile(
	$user_id,
	$description,
	$GPXFile
	)
	{
	$this->user_id = $user_id;
	$this->description = $description;
	$this->GPXFile = $GPXFile;

	$this->db->insert('GPXFiles', $this);
    }

    function update_gpxfile($id,
		     $user_id,
		     $description,
		     $GPXFile)
    {
	if ($user_id!='') $data['user_id']=$user_id;
	if ($description!='') $data['description']=$description;
	if ($GPXFile!='') $data['GPXFile']=$GPXFile;

	$this->db->where('id',$id);
	$this->db->update('GPXFiles',$data);
    }


   function get_initialise_sql()
    {
		$sql = "create table if not exists `GPXFiles` ( 
		`id` int(11) not null auto_increment primary key,
		`userId` int(11) default 0,
		`description` varchar(512),
		`GPXFile` blob
		);";
      return $sql;
    }
 
}

?>