<?php
  $dataDir = dirname(__FILE__)."/output";
  if (!file_exists($dataDir)) {
     mkdir ($dataDir,0777);
     chmod ($dataDir,0777);
  } 
?>