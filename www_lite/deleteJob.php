<?php
  $jobNo       = $_REQUEST['jobNo'] ;

  include("APIconfig.php");
  include("dbconn.php");

  $query  = "delete from queue where jobNo =".$jobNo;
  $result = mysql_query($query) 
  	  or die('Query failed: ' . mysql_error());
  print $jobNo;

?>
