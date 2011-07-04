<html>
<head>
<title>Register</title>
</head>
<body>

 <h3><?php echo $errmsg; ?></h3>

<?php echo validation_errors(); ?>

<?php echo form_open('login/register'); ?>

<label for="uname">User Name:</label> 
<input type="text" name="uname" value="<?php echo set_value('uname'); ?>" size="20" />
<?php echo form_error('uname'); ?>
<br/>

<label for="password">Password:</label> 
<input type="password" name="password" value="<?php echo set_value('password'); ?>" size="20" />
<?php echo form_error('password'); ?>
<br/>

<label for="passconf">Confirm Password:</label> 
<input type="password" name="passconf" value="<?php echo set_value('passconf'); ?>" size="20" />
<?php echo form_error('passconf'); ?>
<br/>

<label for="email">Email Address:</label> 
<input type="text" name="email" value="<?php echo set_value('email'); ?>" size="30" />
<?php echo form_error('email'); ?>
<br/>

<input type="submit" value="Submit" />

</form>
