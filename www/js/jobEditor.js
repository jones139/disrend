//    This file is part of printmaps - a program to produce printable 
//     maps of OpenStreetMap Data.
//
//    printmaps is free software: you can redistribute it and/or modify
//    it under the terms of the GNU General Public License as published by
//    the Free Software Foundation, either version 3 of the License, or
//    (at your option) any later version.
//
//    printmaps is distributed in the hope that it will be useful,
//    but WITHOUT ANY WARRANTY; without even the implied warranty of
//    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//    GNU General Public License for more details.
//
//    You should have received a copy of the GNU General Public License
//    along with printmaps.  If not, see <http://www.gnu.org/licenses/>.
//
//    Copyright Graham Jones 2012.
//
////////////////////////////////////////////////////////////////////////
// Define Global Variables
var JE = {};

JE.lat = 54.505;                  // Initial latitude of centre of map.
JE.lon = -2.0;                    // Initial longitude of centre of map.
JE.zoom = 10;                      // Initial zoom level.
JE.jobNo = -1;                    // Job number to use to configure default
//                                    user interface state.
JE.map;                   // the map object

$(document).ready(function(){
          initialise_jobEditor();
});

function updateOutputListsButtonCallback() {
    jQuery.ajax({
	url: "queueApi/getJobList.php",
	context: document.body,
	success: updateOutputListsSuccessCallback
    });
}

function updateOutputListsSuccessCallback(data) {
    var row,status;
    var html, completeHtml, queuedHtml, failedHtml;
    html = "<table border='1'><tr><th>JobNo</th><th>Status</th><th>Title</th></tr>";
    completeHtml = html;
    queuedHtml = html;
    failedHtml = html;
    adminHtml = html;
    for (row in data) {
	status = data[row]['status'];
 	
	switch (status) {
	case '1':
	case '2':
	case '3':
 	    html = "";
	    html = html + "<tr>";
	    html = html + "<td><a href='queueApi/getJobInfo.php?jobNo="
		+data[row]['jobNo']+"&infoType=1'>"
		+data[row]['jobNo']+"</a></td>";
	    html = html + "<td>"+JE.statuses[status]+"</td>";
	    html = html + "<td>"+data[row]['title']+"</td>";
	    html = html + "</tr>";

	    queuedHtml = queuedHtml + html;
	    break;
	case '4':
	    html = "";
	    html = html + "<tr>";
 	    html = html + "<td><a href='queueApi/getJobInfo.php?jobNo="
		+data[row]['jobNo']+"&infoType=1'>"
		+data[row]['jobNo']+"</a></td>";
	    html = html + "<td>"+JE.statuses[status]+"</td>";
	    html = html + "<td>"+data[row]['title']+"</td>";
	    html = html + "<td><a href='queueApi/getJobInfo.php?jobNo="
		+data[row]['jobNo']+"&infoType=3'>"
		+"<img src='queueApi/getJobInfo.php?jobNo="
		+data[row]['jobNo']+"&infoType=4'>"+"</a></td>";
	    html = html + "<td><a href='queueApi/getJobInfo.php?jobNo="
		+data[row]['jobNo']+"&infoType=2'>"
		+"Log File"+"</a></td>";
	    html = html + "</tr>";
	    completeHtml = completeHtml + html;
	    break;
	case '5':
 	    html = "";
	    html = html + "<tr>";
	    html = html + "<td><a href='queueApi/getJobInfo.php?jobNo="
		+data[row]['jobNo']+"&infoType=1'>"
		+data[row]['jobNo']+"</a></td>";
	    html = html + "<td>"+JE.statuses[status]+"</td>";
	    html = html + "<td>"+data[row]['title']+"</td>";
	    html = html + "</tr>";
	    failedHtml = failedHtml + html;
	    break;
	default:
	    alert("oh no - status="+status);
	}
	html = "";
	html = html + "<tr>";
	html = html + "<td><a href='queueApi/getJobInfo.php?jobNo="
	    +data[row]['jobNo']+"&infoType=1'>"
	    +data[row]['jobNo']+"</a></td>";
	html = html + "<td>"+JE.statuses[status]+"</td>";
	html = html + "<td>"+data[row]['title']+"</td>";
 	html = html + "<td><button class='deleteButton' value="+
	    data[row]['jobNo']+">Delete</button>";
	html = html + "<td><button class='retryButton' value="+
	    data[row]['jobNo']+">Retry</button></td>";
	html = html + "</tr>";
	adminHtml = adminHtml + html;
    }
    html = "</table>";
    completeHtml = completeHtml + html;
    queuedHtml = queuedHtml + html;
    failedHtml = failedHtml + html;
    adminHtml = adminHtml + html;

    jQuery("#outputCompleteTable").html(completeHtml);
    jQuery("#outputQueuedTable").html(queuedHtml);
    jQuery("#outputFailedTable").html(failedHtml);
    jQuery("#tabs-3").html(adminHtml);
}

