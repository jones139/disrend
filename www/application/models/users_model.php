<?php 
class Users_model extends CI_Model {

    var $user_id   = '';
    var $uname     = '';
    var $passwd    = '';
    var $full_name = '';
    var $email     = '';
    var $role      = '1';  // 0=disabled, 1=user, 2=admin

    function __construct()
    {
      // Call the Model constructor
      parent::__construct();
    }
    
    function get_users()
      /** 
       * List all users
       */
    {
      $query = $this->db->get('users');
      return $query;
    }

    function get_user_by_id($user_id)
      /** 
       * get the details of user number user_id - returned as an array;
       */
    {
      $this->db->where('user_id',$user_id);
      $query = $this->db->get('users');
      return $query->first_row('array');
    }

    function get_username_by_id($user_id)
      /** 
       * get the user name of user number user_id;
       */
    {
      $this->db->where('user_id',$user_id);
      $query = $this->db->get('users');
	  $row = $query->first_row('array');
		if ($row != NULL) {
	  		$uname = $row['uname'];
		} else {
			$uname = "Anonymous";
		}
      return $uname;
    }


    function get_user_by_uname($uname)
      /** 
       * get the details of user number user name - returned as an array;
       */
    {
      $this->db->where('uname',$uname);
      $query = $this->db->get('users');
      return $query->first_row('array');
    }


    function add_user($uname,$passwd,$full_name,$email,$role)
    {
        $this->uname = $uname; 
        $this->passwd = md5($passwd);
        $this->full_name = $full_name;
        $this->email = $email;
        $this->role = $role;

        $this->db->insert('users', $this);
    }

    function update_user($user_id,$uname,$passwd,$full_name,$email,$role)
    {
	if ($uname!='') $data['uname']=$uname;
	if ($passwd!='') $data['passwd']=md5($passwd);
	if ($full_name!='') $data['full_name']=$full_name;
	if ($email!='') $data['email']=$email;
	if ($role!='') $data['role']=$role;

	$this->db->where('user_id',$user_id);
	$this->db->update('users',$data);
    }

    function set_passwd($user_id,$passwd)
    {
      $this->passwd = md5($passwd);
      $this->db->update('users', $this, array('user_id' => $user_id));
    }

    /**
     * validate_user:  returns TRUE if the user name and
     *    password passed as parameters match an entry in
     *    the database, or false if they do not
     */
    function validate_user($uname,$passwd) 
    {
      $this->db->select('uname,passwd');
      $query = $this->db->get_where('users', 
				    array('uname' => $uname) 
				    );   
      if ($query->num_rows() > 0)
	{
	  foreach ($query->result() as $row)
	    {
	      $db_passwd = $row->passwd;
	      $db_uname= $row->uname;
	      if ($db_passwd == md5($passwd))
		{
		  return TRUE;
		}
	      else 
		{
		  echo "passwd=".$passwd." db_passwd=".$db_passwd;
		  return FALSE;
		}
	    }
	}
      else 
	{
	  echo "user_id ".$user_id." not found";
	  return FALSE;
	}
    }
    
    /**
     * umame available:  returns TRUE if the specified user
     * name is available for use (not used already), or false
     * if it has been taken.
     */
    function uname_available($uname)
    {
      $this->db->select('uname');
      $query = $this->db->get_where('users', 
				    array('uname' => $uname) 
				    );   
      if ($query->num_rows() > 0)
	{
	  return FALSE;
	}
      else
	{
	  return TRUE;
	}
    }


    function role_to_text($role)
    /* Converts a role as a number to a text string. */
    {
      switch ($role) {
      case 0:
	$roleText="Inactive";
	break;
      case 1:
	$roleText="User";
	break;
      case 2:
	$roleText="Administrator";
	break;
      default:
	$roleText="Unknown Role (".$role.")";
      }
      return $roleText;
    }

   function get_initialise_sql()
    {
      $sql = "create table if not exists `users`"
	. " ( `user_id` int(11) not null auto_increment primary key,"
	. "`uname` varchar(32),"
	. "`passwd` varchar(128),"
	. "`email` varchar(128),"
	. "`full_name` varchar(128),"
	. "`role` int(11)"
	. ")";
      return $sql;
    }
 
}

?>