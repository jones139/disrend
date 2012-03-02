<?php
  $rendererNo       = $_REQUEST['rendererNo'] ;

  include("APIconfig.php");
  include("dbconn.php");

  $query  = "select jobno from queue where renderer =".$rendererNo.
  	  " and status=0 order by jobno asc";
  print $query;
  $result = mysql_query($query) 
  	  or die('Query failed: ' . mysql_error());
  if (mysql_num_rows($result)>0) {
     $row = mysql_fetch_assoc($result);
     print $row['jobno'];
  }
  else {
     print "0";
  }
?>
