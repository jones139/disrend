<h1>View GPX File</h1>
<input type="hidden" name="gpxFileIdHidden" value="<?php echo $id; ?>">
<!-- Main Map area
-->
<div id="mapdiv" style="width:600px; height:400px;">
   Map should be here
</div>

<!-- Sidebar -->
<div id="controlSidebar">
	<div>
		gpxFileId <input type="text" id="gpxFileId">
		<button id="selectGPXFileButton">Select GPX File</button>
	</div>
   <div>
   Title:  <input type="text" id="titleText"/>
   </div>
   <div id="heightControls" style="background-color:#a0a0a0;">
       <div id="heightDiv">height</div>
       <button type="button" id="increaseHeightButton">+</button>
       <button type="button" id="decreaseHeightButton">-</button>
   </div>
   <div id="imageControls" style="background-color:#505050;">
      Image Width (mm) <input type="text" id="imgWidth">
   <br/>
   Image Height (mm) <input type="text" id="imgHeight">
   <br/>
   Image Resolution (dpi) <select id="imgResSelect">
       <option value="92">92 dpi (web)</option>
       <option value="300">300 dpi (normal print output)</option>
       <option value="600">600 dpi (high quality print output)</option>
   </select>
   </div>
   <div id="styleControls" style="background-color:#d0d0d0;">
      Style 
      <select id="styleSelect">
           <option value="1">Standard OSM Style</option>
           <option value="2">Kefalonia Map Style</option>
      </select>
      <br/>
      Contours:  <input type="checkbox" id="contoursCheckbox"/>
      <br/>
      Grid:  <input type="checkbox" id="gridCheckbox"/>
   </div>
   <div id="submitControls">
      <button id="submitButton">Create Map</button>
   </div>
</div>

<!-- Dialog Box -->
<div id="selectGPXFileDialog">
	<h1>Select GPX File</h1>
	<select id="gpxSelect">
		<!--Select Options are set dynamically by javascript -->
	</select>
	<br/>
	<label for="nameFilter">
		Filter by User Name:
	</label>
	<input type="checkbox" id="nameFilterCheckbox" value="filterByName"/>
	Select only Your Files
	<input type="checkbox" id="selectMeCheckbox" value="filterByMyFiles" disabled/>
	<input type="text" id="nameFilterText" disabled>
</div>
<br/>
	<textarea rows=50 cols=80 id="gpxTextArea"></textarea>


<script src="<?php echo base_url().'application/media/js/leaflet.js'; ?>" ></script>
<!--<script src="<?php echo base_url().'application/media/js/jquery-1.4.2.min.js'; ?>" ></script>-->
<script src="<?php echo base_url().'application/media/js/jquery.js'; ?>" ></script>
<script src="<?php echo base_url().'application/media/js/jquery-ui-1.8.6.custom.min.js'; ?>" ></script>

<script>
///////////////////////////////////////////////////////////////////////////
// Fill in the gpx file number from the hidden field pased by the server.
id = $('input[name="gpxFileIdHidden"]').val();
$("#gpxFileId").val(id);
loadGPXFile(id);

/////////////////////////////////////////////////////////////////////////////
// Handlers for GPX File Selector Dialog
$("#selectGPXFileButton").click(
	function() {
		$("#selectGPXFileDialog").dialog("open");
	});

$("#nameFilterCheckbox").click(
	function() {
		if ($("#nameFilterCheckbox").attr("checked")==true) {
			jQuery("#selectMeCheckbox").attr("disabled",false);
			jQuery("#nameFilterText").attr("disabled",false);
		} else {
			jQuery("#selectMeCheckbox").attr("disabled",true);
			jQuery("#nameFilterText").attr("disabled",true);
		}		
	});
	
$("#selectMeCheckbox").click(

);

$( "#selectGPXFileDialog" ).dialog({
			autoOpen: false,
			height: 300,
			width: 350,
			modal: true,
			buttons: {
				"OK": function() {
					alert("ok pressed");
						$( this ).dialog( "close" );
				},
				Cancel: function() {
					$( this ).dialog( "close" );
				}
			},
			close: function() {
					$(this).dialog("close");
			}
		});

function loadGPXFile(file_id) {
/**
 * Retrieve GPX file id number 'id' from the server.  The data is passed to
 * 'parseGPX' function to parse it into variables.
 */
		var url = "<?php echo site_url();?>/gpxfiles/get_gpxfile/"+file_id+"?ajax=true";
		jQuery.ajax({
		  url: url,
		  success: function(data) {	
		  		//alert("success! " + data);
		  		jQuery("#gpxTextArea").val(data);
		  		gpxObj = JSON.parse(data);
		  		parseGPX(gpxObj.GPXFile);
		  		},
		  error: function(data,errTxt) {alert("ajax error -"+errTxt);}
		  });
}

