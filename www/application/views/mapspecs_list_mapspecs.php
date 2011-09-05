<h1>List Mapspecs</h1>

<p>
	<a href="mapspecs/edit">Create New MapSpec</a> 
</p>
<table border="1">
   <tr>
   <th>Mapspec No</th> 
   <th>Renderer ID</th>
   <th>Style ID</th>
   <th>Location (lat,lon)</th>
   <th>Size (x,y) (m)</th>
   </tr>
   <?php foreach ($query->result() as $row):?>

   <tr>
   <?php 
   echo "<td>".
   anchor("mapspecs/edit_map/".$row->map_id,$row->map_id)."</td>";
   echo "<td>".$row->map_renderer."</td>";
   echo "<td>".$row->style_id."</td>";
   echo "<td>".$this->bbox_lon_min.",".
		     $this->bbox_lat_min.
		     "</td>";
   echo "<td>".$row->size_x.",".$row->size_y."</td>";

//  echo "<td>".anchor("townguide/deletemap/".$row->job_id,"Delete");
//  echo ", ".anchor("townguide/retry_job/".$row->job_id,"Re-Try")."</td>";
?>
</tr>
<?php endforeach;?>
</table>