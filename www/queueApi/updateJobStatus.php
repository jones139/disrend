<?php
  $jobNo       = $_REQUEST['jobNo'] ;
  $statusNo    = $_REQUEST['statusNo'];

  include("APIconfig.php");
  include("dbconn.php");

  $nowStr = gmDate("Y-m-d H:i:s");
  $query  = "update queue set status=".$statusNo.", statusDate='".$nowStr.
  	  "' where jobNo =".$jobNo;
  $result = mysql_query($query) 
  	  or die('Query failed: ' . mysql_error());
  if (mysql_affected_rows()>0) {
     print $jobNo;
  }
  else {
     print "0";
  }
?>
