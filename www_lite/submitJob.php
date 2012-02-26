<?php
  $jobData       = $_REQUEST['data'] ;
  $jobObj        = json_decode($jobData);

  $title=$jobObj->title;
  $renderer = $jobObj->renderer;
  $nowStr = gmDate("Y-m-d H:i:s");
  $lat = $jobObj->mapCenterLat;
  $lon = $jobObj->mapCenterLon;

  include("APIconfig.php");
  include("dbconn.php");

  $query  = "insert into queue (status, title, originlat, originlon,"
  	  . "subdate, renderer, jobConfig) values "
  	  . "( 0, "."'".$title."'" 
	  . ", ".$lat.", ".$lon.", "
	  . "'".$nowStr."',"
	  . $renderer."," 
	  ." '".$jobData."');";
       
  $result = mysql_query($query) 
  	  or die('Query failed: ' . mysql_error());

  $jobNo=mysql_insert_id();

  mkdir ($dataDir."/".$jobNo,0777);
  chmod ($dataDir."/".$jobNo,0777);
   
   print $jobNo;

?>
