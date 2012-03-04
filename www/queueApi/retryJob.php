<?php
  include("APIconfig.php");
  include("dbconn.php");

  $jobNo       = $_REQUEST['jobNo'] ;
  $nowStr = gmDate("Y-m-d H:i:s");
  $query  = "update queue set status=1, statusDate='".$nowStr."' where jobNo =".$jobNo;
  print $query;
  $result = mysql_query($query) 
  	  or die('Query failed: ' . mysql_error());
  print $jobNo;

?>
