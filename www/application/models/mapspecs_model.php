<?php 
class Mapspecs_model extends CI_Model {

    var $id   = '';
    var $userId = '';
    var $title = '';
    var $description='';
    var $mapRendererId     = '';
    var $styleId = '';
    var $bboxLonMin = '';
    var $bboxLatMin = '';
    var $bboxLonMax = '';  
    var $bboxLatMax = '';

    function __construct()
    {
      // Call the Model constructor
      parent::__construct();
    }
    
    function get_mapspecs()
      /** 
       * List all mapspecs
       */
    {
      $query = $this->db->get('MapSpecs');
      return $query;
    }

    function get_mapspec($id)
      /** 
       * get the details of map number id - returned as an array;
       */
    {
      $this->db->where('id',$id);
      $query = $this->db->get('MapSpecs');
      return $query->first_row('array');
    }


    function create_mapspec() {
      /**
       * Creates a new mapspec with default data
       */
        $this->mapRendererId = ""; 
	$this->title = "New Mapspec";
	$this->userId = $this -> session -> userdata('user_id');
	$this->description = "New Mapspec";
        $this->styleId = 1;
        $this->bboxLonMin = 0;
        $this->bboxLatMin = 0;
        $this->bboxLonMax = 0;
        $this->bboxLatMax = 0;

        $this->db->insert('MapSpecs', $this);
	$id = $this->db->insert_id();
	return($id);
    }

    function add_map(
		     $mapRendererId,
		     $styleId,
		     $bboxLonMin,
		     $bboxLatMin,
		     $bboxLonMax,
		     $bboxLatMax)
    {
        $this->mapRendererId = $mapRendererId; 
        $this->styleId = $styleId;
        $this->bboxLonMin = $bboxLonMin;
        $this->bboxLatMin = $bboxLatMin;
        $this->bboxLonMax = $bboxLatMax;
        $this->bboxLatMax = $bboxLatMax;

        $this->db->insert('MapSpecs', $this);
    }

    function update_map($id,
		     $mapRendererId,
		     $styleId,
		     $bboxLonMin,
		     $bboxLatMin,
		     $bboxLonMax,
		     $bboxLatMax)
    {
	if ($mapRendererId!='') $data['mapRendererId']=$mapRendererId;
	if ($styleId!='') $data['styleId']=styleId;
	if ($bboxLonMin!='') $data['bboxLonMin']=$bboxLonMin;
	if ($bboxLatMin!='') $data['bboxLatMin']=$bboxLatMin;
	if ($bboxLonMax!='') $data['bboxLonMax']=$bboxLonMax;
	if ($bboxLatMax!='') $data['bboxLatMax']=$bboxLatMax;

	$this->db->where('id',$user_id);
	$this->db->update('MapSpecs',$data);
    }


   function get_initialise_sql()
    {
   		$sql = "create table if not exists `MapSpecs` ( 
		`id` int(11) not null auto_increment primary key,
                `userId` int(11),
		`title` varchar(128),
		`description` varchar(512),
		`mapRendererId` int(11),
		`styleId` int(11),
		`bboxLonMin` double,
		`bboxLatMin` double,
		`bboxLonMax` double,
		`bboxLatMax` double,
		`mapSpec` text
		);";
      return $sql;
    }
 
}

?>