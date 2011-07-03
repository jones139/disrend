<?php

class login extends CI_Controller {

	public function __construct() {
		parent::__construct();
		// Your own constructor code
		$this -> load -> library('session');
		$this -> load -> library('form_validation', 'input');
		$this -> load -> helper('url');
		$this -> load -> helper('form');
		$this -> load -> database();
		$this -> load -> model('users_model');
	}

	function index() {
		$this -> login();
	}

	/**
	 * Display the login form
	 */
	function login() {
		if(!$this -> input -> post('submit')) {
			$data['data'] = array('errmsg' => "");
			$data['main_content'] = 'login_form_view';
			$this -> load -> view('include/site_template', $data);
		} else {
			$uname = $this -> input -> post('uname');
			$passwd = $this -> input -> post('passwd');
			//echo "validate_login: uname=".$uname." passwd=".$passwd.".";
			if($this -> users_model -> validate_user($uname, $passwd) == TRUE) {
				$userdata = $this -> users_model -> get_user_by_uname($uname);
				$session_data['uname'] = $uname;
				$session_data['user_id'] = $userdata['user_id'];
				$session_data['role'] = $userdata['role'];
				$session_data['logged_in'] = TRUE;
				$this -> session -> set_userdata($session_data);
				#$this->load->view('header_view');
				$data['main_content'] = 'login_validate_success';
				$this -> load -> view('include/site_template', $data);
			} else {
				#$this->load->view('header_view');
				$data['data'] = array('errmsg' => "Invalid Username or Password - Pleast Try Again");
				$data['main_content'] = 'login_form_view';
				$this -> load -> view('include/site_template', $data);
			}
		}
		#    $this->load->view('footer_view');
	}

	public function logout() {
		$session_data['uname'] = "";
		$session_data['logged_in'] = FALSE;
		$session_data['role'] = 0;
		
		$this -> session -> set_userdata($session_data);
		$this -> session -> sess_destroy();

		$data['main_content'] = 'message_view';
		$data['data'] = array(
			'title'=>'Logout',
			'msg' => "You have logged out successfully...."
			);
		$this -> load -> view('include/site_template', $data);

	}

	/**
	 * Show the user registration form
	 */
	function register() {
		#$this->load->view('header_view');

		$this -> form_validation -> set_rules('uname', 'Username', 'required');
		$this -> form_validation -> set_rules('password', 'Password', 'required');
		$this -> form_validation -> set_rules('passconf', 'Password Confirmation', 'required');
		$this -> form_validation -> set_rules('passconf', 'Password Confirmation', 'matches[password]');
		$this -> form_validation -> set_rules('email', 'Email', 'required');

		if($this -> form_validation -> run() == FALSE) {
			$maindata['errmsg'] = "";
			$data['main_content'] = 'login_register_form.php';
			$data['data'] = $maindata;
			$this -> load -> view('include/site_template', $data);
		} else {
			$uname = $this -> input -> post('uname');
			$passwd = $this -> input -> post('password');
			$full_name = $this -> input -> post('full_name');
			$email = $this -> input -> post('email');
			$role = 1;
			if($this -> users_model -> uname_available($uname)) {
				// user name available - create username.
				$this -> users_model -> add_user($uname, $passwd, $full_name, $email, $role);
				$data['main_content'] = 'login_register_success';
				$this -> load -> view('include/site_template', $data);
			} else {
				// invalid user name
				$maindata['errmsg'] = "Invalid user name - please try again.";
				$data['data'] = $maindata;
				$data['main_content'] = 'login_register_form';
				$this -> load -> view('include/site_template', $data);
			}
		}
		#    $this->load->view('footer_view');
	}

	public function edit_user($user_id =null) {
		/**
		 * This function is called either by accessing the ...edit_user/user_id
		 * url directly, or by pressing the submit button on the edit form.
		 * if the submit button is pressed, the user_id is passed as POST data
		 * rather than in the URL
		 */
		#   $this->load->view('header_view');

		/* If the user_id is not specified in the URL, this function must have
		 * been called by the form, so the user_id is in the POST data.
		 */
		if($user_id == null) {
			foreach($_POST as $key => $value) {
				$post_data[$key] = $this -> input -> post($key);
			}
			$user_id = $this -> input -> post('user_id');
		}
		$this -> form_validation -> set_rules('passconf', 'Password Confirmation', 'matches[password]');

		$db_data = $this -> users_model -> get_user_by_id($user_id);

		/* If we have pressed the 'submit' button, we should use the POST
		 * data to re-populate the form if necessary, otherwise we need to
		 * provide the current data, extracted from the database
		 */
		if($this -> input -> post('submit')) {
			$data = $post_data;
		} else {
			$data = $db_data;
		}

		if($this -> form_validation -> run() == FALSE) {
			if(($data['user_id'] == $this -> session -> userdata('user_id')) or ($this -> session -> userdata('role') == 2)) {

				$data['data'] = $data;
				$data['main_content'] = 'login_edit_user';
				$this -> load -> view('include/site_template', $data);
			} else {
				$maindata = array('title' => 'ERROR', 'msg' => 'Only an administrator can change the configuration of a different user.');
				$data['data'] = $maindata;
				$data['main_content'] = 'login_message';
				$this -> load -> view('include/site_template', $data);

			}
		} else {
			$uname = $this -> input -> post('uname');
			$passwd = $this -> input -> post('password');
			$full_name = $this -> input -> post('full_name');
			$email = $this -> input -> post('email');
			$role = $this -> input -> post('role');
			// user name available - create username.
			$this -> users_model -> update_user($user_id, $uname, $passwd, $full_name, $email, $role);
			$data['main_content'] = 'message_view';
			$data['data'] = array(
					'title'=>'User Data Updated',
					'msg'=>'User Data Updated Successfully.'
					);
			$this -> load -> view('include/site_template', $data);
		}
		#    $this->load->view('footer_view');
	}

	public function list_users() {
		$data['query'] = $this -> users_model -> get_users();
		;
		#   $this->load->view('header_view',$data);
		if($this -> session -> userdata('role') == 2) {
			$data['data'] = $data;
			$data['main_content'] = 'login_list_users';
			$this -> load -> view('include/site_template', $data);
		} else {
			$data['data'] = array('title' => 'ERROR', 'msg' => 'Only an administrator can list users.');
			$this -> load -> view('include/site_template', $data);
		}
		#    $this->load->view('footer_view');

	}

}?>

