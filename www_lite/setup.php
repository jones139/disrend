<?php 
//////////////////////////////////////////////////////////////
// Setup the databases required by this web interface
//////////////////////////////////////////////////////////////

include("dbconn.php");

$sql = "drop table if exists queue;";
mysql_query($sql,$dbconn)
    or die('Could not connect: ' . mysql_error());


$sql = <<<'EOD'
create table queue (
       	     	   jobNo int, 
		   status int,
                   title varchar(256),
		   originLat float,
		   originLon float,
                   subDate timestamp,
                   statusDate timestamp,
		   renderer int,
                   jobConfig varchar(10000)
);
EOD;

mysql_query($sql,$dbconn)
    or die('Could not connect: ' . mysql_error());



?>
