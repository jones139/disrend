<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Install_renderqueue extends Migration {
	
	public function up() 
	{
		$prefix = $this->db->dbprefix;

		$this->dbforge->add_field('`id` int(11) NOT NULL AUTO_INCREMENT');
			$this->dbforge->add_field("`renderqueue_status` TINYINT(4) NOT NULL");
			$this->dbforge->add_field("`renderqueue_rendererid` INT(4) NOT NULL");
			$this->dbforge->add_field("`renderqueue_statusdate` DATE NOT NULL");
			$this->dbforge->add_field("`renderqueue_mapspec` INT(4) NOT NULL");
		$this->dbforge->add_key('id', true);
		$this->dbforge->create_table('renderqueue');

	}
	
	//--------------------------------------------------------------------
	
	public function down() 
	{
		$prefix = $this->db->dbprefix;

		$this->dbforge->drop_table('renderqueue');

	}
	
	//--------------------------------------------------------------------
	
}