<html>
<head>
<title>Upload GPX File</title>
</head>
<body>

<h5><?php echo $error; ?></h5>

<?php echo form_open_multipart('gpxfiles/upload'); ?>

<h5>Description</h5>
<input type="text" name="description" value="Enter File Description" size="50" />

<h5>File Name</h5>
<input type="file" name="userfile" value="" size="50" />

<div><input type="submit" name="submit" value="Submit" /></div>

</form>
