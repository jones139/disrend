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
<input type="text" name="gpxFileDesc" value="" size="50" />
<br/>
<div><input type="submit" name="submit" value="Submit" /></div>

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
	Javascript, using jQuery-UI to show a confirm dialog box for the 'Delete' buttons.
-->
<script type="text/javascript">
	$("#dialog-confirm").hide();
	$(".deletebutton").click(confirmDelete);
	$("#gpxFileId").change(updateGpxFileDesc);


	function updateGpxFileDesc() {
		file_id = $("#gpxFileId").val();
		desc = "new Desc - fileId="+file_id;
		alert("new Desc="+desc);
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