function parseGPX(data) {
/**
 * Parse the gpx data passed as string 'data' into javascript variables.
 * The global variable GPXdata is set.   GPXdata has the following format
 * { id: file id,
 *   desc: file description,
 *   tracks: [ trackseg1, trackseg2...],
 *   routepts: [ { desc: point description, latlng: point location}, ...]},
 *   waypts:  [ { desc: point description, latlng: point location}, ...]},
 * }
 */
   var $gpxXmlDoc = jQuery.parseXML(data);
   var $gpx = jQuery($gpxXmlDoc);
   //alert("$gpx="+$($gpx).text());
   var trackSegs = jQuery($gpx).find("trkpt").each( 
		function(index) {
   			alert("index="+index+"  "+$(this).attr('lat')+","+$(this).attr('lon'));
   		});
   //var trkName = trackSegs.find("name").text();
   //alert ("trkName="+trkName);
}

//////////////////////////////////////////////////////////////////////
// Initialise the map and add event handlers
var bbox1 = new L.LatLng(0,0);
var bbox2 = new L.LatLng(0,0);

var mapDivID = "mapdiv";

// initialize the map on the "map" div with a given center and zoom
var map = new L.Map('mapdiv', {
	center: new L.LatLng(51.505, -0.09),
	zoom: 13
});

var OSMUrl = 'http://tile.openstreetmap.org/{z}/{x}/{y}.png',
OSMLayer = new L.TileLayer(OSMUrl, {
	maxZoom: 18
});

map.addLayer(OSMLayer);

//map.on('click', onMapClick);
//map.on('mousedown', onMousedown);
//map.on('dragstart', onDragStart);
//map.on('dragend', onDragEnd);

/////////////////////////////////////////////////////////////////
// Add event handlers for user interface components
// Set the text showing the height of the map.
var mapDivHeight = jQuery("#"+mapDivID).height();
var heightStr = "height: " + mapDivHeight;
jQuery("#heightDiv").text(heightStr);

jQuery("#increaseHeightButton").click(increaseMapHeight);
jQuery("#decreaseHeightButton").click(decreaseMapHeight);
jQuery("#submitButton").click(submitMap);

//////////////////////////////////////////////////////////////////////////
// Event Handler callback functions
function increaseMapHeight() {
	var mapDivHeight = jQuery("#"+mapDivID).height();
	if (mapDivHeight < 800) {
		jQuery("#"+mapDivID).height(mapDivHeight+50);
		var mapDivHeight = jQuery("#"+mapDivID).height();
		var heightStr = "height: " + mapDivHeight;
		jQuery("#heightDiv").text(heightStr);
	}
}

function decreaseMapHeight() {
	var mapDivHeight = jQuery("#"+mapDivID).height();
	if (mapDivHeight > 100) {
		jQuery("#"+mapDivID).height(mapDivHeight-50);
		var mapDivHeight = jQuery("#"+mapDivID).height();
		var heightStr = "height: " + mapDivHeight;
		jQuery("#heightDiv").text(heightStr);
	}
}

function onMapClick(e) {
	alert("You clicked the map at " + e.latlng);
}

function onMousedown(e) {
	alert("Mouse down at " + e.latlng);
}

function onDragStart(e) {
	//alert("Drag Start at " + e.latlng);
}

function onDragEnd(e) {
	//alert("Drag End at " + e.latlng);
}

/////////////////////////////////////////////////////////////////////
// Functions to populate the user interface from a JSON string
// and create a JSON string from the user interface state
//
function submitMap() {
	var mapJSON = map2JSON();
	//alert(mapJSON);
	var data = new Object;
	data.json = mapJSON;
	//data["test"] = "test";
	//alert(data.json);
	jQuery.ajax({
		url: "http://localhost/disrend/index.php/townguide/queueMap",
		type: "POST",
		data: data,
		success: mapSubmitSuccess,
		error: mapSubmitError
	});
}

function mapSubmitSuccess(data, textStatus, jqXHR) {
	alert("mapSubmitSucess() - " + data + " - " + textStatus);
}

function mapSubmitError(jqXHR,textStatus,errorThrown) {
	alert("mapSubmitError() - " + errorThrown);
}

function map2JSON() {
	mapObj = new Object();
	mapObj.title = jQuery("#titleText").val();
	mapObj.bounds = map.getBounds();
	mapObj.imgWidth = jQuery("#imgWidth").val();
	mapObj.imgHeight = jQuery("#imgHeight").val();
	mapObj.imgRes = jQuery("#imgResSelect").val();
	mapObj.styleID = jQuery("#styleSelect").val();
	mapObj.contours = jQuery("#contoursCheckbox").is(":checked");
	mapObj.grid = jQuery("#gridCheckbox").is(":checked");
	var mapJSON = JSON.stringify(mapObj);
	return mapJSON;
}






</script>
