<html>
<head>
<title>Initialise disrend Databases</title>
</head>
<body>
<?php


echo '<h1>initialise database<h1>';
echo '<h2>Connect to database</h2>';
$link = mysql_connect('localhost', 'web127-disrend', '1234');
if (!$link) {
    die('Could not connect: ' . mysql_error());
}
echo '<p>Connected successfully</p>';

echo '<h2>select disrend database</h2>';
mysql_select_db("web127-disrend",$link) or die('failed to connect to database web127-disrend: '.mysql_error());

// Initialise the queue table
echo "<h2>Initialise queue table</h2>";
$sql = "create table if not exists `queue`"
  . " ( `job_id` int(11) not null auto_increment primary key,"
  . "`user_id` int(11) default 0,"
  . "`map_id` int(11) default 0,"
  . "`renderer_id` int(11),"
  . "`status` int(11) default 0,"
  . "`submit_time` datetime,"
  . "`render_start_time` datetime,"
  . "`render_complete_time` datetime);";
echo "<p>".$sql."</p>";
mysql_query($sql) or die(mysql_error());

// Initialise the users table
echo "<h2>Initialise users table</h2>";
$sql = "create table if not exists `users`"
  . " ( `user_id` int(11) not null auto_increment primary key,"
  . "`uname` varchar(32),"
  . "`passwd` varchar(128),"
  . "`email` varchar(128),"
  . "`full_name` varchar(128),"
  . "`role` int(11)"
  . ")";
echo "<p>".$sql."</p>";
mysql_query($sql) or die(mysql_error());

// Create mapspecs table
echo "<h2>Initialise mapspecs table</h2>";
$sql = "create table if not exists `mapspecs`"
  . " ( `map_id` int(11) not null auto_increment primary key,"
  . "`map_title` varchar(128),"
  . "`map_description` varchar(512),"
  . "`map_renderer` int(11),"
  . "`style_id` int(11),"
  . "`bbox_lon_min` double,"
  . "`bbox_lat_min` double,"
  . "`size_x` double,"
  . "`size_y` double"
  . ")";
echo "<p>".$sql."</p>";
mysql_query($sql) or die(mysql_error());

// Initialise the session data table
echo "<h2>Initialise ci_sessions table</h2>";
$sql = "CREATE TABLE IF NOT EXISTS  `ci_sessions` (
session_id varchar(40) DEFAULT '0' NOT NULL,
ip_address varchar(16) DEFAULT '0' NOT NULL,
user_agent varchar(50) NOT NULL,
last_activity int(10) unsigned DEFAULT 0 NOT NULL,
user_data text DEFAULT '' NOT NULL,
PRIMARY KEY (session_id)
);";
echo "<p>".$sql."</p>";
mysql_query($sql) or die(mysql_error());


// Create administrator user
echo "<h2>Create default administrator login (admin/1234)</h2>";
$pwd=md5('1234');
$sql = "insert into users (uname,passwd,email,full_name,role) "
  . " values ('admin', '".$pwd."', '','Default Administrator User - Change Password!','2')";
echo "<p>".$sql."</p>";
echo "<h3>PLEASE CHANGE ADMINISTRATOR PASSWORD - Click on 'admin' in top left of screen after logging on</h3>";
mysql_query($sql) or die(mysql_error());
echo "<p><a href='http://localhost/townguide_ci/index.php/login'>Login</a></p>";



mysql_close($link);


?>

</body>
</html>