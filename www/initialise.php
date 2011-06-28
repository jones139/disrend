<html>
	<head>
		<title>Initialise disrend Databases</title>
	</head>
	<body>
<?php
		echo '<h1>initialise database<h1>';
		echo '<h2>Connect to database</h2>';
		$link = mysql_connect('localhost', 'www', '1234');
		if(!$link) {
			die('Could not connect: ' . mysql_error());
		}
		echo '<p>Connected successfully</p>';

		echo '<h2>select disrend database</h2>';
		mysql_select_db("townguide_ci", $link) or die('failed to connect to database web127-disrend: ' . mysql_error());

		// Initialise the users table
		echo "<h2>Initialise users table</h2>";
		$sql = "drop table users;";
		mysql_query($sql) or die(mysql_error());
		$sql = "create table if not exists `users` ( 
		`user_id` int(11) not null auto_increment primary key,
		`uname` varchar(32),
		`passwd` varchar(128),
		`email` varchar(128),
		`full_name` varchar(128),
		`role` int(11)
		);";
		echo "<p>" . $sql . "</p>";
		mysql_query($sql) or die(mysql_error());

		// Create administrator user
		echo "<h2>Create default administrator login (admin/1234)</h2>";
		$pwd = md5('1234');
		$sql = "insert into users (uname,passwd,email,full_name,role) " . " values ('admin', '" . $pwd . "', '','Default Administrator User - Change Password!','2')";
		echo "<p>" . $sql . "</p>";
		echo "<h3>PLEASE CHANGE ADMINISTRATOR PASSWORD - Click on 'admin' in top left of screen after logging on</h3>";
		mysql_query($sql) or die(mysql_error());
		echo "<p><a href='http://localhost/townguide_ci/index.php/login'>Login</a></p>";

		// Initialise the session data table
		echo "
		<h2>Initialise ci_sessions table</h2>";
		$sql = "drop table ci_sessions;";
		mysql_query($sql) or die(mysql_error());
		$sql = "CREATE TABLE IF NOT EXISTS  `ci_sessions` (
		session_id varchar(40) DEFAULT '0' NOT NULL,
		ip_address varchar(16) DEFAULT '0' NOT NULL,
		user_agent varchar(50) NOT NULL,
		last_activity int(10) unsigned DEFAULT 0 NOT NULL,
		user_data text DEFAULT '' NOT NULL,
		PRIMARY KEY (session_id)
		);";
		echo "
		<p>
			" . $sql . "
		</p>";
		mysql_query($sql) or die(mysql_error());

		// Create mapspecs table
		echo "<h2>Initialise MapSpecs table</h2>";
		$sql = "drop table if exists MapSpecs;";
		mysql_query($sql) or die(mysql_error());
		$sql = "create table if not exists `MapSpecs` ( 
		`id` int(11) not null auto_increment primary key,
		`title` varchar(128),
		`description` varchar(512),
		`mapRendererId` int(11),
		`styleId` int(11),
		`bboxLonMin` double,
		`bboxLatMin` double,
		`bboxLonMax` double,
		`bboxLatMax` double,
		`mapSpec` text
		);";
		echo "<p>" . $sql . "</p>";
		mysql_query($sql) or die(mysql_error());

		// Initialise the queue table
		echo "<h2>Initialise JobQueue table</h2>";
		$sql = "drop table if exists JobQueue;";
		mysql_query($sql) or die(mysql_error());
		$sql = "create table if not exists `JobQueue` (
		`id` int(11) not null auto_increment primary key,
		`userId` int(11) default 0,
		`mapSpecId` int(11) default 0,
		`rendererId` int(11),
		`status` int(11) default 0,
		`submitTime` datetime,
		`renderStartTime` datetime,
		`statusTime` datetime
		);";
		echo "<p>" . $sql . "</p>";
		mysql_query($sql) or die(mysql_error());

		// Initialise the renderers table
		echo "<h2>Initialise renderers table</h2>";
		$sql = "drop table if exists Renderers;";
		mysql_query($sql) or die(mysql_error());
		$sql = "create table if not exists `Renderers` ( 
		`id` int(11) not null auto_increment primary key,
		`userId` int(11) default 0,
		`description` varchar(512),
		`rendererStatus` int(11) default 0
		);";
		echo "<p>" . $sql . "</p>";
		mysql_query($sql) or die(mysql_error());

		// Initialise the JobStatuses table
		echo "<h2>Initialise JobStatuses table</h2>";
		$sql = "drop table if exists JobStatuses;";
		mysql_query($sql) or die(mysql_error());
				$sql = "create table if not exists `JobStatuses` ( 
		`id` int(11) not null primary key,
		`description` varchar(512)
		);";
		echo "<p>" . $sql . "</p>";
		mysql_query($sql) or die(mysql_error());

		$sql = "insert into JobStatuses (id,description)
		values (0,'Queued'),(1,'Running'),(2,'Complete'),(3,'Failed')";
		echo "<p>" . $sql . "</p>";
		mysql_query($sql) or die(mysql_error());
		
		// Initialise the SymbolSets table
		echo "<h2>Initialise SymbolSets table</h2>";
		$sql = "drop table if exists SymbolSets;";
		mysql_query($sql) or die(mysql_error());
				$sql = "create table if not exists `SymbolSets` ( 
		`id` int(11) not null auto_increment primary key,
		`userId` int(11) default 0,
		`description` varchar(512),
		`symbolSetArch` blob
		);";
		echo "<p>" . $sql . "</p>";
		mysql_query($sql) or die(mysql_error());
				
		// Initialise the Styles table
		echo "<h2>Initialise Styles table</h2>";
		$sql = "drop table if exists Styles;";
		mysql_query($sql) or die(mysql_error());
		$sql = "create table if not exists `Styles` ( 
		`id` int(11) not null auto_increment primary key,
		`userId` int(11) default 0,
		`description` varchar(512),
		`baseSymbolSetId` int(11),
		`symbolSetId` int(11),
		`styleArch` blob
		);";
		echo "<p>" . $sql . "</p>";
		mysql_query($sql) or die(mysql_error());
						
		echo "<h1>Database Intialisation Complete!!!</h1>";
						
		mysql_close($link);
		
		?>
		</body>
</html>