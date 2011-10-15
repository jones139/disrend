<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Install_styles extends Migration {
	
	public function up() 
	{
		$prefix = $this->db->dbprefix;

		$this->dbforge->add_field('`id` int(11) NOT NULL AUTO_INCREMENT');
			$this->dbforge->add_field("`styles_userid` INT(3) NOT NULL");
			$this->dbforge->add_field("`styles_description` VARCHAR(255) NOT NULL");
			$this->dbforge->add_field("`styles_basesymbolsetid` INT(3) NOT NULL");
			$this->dbforge->add_field("`styles_symbolsetid` INT(3) NOT NULL");
			$this->dbforge->add_field("`styles_style` BLOB NOT NULL");
		$this->dbforge->add_key('id', true);
		$this->dbforge->create_table('styles');

	}
	
	//--------------------------------------------------------------------
	
	public function down() 
	{
		$prefix = $this->db->dbprefix;

		$this->dbforge->drop_table('styles');

	}
	
	//--------------------------------------------------------------------
	
}