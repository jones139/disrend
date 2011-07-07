<?php 
echo "<h1>Edit User Data</h1>";
echo validation_errors();
echo form_open('login/edit_user');
echo form_fieldset("Edit User_ID ".$user_id);
echo form_hidden('user_id',$user_id);
echo form_label("Username:");
echo form_error('uname');
echo "<input type='text' name='uname' value='".$uname."' size='20'>";
echo "<br/>";

echo form_label("Password:");
echo form_error('password');
echo "<input type='password' name='password' value='' size='20'>";
echo "<br/>";

echo form_label("Confirm Password:");
echo form_error('passconf'); 
echo "<input type='password' name='passconf' value='' size='20'>";
echo "<br/>";

echo form_label("Email Address:");
echo form_error('email');
echo "<input type='text' name='email' value='".$email."' size='40'>";
echo "<br/>";

   /* Only show the role changer to administrators */
   if ($this->session->userdata('role')==2)
     {
       echo form_label("User Role");
       $options = array(
			0  => 'Account Disabled',
			1    => 'User',
			2   => 'Administrator',
			);

       echo form_dropdown('role',$options,$role);
       echo "<br/>";
     }

echo "<input type='submit' name='submit' value='submit'";
echo form_fieldset_close();
echo "</form>";
echo "</div>";