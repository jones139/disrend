<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Install_gpxfiles extends Migration {
	
	public function up() 
	{
		$prefix = $this->db->dbprefix;

		$this->dbforge->add_field('`id` int(11) NOT NULL AUTO_INCREMENT');
			$this->dbforge->add_field("`gpxfiles_userid` INT(4) NOT NULL");
			$this->dbforge->add_field("`gpxfiles_description` VARCHAR(512) NOT NULL");
			$this->dbforge->add_field("`gpxfiles_gpxfile` BLOB NOT NULL");
		$this->dbforge->add_key('id', true);
		$this->dbforge->create_table('gpxfiles');

	}
	
	//--------------------------------------------------------------------
	
	public function down() 
	{
		$prefix = $this->db->dbprefix;

		$this->dbforge->drop_table('gpxfiles');

	}
	
	//--------------------------------------------------------------------
	
}