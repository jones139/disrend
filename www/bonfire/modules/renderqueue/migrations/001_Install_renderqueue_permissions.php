<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Install_renderqueue_permissions extends Migration {
	
	public function up() 
	{
		$prefix = $this->db->dbprefix;


		// permissions
					$this->db->query("INSERT INTO {$prefix}permissions VALUES (0,'RenderQueue.Content.View','','active');");
					$this->db->query("INSERT INTO {$prefix}role_permissions VALUES (1,".$this->db->insert_id().");");
					$this->db->query("INSERT INTO {$prefix}permissions VALUES (0,'RenderQueue.Content.Create','','active');");
					$this->db->query("INSERT INTO {$prefix}role_permissions VALUES (1,".$this->db->insert_id().");");
					$this->db->query("INSERT INTO {$prefix}permissions VALUES (0,'RenderQueue.Content.Edit','','active');");
					$this->db->query("INSERT INTO {$prefix}role_permissions VALUES (1,".$this->db->insert_id().");");
					$this->db->query("INSERT INTO {$prefix}permissions VALUES (0,'RenderQueue.Content.Delete','','active');");
					$this->db->query("INSERT INTO {$prefix}role_permissions VALUES (1,".$this->db->insert_id().");");
					$this->db->query("INSERT INTO {$prefix}permissions VALUES (0,'RenderQueue.Reports.View','','active');");
					$this->db->query("INSERT INTO {$prefix}role_permissions VALUES (1,".$this->db->insert_id().");");
					$this->db->query("INSERT INTO {$prefix}permissions VALUES (0,'RenderQueue.Reports.Create','','active');");
					$this->db->query("INSERT INTO {$prefix}role_permissions VALUES (1,".$this->db->insert_id().");");
					$this->db->query("INSERT INTO {$prefix}permissions VALUES (0,'RenderQueue.Reports.Edit','','active');");
					$this->db->query("INSERT INTO {$prefix}role_permissions VALUES (1,".$this->db->insert_id().");");
					$this->db->query("INSERT INTO {$prefix}permissions VALUES (0,'RenderQueue.Reports.Delete','','active');");
					$this->db->query("INSERT INTO {$prefix}role_permissions VALUES (1,".$this->db->insert_id().");");
					$this->db->query("INSERT INTO {$prefix}permissions VALUES (0,'RenderQueue.Settings.View','','active');");
					$this->db->query("INSERT INTO {$prefix}role_permissions VALUES (1,".$this->db->insert_id().");");
					$this->db->query("INSERT INTO {$prefix}permissions VALUES (0,'RenderQueue.Settings.Create','','active');");
					$this->db->query("INSERT INTO {$prefix}role_permissions VALUES (1,".$this->db->insert_id().");");
					$this->db->query("INSERT INTO {$prefix}permissions VALUES (0,'RenderQueue.Settings.Edit','','active');");
					$this->db->query("INSERT INTO {$prefix}role_permissions VALUES (1,".$this->db->insert_id().");");
					$this->db->query("INSERT INTO {$prefix}permissions VALUES (0,'RenderQueue.Settings.Delete','','active');");
					$this->db->query("INSERT INTO {$prefix}role_permissions VALUES (1,".$this->db->insert_id().");");
					$this->db->query("INSERT INTO {$prefix}permissions VALUES (0,'RenderQueue.Developer.View','','active');");
					$this->db->query("INSERT INTO {$prefix}role_permissions VALUES (1,".$this->db->insert_id().");");
					$this->db->query("INSERT INTO {$prefix}permissions VALUES (0,'RenderQueue.Developer.Create','','active');");
					$this->db->query("INSERT INTO {$prefix}role_permissions VALUES (1,".$this->db->insert_id().");");
					$this->db->query("INSERT INTO {$prefix}permissions VALUES (0,'RenderQueue.Developer.Edit','','active');");
					$this->db->query("INSERT INTO {$prefix}role_permissions VALUES (1,".$this->db->insert_id().");");
					$this->db->query("INSERT INTO {$prefix}permissions VALUES (0,'RenderQueue.Developer.Delete','','active');");
					$this->db->query("INSERT INTO {$prefix}role_permissions VALUES (1,".$this->db->insert_id().");");
	}
	
	//--------------------------------------------------------------------
	
	public function down() 
	{
		$prefix = $this->db->dbprefix;

        // permissions
					$query = $this->db->query("SELECT permission_id FROM {$prefix}permissions WHERE name='RenderQueue.Content.View';");
					foreach ($query->result_array() as $row)
					{
						$permission_id = $row['permission_id'];
						$this->db->query("DELETE FROM {$prefix}role_permissions WHERE permission_id='$permission_id';");
					}
					$this->db->query("DELETE FROM {$prefix}permissions WHERE name='RenderQueue.Content.View';");
					$query = $this->db->query("SELECT permission_id FROM {$prefix}permissions WHERE name='RenderQueue.Content.Create';");
					foreach ($query->result_array() as $row)
					{
						$permission_id = $row['permission_id'];
						$this->db->query("DELETE FROM {$prefix}role_permissions WHERE permission_id='$permission_id';");
					}
					$this->db->query("DELETE FROM {$prefix}permissions WHERE name='RenderQueue.Content.Create';");
					$query = $this->db->query("SELECT permission_id FROM {$prefix}permissions WHERE name='RenderQueue.Content.Edit';");
					foreach ($query->result_array() as $row)
					{
						$permission_id = $row['permission_id'];
						$this->db->query("DELETE FROM {$prefix}role_permissions WHERE permission_id='$permission_id';");
					}
					$this->db->query("DELETE FROM {$prefix}permissions WHERE name='RenderQueue.Content.Edit';");
					$query = $this->db->query("SELECT permission_id FROM {$prefix}permissions WHERE name='RenderQueue.Content.Delete';");
					foreach ($query->result_array() as $row)
					{
						$permission_id = $row['permission_id'];
						$this->db->query("DELETE FROM {$prefix}role_permissions WHERE permission_id='$permission_id';");
					}
					$this->db->query("DELETE FROM {$prefix}permissions WHERE name='RenderQueue.Content.Delete';");
					$query = $this->db->query("SELECT permission_id FROM {$prefix}permissions WHERE name='RenderQueue.Reports.View';");
					foreach ($query->result_array() as $row)
					{
						$permission_id = $row['permission_id'];
						$this->db->query("DELETE FROM {$prefix}role_permissions WHERE permission_id='$permission_id';");
					}
					$this->db->query("DELETE FROM {$prefix}permissions WHERE name='RenderQueue.Reports.View';");
					$query = $this->db->query("SELECT permission_id FROM {$prefix}permissions WHERE name='RenderQueue.Reports.Create';");
					foreach ($query->result_array() as $row)
					{
						$permission_id = $row['permission_id'];
						$this->db->query("DELETE FROM {$prefix}role_permissions WHERE permission_id='$permission_id';");
					}
					$this->db->query("DELETE FROM {$prefix}permissions WHERE name='RenderQueue.Reports.Create';");
					$query = $this->db->query("SELECT permission_id FROM {$prefix}permissions WHERE name='RenderQueue.Reports.Edit';");
					foreach ($query->result_array() as $row)
					{
						$permission_id = $row['permission_id'];
						$this->db->query("DELETE FROM {$prefix}role_permissions WHERE permission_id='$permission_id';");
					}
					$this->db->query("DELETE FROM {$prefix}permissions WHERE name='RenderQueue.Reports.Edit';");
					$query = $this->db->query("SELECT permission_id FROM {$prefix}permissions WHERE name='RenderQueue.Reports.Delete';");
					foreach ($query->result_array() as $row)
					{
						$permission_id = $row['permission_id'];
						$this->db->query("DELETE FROM {$prefix}role_permissions WHERE permission_id='$permission_id';");
					}
					$this->db->query("DELETE FROM {$prefix}permissions WHERE name='RenderQueue.Reports.Delete';");
					$query = $this->db->query("SELECT permission_id FROM {$prefix}permissions WHERE name='RenderQueue.Settings.View';");
					foreach ($query->result_array() as $row)
					{
						$permission_id = $row['permission_id'];
						$this->db->query("DELETE FROM {$prefix}role_permissions WHERE permission_id='$permission_id';");
					}
					$this->db->query("DELETE FROM {$prefix}permissions WHERE name='RenderQueue.Settings.View';");
					$query = $this->db->query("SELECT permission_id FROM {$prefix}permissions WHERE name='RenderQueue.Settings.Create';");
					foreach ($query->result_array() as $row)
					{
						$permission_id = $row['permission_id'];
						$this->db->query("DELETE FROM {$prefix}role_permissions WHERE permission_id='$permission_id';");
					}
					$this->db->query("DELETE FROM {$prefix}permissions WHERE name='RenderQueue.Settings.Create';");
					$query = $this->db->query("SELECT permission_id FROM {$prefix}permissions WHERE name='RenderQueue.Settings.Edit';");
					foreach ($query->result_array() as $row)
					{
						$permission_id = $row['permission_id'];
						$this->db->query("DELETE FROM {$prefix}role_permissions WHERE permission_id='$permission_id';");
					}
					$this->db->query("DELETE FROM {$prefix}permissions WHERE name='RenderQueue.Settings.Edit';");
					$query = $this->db->query("SELECT permission_id FROM {$prefix}permissions WHERE name='RenderQueue.Settings.Delete';");
					foreach ($query->result_array() as $row)
					{
						$permission_id = $row['permission_id'];
						$this->db->query("DELETE FROM {$prefix}role_permissions WHERE permission_id='$permission_id';");
					}
					$this->db->query("DELETE FROM {$prefix}permissions WHERE name='RenderQueue.Settings.Delete';");
					$query = $this->db->query("SELECT permission_id FROM {$prefix}permissions WHERE name='RenderQueue.Developer.View';");
					foreach ($query->result_array() as $row)
					{
						$permission_id = $row['permission_id'];
						$this->db->query("DELETE FROM {$prefix}role_permissions WHERE permission_id='$permission_id';");
					}
					$this->db->query("DELETE FROM {$prefix}permissions WHERE name='RenderQueue.Developer.View';");
					$query = $this->db->query("SELECT permission_id FROM {$prefix}permissions WHERE name='RenderQueue.Developer.Create';");
					foreach ($query->result_array() as $row)
					{
						$permission_id = $row['permission_id'];
						$this->db->query("DELETE FROM {$prefix}role_permissions WHERE permission_id='$permission_id';");
					}
					$this->db->query("DELETE FROM {$prefix}permissions WHERE name='RenderQueue.Developer.Create';");
					$query = $this->db->query("SELECT permission_id FROM {$prefix}permissions WHERE name='RenderQueue.Developer.Edit';");
					foreach ($query->result_array() as $row)
					{
						$permission_id = $row['permission_id'];
						$this->db->query("DELETE FROM {$prefix}role_permissions WHERE permission_id='$permission_id';");
					}
					$this->db->query("DELETE FROM {$prefix}permissions WHERE name='RenderQueue.Developer.Edit';");
					$query = $this->db->query("SELECT permission_id FROM {$prefix}permissions WHERE name='RenderQueue.Developer.Delete';");
					foreach ($query->result_array() as $row)
					{
						$permission_id = $row['permission_id'];
						$this->db->query("DELETE FROM {$prefix}role_permissions WHERE permission_id='$permission_id';");
					}
					$this->db->query("DELETE FROM {$prefix}permissions WHERE name='RenderQueue.Developer.Delete';");
	}
	
	//--------------------------------------------------------------------
	
}