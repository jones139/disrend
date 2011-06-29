<!--
********************************************************
*  Now the HTML                                        *
********************************************************
-->
<h2>Fill in the form in each tab in turn to create your map.</h2>
<?php	echo form_open('gpxfiles/edit_gpxfile');?>
<p>
	<label for="desc">
		Description:
	</label>
	<br />
	<?php	echo form_input("description",$description);?>
</p>

<p>
	<label for="gpxdata">
		GPX Data:
	</label>
	<br />
	<?php echo form_textarea("GPXFile",$GPXFile);?>
</p>
<?php echo form_submit('submit', 'Submit');?>
<?php echo form_close();?>

