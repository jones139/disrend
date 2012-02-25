<?php include("header.php");?>

<?php
if (isset($_POST['deleteSelected'])) {
   echo "<h3>Deleting</h3>";
   $delList = $_POST['delList'];

   foreach ($delList as $jobNo) {
   	   echo "$jobNo is selected";    
     	   deleteJob($jobNo);
	   }    
}
elseif (isset($_POST['retrySelected'])) {
       echo "<h3>Re-Queueing</h3>";
       $delList = $_POST['delList'];

       foreach ($delList as $jobNo) {
       	       echo "$jobNo is selected";    
     	       retryJob($jobNo);
	       }
}
else {
     echo "<h1>Townguide Queue Administration</h2>\n";
     print "<h3>Select Jobs to Delete </h3>";

     $dbconn = pg_connect("host=localhost dbname=townguide user=www password=1234")
     or die('Could not connect: ' . pg_last_error());

     $query = 'SELECT jobno,status,title FROM queue order by jobno desc';
     $result = pg_query($query) or die('Query failed: ' . pg_last_error());
     $resultCount = pg_num_rows($result);
     echo "<p>There are ".$resultCount." jobs in the queue.</p>";

     echo "<form action='admin.php' method='POST'>";
     echo "<input type='submit' value='Delete Selected Jobs' name='deleteSelected'>";
     echo "<input type='submit' value='Retry Selected Jobs' name='retrySelected'>";
     echo "<table border='1'>\n";
     echo "<tr><th>JobNo</th><th>Status</th><th>Title</th><th>Select</th>";
     $resultCount = 0;	
     while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {
           $resultCount = $resultCount + 1;
	       echo "\t<tr>\n";
	       echo "\t\t<td>",$line['jobno'],"</td>\n";
	   switch($line['status']) {
       	   case 0:
            	echo "<td>Queued</td>";
	    	break;
       	   case 1:
            	echo "<td>Running</td>";
	    	break;
       	   case 2:
            	echo "<td>Complete</td>";
	    	break;
       	   case 3:
            	echo "<td>Failed</td>";
	    	break;
           default:
                echo "<td>Unknown status ",$line['status'],"</td>";
    	   }
    
	echo "\t\t<td><a href='output/",$line['jobno'],"'>",$line['title'],"</a></td>\n";
    	echo "\t\t<td><input type=checkbox name='delList[]' value='",$line['jobno'],"'></td>\n";
    	echo "\t</tr>\n";
    	}
	echo "</table>\n";
    	echo "</form>";
 }



function retryJob($jobNo)
{
	echo "<p>retryJob($jobNo)</p>";

   	$dbconn = pg_connect("host=localhost dbname=townguide user=www password=1234")
     	or die('Could not connect: ' . pg_last_error());

     	$query = 'update queue set status=0 where jobno='.$jobNo;
     	$result = pg_exec($query) or die('Query failed: ' . pg_last_error());

	echo "<p><a href='admin.php'>Return to Admin Page</a></p>\n";
}


function deleteJob($jobNo)
{
	$dir = "/var/www/townguide/www/output/".$jobNo;
	echo "<p>deleteJob($jobNo) - directory $dir</p>";

   	$dbconn = pg_connect("host=localhost dbname=townguide user=www password=1234")
     	or die('Could not connect: ' . pg_last_error());

     	$query = 'delete FROM queue where jobno='.$jobNo;
     	$result = pg_exec($query) or die('Query failed: ' . pg_last_error());
	deleteDirectory($dir);

	echo "<p><a href='admin.php'>Return to Admin Page</a></p>\n";
}

function deleteDirectory($dir)
{
      	if (!file_exists($dir)) return true;
        if (!is_dir($dir)) return unlink($dir);
        foreach (scandir($dir) as $item) {
            if ($item == '.' || $item == '..') continue;
            if (!deleteDirectory($dir.DIRECTORY_SEPARATOR.$item)) return false;
        }
        return rmdir($dir);
}
?>