function deleteButtonCallback(e) {
    var jobNo;
    jobNo = $(e.target).val();
    jQuery.get("queueApi/deleteJob.php?jobNo="+jobNo,function() { 
	alert("deleted");
	updateOutputListsButtonCallback();
    });
}


function retryButtonCallback(e) {
    var jobNo;
    jobNo = $(e.target).val();
    jQuery.get("queueApi/retryJob.php?jobNo="+jobNo,function() { 
	alert("re-queueued");
	updateOutputListsButtonCallback();
    });
}


function submitButtonCallback() {
    var dataObj = {};
    var paperObj = {};
    var originObj = {};
    var postData = {};
    dataObj.title = jQuery("#titleInput").val();
    dataObj.renderer = jQuery("#rendererSelect").val();
    paperObj.size = jQuery("#paperSizeSelect").val();
    paperObj.orientation = jQuery("#paperOrientationSelect").val();
    dataObj.paper = paperObj;
    originObj.lon = jQuery("#mapCenterLon").val();
    originObj.lat = jQuery("#mapCenterLat").val();
    dataObj.origin = originObj;
    dataObj.mapSizeW = jQuery("#mapSizeW").val();
    dataObj.mapSizeH = jQuery("#mapSizeH").val();
    dataObj.mapScale = jQuery("#mapScaleSelect").val();
    dataObj.mapStyle = jQuery("#mapStyleSelect").val();
    dataObj.grid = jQuery('#gridCheck').is(':checked');
    dataObj.gridSpacing = jQuery("#gridSpacingSelect").val();
    dataObj.contours = jQuery('#contourCheck').is(':checked');
    dataObj.hillshade = jQuery('#hillshadeCheck').is(':checked');
    dataObj.outputDpi = jQuery('#outputResolutionSelect').val();
    dataObj.projection = jQuery('#mapProjectionSelect').val();

    dataJSON = JSON.stringify(dataObj);

    postData.data = dataJSON;

    //alert("dataJSON="+dataJSON);
    //alert("postData['data'] = "+postData['data']);

    jQuery.post("queueApi/submitJob.php",postData,submitSuccessCallback);

}

function submitSuccessCallback(data, textStatus,jqXHR) {
    var html;
    html = "<p>Job Number = <a href='queueApi/getJobInfo.php?jobNo="+data+"'>"+data+"</p>";
    $("#dialog").dialog('option', 'title', 'Job Submitted Successfully');
    jQuery("#dialog").html(html);
    jQuery("#dialog").css('overflow','auto');
    $( "#dialog" ).dialog( "open" );
    //alert("submitSuccessCallback - textStatus = "+textStatus+ " data="+data);
}

// Put a marker in the centre of the map to help the user align it.
function drawMapCenterMarker() {
    JE.map.removeLayer(JE.mapCenterMarker);
    JE.mapCenterMarker = new L.Circle(JE.map.getCenter(),10);
    JE.map.addLayer(JE.mapCenterMarker);
}

// Called whenever the user drags the map to update the lat,lon text boxes
// in the user interface with the new map centre.
function updateMapCenterTextBoxes() {
    var mapCenter;
    mapCenter = JE.map.getCenter();
    jQuery("#mapCenterLon").val(mapCenter.lng);
    jQuery("#mapCenterLat").val(mapCenter.lat);
    drawMapCenterMarker();
}

// Called whenever the lat,lon text boxes are updated to move the map
// to the new map centre.
function setMapCenter() {
    var lat,lon;
    var mapCenter;
    lon = jQuery("#mapCenterLon").val();
    lat = jQuery("#mapCenterLat").val();
    mapCenter = new L.LatLng(lat,lon);
    JE.map.panTo(mapCenter);
    drawMapCenterMarker();
}

