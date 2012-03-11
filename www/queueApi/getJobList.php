<?php
  header('Content-type: application/json');
  include("APIConfig.php");
  include("dbconn.php");

  $query = "select jobNo,status,title from queue order by jobNo desc";
  $result = mysql_query($query) 
  	     	 or die('Query failed: ' . mysql_error());
  $rows = array();
  while($r = mysql_fetch_assoc($result)) {
    $rows[] = $r;
  }
  print json_encode($rows);  

?>
