<html>
<head>

<title>TownGuide Generator</title>

<script type="text/javascript" src="http://www.openlayers.org/api/OpenLayers.js"></script>
<script type="text/javascript" src="http://www.openstreetmap.org/openlayers/OpenStreetMap.js"></script>
<script type="text/javascript" src="osm_map.js"></script>


<script>
function pageinit()
{
    advCheckBox = document.getElementById("advanced");
    advCheckBox.checked = false;
    toggleAdvancedOptions();
    init();
}

function poiClick()
{
     featureCheckBoxes = ["pubs","hotels","restaurants","fastfood",
                          "tourism","leisure","shopping","banking"];
     poiBox = document.getElementById("featureList");

     if (poiBox.checked) {
       disabled=false;
       document.getElementById("poiTable").style.display='block';
     } else {
       disabled=true;
       document.getElementById("poiTable").style.display='none';
     }

     for (i=0;i<featureCheckBoxes.length;i++) {
       document.getElementById(featureCheckBoxes[i]).disabled=disabled

     }
}


function toggleAdvancedOptions() {
   if (document.getElementById("advanced").checked) {
      document.getElementById("advancedOptions").style.display='block';
   }
   else {
      document.getElementById("advancedOptions").style.display='none';

   }
}

</script>


<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-7615786-8");
pageTracker._trackPageview();
} catch(err) {}</script>


<script>
  function increment(id) {
     var val = parseInt(document.getElementById(id).value);
     if (val<=20) {
		  document.getElementById(id).value = val+1;
		  updateMap();
		  }
  }
  function decrement(id) {
     var val = parseInt(document.getElementById(id).value);
     if (val>1) {
                 document.getElementById(id).value = val-1;
                 updateMap();
                }
  }
</script>

</head>

<body onload='pageinit()'>
<?php include("header.php");?>
<h3>Request TownGuide Production</h3>
<p>Adjust the map below so that the bottom left corner is where you want the 
bottom left corner of your townguide map.  Adjust the map size in units of 
1km squares.  Press the "Submit Request" Button in the bottom right hand corner of the page to produce your map.</p>
<FORM action="submitRenderRequest.php" method="POST">
<table border="1">
  <tbody>
    <tr>
      <td>
	<div id="map", style="width:400pt; height:300pt"></div>
      </td>
      <td>
	<table border="1">
	  <caption><b>Specify Map Title and Origin</b><br>
	  The origin can be set by dragging the map on the left.</caption>
	  <tr>
	    <td>  Title:</td>
	    <td colspan="3"> <INPUT type="text" name="title" value="Enter Title for your Town Guide" size="30" maxlength="50"><br/></td>
	  <tr>
	    <td>Origin (lat,lon)</td>
	    <td><INPUT type="text" id="lat" 
		       name="lat" value="54.6779" size="10" 
		       maxlength="10"
		       onChange="updateMap()"></td>
	    <td><INPUT type="text" 
		       id="lon" name="lon" 
		       value="-1.2204" size="10" 
		       maxlength="10"
		       onChange="updateMap()"></td>
	  </tr>
	  <tr>
	    <td>Map size (x,y in 1km units)
	      </td>
	    <td>
	      <table>
		<tr>
		  <td rowspan='2'>
		    <INPUT type="text" 
			   name="nx" id="nx" 
			   value="3" size="2" 
			   maxlength="3"
			   onChange="zoomMap()">
		    </td>
		  <td><img src="plus.png" onClick="increment('nx')"></td>
		  </tr>
		<tr><td><img src="minus.png" onClick="decrement('nx')"></td></tr>
	      </table>
	    </td>
	    <td>
	      <table>
		<tr>
		  <td rowspan='2'>
		    <INPUT type="text" 
			   name="ny" id="ny" 
			   value="3" size="2" 
			   maxlength="3"
			   onChange="zoomMap()">
		    </td>
		  <td><img src="plus.png" onClick="increment('ny')"></td>
		  </tr>
		<tr><td><img src="minus.png" onClick="decrement('ny')"></td></tr>
	      </table>
	    </td>
	  </tr>
	  <tr>
	    <td>Output Format</td>
	    <td><SELECT name="format">
		<!--<option value="html">HTML</option>
		<option value="book">PDF Booklet</option>-->
		<option selected value="poster">PDF Poster</option>
		
	    </SELECT></td>
	    <td><SELECT name="papersize">
		<option selected value="A4">A4</option>
		<option value="A3">A3</option>
		<option value="A2">A2</option>
		<option value="A1">A1</option>
		<option value="A0">A0</option>  
	    </SELECT></td>
	  </tr>
	  <tr>
	    <td>Select Renderer</td>
	    <td>
	      <SELECT name="renderer">
		<option selected value="1">Townguide-1</option>
		<option value="2">Townguide-2</option>
	    </SELECT></td>
	    <td>
	    </td>
	  </tr>

  </tbody>
  </table>
  <table border="1" width="100%">
    <caption><b>Select Types of Information to Include in Output</b></caption>
    <tr>
      <td>Street Index</td>
      <td><INPUT type="checkbox" checked name="streetIndex"></td>
      <td>Points of Interest</td>
      <td><INPUT type="checkbox" checked id="featureList" name="featureList" onClick = "poiClick()"></td>
    </tr>
  </table>
  <table border="1" width="100%" id="poiTable">
    <caption><b>Select Points of Interest to Show on Map</b></caption>
    <tr>
      <td>Pubs</td>
      <td><INPUT type="checkbox" id="pubs" checked name="pubs"></td>
      <td>Hotels / Guest Houses</td>
      <td><INPUT type="checkbox"  id="hotels" name="hotels"></td>
    </tr>
    <tr>
      <td>Restaurants</td>
      <td><INPUT type="checkbox"  id="restaurants" name="restaurants"></td>
      <td>Fast Food</td>
      <td><INPUT type="checkbox"  id="fastfood" name="fastfood"></td>
    </tr>
    <tr>
      <td>Tourist Attractions</td>
      <td><INPUT type="checkbox"  id="tourism" name="tourism"></td>
      <td>Leasure Facilities</td>
      <td><INPUT type="checkbox"  id="leisure" name="leisure"></td>
    </tr>
    <tr>
      <td>Shopping</td>
      <td><INPUT type="checkbox"  id="shopping" name="shopping"></td>
      <td>Banking</td>
      <td><INPUT type="checkbox"  id="banking" name="banking"></td>
    </tr>
    <tr>
      <td>Libraries</td>
      <td><INPUT type="checkbox"  id="libraries" name="libraries"></td>
      <td></td>
      <td></td>
    </tr>
  </table>
  <table><tr>
      <td>Show Advanced Options</td>
      <td><INPUT type="checkbox" checked id="advanced" name="" onClick = "toggleAdvancedOptions()"></td>
  </tr></table>
  <table id="advancedOptions">
    <tr><td>dpi</td><td><input type="text" name="dpi" value="100"></td></tr>
    <tr><td>Marker Size (pt)</td><td><input type="text" name="markersize" value="10"></td></tr>
  </table>
  <table>
    <tr><td colspan="4"><INPUT type="submit" value="Submit Request"></td></tr>
  </table>
</table>
<h3>NOTE:  This can take some time (a few minutes) to run, so be patient!!</h3>
        
</FORM>


</body>
</html>
