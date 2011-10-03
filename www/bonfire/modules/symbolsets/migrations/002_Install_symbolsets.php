<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Install_symbolsets extends Migration {
	
	public function up() 
	{
		$prefix = $this->db->dbprefix;

		$this->dbforge->add_field('`id` int(11) NOT NULL AUTO_INCREMENT');
			$this->dbforge->add_field("`symbolsets_name` VARCHAR(50) NOT NULL");
			$this->dbforge->add_field("`symbolsets_symbolsetfile` BLOB NOT NULL");
			$this->dbforge->add_field("`symbolsets_thumbnail` BLOB NOT NULL");
		$this->dbforge->add_key('id', true);
		$this->dbforge->create_table('symbolsets');

	}
	
	//--------------------------------------------------------------------
	
	public function down() 
	{
		$prefix = $this->db->dbprefix;

		$this->dbforge->drop_table('symbolsets');

	}
	
	//--------------------------------------------------------------------
	
}