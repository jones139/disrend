<?php 
class Mapspecs_model extends CI_Model {

    var $map_id   = '';
    var $map_title = '';
    var $map_description='';
    var $map_renderer     = '';
    var $style_id = '';
    var $bbox_lon_min = '';
    var $bbox_lat_min = '';
    var $size_x = '';  
    var $size_y = '';

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
      $query = $this->db->get('mapspecs');
      return $query;
    }

    function get_mapspec_by_id($map_id)
      /** 
       * get the details of map number map_id - returned as an array;
       */
    {
      $this->db->where('map_id',$map_id);
      $query = $this->db->get('mapspecs');
      return $query->first_row('array');
    }

    function add_map(
		     $map_renderer,
		     $style_id,
		     $bbox_lon_min,
		     $bbox_lat_min,
		     $size_x,
		     $size_y)
    {
        $this->map_renderer = $map_renderer; 
        $this->style_id = $style_id;
        $this->bbox_lon_min = $bbox_lon_min;
        $this->bbox_lat_min = $bbox_lat_min;
        $this->size_x = $size_y;
        $this->size_y = $size_y;

        $this->db->insert('mapspecs', $this);
    }

    function update_map($map_id,
		     $map_renderer,
		     $style_id,
		     $bbox_lon_min,
		     $bbox_lat_min,
		     $size_x,
		     $size_y)
    {
	if ($map_renderer!='') $data['map_renderer']=$map_renderer;
	if ($style_id!='') $data['style_id']=style_id;
	if ($bbox_lon_min!='') $data['bbox_lon_min']=$bbox_lon_min;
	if ($bbox_lat_min!='') $data['bbox_lat_min']=$bbox_lat_min;
	if ($size_x!='') $data['size_x']=$size_x;
	if ($size_y!='') $data['size_y']=$size_y;

	$this->db->where('map_id',$user_id);
	$this->db->update('mapspecs',$data);
    }


   function get_initialise_sql()
    {
      $sql = "create table if not exists `mapspecs`"
	. " ( `map_id` int(11) not null auto_increment primary key,"
	. "`map_title` varchar(128),"
	. "`map_description` varchar(512),"
	. "`map_renderer` int(11),"
	. "`style_id` int(11),"
	. "`bbox_lon_min` double,"
	. "`bbox_lat_min` double,"
	. "`size_x` double,"
	. "`size_y` double"
	. ")";
      return $sql;
    }
 
}

?>