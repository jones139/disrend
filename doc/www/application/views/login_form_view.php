<?php
echo "<h3>Login</h3>";
echo "<h4>".$errmsg."</h4>";
echo form_open('login/login');
echo form_input('uname','enter user name');
echo form_password('passwd','');
echo form_submit('submit','submit');
echo anchor("login/register","Register");
echo form_close();
?>