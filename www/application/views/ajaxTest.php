<h1>AjaxTest</h1>

<?php
if(isset($errmsg)) {
	echo '<h2>' . $errmsg . '</h2>';
}
?>


<div id="dialog-confirm" title="Delete GPX File?">
	<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>
		This is permanent. Are you sure?</p>
</div>

<?php echo form_open_multipart('gpxfiles/upload'); ?>

<label for="gpxFileId">GPX File ID</label>
<input type="text" name="gpxFileId" id="gpxFileId" value="" size="4" />
<button id="searchButton">Search</button>
<br/>
<label for="gpxFileDesc">File Description</label>
<input type="text" name="gpxFileDesc" id="gpxFileDesc" value="" size="50" readonly/>
<br/>
<div><input type="submit" name="submit" value="Submit" /></div>

<select id="gpxSelect">
</select>
<br/>
<textarea rows="10" cols="70" id="dataArea"></textarea>
</form>



<?php 		$this -> load -> helper('url');?>

<!-- 
	Import the jQuery and jQuery-UI libraries to help with the javascript based
	user interface
-->
<link type="text/css" href="<?php echo base_url();?>application/media/css/smoothness/jquery-ui-1.8.2.css" rel="Stylesheet" />	
<script type="text/javascript" 
	src="<?php echo base_url();?>application/media/js/jquery-1.4.2.min.js">
</script>
<script type="text/javascript" 
	src="<?php echo base_url();?>application/media/js/jquery-ui-1.8.6.custom.min.js">
	</script>



<!--
	Javascript to update the GPX File Description based on specified ID number.
-->
<script type="text/javascript">
	$("#dialog-confirm").hide();
	$(".deletebutton").click(confirmDelete);
	$("#gpxFileId").change(updateGpxFileDesc);

	jQuery.ajax({
		  url: "gpxfiles/list_gpxfiles?ajax=TRUE",
		  success: function(data) {	$("#dataArea").val(data); setOptionList(JSON.parse(data));},
		  error: function(data,errTxt) {alert("ajax error -"+errTxt);}
		  });

	function setOptionList(optionList) {
		var select = $('#gpxSelect');
		if(select.prop) {
			var options = select.prop('options');
		}
		else {
			var options = select.attr('options');
		}
		  
		$('option', select).remove();
		//alert(options);
		$.each(optionList, function(val, text) {
	    	//options[optionList.length] = new Option(text, val);
			//$('#gpxSelect').prop('options')[1] = new Option(text,val);
			$('#gpxSelect').append('<option value="'+val+'">'+text+'</option>');

			//alert("val="+val+", text="+text);
		});
		//alert("done");
		//history.go(0);
}


	function updateGpxFileDesc() {
		file_id = $("#gpxFileId").val();
		desc = "new Desc - fileId="+file_id;
		jQuery.ajax({
		  url: "gpxfiles/get_gpxfile_desc/"+file_id,
		  success: function(data) {	$("#gpxFileDesc").val(data);},
		  error: function(data,errTxt) {alert("ajax error -"+errTxt);}
		  });
		//alert("new Desc="+desc);
		$("#gpxFileDesc").val(desc);
	}

	function confirmDelete(e) {
		file_id = $(this).val();
		//alert("alert - " + e.pageX + ' ' + e.pageY + ' val=' . e.target);
		$( "#dialog-confirm" ).dialog({
			resizable: false,
			height:200,
			modal: true,
			buttons: {
				Cancel: function() {
					//alert("Ok - Leaving it alone");
					$( this ).dialog( "close" );
				},
				"Delete?": function() {
					//alert("file_id="+file_id);
					href_url = "delete/"+file_id;
					$( this ).dialog( "close" );
					//alert("Deleting File using url: " + href_url);
					window.location.href=href_url;
				}
			}
		});
	}

</script>