<?php
  $jobNo       = $_REQUEST['jobNo'] ;
  $logFile     = $_REQUEST['logFile'];
  $resultFile  = $_REQUEST['resultFile'];
  $thumbnail   = $_REQUEST['thumbnail'];

  #var_dump($_REQUEST);

  include("APIConfig.php");
  include("dbconn.php");

  $outDir = $dataDir."/".$jobNo;
  if (!file_exists($outDir,0777)) {
     mkdir ($outDir,0777);
  } 

  if ($logFile!="") {
    $outFile = $dataDir."/".$jobNo."/logFile.txt";
    $fh = fopen($outFile,'w');
    fwrite($fh,$logFile);
    fclose($fh);
  }
  else {
       print "skipping empty logFile..";
  }

  if ($resultFile!="") {
    $outFile = $dataDir."/".$jobNo."/resultFile.pdf";
    $fh = fopen($outFile,'w');
    fwrite($fh,$resultFile);
    fclose($fh);
  }
  else {
       print "skipping empty resultFile..";
  }

  if ($thumbnail!="") {
    $outFile = $dataDir."/".$jobNo."/thumbnail.png";
    $fh = fopen($outFile,'w');
    fwrite($fh,$thumbnail);
    fclose($fh);
  }
  else {
       print "skipping empty thumbnail..";
  }

  
  $nowStr = gmDate("Y-m-d H:i:s");
  $query  = "update queue set status=4, statusDate='".$nowStr.
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
