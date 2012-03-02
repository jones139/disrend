<?php 
//////////////////////////////////////////////////////////////
// Setup the databases required by this web interface
//////////////////////////////////////////////////////////////

include("dbconn.php");
include("APIConfig.php");



$sql = "drop table if exists queue;";
mysql_query($sql,$dbconn)
    or die('Could not connect: ' . mysql_error());


$sql = <<<'EOD'
create table queue (
       	     	   jobNo int not null auto_increment, 
		   status int,
                   title varchar(256),
		   originLat float,
		   originLon float,
                   statusDate timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                   subDate timestamp,
		   renderer int,
                   jobConfig varchar(10000),
		   primary key (jobNo)
);
EOD;

mysql_query($sql,$dbconn)
    or die('Could not connect: ' . mysql_error());



?>
