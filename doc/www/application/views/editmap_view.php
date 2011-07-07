<h1>EditMap</h1>
<div id="mapdiv" style="width:600px; height:400px;">Map should be here</div>


<div id="controlSidebar">
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




<script src="<?php echo base_url().'application/media/js/leaflet.js'; ?>" ></script>
<script src="<?php echo base_url().'application/media/js/jquery-1.4.2.min.js'; ?>" ></script>
<script src="<?php echo base_url().'application/media/js/jquery-ui-1.8.6.custom.min.js'; ?>" ></script>
<script src="<?php echo base_url().'application/media/js/editmap.js'; ?>" ></script>

<script>
$.extend({
  getUrlVars: function(){
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for(var i = 0; i < hashes.length; i++)
    {
      hash = hashes[i].split('=');
      vars.push(hash[0]);
      vars[hash[0]] = hash[1];
    }
    return vars;
  },
  getUrlVar: function(name){
    return $.getUrlVars()[name];
  }
});
</script>
