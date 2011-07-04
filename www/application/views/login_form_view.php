<?php
echo "<h3>Login</h3>";
echo "<h4>".$errmsg."</h4>";
echo form_open('login/login');
echo "<label for='uname'>User Name:</label>"; 
echo form_input('uname','');
echo "<br/>";
echo "<label for='passwd'>Password:</label>"; 
echo form_password('passwd','');
echo "<br/>";
echo form_submit('submit','Log In');
echo anchor("login/register","Register");
echo form_close();
?>