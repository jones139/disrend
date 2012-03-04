<?php include("header.php");?>
<?php
print "<h1>TownGuide Queue Status</h1>";
print "<ol>";
print "<li><a href='#Waiting'>Waiting Jobs</a></li>";
print "<li><a href='#Running'>Running Jobs</a></li>";
print "<li><a href='#Failed'>Failed Jobs</a></li>";
print "<li><a href='#Completed'>Completed Jobs</a></li>";
print "<li><a href='/index.html'>Townguide Home Page</a></li>";
print "<li><a href='/submitForm.html'>Submit a Rendering Request Job</a></li>";
print "</ol>";

$dbconn = pg_connect("host=localhost dbname=townguide user=www password=1234")
    or die('Could not connect: ' . pg_last_error());

print "<a name='Waiting'</a>";
print "<h3>Waiting Jobs </h3>";

$query = 'SELECT jobno,status,title FROM queue where status=0 order by jobno desc';
$result = pg_query($query) or die('Query failed: ' . pg_last_error());
$resultCount = pg_num_rows($result);
echo "<p>There are ".$resultCount." waiting jobs in the queue.</p>";

echo "<table border='1'>\n";
$resultCount = 0;
while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {
      $resultCount = $resultCount + 1;
    echo "\t<tr>\n";
    foreach ($line as $col_value) {
        echo "\t\t<td>$col_value</td>\n";
    }
    echo "\t</tr>\n";
}
echo "</table>\n";

print "<a name='Running'</a>";
print "<h3>Running Job</h3>";
$query = 'SELECT jobno,status,title FROM queue where status=1 order by jobno desc';
$result = pg_query($query) or die('Query failed: ' . pg_last_error());
$resultCount = pg_num_rows($result);
echo "<p>There are ".$resultCount." running jobs in the queue.</p>";

echo "<table border='1'>\n";
$resultCount = 0;
while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {
      $resultCount = $resultCount + 1;
    echo "\t<tr>\n";
    foreach ($line as $col_value) {
        echo "\t\t<td>$col_value</td>\n";
    }
    echo "\t</tr>\n";
}
echo "</table>\n";

print "<a name='Failed'</a>";
print "<h3>Failed Jobs</h3>";
$query = 'SELECT jobno,status,title FROM queue where status=3 order by jobno desc';
$result = pg_query($query) or die('Query failed: ' . pg_last_error());
$resultCount = pg_num_rows($result);
echo "<p>There are ".$resultCount." failed jobs in the queue.</p>";

echo "<table border='1'>\n";
$resultCount = 0;
while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {
      $resultCount = $resultCount + 1;
    echo "\t<tr>\n";
    foreach ($line as $col_value) {
        echo "\t\t<td>$col_value</td>\n";
    }
    echo "\t</tr>\n";
}
echo "</table>\n";

#######################################################################
#
#
print "<a name='Completed'</a>";
print "<h3>Completed Jobs</h3>";
$query = 'SELECT jobno, title,subdate,statusdate from queue where status=2 order by jobno desc';
$result = pg_query($query) or die('Query failed: ' . pg_last_error());
$resultCount = pg_num_rows($result);

echo "<p>There are ".$resultCount." completed jobs in the queue.</p>";

echo "<table border='1'>\n";
while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {
    echo "\t<tr>\n";
    #foreach ($line as $col_value) {
    #    echo "\t\t<td>$col_value</td>\n";
    #}
    echo "\t\t<td>".$line['jobno']."</td>";
    echo "\t\t<td>".$line['title']."</td>";
    echo "\t\t<td>".$line['subdate']."</td>";
    echo "\t\t<td><a href='output/".$line['jobno']."'>View Output</a></tr>";
    echo "\t</tr>\n";
}
echo "</table>\n";

#$line = pg_fetch_array($result, null, PGSQL_ASSOC);
#print "<p>".$line[0]."</p>";
#print "<p>Last Completed Job (".$line[0].") took ".$line[1]." to complete</p>";



pg_free_result($result);
pg_close($dbconn);
?>
