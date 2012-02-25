<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html><head>



  <title>Free Town Guide Generator</title>
  <meta name="GENERATOR" content="Quanta Plus">
  <meta name="AUTHOR" content="Graham Jones">
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="KEYWORDS" content="OpenStreetMap, TownGuide">


<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script><script src="index_files/ga.js" type="text/javascript"></script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-7615786-8");
pageTracker._trackPageview();
} catch(err) {}</script>

</head>
<body>
<?php include("header.php");?>
<h1>Free Town Guide Generator</h1>
<h2>Introduction</h2>
<p>The Free Town Guide Generator will generate simple PDF posters which
are guides to a particular area. </p>
<p>The poster contains a map, and a
selectable set of features (a street index, or lists of pubs,
restaurants, shops, banks etc.).  The idea is that it will help you to produce
useable printed maps, with a street index and selectable points of interest
highlighted.</p>
<p>The Data is derived from the <a href="http://www.openstreetmap.org/" name="OpenStreetMap">Open Street Map</a> project, which is a freely available map dataset, that can be edited by anyone.
</p>
<p>Examples of the town guide generator output can be seen by clicking on the following images:</p>
<table align="center">
<tbody><tr>
  <td><a href="example1_hartlepool.pdf">Hartlepool Pub Guide</a></td>
  <td><a href="example2_london.pdf">Central London Tourist Guide</a></td>
</tr>
<tr>
  <td>
    <a href="example1_hartlepool.pdf">
      <img src="example1_hartlepool.png" alt="example1_hartlepool.png">
      </a>
  </td>
  <td>
    <a href="example2_london.pdf">
      <img src="example2_london.png" alt="example2_london.png">
    </a>
  </td>
</tr>
</tbody></table>

<h2>Generate a Town Guide</h2>
<p>There are two ways to generate a town guide using this program.  
You can either download the source code and install it on your computer from 
<a href="http://www.code.google.com/p/townguide">
http://www.code.google.com/p/townguide</a>, 
or you can use the web service on this site to generate one for you which 
you can download.</p>
<h3>Request Generation of a Town Guide</h3>
<p>You can generate a town guide using this web service by clicking on the link
below then selecting the area that you want to produce the map for.  This is done by dragging the map image to put your area within the shaded region (which is the are that will be mapped).   The size of the map to be produced is selectable using the controls on the page.</p>
<p>Note that the service is running on a very slow computer, so when you ask
it to generate a map for you by pressing the "submit" button it will add your
request to a queue of jobs.  You can check the progress of your request in the
job queue using the link below.</p>
<table border='1' bgcolor="#ff0000">
<tr><td><a href="submitForm.php" name="here">Generate a Town Guide</a></td></tr>
</table>
<p>Reliability of this service is not promised at the moment though 
- this is very much work in
progress!</p>
<p>I see that some people are having trouble with this service apparently running successfully, but either producing no output, or a blank map.  I do not know why this is, so if this happens to you, please either email me (grahamjones139 at gmail dot com), or raise an 'issue' at <a href="http://www.code.google.com/p/townguide">
http://www.code.google.com/p/townguide</a> and I will look into it.
</p>

<h3>View Job Queue</h3>
<p>You can view the job request queue usng the link below</p>
<table border='1' bgcolor="#ff0000">
<tr><td> <a href="listQueue.php">View Rendering Job Queue</a>.</p></td></tr>
</table>


<h3>Source Code</h3>
<p>The source code for the townguide generator is at <a href="http://code.google.com/p/townguide">http://code.google.com/p/townguide</a>.
</p>
<h2>Contact</h2>
<p>If you have any comments on the program or its output, please email me
on grahamjones139 at googlemail.com and/or raise an issue on the
project web page at <a href="http://code.google.com/p/townguide/issues">http://code.google.com/p/townguide/issues</a>. </p>

<h2>Alternatives</h2>
<p>
<a href="http://www.maposmatic.org/">www.maposmatic.org</a> provide a similar
service, producing printable maps with street indices (indexes?).
</p
</body></html>
