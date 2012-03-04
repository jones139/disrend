<?php
  $jobNo       = $_REQUEST['jobNo'] ;
  $fileData     = $_REQUEST['fileData'];
  $fileType    = $_REQUEST['fileType'];

# fileType is 1 - job configuration data (JSON) - NOT USED
# 	      2 - Job Log File
#             3 - Job Result (pdf)
#	      4 - Job Result Thumbnail (png)

  include("APIConfig.php");
  include("dbconn.php");

  $outDir = $dataDir."/".$jobNo;
  if (!file_exists($outDir,0777)) {
     mkdir ($outDir,0777);
  } 

  switch($fileType) {
  	case "1":
    	     $outFile = $dataDir."/".$jobNo."/config.json";
	     break;
  	case "2":
	     echo "2 - job log file";
    	     $outFile = $dataDir."/".$jobNo."/logFile.txt";
	     break;
  	case "3":
    	     $outFile = $dataDir."/".$jobNo."/resultFile.pdf";
	     echo "3 - Job Result (pdf)";
	     break;
  	case "4":
	     echo "4 - thumbnail";
   	     $outFile = $dataDir."/".$jobNo."/thumbnail.png";
	     break;
  }
  $fh = fopen($outFile,'w');
  fwrite($fh,$fileData);
  fclose($fh);

  print $jobNo
?>
