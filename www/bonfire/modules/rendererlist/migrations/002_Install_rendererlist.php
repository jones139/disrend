<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Install_rendererlist extends Migration {
	
	public function up() 
	{
		$prefix = $this->db->dbprefix;

		$this->dbforge->add_field('`id` int(11) NOT NULL AUTO_INCREMENT');
			$this->dbforge->add_field("`rendererlist_bbox` VARCHAR(255) NOT NULL");
			$this->dbforge->add_field("`rendererlist_name` VARCHAR(255) NOT NULL");
			$this->dbforge->add_field("`rendererlist_url` VARCHAR(255) NOT NULL");
			$this->dbforge->add_field("`rendererlist_status` INT(3) NOT NULL");
		$this->dbforge->add_key('id', true);
		$this->dbforge->create_table('rendererlist');

	}
	
	//--------------------------------------------------------------------
	
	public function down() 
	{
		$prefix = $this->db->dbprefix;

		$this->dbforge->drop_table('rendererlist');

	}
	
	//--------------------------------------------------------------------
	
}