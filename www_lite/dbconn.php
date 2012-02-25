<?php
///////////////////////////////////////////////////////////
// Connect to the database.
// This is the only file that needs customising to define the
// database to be used, user name, password etc.
//////////////////////////////////////////////////////////////
$dbconn = mysql_connect("localhost","printmaps","1234")
    or die('Could not connect: ' . mysql_error());
mysql_select_db("printmaps",$dbconn);
?>