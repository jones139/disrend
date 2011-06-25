<html>
<head>
<title>Register</title>
</head>
<body>

 <h3><?php echo $errmsg; ?></h3>

<?php echo validation_errors(); ?>

<?php echo form_open('login/register'); ?>

<h5>Username</h5>
<?php echo form_error('uname'); ?>
<input type="text" name="uname" value="<?php echo set_value('uname'); ?>" size="50" />

<h5>Password</h5>
<?php echo form_error('password'); ?>
<input type="password" name="password" value="<?php echo set_value('password'); ?>" size="50" />

<h5>Password Confirm</h5>
<?php echo form_error('passconf'); ?>
<input type="password" name="passconf" value="<?php echo set_value('passconf'); ?>" size="50" />

<h5>Email Address</h5>
<?php echo form_error('email'); ?>
<input type="text" name="email" value="<?php echo set_value('email'); ?>" size="50" />

<div><input type="submit" value="Submit" /></div>

</form>
