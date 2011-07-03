<h1>List GPX Files</h1>
<p><a href="upload">Upload GPX File</a></p>
<table border="1">
   <tr>
   <th>File No</th> 
   <th>User</th></th>
   <th>Description</th>
   </tr>
   <?php 
   foreach ($query->result() as $row):
   		echo "<tr>";
   		echo "<td>".
   		anchor("gpxfiles/edit/".$row->id,$row->id)."</td>";
		echo "<td>". $this->users_model -> get_username_by_id($row->userId)."</td>";
   		echo "<td>".$row->description."</td>";
		echo "</tr>";
	endforeach;
	?>
	</table>