<?php
# Needs jobNo and infoType specifying as GET or POST data.
# jobNo is the job Number.
# infoType is 1 - job configuration data (JSON
# 	      2 - Job Log File
#             3 - Job Result (pdf)
#	      4 - Job Result Thumbnail (png)
#

  include("APIconfig.php");
  include("dbconn.php");

  $jobNo      = $_REQUEST['jobNo'] ;
  $infoType   = $_REQUEST['infoType'] ;

  switch($infoType) {
  	case "1":
	     $query = "select jobConfig from queue where jobNo=".$jobNo;
	     $result = mysql_query($query) 
  	     	     or die('Query failed: ' . mysql_error());
	     $row = mysql_fetch_array($result);
	     print $row['jobConfig'];
	     break;
  	case "2":
	     echo "2 - job log file";
	     break;
  	case "3":
	     echo "3 - Job Result (pdf)";
	     break;
  	case "4":
	     echo "4 - thumbnail";
	     break;

  } 

  #mkdir ($dataDir."/".$jobNo,0777);
  #chmod ($dataDir."/".$jobNo,0777);
   

?>
