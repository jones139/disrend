<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Install_jobqueue_permissions extends Migration {
	
	public function up() 
	{
		$prefix = $this->db->dbprefix;


		// permissions
					$this->db->query("INSERT INTO {$prefix}permissions VALUES (0,'JobQueue.Content.View','','active');");
					$this->db->query("INSERT INTO {$prefix}role_permissions VALUES (1,".$this->db->insert_id().");");
					$this->db->query("INSERT INTO {$prefix}permissions VALUES (0,'JobQueue.Content.Create','','active');");
					$this->db->query("INSERT INTO {$prefix}role_permissions VALUES (1,".$this->db->insert_id().");");
					$this->db->query("INSERT INTO {$prefix}permissions VALUES (0,'JobQueue.Content.Edit','','active');");
					$this->db->query("INSERT INTO {$prefix}role_permissions VALUES (1,".$this->db->insert_id().");");
					$this->db->query("INSERT INTO {$prefix}permissions VALUES (0,'JobQueue.Content.Delete','','active');");
					$this->db->query("INSERT INTO {$prefix}role_permissions VALUES (1,".$this->db->insert_id().");");
					$this->db->query("INSERT INTO {$prefix}permissions VALUES (0,'JobQueue.Reports.View','','active');");
					$this->db->query("INSERT INTO {$prefix}role_permissions VALUES (1,".$this->db->insert_id().");");
					$this->db->query("INSERT INTO {$prefix}permissions VALUES (0,'JobQueue.Reports.Create','','active');");
					$this->db->query("INSERT INTO {$prefix}role_permissions VALUES (1,".$this->db->insert_id().");");
					$this->db->query("INSERT INTO {$prefix}permissions VALUES (0,'JobQueue.Reports.Edit','','active');");
					$this->db->query("INSERT INTO {$prefix}role_permissions VALUES (1,".$this->db->insert_id().");");
					$this->db->query("INSERT INTO {$prefix}permissions VALUES (0,'JobQueue.Reports.Delete','','active');");
					$this->db->query("INSERT INTO {$prefix}role_permissions VALUES (1,".$this->db->insert_id().");");
					$this->db->query("INSERT INTO {$prefix}permissions VALUES (0,'JobQueue.Settings.View','','active');");
					$this->db->query("INSERT INTO {$prefix}role_permissions VALUES (1,".$this->db->insert_id().");");
					$this->db->query("INSERT INTO {$prefix}permissions VALUES (0,'JobQueue.Settings.Create','','active');");
					$this->db->query("INSERT INTO {$prefix}role_permissions VALUES (1,".$this->db->insert_id().");");
					$this->db->query("INSERT INTO {$prefix}permissions VALUES (0,'JobQueue.Settings.Edit','','active');");
					$this->db->query("INSERT INTO {$prefix}role_permissions VALUES (1,".$this->db->insert_id().");");
					$this->db->query("INSERT INTO {$prefix}permissions VALUES (0,'JobQueue.Settings.Delete','','active');");
					$this->db->query("INSERT INTO {$prefix}role_permissions VALUES (1,".$this->db->insert_id().");");
					$this->db->query("INSERT INTO {$prefix}permissions VALUES (0,'JobQueue.Developer.View','','active');");
					$this->db->query("INSERT INTO {$prefix}role_permissions VALUES (1,".$this->db->insert_id().");");
					$this->db->query("INSERT INTO {$prefix}permissions VALUES (0,'JobQueue.Developer.Create','','active');");
					$this->db->query("INSERT INTO {$prefix}role_permissions VALUES (1,".$this->db->insert_id().");");
					$this->db->query("INSERT INTO {$prefix}permissions VALUES (0,'JobQueue.Developer.Edit','','active');");
					$this->db->query("INSERT INTO {$prefix}role_permissions VALUES (1,".$this->db->insert_id().");");
					$this->db->query("INSERT INTO {$prefix}permissions VALUES (0,'JobQueue.Developer.Delete','','active');");
					$this->db->query("INSERT INTO {$prefix}role_permissions VALUES (1,".$this->db->insert_id().");");
	}
	
	//--------------------------------------------------------------------
	
	public function down() 
	{
		$prefix = $this->db->dbprefix;

        // permissions
					$query = $this->db->query("SELECT permission_id FROM {$prefix}permissions WHERE name='JobQueue.Content.View';");
					foreach ($query->result_array() as $row)
					{
						$permission_id = $row['permission_id'];
						$this->db->query("DELETE FROM {$prefix}role_permissions WHERE permission_id='$permission_id';");
					}
					$this->db->query("DELETE FROM {$prefix}permissions WHERE name='JobQueue.Content.View';");
					$query = $this->db->query("SELECT permission_id FROM {$prefix}permissions WHERE name='JobQueue.Content.Create';");
					foreach ($query->result_array() as $row)
					{
						$permission_id = $row['permission_id'];
						$this->db->query("DELETE FROM {$prefix}role_permissions WHERE permission_id='$permission_id';");
					}
					$this->db->query("DELETE FROM {$prefix}permissions WHERE name='JobQueue.Content.Create';");
					$query = $this->db->query("SELECT permission_id FROM {$prefix}permissions WHERE name='JobQueue.Content.Edit';");
					foreach ($query->result_array() as $row)
					{
						$permission_id = $row['permission_id'];
						$this->db->query("DELETE FROM {$prefix}role_permissions WHERE permission_id='$permission_id';");
					}
					$this->db->query("DELETE FROM {$prefix}permissions WHERE name='JobQueue.Content.Edit';");
					$query = $this->db->query("SELECT permission_id FROM {$prefix}permissions WHERE name='JobQueue.Content.Delete';");
					foreach ($query->result_array() as $row)
					{
						$permission_id = $row['permission_id'];
						$this->db->query("DELETE FROM {$prefix}role_permissions WHERE permission_id='$permission_id';");
					}
					$this->db->query("DELETE FROM {$prefix}permissions WHERE name='JobQueue.Content.Delete';");
					$query = $this->db->query("SELECT permission_id FROM {$prefix}permissions WHERE name='JobQueue.Reports.View';");
					foreach ($query->result_array() as $row)
					{
						$permission_id = $row['permission_id'];
						$this->db->query("DELETE FROM {$prefix}role_permissions WHERE permission_id='$permission_id';");
					}
					$this->db->query("DELETE FROM {$prefix}permissions WHERE name='JobQueue.Reports.View';");
					$query = $this->db->query("SELECT permission_id FROM {$prefix}permissions WHERE name='JobQueue.Reports.Create';");
					foreach ($query->result_array() as $row)
					{
						$permission_id = $row['permission_id'];
						$this->db->query("DELETE FROM {$prefix}role_permissions WHERE permission_id='$permission_id';");
					}
					$this->db->query("DELETE FROM {$prefix}permissions WHERE name='JobQueue.Reports.Create';");
					$query = $this->db->query("SELECT permission_id FROM {$prefix}permissions WHERE name='JobQueue.Reports.Edit';");
					foreach ($query->result_array() as $row)
					{
						$permission_id = $row['permission_id'];
						$this->db->query("DELETE FROM {$prefix}role_permissions WHERE permission_id='$permission_id';");
					}
					$this->db->query("DELETE FROM {$prefix}permissions WHERE name='JobQueue.Reports.Edit';");
					$query = $this->db->query("SELECT permission_id FROM {$prefix}permissions WHERE name='JobQueue.Reports.Delete';");
					foreach ($query->result_array() as $row)
					{
						$permission_id = $row['permission_id'];
						$this->db->query("DELETE FROM {$prefix}role_permissions WHERE permission_id='$permission_id';");
					}
					$this->db->query("DELETE FROM {$prefix}permissions WHERE name='JobQueue.Reports.Delete';");
					$query = $this->db->query("SELECT permission_id FROM {$prefix}permissions WHERE name='JobQueue.Settings.View';");
					foreach ($query->result_array() as $row)
					{
						$permission_id = $row['permission_id'];
						$this->db->query("DELETE FROM {$prefix}role_permissions WHERE permission_id='$permission_id';");
					}
					$this->db->query("DELETE FROM {$prefix}permissions WHERE name='JobQueue.Settings.View';");
					$query = $this->db->query("SELECT permission_id FROM {$prefix}permissions WHERE name='JobQueue.Settings.Create';");
					foreach ($query->result_array() as $row)
					{
						$permission_id = $row['permission_id'];
						$this->db->query("DELETE FROM {$prefix}role_permissions WHERE permission_id='$permission_id';");
					}
					$this->db->query("DELETE FROM {$prefix}permissions WHERE name='JobQueue.Settings.Create';");
					$query = $this->db->query("SELECT permission_id FROM {$prefix}permissions WHERE name='JobQueue.Settings.Edit';");
					foreach ($query->result_array() as $row)
					{
						$permission_id = $row['permission_id'];
						$this->db->query("DELETE FROM {$prefix}role_permissions WHERE permission_id='$permission_id';");
					}
					$this->db->query("DELETE FROM {$prefix}permissions WHERE name='JobQueue.Settings.Edit';");
					$query = $this->db->query("SELECT permission_id FROM {$prefix}permissions WHERE name='JobQueue.Settings.Delete';");
					foreach ($query->result_array() as $row)
					{
						$permission_id = $row['permission_id'];
						$this->db->query("DELETE FROM {$prefix}role_permissions WHERE permission_id='$permission_id';");
					}
					$this->db->query("DELETE FROM {$prefix}permissions WHERE name='JobQueue.Settings.Delete';");
					$query = $this->db->query("SELECT permission_id FROM {$prefix}permissions WHERE name='JobQueue.Developer.View';");
					foreach ($query->result_array() as $row)
					{
						$permission_id = $row['permission_id'];
						$this->db->query("DELETE FROM {$prefix}role_permissions WHERE permission_id='$permission_id';");
					}
					$this->db->query("DELETE FROM {$prefix}permissions WHERE name='JobQueue.Developer.View';");
					$query = $this->db->query("SELECT permission_id FROM {$prefix}permissions WHERE name='JobQueue.Developer.Create';");
					foreach ($query->result_array() as $row)
					{
						$permission_id = $row['permission_id'];
						$this->db->query("DELETE FROM {$prefix}role_permissions WHERE permission_id='$permission_id';");
					}
					$this->db->query("DELETE FROM {$prefix}permissions WHERE name='JobQueue.Developer.Create';");
					$query = $this->db->query("SELECT permission_id FROM {$prefix}permissions WHERE name='JobQueue.Developer.Edit';");
					foreach ($query->result_array() as $row)
					{
						$permission_id = $row['permission_id'];
						$this->db->query("DELETE FROM {$prefix}role_permissions WHERE permission_id='$permission_id';");
					}
					$this->db->query("DELETE FROM {$prefix}permissions WHERE name='JobQueue.Developer.Edit';");
					$query = $this->db->query("SELECT permission_id FROM {$prefix}permissions WHERE name='JobQueue.Developer.Delete';");
					foreach ($query->result_array() as $row)
					{
						$permission_id = $row['permission_id'];
						$this->db->query("DELETE FROM {$prefix}role_permissions WHERE permission_id='$permission_id';");
					}
					$this->db->query("DELETE FROM {$prefix}permissions WHERE name='JobQueue.Developer.Delete';");
	}
	
	//--------------------------------------------------------------------
	
}