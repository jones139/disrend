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
JE.zoom = 5;                      // Initial zoom level.
JE.jobNo = -1;                    // Job number to use to configure default
//                                    user interface state.
JE.map;                   // the map object

$(document).ready(function(){
          initialise_jobEditor();
});


function submitButtonCallback() {
    var dataObj = {};
    var postData = {};
    dataObj.title = jQuery("#titleInput").val();
    dataObj.renderer = jQuery("#rendererSelect").val();
    dataObj.paperSize = jQuery("#paperSizeSelect").val();
    dataObj.mapCenterLon = jQuery("#mapCenterLon").val();
    dataObj.mapCenterLat = jQuery("#mapCenterLat").val();
    dataObj.mapSizeW = jQuery("#mapSizeW").val();
    dataObj.mapSizeH = jQuery("#mapSizeH").val();

    dataJSON = JSON.stringify(dataObj);

    postData.data = dataJSON;

    alert("dataJSON="+dataJSON);
    alert("postData['data'] = "+postData['data']);

    jQuery.post("submitJob.php",postData,submitSuccessCallback);

}

function submitSuccessCallback(data, textStatus,jqXHR) {
    alert("submitSuccessCallback - textStatus = "+textStatus+ " data="+data);
}

function drawMapCenterMarker() {
    JE.map.removeLayer(JE.mapCenterMarker);
    JE.mapCenterMarker = new L.Circle(JE.map.getCenter(),10);
    JE.map.addLayer(JE.mapCenterMarker);
}

function updateMapCenterTextBoxes() {
    var mapCenter;
    mapCenter = JE.map.getCenter();
    jQuery("#mapCenterLon").val(mapCenter.lng);
    jQuery("#mapCenterLat").val(mapCenter.lat);
    drawMapCenterMarker();
}

function setMapCenter() {
    var lat,lon;
    var mapCenter;
    lon = jQuery("#mapCenterLon").val();
    lat = jQuery("#mapCenterLat").val();
    mapCenter = new L.LatLng(lat,lon);
    JE.map.panTo(mapCenter);
    drawMapCenterMarker();
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
	lat = parseFloat(urlVars['lat']);
    } 
    if ('lon' in urlVars) {
	lon = parseFloat(urlVars['lon']);
    } 
    if ('z' in urlVars) {
	zoom = parseFloat(urlVars['z']);
    } 

    // Initialise the map object
    JE.map = new L.Map('map');
    JE.mapCenterMarker = new L.Circle(new L.LatLng(JE.lat,JE.lon),10);
    JE.map.addLayer(JE.mapCenterMarker);

    var osmURL = 'http://tile.openstreetmap.org/{z}/{x}/{y}.png';
    var osmLayer = new L.TileLayer(osmURL,{maxZoom:18});
    JE.map.addLayer(osmLayer);

    JE.map.setView(new L.LatLng(JE.lat,JE.lon), JE.zoom);
    //JE.map.addEventListener('moveend',updatePermaLink);
    //JE.map.addEventListener('zoomend',updatePermaLink);
    

    // Set up the callbacks to update the user interface.
    // Set up the Edit Button
    jQuery('#submitButton').click(submitButtonCallback);
    jQuery('#mapCenterLon').change(setMapCenter);
    jQuery('#mapCenterLat').change(setMapCenter);

    JE.map.on('dragend',updateMapCenterTextBoxes);

    updateMapCenterTextBoxes();

}
