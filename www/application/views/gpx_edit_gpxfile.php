<!--
********************************************************
*  Now the HTML                                        *
********************************************************
-->
<h2>Edit GPX Data.</h2>
<?php	echo form_open('gpxfiles/edit');?>
<p>
	<label for="id">GPX File ID:</label> 
	<?php echo form_input("id",$id,"readonly"); ?>
<br/>
	<label for="userId">User ID:</label> 
	<?php echo form_input("userId",$userId,"readonly"); ?>
	<br/>
	<label for="userName">User Name:</label> 
	<?php echo form_input("userName",$uname,"readonly"); ?>

<br/>

	<label for="desccription">
		Description:
	</label>
	<?php	echo form_input("description",$description);?>

<br/>

	<label for="GPXFile">
		GPX Data:
	</label>
	<?php echo form_textarea("GPXFile",$GPXFile);?>
</p>
<?php echo form_submit('submit', 'Submit');?>
<?php echo form_close();?>

