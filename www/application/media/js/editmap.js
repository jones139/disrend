
var bbox1 = new L.LatLng(0,0);
var bbox2 = new L.LatLng(0,0);

var mapDivID = "mapdiv";

// Set the text showing the height of the map.
var mapDivHeight = jQuery("#"+mapDivID).height();
var heightStr = "height: " + mapDivHeight;
jQuery("#heightDiv").text(heightStr);

jQuery("#increaseHeightButton").click(increaseMapHeight);
jQuery("#decreaseHeightButton").click(decreaseMapHeight);

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

// initialize the map on the "map" div with a given center and zoom 
var map = new L.Map('mapdiv', {
    center: new L.LatLng(51.505, -0.09), 
    zoom: 13
});

var OSMUrl = 'http://tile.openstreetmap.org/{z}/{x}/{y}.png',
    OSMLayer = new L.TileLayer(OSMUrl, {maxZoom: 18});

map.addLayer(OSMLayer);

//map.on('click', onMapClick);
//map.on('mousedown', onMousedown);
//map.on('dragstart', onDragStart);
//map.on('dragend', onDragEnd);
        
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

