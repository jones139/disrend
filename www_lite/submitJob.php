<?php
  $jobData       = $_REQUEST['jobData'] ;

  $jobObj        = json_decode($jobData);

  $title=$jobObj['title'];
  $renderer = $jobObj['renderer'];
  $nowStr = gmDate("Y-m-d H:i:s");
  $lat = 0;
  $lon = 0;

  include("APIconfig.php");
  include("dbconn.php");

  $query  = "insert into queue (status, title, originlat, originlon,"
  	  . "subdate, statusdate, renderer, jobConfig) values "
  	  . "( 0, "."'".$title."'" 
	  . ", ".$lat.", ".$lon.", "
	  . "timestamp '".$nowStr."', timestamp '".$nowStr."',"
	  . $renderer."," 
	  ." '".jobData."') returning jobno;";
       
  $result = mysql_query($query) 
  	  or die('Query failed: ' . mysql_error());
  $line = pg_fetch_array($result);
  $jobNo=$line['jobno'];	

  mkdir ($dataDir."/".$jobNo,0777);
  chmod ($dataDir."/".$jobNo,0777);
   
   print $jobNo;

?>
