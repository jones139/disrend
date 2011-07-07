
<!-- 
    ***********************************************************
    *  Include the jquery-ui stylesheet to make the tabs work *
    ***********************************************************
-->
<link 
  rel="stylesheet" 
  type="text/css" 
  href="<?php echo base_url().'application/media/css/smoothness/jquery-ui-1.8.2.css'; ?>" />

<!-- 
    **************************************************************
    *  Include the jquery javascript libraries to make tabs work *
    **************************************************************
-->
<script 
   type="text/javascript" 
   src="<?php echo base_url().'application/media/js/jquery-1.4.2.min.js'; ?>"
 ></script>
<script 
   type="text/javascript" 
   src="<?php echo base_url().'application/media/js/jquery-ui-1.8.6.custom.min.js'; ?>"
 ></script>

<!-- 
    ********************************************************
    *  Actually run the bit of javascript to make the tabs *
    *    and define default values for UI elements.        *
    ********************************************************
-->
<script type="text/javascript">
	$(function() {
		$( "#tabs" ).tabs();
	});
map_id = <?php if (isset($map_id)) echo $map_id; else echo -1; ?>;
        
	</script>


<!-- 
    ********************************************************
    *  Now the HTML                                        *
    ********************************************************
-->
<h2>Fill in the form in each tab in turn to create your map.</h2>
<form method="post" action="mapspecs/update_mapspec"
      enctype="multipart/form-data">
  <div id="tabs">
    <ul>
      <li><a href="#tabs-1">1. Map Title &amp; Size</a></li>
      <li><a href="#tabs-2">2. Map Area</a></li>
      <li><a href="#tabs-3">3. Map Style</a></li>
      <li><a href="#tabs-4">4. Points of Interest</a></li>
      <li><a href="#tabs-5">5. Advanced Options</a></li>
      <li><a href="#tabs-6">6. Create Map</a></li>
    </ul>
    
<!-- 
    **************
    *  First Tab *
    **************
-->
    <div id="tabs-1" class="tabcontainer">
	<h2>Enter the Map Title and Description</h2>
        <table>
          <tr>
             <th>Title</th>
             <td>{{ form.title }} </td>
          </tr>
          <tr>
            <th>Description</th>
            <td>{{ form.description }}</td>
          </tr>
        </table>


        <h2>Select the Output type and Page Size</h2>
        <table>
          <tr>
            <th>Output Format</th>
            <td>{{ form.output_format }}</td>
          </tr>
          <tr>
            <th>Paper Size</th>
            <td>{{ form.paper_size }}</td>
          </tr>
        </table>
    </div>
    
<!-- 
    ***************
    *  Second Tab *
    ***************
-->
    <div id="tabs-2" class="tabcontainer">
      <h1>Select the location for your map</h1>
      <h3>NOTE: THE DATABASE ONLY CONTAINS UK DATA, SO YOU WILL 
	GET A BLANK MAP IF YOU REQUEST ANYTHING ELSE!!!</h3>
      <span id="quick_howto">
	Map usage: 
	1) Move around the map 
	2) Use Control-Drag to select the area you want</span>
      <div id="map" 
	   style="height: 320px; 
		  width: 500px;
		  background-color:#d0d0d0"> 
	&nbsp; 
      </div>
      
      <table>
	<tr>
	  <th rowspan="2">Map Origin</th>
	  <th style="padding: 2px;">Lat</th>
	  <th style="padding: 2px;">Lon</th>
	</tr>
	<tr>
	  <td style="padding: 2px;">
	    <input id="navLat" type="text" name="" value="" />
	  </td>
	  <td style="padding: 2px;">
	    <input id="navLon" type="text" name="" value="" />
	  </td>
	</tr>
      </table>

      <table>
	<tr>
	  <th rowspan="3">
	    Map Size area in kilometers<br/>
	    <em>Use the scrollbars when selecting a 
	      smaller area <br />(around 0km ~ 15km)</em>
	  </th>
	</tr>
	<tr>
	  <td>Width:</td><td>{{ form.nx }}</td>
	  <td><div id="width-slider-range-min">  </div></td>
	</tr>
	<tr>
	  <td>Height:</td><td>{{ form.ny }}</td>
	  <td><div id="height-slider-range-min">  </div></td>
	</tr>
      </table>
      <div class="">
	<h5>Bounding Box information</h5>
	
	<!-- These two are the important ones -->
	<table width="0" cellspacing="0" cellpadding="0" border="0">
	  <tr>
	    <td colspan="2"> Selected Area Origin </td>
	  </tr>
	  <tr>
	    <td>     Lat: {{ form.lat }} <!-- id_lat -->        </td>
	    <td>     Lon: {{ form.lon }} <!-- id_lon --><br />  </td>
	  </tr>
	</table>
      </div>
    </div>

<!-- 
    ***************
    *  Third Tab  *
    ***************
-->
    <div id="tabs-3" class="tabcontainer">
	<h1>Which style?</h1>
      <div class="">
	{% check_mapnikstyleshare_installed %}
	{% if mapnikstyleshare_installed %}
	{% include "djtownguide/style_selector.html" %}
	{% else %}
	<div class="">
	  <em>Style Selection Diabled - Using Original OpenStreetMap Style</em>
	</div>
	{% endif %}
      </div>
    </div>
    
<!-- 
    ****************
    *  Fourth Tab  *
    ****************
-->
    <div id="tabs-4" class="tabcontainer">
      <!-- Table with all the amenities that can appear on the map -->
      <!--{% include "djtownguide/amenities_select.html" %}-->
      <h2>Amenities to be added later...</h2>
    </div>

<!-- 
    ***************
    *  Fifth Tab  *
    ***************
-->
    <div id="tabs-5" class="tabcontainer">
      <h2>Advanced Options to be added later</h2>
      <!--{% include "djtownguide/advanced_options_form.html" %}-->
    </div>

<!-- 
    ***************
    *  Sixth Tab  *
    ***************
-->
    <div id="tabs-6" class="tabcontainer">
      <input id="generate_map_button" 
	     type="submit" 
	     value="Generate Map" />
    </div>
    <!--
       <div id="tabs-7">
	 <h2>Not Used</h2>
       </div>
       -->
  </div>
</form>


<!--
<p>
  <a href="http://validator.w3.org/check?uri=referer">
    <img
       src="http://www.w3.org/Icons/valid-xhtml10"
       alt="Valid XHTML 1.0 Strict" height="31" width="88" /></a>
</p>
-->

