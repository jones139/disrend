
var routePtsList = [];
var wayPtsList = [];
var trackPtsList = [];

////////////////////////////////////////////////////////////////////////////
// NAME: parseGPX(gpxStr)
// DESC: Parse the GPX xml string gpxStr and populate the routePtsList,
//       wayPtsList and trackPtsList arrays with the data in the file.
//       Note that if there is more than one route or track segment in the 
//       data it is merged into a single list.
//
// 18sep2011  GJ  ORIGINAL VERSION
//
function parseGPX(gpxStr) {
    $(gpxStr).find("rtept").each( function() {
	    var lat = parseFloat($(this).attr('lat'));
	    var lon = parseFloat($(this).attr('lon'));
	    var name = $(this).find("name").text();
	    var rtept = {name:name, lat:lat, lon:lon};
	    //alert("rtept.lat="+rtept.lat+"  rtept.lon="+rtept.lon);
	    routePtsList.push(rtept);
	});
}

