<?php
  header('Content-type: application/json');
  include("APIConfig.php");
  include("dbconn.php");

  $query = "select statusNo,title from statuses";
  $result = mysql_query($query) 
  	     	 or die('Query failed: ' . mysql_error());
  $rows = array();
  while($r = mysql_fetch_assoc($result)) {
    $rows[] = $r;
  }
  print json_encode($rows);  

?>
