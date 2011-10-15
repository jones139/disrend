<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Install_jobqueue extends Migration {
	
	public function up() 
	{
		$prefix = $this->db->dbprefix;

		$this->dbforge->add_field('`id` int(11) NOT NULL AUTO_INCREMENT');
			$this->dbforge->add_field("`jobqueue_userid` INT(3) NOT NULL");
			$this->dbforge->add_field("`jobqueue_mapspecid` INT(3) NOT NULL");
			$this->dbforge->add_field("`jobqueue_status` INT(3) NOT NULL");
			$this->dbforge->add_field("`jobqueue_rendererid` INT(3) NOT NULL");
			$this->dbforge->add_field("`jobqueue_submittime` DATETIME NOT NULL");
			$this->dbforge->add_field("`jobqueue_renderstarttime` DATETIME NOT NULL");
			$this->dbforge->add_field("`jobqueue_statustime` DATETIME NOT NULL");
		$this->dbforge->add_key('id', true);
		$this->dbforge->create_table('jobqueue');

	}
	
	//--------------------------------------------------------------------
	
	public function down() 
	{
		$prefix = $this->db->dbprefix;

		$this->dbforge->drop_table('jobqueue');

	}
	
	//--------------------------------------------------------------------
	
}