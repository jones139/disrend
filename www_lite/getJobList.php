<?php
  header('Content-type: application/json');
  include("APIconfig.php");
  include("dbconn.php");

  $query = "select jobNo,status,title from queue";
  $result = mysql_query($query) 
  	     	 or die('Query failed: ' . mysql_error());
  $rows = array();
  while($r = mysql_fetch_assoc($result)) {
    $rows[] = $r;
  }
  print json_encode($rows);  

?>
