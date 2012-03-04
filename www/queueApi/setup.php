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


////////////////////////////////////////////////////////////
// Create and populate the statuses table
////////////////////////////////////////////////////////////
$sql="drop table if exists statuses";
mysql_query($sql,$dbconn)
    or die('Could not connect: ' . mysql_error());


$sql=<<<'EOD'
create table statuses (
       statusNo int not null,
       title varchar(50),
       primary key (statusNo)
       );
EOD;
mysql_query($sql,$dbconn)
    or die('Could not connect: ' . mysql_error());

$sql=<<<'EOD'
insert into statuses values (1,'waiting'),
       	    	     	    (2,'Claimed for Rendering'),
			    (3,'Rendering in Progress'),
			    (4,'Rendering Complete'),
			    (5,'Rendering Failed');
EOD;
mysql_query($sql,$dbconn)
    or die('Could not connect: ' . mysql_error());



////////////////////////////////////////////////////////////
// Create and populate the renderers table
////////////////////////////////////////////////////////////
$sql="drop table if exists renderers";
mysql_query($sql,$dbconn)
    or die('Could not connect: ' . mysql_error());


$sql=<<<'EOD'
create table renderers (
       rendererNo int not null,
       title varchar(50),
       primary key (rendererNo)
       );
EOD;
mysql_query($sql,$dbconn)
    or die('Could not connect: ' . mysql_error());

$sql=<<<'EOD'
insert into renderers values (1,'townguide'),
       	    	     	    (2,'mapbook');
EOD;
mysql_query($sql,$dbconn)
    or die('Could not connect: ' . mysql_error());


?>
