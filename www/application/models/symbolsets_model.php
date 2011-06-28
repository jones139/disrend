<?php 
class SymbolSets_model extends CI_Model {

    var $id   = '';
	var $userId = '';
    var $description='';
    var $symbolSetArch = '';

    function __construct()
    {
      // Call the Model constructor
      parent::__construct();
    }
    
    function get_symbolsets()
      /** 
       * List all symbolsets
       */
    {
      $query = $this->db->get('SymbolSets');
      return $query;
    }

    function get_symbolset_by_id($id)
      /** 
       * retrieve symbol set number $id - returned as an array;
       */
    {
      $this->db->where('id',$id);
      $query = $this->db->get('SymbolSets');
      return $query->first_row('array');
    }

    function add_symbol_set(
		     $user_id,
		     $description,
		     $symbolSetArch
			)
    {
        $this->user_id = $user_id; 
        $this->description = $description;
        $this->symbolSetArch = $symbolSetArch;

        $this->db->insert('SymbolSets', $this);
    }

    function update_symbolSet($id,
		     $user_id,
		     $description,
		     $symbolSetArch)
    {
	if ($user_id!='') $data['user_id']=$user_id;
	if ($description!='') $data['description']=$description;
	if ($symbolSetArch!='') $data['symbolSetArch']=$symbolSetArch;

	$this->db->where('id',$id);
	$this->db->update('SymbolSets',$data);
    }


   function get_initialise_sql()
    {
		$sql = "create table if not exists `SymbolSets` ( 
		`id` int(11) not null auto_increment primary key,
		`userId` int(11) default 0,
		`description` varchar(512),
		`symbolSetArch` blob
		);";
      return $sql;
    }
 
}

?>