function updatePermalink() {
    var lat,lon,z;
    var pageURL = document.location.href;
    var baseURL = pageURL.split('?')[0];
    var queryPart;

    lon = jQuery("#mapCenterLon").val();
    lat = jQuery("#mapCenterLat").val();
    z = JE.map.getZoom();
    queryPart = "?lat="+lat+"&lon="+lon+"&z="+z;
    jQuery('#permaLink').attr('href',baseURL+queryPart); 

}

function initialiseFromJSON(jobNo) {
	var postData = { 
	    'jobNo':JE.jobNo,
	    'infoType':'1'
	};
	jQuery.post("queueApi/getJobInfo.php",postData,initialiseFromJSONCallback);
}

function initialiseFromJSONCallback(data, textStatus,jqXHR) {
    var dataObj = JSON.parse(data);
    alert("initialiseFromJSONCallback - data = "+data); 

    jQuery("#titleInput").val(dataObj.title);
    jQuery("#rendererSelect").val(dataObj.renderer);
    jQuery("#paperSizeSelect").val(dataObj.paperSize);
    jQuery("#mapCenterLon").val(dataObj.mapCenterLon);
    jQuery("#mapCenterLat").val(dataObj.mapCenterLat);
    jQuery("#mapSizeW").val(dataObj.mapSizeW);
    jQuery("#mapSizeH").val(dataObj.mapSizeH);
    setMapCenter();
}


function initialise_jobEditor() {
    // Set the URL of the source of data for the map (../server)
    // Thanks to http://programmingsolution.net/post/
    //          URL-Parsing-Using-JavaScript-Get-Domain-Name-Port-Number-and-Virtual-Directory-Path.aspx
    // for a pointer to getting this one working.
    var pageURL = document.location.href;
    var URLParts = pageURL.split('/');
    URLParts[URLParts.length - 2] = 'server';
    URLParts[URLParts.length - 1] = '';
    dataURL = URLParts.join('/');

    URLParts = pageURL.split('/');
    URLParts[URLParts.length - 1] = 'images';
    imageURL = URLParts.join('/');

    //Now read any GET variariables from the URL (to use for permalinks etc.)
    //These are used to set up the initial state of the map.
    var urlVars = getUrlVars();
    if ('lat' in urlVars) {
	JE.lat = parseFloat(urlVars['lat']);
    } 
    if ('lon' in urlVars) {
	JE.lon = parseFloat(urlVars['lon']);
    } 
    if ('z' in urlVars) {
	JE.zoom = parseFloat(urlVars['z']);
    } 
    if ('jobNo' in urlVars) {
	JE.jobNo = parseFloat(urlVars['jobNo']);
    } 

    // Initialise the map object
    JE.map = new L.Map('map');
    JE.mapCenterMarker = new L.Circle(new L.LatLng(JE.lat,JE.lon),JE.zoom);
    var osmURL = 'http://tile.openstreetmap.org/{z}/{x}/{y}.png';
    var osmLayer = new L.TileLayer(osmURL,{maxZoom:18});
    JE.map.addLayer(osmLayer);
    JE.map.setView(new L.LatLng(JE.lat,JE.lon), JE.zoom);
        

    // Initialise the array of status descriptions
    jQuery.ajax({
	url:"queueApi/getStatuses.php",
	success:function(data) {
	    JE.statuses = {};
	    for (row in data) {
		JE.statuses[data[row]['statusNo']] = data[row]['title'];
	    }
	}
    }
	       );


    // Set up the callbacks to update the user interface.
    // Set up the Edit Button
    jQuery('#submitButton').click(submitButtonCallback);
    jQuery('.deleteButton').live("click",deleteButtonCallback);
    jQuery('.retryButton').live("click",retryButtonCallback);
    jQuery('#updateOutputListsButton').click(
	updateOutputListsButtonCallback
    );
    // update the jobs list if the 'output' tab is selected.
    jQuery('#tabs').tabs({
	select: updateOutputListsButtonCallback
    });
    jQuery('#mapCenterLon').change(setMapCenter);
    jQuery('#mapCenterLat').change(setMapCenter);
    JE.map.on('dragend',updateMapCenterTextBoxes);
    JE.map.addEventListener('moveend',updatePermalink);
    JE.map.addEventListener('zoomend',updatePermalink);

    updateMapCenterTextBoxes();
    updatePermalink();

    if (JE.jobNo >= 1) {
	initialiseFromJSON(JE.jobNo);
    }
}
