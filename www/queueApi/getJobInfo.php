<?php
# Needs jobNo and infoType specifying as GET or POST data.
# jobNo is the job Number.
# infoType is 1 - job configuration data (JSON
# 	      2 - Job Log File
#             3 - Job Result (pdf)
#	      4 - Job Result Thumbnail (png)
#

  include("APIConfig.php");
  include("dbconn.php");

  if (array_key_exists("jobNo",$_REQUEST)) {
     $jobNo      = $_REQUEST['jobNo'];
  }
  else {
     print "-1";
     exit(0);
  }

  if (array_key_exists('infoType',$_REQUEST)) {
     $infoType   = $_REQUEST['infoType'] ;
  } else {
     $infoType = "1";
  }
  switch($infoType) {
  	case "1":
	     $query = "select jobConfig from queue where jobNo=".$jobNo;
	     $result = mysql_query($query) 
  	     	     or die('Query failed: ' . mysql_error());
	     $row = mysql_fetch_array($result);
	     print $row['jobConfig'];
	     break;
  	case "2":
	     $fname =$dataDir.'/'.$jobNo.'/logFile.txt';
	     if (file_exists($fname)) {
	       readfile($fname);
	     } else {
	       print "ERROR - FILE ".$fname." DOES NOT EXIST";
	     }
	     break;
  	case "3":
	     $fname =$dataDir.'/'.$jobNo.'/resultFile.pdf';
	     if (file_exists($fname)) {
                header("Cache-Control: public");
                header("Content-Description: File Transfer");
                header("Content-Disposition: attachment; filename=resultFile.pdf");
                header("Content-Type: application/zip");
    		header("Content-Transfer-Encoding: binary");
	        readfile($fname);
	     } else {
	       print "ERROR - FILE ".$fname." DOES NOT EXIST";
	     }
	     break;
  	case "4":
	     $fname =$dataDir.'/'.$jobNo.'/thumbnail.png';
	     if (file_exists($fname)) {
	       header("Content-Type: image/png");
	       readfile($fname);
	     } else {
	       print "ERROR - FILE ".$fname." DOES NOT EXIST";
	     }
	     break;
  } 

  #mkdir ($dataDir."/".$jobNo,0777);
  #chmod ($dataDir."/".$jobNo,0777);
   

?>
