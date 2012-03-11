<?php
  $jobNo       = $_REQUEST['jobNo'] ;

  include("APIConfig.php");
  include("dbconn.php");

  $nowStr = gmDate("Y-m-d H:i:s");
  $query  = "update queue set status=2, statusDate='".$nowStr.
  	  "' where jobNo =".$jobNo.
	  " and status = 1";
  #print $query;
  $result = mysql_query($query) 
  	  or die('Query failed: ' . mysql_error());
  if (mysql_affected_rows()>0) {
     print $jobNo;
  }
  else {
     print "0";
  }
?>
