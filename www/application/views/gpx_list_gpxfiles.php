<h1>List GPX Files</h1>
<table border="1">
   <tr>
   <th>File No</th> 
   <th>Description</th>
   </tr>
   <?php foreach ($query->result() as $row):?>

   <tr>
   <?php 
   echo "<td>".
   anchor("gpxfiles/edit_gpxfile/".$row->id,$row->id)."</td>";
   echo "<td>".$row->description."</td>";
?>
</tr>
<?php endforeach;?>
</table>