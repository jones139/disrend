<h1>List GPX Files</h1>

<?php
if(isset($errmsg)) {
	echo '<h2>' . $errmsg . '</h2>';
}
?>

<p>
	<a href="upload">Upload GPX File</a>
</p>
<table border="1">
	<tr>
		<th>File No</th>
		<th>User</th></th>
		<th>Description</th>
		<th>Delete?</th>
	</tr>
	<?php
		foreach($query->result() as $row) :
			echo "<tr>";
			echo "<td>" . anchor("gpxfiles/edit/" . $row -> id, $row -> id) . "</td>";
			echo "<td>" . $this -> users_model -> get_username_by_id($row -> userId) . "</td>";
			echo "<td>" . $row -> description . "</td>";
			#echo "<td>".anchor("gpxfiles/delete/".$row->id,"Delete")."</td>";
			echo "<td><button class='deleteButton' value='" . $row -> id . "'>Delete</button></td>";
			echo "</tr>";
		endforeach;
	?>
</table>

<div id="dialog-confirm" title="Delete GPX File?">
	<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>
		This is permanent. Are you sure?</p>
</div>


<?php 		$this -> load -> helper('url');?>
<script type="text/javascript" 
	src="<?php echo base_url();?>application/media/js/jquery-1.4.2.min.js">
</script>
<script type="text/javascript" 
	src="<?php echo base_url();?>application/media/js/jquery-ui-1.8.6.custom.min.js">
	</script>
<script type="text/javascript">
	$(".deletebutton").click(showConfirm);

	function showConfirm(e) {
		//alert("alert - " + e.pageX + ' ' + e.pageY + ' val=' . e.target);
		$( "#dialog-confirm" ).dialog({
			resizable: false,
			height:140,
			modal: true,
			buttons: {
				"GPX File?": function() {
					alert("Deleting File " + $(this).val());
					$( this ).dialog( "close" );
				},
				Cancel: function() {
					alert("Ok - Leaving it alone");
					$( this ).dialog( "close" );
				}
			}
		});
	}

	function deleteButtonClicked() {
		alert("deleteButtonClicked");
	}
</script>